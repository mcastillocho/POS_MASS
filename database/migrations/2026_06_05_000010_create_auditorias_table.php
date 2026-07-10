<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id('id_auditoria');
            $table->foreignId('id_usuario')->nullable()->constrained('usuarios', 'id_usuario')->cascadeOnUpdate()->nullOnDelete();
            $table->string('modulo_afectado', 80);
            $table->string('accion', 80);
            $table->text('descripcion_detalle')->nullable();
            $table->ipAddress('ip_origen')->nullable();
            $table->dateTime('fecha_hora');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
