<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Pagina_web extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("pagina_web_model");
		$this->load->library('table');
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("id_usuario");
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "q,q2")) {

		    $params = $param["q"];
			if ($param["q2"]== 0) {
				$response = $this->pagina_web_model->insert($params, 1);
			} else {
				$response = $this->pagina_web_model->insert($params, 1, 0, "pagina_web_bot");
			}
		}
		$this->response($response);

	}

	function dia_GET()
	{

		$this->response($this->pagina_web_model->accesos_enid_service());
	}

}