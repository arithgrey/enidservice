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
        $id_servicio = prm_def($param,'q');
        $data = $this->app->session();
        $data["id_servicio"] = $id_servicio; 
        $data["propuestas"] = $this->propuestas($id_servicio);        
        $data = $this->app->cssJs($data, "propuestas");        
        $this->app->pagina($data, propuestas($data), 1);

    }
    private function propuestas($id_servicio)
    {        
        return $this->app->api("propuesta/servicio", 
            [
                "id_servicio" => $id_servicio 
            ]);

    }
    
}
