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

            $table->string('Terminal')->nullable();
            $table->string('Shipowner')->nullable();
            $table->string('ItemNumber')->nullable();
            $table->string('Item_Type')->nullable();
            $table->string('Item_Code')->nullable();
            $table->string('BlNumber')->nullable();
            $table->string('FinalDestinationCountry')->nullable();
            $table->string('Description_')->nullable();
            $table->string('TEU')->nullable();
            $table->string('Volume')->nullable();
            $table->string('Weight_')->nullable();
            $table->string('YardZoneType')->nullable();
            $table->string('Zone')->nullable();
            $table->string('Type_Veh')->nullable();
            $table->string('TypeDeMarchandise')->nullable();
            $table->string('POD')->nullable();
            $table->string('YardZone')->nullable();
            $table->string('consignee')->nullable();
            $table->string('callNumber')->nullable();
            $table->string('Vessel')->nullable();
            $table->string('ETA')->nullable();
            $table->string('vesselarrivaldate')->nullable();
            $table->string('Cycle')->nullable();
            $table->string('Yard Quantity')->nullable();
            $table->string('DAYS SINCE IN')->nullable();
            $table->string('Dwelltime')->nullable();
            $table->string('Bloqué')->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->string('bae')->nullable();
            $table->string('client')->nullable();
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
