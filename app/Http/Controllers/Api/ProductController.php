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
        if ($products) {
            return response()->json([
                'status' => '200',
                'products' => $products
            ], 200);
        } else {
            return response()->json([
                'status' => '500',
                'messages' => 'Something went wrong!'
            ]);
        }
    }

    public function store(Request $request)
    {
        // Function to create a new products
        $validator = Validator::make($request->all(), [
            'productname' => 'required|max:191',
            'productprice' => 'required',
            'category_id' => 'required',
        ]);
        $productImg = $request->input('productimg');
        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $binaryData = base64_decode($productImg);
            $path = 'images/' . uniqid() . '.jpg'; // Example path and file name
            Storage::put($path, $binaryData);

            $products = Product::create([
                'productname' => $request->productname,
                'productprice' => $request->productprice,
                'IsActive' => $request->IsActive,
                'productimg' => $path,
                'category_id' => $request->category_id
            ]);

            if ($products) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Product Created Successfully!'
                ], 200);
            } else {
                return response()->json([
                    'status' => '500',
                    'messages' => 'Something went wrong!'
                ], 500);
            }
        }
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
            $products -> delete();
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
