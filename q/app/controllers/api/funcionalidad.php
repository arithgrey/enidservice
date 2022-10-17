<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class funcionalidad extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("funcionalidad_model");
		$this->load->helper("funcionalidad");
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("id_usuario");
	}

	function add_usuario_PUT()
	{

		$param = $this->put();
		$response = false;
		if (fx($param, "id_usuario")) {

			$response = $this->add_conceptos($this->funcionalidad_model->get([], [], 100), $param["id_usuario"]);
		}
		$this->response($response);
	}

	function usuario_GET()
	{

		$param = $this->get();
		$funcionalidad = $this->funcionalidad_model->get([], [], 100);
		$conceptos = $this->add_conceptos($funcionalidad, $this->id_usuario);
		$this->response(get_terminos($conceptos));
	}

	function add_conceptos($funcionalidades, $id_usuario)
	{

		$response = [];
		$a = 0;
		foreach ($funcionalidades as $row) {

			$response[$a] = $row;
			$response[$a]["conceptos"] = $this->get_conceptos_por_funcionalidad_usuario($row["id_funcionalidad"], $id_usuario);
			$a++;
		}

		return $response;
	}

	function get_conceptos_por_funcionalidad_usuario($id_funcionalidad, $id_usuario)
	{


		$q =  [

            "id_usuario" => $id_usuario,
            "id_funcionalidad" => $id_funcionalidad,
        ];

		return $this->app->api("privacidad/conceptos_por_funcionalidad_usuario", $q);
	}

}