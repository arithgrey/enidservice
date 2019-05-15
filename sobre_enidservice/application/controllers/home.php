<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->helper("sobre");
		$this->load->library(lib_def());
	}

	function index()
	{

		$data = $this->principal->val_session("");
		$data["meta_keywords"] = "";
		$data["desc_web"] = "";
		$data["url_img_post"] = create_url_preview("paginas_web_ii.jpeg");
		$data["f_pago"] = 1;
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
        $data = $this->principal->getCssJs($data, "sobre_enid");
		$this->principal->show_data_page($data, 'home');
	}
}