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

            $table->string('statut')->nullable();

            $table->timestamp('date_en_attente_proforma')->nullable();
            $table->timestamp('date_en_attente_facture')->nullable();
            $table->timestamp('date_en_attente_bon')->nullable();


            $table->string('time_elapsed_proforma')->nullable();
            $table->string('time_elapsed_facture')->nullable();
            $table->string('time_elapsed_bon')->nullable();

            $table->boolean('relance_proforma')->default(false);

            $table->boolean('relance_facture')->default(false);

            $table->boolean('relance_bad')->default(false);

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
