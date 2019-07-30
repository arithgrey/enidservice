<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Usuario_punto_encuentro extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("usuario_punto_encuentro_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "punto_encuentro,id_usuario")) {

			$id_usuario = $param["id_usuario"];
			$id_punto_encuentro = $param["punto_encuentro"];
			$params = [
			    "id_punto_encuentro" => $id_punto_encuentro,
                "id_usuario" => $id_usuario
            ];
			$num = $this->usuario_punto_encuentro_model->get_num($id_usuario, $id_punto_encuentro);
            $response = ($num == 0)  ? $response = $this->usuario_punto_encuentro_model->insert($params) :  true;

		}
		$this->response($response);
	}

	function usuario_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_usuario")) {

			$response =
                $this->usuario_punto_encuentro_model->get_usuario($param["id_usuario"]);
		}
		$this->response($response);
	}

}