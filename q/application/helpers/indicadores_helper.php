<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  function porcentaje($total, $parte, $redondear = 2) {

    if(is_numeric($total) ==  is_numeric($parte)) {      
      if ($total>0 && $parte > 0 ){
        return round($parte / $total * 100, $redondear);  
      }else{
        return 0;
      }
      
    }else{
      return 0;
    }    
  }


}/*Termina el helper*/