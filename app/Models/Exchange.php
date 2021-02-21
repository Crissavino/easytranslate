<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'source_currency',
        'target_currency',
        'exchangeRate',
        'convertedAmount'
    ];
}
