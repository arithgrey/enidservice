<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("metricas_recursos");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "metricas_recursos");

        $data["usuarios_comisionistas"] = [];
        $data["ventas"] = [];
        $params = $this->input->post();

        $data["fecha_inicio"] =  '';
        $data["fecha_termino"] =  '';

        if ($params) {

            $usuarios_comisionistas = $this->usuarios_comisionistas();
            $fecha_inicio = $params["fecha_inicio"];
            $fecha_termino = $params["fecha_termino"];
            $ids = array_column($usuarios_comisionistas, "idusuario");
            $ventas = $this->ventas_periodo($fecha_inicio, $fecha_termino, $ids);
            $data["usuarios_comisionistas"] =  $usuarios_comisionistas;
            $data["ventas"] =  $ventas;
            $data["fecha_inicio"] =  $fecha_inicio;
            $data["fecha_termino"] =  $fecha_termino;

        }

        $this->app->pagina($data, render($data), 1);


    }

    private function ventas_periodo($fecha_inicio, $fecha_termino, $ids = [])
    {

        $q = [
            "cliente" => "",
            "v" => 2,
            "recibo" => "",
            "tipo_entrega" => 0,
            "status_venta" => 14,
            "tipo_orden" => 1,
            "fecha_inicio" => $fecha_inicio,
            "fecha_termino" => $fecha_termino,
            "perfil" => 3,
            "id_usuario" => 0,
            "ids" => $ids
        ];

        return $this->app->api("recibo/ventas_periodo_ids/format/json/", $q);

    }


    private function usuarios_comisionistas()
    {

        return $this->app->api("usuario_perfil/comisionistas/format/json/");
    }

}
