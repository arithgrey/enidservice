<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class recordatorio extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("recordatorio_model");
		$this->load->library(lib_def());
	}

	function index_GET()
	{
		$response = false;
		$param = $this->get();
		if (fx($param, "id_recibo")) {
			$response = $this->recordatorio_model->get_complete($param["id_recibo"]);
		}
		$this->response($response);
	}

	function index_POST()
	{
		$response = false;
		$param = $this->post();
		if (fx($param, "fecha_cordatorio,horario_entrega,recibo,tipo,descripcion")) {

			$params = [
				"fecha_cordatorio" =>  $param["fecha_cordatorio"] . " " . $param["horario_entrega"] . ":00",
				"id_recibo" => $param["recibo"],
				"id_tipo" => $param["tipo"],
				"descripcion" => $param["descripcion"],
				"id_usuario" => $this->app->get_session("idusuario")

			];
			$response = $this->recordatorio_model->insert($params);
		}
		$this->response($response);
	}

	function status_PUT()
	{
		$response = false;
		$param = $this->put();
		if (fx($param, "id_recordatorio,status")) {
			$response = $this->recordatorio_model->q_up("status", $param["status"], $param["id_recordatorio"]);
		}
		$this->response($response);
	}
	function  usuario_GET(){

		$param      =  $this->get();
		$response   =  false;
		if (fx($param, "id_usuario")){
			$in  = ["id_usuario" =>  $param["id_usuario"] , "status" => 0];
			$response =  $this->recordatorio_model->get([], $in, 10, 'fecha_registro', 'ASC');
		}
		$this->response($response);

	}
}