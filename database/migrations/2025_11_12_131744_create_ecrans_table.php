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
        Schema::create('ecrans', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_reception')->nullable();
            $table->dateTime('date_deploiement')->nullable();
            $table->string("service_tag")->nullable();
            $table->string("etiquetage")->nullable();
            $table->string("service")->nullable();
            $table->string("utilisateur")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecrans');
    }
};
