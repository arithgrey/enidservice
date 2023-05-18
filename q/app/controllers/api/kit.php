<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

use Enid\Kits\Formato as Kits_servicio;

class kit extends REST_Controller
{
    private $kits_servicio;
    function __construct()
    {
        parent::__construct();
        $this->load->model("kit_model");
        $this->load->library(lib_def());
        $this->kits_servicio = new kits_servicio();
    }
    function index_GET()
    {
        $param = $this->get();
        $response = false;
        $response = $this->kit_model->get([], [], 100);
        $this->response($response);
    }
    function list_servicios_GET()
    {

        $kits_servicios = $this->kit_model->lista_servicios();
        $listado = $this->kits_servicio->listado($kits_servicios);
        $this->response($listado);
    }
    function index_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, "nombre")) {

            $params = [
                "nombre" => $param["nombre"],
            ];


            $response = $this->kit_model->insert($params, 1);
        }
        $this->response($response);
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

            
			$response = $this->kit_model->update($params,  ["id" => $id]);

		}
		$this->response($response);
	}

    function index_DELETE()
	{
		$param = $this->delete();
		$response = false;
		
		if (fx($param, "id")) {
            
            $id = $param["id"];
			        
			$response = $this->kit_model->delete(["id" => $id]);

		}
		$this->response($response);
	}
    function id_GET()
    {
        $param = $this->get();
		$response = false;
		

        if (fx($param, "id")) {
            
            $id = $param["id"];
            $response = $this->response($this->kit_model->q_get($id));
        }
        $this->response($response);
    }
    */
}
