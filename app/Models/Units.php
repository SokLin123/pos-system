<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Units extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'name',
        'abbreviation',
        'note'
    ];

    public $sortable = [
        'name',
    ];

    
    public function products(): HasMany
    {
        return $this->hasMany(Products::class);
    }

    

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        });
    }

}
