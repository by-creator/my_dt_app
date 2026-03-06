<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scan_tokens', function (Blueprint $table) {
            $table->id();
            $table->uuid('token')->unique();
            $table->string('ip_address');
            $table->boolean('used')->default(false);
            $table->datetime('expires_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scan_tokens');
    }
};
