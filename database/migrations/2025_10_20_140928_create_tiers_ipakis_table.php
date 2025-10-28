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
        Schema::create('tiers_ipakis', function (Blueprint $table) {
            $table->id();
            $table->string("code")->nullable();
            $table->string("label")->nullable();
            $table->string("active")->nullable()->default("TRUE");
            $table->string("billable")->nullable()->default("TRUE");
            $table->string("accounting_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tiers_ipakis');
    }
};
