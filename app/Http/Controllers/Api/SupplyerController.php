<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplyer;
use Illuminate\Support\Facades\Validator;

class SupplyerController extends Controller
{
    //
    public function index()
    {
        $supplyers = Supplyer::all();
        if ($supplyers->count() > 0) {
            return response()->json([
                'status' => '200',
                'supplyers' => $supplyers
            ]);
        } else {
            return response()->json([
                'status' => '404',
                'supplyers' => 'No Record Fonud!'
            ]);
        }
    }

    public function show($id)
    {

        $supplyers = Supplyer::find($id);
        if ($supplyers) {
            return response()->json([
                'status' => '200',
                'supplyers' => $supplyers
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
            'supplyer_name' => 'required|max:191',
            'supplyer_contact' => 'required',
            'supplyer_type' => 'required',
            'supplyer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $supplyers = Supplyer::create([
                'supplyer_name' => $request->supplyer_name,
                'supplyer_contact' => $request->supplyer_contact,
                'supplyer_type' => $request->supplyer_type,
                'supplyer_address' => $request->supplyer_address
            ]);

            if ($supplyers) {
                return response()->json([
                    'status' => '200',
                    'messages' => 'Supplyer Created Successfully!'
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
        // Function to update a Supplyer by ID
        $validator = Validator::make($request->all(), [
            'supplyer_name' => 'required|max:191',
            'supplyer_contact' => 'required',
            'supplyer_type' => 'required',
            'supplyer_address' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        } else {
            $supplyers = Supplyer::find($id);
            if ($supplyers) {
                $supplyers->update([
                    'supplyer_name' => $request->supplyer_name,
                    'supplyer_contact' => $request->supplyer_contact,
                    'supplyer_type' => $request->supplyer_type,
                    'supplyer_address' => $request->supplyer_address
                ]);
                return response()->json([
                    'status' => '200',
                    'messages' => 'Supplyer update Successfully!'
                ], 200);

            } else {
                return response()->json([
                    'status' => '404',
                    'supplyers' => 'No Record Fonud!'
                ]);
            }

        }
    }

    public function destroy($id)
    {


        $supplyers = Supplyer::find($id);
        if ($supplyers) {
            $supplyers->delete();
            return response()->json([
                'status' => '200',
                'messages' => 'Supplyer Deleted Successfully!'
            ], 200);

        } else {
            return response()->json([
                'status' => '404',
                'supplyers' => 'No Record Fonud!'
            ]);
        }

    }
}
