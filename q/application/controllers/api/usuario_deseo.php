<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_deseo extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("usuario_deseo_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->principal->get_session("idusuario");
	}

	private function get_num_deseo_servicio_usuario($param)
	{

		$response = false;
		if (if_ext($param, "id_usuario,id_servicio")) {
			$q = [
				"id_usuario" => $param["id_usuario"],
				"id_servicio" => $param["id_servicio"]
			];
			$response = $this->usuario_deseo_model->get(["COUNT(0)num"], $q)[0]["num"];
		}

		return $response;
	}

	function num_deseo_servicio_usuario_GET($param)
	{

		$param = $this->get();
		if (if_ext($param, "id_usuario,id_servicio")) {
			$response = $this->get_num_deseo_servicio_usuario($param);
		}
		$this->response($response);
	}

	function status_PUT()
	{
		$param    = $this->put();
		$response = false;
		if (if_ext($param, "id")) {


			$response =  $this->usuario_deseo_model->q_up("status", 2, $param["id"]);

		}
		$this->response($response);
	}


	function add_lista_deseos_PUT()
	{

		$param = $this->put();
		$response = $this->procesa_deseo($param);
		$this->response($response);
	}

	function servicio_POST()
	{

		$param = $this->post();
		if (if_ext($param, "servicio") > 0 && $this->id_usuario > 0) {

			$params = [
				"id_usuario" => $this->id_usuario,
				"id_servicio" => $param["servicio"]
			];
			$response = $this->usuario_deseo_model->insert($params);
		}
		$this->response($response);
	}

	function procesa_deseo($param)
	{

		$response = false;
		if (if_ext($param, "id_usuario,id_servicio")) {
			$response = 0;
			/*if ($this->get_num_deseo_servicio_usuario($param) == 0) {*/

				$params = [
					"id_usuario" => $param["id_usuario"],
					"id_servicio" => $param["id_servicio"],
					"articulos"=> $param["articulos"]

				];

				$response = $this->usuario_deseo_model->insert($params);

	/*
			} else {

				$response = $this->usuario_deseo_model->aumenta_deseo($param);

			}
		*/
		}
		return $response;
	}

	function agregan_lista_deseos_periodo_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "fecha_inicio,fecha_termino")) {
			$response = $this->usuario_deseo_model->agregan_lista_deseos_periodo($param);
		}
		$this->response($response);
	}

	function lista_deseos_PUT()
	{

		$param = $this->put();
		$param["id_usuario"] = $this->id_usuario;
		$this->procesa_deseo($param);
		$this->agrega_interes_usuario($param);
		$this->gamificacion_deseo($param);
		$this->response(true);
	}

	function usuario_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_usuario")) {

			$id_usuario =  $param["id_usuario"];
			if (array_key_exists("c" , $param) && $param["c"] >  0) {

				$response = $this->usuario_deseo_model->get_usuario_deseo($id_usuario);

			}else{

				$response = $this->usuario_deseo_model->get([], ["id_usuario" =>  $id_usuario], 30, 'num_deseo');

			}

		}
		$this->response($response);
	}

	private function agrega_interes_usuario($q)
	{

		$api = "usuario_clasificacion/interes";
		return $this->principal->api($api, $q, "json", "POST");
	}

	private function gamificacion_deseo($q)
	{
		$api = "servicio/gamificacion_deseo";
		return $this->principal->api($api, $q, "json", "PUT");
	}

	/*
	function add_lista_deseos($q){
		$api    =  "usuario_deseo/add_lista_deseos/format/json/";
		return $this->principal->api( $api , $q , "json" , "PUT");
	}
	*/
}