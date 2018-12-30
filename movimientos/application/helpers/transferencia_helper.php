<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
    if ( ! function_exists('get_resumen_cuenta'))
    {
        function get_resumen_cuenta($text){
            return  substr($text, 0 ,4) . "********";
        }
    }
    if ( ! function_exists('agrega_cuentas_existencia'))
    {
        function agrega_cuentas_existencia($flag_cuentas){
            $text = ($flag_cuentas == 0) ? "Asociar nueva cuenta" : "Asociar otra cuenta";
            return $text;
        }
    }
    if ( ! function_exists('valida_siguiente_paso_cuenta_existente'))
    {
        function valida_siguiente_paso_cuenta_existente($flag_cuentas_registradas){
            $text = ($flag_cuentas_registradas ==  0) ? "readonly" : "";
            return $text;
        }

    }
    if ( ! function_exists('despliega_cuentas_registradas'))
    {
        function despliega_cuentas_registradas($cuentas){
            $option = "";
            foreach($cuentas as $row){

                $id_cuenta_pago       =   $row["id_cuenta_pago"];
                $numero_tarjeta       =   $row["numero_tarjeta"];
                $nuevo_numero_tarjeta =   substr($numero_tarjeta, 0 , 4);
                $nombre               =   "Cuenta - " .$row["nombre"] ." " .$nuevo_numero_tarjeta."************";
                $option .= add_option_select($nombre , $id_cuenta_pago );
            }
            return $option;
        }
    }
    if ( ! function_exists('add_option_select'))
    {
        function add_option_select($text , $value){
            return "<option value='".$value."'>".$text."</option>";
        }
    }
    /*
    if ( ! function_exists('valida_nombre_propietario'))
    {
        function valida_nombre_propietario($nombre_persona , $propietario_tarjeta ){
            return $nombre_persona;
        }
    }
    */
    if ( ! function_exists('get_data_saldo'))
    {
        function get_data_saldo($saldo){

            $text = ( get_param_def( $saldo , "saldo") > 0  ) ?  $saldo["saldo"] : 0;
            return $text;
        }
    }
}