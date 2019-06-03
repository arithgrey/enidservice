<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tarea extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->model("tareasmodel");
		$this->load->library(lib_def());
		$this->id_usuario = $this->principal->get_session("idusuario");
	}

	function estado_PUT()
	{

		$param = $this->put();
		$response = false;
		if (if_ext($param, "nuevo_valor,id_tarea")) {
			$response = $this->tareasmodel->update_estado_tarea($param);
		}
		$this->response($response);
	}

    function descripcion_PUT()
    {

        $param = $this->put();
        $response = false;
        if (if_ext($param, "descripcion,id_tarea")) {
            $response = $this->tareasmodel->q_up("descripcion" , $param["descripcion"] , $param["id_tarea"]);
        }
        $this->response($response);
    }


    function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "tarea,id_ticket")) {
			$param["id_usuario"] = $this->principal->get_session("idusuario");

			if ($param["id_usuario"] > 0) {
				$params = [
					"descripcion" => $param["tarea"],
					"id_ticket" => $param["id_ticket"],
					"usuario_registro" => $param["id_usuario"]
				];

				$response = $this->tareasmodel->insert($params);

				if ($response == true) {
					$this->set_stado_ticket($this->valida_tareas_pendientes($param));
				}
			}
		}
		$this->response($response);
	}

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (if_ext($param, "id_tarea")) {

            $response = $this->tareasmodel->q_delete($param["id_tarea"]);

        }
        $this->response($response);
    }

	private function set_stado_ticket($q)
	{

		$api = "tickets/estado";
		return $this->principal->api($api, $q, "json", "PUT");

	}

	private function valida_tareas_pendientes($param)
	{

		$num_pendientes = $this->tareasmodel->get_tareas_ticket_num($param)[0]["pendientes"];
		$status = ($num_pendientes > 0) ? 0 : 1;
		$q = [
			"status" => $status,
			"id_ticket" => $param["id_ticket"],
			"num_tareas" => $num_pendientes
		];
		return $q;
	}

	function buzon_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "tarea,id_ticket,id_usuario")) {
			$params = [
				"descripcion" => $param["tarea"],
				"id_ticket" => $param["id_ticket"],
				"usuario_registro" => $param["id_usuario"]
			];
			$response = $this->tareasmodel->insert($params);
		}
		$this->response($response);
	}

	function ticket_GET()
	{

		$param = $this->get();
		$response = [];
		if (if_ext($param, "id_ticket")) {
			$response = $this->tareasmodel->get_tareas_ticket($param);
			$response = $this->clean($response);
			try {
				$response = $this->cleanTagsInArray($response);
			} catch (Exception $e) {

			}
		}
		$this->response($response);
	}

	function cleanTagsInArray(array $input, $easy = false, $throwByFoundObject = true)
	{
		if ($easy) {
			$output = array_map(function ($v) {
				return trim(strip_tags($v));
			}, $input);
		} else {
			$output = $input;
			foreach ($output as $key => $value) {
				if (is_string($value)) {
					$output[$key] = trim(strip_tags(html_entity_decode($value)));
				} elseif (is_array($value)) {
					$output[$key] = self::cleanTagsInArray($value);
				} elseif (is_object($value) && $throwByFoundObject) {

					throw new Exception('Object found in Array by key ' . $key);
				}
			}
		}
		return $output;
	}

	function tareas_ticket_num_GET()
	{

		$param = $this->get();
		$response = $this->tareasmodel->get_tareas_ticket_num($param);
		$this->response($response);
	}

	function tareas_enid_service_GET()
	{

		$param = $this->get();
		$response = $this->tareasmodel->tareas_enid_service($param);
		$this->response($response);
	}

	private function clean($array)
	{

		$list = [];
		$a = 0;
		foreach ($array as $row) {

			$descripcion = strip_tags(trim($row["descripcion"]));
			$descripcion = str_replace("-", "", $descripcion);
			$list[] = [
				"id_tarea" => $row["id_tarea"],
				"descripcion" => utf8_encode($descripcion),
				"fecha_registro" => $row["fecha_registro"],
				"status" => $row["status"],
				"id_ticket" => $row["id_ticket"],
				"fecha_termino" => $row["fecha_termino"],
				"usuario_registro" => $row["usuario_registro"],
				"idusuario" => $row["idusuario"],
				"nombre" => strip_tags(trim($row["nombre"])),
				"apellido_paterno" => $row["apellido_paterno"],
				"apellido_materno" => $row["apellido_materno"],
				"num_comentarios" => $row["num_comentarios"]
			];

			$a++;
		}
		return $list;
	}
	/*
	private function get_pendientes_ticket($q){

		$api    = "tickets/num/format/json/";
		return  $this->principal->api($api , $q);

	}
	*/
}