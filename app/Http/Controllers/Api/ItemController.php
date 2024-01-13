<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        if ($items->count() > 0) {
            return response()->json([
                'status' => '200',
                'items' => $items
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'items' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {
        // Function to retrieve a specific Item by ID
        $items = Item::find($id);
        if ($items) {
            return response()->json([
                'status' => '200',
                'items' => $items
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
        // Function to create a new items
        $validator = Validator::make($request->all(), [
            'item_name' => 'required|max:191',
            'item_price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $items = Item::create([
                'item_name' => $request->item_name,
                'item_price' => $request->item_price,
            ]);

            if ($items) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Item Created Successfully!'
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
    $validator = Validator::make($request->all(), [
        'item_name' => 'required',
        'item_price' => 'required|numeric',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'errors' => $validator->messages()
        ], 422);
    } else {
        $item = Item::find($id);
        if ($item) {
            $item->update([
                'item_name' => $request->item_name,
                'item_price' => $request->item_price,
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Item updated successfully!',
                'item' => $item // Optionally, you can return the updated item
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No record found!'
            ], 404);
        }
    }
}


    public function destroy($id)
    {
        // Function to delete a user by ID

        $items = Item::find($id);
        if ($items) {
            $items -> delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Item Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'items' => 'No Record Fonud!'
            ]);
        }

    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $categories = Item::where('item_name', 'like', '%' . $keyword . '%')->get();

        if ($categories->count() > 0) {
            return response()->json([
                'status' => '200',
                'items' => $categories
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'items' => 'No Records Found!'
            ]);
        }
    }
}
