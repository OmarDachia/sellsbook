<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShopPos extends Model
{
    //
     use HasFactory;

    protected $fillable = [
        'date',
        'item_name',
        'cash_amount',
        'transfer_amount',
        'total_sales',
        'pos_old_balance',
        'pos_new_balance',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'cash_amount' => 'decimal:2',
        'transfer_amount' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'pos_old_balance' => 'decimal:2',
        'pos_new_balance' => 'decimal:2',
        'created_at' => 'datetime',
    ];
}
