<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("conexiones");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "conexiones", 1);
        $id_seguidor = $data["id_usuario"];
        $nombre = $data["nombre"];
        $data["conexiones_ranking"] = $this->conexiones_ranking($id_seguidor, $nombre);
        $data["id_seguidor"] = $id_seguidor;
        $this->app->pagina($data, render($data), 1);

    }

    private function conexiones_ranking($id_seguidor, $nombre)
    {
        return $this->app->api("usuario_conexion/ranking/format/json/",
            [
                "id_seguidor" => $id_seguidor,
                "nombre" => $nombre
            ]
        );
    }
}
