<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{

    use HasFactory;

    protected $fillable = [
        'bl',
        'account',
        'document',
        'filename',
        'mime_type',
        'file_data',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facture()
    {
        return $this->belongsTo(Facture::class);
    }
}
