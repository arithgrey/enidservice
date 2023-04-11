<?php

namespace Enid\ReciboReparto;

class Reparto
{
    private $recibo_model;
    function __construct($recibo_model)
    {
        $this->recibo_model =  $recibo_model;
    }
    function envio_a_reparto($productos_orden_compra, $es_ubicacion = 0)
    {

        foreach ($productos_orden_compra as $row) {

            $id_recibo = $row["id"];
            $params = [
                "status" => 16,
                "saldo_cubierto" => 0,
                "se_cancela" => 0,
                "cancela_cliente" => 0,
                "ubicacion" => $es_ubicacion,
                "contra_entrega_domicilio" => 1
            ];

            $in = ["id" => $id_recibo];

            return $this->recibo_model->update($params, $in);
        }
    }
}
