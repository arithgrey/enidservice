<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoOrdenCompra extends Model
{
    use HasFactory;

    function orden_compra()
    {
        return $this->belongsTo(OrdenCompra::class, 'id_orden_compra');
    }
    function proyecto_persona_forma_pago()
    {
        return $this->belongsTo(ProyectoPersonaFormaPago::class, 'id_proyecto_persona_forma_pago');
    }

}
