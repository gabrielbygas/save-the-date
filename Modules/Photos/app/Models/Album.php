<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Photos\Database\Factories\AlbumFactory;

class Album extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'slug', 'couple_names', 'wedding_date', 'status',
        'qr_code_path', 'share_url_token', 'max_guests',
        'opens_at', 'storage_until_at', 'owner_id'
    ];

     public function photos() {
        return $this->hasMany(Photo::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    public function album_access_logs() {
        return $this->hasMany(AlbumAccessLog::class);
    }

    // protected static function newFactory(): AlbumFactory
    // {
    //     // return AlbumFactory::new();
    // }
}