<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    private $id_servicio;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("producto");
        $this->load->library(lib_def());
        $this->id_servicio = $this->input->get("producto");
    }

    function index()
    {

        $param = $this->input->get();
        $data = $this->app->session();        
        $data["q2"] = prm_def($param, "q2");
        $servicio = $this->app->servicio($this->id_servicio,1);        
        $path = path_enid("go_home");
        $id_usuario = pr($servicio, "id_usuario");
        $usuario = (es_data($servicio)) ? $this->app->usuario($id_usuario) : redirect($path);
        $data["usuario"] = $usuario;        
        $data["info_servicio"]["servicio"] = $servicio;        
        $data["imgs"] = $this->app->imgs_productos($this->id_servicio, 1, 10);

        $data["id_servicio"] = $this->id_servicio;
        $data["existencia"] = $this->get_existencia($this->id_servicio);

        $data = $this->app->cssJs($data, "producto_metricas");
        $this->app->pagina($data, render_producto($data), 1);
        $this->load->view("producto/localidades");

        
    }
    
    private function get_existencia($id_servicio)
    {

        return $this->app->api("servicio/existencia", ["id_servicio" => $id_servicio]);
    }
    

}
