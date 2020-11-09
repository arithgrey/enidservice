<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("reventa");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "reventa");
        $clientes = $this->clientes($data["id_usuario"]);
        $usuarios = [];
        $intentos  = [];
        if (es_data($clientes)) {

            $usuarios = $this->usuarios_q($clientes);
            sksort($usuarios, "num_compras");
            $intentos = $this->intentos_reventa();

        }

        $this->app->pagina($data, render($usuarios, $intentos), 1);


    }


    private function clientes($id_vendedor)
    {

        $clientes = $this->app->api("recibo/reventa/format/json/",
            [
                "id_vendedor" => $id_vendedor
            ]
        );

        $ids = [];
        if (es_data($clientes)) {

            $ids = array_unique(array_column($clientes, 'id_usuario'));
        }
        return $ids;


    }

    private function intentos_reventa()
    {

        return $this->app->api("usuario_servicio_propuesta/intentos/format/json/", []);

    }

    private function usuarios_q($ids_usuarios = [])
    {

        return $this->app->api("usuario/ids/format/json/", ["ids" => $ids_usuarios]);
    }

}
