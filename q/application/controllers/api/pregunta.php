<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class pregunta extends REST_Controller
{
	private $id_usuario;

	function __construct()
	{
		parent::__construct();
		$this->load->helper("pregunta");
		$this->load->model("pregunta_model");
		$this->load->library(lib_def());
	}

	function visto_pregunta_PUT()
	{

		$param = $this->put();
		$response = false;
		if (if_ext($param, "id_pregunta,modalidad")) {
			$response = $this->pregunta_model->set_visto_pregunta($param);
		}
		$this->response($response);
	}

	function index_POST()
	{

		$param = $this->post();
		$response["in_session"] = 0;
		if ($this->principal->is_logged_in()) {
			$response = false;
			$param["usuario"] = $this->principal->get_session("idusuario");
			if (if_ext($param, 'pregunta,usuario,servicio')) {

				$id_servicio = $param["servicio"];
				$usuario = $this->get_usuario_servicio($id_servicio);
				$id_vendedor = $usuario[0]["id_usuario"];
				$pregunta = $param["pregunta"];
				$id_usuario = $param["usuario"];

				$q =
					["pregunta" => $pregunta,
						"id_usuario" => $id_usuario,
						"id_servicio" => $id_servicio,
						"id_vendedor" => $id_vendedor
					];
				$id_pregunta = $this->pregunta_model->insert($q, 1);

				if ($id_pregunta > 0) {

					$this->notifica_vendedor($usuario);
				}
			}
		}
		$this->response($response);
	}

	private function get_usuario_servicio($id_servicio)
	{
		$q["id_servicio"] = $id_servicio;
		$api = "usuario/usuario_servicio/format/json/";
		return $this->principal->api($api, $q);
	}

	private function notifica_vendedor($usuario)
	{
		$sender = get_notificacion_pregunta($usuario);
		$this->principal->send_email_enid($sender);

	}

	function periodo_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "fecha_inicio,fecha_termino")) {
			$response = $this->pregunta_model->num_periodo($param);
		}
		$this->response($response);
	}

	function buzon_GET()
	{

		$param = $this->get();
		$param["id_usuario"] = $this->principal->get_session("idusuario");

		$data_complete["modalidad"] = $param["modalidad"];
		/*Consulta preguntas hechas con proposito de compras*/
		if ($param["modalidad"] == 1) {
			$preguntas =
				$this->pregunta_model->get_preguntas_realizadas_a_vendedor($param);
			$data_complete["preguntas"] = $this->add_num_respuestas_preguntas($preguntas);

		} else {

			$preguntas = $this->pregunta_model->get_preguntas_realizadas($param);
			$data_complete["preguntas"] = $this->add_num_respuestas_preguntas($preguntas);
		}
		$this->load->view("valoraciones/preguntas", $data_complete);
	}

	function add_num_respuestas_preguntas($data)
	{

		$response = [];
		$a = 0;
		foreach ($data as $row) {
			$response[$a] = $row;
			$response[$a]["respuestas"] = $this->get_num_respuestas_sin_leer($row["id_pregunta"]);
			$a++;
		}
		return $response;
	}

	private function get_num_respuestas_sin_leer($id_pregunta)
	{

		$q["id_pregunta"] = $id_pregunta;
		$api = "respuesta/num_respuestas_sin_leer/format/json/";
		return $this->principal->api($api, $q);
	}

	function preguntas_sin_leer_GET()
	{

		$param = $this->get();
		$param["id_usuario"] = $this->principal->get_session("idusuario");

		if ($param["modalidad"] == 1) {

			if (!isset($param["id_usuario"])) {
				$param["id_usuario"] = $this->principal->get_session("idusuario");
			}
			/*Modo vendedor*/
			$data_complete["modo_vendedor"] =
				$this->pregunta_model->get_preguntas_sin_leer_vendedor($param)[0]["num"];
			/*Modo cliente*/
			$data_complete["modo_cliente"] =
				$this->pregunta_model->get_respuestas_sin_leer($param);

			$this->response($data_complete);
		}
		$this->response("");
	}

	function usuario_por_pregunta_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_pregunta")) {
			$usuario = $this->pregunta_model->get_usuario_por_id_pregunta($param);
			$response = $usuario[0]["id_usuario"];
		}
		$this->response($response);
	}

	function vendedor_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_vendedor")) {

			$id_vendedor = $param["id_vendedor"];

			$in = [
				"id_vendedor" => $id_vendedor,
				"status" => 0
			];
			if (array_key_exists("recepcion" , $param)){
				$in = [
					"id_vendedor" => $id_vendedor
				];
			}


			if (array_key_exists("id_pregunta" , $param)){

				$in["id_pregunta"] =  $param["id_pregunta"];
			}


			$limit =  (array_key_exists("recepcion" , $param)) ? 30 : 5;

			$response = $this->pregunta_model->get([], $in, $limit, 'fecha_registro', 'DESC');

		}
		$this->response($response);

	}
	function cliente_GET()
	{
		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_usuario")) {

			$id_usuario = $param["id_usuario"];
			$in = [
				"id_usuario" => $id_usuario,
				"status" => 0
			];

			$response = $this->pregunta_model->get([], $in, 50, 'fecha_registro', 'DESC');

		}
		$this->response($response);

	}


}