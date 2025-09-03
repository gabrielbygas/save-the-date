<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Photos\Models\Album;

class AlbumAccessLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['album_id', 'action', 'ip', 'user_agent'];

    public function album() {
        return $this->belongsTo(Album::class);
    }

    // protected static function newFactory(): AlbumAccessLogFactory
    // {
    //     // return AlbumAccessLogFactory::new();
    // }
}