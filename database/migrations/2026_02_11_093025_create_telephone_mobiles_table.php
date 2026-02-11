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
        Schema::create('telephone_mobiles', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->nullable();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('service')->nullable();
            $table->string('destination')->nullable();
            $table->string('modele_telephone')->nullable();
            $table->string('reference_telephone')->nullable();
            $table->string('montant_ancien_forfait_ttc')->nullable();
            $table->string('numero_sim')->nullable();
            $table->string('formule_premium')->nullable();
            $table->string('montant_forfait_ttc')->nullable();
            $table->string('code_puk')->nullable();
            $table->string('acquisition_date')->nullable();
            $table->string('statut')->nullable();
            $table->string('cause_changement')->nullable();
            $table->string('imsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telephone_mobiles');
    }
};
