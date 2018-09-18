<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
  function create_notificacion_ticket($info_usuario ,  $param ,  $info_ticket){
      
      $usuario =  $info_usuario[0];       
      $nombre_usuario =  $usuario["nombre"] ." " . 
                         $usuario["apellido_paterno"] . 
                         $usuario["apellido_materno"] ." -  " .
                         $usuario["email"];

      
      $asunto_email = "Nuevo ticket abierto [".$param["ticket"]."]";

      $ticket =  "<label> 
                      Nuevo ticket abierto [".$param["ticket"]."]
                  </label>
                  ";                        

      $ticket .= "<div style='margin-top:20px;'>
                    <span>
                      Cliente que solicita ".$nombre_usuario."
                    </span>
                  </div>";                              

  
        $lista_prioridades =["" , "Alta" , "Media" , "Baja"];
        $lista =  "";
        $asunto = "";
        $mensaje = "";
        $prioridad = "";
        $nombre_departamento = "";

        foreach ($info_ticket as $row) {
              
          $asunto =  $row["asunto"]; 
          $mensaje =  $row["mensaje"];     
          $prioridad = $row["prioridad"];
          $nombre_departamento =  $row["nombre_departamento"]; 
           
        }

        $ticket .='
        <div >
          <span>
            <strong>
              Prioridad:
            </strong>
          </span>  
          '.$lista_prioridades[$prioridad].'
        </div>
        <div >
          <span>
            <strong>
              Departamento a quien está dirigido:
            </strong>
          </span>          
          '.$nombre_departamento.'
        </div>

        <div >
          <span>
            <strong>
              Asunto:
            </strong>
          </span>            
          '.$asunto.'
        </div>

        <div >
          <span>
            <strong>
              Reseña:
            </strong>
          </span>  
          '.$mensaje.'
        </div>';
            
      
      $msj_email["info_correo"] =  $ticket;    
      $msj_email["asunto"] =  $asunto_email;
      
      return $msj_email;
 
  }      

}