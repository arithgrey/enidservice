<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
  /**/
  function btn_ticket_header($cliente){

    /* 2 ==  cliente*/
      $l ="";
      if ($cliente ==  2){

        $extra ="style='font-size:.8em!important;background: #0030ff;color: white;'";   
        $l .= get_td("Servicios" , $extra);        
      }
      return $l;
  }

  /**/
  function btn_ticket($cliente ,  $id_persona , $nombre ){
      /* 2 ==  cliente*/
      $l ="";
      if ($cliente ==  2) {

        $z = "<i                
                href='#tab_abrir_ticket' 
                data-toggle='tab'                 
                nombre_persona = '". $nombre ."'                
                id='".$id_persona."' 
                class='fa fa-shopping-bag  btn_abrir_ticket'>

              </i>";
        $l .= get_td($z);        
      }
      return $l;
  }  
  /**/
  function header_ticket($cliente){
      /* 2 ==  cliente*/
      $l ="";
      if ($cliente ==  2) {
        $l .= "<th style='color:#007BE3!important;font-size:.8em!important;'>
                Servicios
              </th>";
      }
      return $l;

  }
  /**/
  function evalua_cadena($cadena){

    if (strlen(trim($cadena)) > 0){
      return $cadena;
    }else{
      return "+";
    }

  }
  /**/
  function get_comentarios_persona($data){
      
      $l ="";

      foreach ($data as $row){
                
        $comentario    = $row["comentario"];
        $nombre_tipificacion    = $row["nombre_tipificacion"];
        $icono =  $row["icono"];
        $id_usuario   =  $row["idusuario"];
        $nombre    =  $row["nombre"];
        $apellido_paterno =  $row["apellido_paterno"];
        $apellido_materno =  $row["apellido_materno"];
        $email =  $row["email"];
       
        $persona_seguimiento =  
          $nombre . " " .
          $apellido_paterno . 
          " " .$apellido_materno .
          "- <span class='blue_enid'>
          " .$email ."
          </span>";

        
        /**/
        $url_imagen_usuario =  "../imgs/index.php/enid/imagen_usuario/".$id_usuario;  
        
        
                    $l .= '<li class="left clearfix">                              
                                <span class="chat-img pull-left">
                                    <img 
                                      src="'.$url_imagen_usuario.'"                                     
                                      class="img-circle"      
                                      id="usuario_'.$id_usuario.'"
                                      style="width:48px;"
                                      onerror="asigna_imagen_preview_user('.$id_usuario.')" />
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong style="font-size:.9em;">
                                          '.$persona_seguimiento.' 
                                        </strong> 
                                        <small class="pull-right">
                                            <br> 
                                            <i class="'.$icono.'"></i>
                                            '.$nombre_tipificacion .'
                                        </small>
                                    </div>
                                    <p style="font-size:.8em;">
                                        '.$comentario.'
                                    </p>
                                </div>
                            </li> 
                            ';  
      }
      return $l;
  }
  /**/
  function valida_class_extra_scroll($data){

    if (count($data) > 20) {
      return "contenedor_movil contenedor_listado_info";
    }else{
      return "contenedor_listado_info";
    }
  }

}/*Termina el helper*/