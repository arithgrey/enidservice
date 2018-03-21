<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
 	function forma_info_accesos_area_cliente_usuario($param){
        
        $password =  $param["password"];        
        $email =  "";    

        foreach ($param["info_usuario"] as $row){          
            $email =  $row["email"];    
        }
        
          $estilos =" style='font-size:.8em!important;background:#0030ff;color: white!important;padding:5px;'";         
          $estilos_2 =" style='font-size:.8em!important;background:#03153B;color: white!important;padding:5px;' ";

          
          $l ="<table style='width:100%;'>";            
            
            $l .="<tr>";      
              $l .=get_td("Sitio de soporte" , $estilos );      
              $l .=get_td("http://enidservice.com/inicio/login/" , $estilos_2);      
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
          $email =  "";    

          foreach ($param["info_usuario"] as $row){          
              $email =  $row["email"];    
          }
          
          $texto ="<a href='http://enidservice.com/inicio/login/'>Sitio de soporte</a>
                  <br>
                  Usuario:$email 
                  <br> 
                  Credenciales de acceso temporales : $password ";
          
          
          return $texto;

      }
      /***/    
}/*Termina el helper*/