<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){


  function create_select_colonia($data , $name , $class , $id , $text_option , $val ){
    $select ="<select name='". $name ."'  class='".$class ."'  id='". $id ."'> ";
      $select .=  "<option value='0'>Seccione </option>";
      foreach ($data as $row) {      
        $select .=  "<option value='". $row[$val] ."'>". $row[$text_option]." </option>";
      }
    $select .="</select>";
    return $select;
  }

}

