<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Paginacion extends REST_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
	}

	function create_GET()
	{

		$param = $this->get();
		$response = false;
		if (fx($param, "totales_elementos,per_page,q")) {

			$base_url = "?q=" . $param["q"];
            $base_url .= (prm_def($param, "q2", 0, 1) > 0) ? "&q2=".$param["q2"] : "";
            $base_url .= (prm_def($param, "q3", 0, 1) > 0) ? "&q3=".$param["q3"] :"";
            $base_url .= (prm_def($param, "order", 0, 1) > 0) ? "&order=" . $param["order"] : "";

			$config = [
                'full_tag_open' => '<div class="pagination">',
                'full_tag_close' => '</div>',
                'num_tag_open' => '<li>',
                'num_tag_close' => '</li>',
                'cur_tag_open' => '<li class="active"><span>',
                'cur_tag_close' => '<span></span></span></li>',
                'prev_tag_open' => '<li>',
                'prev_tag_close' => '</li>',
                'next_tag_open' => '<li>',
                'next_tag_close' => '</li>',
                'prev_link' => '«',
                'last_link' => '»',
                'next_link' => '<span class="white">›</span>',
                'first_tag_open' => '<li>',
                'first_tag_close' => '</li>',
                'last_tag_open' => '<li>',
                'last_tag_close' => '</li>',
                'per_page' => $param["per_page"],
                'base_url' => $base_url,
                'num_links' => 10,
                'first_link' => '<span class="white">« Primera</span>',
                'last_link' => '<span class="white">Última»</span>',
                'total_rows' => $param["totales_elementos"],
                'use_page_numbers' => TRUE,
                'page_query_string' => TRUE,
                'enable_query_strings' => TRUE,
                'query_string_segment' => 'page',
            ];

			$this->pagination->initialize($config);
			$response = $this->pagination->create_links();

		}

		$this->response($response);

	}
}