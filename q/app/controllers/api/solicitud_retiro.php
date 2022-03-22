<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class solicitud_retiro extends REST_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model("solicitud_retiro_model");
		$this->load->library(lib_def());
	}

	function index_POST()
	{
		$param = $this->post();
		$response = false;

		if (fx($param, "id_cuenta_pago,id_usuario,ultima_orden_compra,monto")) {

	
			$id_cuenta_pago = $param["id_cuenta_pago"];
			$id_usuario = $param["id_usuario"];
			$ultima_orden_compra = $param["ultima_orden_compra"];
			$monto = $param["monto"];

			$cuenta_usuario = $this->ultima_solicitud_usuario($id_usuario);		

			if (es_data($cuenta_usuario)) {
					
				$params =  [ 
					"id_cuenta_pago" => $id_cuenta_pago,
					"user_id" => $id_usuario,					
					"monto" => $monto,
					"ultima_orden_compra" => $ultima_orden_compra            		

				];

				$response = $this->solicitud_retiro_model->update($params , 
					[
						"status" => 0, 
            			"user_id" => $id_usuario            		
					] 
				);

			}else{

				$params =  [ 
					"id_cuenta_pago" => $id_cuenta_pago,
					"user_id" => $id_usuario,					
					"monto" => $monto,
					"ultima_orden_compra" => $ultima_orden_compra            		
				];
				
				$response = $this->solicitud_retiro_model->insert($params , 1 );
				
			}
			
		
		}
		$this->response($response);


	}
	function usuario_PUT()
	{

		$param = $this->put();
		$response = false;

		if (fx($param, "id_usuario")) {


			$id_usuario = $param["id_usuario"];
			$response = $this->solicitud_retiro_model->update(
				[
					"status" => 1 
				], 
				[
					"user_id" => $id_usuario ,
					"status" => 0 
				], 
				10
			);
		}
		$this->response($response);

	}

	function id_GET(){
		
		$param = $this->get();
		$response  =  false;
		if (fx($param, "id_usuario")) {
					
			$id_usuario = $param["id_usuario"];
        	$response = $this->ultima_solicitud_usuario($id_usuario);		

    	}
    	$this->response($response);
    	
        
	}
	private function ultima_solicitud_usuario($id_usuario){
	

        return $this->solicitud_retiro_model->get(
            	[], 
            	[
            		"status" => 0, 
            		"user_id" => $id_usuario            		
            	], 
            1);		
        
	}
}