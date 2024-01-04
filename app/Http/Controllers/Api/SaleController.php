<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    public function index()
    {
        $sales = Sale::select(
            'sales.SId',
            'sales.SDate',
            'cutomer_type.stand_for',
            'users.NAME',
            Sale::raw('SUM(sales.qty) AS total_quantity'),
            Sale::raw('SUM(sales.qty * products.productprice) AS total_amount'),
            'sales.discount',
            'customers.customer_name'
        )
            ->leftJoin('products', 'sales.product_id', '=', 'products.id')
            ->leftJoin('cutomer_type', 'sales.customer_id', '=', 'cutomer_type.id')
            ->leftJoin('customers', 'sales.particular_client', '=', 'customers.id')
            ->leftJoin('users', 'sales.user_id', '=', 'users.id')
            ->groupBy('sales.SId', 'sales.SDate', 'cutomer_type.stand_for', 'users.NAME', 'sales.discount', 'customers.customer_name')
            ->get();

            return response()->json([
                'status' => '400',
                'sales' => $sales
            ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer',
            'qty' => 'required|integer',
            // Add other validation rules as needed
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => '422',
                'errors' => $validator->messages()
            ]);
        }
        // Set default values for user_id, customer_id, and status
        $defaultUserId = 1;
        $defaultCustomerId = 1;
        $defaultStatus = 1;

        // Create the sale record, using defaults if not provided in the request
        $sales = Sale::create([
            'SId' => $request->SId,
            'SDate' => $request->SDate,
            'user_id' => $request->user_id ?? $defaultUserId,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'customer_id' => $request->customer_id ?? $defaultCustomerId,
            'status' => $request->status ?? $defaultStatus,
            'discount' => $request->discount,
            'particular_client' => $request->particular_client
        ]);

        if ($sales) {
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

    public function show($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        return response()->json($sale);
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        $validatedData = $request->validate([
            'SId' => 'required|string',
            'SDate' => 'required|date',
            'user_id' => 'integer', // Remove 'required' for fields to be nullable
            'product_id' => 'required|integer',
            'qty' => 'required|integer',
            'customer_id' => 'integer', // Remove 'required' for fields to be nullable
            'status' => 'integer', // Remove 'required' for fields to be nullable
        ]);

        // Set default values for user_id, customer_id, and status if not provided
        $validatedData['user_id'] = $validatedData['user_id'] ?? 1;
        $validatedData['customer_id'] = $validatedData['customer_id'] ?? 1;
        $validatedData['status'] = $validatedData['status'] ?? 1;

        $sale->update($validatedData);

        return response()->json($sale, 200);
    }


    public function destroy($id)
    {
        $sale = Sale::find($id);

        if (!$sale) {
            return response()->json(['message' => 'Sale not found'], 404);
        }

        $sale->delete();

        return response()->json(['message' => 'Sale deleted'], 200);
    }

    public function search(Request $request)
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        // Call the stored procedure
        $results = DB::select('CALL SelectSaleList(?, ?)', [$fromDate, $toDate]);

        // Return the results or process them further
        return response()->json($results);
    }
    public function findBySId(Request $request, $sid)
    {
        try {
            $invoiceData = Sale::select(
                    'sales.SId',
                    'sales.SDate',
                    'products.productname',
                    'customers.customer_name',
                    'cutomer_type.stand_for',
                    'users.name',
                    'sales.qty as qty',
                    'products.productprice as amount'
                )
                ->leftJoin('products', 'sales.product_id', '=', 'products.id')
                ->leftJoin('customers', 'sales.particular_client', '=', 'customers.id')
                ->leftJoin('cutomer_type', 'sales.customer_id', '=', 'cutomer_type.id')
                ->leftJoin('users', 'sales.user_id', '=', 'users.id')
                ->where('sales.SId', $sid)
                ->get();

            return response()->json($invoiceData);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch data.'], 500);
        }
    }
}
