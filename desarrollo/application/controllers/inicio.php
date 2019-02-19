<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("desarrollos");
		$this->load->library(lib_def());
		$this->principal->acceso();
	}

	function index()
	{

		$data = $this->principal->val_session("");
		$num_perfil = $this->principal->getperfiles(2, "idperfil");
		$data["num_departamento"] = $this->get_id_departamento_by_id_perfil($num_perfil);
		$data["departamentos"] = $this->get_departamentos_enid();
		$data["clasificaciones_departamentos"]
			= $this->principal->get_departamentos("", 1);
		//$x                          =   ($num_perfil == 20 ) ? header("location:../area_cliente") : "";
		$activa = get_info_variable($this->input->get(), "q");
		$data["activa"] = ($activa === "") ? 1 : $activa;
		$data = $this->getCssJS($data);
		$this->principal->show_data_page($data, 'empresas_enid');


	}

	private function get_id_departamento_by_id_perfil($id_perfil)
	{

		$q["id_perfil"] = $id_perfil;
		$api = "perfiles/id_departamento_by_id_perfil/format/json/";
		return $this->principal->api($api, $q);

	}

	private function get_departamentos_enid()
	{
		$q["info"] = 1;
		$api = "departamento/index/format/json/";
		return $this->principal->api($api, $q);
	}

	private function getCssJS($data)
	{
		$data["css"] = ["desarrollo_principal.css", "confirm-alert.css"];

		$data["js"] = [
			"js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
			"js/bootstrap-datepicker/js/bootstrap-datepicker.js",
			"js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
			"js/bootstrap-timepicker/js/bootstrap-timepicker.js",
			"js/pickers-init.js",
			"desarrollo/principal.js",
			"alerts/jquery-confirm.js",
			"js/summernote.js"

		];

		$data["css_external"] = [
			"http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css"
		];

		return $data;
	}

}