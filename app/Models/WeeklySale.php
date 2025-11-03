<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklySale extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'date',
        'item_sold',
        'quantity',
        'size',
        'selling_price',
        'cost_price',
        'profit',
        'profit_by_quantity',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'selling_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'profit' => 'decimal:2',
        'profit_by_quantity' => 'decimal:2',
        'created_at' => 'datetime',
    ];
}
