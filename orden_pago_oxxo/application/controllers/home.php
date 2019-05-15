<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("saldos");
		$this->load->library(lib_def());
	}

	function index()
	{

		$data = $this->principal->val_session("Orden de compra");
		$data["meta_keywords"] = "";
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("");
		$param = $this->input->get();
		$q = get_info_variable($param, "q", 1);
		if ($q > 0) {
			$data["info_pago"] = $param;
			$data["clasificaciones_departamentos"] = "";
			$id_usuario = get_info_variable($param, "q3");
			$data["concepto"] = get_info_variable($param, "concepto");
			$data["usuario"] = $this->principal->get_info_usuario($id_usuario);
			$data =  $this->principal->getCSSJs($data, "pago_oxxo");
			$this->principal->show_data_page($data, get_format_orden_compra($data["usuario"], $param) , 1);

		} else {
			redirect("../../movimientos/?q=transfer&action=7");
		}
	}
}