<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Photos\Database\Factories\UploadTokensFactory;

class UploadToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['album_id', 'token', 'visitor_name', 'visitor_email', 'visitor_phone', 'used', 'expires_at'];

    // protected static function newFactory(): UploadTokensFactory
    // {
    //     // return UploadTokensFactory::new();
    // }
}