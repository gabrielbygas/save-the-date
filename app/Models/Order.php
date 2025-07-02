<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'pack_id',
        'theme_id', // Nullable, can be set later
        'wedding_title', // e.g., "Mariage de Marie et Paul"
        'wedding_date',
        'wedding_location',
        'status', // e.g., "pending", "processing", "completed"
    ];
    
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function pack()
    {
        return $this->belongsTo(Pack::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}