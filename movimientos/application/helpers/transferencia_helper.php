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

    if ( ! function_exists('get_data_saldo'))
    {
        function get_data_saldo($saldo){

            $text = ( get_param_def( $saldo , "saldo") > 0  ) ?  $saldo["saldo"] : 0;
            return $text;
        }
    }

    if ( ! function_exists('get_submenu'))
    {
        function get_submenu(){

            $list = [
                li(anchor_enid("Añadir ó solicitar saldo", ["href"=>"?q=transfer&action=6", "class"=>"black"]) , ["class" => "list-group-item"] ),
                li(anchor_enid("Trasnferir fondos ".icon("fa fa-fighter-jet") , ["href"=>"?q=transfer&action=2" , "class"=>"black"]  ) , ["class" => "list-group-item"] ),
                li(anchor_enid("Mis tarjetas y cuentas", ["href"=>"?q=transfer&action=3", "class"=>"black"] ) , ["class"=>"list-group-item metodo_pago_disponible"] ),
                li(anchor_enid("Asociar cuenta bancaria", ["href"=>"?q=transfer&action=1" , "class"=>"black"]) , ["class"=>"list-group-item metodo_pago_disponible"]),
                li(anchor_enid("Asociar tarjeta de crédito o débito".icon("fa fa-credit-card-alt") ,  ["href"=>"?q=transfer&action=1&tarjeta=1" , "class"=>"black"] ) , ["class"=>"list-group-item metodo_pago_disponible"])

            ];

            return ul($list, ["class"=>"list-group list-group-flush"]);
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
}