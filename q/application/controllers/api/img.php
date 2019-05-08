<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Img extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model("img_model");
		$this->load->helper("img");
		$this->load->library(lib_def());
	}

	function index_DELETE()
	{

		$param = $this->delete();
		$response = false;
		if (if_ext($param, "id_imagen")) {
			$response = [];
			if ($param["id_imagen"] > 0) {
				$params = ['idimagen' => $param["id_imagen"]];
				$response = $this->img_model->delete($params);
			}
		}
		$this->response($response);
	}

	function imgs_servicio_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_servicio")) {
			$response = $this->img_model->get_imagenes_por_servicio($param);
		}
		$this->response($response);
	}

	function form_faq_GET()
	{

		$param = $this->get();
		$response =  get_format_faq($param["id_faq"]);
		$this->response($response);
	}

	function form_img_user_GET()
	{

		$param = $this->get();
		$response = form_img_usuario();
		$this->response($response);

	}

	function form_img_servicio_producto_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_servicio")) {

			$response = form_img("servicio", "servicio", $param["id_servicio"]);
		}
		$this->response($response);
	}

	function imagen_servicio_DELETE()
	{

		$param = $this->delete();
		$response = $this->img_model->delete_imagen_servicio($param);
		$this->response($response);

	}

	function img_faq_GE()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id")) {
			$id = $param["id"];
			$response = $this->img_model->get_img_faq($id);
		}
		$this->response($response);
	}

	function id_GET()
	{

		$param = $this->get();
		$response = false;
		if (if_ext($param, "id_imagen")) {
			$response = $this->img_model->q_get(["img"], $param["id_imagen"]);
		}
		$this->response($response);
	}
}