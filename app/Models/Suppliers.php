<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suppliers extends Model
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

    public function product(): HasMany
    {
        return $this->hasMany(Products::class);
    }

    
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')->orWhere('company_name', 'like', '%' . $search . '%');
        });
    }
}
