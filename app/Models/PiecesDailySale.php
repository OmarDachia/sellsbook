<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiecesDailySale extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'date',
        'cash_amount',
        'transfer_amount',
        'total_sales',
        'shop_daily_sales',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'cash_amount' => 'decimal:2',
        'transfer_amount' => 'decimal:2',
        'total_sales' => 'decimal:2',
        'shop_daily_sales' => 'decimal:2',
        'created_at' => 'datetime',
    ];
}
