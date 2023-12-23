<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        if ($categories->count() > 0) {
            return response()->json([
                'status' => '200',
                'Category' => $categories
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'Category' => 'No Record Fonud!'
            ]);
        }

    }

    public function store(Request $request)
    {
        $category = Category::create($request->all());
        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json(null, 204);
    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $categories = Category::where('name', 'like', '%' . $keyword . '%')->get();

        if ($categories->count() > 0) {
            return response()->json([
                'status' => '200',
                'categories' => $categories
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'No Records Found!'
            ]);
        }
    }


}
