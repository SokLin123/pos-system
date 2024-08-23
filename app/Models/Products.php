<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Products extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'product_name',
        'barcode',
        'product_image',
        'garage_id',
        'buy_date',
        'expire_date',
        'buying_price',
        'selling_price',
        'category_id',
        'supplier_id',
        'unit_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id', 'id');
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class, 'garage_id', 'id');
    }

    public function units(): BelongsTo
    {
        return $this->belongsTo(Units::class, 'unit_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('product_name', 'like', '%'.$search.'%');
        });
    }

    public function purchase()
    {
        return $this->hasMany(purchase_detail::class);
    }
}
