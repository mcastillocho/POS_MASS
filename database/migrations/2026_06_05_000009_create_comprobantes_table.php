<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comprobantes', function (Blueprint $table) {
            $table->id('id_comprobante');
            $table->foreignId('id_venta')->unique()->constrained('ventas', 'id_venta')->cascadeOnUpdate()->cascadeOnDelete();
            $table->enum('tipo_comprobante', ['BOLETA', 'FACTURA']);
            $table->string('serie', 10);
            $table->unsignedInteger('correlativo');
            $table->string('documento_cliente', 20)->nullable();
            $table->timestamps();
            $table->unique(['tipo_comprobante', 'serie', 'correlativo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comprobantes');
    }
};
