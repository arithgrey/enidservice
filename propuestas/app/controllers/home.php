<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller
{
    public $options;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("recompensa");        
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $param = $this->input->get();
        $id_servicio = prm_def($param,'q');
        $data = $this->app->session();
        $data["id_servicio"] = $id_servicio; 
        $data["propuestas"] = $this->propuestas($id_servicio);      
        $data["servicio"] = $this->app->servicio($id_servicio);
        $data = $this->app->cssJs($data, "propuestas"); 
        $data["url_img_servicio"]= $this->app->imgs_productos($id_servicio, 1, 1, 1);
        $data["path_producto"] = _text("https://enidservices.com/web/producto/?producto=",$id_servicio);
        $this->app->log_acceso($data, 23);
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
