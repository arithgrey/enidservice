<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Saldos extends REST_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->model("saldos_model");
		$this->load->library(lib_def());
	}
	

}