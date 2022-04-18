<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoPersonaFormaPago extends Model
{
    use HasFactory;
    protected $appends = ['es_cancelacion','path_orden'];
    function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
    public function getEsCancelacionAttribute()
    {
        $response = false;
        if( $this->se_cancela || $this->cancela_cliente){
            $response = true;
        }
        return $response;
    }
    public function getPathOrdenAttribute()
    {
        return "https://enidservices.com/web/pedidos/?recibo=$this->id_orden_compra";
    }


}
