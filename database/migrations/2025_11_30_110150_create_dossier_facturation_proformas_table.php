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
        Schema::create('dossier_facturation_proformas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dossier_facturation_id')->nullable()->constrained()->onDelete('set null');
            $table->json('proforma')->nullable();
            $table->string('user')->nullable();
            $table->string('bl')->nullable();
            $table->string('statut')->nullable();
            $table->string('time_elapsed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_facturation_proformas');
    }
};
