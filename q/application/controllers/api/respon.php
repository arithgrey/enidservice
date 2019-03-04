<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Respon extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("response_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->principal->get_session("idusuario");
	}

	function respuestas_pregunta_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_pregunta")) {
			$response = $this->response_model->get_respuestas_pregunta($param);
		}
		$this->response($response);
	}

}