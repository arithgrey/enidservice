<?php defined('BASEPATH') OR exit('No direct script access allowed');
class empresamodel extends CI_Model{
	function __construct(){
		parent::__construct();        
	    $this->load->database();
	}
	/**/
	function get_galeria($param){
	    $query_get =  "select *  from 
	                  imagen_empresa where  id_empresa = '".$param["id_empresa"]."'  and tipo = 2 ";
	    $result =  $this->db->query($query_get);
	    return $result->result_array();
	}

/*Termina modelo */
}

