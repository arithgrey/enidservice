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

    $text = ($flag_cuentas == 0) ? "Asociar nueva cuenta" : "Asociar otra cuenta";
    return $text;
  } 		
  /**/
  function valida_siguiente_paso_cuenta_existente($flag_cuentas_registradas){
    $text = ($flag_cuentas_registradas ==  0) ? "readonly" : "";
    return $text;
  }
  /**/
  function despliega_cuentas_registradas($cuentas){

  	$option = "";
  	foreach($cuentas as $row){
  		/**/		
  		$id_cuenta_pago       =   $row["id_cuenta_pago"];
  		$numero_tarjeta       =   $row["numero_tarjeta"];
  		$nuevo_numero_tarjeta =   substr($numero_tarjeta, 0 , 4);
  		$nombre               =   "Cuenta - " .$row["nombre"] ." " .$nuevo_numero_tarjeta."************";
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
  function get_data_saldo($saldo){

      $text = ( get_param_def( $saldo , "saldo") > 0  ) ?  $saldo["saldo"] : 0;
      return $text;

  }

}/*Termina el helper*/