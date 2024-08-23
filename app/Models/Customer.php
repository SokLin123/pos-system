<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'company_name',
        'email',
        'phone',
        'address',
        'photo',
        'note',
        'VANTTIN_num',
    ];


    public function sell(): HasMany
    {
        return $this->hasMany(Sell::class);
    }
    public function order(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')->orWhere('company_name', 'like', '%' . $search . '%');
        });
    }
}
