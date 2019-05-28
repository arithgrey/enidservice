<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("recomendacion");
		$this->load->library(lib_def());
	}

	function index()
	{

		$param = $this->input->get();
		$val = get_param_def($param, "q");
		if (ctype_digit($val)) {


			$id_usuario = $this->input->get("q");
			$data = $this->principal->val_session();
			
			
			$prm["id_usuario"] = $id_usuario;
			$data["usuario"] = $this->principal->get_info_usuario($id_usuario);

			if (count($data["usuario"]) > 0) {

				$this->create_vista($data, $id_usuario, $prm);

			} else {

				$this->go_home();

			}
		} else {

			$this->go_home();
		}
	}

	private function create_vista($data, $id_usuario, $prm)
	{
		$data_recomendacion = $this->busqueda_recomendacion($prm);
		if ($data["in_session"] == 1) {
			$id_usuario_actual = $data["id_usuario"];
			$this->notifica_lectura($id_usuario, $id_usuario_actual);
		}
		$resumen_recomendacion = $data_recomendacion["info_valoraciones"];


		$prm["page"] = get_param_def($this->input->get(), "page");
		$prm["resultados_por_pagina"] = 5;
		$resumen_valoraciones_vendedor = $this->resumen_valoraciones_vendedor($prm);
		$prm["totales_elementos"] = $data_recomendacion["data"][0]["num_valoraciones"];

		$data["paginacion"] = "";
		if ($prm["totales_elementos"] > $prm["resultados_por_pagina"]) {

			$prm["per_page"] = 5;
			$prm["q"] = $id_usuario;
			$data["paginacion"] = $this->get_paginacion($prm);
		}


		$data = $this->principal->getCSSJs($data, "recomendacion_vista");

		$response = get_formar_recomendacion($data["usuario"],
			$resumen_recomendacion,
			$data["paginacion"],
			$resumen_valoraciones_vendedor
        );

		$this->principal->show_data_page($data, $response, 1);

	}

	private function busqueda_recomendacion($q)
	{
		$api = "valoracion/usuario/format/json/";
		return $this->principal->api($api, $q);
	}

	private function notifica_lectura($id_usuario, $id_usuario_valoracion)
	{

		if ($id_usuario == $id_usuario_valoracion) {
			$q["id_usuario"] = $id_usuario;
			$api = "valoracion/lectura/format/json/";
			$this->principal->api($api, $q, 'json', 'PUT');
		}
	}

	private function resumen_valoraciones_vendedor($q)
	{
		$api = "valoracion/resumen_valoraciones_vendedor/format/json/";
		return $this->principal->api($api, $q);
	}

	private function get_paginacion($q)
	{
		$api = "producto/paginacion/format/json/";
		return $this->principal->api($api, $q);
	}

	private function go_home()
	{
		redirect("../../", 'POST');
	}
}