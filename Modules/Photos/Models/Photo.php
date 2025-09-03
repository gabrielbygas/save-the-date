<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Photos\Models\Album;

class Photo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['album_id', 'original_path', 'thumb_path', 'size_bytes', 'mime', 'exif_json', 'uploaded_ip'];

    public function album() {
        return $this->belongsTo(Album::class);
    }

    // protected static function newFactory(): PhotoFactory
    // {
    //     // return PhotoFactory::new();
    // }
}