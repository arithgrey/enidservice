<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("compras");
		$this->load->library(lib_def());
	}

	function index()
	{

		$param = $this->input->get();
		$data = $this->principal->val_session("");
		$this->principal->acceso();
		$data["meta_keywords"] = "";
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("");
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();

		$this->carga_vista_compras($data);

	}

	private function carga_vista_compras($data)
	{

		$data = $this->getCssJs($data);
		$this->principal->show_data_page($data, 'principal');
	}

	private function getCssJs($data)
	{
		$data["css"] = [
			"confirm-alert.css",
			"compras.css"

		];

		$data["js"] =

			[
				"js/bootstrap-datepicker/js/bootstrap-datepicker.js",
				"js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
				"js/bootstrap-daterangepicker/moment.min.js",
				"js/bootstrap-daterangepicker/daterangepicker.js",
				"js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
				"js/bootstrap-timepicker/js/bootstrap-timepicker.js",
				"js/pickers-init.js",
				"alerts/jquery-confirm.js",
				"compras/principal.js"

			];
		return $data;
	}

}