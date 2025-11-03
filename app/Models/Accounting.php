<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Accounting extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'as_of_date',
        'capital',
        'goods',
        'pos',
        'account',
        'expense',
        'salary',
        'notes'
    ];

    protected $casts = [
        'as_of_date' => 'date',
        'capital' => 'decimal:2',
        'goods' => 'decimal:2',
        'pos' => 'decimal:2',
        'account' => 'decimal:2',
        'expense' => 'decimal:2',
        'salary' => 'decimal:2',
        'created_at' => 'datetime',
    ];
}
