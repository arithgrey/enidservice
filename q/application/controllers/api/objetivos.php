<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class objetivos extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->helper("q");
		$this->load->model("objetivos_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->principal->get_session("idusuario");
	}

	function perfil_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_perfil")) {
			$response = $this->objetivos_model->get([], ["id_perfil" => $param["id_perfil"]], 100);
		}
		$this->response($response);
	}

}

