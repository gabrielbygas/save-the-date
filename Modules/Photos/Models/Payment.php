<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Photos\Models\Album;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['album_id', 'amount', 'currency', 'provider', 'status', 'provider_ref', 'paid_at'];

    public function album() {
        return $this->belongsTo(Album::class);
    }

    // protected static function newFactory(): PaymentFactory
    // {
    //     // return PaymentFactory::new();
    // }
}