<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $table = 'sales';
    protected $fillable  = [
        'SId',
        'SDate',
        'user_id',
        'product_id',
        'qty',
        'customer_id',
        'status',
        'discount',
        'particular_client'
    ];
}
