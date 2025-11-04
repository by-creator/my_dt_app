<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;
use Carbon\Carbon;

class UserAccount extends Model
{
    use ConvertsDates, HasFactory;

    protected $fillable = [
        'department',
        'display_name',
        'email',
        'job_title',
        'created_time',
        'employee_end_date',
    ];

    protected $casts = ['created_time' => 'datetime', 'employee_end_date' => 'datetime'];

    public function getCreatedTimeFormattedAttribute()
    {
        return $this->created_time
            ? $this->created_time->format('d-m-Y H:i')
            : null;
    }

    public function getEmployeeEndDateFormattedAttribute()
    {
        return $this->employee_end_date
            ? $this->employee_end_date->format('d-m-Y H:i')
            : null;
    }
}
