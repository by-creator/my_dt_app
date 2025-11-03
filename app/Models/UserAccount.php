<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\ConvertsDates;

class UserAccount extends Model
{
    use ConvertsDates, HasFactory;

    protected $fillable = [
        'department', 'display_name', 'email', 'job_title', 'manager', 'office_phone', 'license_options',
        'site', 'status', 'user_type', 'user_principal_name', 'ageny', 'agency_code', 'local_job_title',
        'local_department', 'user_license_type', 'contractor_company', 'contractor_company_email',
        'created_time', 'employee_end_date', 'last_activity_date','final_deprovisioned_date'
    ];

    protected $dates = ['created_time', 'employee_end_date', 'last_activity_date','final_deprovisioned_date'];

}
