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
		$this->id_usuario = $this->app->get_session("idusuario");
	}

	function estado_PUT()
	{

		$param = $this->put();
		$response = false;
		if (fx($param, "nuevo_valor,id_tarea")) {
			$response = $this->tareasmodel->update_estado_tarea($param);
		}
		$this->response($response);
	}

    function descripcion_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "descripcion,id_tarea")) {
            $response = $this->tareasmodel->q_up("descripcion" , $param["descripcion"] , $param["id_tarea"]);
        }
        $this->response($response);
    }


    function index_POST()
	{

		$param = $this->post();
		$response = false;
		if (fx($param, "tarea,id_ticket")) {
			$param["id_usuario"] = $this->app->get_session("idusuario");

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
        if (fx($param, "id_tarea")) {

            $response = $this->tareasmodel->q_delete($param["id_tarea"]);

        }
        $this->response($response);
    }

	private function set_stado_ticket($q)
	{

		$api = "tickets/estado";
		return $this->app->api($api, $q, "json", "PUT");

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
		if (fx($param, "tarea,id_ticket,id_usuario")) {
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
		if (fx($param, "id_ticket")) {

			$response = $this->clean($this->tareasmodel->get_tareas_ticket($param));
		}
		$this->response($response);
	}

	function tareas_ticket_num_GET()
	{

		$this->response($this->tareasmodel->get_tareas_ticket_num($this->get()));
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


			$list[] = [
				"id_tarea" => $row["id_tarea"],
				"descripcion" =>
                    str_replace("-", "", $this->security->entity_decode($row["descripcion"])),
				"fecha_registro" => $row["fecha_registro"],
				"status" => $row["status"],
				"id_ticket" => $row["id_ticket"],
				"fecha_termino" => $row["fecha_termino"],
				"usuario_registro" => $row["usuario_registro"],
				"idusuario" => $row["idusuario"],
				"nombre" => $row["nombre"],
				"apellido_paterno" => $row["apellido_paterno"],
				"apellido_materno" => $row["apellido_materno"],
				"num_comentarios" => $row["num_comentarios"]
			];

			$a++;
		}
		return $list;
	}

}