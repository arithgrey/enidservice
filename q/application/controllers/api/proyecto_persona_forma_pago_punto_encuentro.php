<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Proyecto_persona_forma_pago_punto_encuentro extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("proyecto_persona_forma_pago_punto_encuentro_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "id_recibo,punto_encuentro")) {

            $id_recibo =  $param["id_recibo"];
			$in = ["id_proyecto_persona_forma_pago" => $id_recibo];
			if ($this->proyecto_persona_forma_pago_punto_encuentro_model->delete($in, 10)) {

				$params = [
					"id_proyecto_persona_forma_pago" => $id_recibo,
					"id_punto_encuentro" => $param["punto_encuentro"]
				];

				$response = $this->proyecto_persona_forma_pago_punto_encuentro_model->insert($params);
			}
		}
		$this->response($response);
	}

	function punto_encuentro_recibo_GET()
	{

		$param = $this->get();
		$response = false;

		if (fx($param, "id_recibo")) {
			$response = $this->get_id_proyecto_persona_forma_pago($param["id_recibo"]);
		}
		$this->response($response);
	}

	function complete_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_recibo")) {
            $response = [];
			$pe = $this->get_id_proyecto_persona_forma_pago($param["id_recibo"]);
			if (es_data($pe)) {
				$id_pe = pr($pe,"id_punto_encuentro");
				$response = $this->get_punto_encuentro($id_pe);
			}
		}
		$this->response($response);
	}

	private function get_punto_encuentro($id_recibo)
	{
		$q["id"] = $id_recibo;
		return $this->app->api("punto_encuentro/id/format/json/", $q);
	}

	private function get_id_proyecto_persona_forma_pago($id_recibo)
	{

		$in = ["id_proyecto_persona_forma_pago" => $id_recibo];
		return $this->proyecto_persona_forma_pago_punto_encuentro_model->get(["id_punto_encuentro"], $in);
	}
	function  index_DELETE(){

		$param = $this->delete();
		$response = false;
		if (fx($param, "id_recibo")) {

			$in       =  ["id_proyecto_persona_forma_pago" => $param["id_recibo"]];
			$response = $this->proyecto_persona_forma_pago_punto_encuentro_model->delete($in,  10);
		}
		$this->response($response);
	}

}