<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  /**/
  function valida_atencion($dias_uso  , $eventos_publicados){
    
    $alert = "class='f-enid' ";
    if ($dias_uso > 0 && $eventos_publicados == 0){      
      $alert =   "class='alert-uso' ";
    }
    return $alert; 
  }
  /**/
  function valida_uso($val){
      

      if($val ==   0 ){
          return  "hoy";
      }else{
          return $val;
      }
  }
  /**/
  function valida_num_eventos($val){
    if ($val ==  null ){
      return  0;
    }else{
      return $val;
    }
  }
  /**/
  function get_msj_no_eventos($num){

      $msj =  "
        <label>
          Empresas 
          ".$num."
        </label>";
      return $msj;

  }

}/*Termina el helper*/