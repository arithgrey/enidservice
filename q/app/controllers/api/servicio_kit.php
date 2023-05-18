<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class servicio_kit extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("servicio_kit_model");
		$this->load->library(lib_def());
	}	
    function servicios_por_kit_GET()
	{
        $param = $this->get();
        $response = false;
        if (fx($param, "id_kit")) {

            $response = $this->servicio_kit_model->get([], ["id_kit" => $param["id_kit"]],100);

        }
        $this->response($response);

	}
    function index_POST()
	{
		$param = $this->post();
		$response = false;
		
		if (fx($param, "id_kit,id_servicio")) {
            
			$params = [
				"id_kit" => $param["id_kit"],
				"id_servicio" => $param["id_servicio"],				
			];

            
			$response = $this->servicio_kit_model->insert($params, 1);

		}
		$this->response($response);
	}
    

    /*
    function index_GET()
	{
        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {
q
            $response = $this->servicio_kit_model->get([], ["id" => $param["id"]],100);

        }
        $this->response($response);

	}

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

            
			$response = $this->servicio_kit_model->update($params,  ["id" => $id]);

		}
		$this->response($response);
	}

    function index_DELETE()
	{
		$param = $this->delete();
		$response = false;
		
		if (fx($param, "id")) {
            
            $id = $param["id"];
			        
			$response = $this->servicio_kit_model->delete(["id" => $id]);

		}
		$this->response($response);
	}
    function id_GET()
    {
        $param = $this->get();
		$response = false;
		

        if (fx($param, "id")) {
            
            $id = $param["id"];
            $response = $this->response($this->servicio_kit_model->q_get($id));
        }
        $this->response($response);
    }
    */
    

}