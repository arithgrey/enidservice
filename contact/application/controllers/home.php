<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $option;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("contacto");
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session("Solicita una llamada aquí");
        $data["departamentos"] = $this->app->api("departamento/index/format/json/");
        $data = $this->app->cssJs($data, "contacto");
        $param = $this->input->post();

        if (get_param_def($param, "proceso_compra", 0, 1) > 0) {


            $this->app->pagina($this->app->cssJs($data, "contacto_proceso_compra"), get_format_proceso_compra(), 1);

        } else {

            $this->load_ubicacion($data, $param);

        }
    }

    private function load_ubicacion($data, $param)
    {


        $data["telefono"] = ($data["id_usuario"] > 0) ? $this->app->usuario($data["id_usuario"])[0]["tel_contacto"] : "";

        if ($data["in_session"] == 0 && get_param_def($param, "servicio", 0, 1) > 0) {

            $data = $this->app->cssJs($data, "contacto_ubicacion");
            $this->app->pagina($data, get_format_recibe_ubicacion($param["servicio"]), 1);

        } else {

            $param = $this->input->get();
            $data["ubicacion"] = exists_array_def($param, "ubicacion");
            $this->app->pagina($data, render_contacto($data), 1);

        }
    }

}