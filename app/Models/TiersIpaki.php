<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class TiersIpaki extends Model
{
    use HasFactory;
    

    protected $fillable = [
        'code',
        'label',
        'active',
        'billable',
        'accounting_id',

    ];
}
