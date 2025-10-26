<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{

    use HasFactory;
    
    protected $fillable = [
        'filename',
        'mime_type',
        'file_data',
    ];


    public function proformas()
    {
        return $this->hasMany(Proforma::class);
    }

    public function bad()
    {
        return $this->belongsTo(Bad::class);
    }
}
