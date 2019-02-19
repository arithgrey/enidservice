<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->library(lib_def());
	}

	function index()
	{

		$data = $this->principal->val_session("Solicita una llamada aquí");
		$data["meta_keywords"] = "Solicita una llamada aquí";
		$data["desc_web"] = "Solicita una llamada aquí";
		$data["url_img_post"] = create_url_preview("images_1.jpg");
		$data["departamentos"] = $this->get_departamentos_enid();
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
		$data["css"] = ["contact.css"];
		$param = $this->input->post();
		if (get_param_def($param, "proceso_compra", 0, 1) > 0) {

			$data["js"] = ["contact/proceso_compra_direccion.js"];
			$this->principal->show_data_page($data, 'preso_deseo_compra');
		} else {

			$this->load_ubicacion($data, $param);

		}
	}

	private function load_ubicacion($data, $param)
	{


		$data["telefono"] = ($data["id_usuario"] > 0) ? $this->principal->get_info_usuario($data["id_usuario"])[0]["tel_contacto"] : "";

		if ($data["in_session"] == 0 && get_param_def($param, "servicio", 0, 1) > 0) {


			$data["js"] = [
				"login/sha1.js",
				"contact/principal.js"
			];
			$data["servicio"] = $param["servicio"];
			$this->principal->show_data_page($data, 'preso_compra');


		} else {


			$param = $this->input->get();
			$ubicacion = exists_array_def($param, "ubicacion");
			$data["ubicacion"] = $ubicacion;
			$this->principal->show_data_page($data, 'home');
		}
	}

	private function get_departamentos_enid()
	{

		$api = "departamento/index/format/json/";
		return $this->principal->api($api);
	}

}