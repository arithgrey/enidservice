<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class cuenta_pago extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("cuenta_pago_model");
		$this->load->library(lib_def());
	}

	function regitra_tarjeta($param)
	{

		$numero_tarjeta = $param["numero_tarjeta"];
		$banco = $param["banco"];
		$respose["registro_cuenta"] = 0;
		$respose["banco_es_numerico"] = 0;
		$respose["clabe_es_corta"] = 1;

		if (is_numeric($banco)) {
			$respose["banco_es_numerico"] = 1;
			if (strlen(trim($numero_tarjeta)) == 16) {
				$respose["clabe_es_corta"] = 0;
				$params = [
					"id_usuario" => $param["id_usuario"],
					"numero_tarjeta" => $numero_tarjeta,
					"id_banco" => $banco,
					"tipo" => 1,
					"tipo_tarjeta" => $param["tipo_tarjeta"]
				];
				$respose["registro_cuenta"] = $this->cuenta_pago_model->insert($params);
			}
		}
		return $respose;


	}


}