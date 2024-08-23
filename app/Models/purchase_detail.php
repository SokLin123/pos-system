<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class purchase_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'qty',
        'unit_id',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'sell_id', 'id');
    }
}
