<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Talla extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("talla_model");
		$this->load->library(lib_def());
	}

	function id_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id")) {

			$response = $this->talla_model->q_get(["id_talla", "talla", "id_country"], $param["id"]);

		}
		$this->response($response);

	}

	function clasificacion_GET()
	{

		$this->response($this->talla_model->get(["id", "tipo", "clasificacion"], [], 10));

	}

	function tallas_countries_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_tipo_talla")) {

			$response = $this->talla_model->get_tallas_countries($param);
		}
		$this->response($response);
	}
	/*
	function tipo_talla_id_GET(){
  
	  $param        =   $this->get();
	  $response     =   $this->talla_model->get_tipo_talla($param);
	  $this->response($response);
  
	}
	function get_tipo_talla($q){
		$q["info"]  = 1;
		$api        =  "tipo_talla/index/format/json/";
		return      $this->app->api( $api, $q);
	}
	*/
	/*
	function clasificacion_PUT(){

	  $param        =   $this->put();
	  $response     =   false;
	  if (fx($param , "id")){
		  $response     = $this->talla_model->q_up("clasificacion" ,  $param["clasificaciones"] ,  $param["id"]);
	  }
	  $this->response($response);
	}
	*/

}