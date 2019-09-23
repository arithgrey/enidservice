<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Keyword extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("keyword_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("idusuario");
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;

		if (fx($param, "q")) {
			$response = [];
			$params = ["keyword" => $param["q"]];
			if (array_key_exists("id_usuario", $param)) {
				$params["id_usuario"] = $param["id_usuario"];
			}
			$response = $this->keyword_model->insert($params);
		}
		$this->response($response);

	}


}