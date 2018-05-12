<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**/
function valida_editar_servicio($usuario_servicio , $id_usuario , $in_session , $id_servicio){
  
  $editar ="";
  if ($in_session == 1 ) {      
      $href="../planes_servicios/?action=editar&servicio=".$id_servicio;
      $editar_button ="<div class='a_enid_black_sm editar_button'>                        
                        
                        <a href='".$href."' 
                          style='color:white!important;' >                          
                          <span class='fa fa-pencil'></span>
                          EDITAR                        
                        </a>                        
                      </div>";
      $editar =($id_usuario ==  $usuario_servicio)?$editar_button:"";
  }
  return $editar;
}
/**/
function valida_valor_variable($param , $q){
  $val = (array_key_exists($q, $param)== true) ? $param[$q]:0; 
  return $val;
}
/**/
function valida_maximo_compra($flag_servicio, $existencia){

  if($flag_servicio ==  1){
    return 100;
  }else{
    return $existencia;
  }
}
/**/
function crea_nombre_publicador($usuario , $id_usuario){
  
  $nombre =  $usuario[0]["nombre"]; 
  return "<div class='informacion_vendedor'>
            <span class='por_vendedor'>
              POR
            <span>
            <a href='../search/?q3=$id_usuario&vendedor=$nombre'
              class='publicado_por' >  
              ".strtoupper($nombre) ."
            </a> 
          </div>";
}
function crea_nombre_publicador_info($usuario , $id_usuario){
  
  $nombre =  $usuario[0]["nombre"]; 
  return "<div class='informacion_vendedor_descripcion'>
              <a href='../search/?q3=$id_usuario&vendedor=$nombre'>  
              POR                    
              ".strtoupper($nombre) ."
            </a> 
          </div>";
}

/**/
function get_text_periodo_compra($flag_servicio){
  if($flag_servicio == 0){
    return "Piezas";
  }else{

  }
}
/**/
function get_text_costo_envio($flag_servicio , $param){

  if($flag_servicio ==  0){
    return $param["text_envio"]["cliente"];   
  } 
}
/**/
function get_valor_variable($variable , $valor){

  $val =0;
  if (isset($variable[$valor])) {
    $val =   $variable[$valor];
  }
  return $val;
}
/**/
function get_text_diponibilidad_articulo($existencia , $flag_servicio){
  if($flag_servicio == 0 ){
    if($existencia > 0){    
        $text =  "¡Apresúrate! solo hay " .$existencia." en existencia ";      
        return strtoupper($text);
    }
  }
  /**/
}
/**/
function creta_tabla_colores($text_color , $flag_servicio ){

  $final ="";
  if ($flag_servicio == 0) {    
    $arreglo_colores = explode(",", $text_color);
    $num_colores=  count($arreglo_colores);  
    $info_title ="";  

    if($num_colores > 0){
      $info_title = ($num_colores>1)?"COLORES DISPONIBLES":"COLOR DISPONIBLE";      
    }
    $info ="";
    $v =0;
    for($z=0; $z <count($arreglo_colores); $z++){       
        $color =  $arreglo_colores[$z]; 
        $estyle = "style='background:$color;height:40px;' ";
        $info .= "<div $estyle class='col-lg-4'></div>";
        $v ++;
    }
    if($v>0){    
      $final  ="<div class='contenedor_informacion_colores'> ";
        $final .= "<div class='informacion_colores_disponibles'>".$info_title."</div>";        
          $final .= $info;        
      $final .="</div>";
    }
    return $final;
  }

}
/**/
function get_tipo_articulo($flag_nuevo , $flag_servicio){

  if ($flag_servicio ==  0){
    if($flag_nuevo ==  0){
      $text = n_row_12();
      $text .= "<li><span> - Artículo usado </span></li>";
      $text .= end_row();
      return $text;
    }
  }
}
/**/
function get_entrega_en_casa($entregas_en_casa , $flag_servicio){
  
  $text ="";
  if($entregas_en_casa ==  1) {
    
    $text = ($flag_servicio ==  1)? "EL VENDEDOR TAMBIÉN BRINDA
           ATENCIÓN EN SU NEGOCIO":
          "TAMBIÉN PUEDES ADQUIRIR TUS COMPRAS EN EL NEGOCIO DEL VENDEDOR";
  }
  return $text;
}
/******/
function get_contacto_cliente($telefono_visible , $in_session , $usuario){

  if ($in_session ==  1){
    
    $telefono =  $usuario[0]["tel_contacto"];
    $text_tel =  "<div>                  
                    <a target='_blank' href='tel:".$telefono."' style='text-decoration:underline;color:black;'>
                      <i class='fa fa-phone'>
                      </i>
                      ".$telefono."
                    </a>
                    </div>
                    <br>";
    $text_telefono_visible =  
    ($telefono_visible ==  1 && strlen(trim($telefono))>4)? $text_tel :"";
    return $text_telefono_visible;
  }

}

