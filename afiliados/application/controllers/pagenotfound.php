<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagenotfound extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('sessionclass');    
	}
	function index(){	
		$data["Titulo"] = "Página no encontrada";
		$this->load->view("pagenotfound", $data );
	}/*Termina la función*/
		
}/*Termina el controlador */