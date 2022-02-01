<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("seguidores");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "seguidores", 1);
        $id_seguidor = $data["id_usuario"];
        $data["seguidores"] = $this->seguidores($id_seguidor);
        $data["seguimiento"] = $this->seguimiento($id_seguidor);
        $data["id_seguidor"] = $id_seguidor;
        $this->app->pagina($data, render($data), 1);

    }

    private function seguidores($id_seguidor)
    {
        return $this->app->api("usuario_conexion/seguidores",
            [
                "id_usuario" => $id_seguidor
            ]
        );
    }
    private function seguimiento($id_seguidor)
    {
        return $this->app->api("usuario_conexion/seguimiento",
            [
                "id_usuario" => $id_seguidor
            ]
        );
    }
}
