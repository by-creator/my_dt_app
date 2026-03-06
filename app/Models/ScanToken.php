<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanToken extends Model
{
    protected $fillable = [
        'token',
        'ip_address',
        'used',
        'expires_at',
    ];
}
