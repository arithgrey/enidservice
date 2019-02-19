<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Saldos extends REST_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->model("saldos_model");
		$this->load->library(lib_def());
	}
	/*
	function usuario_POST(){

		$param =  $this->post();
		$saldos=  $this->saldos_model->get_saldo_usuario($param);

		$nueva_data =0;
		if(count($saldos)>0){

			$porcentaje_comision = $this->get_porcentaje_comision($param);
			$nueva_data=  crea_saldo_disponible($saldos , $porcentaje_comision);

		}
		$this->response($nueva_data);
	}
	private function get_porcentaje_comision($q){
		$api = "cobranza/comision/format/json/";
		return $this->principal->api(  $api, $q );
	}
	*/

}