<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'order_id',
        'file_path',
        'type', // 'photo' or 'video'
    ];
    
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}