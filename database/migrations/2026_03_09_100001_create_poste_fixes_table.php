<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('poste_fixes', function (Blueprint $table) {
            $table->id();
            $table->string('annuaire')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('type')->nullable();
            $table->string('entite')->nullable();
            $table->string('role')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poste_fixes');
    }
};
