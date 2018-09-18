<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  function texto_costo_envio_info_publico(
    $flag_envio_gratis , $costo_envio_cliente , $costo_envio_vendedor){
    $data_complete = [];        
    if($flag_envio_gratis > 0){
      $text                     = "ENVÍO GRATIS!";
      $data_complete["cliente"] = $text;
      $data_complete["cliente_solo_text"]     = "ENVÍO GRATIS!";
      $data_complete["ventas_configuracion"]  = 
      "TU PRECIO YA INCLUYE EL ENVÍO";
    }else{        
      $data_complete["ventas_configuracion"]  = 
      "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO";      
      $text                                   = "MÁS ".$costo_envio_cliente." MXN DE ENVÍO";
      $data_complete["cliente_solo_text"]     = "Más ".$costo_envio_cliente." MXN de envío";
      $data_complete["cliente"] = $text;      
    }
    return $data_complete;
  }   
}

