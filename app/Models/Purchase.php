<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'purchases';
    protected $fillable = [
        'PId',
        'PDate',
        'user_id',
        'item_id',
        'qty',
        'vendor_id',
        'Status',
        'supplyer_id'
    ];
}
