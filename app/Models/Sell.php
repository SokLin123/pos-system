<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Sell extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'invoice_no',
        'reference',
        'sell_Date',
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



    public function sell_detail(): HasMany
    {
        return $this->hasMany(Sell_Detail::class);
    }
}
