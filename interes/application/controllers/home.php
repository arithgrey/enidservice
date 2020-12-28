<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('pregunta_frecuente');
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session(
            "",
            "Cosas que deberías saber",
            "",
            create_url_preview("comisionistas.png")
        );

        $data = $this->app->cssJs($data, "preguntas_frecuentes");
        $data["es_administrador"] = intval((intval( $data["in_session"])) && es_administrador($data));

        $this->app->pagina($data, 'ventas');

    }

}