<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombres', 100);
            $table->string('apellidos', 120);
            $table->string('username', 80)->unique();
            $table->string('password_hash');
            $table->string('estado', 20)->default('activo');
            $table->foreignId('id_rol')->constrained('roles', 'id_rol')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('id_tienda')->constrained('tiendas', 'id_tienda')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
