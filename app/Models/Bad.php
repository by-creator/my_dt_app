<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bad extends Model
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
}
