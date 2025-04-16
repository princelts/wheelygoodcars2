<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'color',
        'group',
        'used_count',
        'used_sold_count', 
        'used_unsold_count'
    ];

    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }

    public function scopeOrderByConversionRate(Builder $query, string $direction = 'asc'): Builder
    {
        return $query->orderByRaw(
            'CASE WHEN used_count > 0 THEN (used_sold_count * 100.0 / used_count) ELSE 0 END ' . $direction
        );
    }

    public function getConversionRateAttribute(): float
    {
        return $this->used_count > 0 
            ? round(($this->used_sold_count / $this->used_count) * 100, 2)
            : 0;
    }
}