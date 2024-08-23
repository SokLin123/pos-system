<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Order extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'user_id',
        'customer_id',
        'invoice_no',
        'reference',
        'order_date',
        'locatioin',
        'delevery',
        'subtotal',
        'discount',
        'tax',
        'total_payment',
        'note',
    ];

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function customers(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function order_detail(): HasMany
    {
        return $this->hasMany(Order_Detail::class);
    }
}
