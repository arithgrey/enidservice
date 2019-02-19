<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class metakeyword_usuario extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("metakeyword_usuario_model");
		$this->load->library(lib_def());
	}
	/*
	function metakeyword_usuario_POST(){

		if($this->input->is_ajax_request()){

		  $param                        =   $this->post();
		  $param["id_usuario"]          =   $this->id_usuario;
		  $param["metakeyword_usuario"] =   remove_comma($param["metakeyword_usuario"]);
		  $response["add"]              =   $this->agrega_metakeyword->agrega_metakeyword($param);
		  $response["add_catalogo"] =
		  $this->serviciosmodel->agrega_metakeyword_catalogo($param);
		  $this->response($response);

		}
	}
	*/

}