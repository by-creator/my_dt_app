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
        Schema::create('dossier_facturations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('rattachement_bl_id')->nullable()->constrained()->onDelete('set null');
            
            $table->dateTime('date_proforma')->nullable();

            $table->json('proforma')->nullable();
            $table->string('proforma_original_name')->nullable();

            $table->json('facture')->nullable();
            $table->string('facture_original_name')->nullable();

            $table->json('bon')->nullable();
            $table->string('bon_original_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_facturations');
    }
};
