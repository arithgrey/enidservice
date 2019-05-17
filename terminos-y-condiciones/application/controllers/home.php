<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	public $option;

	function __construct()
	{
		parent::__construct();
		$this->load->library(lib_def());
	}

	function index()
	{

		$data = $this->principal->val_session("");
		$data["clasificaciones_departamentos"] = $this->principal->get_departamentos();
		$vista = "secciones/terminos_condiciones";
		$titulo = "TÉRMINOS Y CONDICIONES";
		$data["vista"] = $vista;
		$data["titulo"] = $titulo;
		$this->principal->show_data_page($data, 'home');
	}
}