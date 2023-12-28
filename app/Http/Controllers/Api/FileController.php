<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class FileController extends Controller
{
    //
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        // Assuming 'productimg' is the attribute that stores the image path in your database
        $imagePath = $product->productimg;

        // Construct the URL to access the image through your Laravel app
        $imageUrl = url('/storage/' . $imagePath);

        return response()->json(['image_url' => $imageUrl]);
    }
}
