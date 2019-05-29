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

		$data = $this->principal->val_session(
		    "",
            "",
            "",
            create_url_preview("paginas_web_ii.jpeg")
        );

		$data["f_pago"] = 1;
		
        $data = $this->principal->getCssJs($data, "sobre_enid");
		$this->principal->show_data_page($data, get_format_descripcion() , 1);
	}
}