<?php defined('BASEPATH') OR exit('No direct script access allowed');
class passwordmodel extends CI_Model {
function __construct(){

        parent::__construct();        
        $this->load->database();
}

function actualizarPassword($antes, $nuevo, $id_usuario)
{	
	$existe = count($this->validarPassword($antes, $id_usuario));
	if($existe != 1){
		return "La contraseña ingresada no corresponde a su contraseña actual";
	}else{

		$query_update = "UPDATE usuario SET password = '".$nuevo."' WHERE idusuario = '".$id_usuario."' limit 1";  
    	$dbresponse = $this->db->query( $query_update );     
    	return $dbresponse;
	}
	
}
/**/
function validarPassword($antes , $id_usuario)
{
    $query_get = "SELECT password FROM usuario WHERE idusuario = '".$id_usuario."' AND password = '".$antes."' limit  1";
    $result = $this->db->query( $query_get );     
    return $result ->result_array();
}
}/*Termina la función */