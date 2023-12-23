<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplyer extends Model
{
    use HasFactory;
    protected $table = 'supplyers';
    protected $fillable = [
        'supplyer_name',
        'supplyer_contact',
        'supplyer_type',
        'supplyer_address'
    ];
}
