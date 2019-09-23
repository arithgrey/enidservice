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

		$data = $this->app->session("Orden de compra");
		$param = $this->input->get();

		$q = prm_def($param, "q", 1);

		if ($q > 0) {

			$data["info_pago"] = $param;
			$id_usuario = prm_def($param, "q3");

			$data += [
                "concepto" => prm_def($param, "concepto"),
                "usuario"  => $this->app->usuario($id_usuario)
            ];

			$data =  $this->app->cssJs($data, "pago_oxxo");
			$this->app->pagina($data, format_orden_compra($data["usuario"], $param,$this->config->item('numero_cuenta')) , 1);

		} else {
			redirect("../../movimientos/?q=transfer&action=7");
		}
	}
}