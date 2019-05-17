<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("reporte");
		$this->load->library(lib_def());
		$this->principal->acceso();
	}

	function index()
	{
		$data = $this->principal->val_session("Métricas Enid Service");
		$num_perfil = $this->principal->getperfiles();
		$module = $this->module_redirect($num_perfil);

		if ($module != 1) {
			header($module);
		}

		$data["categorias_destacadas"] = $this->carga_categorias_destacadas();
		$data = $this->principal->getCssJs($data, "reporte_enid");
		$this->principal->show_data_page($data, 'empresas_enid');

	}
	private function module_redirect($num_perfil)
	{

		$module = 1;
		switch ($num_perfil) {
			case 5:
				$module = "location:../cargar_base";
				break;

			case 6:
				$module = "location:../tareas";
				break;

			case 7:
				$module = "location:../desarrollo";
				break;
			case 8:
				$module = "location:../desarrollo";
				break;

			case 11:
				$module = "location:../desarrollo";
				break;



			case 20:

				$module = "location:../area_cliente";

				break;

			default:

				break;
		}
		return $module;

	}

	private function carga_categorias_destacadas($q=[])
	{
		$api = "clasificacion/categorias_destacadas/format/json/";
		return $this->principal->api($api, $q);
	}

}