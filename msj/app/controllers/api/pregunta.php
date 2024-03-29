<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Pregunta extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(lib_def());
	}

	function respuesta_vendedor_GET()
	{


		$param = $this->get();
		$id_pregunta = $param["pregunta"];
		$id_usuario = $this->get_id_usuario_por_pregunta($id_pregunta);
		$usuario = $this->app->usuario($id_usuario);

		if (count($usuario) > 0) {

			$email_cliente = $usuario[0]["email"];
			$prm_email["info_correo"] = $this->crea_vista_notificacion_respuesta($usuario);
			$prm_email["asunto"] =
				"Notificación, un nuevo cliente te ha enviado una pregunta, apresúrate!";
			$this->envia_email($prm_email, $email_cliente);
			$this->response(1);

		} else {
			$this->response("No se envió el mensaje");
		}

	}

	function pregunta_vendedor_GET()
	{

		$param = $this->get();
		$response = false;

		if (fx($param, "servicio")) {
			$prm = $this->get_info_vendedor_por_servicio($param["servicio"]);
			$response = "No se envió el mensaje";
			if (count($prm) > 0) {
				$email_vendedor = $prm[0]["email"];
				$prm_email["info_correo"] = $this->crea_vista_notificacion_pregunta($prm);
				$prm_email["asunto"] = "Notificación, un nuevo cliente te ha enviado una pregunta, apresúrate!";
				$this->envia_email($prm_email, $email_vendedor);
				$response = true;
			}
		}

		$this->response($response);
	}

	private function envia_email($param, $email_a_quien_se_envia)
	{
		$this->mensajeria_lead->notificacion_email($param, $email_a_quien_se_envia);
	}

	private function crea_vista_notificacion_pregunta($q)
	{
		$api = "presentacion/notificacion_duda_vendedor/format/html/";
		return $this->app->api($api, $q, "html");
	}

	private function crea_vista_notificacion_respuesta($q)
	{

		$api = "presentacion/notificacion_respuesta_a_cliente/format/html/";
		return $this->app->api($api, $q, "html");
	}

	private function get_info_vendedor_por_servicio($id_servicio)
	{

		$q["id_servicio"] = $id_servicio;
		$api = "usuario/usuario_servicio/";
		return $this->app->api($api, $q);
	}

	private function get_id_usuario_por_pregunta($id_pregunta)
	{

		$q["id_pregunta"] = $id_pregunta;
		$api = "pregunta/usuario_por_pregunta/";
		return $this->app->api($api, $q);
	}
}