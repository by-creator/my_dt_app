<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;

class UserAccount extends Model
{
    use ConvertsDates, HasFactory;

    protected $fillable = [
        'department', 'display_name', 'email', 'job_title',
        'created_time', 'employee_end_date',
    ];

    protected $dates = ['created_time', 'employee_end_date'];

}
