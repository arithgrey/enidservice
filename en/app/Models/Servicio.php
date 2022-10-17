<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    function clasificacion()
    {
        return $this->belongsTo(Clasificacion::class, 'id_clasificacion');
    }
    function ciclo_facturacion()
    {
        return $this->belongsTo(CicloFacturacion::class, 'id_ciclo_facturacion');
    }
    function preferencias(){

        return $this->hasMany(Preferencia::class);
    }
    function proveedores(){

        return $this->hasMany(ProveedorServicio::class);
    }

}
