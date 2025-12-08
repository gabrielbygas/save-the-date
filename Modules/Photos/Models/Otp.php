<?php

namespace Modules\Photos\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OTP extends Model
{
    protected $table = 'otps'; // <-- nom exact de ta table
    protected $fillable = ['identifier', 'otp', 'expires_at'];
}