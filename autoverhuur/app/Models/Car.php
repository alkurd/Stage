<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        "merk",
        "model",
        "bouwjaar",
        "price_per_day",
        "omschrijving",
        "beschikbaar",
        "primary_image"
    ];
    public function images(){
        return $this->hasMany(CarImage::class);
    }
    public function reservations(){
        return $this->hasMany(Reservation::class);
    }
}
