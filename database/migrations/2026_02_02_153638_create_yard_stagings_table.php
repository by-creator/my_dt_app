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
        Schema::create('yard_stagings', function (Blueprint $table) {
            $table->id();

            $table->string('terminal')->nullable();
            $table->string('shipowner')->nullable();
            $table->string('item_number')->nullable();
            $table->string('item_type')->nullable();
            $table->string('item_code')->nullable();
            $table->string('bl_number')->nullable();
            $table->string('final_destination_country')->nullable();
            $table->text('description')->nullable();
            $table->string('teu')->nullable();
            $table->string('volume')->nullable();
            $table->string('weight')->nullable();
            $table->string('yard_zone_type')->nullable();
            $table->string('zone')->nullable();
            $table->string('type_veh')->nullable();
            $table->string('type_de_marchandise')->nullable();
            $table->string('pod')->nullable();
            $table->string('yard_zone')->nullable();
            $table->string('consignee')->nullable();
            $table->string('call_number')->nullable();
            $table->string('vessel')->nullable();
            $table->string('eta')->nullable();
            $table->string('vessel_arrival_date')->nullable();
            $table->string('cycle')->nullable();
            $table->string('yard_quantity')->nullable();
            $table->string('days_since_in')->nullable();
            $table->string('dwelltime')->nullable();
            $table->string('bloque')->nullable();
            $table->string('bae')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('chauffeur')->nullable();
            $table->string('permis')->nullable();
            $table->string('pointeur')->nullable();
            $table->string('responsable')->nullable();
            $table->string('reserve')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yard_stagings');
    }
};
