<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
  
  /**/
  function get_correos_disponibles($info_mail_marketing){
    
    $repo =  "";
    
    foreach ($info_mail_marketing as $row){
      
      $disponibles = $row["disponibles"];
      $disponibles_sw = $row["disponibles_sw"];
      $disponibles_adw = $row["disponibles_adw"];
      $disponibles_tl = $row["disponibles_tl"];
      $disponibles_crm = $row["disponibles_crm"];
      

      $repo .="<tr>";
        $repo .= get_td($disponibles , " class='text-tb' ");
        $repo .= get_td($disponibles_sw , " class='text-tb' ");
        $repo .= get_td($disponibles_adw , " class='text-tb' ");
        $repo .= get_td($disponibles_tl , " class='text-tb' ");
        $repo .= get_td($disponibles_crm , " class='text-tb' ");
        
      $repo .="</tr>";

    }
    
    return  $repo;


  }

}/*Termina el helper*/