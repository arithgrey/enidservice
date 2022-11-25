<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper("promesa");
        $this->load->library(lib_def());
    }

    function index()
    {
        $param = $this->input->get();  
        $id_servicio = $param["q"];
        $sorteo = $this->sorteo($id_servicio);
        $data = $this->app->session(); 
        $data["boletos"] = $sorteo;

        if(es_data($sorteo)){
            
            /*Mapeo del plano*/
            
            $data = $this->app->cssJs($data, "sorteo_venta");   
            $this->app->log_acceso($data, 3, $id_servicio);     
            $data["boletos_comprados"] = $this->boletos_pagos($id_servicio);
            
            
            $data["boleto"] = prm_def($param,"boleto");
            $data["numero_sorteo"] = prm_def($param,"q");
            
            $data["servicio"] = $this->app->servicio($id_servicio);
            $data["imgs"] = $this->app->imgs_productos($id_servicio, 1, 10);              
            $this->app->pagina($data, render_plano($data, $id_servicio), 1);

        }else{

            /*Registro*/
            
            $data = $this->app->cssJs($data, "sorteo");        
            $this->app->pagina($data, render($data, $param), 1);

        }
        
    }

    private function sorteo($id_servicio)
    {
        
        return $this->app->api("servicio_sorteo/index", 
            [                
                "id_servicio" => $id_servicio
            ]
        );
    }
    private function boletos_pagos($id_servicio)
    {

        $response = [];
        $recibos =  $this->app->api("recibo/servicio_pago", 
            [                
                "id_servicio" => $id_servicio
            ]
        );
        if(es_data($recibos)){
            $a = 0;
            foreach($recibos as $row){

                $response[$a] =  $row;
                $response[$a]["usuario"]  = $this->app->usuario($row["id_usuario"]);
            }
        }
        return $response;
    }
    

    
}
