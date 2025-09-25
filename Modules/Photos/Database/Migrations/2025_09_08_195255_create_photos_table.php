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
       Schema::create('photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('album_id')->constrained()->onDelete('cascade');
            $table->foreignID('upload_token_id')->nullable()
                ->constrained('upload_tokens')
                ->onDelete('set null'); // si le token est supprimé, on garde la photo mais sans référence
            $table->string('original_path');
            $table->string('file_name')->nullable()->unique();
            $table->string('thumb_path')->nullable();
            $table->unsignedBigInteger('size_bytes');
            $table->string('mime');
            $table->enum('category', ['civil', 'religieux', 'coutumier', 'reception', 'autre', 'invite', 'tout'])->default('tout');
            $table->json('exif_json')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};