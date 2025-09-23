<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Photos\Models\Album;
// use Modules\Photos\Database\Factories\UploadTokensFactory;

class UploadToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['album_id', 'token', 'visitor_name', 'visitor_email', 'visitor_phone', 'used', 'expires_at', 'photo_count'];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }

    // protected static function newFactory(): UploadTokensFactory
    // {
    //     // return UploadTokensFactory::new();
    // }
}