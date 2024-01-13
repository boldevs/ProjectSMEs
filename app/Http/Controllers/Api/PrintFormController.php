<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Http\Request;


class PrintFormController extends Controller
{
    public function show($id)
    {
        try {
            $invoiceData​ = '';
            $invoiceData = Sale::select(
                    'sales.SId',
                    'sales.SDate',
                    'products.productname',
                    'customers.customer_name',
                    'customers.customer_address',
                    'customers.customer_contact',
                    'cutomer_type.stand_for',
                    'users.name',
                    'sales.qty as qty',
                    'sales.discount',
                    'products.productprice as amount'
                )
                ->leftJoin('products', 'sales.product_id', '=', 'products.id')
                ->leftJoin('customers', 'sales.particular_client', '=', 'customers.id')
                ->leftJoin('cutomer_type', 'sales.customer_id', '=', 'cutomer_type.id')
                ->leftJoin('users', 'sales.user_id', '=', 'users.id')
                ->where('sales.SId', '=', $id)
                ->get();

            // Pass data to the Blade view
            $pdf = PDF::loadView('template.invoice', ['invoiceData' => $invoiceData]);

            // Return the PDF as a stream
            return $pdf->stream('invoice.pdf');


        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not fetch data.'], 500);
        }
    }
}
