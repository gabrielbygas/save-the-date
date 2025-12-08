<?php
// database/migrations/xxxx_xx_xx_create_otps_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique(); // Email ou téléphone
            $table->string('otp'); // Code OTP à 8 caractères
            $table->timestamp('expires_at'); // Date d'expiration (ex: 10 minutes)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('otps');
    }
};