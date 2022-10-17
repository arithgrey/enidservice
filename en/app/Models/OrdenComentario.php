<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenComentario extends Model
{
    use HasFactory;
    protected $fillable = [
        'comentario',
        'id_orden_compra'
    ];
    protected $appends = ['path_orden'];
    function orden_compra()
    {
        return $this->belongsTo(OrdenCompra::class, 'id_orden_compra');
    }
    public function getPathOrdenAttribute()
    {
        return "https://enidservices.com/web/pedidos/?recibo=$this->id_orden_compra";
    }
}
