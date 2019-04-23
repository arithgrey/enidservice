<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Punto_encuentro extends REST_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->model("punto_encuentro_model");
		$this->load->helper("puntoencuentro");
		$this->load->library(lib_def());
	}

	function tipo_GET()
	{

		$param = $this->get();
		$response = [];
		if (if_ext($param, "id")) {

			$params_where = ["id_tipo_punto_encuentro" => $param["id"]];
			$response = $this->punto_encuentro_model->get([], $params_where, 100);
		}
		$this->response($response);
	}

	function linea_metro_GET()
	{

		$param = $this->get();
		$response = [];

		if (if_ext($param, "id,v")) {



			if (strlen($param["q"]) >  2){

                $response = $this->punto_encuentro_model->get_like($param["id"] ,  $param["q"]);

            }else{

                $response = $this->punto_encuentro_model->get([], ["id_linea_metro" => $param["id"]], 100);
            }



			if ($param["v"] == 1) {

				$flag_envio_gratis = $this->get_flag_envio_gratis($param["servicio"]);
				$response = create_estaciones($response, $flag_envio_gratis);
			} else {

				$id_servicio = $this->get_servicio_por_recibo($param["recibo"]);
				$flag_envio_gratis = $this->get_flag_envio_gratis($id_servicio);
				$response = create_estaciones($response, $flag_envio_gratis);

			}
		}
		$this->response($response);

	}

	function costo_entrega_GET()
	{

		$param = $this->get();
		$response = [];
		if (if_ext($param, "punto_encuentro")) {
			$response = $this->punto_encuentro_model->q_get(["costo_envio"], $param["punto_encuentro"]);
		}
		$this->response($response);
	}

	function id_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id")) {

			$response = $this->punto_encuentro_model->get_tipo($param);

		}
		$this->response($response);
	}

	private function get_flag_envio_gratis($id_servicio)
	{

		$q = ["id" => $id_servicio];
		$api = "servicio/envio_gratis/format/json/";
		$response = $this->principal->api($api, $q);
		return $response[0]["flag_envio_gratis"];
	}

	private function get_servicio_por_recibo($id_recibo)
	{

		$q = ["id_recibo" => $id_recibo];
		$api = "recibo/servicio_ppfp/format/json/";
		return $this->principal->api($api, $q);

	}

}