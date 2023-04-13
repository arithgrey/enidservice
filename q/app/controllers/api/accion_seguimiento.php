<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class accion_seguimiento extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("accion_seguimiento_model");
        $this->load->library(lib_def());
    }

    function index_GET()
    {
                
        $this->response($this->accion_seguimiento_model->get([], [], 100,'fecha_registro'));
    }
    /*
    function index_PUT()
	{
		$param = $this->put();
		$response = false;
		
		if (fx($param, "")) {
            
            $id = $param["id"];
			$params = [
				"" => $param[""],
				"" => $param[""]
			];

            
			$response = $this->accion_seguimiento_model->update($params,  ["id" => $id]);

		}
		$this->response($response);
	}

    function index_DELETE()
	{
		$param = $this->delete();
		$response = false;
		
		if (fx($param, "id")) {
            
            $id = $param["id"];
			        
			$response = $this->accion_seguimiento_model->delete(["id" => $id]);

		}
		$this->response($response);
	}
    function id_GET()
    {
        $param = $this->get();
		$response = false;
		

        if (fx($param, "id")) {
            
            $id = $param["id"];
            $response = $this->response($this->accion_seguimiento_model->q_get($id));
        }
        $this->response($response);
    }
    function index_POST()
	{
		$param = $this->post();
		$response = false;
		
		if (fx($param, "")) {
            
			$params = [
				"" => $param[""],
				"" => $param[""],				
			];

            
			$response = $this->accion_seguimiento_model->insert($params, 1);

		}
		$this->response($response);
	}
    */
}
