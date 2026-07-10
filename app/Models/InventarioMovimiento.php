<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarioMovimiento extends Model
{
    protected $table = 'inventarios_movimientos';
    protected $primaryKey = 'id_movimiento';

    protected $fillable = ['id_producto', 'tipo_movimiento', 'cantidad', 'motivo', 'fecha_movimiento'];
    protected $casts = ['fecha_movimiento' => 'datetime'];

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto', 'id_producto');
    }
}
