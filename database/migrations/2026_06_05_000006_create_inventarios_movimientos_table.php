<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inventarios_movimientos', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->cascadeOnUpdate()->restrictOnDelete();
            $table->enum('tipo_movimiento', ['ENTRADA', 'SALIDA']);
            $table->integer('cantidad');
            $table->string('motivo', 180)->nullable();
            $table->dateTime('fecha_movimiento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventarios_movimientos');
    }
};
