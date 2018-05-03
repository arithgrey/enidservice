<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('invierte_date_time')){


  /**/
  function valida_botton_editar_servicio($param, $id_usuario_registro_servicio ){

      $in_session = $param["in_session"];

      if($in_session ==  1){
          

          $id_servicio =  $param["id_servicio"];
          $id_usuario_actual =   $param["id_usuario"];

          if($id_usuario_actual ==  $id_usuario_registro_servicio){
            $extra_estilos =" style='background:blue;padding:5px;color:white;' ";
            return "<div class='servicio fa fa-pencil' title='Editar'
                    ".$extra_estilos."
                    id='$id_servicio' >
                    </div>";  
          }
          
      }
  }
  /**/
  function get_numero_colores($color , $flag_servicio , $url_info_producto , $extra ){

        if($flag_servicio !=  1) {                
          $arreglo_colores =  explode(",", $color);
          $num_colores =  count($arreglo_colores);
          if( $num_colores > 0){            
              if($num_colores > 1){
                return "  <a href='".$url_info_producto."' ".$extra." >" 
                          .$num_colores ." colores
                          </a>
                        ";  
              }else{
                return "  <a href='".$url_info_producto."' ".$extra." >" 
                          .$num_colores ." color
                          </a>
                        ";  
              }
              
          }
        }
    }
    /**/
    function get_text_nombre_servicio($nombre_servicio){

      $extra_estilos ='style="font-weight:40;font-size: .8em;text-transform: uppercase;color:black!important"';

      $text_nombre_servicio ='<h2 '.$extra_estilos.'>'.
                substr( $nombre_servicio ,  0  , 70 ).
                '</h2>';
      return $text_nombre_servicio;
    }
    function get_info_variable($param , $nomber_variable ){
      
      $valor =0;
      if(isset($param[$nomber_variable]) && $param[$nomber_variable] != null ){             
          $valor = $param[$nomber_variable];
      }
      return $valor;
    }
    /**/
    function crea_seccion_de_busqueda_extra($info , $busqueda){

      /**/
      $seccion ="";

      $flag =0;
      for ($z=0; $z <count($info); $z++) { 
          
          $data = $info[$z];
          foreach ($data as $row) {
          
            $id_clasificacion = $row["id_clasificacion"];  
            $nombre_clasificacion = $row["nombre_clasificacion"];  

            $url ="../search/?q=".$busqueda."&q2=".$id_clasificacion;
            $seccion .="<div> 
                          <a href='".$url."' 
                            style='font-size:.8em;margin-left:5px;' 
                            class='black categoria_text'>
                            ".$nombre_clasificacion."
                          </a>
                        </div>";
                        $flag ++; 
              
          }
      }
      
      $info_seccion["html"] =  $seccion;
      $info_seccion["num_categorias"] =  $flag; 
      return $info_seccion;
      /**/
    }
    

   function is_servicio($row){

      $flag_precio_definido = 0;
      $flag_envio_gratis =  $row["flag_envio_gratis"];
      $flag_servicio =  $row["flag_servicio"];
      $precio =  $row["precio"];
      $extra ="";

      switch($flag_servicio){
        case 1:

          if($flag_precio_definido == 1){
            
            $extra = "";  
          }else{
              $extra = "A convenir";  
          }          
          break;
        case 0:
          
          if($flag_envio_gratis == 1){              
            /**/
            $extra ="Envio a todo México";               
          }else{
            $extra ="Envios a todo México";               
          }
          break;
        default:          
          break;
      }
      return $extra;
    }

        function get_btn_copiar($url){

      $btn_copiar ='<i 
      class="btn_copiar_enlace_pagina_contacto fa fa-clone" data-clipboard-text="'.$url.'">
      </i>';
      return $btn_copiar;

    }
    /**/
    /**/
    function get_url_tumblr($url , $mensaje){
      
      return "http://tumblr.com/widgets/share/tool?canonicalUrl=".$url;
      
    }
    /**/
    function get_url_pinterest($url , $mensaje){

      $url_pinterest = "https://www.pinterest.com/pin/create/button/?url=". $url;

      return $url_pinterest;
    }
    /**/
    function get_url_twitter($url , $mensaje){

      $url_twitter ="https://twitter.com/intent/tweet?text=".$mensaje.$url;
      return $url_twitter;
    }
    /**/
    function get_url_facebook($url){
      $url_facebook ="https://www.facebook.com/sharer/sharer.php?u=".$url.";src=sdkpreparse";
      return $url_facebook;
    }
    /**/
function create_social_buttons($url_venta , $nombre_servicio){

      $url_facebook =  get_url_facebook($url_venta);   
      $url_twitter =  get_url_twitter($url_venta , $nombre_servicio);
      $url_pinterest = get_url_pinterest($url_venta, $nombre_servicio);
      $url_tumblr = get_url_tumblr($url_venta, $nombre_servicio);        
      $url_copi =  get_btn_copiar($url_venta);

      $social =      '<div class="social-sharing" style="font-size:.7em;">
                        '.$url_copi.'
                        <a 
                          href="'.$url_facebook.'" 
                          target="_black"
                          class="fa fa-facebook" 
                          title="Share">                    
                        </a>
                        <a 
                          class="fa fa-twitter" 
                          title="Tweet"
                          target="_black"
                          data-size="large"
                          href="'.$url_twitter.'" 
                          >                    
                        </a>
                        <a 
                          href="'.$url_pinterest.'" 
                          class="fa fa-pinterest-p" 
                          title="Pin it">                    
                        </a>                       
                        <a 
                          href="'.$url_tumblr.'" 
                          class="fa fa-tumblr" 
                          title="Tumblr">                    
                        </a>

                      </div>';
                      return $social;
    }
    



}/*Termina el helper*/