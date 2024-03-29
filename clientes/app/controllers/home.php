<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('vinculo');
        $this->load->library(lib_def());
    }

    function index()
    {

        $data = $this->app->session();
        $data = $this->app->cssJs($data, "clientes");
        
        $data["imagenes_clientes"] = $this->imagenes_clientes($data["id_nicho"]);
        
        $this->app->log_acceso($data,1);
        $this->app->pagina($data, render($data), 1);


    }

    private function imagenes_clientes($id_nicho)
    {
        
        
        return $this->app->api("imagen_cliente_empresa/clientes", 
            [                
                "id_nicho" => $id_nicho
            ]);

    }


}