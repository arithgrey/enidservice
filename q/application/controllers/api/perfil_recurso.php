<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class perfil_recurso extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("perfil_recurso_model");
		$this->load->library(lib_def());
	}

	function permiso_PUT()
	{

		$param = $this->put();
		$response = false;
		if (fx($param, "id_recurso,id_perfil")) {
			$params = [
				"idrecurso" => $param["id_recurso"],
				"idperfil" => $param["id_perfil"]
			];
			$num = $this->perfil_recurso_model->get_num($param);
			if ($num > 0) {
				$response = $this->perfil_recurso_model->delete($params, 10);
			} else {
				$response = $this->perfil_recurso_model->insert($params);
			}
		}
		$this->response($response);
	}
}