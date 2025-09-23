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
        Schema::create('upload_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->string('token')->unique();
            $table->string('visitor_name')->nullable();
            $table->string('visitor_email');
            $table->string('visitor_phone')->nullable();
            $table->boolean('used')->default(false);
            $table->dateTime('expires_at')->nullable();
            $table->unsignedInteger('photo_count')->default(0); // max 10 Compteur de photos uploadées
            $table->timestamps();
            $table->unique(['visitor_email', 'album_id', 'used'], 'unique_visitor_per_album');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_tokens');
    }
};