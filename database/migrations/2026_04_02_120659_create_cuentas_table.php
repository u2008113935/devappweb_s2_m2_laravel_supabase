<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('tipo');
            $table->string('numero_cuenta', 20);
            $table->decimal('saldo', 12, 2)->default(0);
            $table->string('moneda', 3)->default('PEN');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuentas');
    }
};

