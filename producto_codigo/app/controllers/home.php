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
        $this->vista($param, $data);

      

    }

    private function vista($param, $data)
    {
    
        $data["q2"] = prm_def($param, "q2");
        $servicio = $this->app->servicio($this->id_servicio);

            
            $id_usuario = pr($servicio, "id_usuario");
            $usuario = $this->app->usuario($id_usuario);            
            $data["usuario"] = $usuario;
            $data["id_publicador"] = key_exists_bi($servicio, 0, "id_usuario", 0);        
            $data["producto"] = $servicio;
            $data["costo_envio"] = "";
            $data["tiempo_entrega"] = "";
            $data["ciclos"] = "";            
            $data["id_usuario"] = $id_usuario;
            
            $data["img"] = $this->app->imgs_productos($this->id_servicio, 1, 1);                                    
            
            $titulo_nombre_servicio = html_escape(pr($servicio,"nombre_servicio"));                                                                                                                                                                
            $data["titulo"] = $titulo_nombre_servicio;
            $data["id_servicio"] = $this->id_servicio;            
            $data["footer_visible"] = false;
            $data = $this->app->cssJs($data, "producto_codigo");        
            $this->app->log_acceso($data, 3, $this->id_servicio  );
            $this->app->pagina($data, render_producto_codigo($data), 1);
            //$this->app->pagina($data, "cuenta_regresiva/conteo");

                     
    
    }

    
}

