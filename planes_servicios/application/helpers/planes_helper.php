<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

    if ( ! function_exists('valida_action'))
    {
        function valida_action($param , $key ){

            $action =0;
            if ( get_param_def($param , $key) !== 0 ) {
                $action = $param[$key];
                switch ($action) {
                    case 'nuevo':
                      $action = 1;
                      break;
                    case 'vender':
                      $action = 1;
                      break;
                    case 'lista':
                      $action = 0;
                      break;
                    case 'editar':
                      $action = 2;
                      break;
                   default:
                     break;
                 }
            }
            return $action;
        }
    }
    if ( ! function_exists('valida_active_tab'))
    {
        function valida_active_tab($seccion , $valor_actual , $considera_segundo =0 ){
            $response =  " active ";
            if ($considera_segundo == 0 ) {
                $response = ($seccion ==  $valor_actual) ? " active ": "";
            }
            return $response;
        }
    }

}