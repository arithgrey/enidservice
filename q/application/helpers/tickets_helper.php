<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  function valida_tipo_usuario_tarea($id_perfil){
    $text ="Equipo Enid Service";
    if ($id_perfil == 20) {        
        $text ="Cliente";
    }
    return $text;
  }
  function valida_check_tarea($id_tarea, $valor_actualizar,$status,$id_perfil){    

    if($id_perfil !=  20 ){          

        $config = [          
            "type"        =>  'checkbox', 
            "class"       =>  'tarea',                         
            "id"          =>  $id_tarea ,
            "value"       =>  $valor_actualizar,            
        ];
        if ($status ==  1){          
          $config["checked"] = true;
        }      

        $input = input($config);        
    }else{
      $input = ($status == 1) ? " Tarea terminada" : " | En proceso";
    }
    return $input;              
  }
  function valida_mostrar_tareas($data){
    
    if (count($data) > 0 ){

      $config     =   [ "class" =>  'mostrar_tareas_pendientes a_enid_black cursor_pointer' ];
      $config2    =   [ "class" =>  'mostrar_todas_las_tareas a_enid_black cursor_pointer'];
      $contenido  =   div("MOSTRAR SÓLO TAREAS PENDIENTES",   $config);
      $contenido .=   div("MOSTRAR TODAS LAS TAREAS",         $config2);
      return $contenido;
    }
  }
  function create_notificacion_ticket($info_usuario ,  $param ,  $info_ticket){
      
      $usuario        =  $info_usuario[0];       
      $nombre_usuario =  $usuario["nombre"] ." " . $usuario["apellido_paterno"] . $usuario["apellido_materno"] ." -  " .$usuario["email"];

      
      $asunto_email     =   "Nuevo ticket abierto [".$param["ticket"]."]";
      $ticket           =   div("Nuevo ticket abierto [".$param["ticket"]."]");
      $ticket          .=   div("Cliente que solicita ".$nombre_usuario."");
    
      $lista_prioridades =["" , "Alta" , "Media" , "Baja"];
      $lista                =   "";
      $asunto               =   "";
      $mensaje              =   "";
      $prioridad            =   "";
      $nombre_departamento  =   "";

        foreach ($info_ticket as $row) {
              
          $asunto       =   $row["asunto"]; 
          $mensaje      =   $row["mensaje"];     
          $prioridad    =   $row["prioridad"];
          $nombre_departamento =  $row["nombre_departamento"]; 
           
        }

        $ticket .=  div("Prioridad: ".$lista_prioridades[$prioridad]);
        $ticket .=  div("Departamento a quien está dirigido: ".$nombre_departamento);
        $ticket .=  div("Asunto:".$asunto);
        $ticket .=  div("Reseña:".$mensaje);

      $msj_email["info_correo"] =  $ticket;    
      $msj_email["asunto"]      =  $asunto_email;
      
      return $msj_email;
 
  }      
    function crea_tabla_resumen_ticket($info_ticket  , $info_num_tareas){
     
    $tareas                   =  $info_num_tareas[0]["tareas"];  
    $pendientes               =  $info_num_tareas[0]["pendientes"];      
    $id_ticket                =   ""; 
    $asunto                   =   ""; 
    $mensaje                  =   ""; 
    $status                   =   "";
    $fecha_registro           =   "";    
    $prioridad                =   "";
    $id_proyecto              =   "";
    $id_usuario               =   "";
    $nombre_departamento                  = "";
    foreach($info_ticket as $row){
            
          $id_ticket                  =  $row["id_ticket"];
          $status                     = $row["status"];     
          $fecha_registro             = $row["fecha_registro"];          
          $prioridad                  = $row["prioridad"];     
          $nombre_departamento        = $row["nombre_departamento"];    
          $lista_prioridad            = ["Alta" , "Media" , "Baja"];
          $lista_status               = ["Abierto", "Cerrado" , "Visto"];
          $asunto                     =  $row["asunto"];
      }
      ?>      
      <?php echo n_row_12()?>
          <?=div($asunto , ["class"=>"titulo_enid_sm titulo_bloque_tarea"]); ?>
      <?php echo end_row()?>

      <?php echo n_row_12()?>
            <?=div("#TAREAS ".$tareas ."" . "#PENDIENTES ".$pendientes ); ?> 
      <?php echo end_row()?>

      <?php echo n_row_12()?>
            <?=div($info_ticket[0]["asunto"]); ?> 
            <?=div($info_ticket[0]["mensaje"]); ?>             
      <?php echo end_row()?>

      <?php echo n_row_12()?>
        <?php echo "TICKET # ".$id_ticket ?> |
        <?php echo "DEPARTAMENTO ".strtoupper($nombre_departamento) ?> |
        <?php echo "ESTADO ".strtoupper($lista_status[$status]) ?> |
        <?php echo "PRIORIDAD ".strtoupper($lista_prioridad[$prioridad])  ?> |
        <?php echo "ALTA ".strtoupper($fecha_registro) ?>
      <?php echo end_row()?>
    
  <?php
  }
  

}