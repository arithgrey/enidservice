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
    function tiendas()
    {
        $nichos = $this->api->api("nicho/index");
        $response = "";
        if (es_data($nichos)) {
            $response = create_select(
                $nichos,
                'tienda',
                'tiendas form-control selector_tienda_nicho',
                "tiendas",
                'nombre',
                'path'
            );
            
        }
        return $response;
    }
}
