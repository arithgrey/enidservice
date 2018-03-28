<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
  /**/  
  function entrega_data_campo($param , $key , $label='' , $validador_numerico =0){
    $value =$param[0][$key];
    if($validador_numerico == 1){
        if(strlen($value) <5){
          $value ="AGREGA TU NÚMERO TELEFÓNICO";
        }
    }
    return $value;
  }
  /**/
  function get_costo_envio($param){
    /**/
    $flag_envio_gratis =  $param["flag_envio_gratis"];
    $data_complete = [];
    /**/
    if($flag_envio_gratis ==  1){      
      
      $data_complete["costo_envio_cliente"]= 0;
      $data_complete["costo_envio_vendedor"]= 100;
      /**/
      $data_complete["text_envio"] =  
      texto_costo_envio_info_publico(
        $flag_envio_gratis, 
        $data_complete["costo_envio_cliente"], 
        $data_complete["costo_envio_vendedor"]);
    }else{

      $data_complete["costo_envio_cliente"]= 100;
      $data_complete["costo_envio_vendedor"]= 0;
      $data_complete["text_envio"] =  
      texto_costo_envio_info_publico(
        $flag_envio_gratis , 
        $data_complete["costo_envio_cliente"] , 
        $data_complete["costo_envio_vendedor"]);
    }
    return $data_complete;
  }
  /**/
  function texto_costo_envio_info_publico(
    $flag_envio_gratis , 
    $costo_envio_cliente , 
    $costo_envio_vendedor){
    
    $data_complete = [];
            
    if($flag_envio_gratis > 0){

      $text ="<span class='white' style='padding: 5px;background:#006fff!important;'>
                <span style='background:#f7f7ff !important; color:black;padding:3px;font-size:.9em;'> 
                  <i class='fa fa-bus'></i> 
                  Envío GRATIS!
                </span>
              </span>";
      $data_complete["cliente"] = $text;
      $data_complete["cliente_solo_text"] = "Envío GRATIS!";

      $data_complete["ventas_configuracion"] = "Tu precio ya incluye el envío";
     
    }else{
        

      $data_complete["ventas_configuracion"] = "El cliente paga su envío, no gastas por el envío";
      $text ="<span class='white' style='padding: 5px;background:#006fff!important;'>
                <span style='background:#f7f7ff !important; color:black;padding:3px;font-size:.8em;'> 
                  <i class='fa fa-bus'>
                  </i>  
                  Más ".$costo_envio_cliente." MXN de envío
                </span>
              </span>";
      $data_complete["cliente_solo_text"] = "Más ".$costo_envio_cliente." MXN de envío";
      $data_complete["cliente"] = $text;
      
      
    }
    return $data_complete;
  }
  /**/
  function porcentajes_ventas_mayoreo($costo){

    $nuevo_precio =  porcentaje($costo, 15 ,2);
    return $costo + $nuevo_precio;    
  }
  /**/
  function porcentajes_ventas($precio){    
    
    $data["precio"] =  $precio;
    $data["comision_venta"] =  floatval($precio)*(.07);
    return $data;
  }
  /**/
  function porcentaje($cantidad,$porciento,$decimales){
    return number_format($cantidad*$porciento/100 ,$decimales);
  }
  /**/
  function get_info_usuario_valor_variable($q2 , $campo ){

    $id_usuario_envio =0;
    if(isset($q2[$campo]) && $q2[$campo] != null ){             
        $id_usuario_envio =$q2[$campo];
    }
    return $id_usuario_envio;

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
  function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
  /**/
  function now_enid(){
    return  date('Y-m-d');
  } 
  /**/
  function get_random(){
    return  mt_rand();       
  }
  /**/
  function evalua_accion_ticket($status){
    /*0 abierto, 1 cerrado , 2 en visto*/

    $btn  ="";

    if ($status == 0){

      $btn  ="    <button  class='btn btn_mod_ticket'  style='background:#E71E06!important;' id='1' >
                    Cerrar Ticket
                  </button>
                  "; 
  
    }else{
      $btn  ="    <button  class='btn btn_mod_ticket'  style='background:blue!important;' id='0' >
                    Abrir Ticket
                  </button>";
    }



    
    return $btn;
  }
  /**/
  function evalua_status_ticket($valor_actual , $valor_real){

    if ($valor_real ==  $valor_actual) {
      return "selected";
    }
  }
  /**/
  function get_nombre_ciclo_facturacion($cliclo){

    $cliclos = ["", "Anual" , "Mensual" , "Semanal" , "No aplica"];
    return $cliclos[$cliclo];
  }
  /**/
  

  function get_nombre_estados_pago($estado){

    $estados = ["Pendiente" , "Liquidado" , "Suspendido" , "Lista negra" , "En desarrollo" ];
    return $estados[$estado];
  }
  /**/
  function get_nombre_estados_proyecto($estado,  $dias_restantes  ,  $ciclo_facturacion){


    $estados = ["Inactivo" , 
                "Activo" , 
                "Suspendido" , 
                "Lista negra" , 
                "En desarrollo" , 
                "Próximo a expirar" ];
                $nuevo_estado =  $estados[$estado];

    if( $dias_restantes == 0){      
      $nuevo_estado =  $estados[2];
    }if($ciclo_facturacion == "1" && $dias_restantes < 45  &&  $dias_restantes > 0 ){
      $nuevo_estado =  $estados[5];
    }if($ciclo_facturacion == "2" && $dias_restantes < 7  &&  $dias_restantes > 0 ){
      $nuevo_estado =  $estados[5];
    }if($dias_restantes < 0 ){      
      $nuevo_estado =  $estados[2];
    }if($dias_restantes < 0 && abs($dias_restantes) > 15 ){      
      $nuevo_estado =  $estados[0];
    }
    
    return $nuevo_estado;
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
  function titulo_enid_w($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service_w'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  
  function get_td($val , $extra = '' ){
    return "<td ". $extra ." nowrap NOWRAP >". $val ."</td>";
  }

  function get_td_val($val , $extra){
    if ($val!="" ) {
      return "<td style='font-size:.71em !important;' ". $extra .">". $val ."</td>";  
    }else{
      return "<td style='font-size:.71em !important;' ". $extra .">0</td>";
    }    
  }
  /**/
}/*Termina el helper*/