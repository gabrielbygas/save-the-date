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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade')->unique();
            $table->string('slug')->unique(); // identifiant public de l’album
            $table->string('owner_token')->unique(); // token privé pour le propriétaire
            $table->string('album_title');
            $table->date('wedding_date');
            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');
            $table->string('qr_code_path')->nullable();
            $table->string('share_url_token')->unique();
            $table->unsignedInteger('max_guests')->default(300);
            $table->timestamp('opens_at')->nullable();
            $table->timestamp('storage_until_at')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};