<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Respon extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();

		$this->load->helper("respuesta");
		$this->load->model("response_model");
		$this->load->library(lib_def());
		$this->id_usuario = $this->app->get_session("id_usuario");
	}

	function pregunta_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "id_pregunta,v,es_vendedor")) {
			$id_pregunta = $param["id_pregunta"];
			$response = $this->response_model->get_respuestas_pregunta($id_pregunta);
			$es_vendedor = $param["es_vendedor"];

			if ($param["v"] > 0) {

				$response = get_format_listado($response, $id_pregunta, $es_vendedor);
			}
			if ($es_vendedor < 1){

				$this->notifica_lectura_cliente($this->id_usuario , $id_pregunta);

			}
		}
		$this->response($response);
	}

	function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "id_pregunta,respuesta,es_vendedor")) {
			$es_vendedor  =  $param["es_vendedor"];
			$id_pregunta = $param["id_pregunta"];

			$params = [
				"respuesta" => $param["respuesta"],
				"id_pregunta" => $id_pregunta,
				"id_usuario" => $this->id_usuario
			];


			$response = $this->response_model->insert($params);
			if ($response == true) {


				$this->notifica_respuesta($id_pregunta, $es_vendedor);

			}

		}
		$this->response($response);
	}

	private function notifica_respuesta($id_pregunta, $es_vendedor)
	{

        $q = [
            "id_pregunta" => $id_pregunta,
            "es_vendedor" => $es_vendedor,

        ];
		return $this->app->api("pregunta/noficacion_respuesta", $q, "json", "POST");

	}
	private function notifica_lectura_cliente($id_usuario, $id_pregunta)
	{

	    $q = [
            "id_pregunta" => $id_pregunta,
            "id_usuario" => $id_usuario,
        ];

		return $this->app->api("pregunta/notifica_lectura_cliente", $q, "json", "PUT");

	}

}