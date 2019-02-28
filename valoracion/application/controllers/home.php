<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library(lib_def());
	}

	function index()
	{

		$data = $this->principal->val_session("");
		$data["meta_keywords"] = '';
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("formas_pago_enid.png");

		$servicio = $this->input->get("servicio");
		if ($servicio > 0 && ctype_digit($servicio)) {

			$param = $this->input->get();

			$clasificaciones_departamentos = $this->principal->get_departamentos();
			$data["clasificaciones_departamentos"] = $clasificaciones_departamentos;


			$prm["in_session"] = 0;
			$prm["id_usuario"] = 0;
			if ($data["in_session"] == 1) {

				$prm["in_session"] = 1;
				$prm["email"] = $data["email"];
				$prm["nombre"] = $data["nombre"];
				$prm["id_usuario"] = $data["id_usuario"];
			}

			$prm["id_servicio"] = $servicio;
			$data["formulario_valoracion"] = $this->carga_formulario_valoracion($prm);
			$data["css"] = ["valoracion_servicio.css"];
			$data["js"] = ["valoracion/principal.js"];
			$this->principal->show_data_page($data, 'home');
		} else {
			header("location:../?q2=0&q=");
		}
	}

	private function carga_formulario_valoracion($q)
	{

		$api = "valoracion/valoracion_form/format/json/";
		return $this->principal->api($api, $q, "html");

	}
}