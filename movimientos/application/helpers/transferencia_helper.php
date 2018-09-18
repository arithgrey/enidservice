<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){ 	
  
  if ( ! function_exists('get_resumen_cuenta'))
  {
    function get_resumen_cuenta($text){

      return  substr($text, 0 ,4) . "********";
    }
  }
  /**/
  function agrega_cuentas_existencia($flag_cuentas){

  	if($flag_cuentas == 0){
  		return "Asociar nueva cuenta";
  	}else{
  		return "Asociar otra cuenta";
  	}	
  } 		
  /**/
  function valida_siguiente_paso_cuenta_existente($flag_cuentas_registradas){
    /**/  
    if($flag_cuentas_registradas ==  0){
       return  "readonly";
    }
  }
  /**/
  function despliega_cuentas_registradas($cuentas){

  	$option = "";
  	foreach($cuentas as $row){
  		/**/		
  		$id_cuenta_pago = $row["id_cuenta_pago"];
  		$numero_tarjeta = $row["numero_tarjeta"];
  		$nuevo_numero_tarjeta =  substr($numero_tarjeta, 0 , 4);
  		$nombre = "Cuenta - " .$row["nombre"] ." " .$nuevo_numero_tarjeta."************";
  		$option .= add_option_select($nombre , $id_cuenta_pago );
  	}
  	return $option;
  }
  /**/
  function add_option_select($text , $value){

  	return "<option value='".$value."'>".$text."</option>";
  }
  function valida_nombre_propietario($nombre_persona , $propietario_tarjeta ){
      return $nombre_persona; 
  }

}/*Termina el helper*/