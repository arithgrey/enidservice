<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("cross_selling");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->acceso();
        $param = $this->input->get();
        $data = $this->app->cssJs($data, "cross_selling");
        $id_usuario = prm_def($param, "id_usuario");

        if ($id_usuario > 0) {

            $data["cliente"] = $this->app->usuario($id_usuario);
            $data["recibos"] = $this->recibos_usuario($id_usuario);
            $recibos_pagos = $this->recibos_usuario($id_usuario,1);
            $recibos_pagos = $this->app->add_imgs_servicio($recibos_pagos);
            $data["recibos_pagos"] = $recibos_pagos;

            $servicios_sugeridos = $this->servicios_relacionados($id_usuario);
            $data["servicios_sugeridos"] = $this->app->add_imgs_servicio($servicios_sugeridos, "id_servicio_relacion");

            $this->app->pagina($data, render($data), 1);

        }

    }


    private function recibos_usuario($id_usuario, $es_pago = 0)
    {

        return $this->app->api(
            "recibo/usuario_relacion/format/json/",
            [
                "id_usuario" => $id_usuario,
                "es_pago" => $es_pago
            ]
        );
    }

    private function servicios_relacionados($id_usuario)
    {

        return $this->app->api(
            "servicio_relacion/usuario_recibo/format/json/",
            [
                "id_usuario" => $id_usuario
            ]
        );
    }


}
