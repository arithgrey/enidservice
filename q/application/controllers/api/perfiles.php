<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Perfiles extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("perfil_model");
		$this->load->library(lib_def());
	}

	function get_GET()
	{

		$this->response($this->perfil_model->get([], [], 50));
	}

	function id_departamento_by_id_perfil_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_perfil")) {
			$response = $this->perfil_model->get(["id_departamento"], ["idperfil" => $param["id_perfil"]])[0]["id_departamento"];
		}
		$this->response($response);
	}

	function data_usuario_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_usuario")) {

			$response = $this->perfil_model->get_usuario($param["id_usuario"]);

		}
		$this->response($response);
	}

	function puesto_cargo_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_usuario")) {

			$response = create_select(
			    $this->perfil_model->get([], ["id_departamento" => $param["id_departamento"]], 100),
				"puesto",
				"form-control input-sm puesto",
				"puesto",
				"nombreperfil",
				"idperfil");
		}
		$this->response($response);
	}
}