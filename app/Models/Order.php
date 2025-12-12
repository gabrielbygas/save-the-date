<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'client_id',
        'pack_id',
        'theme_id',
        'wedding_title',
        'wedding_date',
        'wedding_location',
        'status',
        'confirmation_number',
        'payment_due_at',
    ];

    protected $casts = [
        'wedding_date' => 'date',
        'payment_due_at' => 'datetime',
    ];
    
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