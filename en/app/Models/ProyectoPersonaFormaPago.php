<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyectoPersonaFormaPago extends Model
{
    use HasFactory;
    protected $fillable = [
        'saldo_cubierto',
        'id_forma_pago',
        'id_usuario_referencia',
        'id_usuario',
        'id_usuario_venta',
        'status',
        'num_ciclos_contratados',
        'id_servicio',
        'se_cancela',
        'nota',
        'resumen_pedido',
        'monto_a_pagar'
    ];

    protected $appends = [
        'es_cancelacion',
        'path_orden',
    ];
    function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    function forma_pago()
    {
        return $this->belongsTo(FormaPago::class, 'id_forma_pago');
    }
    function ciclo_facturacion()
    {
        return $this->belongsTo(CicloFacturacion::class, 'id_ciclo_facturacion');
    }
    function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
    function productos_ordenes_compra(){

        return $this->hasMany(ProductoOrdenCompra::class);
    }
    function ubicaciones(){

        return $this->hasMany(Ubicacion::class);
    }
    public function getEsCancelacionAttribute()
    {
        $response = false;
        if ($this->se_cancela || $this->cancela_cliente) {
            $response = true;
        }
        return $response;
    }
    public function getPathOrdenAttribute()
    {
        return "https://enidservices.com/web/pedidos/?recibo=$this->id_orden_compra";
    }
}