/**/
function get_descripcion_servicio($descripcion , $flag_servicio){
  
  $extra_info ="style='font-size:.9em;'";
  $extra ="style='padding:5px;margin-top:10px;'";
  $servicio = ($flag_servicio ==  1)?"SOBRE EL SERVICIO": "SOBRE EL PRODUCTO";
  

  if (strlen(trim(strip_tags($descripcion))) >10 ){
    return "<div class='contenedor_descripcion_servicio'>    
            <h3 class='titulo_sobre_el_producto'>
              ".$servicio."
            </h3>          
            <div ".$extra.">
              <p ".$extra_info.">
                " . strip_tags($descripcion) ."
              </p>
            </div>
          </div>";  
  }
  
}
/**/
function valida_text_servicio($flag_servicio , $precio_unidad , $id_ciclo_facturacion){
    
    $text = "1 Pza ". $precio_unidad."MXN";  
    if ($flag_servicio == 1 ){      
        
        if($id_ciclo_facturacion != 9){
          $text = $precio_unidad."MXN";       
        }else{
          $text ="Precio a convenir";       
        }
        
      
    }else{
      if($precio_unidad >0) {
        $text = $precio_unidad."MXN";       
      }else{
        $text ="Precio a convenir";       
      }
    }
                     
    return $text;
    
}
/**/
function valida_url_youtube($url_youtube){

  $url ="";
  if(strlen($url_youtube)>5){    
    $url = "<iframe width='100%' 
            height='315' 
            style='margin-top:20px;'
            src='".$url_youtube."' 
            frameborder='0' 
            allow='autoplay; encrypted-media' allowfullscreen>
                      </iframe>";
  }
  return $url;
}
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
function valida_imagen_principal($num_imagenes , $imagen){
  /**/
  $imagen_principal ="";
  if($num_imagenes > 0 ){    
      return $imagen;
  }else{
      return "../img_tema/temas-ayuda/clarificar-informacion.jpg";
  }
  /**/
}
/**/
function crea_url_imagen($id_imagen){

  return "../imgs/index.php/enid/imagen/".$id_imagen;
}
/**/
function get_img_por_posicion($imagenes_arreglo , $posicion ){

  return $imagenes_arreglo[$posicion];
}
/**/
function construye_seccion_imagen_lateral($param , $nombre_servicio , $url_youtube){

  $preview ="";
  $z = 0;
  $img_principal = "";
  $imgs_grandes = "";

  foreach($param as $row){
            
      $id_imagen =  $row["id_imagen"];      
      $url =  "../imgs/index.php/enid/imagen/".$id_imagen;    
      $extra_class = '';
      $extra_class_contenido = '';      
      if($z == 0){

        $extra_class =' active ';  
        $extra_class_contenido = ' in active ';
        $img_principal = $url;
      
      }
      /**/
      $producto_tab = "imagen_tab_".$z;
      $parte_tab ="data-toggle='tab'  href='#".$producto_tab."'";
      $preview .='<a class="'.$extra_class.' "  '. $parte_tab.' >                    
                      <img src="'.$url.'" alt="'.$nombre_servicio.'"
                      onerror="this.src='."'".$url."'".' ">                    
                  </a>';

      /**/
      $imgs_grandes .='<div 
                        id="'.$producto_tab.'" 
                        class="tab-pane fade '.$extra_class_contenido.' " >
                        <span 
                          class="img"  
                          style="background-image: url('."'".$url ."'".')"
                          onerror="this.src='."'".$url."'".' ">
                        </span>  
                      </div>';
      /**/
      $z ++;

  }

  
  $data_complete["preview"] =  $preview;
  $data_complete["num_imagenes"] =  count($param);
  $data_complete["imagenes_contenido"] = $imgs_grandes;
  return $data_complete;

}
/**/
function get_info_producto($q2){
    /**/    
    $id_producto =0;
    if(isset($q2) && $q2 != null ){             
        $id_producto =$q2;
    }
    return $id_producto;    
    /**/
}
/**/
/**/
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
        
        if(isset($q)){ 

            if($q== 1){
                /*Cuando se comparte en facebook*/
                $num_hist= 109;      
            }if ($q == 2 ){
                /*Cuando se comparte en mercado libre*/
                $num_hist= 110;             
            }    
            if ($q == 3 ){
                /*Cuando se comparte en linkeding*/
                $num_hist= 510;             
            }    
            if ($q == 4 ){
                /*Cuando se comparte en twitter*/
                $num_hist= 511;             
            }if ($q == 5 ){
                /*Cuando se comparte en Email*/
                $num_hist= 50123;             
            }    
            if ($q == 6 ){
                /*Cuando se comparte en Blog*/
                $num_hist= 50121;             
            }    
            if ($q == 7 ){
                /*Cuando se comparte Adwords*/
                $num_hist= 50179;             
            }
            /**/
            if ($q == 8 ){
                /*Cuando es en Instagram*/
                $num_hist= 50180;             
            }
            if ($q == 9 ){
                /*Cuando es en pinterest*/
                $num_hist= 50181;             
            }

        }  
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