<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'user_id',
        'invoice_no',
        'reference',
        'purchase_date',
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

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id', 'id');
    }

    public function sell_detail(): HasMany
    {
        return $this->hasMany(Sell_Detail::class);
    }
}
