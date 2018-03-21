<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
function get_text_ciclo_facturacion($id_ciclo_facturacion){

    $nuevo_text ="";
  switch ($id_ciclo_facturacion) {
    case '1':
      $nuevo_text ="365 Días";

      break;
    case '2':
      $nuevo_text ="30 Días";

      break;

    case '3':
      $nuevo_text ="7 Días";

      break;

    case '4':
      $nuevo_text ="15 Días";

      break;

    case '5':
      $nuevo_text ="Págo único";
      break;


    case '6':
      $nuevo_text ="365 Días";
      break;    

    case '7':
      $nuevo_text ="365 Días";
      break;    

    case '8':
      $nuevo_text ="365 Días";
      break;    

    default:
      # code...
      break;      
  }
  return  $nuevo_text;
}

/**/
function create_url_procesar_compra($producto_text, 
                                    $id_servicio ,  
                                    $total ,
                                    $ciclo_facturacion , 
                                    $num_ciclos, 
                                    $flag_servicio, 
                                    $dominio ="" , 
                                    $extension_dominio = ""){

  
  $url_procesar_compra =
  "../procesar/?producto=".$producto_text."&plan=".$id_servicio."&ciclo_facturacion=".
    $ciclo_facturacion."&num_ciclos=".$num_ciclos."&total=".$total."&dominio=".$dominio."&extension_dominio=".$extension_dominio."&is_servicio=".$flag_servicio;
  return $url_procesar_compra;
  
}
/**/
function get_titulos_precios($servicios , $in_session){

    $id_servicio =  "";
    $nombre_servicio =  "";
    $descripcion =  "";             
    $precio =  "";
    $id_ciclo_facturacion = "";
    $ciclo =  "";   
    $num_meses =  "";
    $table_info ="";

    $tmp_servicios =[];
    $z =0;
    foreach($servicios as $row){
      
      $id_servicio =  $row["id_servicio"];
      $tmp_servicios[$z] =  $id_servicio;
            
      $nombre_servicio =  $row["nombre_servicio"];
      $descripcion =  $row["descripcion"];              
      $precio =  $row["precio"];
      $id_ciclo_facturacion = $row["id_ciclo_facturacion"];
      $ciclo =  $row["ciclo"];    
      $flag_servicio =  $row["flag_servicio"];

      $num_meses =  $row["num_meses"];    
      $iva =  $precio *  (.16);
      $precio_iva =  $precio + $iva;

        $url_orden_compra = create_url_procesar_compra(
          $nombre_servicio , 
          $id_servicio ,
          $precio_iva , 
          $id_ciclo_facturacion, 
          1     ,
          $flag_servicio
        );

     
      $text_dias = get_text_ciclo_facturacion($id_ciclo_facturacion);
      
      $text = "<div 
                style='background:black;font-size:.8em;padding:5px;'
                class='white'>
                <i
                href='#tab_servicios' 
                  data-toggle='tab'                         
                class='fa fa-pencil servicio' id='".$id_servicio."'>
                </i>


              ".$nombre_servicio."
            </div>";
        $text .= "<div class='text-center strong'>
              ".$precio_iva."MXN
              </div>";

        $text .= "<div class='text-center strong' style='font-size:.9em;'>
              ".$text_dias."
              </div>";

            
        $text .= "<div class='text-center strong'>
              <a 
                href='$url_orden_compra'
                style='font-size:.9em;padding:5px;color:white!important;'   class='blue_enid_background'>
                  Ordenar compra!
              </a>
              </div>";
          
        $table_info .= get_td( $text);
        $z++;          
    }

    $data_complete["table_header"] =  $table_info;
    $data_complete["tmp_servicios"] = $tmp_servicios;
    return $data_complete;
}
/**/
/**/
function get_td($val , $extra = '' ){
    return "<td ". $extra ." NOWRAP >". $val ."</td>";
  }

  function get_td_val($val , $extra){
    if ($val!="" ) {
      return "<td style='font-size:.71em !important;' ". $extra .">". $val ."</td>";  
    }else{
      return "<td style='font-size:.71em !important;' ". $extra .">0</td>";
    }
    
  }
/*
function get_info_usuario($q2){
    
    $id_usuario_envio =0;
    if(isset($q2) && $q2 != null ){             
        $id_usuario_envio =$q2;
    }
    return $id_usuario_envio;
}
/**/
function get_info_servicio($q){
        $num_hist= 45;                      
       
        if(isset($q)){                
            if($q== 1){
                /*Cuando se comparte en facebook*/
                $num_hist= 105;      
            }if ($q == 2 ){
                /*Cuando se comparte en mercado libre*/
                $num_hist= 106;             
            }    
            if ($q == 3 ){
                /*Cuando se comparte en Likeding*/
                $num_hist= 500;             
            }    
            if ($q == 4 ){
                /*Cuando se comparte en twitter*/
                $num_hist= 501;             
            }    
            if ($q == 5 ){
                /*Cuando se comparte en correo*/
                $num_hist= 5010;             
            }    
            if ($q == 6 ){
                /*Cuando se comparte en blog*/
                $num_hist= 50100;             
            }
            if ($q == 7 ){
                /*Cuando se comparte en blog*/
                $num_hist= 50177;             
            }if ($q == 8 ){
                /*Cuando se comparte en instagram*/
                $num_hist= 99993;             
                
            }if ($q == 9 ){
                /*Cuando se comparte en pinterest*/
                $num_hist= 999939;             
            }

        }  
        return $num_hist;      

}
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