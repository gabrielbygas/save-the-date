<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    protected $fillable = [
        'name', // Pack name (e.g., "Pack Mariage Élégant")
        'price', // Price of the pack
    ];
    /** @use HasFactory<\Database\Factories\PackFactory> */
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, ',', ' ') . ' $';
    }

}