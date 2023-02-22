<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Intento_conversion extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("intento_conversion_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "in_session,ip")) {

            $numero_intentos = $this->intento_conversion_model->get([], ["ip" => $param["ip"]]);            
            if(es_data($numero_intentos) ){
                
                $intentos = pr($numero_intentos, "intentos") + 1;
                $id = pr($numero_intentos, "id_intento_conversion");


                $response = $this->intento_conversion_model->q_up("intentos", $intentos, $id);

            }else{

                $response = $this->intento_conversion_model->insert($param, 1);
            }
            
        }
        $this->response($response);
    }
    function id_cupon_GET()
	{
        $response = false;
        $param = $this->get();
        $response = ["promocion_10_porciento" => false]; 
        if (fx($param, "ip")) {

            $intento_conversion = $this->intento_conversion_model->intento_conversion($param["ip"]);

            if(es_data($intento_conversion) ){

                $se_muestra_cupon = pr($intento_conversion, "se_muestra_cupon");
                $intentos = pr($intento_conversion, "intentos");
                $nuevo_intento = $intentos + 1;
                $id = pr($intento_conversion, "id_intento_conversion");
                
                $response["intentos"] = $intentos;

                $this->intento_conversion_model->q_up("intentos", $nuevo_intento, $id);
                
                $movimientos = [1,30,50];
                
                if(in_array($intentos, $movimientos) && $se_muestra_cupon < 4){

                    $response = ["promocion_10_porciento" => true]; 
                    
                    $notificacion_cupon = $se_muestra_cupon + 1;
                    $this->intento_conversion_model->q_up("se_muestra_cupon", $notificacion_cupon, $id);
                }

            }
            
        }
        $this->response($response);
		
	}


    
}
