<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Lista_deseo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->helper("lista_deseo");
        $this->load->library(lib_def());
    }

    function explora_deseo_GET($data)
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "ip")) {

            
            $lista_deseo = $this->app->api("usuario_deseo_compra/ip_carro/", ['ip' => $param["ip"]]);            
            $listado = prm_def($lista_deseo,"listado",[]);                                
            $response = productos($data,  $listado,1);
            
        }
        $this->response($response);

    }

}