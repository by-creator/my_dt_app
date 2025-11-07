<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;


class RattachementBl extends Model
{
    use HasFactory, ConvertsDates;

    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'email',
        'bl',
        'compte',
        'statut',
        'time_elapsed'
    ];

    protected $casts = ['time_elapsed' => 'datetime'];

    public function getTimeElapsedFormattedAttribute()
    {
        return $this->time_elapsed
            ? $this->time_elapsed->format('d-m-Y H:i')
            : null;
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
