<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sell_Detail extends Model
{
    use HasFactory;


    protected $fillable = [
        'sell_id',
        'product_id',
        'qty',
        'unit_id',
        'price',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Sell::class, 'sell_id', 'id');
    }
}
