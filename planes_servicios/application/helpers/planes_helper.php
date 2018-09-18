<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

function valida_action($param , $key ){

    $action =0;
    if (is_array($param) && array_key_exists($key, $param) ) {
        $action = $param[$key];       
        switch ($action) {
            case 'nuevo':
              $action =1;
              break;
            case 'vender':
              $action =1;
              break;
            case 'lista':
              $action =0;
              break;
            case 'editar':
              $action =2;
              break;
           default:
             break;
         } 
    }
    
    return $action;
  } 
  /**/
  function valida_active_tab($seccion , $valor_actual , $considera_segundo =0 ){
      if ($considera_segundo == 0 ) {
        return ($seccion ==  $valor_actual) ? " active ": ""; 
      }else{        
          return " active ";           
      }      
  }  
  
  
}