<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');
            $table->string('nombres', 100);
            $table->string('apellidos', 120)->nullable();
            $table->string('dni', 8)->nullable()->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 120)->nullable();
            $table->string('direccion', 180)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
