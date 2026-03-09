<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('numero_serie')->nullable();
            $table->string('modele')->nullable();
            $table->string('type')->nullable();
            $table->string('utilisateur')->nullable();
            $table->string('service')->nullable();
            $table->string('site')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
