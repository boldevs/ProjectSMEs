<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        if ($products->count() > 0) {
            return response()->json([
                'status' => '200',
                'products' => $products
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'products' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {
        // Function to retrieve a specific product by ID
        $products = Product::find($id);
        if ($products->count() > 0) {
            $productsWithImages = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'productname' => $product->productname,
                    'productprice' => $product->productprice,
                    'category_id' => $product->category_id,
                    'IsActive' => $product->IsActive,
                    'productimg' => asset('storage/' . $product->productimg), // Generating image URL
                ];
            });

            return response()->json([
                'status' => '200',
                'products' => $productsWithImages
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'products' => 'No Record Found!'
            ]);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'productname' => 'required|max:191',
            'productprice' => 'required',
            'category_id' => 'required',
            'productimg' => 'required', // Assuming the image is required and received in binary format
        ]);

        if ($validatedData['productimg']) {
            // Handle binary image data storage
            $binaryImage = base64_decode($validatedData['productimg']); // Decode binary image from base64
            $filename = uniqid() . '.jpg'; // Assign a unique filename or customize as needed

            // Store the binary image in the 'public' disk under the 'images' directory
            Storage::disk('public')->put('images/' . $filename, $binaryImage);

            // Store other validated data in the database along with the image path
            $product = Product::create([
                'productname' => $validatedData['productname'],
                'productprice' => $request->productprice,
                'category_id' => $request->category_id,
                'productimg' => 'images/' . $filename, // Save the path in the database
            ]);

            if ($product) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Product Created Successfully!',
                ], 200);
            } else {
                return response()->json([
                    'status' => '500',
                    'messages' => 'Something went wrong!',
                ], 500);
            }
        }

        return response()->json([
            'status' => '422',
            'errors' => 'No image provided or invalid image format!',
        ], 422);
    }



    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'productname' => 'required|max:191',
            'productprice' => 'required',
            'category_id' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => '404',
                'message' => 'Product not found!'
            ], 404);
        }

        $product->productname = $request->productname;
        $product->productprice = $request->productprice;
        $product->category_id = $request->category_id;

        // Check if productimg exists and update accordingly
        if ($request->has('productimg')) {
            $binaryImage = base64_decode($request->productimg); // Decode binary image from base64
            $filename = uniqid() . '.jpg'; // Assign a unique filename or customize as needed

            // Store the binary image in the 'public' disk under the 'images' directory
            Storage::disk('public')->put('images/' . $filename, $binaryImage);

            $product->productimg = 'images/' . $filename; // Save the path in the database
        }

        // Update IsActive field if it exists in the request
        if ($request->has('IsActive')) {
            $product->IsActive = $request->IsActive;
        }

        $product->save();

        return response()->json([
            'status' => '200',
            'message' => 'Product updated successfully!'
        ], 200);
    }


    public function destroy($id)
    {
        $product = Product::find($id);

        if ($product) {
            $imagePath = $product->productimg; // Get the image path from the product

            // Delete the associated image file if it exists
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            $product->delete();

            return response()->json([
                'status' => '200',
                'messages' => 'Product Deleted Successfully!'
            ], 200);
        } else {
            return response()->json([
                'status' => '404',
                'messages' => 'Product Not Found!'
            ], 404);
        }
    }

    public function search(Request $request)
    {
        $query = Product::query();

        // Check if a search term is provided
        if ($request->has('searchTerm')) {
            $searchTerm = $request->input('searchTerm');

            // Filter products based on the product name or category name
            $query->where(function ($query) use ($searchTerm) {
                $query->where('productname', 'like', '%' . $searchTerm . '%')
                      ->orWhereHas('category', function ($query) use ($searchTerm) {
                          $query->where('name', 'like', '%' . $searchTerm . '%');
                      });
            });
        }
        // You can add more conditions for filtering based on other attributes if needed

        // Get the filtered products
        $filteredProducts = $query->with('category')->get();

        if ($filteredProducts->count() > 0) {
            return response()->json([
                'status' => '200',
                'products' => $filteredProducts
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'products' => 'No matching products found!'
            ]);
        }
    }

}
