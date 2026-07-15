<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('id_empleado');
            $table->string('nombres', 100);
            $table->string('apellidos', 120)->nullable();
            $table->string('dni', 8)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('cargo', 80)->nullable();
            $table->foreignId('id_tienda')->nullable()->constrained('tiendas', 'id_tienda')->cascadeOnUpdate()->nullOnDelete();
            $table->date('fecha_ingreso')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
