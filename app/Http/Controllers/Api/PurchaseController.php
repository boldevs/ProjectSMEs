<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{

    public function index()
    {
        $purchases = Purchase::all();
        if ($purchases->count() > 0) {
            return response()->json([
                'status' => '200',
                'purchases' => $purchases
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'purchases' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {

        $purchases = Purchase::find($id);
        if ($purchases) {
            return response()->json([
                'status' => '200',
                'purchases' => $purchases
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
            'item_id' => 'required',
            'qty' => 'required',
            'vendor_id' => 'required',
            'Status' => 'required',
            'supplyer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $purchases = Purchase::create([
                'user_id' => $request->user_id,
                'item_id' => $request->item_id,
                'qty' => $request->qty,
                'vendor_id' => $request->vendor_id,
                'Status' => $request->Status,
                'supplyer_id' => $request->supplyer_id
            ]);

            if ($purchases) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Purchase Created Successfully!'
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
        // Function to update a Purchase by ID
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|max:191',
            'item_id' => 'required',
            'qty' => 'required',
            'vendor_id' => 'required',
            'Status' => 'required',
            'supplyer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $purchases = Purchase::find($id);
            if ($purchases) {
                $purchases->update([
                    'user_id' => $request->user_id,
                    'item_id' => $request->item_id,
                    'qty' => $request->qty,
                    'vendor_id' => $request->vendor_id,
                    'Status' => $request->Status,
                    'supplyer_id' => $request->supplyer_id
                ]);
                return response()->json([
                    'status' => '200',
                    'messages' => 'Purchase update Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => '404',
                    'purchases' => 'No Record Fonud!'
                ]);
            }

        }
    }

    public function destroy($id)
    {


        $purchases = Purchase::find($id);
        if ($purchases) {
            $purchases->delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Purchase Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'purchases' => 'No Record Fonud!'
            ]);
        }

    }
}
