<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class mas_vendido extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("mas_vendido_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{
		$param = $this->post();
		$response = false;
		
		if (fx($param, "menu,sub_menu,path")) {
            
			$params = [
				"menu" => $param["menu"],
				"sub_menu" => $param["sub_menu"],
				"path" => $param["path"]
			];

            
			$response = $this->mas_vendido_model->insert($params, 1);

		}
		$this->response($response);
	}
    function index_PUT()
	{
		$param = $this->put();
		$response = false;
		
		if (fx($param, "id_mas_vendido,menu,sub_menu,path")) {
            
            $id = $param["id_mas_vendido"];
			$params = [
				"menu" => $param["menu"],
				"sub_menu" => $param["sub_menu"],
				"path" => $param["path"]
			];

            
			$response = $this->mas_vendido_model->update($params,  ["id" => $id]);

		}
		$this->response($response);
	}

  
    function publicos_GET()
    {
    
        $this->response(
            $this->mas_vendido_model->get(
                [],["status" => 1],100));
    }
    function id_GET()
    {
        $param = $this->get();
		$response = false;
		

        if (fx($param, "id")) {
            
            $id = $param["id"];
            $response = $this->response($this->mas_vendido_model->q_get($id));
        }
        $this->response($response);
    }

    

}