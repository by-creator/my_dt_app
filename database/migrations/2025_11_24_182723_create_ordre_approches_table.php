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
        Schema::create('ordre_approches', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->string('chassis')->nullable();
            $table->string('poids')->nullable();
            $table->string('lane')->nullable();
            $table->string('lane_number')->nullable();
            $table->string('bae')->nullable();
            $table->string('booking')->nullable();
            $table->string('port')->nullable();
            $table->string('vessel')->nullable();
            $table->string('call_number')->nullable();
            $table->dateTime('vessel_arrival_date')->nullable();
            $table->string('shipping_line')->nullable();
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->string('client')->nullable();
            $table->string('chauffeur')->nullable();
            $table->string('permis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordre_approches');
    }
};
