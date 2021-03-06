<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class direccion extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("direccion_model");
		$this->load->library(lib_def());
	}

	function data_direccion_GET()
	{
		$param = $this->get();
		$response = [];
		if (fx($param, "id_direccion")) {

			$response = $this->direccion_model->get_data_direccion($param["id_direccion"]);

		}
		$this->response($response);
	}

	function index_POST()
	{
		$param = $this->post();
		$response = false;
		$receptor = prm_def($param, "nombre_receptor", "");
		$tel_receptor = prm_def($param, "telefono_receptor", 0);

		if (fx($param, "calle,referencia,numero_exterior,numero_interior,id_codigo_postal")) {
			$params = [
				"calle" => $param["calle"],
				"entre_calles" => $param["referencia"],
				"numero_exterior" => $param["numero_exterior"],
				"numero_interior" => $param["numero_interior"],
				"id_codigo_postal" => $param["id_codigo_postal"],
				"nombre_receptor" => $receptor,
				"telefono_receptor" => $tel_receptor
			];
			$response = $this->direccion_model->insert($params, 1);

		}
		$this->response($response);
	}
    function ids_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "ids")) {

            $response = $this->direccion_model->in($param['ids']);

        }
        $this->response($response);
    }

}