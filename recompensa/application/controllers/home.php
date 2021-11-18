<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('../librerias/google-translate/vendor/autoload.php');


class Home extends CI_Controller
{
    public $options;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("recompensa");
        $this->load->library(lib_def());
    }

    function index()
    {
        $param = $this->input->get();
        $id_producto = $this->input->get("id");
        $data = $this->app->session(3);
        $data["recompensa"] = $this->recompensas($id_producto);
        $data["id_servicio"] = $id_producto;
        $data = $this->app->cssJs($data, "recompensa");
        $this->app->log_acceso($data, 21);
        $this->app->pagina($data, recompensa($data), 1);

    }


    private function recompensas($id_servicio)
    {

        $api = "recompensa/servicio/format/json/";
        return $this->app->api($api,
            [
                "id_servicio" => $id_servicio,
                "disponible" => 1
            ]
        );

    }

}
