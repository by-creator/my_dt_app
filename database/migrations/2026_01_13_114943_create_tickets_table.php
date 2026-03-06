<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('service_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('agent_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->unsignedInteger('numero');

            $table->enum('statut', [
                'en_attente',
                'en_cours',
                'termine',
                'absent',
                'incomplet'
            ])->default('en_attente');

            $table->string('ip_address')->nullable();

            $table->timestamp('appel_at')->nullable();
            $table->timestamp('termine_at')->nullable();

            $table->timestamps();

            $table->unique(['service_id', 'numero']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
