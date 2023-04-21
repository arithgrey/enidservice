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
            
            $es_acceso_rapido = prm_def($param,'acceso_rapido');

            $limit = ($es_acceso_rapido > 0) ?  15 : 30;
            $respuestas_frecuentes = $this->respuesta_frecuente_model->q($param["q"], $limit);
            $response = $this->respuestas_frecuentes->opciones($respuestas_frecuentes, $es_acceso_rapido);

        }
        $this->response($response);

	}
    function listado_GET()
	{
        $param = $this->get();
        $response = false;
        if (fx($param, "q")) {

            $respuestas_frecuentes = $this->respuesta_frecuente_model->q($param["q"]);
            $response = $this->respuestas_frecuentes->opciones($respuestas_frecuentes);

        }
        $this->response($response);

	}

    function index_POST()
	{
		$param = $this->post();
		$response = false;
		
		if (fx($param, "respuesta,atajo")) {
            
			$params = [
				"respuesta" => $param["respuesta"],
				"atajo" => $param["atajo"],				
			];
            
			$response = $this->respuesta_frecuente_model->insert($params, 1);

		}
		$this->response($response);
	}

}