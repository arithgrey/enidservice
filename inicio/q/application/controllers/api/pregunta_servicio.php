<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Pregunta_servicio extends REST_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper("pregunta");
		$this->load->model("pregunta_servicio_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "id_pregunta,servicio")) {
			$params = [
				"id_pregunta" => $param["id_pregunta"],
				"id_servicio" => $param["servicio"]
			];
			$response = $this->pregunta_servicio_model->insert($params);
			if ($response == true) {
				$this->notifica_vendedor($param["servicio"]);
			}
		}
		$this->response($response);
	}

	private function notifica_vendedor($id_servicio)
	{

		$usuario = $this->get_usuario_servicio($id_servicio);
		$sender = get_notificacion_pregunta($usuario);
		$this->principal->send_email_enid($sender);

	}

	private function get_usuario_servicio($id_servicio)
	{
		$q["id_servicio"] = $id_servicio;
		$api = "usuario/usuario_servicio/format/json/";
		return $this->principal->api($api, $q);
	}

}