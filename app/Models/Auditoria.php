<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Auditoria extends Model
{
    protected $table = 'auditorias';
    protected $primaryKey = 'id_auditoria';

    protected $fillable = ['id_usuario', 'modulo_afectado', 'accion', 'descripcion_detalle', 'ip_origen', 'fecha_hora'];
    protected $casts = ['fecha_hora' => 'datetime'];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
