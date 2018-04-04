<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
/**/
function create_resumen_servicio($servicio ,  $info_solicitud_extra){
  
  $resumen =""; 
  $resumen_servicio ="";  
  $duracion =  $info_solicitud_extra["num_ciclos"];
  $precio =  0;

  $info_servicio = "";
  $id_ciclo_facturacion ="";
  $precio =0;
  foreach ($servicio as $row) {
    
    $id_servicio =  $row["id_servicio"];
    $nombre_servicio  =  $row["nombre_servicio"];
    $info_servicio = $nombre_servicio;    
    $descripcion =  $row["descripcion"];    
    $resumen_servicio  = $nombre_servicio;    
    $id_ciclo_facturacion =  $row["id_ciclo_facturacion"];
    $precio =  $row["precio"];
  }

  $is_servicio =0;
  $text_label = "Piezas";
    
  if($info_solicitud_extra["is_servicio"] ==  1){
    $text_label = "Duración"; 
    $is_servicio =1;       
  }

  
  $text_ciclos_contratados =   get_text_duracion($id_ciclo_facturacion , $duracion ,  $is_servicio);  

  $resumen_completo ="<div class='row'>
                      <div class='col-lg-4 tex-center'style='font-size:.8em;'>
                        <div class='strong' style='font-size:1.2em!important;'>
                          Producto
                        </div>
                        ".
                        $resumen_servicio
                        ."
                        </div>";
  $resumen_completo .="<div class='col-lg-4 tex-center'style='font-size:.8em;'>
                          <div class='strong' style='font-size:1.2em!important;'>
                            ".$text_label."
                          </div>".$text_ciclos_contratados."</div>";
  $resumen_completo .="<div class='col-lg-4 tex-center'style='font-size:.8em;'>
                          <div class='strong' style='font-size:1.2em!important;'>
                            Precio
                          </div>                          
                          ".
                            $precio
                          ."
                          </div>
                       </div>";

  $data_complete["resumen_producto"] = $resumen_completo;
  $data_complete["monto_total"] = $precio;
  $data_complete["resumen_servicio_info"] =  $info_servicio;

  return $data_complete;
}
/**/
function get_text_duracion($id_ciclo_facturacion , $num_ciclos , $is_servicio){

  $text_ciclos ="";
  $text_ciclos =[
    "Anual",
    "Mensual",
    "Semanal",
    "Quincenal",
    "No aplica",
    "Anual a 3 meses",
    "Anual a 4 meses",
    "Anual a 6 meses"];

    $text ="";


    switch($id_ciclo_facturacion){
      case 1:
        
         $text = $num_ciclos ." Año";
          if ($num_ciclos>1) {
            $text = $num_ciclos ." Años";
          }      
        break;
      
      case 2:
        
        $text = $num_ciclos ." Mes";
        if($num_ciclos>1){
            $text = $num_ciclos ." Meses";
        }      
        break;  
      
      case 5:        
        $text = $num_ciclos ." ";
        if($num_ciclos>1){
            $text = $num_ciclos . "  ";
        }      
        break;        

      default:        
        break;
    }
  
    return $text;


}
/**/
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