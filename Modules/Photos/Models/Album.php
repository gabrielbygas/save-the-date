<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Photos\Models\Photo;
use Modules\Photos\Models\Payment;
use Modules\Photos\Models\AlbumAccessLog;  
use App\Models\Client;  

class Album extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'slug',
        'client_id',
        'owner_token',
        'album_title',
        'wedding_date',
        'status',
        'qr_code_path',
        'share_url_token',
        'max_guests',
        'opens_at',
        'storage_until_at',
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function payments()
    {
        return $this->hasOne(Payment::class);
    }

    public function album_access_logs()
    {
        return $this->hasMany(AlbumAccessLog::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getShareUrl() // token
    {
        return route('albums.share', ['token' => $this->share_url_token]);
    }


    // protected static function newFactory(): AlbumFactory
    // {
    //     // return AlbumFactory::new();
    // }
}