<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comprobante extends Model
{
    protected $table = 'comprobantes';
    protected $primaryKey = 'id_comprobante';

    protected $fillable = ['id_venta', 'tipo_comprobante', 'serie', 'correlativo', 'documento_cliente'];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'id_venta', 'id_venta');
    }
}
