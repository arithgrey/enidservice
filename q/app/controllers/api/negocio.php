<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Negocio extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model('negocio_model');
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("idusuario");
	}

	function index_GET()
	{

		$id_usuario = $this->id_usuario;
		$data["entregas_en_casa"] = $this->get_tipo_entregas($id_usuario);
		$this->load->view("negocio/principal", $data);

	}

	private function get_tipo_entregas($id_usuario)
	{
		$q["id_usuario"] = $id_usuario;
		return $this->app->api("usuario/entregas_en_casa", $q);
	}


}