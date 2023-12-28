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
        $products = Product::all();
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
            $filename = uniqid() . '.png'; // Assign a unique filename or customize as needed

            // Store the binary image in the 'public' disk under the 'images' directory
            Storage::disk('public')->put('images/' . $filename, $binaryImage);

            // Store other validated data in the database along with the image path
            $product = Product::create([
                'productname' => $validatedData['productname'],
                'productprice' => $request->productprice,
                'IsActive' => $request->IsActive,
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
        // Function to update a product by ID
        $validator = Validator::make($request->all(), [
            'productname' => 'required|max:191',
            'productprice' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $products = Product::find($id);
            if ($products) {
                $products->update([
                    'productname' => $request->productname,
                    'productprice' => $request->productprice,
                    'IsActive' => $request->IsActive,
                    'productimg' => $request->productimg,
                    'category_id' => $request->category_id
                ]);
                return response()->json([
                    'status' => '200',
                    'messages' => 'Product update Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => '404',
                    'products' => 'No Record Fonud!'
                ]);
            }

        }
    }

    public function destroy($id)
    {
        // Function to delete a user by ID

        $products = Product::find($id);
        if ($products) {
            $products->delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Product Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'products' => 'No Record Fonud!'
            ]);
        }

    }
}
