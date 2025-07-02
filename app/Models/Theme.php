<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'name',  // e.g., "Boho Chic", "Rustique"
        'style', // e.g., "Nature", "Rétro"
    ];
    
    /** @use HasFactory<\Database\Factories\ThemeFactory> */
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}