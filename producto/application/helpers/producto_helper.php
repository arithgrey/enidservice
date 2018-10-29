<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
function get_text_periodo_compra($flag_servicio){
  if($flag_servicio == 0){
    return "Piezas";
  }
}
function valida_maximo_compra($flag_servicio, $existencia){

  if($flag_servicio ==  1){
    return 100;
  }else{
    return $existencia;
  }
}
function get_text_costo_envio($flag_servicio , $param){

  if($flag_servicio ==  0){
    return $param["text_envio"]["cliente"];   
  } 
}

function get_descripcion_servicio($descripcion , $flag_servicio){
  
  $extra_info = "";
  $extra      = "";
  $servicio = ($flag_servicio ==  1)?"SOBRE EL SERVICIO": "SOBRE EL PRODUCTO";  
  if (strlen(trim(strip_tags($descripcion))) > 10 ){
    $text   =   heading_enid($servicio, 2, ["class"=>'titulo_sobre_el_producto']);
    $text   .=  div(p(strip_tags($descripcion)) );
    return $text;  
  }
  
}

function get_contacto_cliente($tel_visible , $in_session , $usuario){

    $inf ="";
    if ($tel_visible){
        $usr = $usuario[0];    
        $ftel =1;
        $ftel2 =1;

        $tel     = (strlen($usr["tel_contacto"]) >4)?$usr["tel_contacto"]:$ftel=0;
        $tel2=(strlen($usr["tel_contacto_alterno"]) >4)?$usr["tel_contacto_alterno"]:$ftel2=0;
        if ($ftel == 1){
            
            $lada     =   (strlen($usr["tel_lada"])>0)?"(".$usr["tel_lada"].")":"";
            $contacto =   $lada.$tel;
            $inf      .=  div(icon("fa fa-phone"). $contacto );
        }
        if ($ftel2 ==  1) {
            $lada = (strlen($usr["lada_negocio"])>0)?"(".$usr["lada_negocio"].")":"";
            $inf .= div(icon('fa fa-phone').$lada.$tel2); 
        }
        return $inf;
    }
}

function get_entrega_en_casa($entregas_en_casa , $flag_servicio){
  
  $text ="";
  if($entregas_en_casa ==  1) {
    
    $text = ($flag_servicio ==  1)? "EL VENDEDOR TAMBIÉN BRINDA ATENCIÓN EN SU NEGOCIO":
          "TAMBIÉN PUEDES ADQUIRIR TUS COMPRAS EN EL NEGOCIO DEL VENDEDOR";
  }
  return $text;
}

function crea_nombre_publicador_info($usuario , $id_usuario){
  
  $nombre =  $usuario[0]["nombre"]; 
  $tienda = '../search/?q3='.$id_usuario.'&vendedor='.$nombre ; 
  $a = anchor_enid(
    "POR ". strtoupper($nombre) , 
    [
      "href"  =>  $tienda, 
      'class' => 'informacion_vendedor_descripcion' 
    ]);

  return "VENDEDOR " .$a;
  
}

function get_tipo_articulo($flag_nuevo , $flag_servicio){
  
  $usado =  div(li('- ARTÍCULO USADO'), [] ,1);    
  $text = ($flag_servicio ==  0 && $flag_nuevo    ==  0 ) ? $usado:"";  
  return $text;
}
function valida_informacion_precio_mayoreo($flag_servicio ,  $venta_mayoreo){
        
    return ($flag_servicio == 0 && $venta_mayoreo ==1)?"TAMBIÉN REALIZA VENTAS A PRECIO DE MAYOREO ".icon('fa fa-check-circle'):"";
   
}
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
        $style = "background:$color;height:40px; ";
        $info .= div("" ,  ["style"=>$style , "class" => "col-lg-4"]);
        $v ++;
    }
    if($v>0){    

      $final  ="";
        $final .= div($info_title ,  ["class"=>'informacion_colores_disponibles']);
        $final .= $info;        
      $final  = div($final ,         ['class'=>'contenedor_informacion_colores']);

    }
    return div($final , 1);
  }

}

function get_text_diponibilidad_articulo($existencia , $flag_servicio , $url_ml=''){
  if($flag_servicio == 0 ){
    if($existencia > 0){    
        $text =  "APRESÚRATE! SOLO HAY " .$existencia." EN EXISTENCIA ";              
        $text   = div($text , ['class' => 'text-en-existencia'] );
        if (strlen($url_ml) > 10 ) {
          $text  .= "<br>".anchor_enid("Adquiéralo en Mercado libre" ,["href" => $url_ml , "class" => "black"]);  
        }
        return $text;
    }
  }
  
}

function valida_editar_servicio($usuario_servicio , $id_usuario , $in_session , $id_servicio){
  
  $editar ="";
  if ($in_session == 1 ) {      
      $href="../planes_servicios/?action=editar&servicio=".$id_servicio;
      $editar_button =  div(anchor_enid(icon('fa fa-pencil')."EDITAR" , ["href"=> $href]) ,  ["class"=>'a_enid_black_sm editar_button'] );
      $editar =($id_usuario ==  $usuario_servicio)?$editar_button:"";
  }
  return $editar;
}

function valida_text_servicio($flag_servicio , $precio_unidad , $id_ciclo_facturacion){
    
    $text = "1 Pza ". $precio_unidad."MXN";  
    if ($flag_servicio == 1 ){      
        
        if($id_ciclo_facturacion != 9 && $precio_unidad >0 ){
          $text = $precio_unidad."MXN";       
        }else{
          $text ="A CONVENIR";       
        }
    }else{
      if($precio_unidad >0) {
        $text = $precio_unidad."MXN";       
      }else{
        $text ="A CONVENIR";       
      }
    }
    return $text;
}

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

      $producto_tab = "#imagen_tab_".$z;      
      $producto_tab_s = "imagen_tab_".$z;      
      
      $img_pro = array(
        'src'     => $url,                        
        'alt'     => $nombre_servicio, 
        'id'      => $z, 
        'class'   => 'imagen-producto',
        'onerror' => "this.onerror=null;this.src='".$url."';"
        );

      $preview  .=  anchor_enid(img($img_pro) , array(
        'id'          =>  $z, 
        'data-toggle' =>  'tab',
        'class'       =>  ' preview_enid '.$extra_class,
        'href'            =>  $producto_tab
        ));

      $image_properties = [  'src'     => $url , 
                              "class" => "imagen_producto_completa",
                              'onerror' => "this.onerror=null;this.src='".$url."';"
                          ];
      $imgs_grandes .= div(img($image_properties) , ["id"=> $producto_tab_s ,  "class"=>"tab-pane fade zoom ".$extra_class_contenido." "]);
      
      $z ++;

  }
  
  $data_complete["preview"] =  $preview;
  $data_complete["num_imagenes"] =  count($param);
  $data_complete["imagenes_contenido"] = $imgs_grandes;
  return $data_complete;
}
function valida_url_youtube($url_youtube){

  $url ="";
  if(strlen($url_youtube)>5){    
    

    $url  = iframe([
        "width"         =>  '100%' ,
        "src"           =>   $url_youtube,
        "frameborder"   =>  '0' ,
        "allow"         =>  'autoplay'
      
    ]);

  }
  return $url;
}

function get_info_producto($q2){
        
    $id_producto =0;
    if(isset($q2) && $q2 != null ){             
        $id_producto =$q2;
    }
    return $id_producto;        
}

}