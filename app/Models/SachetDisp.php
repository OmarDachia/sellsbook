<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SachetDisp extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'date',
        'batch',
        'total_no',
        'sold_out',
        'available',
        'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];
}
