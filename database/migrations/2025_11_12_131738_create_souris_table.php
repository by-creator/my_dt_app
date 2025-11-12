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
        Schema::create('souris', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_reception')->nullable();
            $table->dateTime('date_deploiement')->nullable();
            $table->string('marque')->nullable();
            $table->string('utilisateur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('souris');
    }
};
