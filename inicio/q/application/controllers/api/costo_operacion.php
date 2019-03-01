<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class costo_operacion extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("costo_operacion_model");
		$this->load->library(lib_def());
	}

	function recibo_GET()
	{
		$param = $this->get();
		$response = false;
		if (if_ext($param, "recibo")) {
			$response = $this->costo_operacion_model->get_recibo($param["recibo"]);
		}
		$this->response($response);
	}
	function index_POST(){

		$param = $this->post();
		$response = false;
		if (if_ext($param, "recibo,costo,tipo")) {

			$params =  [

					"monto"    =>  $param["costo"],
					"id_recibo" => $param["recibo"],
					"id_tipo_costo" => $param["tipo"]

			];
			$response = $this->costo_operacion_model->insert($params);

		}
		$this->response($response);

	}

}
