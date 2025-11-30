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

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');


            $table->foreignId('rattachement_bl_id')->nullable()->constrained()->onDelete('set null');

            $table->date('date_proforma')->nullable();

            $table->json('proforma')->nullable();
            $table->json('facture')->nullable();
            $table->json('bon')->nullable();

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
        Schema::dropIfExists('dossier_facturations');
    }
};
