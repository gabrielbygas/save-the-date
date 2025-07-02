<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'mr_first_name',
        'mr_last_name',
        'mrs_first_name',
        'mrs_last_name',
        'email',
        'phone',
    ];
    
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->mr_first_name} {$this->mr_last_name} & {$this->mrs_first_name} {$this->mrs_last_name}";
    }

}