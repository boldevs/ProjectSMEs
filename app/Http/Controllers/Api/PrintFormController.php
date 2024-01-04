<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Support\Facades\DB;


class PrintFormController extends Controller
{
    public function index()
    {
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
        ->where('sales.SId', 'c69921bb-dfd3-4a7a-bb29-23d80083aaed')
        ->get();

       // Pass data to the Blade view
       $pdf = PDF::loadView('template.invoice', ['invoiceData' => $invoiceData]);

       // Return the PDF as a stream
        return $pdf->stream('invoice.pdf');

    }
}
