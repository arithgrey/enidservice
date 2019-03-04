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
			header("location:../area_cliente");
		}

		$data["departamentos"] = $this->get_departamentos_enid();
		$data["perfiles_enid_service"] = $this->get_perfiles_enid_service();
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
		$data = $this->getCssJs($data);
		$this->principal->show_data_page($data, 'empresas_enid');
	}

	function getCssJs($data)
	{

		$data["js"] = [
			"js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
			"js/bootstrap-datepicker/js/bootstrap-datepicker.js",
			"js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
			"js/bootstrap-daterangepicker/moment.min.js",
			"js/bootstrap-daterangepicker/daterangepicker.js",
			"js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
			"js/bootstrap-timepicker/js/bootstrap-timepicker.js",
			"js/pickers-init.js",
			'usuarios_enid/principal.js',
			'usuarios_enid/notificaciones.js',
			'usuarios_enid/categorias.js',
			"js/clasificaciones.js"
		];

		$data["css"] = [
			"usuarios_enid_service_principal.css",
			"template_card.css",

		];

		$data["css_external"] = [
			"js/bootstrap-colorpicker/css/colorpicker.css",
			"js/bootstrap-datepicker/css/datepicker-custom.css",
			"js/bootstrap-datepicker/css/datepicker.css",
			"js/bootstrap-daterangepicker/daterangepicker.css",
			"js/bootstrap-datetimepicker/css/datetimepicker-custom.css",
			"js/bootstrap-datetimepicker/css/datetimepicker.css",
			"js/bootstrap-timepicker/css/timepicker.css",
			"js/bootstrap-wysihtml5/bootstrap-wysihtml5.css",
		];
		return $data;
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