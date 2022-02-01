<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


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
        $data = $this->app->session();
        $data["recompensa"] = $this->recompensas($id_producto);        
        $data["id_servicio"] = $id_producto;
        $data = $this->app->cssJs($data, "recompensa");        
        $this->app->pagina($data, recompensa($data), 1);

    }


    private function recompensas($id_servicio)
    {

        $api = "recompensa/servicio";
        return $this->app->api($api,
            [
                "id_servicio" => $id_servicio,
                "disponible" => 1
            ]
        );

    }

}
