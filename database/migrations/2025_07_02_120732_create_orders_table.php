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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('pack_id')->constrained()->onDelete('cascade');
            // 🛠️ CORRECTION : déclaration manuelle
            $table->unsignedBigInteger('theme_id')->nullable();
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('set null');
            $table->string('order_id')->unique(); // Assure que chaque commande est unique
            $table->string('wedding_title'); // ex: "Mariage de Marie et Paul"
            $table->date('wedding_date');
            $table->string('wedding_location');
            $table->enum('status', ['pending', 'processing', 'completed', 'canceled'])->default('pending');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};