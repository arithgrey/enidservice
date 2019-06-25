<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Imagen_servicio extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("imagen_servicio_model");
		$this->load->library(lib_def());
	}

	function servicio_GET()
	{

		$param = $this->get();
		$response = 2;
		if (if_ext($param, "id_servicio")) {

			$id_servicio = $param["id_servicio"];

			if (get_param_def($param, "c") >  0){

				$response =  $this->imagen_servicio_model->get_imagen_servicio($id_servicio, get_param_def($param,"l",1));

			}else{

				$limit = (get_param_def($param, "limit") > 0) ? $param["limit"] : 8;
				$in = ["id_servicio" => $id_servicio];
				$f = ["id_imagen", "principal"];
				$response = $this->imagen_servicio_model->get($f, $in, $limit, "principal");
			}


		}
		$this->response($response);
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "id_imagen,id_servicio")) {
			$params = [
				"id_imagen" => $param["id_imagen"],
				"id_servicio" => $param["id_servicio"]
			];
			$response = $this->imagen_servicio_model->insert($params);
		}
		$this->response($response);
	}

	function principal_PUT()
	{
		$param = $this->put();
		$response = 2;
		if (if_ext($param, "id_imagen,id_servicio")) {

			$id_servicio = $param["id_servicio"];
			$set = ["principal" => 0];
			$in = ["id_servicio" => $id_servicio];
			$response = false;
			if ($this->imagen_servicio_model->update($set, $in, 10)) {

				$set = ["principal" => 1];
				$in = ["id_servicio" => $id_servicio, "id_imagen" => $param["id_imagen"]];
				$response = $this->imagen_servicio_model->update($set, $in);
			}

		}

		$this->response($response);
	}

	function index_DELETE()
	{

		$param = $this->delete();
		$response = [];
		if (if_ext($param, 'id_imagen')) {

			$q = ["id_imagen" => $param["id_imagen"]];

			if ($this->imagen_servicio_model->delete($q, 20)) {

                $response = [
                    "status_imagen_servicio" =>  1,
                    "status_img" =>  $this->delete_imagen($param),
                    "evento" =>  $this->valida_existencia_servicio($param),
                ];

			}
		}

		$this->response($response);
	}

	private function delete_imagen($q)
	{

		return $this->principal->api("img/index", $q, "json", "DELETE");
	}

	private function valida_existencia_servicio($q)
	{

		/*Ahora valido que el servicio no se quede sin imagenes, de ser así pasar a 0 el status del servicio*/
		$response = [];
		if (if_ext($q, "id_servicio")) {

			$response["num_imagenes"] = $this->imagen_servicio_model->get_num_servicio($q["id_servicio"]);
			if ($response["num_imagenes"] == 0) {
				/*Notifico en servicio que no cuenta con la imagen*/
				$response["notificacion_existencia"] = $this->notifica_existencia_servicio($q);
			}
		}
		return $response;
	}

	private function notifica_existencia_servicio($q)
	{

		$q["existencia"] = 0;
		return $this->principal->api("servicio/status_imagen", $q, "json", "PUT");
	}

}