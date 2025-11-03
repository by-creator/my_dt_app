<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_accounts', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_time')->nullable();
            $table->string('department')->nullable();
            $table->string('display_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->dateTime('employee_end_date')->nullable();
            $table->string('job_title')->nullable();
            $table->string('manager')->nullable();
            $table->string('office_phone')->nullable();
            $table->string('license_options')->nullable();
            $table->string('site')->nullable()->default('Dakar Terminal S.A. - DAKAR');
            $table->string('status')->nullable();
            $table->string('user_type')->nullable();
            $table->string('user_principal_name')->nullable();
            $table->string('agency')->nullable()->default('Dakar Terminal S.A.');
            $table->string('agency_code')->nullable()->default('SN004');
            $table->dateTime('last_activity_date')->nullable();
            $table->string('local_job_title')->nullable();
            $table->string('local_department')->nullable();
            $table->string('user_license_type')->nullable();
            $table->dateTime('final_deprovisioned_date')->nullable();
            $table->string('contractor_company')->nullable();
            $table->string('contractor_company_email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_accounts');
    }
};
