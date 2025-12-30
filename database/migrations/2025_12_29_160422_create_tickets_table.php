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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('numero'); // A001
            $table->foreignId('service_id')->constrained();
            $table->enum('priorite', ['normal', 'prioritaire'])->default('normal');
            $table->enum('statut', ['en_attente', 'en_cours', 'termine', 'incomplet', 'absent'])
                ->default('en_attente');

            $table->foreignId('guichet_id')->nullable()->constrained();
            $table->timestamp('appel_at')->nullable();
            $table->timestamp('fin_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
