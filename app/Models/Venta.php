<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Venta extends Model
{
    protected $table = 'ventas';
    protected $primaryKey = 'id_venta';

    protected $fillable = ['fecha_hora', 'total_neto', 'igv', 'total_pagar', 'metodo_pago', 'id_usuario'];
    protected $casts = ['fecha_hora' => 'datetime'];

    public function cajero(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta', 'id_venta');
    }

    public function comprobante(): HasOne
    {
        return $this->hasOne(Comprobante::class, 'id_venta', 'id_venta');
    }
}
