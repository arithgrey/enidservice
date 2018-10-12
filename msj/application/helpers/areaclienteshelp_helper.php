<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
 	function forma_info_accesos_area_cliente_usuario($param){
        
        $password =  $param["password"];        
        $email =  "";    

        foreach ($param["info_usuario"] as $row){          
            $email =  $row["email"];    
        }
          $l ="<table>";            
            $l .="<tr>";      
              $l .=get_td("Sitio de soporte");      
              $l .=get_td("http://enidservice.com/inicio/login/");      
            $l .="</tr>";      
            $l .="<tr>";      
              $l .=get_td("Usuario" , $estilos);      
              $l .=get_td($email , $estilos_2);      
            $l .="</tr>";      

            $l .="<tr>";      
              $l .=get_td("Accesos" , $estilos);      
              $l .=get_td($password , $estilos_2);      
            $l .="</tr>";      
          $l  .="</table>";
          return $l;
  }
  /**/
  function forma_info_accesos_area_cliente_usuario_simple($param){
        
    $password =  $param["password"];        
    $email    =  "";    
    foreach ($param["info_usuario"] as $row){          
        $email =  $row["email"];    
    }
    $texto  =   anchor_enid("Sitio de soporte", ["href"=>'http://enidservice.com/inicio/login/']);
    $texto .=   div("Usuario: ". $email);
    $texto .=   div("Credenciales de acceso temporales : ".$password);
    return $texto;

  }
  /***/    
}/*Termina el helper*/