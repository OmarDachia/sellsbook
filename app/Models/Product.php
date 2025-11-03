<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'name',
        'size',
        'created_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
