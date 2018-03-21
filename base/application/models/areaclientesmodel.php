<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class areaclientesmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function asocia_usuario_persona($param){

    	$id_usuario =  $param["id_usuario"];
    	$id_persona =  $param["id_persona"];

    	$query_update ="UPDATE persona
	    				SET 	    					
	    					id_usuario_enid_service = '".$id_usuario ."' ,
	    					tipo = 2 , 
	    					fecha_envio_validacion = CURRENT_TIMESTAMP() , 
	    					fecha_cambio_tipo = CURRENT_DATE() 
	    				WHERE  
	    					id_persona ='".$id_persona."' 
	    				LIMIT 1";
		
		return $this->db->query($query_update);

    }	
    /**/
    function crea_usuario_perfil_cliente($param){
    	
    	$password =  RandomString();            
    	$email =  $param["correo"];
    	$id_departamento =  9; 
    	$nombre =  $param["nombre"];
    	$telefono =  $param["telefono_contacto"];

    
	        $query_insert = "INSERT INTO usuario(
	                                          email  ,                            
	                                          idempresa ,                      
	                                          id_departamento, 
	                                          password,
	                                          nombre , 
	                                          tel_contacto
	                                          )VALUES(
	                              '". $email ."',                                                   
	                              '1',                            
	                              '".$id_departamento."',
	                              '".sha1($password)."',
	                              '".$nombre."',
	                              '".$telefono."'
	                      )";
	        
	        $this->db->query($query_insert);
	        $id_usuario = $this->db->insert_id();	
	        
	        $param["id_usuario"] =  $id_usuario; 
        	$param["puesto"] =  20; 
        	$this->agrega_permisos_usuario($param);   
		

		$data_complete["password"] = $password;
		$data_complete["id_usuario"] = $id_usuario;

        return  $data_complete;        
    }
    /**/
    function agrega_permisos_usuario($param){

	    $puesto =  $param["puesto"];
	    $id_usuario =  $param["id_usuario"];

	    $query_delete =  "DELETE FROM 
	                      usuario_perfil 
	                      WHERE idusuario = '".$id_usuario."' ";
	    $this->db->query($query_delete);


	    $query_insert = "INSERT INTO 
	                      usuario_perfil(
	                              idusuario , 
	                              idperfil 
	                      )VALUES(
	                        '".$id_usuario."', 
	                        '".$puesto ."'
	                      )";

	    return $this->db->query($query_insert);

  }
  /**/   
}