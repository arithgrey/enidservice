<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';
use Enid\RespuestasFrecuentes\Form as RespuestasFrecuentes;
class respuesta_frecuente extends REST_Controller
{   
    private $respuestas_frecuentes;
	function __construct()
	{
		parent::__construct();
		$this->load->model("respuesta_frecuente_model");
		$this->load->library(lib_def());
        $this->respuestas_frecuentes = new RespuestasFrecuentes();
	}
	
    function q_GET()
	{
        $param = $this->get();
        $response = false;
        if (fx($param, "q")) {

            $respuestas_frecuentes = $this->respuesta_frecuente_model->q($param["q"]);
            $response = $this->respuestas_frecuentes->opciones($respuestas_frecuentes);

        }
        $this->response($response);

	}

}