<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::all();
        if ($sales->count() > 0) {
            return response()->json([
                'status' => '200',
                'sales' => $sales
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'sales' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {

        $sales = Sale::find($id);
        if ($sales) {
            return response()->json([
                'status' => '200',
                'sales' => $sales
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

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:191',
            'product_id' => 'required',
            'qty' => 'required',
            'customer_id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $sales = Sale::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);

            if ($sales) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Sale Created Successfully!'
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
        // Function to update a Sale by ID
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:191',
            'product_id' => 'required',
            'qty' => 'required',
            'customer_id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $sales = Sale::find($id);
            if ($sales) {
                $sales->update([
                    'user_id' => $request->user_id,
                    'product_id' => $request->product_id,
                    'qty' => $request->qty,
                    'customer_id' => $request->customer_id,
                    'status' => $request->status,
                ]);
                return response()->json([
                    'status' => '200',
                    'messages' => 'Sale update Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => '404',
                    'sales' => 'No Record Fonud!'
                ]);
            }

        }
    }

    public function destroy($id)
    {


        $sales = Sale::find($id);
        if ($sales) {
            $sales->delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Sale Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'sales' => 'No Record Fonud!'
            ]);
        }

    }
}
