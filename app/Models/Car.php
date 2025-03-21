<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate',
        'make',
        'model',
        'price',
        'mileage',
        'seats',
        'doors',
        'production_year',
        'weight',
        'color',
        'image',
        'sold_at',
        'views',
        'user_id', // <-- Voeg deze toe!

    ];

    protected $casts = [
        'sold_at' => 'datetime',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
{
    return $this->belongsToMany(Tag::class);
}

}
