<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;



class TiersIpaki extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'code',
        'label',
        'active',
        'billable',
        'accounting_id',

    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'code',
                'label',
                'active',
                'billable',
                'accounting_id',
            ])
            ->logOnlyDirty()
            ->useLogName('tiers_ipaki');
    }
}
