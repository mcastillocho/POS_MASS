<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tienda extends Model
{
    protected $table = 'tiendas';
    protected $primaryKey = 'id_tienda';

    protected $fillable = ['nombre_tienda', 'direccion', 'ubigeo', 'estado'];

    public function usuarios(): HasMany
    {
        return $this->hasMany(Usuario::class, 'id_tienda', 'id_tienda');
    }
}
