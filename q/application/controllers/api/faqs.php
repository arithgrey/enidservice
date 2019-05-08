<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Faqs extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("base");
		$this->load->model("faqsmodel");
		$this->load->library(lib_def());
	}

	function id_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id")) {

			$response = $this->faqsmodel->q_get([], $param["id"]);
		}
		$this->response($response);
	}

	function qsearch_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_categoria,extra")) {

			$response = $this->faqsmodel->qsearch($param);

		}
		$this->response($response);
	}

	function search_GET()
	{
		$param = $this->get();
		$response = false;
		if (if_ext($param, "q")) {
			$response = $this->faqsmodel->search($param);
		}
		$this->response($response);
	}

	function respuesta_POST()
	{

		$param = $this->post();
		$response = false;
		if (if_ext($param, "editar_respuesta,id_faq,respuesta,categoria,titulo,status")) {
			$param["id_usuario"] = $this->principal->get_session("idusuario");
			$editar_respuesta = $param["editar_respuesta"];
			$id_faq = $param["id_faq"];
			$respuesta = $param["respuesta"];
			$categoria = $param["categoria"];
			$titulo = $param["titulo"];
			$status = $param["status"];
			$id_usuario = $param["id_usuario"];


			if ($editar_respuesta < 1) {
				$params = [
					"titulo" => $titulo,
					"respuesta" => $respuesta,
					"id_categoria" => $categoria,
					"status" => $status,
					"id_usuario" => $id_usuario
				];
				$response = $this->faqsmodel->insert($params, 1);
			} else {
				$params = [
					"titulo" => $titulo,
					"respuesta" => $respuesta,
					"id_categoria" => $categoria,
					"status" => $status
				];
				$this->faqsmodel->update($params, ["id_faq" => $id_faq]);
				$response  = $id_faq;

			}
		}
		$this->response($response);

	}

	function respuesta_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_faq")) {
			$response = $this->faqsmodel->get_respuesta($param);
		}
		$this->response($response);
	}

	function categorias_extras_GET()
	{

		$in_session = $this->principal->is_logged_in();
		$response = "";
		if ($in_session != false) {

			$perfil = $this->principal->getperfiles();
			switch ($perfil) {
				case 20:
					$categorias = $this->get_categorias_por_tipo(3);
					$response = lista_categorias($categorias);
					break;

				default:

					$r[] = lista_categorias($this->get_categorias_por_tipo(3));
					$r[] = lista_categorias($this->get_categorias_por_tipo(4));
					$response = append_data($r);
					break;

			}
		}

		$this->response($response);
	}

	private function get_categorias_por_tipo($tipo)
	{

		$q["tipo"] = $tipo;
		$api = "categoria/categorias_por_tipo/format/json/";
		return $this->principal->api($api, $q);
	}
}