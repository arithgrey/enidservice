<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("metricas_registros");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "metricas_registros");

        $params = $this->input->post();

        $data["fecha_inicio"] = '';
        $data["fecha_termino"] = '';
        $data["usuarios"] = [];
        $data["accesos"]  = [];

        if (es_data($params)) {

            $fecha_inicio = $params["fecha_inicio"];
            $fecha_termino = $params["fecha_termino"];

            $data["fecha_inicio"] = $fecha_inicio;
            $data["fecha_termino"] = $fecha_termino;

            $data["usuarios"] = $this->usuarios_comisionistas($fecha_inicio, $fecha_termino);
            $data["accesos"] = $this->accesos_landing_page(5, $fecha_inicio, $fecha_termino);
            
        }

        $this->app->pagina($data, render($data), 1);


    }

    private function usuarios_comisionistas($fecha_inicio, $fecha_termino)
    {

        return $this->app->api("usuario_perfil/comisionistas_periodo",
            [
                "fecha_inicio" => $fecha_inicio,
                "fecha_termino" => $fecha_termino
            ]
        );
    }
    private function accesos_landing_page($pagina_id, $fecha_inicio, $fecha_termino)
    {

        return $this->app->api("acceso/q_fecha_conteo",
            [                
                "pagina_id" =>  $pagina_id,
                "fecha_inicio" => $fecha_inicio,
                "fecha_termino" => $fecha_termino
            ]
        );
    }


}
