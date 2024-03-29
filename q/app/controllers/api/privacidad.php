<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Privacidad extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("privacidad_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("id_usuario");
	}

	function conceptos_por_funcionalidad_usuario_GET()
	{

		$param = $this->get();
		$response = false;

		if (fx($param, "id_funcionalidad,id_usuario")) {
			$response = $this->privacidad_model->get_conceptos_por_funcionalidad_usuario($param["id_funcionalidad"], $param["id_usuario"]);
		}

		$this->response($response);
	}
}