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
    protected $fillable = ['album_id', 'upload_token_id', 'original_path', 'file_name', 'thumb_path', 'size_bytes', 'mime', 'exif_json'];

    public function album() {
        return $this->belongsTo(Album::class);
    }

    /**
     * Photo peut appartenir à un upload_token (visiteur).
     * Nullable => si c'est NULL, ça veut dire que c'est le propriétaire.
     */
    public function uploadToken()
    {
        return $this->belongsTo(UploadToken::class);
    }

    // protected static function newFactory(): PhotoFactory
    // {
    //     // return PhotoFactory::new();
    // }
}