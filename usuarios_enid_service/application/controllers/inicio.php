<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("user");
		$this->load->library(lib_def());
		$this->principal->acceso();
	}

	function index()
	{

		$data = $this->principal->val_session("Grupo ventas - Enid Service - ");
		$num_perfil = $this->principal->getperfiles();
		if ($num_perfil == 20) {
			header("location:".path_enid("area_cliente"));
		}
		$data["departamentos"] = $this->get_departamentos_enid();
		$data["perfiles_enid_service"] = $this->get_perfiles_enid_service();
		
		$data = $this->principal->getCssJs($data, "usuarios_enid_service");
		$this->principal->show_data_page($data, 'empresas_enid');
	}
	private function get_perfiles_enid_service()
	{

		$api = "perfiles/get/format/json/";
		return $this->principal->api($api, []);
	}

	private function get_departamentos_enid()
	{

		$q["estado"] = 1;
		$api = "departamento/index/format/json/";
		return $this->principal->api($api, $q);
	}
}