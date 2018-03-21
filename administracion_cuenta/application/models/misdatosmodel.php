<?php defined('BASEPATH') OR exit('No direct script access allowed');
class misdatosmodel extends CI_Model {
function __construct(){

        parent::__construct();        
        $this->load->database();
}
function actualizarNombre($nombre, $idPersona)
{
    $query_update = "UPDATE usuario SET nombre = '".$nombre."' WHERE idusuario = '".$idPersona."' limit 1";  
    $db_response = $this->db->query( $query_update );     
    return $db_response;
}

function mostrarNombre($idPersona)
{
    $query_get = "SELECT nombre FROM usuario WHERE idusuario = '".$idPersona."' limit 1 ";
    $result = $this->db->query( $query_get );     
    return $result ->result_array();
}

function actualizarPuesto($puesto, $idPersona1)
{
    $query_update = "UPDATE usuario SET puesto = '". $puesto ."' WHERE idusuario = '".$idPersona1."' limit 1 ";  
    $db_response = $this->db->query( $query_update );     
    return $db_response;
}

function mostrarPuesto($idPersona)
{
    $query_get = "SELECT puesto FROM usuario WHERE idusuario = '".$idPersona."' ";
    $result = $this->db->query( $query_get );     
    return $result ->result_array();
}

function actualizarDescripcion($descripcion, $idPersona2)
{
  $query_update = "UPDATE usuario SET descripcion = '".$descripcion."' WHERE idusuario = '".$idPersona2."' limit 1";  
    $db_response = $this->db->query( $query_update );     
    return $db_response;
}
function mostrarDescripcion($idPersona)
{
    $query_get = "SELECT descripcion FROM usuario WHERE idusuario = '".$idPersona."' limit 1";
    $result = $this->db->query( $query_get );     
    return $result ->result_array();
}
function update_data_user( $param , $id_usuario ){

    $query_check =  "SELECT count(*)exist  FROM usuario WHERE  email= '".$param["email"]."'  and idusuario != '". $id_usuario ."' limit 1";     
    $result = $this->db->query($query_check);
    $exist =  $result->result_array()[0]["exist"];
    $flag = 0; 

    if ($exist ==  0 ){        
        if ($this->check_exist_mail_in_alternos( $param["email"] , $id_usuario ) > 0  ){            
        }else{
            if( $this->check_exist_mail_alternos_in($param["email_alternativo"] , $id_usuario )> 0  ){
              
            }else{
                  if ($this->check_exist_mail_alternos_self( $param["email_alternativo"] , $id_usuario )> 0    ) {                  
                    }else{
                        $flag =1;
                    }  
            }            
        }        
    }else{}                

    if ($flag ==  1 ) {

        $query_update =  "update usuario set          
                    nombre  = '". $param["nombre"] ."' ,      
                    email =  '". $param["email"] ."', 
                    apellido_paterno    = '". $param["apellido_paterno"] ."' , 
                    apellido_materno    = '". $param["apellido_materno"] ."' , 
                    email_alterno       = '". $param["email_alternativo"] ."' , 
                    tel_contacto        =  '".  $param["tel_contacto"] ."' , 
                    tel_contacto_alterno = '". $param["tel_alterno"] ."' , 
                    edad                = '". $param["edad"] ."' , 
                    inicio_labor        = '". $param["inicio_labor"] ."' , 
                    fin_labor           = '". $param["fin_labor"] ."' , 
                    descripcion_usuario =  '". $param["descripcion_usuario"]."', 
                    rfc='".$param["rfc"]."' , 
                    turno = '". $param["turno"]."' ,
                    url_www= '".$param["npagina_web"]."',
                    url_tw= '".$param["npagina_tw"]."',
                    url_fb= '".$param["npagina_fb"]."',

                    ultima_modificacion = CURRENT_TIMESTAMP()

                    where idusuario = '". $id_usuario ."' limit 1";
        return $this->db->query($query_update);      
    }else{
        return 0; 
    }






}
/**/
function check_exist_mail_in_alternos($email , $id_usuario){
    
    $query_check =  "SELECT count(*)exist  FROM usuario WHERE email_alterno ='". $email ."'  and idusuario != '". $id_usuario ."' ";     
    $result = $this->db->query($query_check);
    $exist =  $result->result_array()[0]["exist"];
    return $exist;

}
/**/
function check_exist_mail_alternos_in($email_ext , $id_usuario ){
    $query_check = "SELECT count(*)exist FROM usuario  WHERE email = '". $email_ext ."' and idusuario != '". $id_usuario ."' "; 
    $result = $this->db->query($query_check);
    $exist =  $result->result_array()[0]["exist"];
    return $exist;       
}
function check_exist_mail_alternos_self($email_ext , $id_usuario ){
    $query_check = "SELECT count(*)exist FROM usuario  WHERE email_alterno  = '". $email_ext ."' and idusuario != '". $id_usuario ."' "; 
    $result = $this->db->query($query_check);
    $exist =  $result->result_array()[0]["exist"];
    return $exist;       
}
/**/    
}/*Termina la función */