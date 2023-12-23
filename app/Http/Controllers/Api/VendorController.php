<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    //
    public function index()
    {
        $vendors = Vendor::all();
        if ($vendors->count() > 0) {
            return response()->json([
                'status' => '200',
                'vendors' => $vendors
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'vendors' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {

        $vendors = Vendor::find($id);
        if ($vendors) {
            return response()->json([
                'status' => '200',
                'vendors' => $vendors
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
            'vendorname' => 'required|max:191',
            'vendorcontact' => 'required',
            'vendor_type' => 'required',
            'vendor_address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $vendors = Vendor::create([
                'vendorname' => $request->vendorname,
                'vendorcontact' => $request->vendorcontact,
                'vendor_type' => $request->vendor_type,
                'vendor_address' => $request->vendor_address
            ]);

            if ($vendors) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Vendor Created Successfully!'
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
        // Function to update a Vendor by ID
        $validator = Validator::make($request->all(), [
            'vendorname' => $request->vendorname,
            'vendorcontact' => $request->vendorcontact,
            'vendor_type' => $request->vendor_type,
            'vendor_address' => $request->vendor_address
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $vendors = Vendor::find($id);
            if ($vendors) {
                $vendors->update([
                    'vendorname' => $request->vendorname,
                    'vendorcontact' => $request->vendorcontact,
                    'vendor_type' => $request->vendor_type,
                    'vendor_address' => $request->vendor_address
                ]);
                return response()->json([
                    'status' => '200',
                    'messages' => 'Vendor update Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => '404',
                    'vendors' => 'No Record Fonud!'
                ]);
            }

        }
    }

    public function destroy($id)
    {


        $vendors = Vendor::find($id);
        if ($vendors) {
            $vendors -> delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Vendor Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'vendors' => 'No Record Fonud!'
            ]);
        }

    }
}
