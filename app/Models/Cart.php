<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'product_id',
        'product_name',
        'barcode',
        'category',
        'product_image',
        'selling_price',
        'qty_store',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }


}
