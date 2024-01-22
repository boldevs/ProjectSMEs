<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PrintFormController extends Controller
{
    public function show($id)
    {
        try {
            $saleId = $id;

            $salesData = Sale::select(
                'sales.SId',
                'sales.SDate',
                'products.productname',
                'products.productprice',
                'cutomer_type.stand_for',
                'customers.customer_address',
                'users.NAME',
                'sales.qty',
                DB::raw('SUM(sales.qty * products.productprice) AS total_amount'),
                'sales.discount',
                'customers.customer_name'
            )
                ->leftJoin('products', 'sales.product_id', '=', 'products.id')
                ->leftJoin('cutomer_type', 'sales.customer_id', '=', 'cutomer_type.id')
                ->leftJoin('customers', 'sales.particular_client', '=', 'customers.id')
                ->leftJoin('users', 'sales.user_id', '=', 'users.id')
                ->where('sales.SId', $saleId)
                ->groupBy(
                    'sales.SId',
                    'sales.SDate',
                    'products.productname',
                    'products.productprice',
                    'cutomer_type.stand_for',
                    'users.NAME',
                    'sales.discount',
                    'customers.customer_name',
                    'customers.customer_address',
                    'sales.qty'
                )
                ->get();

            return response()->json([
                'status' => '200',
                'salesData' => $salesData,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch data.'], 500);
        }
    }
}
