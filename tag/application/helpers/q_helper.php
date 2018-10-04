<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){


    /**/
   
  
/*

  
  
    
    
    function crea_seccion_de_busqueda_extra($info , $busqueda){

      
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
      
    }
    

  

        function get_btn_copiar($url){

      $btn_copiar ='<i 
      class="btn_copiar_enlace_pagina_contacto fa fa-clone" data-clipboard-text="'.$url.'">
      get_titulo_modalidad';
      return $btn_copiar;

    }
    
    
    function get_url_tumblr($url , $mensaje){
      
      return "http://tumblr.com/widgets/share/tool?canonicalUrl=".$url;
      
    }
    
    function get_url_pinterest($url , $mensaje){

      $url_pinterest = "https://www.pinterest.com/pin/create/button/?url=". $url;

      return $url_pinterest;
    }
    
    function get_url_twitter($url , $mensaje){

      $url_twitter ="https://twitter.com/intent/tweet?text=".$mensaje.$url;
      return $url_twitter;
    }
    
    function get_url_facebook($url){
      $url_facebook ="https://www.facebook.com/sharer/sharer.php?u=".$url.";src=sdkpreparse";
      return $url_facebook;
    }
    
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
    


*/
    
    
}/*Termina el helper*/