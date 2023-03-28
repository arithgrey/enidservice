<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class lead_producto extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("lead_producto_model");
		$this->load->library(lib_def());
	}
	function index_POST()
	{
		$param = $this->post();
		$response = false;
		
		if (fx($param, "email,password,nombre")) {
            
			$params = [
                "nombre" => $param["nombre"],
				"email" => $param["email"],
				"password" => $param["password"],				
			];

            
			$response = $this->lead_producto_model->insert($params, 1);

		}
		$this->response($response);
	}
    function id_PUT()
	{
		$param = $this->put();
		$response = false;
		
		if (fx($param, "id,ubicacion,telefono")) {
            
            $id = $param["id"];
			$params = [
				"ubicacion" => $param["ubicacion"],
				"telefono" => $param["telefono"]
			];
            
			$response = $this->lead_producto_model->update($params,  ["id" => $id]);

		}
		$this->response($response);
	}
}