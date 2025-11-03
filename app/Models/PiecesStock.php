<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PiecesStock extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'item_name',
        'size',
        'no_of_ctn',
        'qty_by_ctn',
        'cost_price_by_ctn',
        'selling_price_per_piece',
        'price_per_pieces_in_ctn',
        'price_by_pcs',
        'notes'
    ];

    protected $casts = [
        'cost_price_by_ctn' => 'decimal:2',
        'selling_price_per_piece' => 'decimal:2',
        'price_per_pieces_in_ctn' => 'decimal:2',
        'price_by_pcs' => 'decimal:2',
        'created_at' => 'datetime',
    ];
}
