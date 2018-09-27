<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

    function create_table_blog($data)
    {
        
        $titulo           = "";
        $id_categoria     = "";
        $fecha_registro   = "";
        $l                = "";
        $z                = 1;

        foreach ($data as $row) {
          
          $id_categoria  =  $row["id_categoria"];
          $categoria ="";
          
          $url     =  "../faq/?faq=".$row["id_faq"];   
          $l      .=  "<tr>";
          $l      .=  get_td($z);
          $l      .=  get_td(anchor_enid($row["titulo"] ));     
          $l      .=  "</tr>";
          $z ++;
        }

      
    }
}

