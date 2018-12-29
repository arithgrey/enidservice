<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

    if ( ! function_exists('get_call_to_action_registro'))
    {
        function get_call_to_action_registro($in_session){
            if ($in_session !=  1) {
                return anchor_enid("ACCEDE A TU CUENTA PARA SOLICITAR INFORMACIÓN!", [], 1);
            }
        }
    }

   
}