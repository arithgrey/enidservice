<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Cuentas extends REST_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->model("cuenta_pago_model");
		$this->load->library(lib_def());

	}

	function usuario_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "metodos_disponibles")) {
			if ($param["metodos_disponibles"] == 1) {

				$response = $this->cuenta_pago_model->get_cuentas_usuario($param);
			}
		}
		$this->response($response);

	}

	function bancaria_POST()
	{

		$param = $this->post();
		$response = false;

		if ($param["tipo"] == 0) {

            $response =  (if_ext($param, "id_usuario,clabe,banco")) ? $this->regitra_cuenta_bancaria($param) : "";

		} else {

			$response =  (if_ext($param, "id_usuario,banco,tipo,tipo_tarjeta,numero_tarjeta")) ? $this->regitra_cuenta_debito($param) : "";

		}
		$this->response($response);

	}

	private function regitra_cuenta_bancaria($param)
	{

		$response["registro_cuenta"] = 0;
		$response["banco_es_numerico"] = 0;
		$response["clabe_es_corta"] = 1;
		$banco = $param["banco"];
		$clabe = $param["clabe"];
		$id_usuario = $param["id_usuario"];

		if (is_numeric($banco)) {
			$response["banco_es_numerico"] = 1;
			if (strlen(trim($clabe)) == 18) {
				$response["clabe_es_corta"] = 0;

				$params = [
					"id_usuario" => $id_usuario,
					"clabe" => $clabe,
					"id_banco" => $banco,
					"tipo" => 0,
					"propietario_tarjeta" => ""
				];
				$status = $this->cuenta_pago_model->insert($params);
				$response["registro_cuenta"] = $status;
			}
		}
		return $response;
	}

	private function regitra_cuenta_debito($param)
	{

		$response["registro_cuenta"] = 0;
		$response["banco_es_numerico"] = 0;
		$response["clabe_es_corta"] = 1;
		$banco = $param["banco"];
		$id_usuario = $param["id_usuario"];

		if (is_numeric($banco)) {
			$response["banco_es_numerico"] = 1;
			if (strlen(trim($param["numero_tarjeta"])) == 16) {
				$response["clabe_es_corta"] = 0;
				$params = [
					"id_usuario" => $id_usuario,
					"id_banco" => $banco,
					"tipo" => $param["tipo"],
					"tipo_tarjeta" => $param["tipo_tarjeta"],
					"numero_tarjeta" => $param["numero_tarjeta"],
					"propietario_tarjeta" => ""
				];

				$response["registro_cuenta"] = $this->cuenta_pago_model->insert($params);
			}
		}
		return $response;
	}

}