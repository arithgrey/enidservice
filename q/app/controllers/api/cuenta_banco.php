<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class cuenta_banco extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("cuenta_banco_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{
		$param = $this->post();
		$response = false;
		
		if (fx($param, "id_usuario,id_cuenta_banco,propietario_tarjeta,numero_tarjeta,banco")) {

			$id_usuario = $param["id_usuario"];
			$propietario_tarjeta = $param["propietario_tarjeta"];
			$numero_tarjeta = $param["numero_tarjeta"];
			$banco = $param["banco"];

			$cuenta_usuario = $this->cuenta_usuario($id_usuario);			
			if (es_data($cuenta_usuario)) {
					
				$params =  [ 
					"propietario_tarjeta" => $propietario_tarjeta,
					"numero_tarjeta" => $numero_tarjeta,
					"id_banco" => $banco
				];

				$response = $this->cuenta_banco_model->update($params , 
					[
						"id" =>  $param["id_cuenta_banco"] 
					] 
				);

			}else{

				$params = [
					"propietario_tarjeta" => $propietario_tarjeta,
					"id_usuario" => $id_usuario,
					"numero_tarjeta" => $numero_tarjeta,
					"id_banco" => $banco,					
				];
				
				$response = $this->cuenta_banco_model->insert($params , 1 );
				
			}
			
		
		}
		$this->response($response);


	}

	function id_GET()
	{

		$param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->cuenta_usuario($param["id_usuario"]);

        }
        $this->response($response);

	}

	private function cuenta_usuario($id_usuario){
	

        return $this->cuenta_banco_model->get(
            	[], 
            	[
            		"user_id" => $id_usuario,
            		"status" => 1,
            	], 
            1);		
        
	}
}