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

		$this->principal->show_data_page($this->getCssJs($data), get_format_compras() , 1);

	}

	private function getCssJs($data)
	{
		$data["css"] = [
			"confirm-alert.css",
			"compras.css"

		];
		$data["js"] = [ "compras/principal.js" ];
		return $data;
	}

}