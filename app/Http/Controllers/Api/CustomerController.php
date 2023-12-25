<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    //
    public function index()
    {
        $customers = Customer::all();
        if ($customers->count() > 0) {
            return response()->json([
                'status' => '200',
                'customers' => $customers
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'customers' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {

        $customers = Customer::find($id);
        if ($customers) {
            return response()->json([
                'status' => '200',
                'customers' => $customers
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
            'customer_name' => 'required|max:191',
            'customer_contact' => 'required',
            'customer_type' => 'required',
            'customer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $customers = Customer::create([
                'customer_name' => $request->customer_name,
                'customer_contact' => $request->customer_contact,
                'customer_type' => $request->customer_type,
                'customer_address' => $request->customer_address
            ]);

            if ($customers) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Customer Created Successfully!'
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
        // Function to update a Customer by ID
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|max:191',
            'customer_contact' => 'required',
            'customer_type' => 'required',
            'customer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $customers = Customer::find($id);
            if ($customers) {
                $customers->update([
                    'customer_name' => $request->customer_name,
                    'customer_contact' => $request->customer_contact,
                    'customer_type' => $request->customer_type,
                    'customer_address' => $request->customer_address
                ]);
                return response()->json([
                    'status' => '200',
                    'messages' => 'Customer update Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => '404',
                    'customers' => 'No Record Fonud!'
                ]);
            }

        }
    }

    public function destroy($id)
    {


        $customers = Customer::find($id);
        if ($customers) {
            $customers -> delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Customer Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'customers' => 'No Record Fonud!'
            ]);
        }

    }
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Perform the search query
        $customers = Customer::where('customer_name', 'like', '%' . $keyword . '%')
                        ->orWhere('customer_address', 'like', '%' . $keyword . '%')
                        ->orWhere('customer_type', 'like', '%' . $keyword . '%')
                        ->orWhere('customer_contact', 'like', '%' . $keyword . '%')
                        // Add more fields as needed
                        ->get();

        if ($customers->count() > 0) {
            return response()->json([
                'status' => '200',
                'customers' => $customers
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'message' => 'No Records Found!'
            ]);
        }
    }
}
