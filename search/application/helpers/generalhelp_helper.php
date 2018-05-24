<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    function crea_sub_menu_categorias_destacadas($param){      
      $z =0;
      $data_complete = [];

      foreach ($param as $row) {      
        
        $primer_nivel = $row["primer_nivel"];
        $total =  $row["total"];
        $nombre_clasificacion =  $row["nombre_clasificacion"];
        
        if ($z == 0) {          
          echo "<ul class='clasificaciones_sub_menu_ul'>";    
        } 
        $href ="?q=&q2=".$row["primer_nivel"];
        echo "<li>
              <a href='".$href."' class='text_categoria_sub_menu'>".$nombre_clasificacion."
              </a>
              </li>"; 
        $z ++;
        if ($z == 5) {          
          $z =0;
          echo "</ul>";    
        }                 
        /**/
      }
    }
    /**/
    function sub_categorias_destacadas($param){

      $nombres_primer_nivel =  $param["nombres_primer_nivel"];
        $z =0;
        $data_complete =[];
                
        foreach ($param["clasificaciones"] as $row){
            
            $primer_nivel =  $row["primer_nivel"];
            $total =  $row["total"];
            $nombre_clasificacion =  "";
            foreach ($param["nombres_primer_nivel"] as $row2){                
                
                $id_clasificacion = $row2["id_clasificacion"];
                if($primer_nivel == $id_clasificacion ){
                    $nombre_clasificacion =  $row2["nombre_clasificacion"];
                    break;
                }
                
                
            }
            $data_complete[$z]["primer_nivel"] =  $primer_nivel;
            $data_complete[$z]["total"] =  $total;
            $data_complete[$z]["nombre_clasificacion"] =  $nombre_clasificacion;
            
            if($z == 29){
                break;
            }
            $z ++;
            
        }        
        return $data_complete; 

    }
    /**/  
    function mayus($variable){
      $variable = strtr(strtoupper($variable),"àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
      return $variable;
    }    
    /**/
    function crea_menu_principal_web($param){
        
        $nombres_primer_nivel =  $param["nombres_primer_nivel"];
        $z =0;
        $data_complete =[];
                
        foreach ($param["clasificaciones"] as $row){
            
            $primer_nivel =  $row["primer_nivel"];
            $total =  $row["total"];
            $nombre_clasificacion =  "";
            foreach ($param["nombres_primer_nivel"] as $row2){                
                
                $id_clasificacion = $row2["id_clasificacion"];
                if($primer_nivel == $id_clasificacion ){
                    $nombre_clasificacion =  $row2["nombre_clasificacion"];
                    break;
                }
                
                
            }
            $data_complete[$z]["primer_nivel"] =  $primer_nivel;
            $data_complete[$z]["total"] =  $total;
            $data_complete[$z]["nombre_clasificacion"] =  $nombre_clasificacion;
            
            if($z == 4){
                break;
            }
            $z ++;
            
        }        
        return $data_complete;          
    }
    /**/  
    function get_numero_colores($arreglo){

        $num_colores =  count($arreglo);
        if( $num_colores > 0){            
            if($num_colores > 1){
              return "<div style='border-bottom: 1px dotted grey;font-size: .7em;height:20px;'>" 
                        .$num_colores ." colores
                      </div>";  
            }else{
              return "<div style='border-bottom: 1px dotted grey;font-size: .7em;height:20px;'>
                        ".$num_colores ." color
                      </div>";  
            }
            
        }
    }
    /**/
    function get_text_nombre_servicio($nombre_servicio){

      $extra_estilos ='style="font-weight:40;font-size: .7em;text-transform: uppercase;color:black!important"';

      if(strlen($nombre_servicio) >40) {
        $extra_estilos ='style="font-weight:40;font-size: .7em;text-transform: uppercase;color:black!important"';        
      }
      $text_nombre_servicio ='<h2 '.$extra_estilos.'>'.$nombre_servicio.'</h2>';
      return $text_nombre_servicio;
    }
    function get_info_variable( $param , $nomber_variable ){      
      $val =  array_key_exists($nomber_variable , $param)? $param[$nomber_variable]:0;
      return $val;
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
    /**/
    function get_btn_compartir_facebook($url_info_producto){

      return  '<div 
        class="fb-share-button" data-href="'.$url_info_producto.'" 
        data-layout="box_count" 
        data-size="small" 
        data-mobile-iframe="true">
        <a 
        class="fb-xfbml-parse-ignore" 
        target="_blank" 
        href="https://www.facebook.com/sharer/sharer.php?u='.$url_info_producto.';src=sdkpreparse">
        <i class="fa fa-2x fa-facebook blue_enid"></i>
        </a>
        </div>';

    }
    /**/
    
    /**/
    function evalua_precio_articulo_servicio($row){

      $flag_precio_definido = $row["flag_precio_definido"];
      $flag_envio_gratis =  $row["flag_envio_gratis"];
      $flag_servicio =  $row["flag_servicio"];
      
      $precio =  $row["precio"];
      $iva = $precio * .16;
      $precio =  $precio + $iva;
      /**/
      $extra ="";
      $tipo_moneda = "";

      switch($flag_servicio){
        case 1:
          if($flag_precio_definido == 1){
            
            $extra = $precio." MXN";  
          }else{
              $extra = "A convenir";  
          }          
          break;
        case 0:        
            $extra = $precio." MXN";  
          break;
        default:          
          break;
      }
      return $extra;

    }
    /**/
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
    /**/
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
    
/*****/
function valida_botton_agregar_productos($in_session , $num_perfil){

  /**/  
  if($in_session == 1){      
      if($num_perfil != 20 && $num_perfil != 19) {
        
        $list ="<li>
                    <a  class=' agregar_servicio white blue_enid_background  btn_agregar_servicios' 
                        href='../planes_servicios/?q=1'
                        style='color: white!important;font-size: .8em;padding: 10px;'>
                        <i class='fa fa-cart-plus'>                            
                        </i>
                        Agregar producto

                    </a>
                </li>";
                return $list;
      }
  }


}

/****/
function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
function get_info_usuario($q2){

    $id_usuario_envio =0;
    if(isset($q2) && $q2 != null ){             
        $id_usuario_envio =$q2;
    }
    return $id_usuario_envio;    
}
/**/
function get_info_servicio($q){
        $num_hist= 9990890;                                    
        return $num_hist;      

}
/**/
/**/
function template_documentacion($titulo,  $descripcion , $url_img  ){    
      $block =  "
                  <span>
                  <b>"; 
      $block .= $titulo;
      
      $block .= "</b>
                </span>
                <br>
                <span>
                ". $descripcion;

      $block .= "</span>
                  <img src='".$url_img."' class='desc-img'>
                ";                          
      $block .= "<br>
                <br>";
      return $block;


  }
/**/
if(!function_exists('invierte_date_time')){
  
  function construye_menu_enid_service($titulos , $extras ){
      $menu =  ""; 
      for ($a=0; $a < count($titulos ); $a++){ 
        $menu .=  "<a ".$extras[$a]." >" . $titulos[$a]." | </a>" ; 
      }
      return $menu;
  }
  /**/
  /**/
  

  /*NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN */
  function navegador(){
    return $_SERVER['HTTP_USER_AGENT'];
  }
  /**/
  function ip_user(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
  }  
  /**/
  function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){    
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }
        return $rstr;
  }
  function create_url_preview($img){
    return base_url()."../img_tema/portafolio/".$img;
  }

  /**/
  function valida_template_perfil_home($perfil){

    switch ($perfil) {
      case 7:
          return "principal/center_page_general"; 
        break;
      case 4:
          return "principal/center_page_general_prospecto";   
        break;    
      case 3:
          return "principal/center_page_general_prospecto"; 
      break;  
      
      default:
        return ""; 
      break;
    }
  }                                                

  /*NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN */
  
  function get_random(){
    return  mt_rand();       
  }
  /**/
  
  function n_row_12($extra =""){

    $row= "<div class='row'>
            <div class='col-lg-12 col-md-12 col-sm-12 ". $extra ." '>";
    return $row;
  }
  function end_row(){
    $row= "</div>
          </div>";
    return $row;
  }
  /**/
  function titulo_enid($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  /**/

  
  

}/*Termina el helper*/