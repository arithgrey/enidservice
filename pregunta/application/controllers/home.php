<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("validador");
		$this->load->library(lib_def());

	}

	function index()
	{

		$param = $this->input->get();
		if (array_key_exists("tag", $param)) {

			$this->get_form();

		} else {

			$this->get_listado();

		}
	}

	private function get_form()
	{

		$data = $this->principal->val_session("");
		$data["meta_keywords"] = '';
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("formas_pago_enid.png");
		$servicio = $this->input->get("tag");

		if ($servicio > 0 && ctype_digit($servicio)) {

			$send["in_session"] = $this->principal->is_logged_in();
			if ($send["in_session"] === false) {

				$session_data = [
					"servicio_pregunta" => $servicio

				];
				$this->principal->set_userdata($session_data);
				redirect("../../login");


			} else {

				$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
				$send["id_servicio"] = $servicio;
				$send["id_usuario"] = ($send["in_session"] == 1) ? $this->principal->get_session("idusuario") : 0;
				$formulario_valoracion = $this->carga_formulario_valoracion($send);
				$data["in_session"] = $this->principal->is_logged_in();
				$data["id_servicio"] = $servicio;
				$data["js"] = ["pregunta/principal.js"];
				$data["css"] = ["producto.css", "sugerencias.css", "valoracion.css"];

				$response =  get_view_pregunta($formulario_valoracion, $send["id_servicio"]);

				$this->principal->show_data_page(
					$data,
					$response ,
					1);
			}


		} else {
			header("location:../?q2=0&q=");
		}
	}

	private function carga_formulario_valoracion($q)
	{

		$api = "valoracion/pregunta_consumudor_form/format/json/";
		return $this->principal->api($api, $q);
	}

	private function get_listado()
	{

		$param = $this->input->get();
		$data = $this->principal->val_session("");
		$id_usuario = $data["id_usuario"];

		if (array_key_exists("action", $param) && $data["in_session"] > 0) {

			$action = $param["action"];
			$id_pregunta = (array_key_exists("id", $param) && $param["id"] > 0) ? $param["id"] : 0;
			switch ($action) {

				case "hechas":

					$this->get_hechas($id_usuario, $data, $id_pregunta);
					break;
				case "recepcion":

					$this->get_recibidas($id_usuario, $data, $id_pregunta);

					break;
				case 2:

					break;
			}


		} else {

			header("location:../?q2=0&q=");

		}
	}

	private function get_hechas($id_usuario, $data , $id_pregunta)
	{

		$preguntas = $this->get_preguntas_hechas_cliente($id_usuario, $id_pregunta);

		$data["preguntas_format"] = get_format_preguntas($preguntas , 0);
		$data["meta_keywords"] = '';
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("");
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
		$data["js"] = ["js/summernote.js", "pregunta/listado.js"];
		$data["css"] = ["pregunta_listado.css",  "summernote.css"];


		$response=  get_format_listado(get_format_preguntas($preguntas, 0));

		$this->principal->show_data_page($data, $response , 1);


	}

	function get_preguntas_hechas_cliente($id_usuario, $id_pregunta)
	{


		$q["id_pregunta"] = $id_pregunta;
		$q["id_usuario"] = $id_usuario;
		$q["recepcion"] = 1;
		$q["num_respuesta"] = 1;

		$api = "pregunta/cliente/format/json/";
		return $this->principal->api($api, $q);

	}

	private function get_recibidas($id_usuario, $data, $id_pregunta)
	{

		$preguntas = $this->get_preguntas_recibidas_vendedor($id_usuario, $id_pregunta);

		$data["meta_keywords"] = '';
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("");
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();

		$data["js"] = ["js/summernote.js", "pregunta/listado.js"];
		$data["css"] = ["pregunta_listado.css", "summernote.css"];

		$response=  get_format_listado(get_format_preguntas($preguntas, 1));
		$this->principal->show_data_page($data, $response , 1);



	}
	private function get_preguntas_recibidas_vendedor($id_usuario, $id_pregunta)
	{


		$q["id_pregunta"] = $id_pregunta;
		$q["id_vendedor"] = $id_usuario;
		$q["recepcion"] = 1;
		$q["num_respuesta"] = 1;
		$api = "pregunta/vendedor/format/json/";
		return $this->principal->api($api, $q);

	}


}