<?php

namespace Enid\Nicho;

use Enid\Api\Api as Api;

class Nicho
{
    private $api;
    function __construct()
    {
        $this->api = new Api();
    }
    function tiendas($campo_valor = 'path', $clase_ir_a_tienda = 'selector_tienda_nicho', $selector_default = 0)
    {
        $nichos = $this->api->api("nicho/index");
        $response = "";
        if (es_data($nichos)) {
            $clase = _text_('tiendas form-control', $clase_ir_a_tienda);
            if($selector_default < 1){

                $response = create_select(
                    $nichos,
                    'tienda',
                    $clase ,
                    "tiendas",
                    "nombre",
                    $campo_valor,
                    0,
                    1,
                    0,
                    "Selecciona una tienda Nicho"
                );

            }else{
                
                $response =  create_select_selected(
                    $nichos,
                    $campo_valor,
                    "nombre",
                    $selector_default,
                    "id_nicho",
                    $clase 

                );
            }
            
        }
        return $response;
    }
}
