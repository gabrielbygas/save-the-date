<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Photos\Database\Factories\AlbumAccessLogFactory;

class AlbumAccessLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): AlbumAccessLogFactory
    // {
    //     // return AlbumAccessLogFactory::new();
    // }
}
