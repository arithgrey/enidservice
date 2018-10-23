<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){  
  function crea_alcance($alcance){

    $maximo   =   $alcance[0]["maximo"];
    $minimo   =   $alcance[0]["minimo"];
    $promedio =   $alcance[0]["promedio"];
    
    $text =  heading_enid("ALCANCE DE TUS PRODUCTOS" , 3 , []);    
    $text .=  "<table>";
    $text .=  "<tr>";
      $text .=  get_td($maximo  , ["class"=>'num_alcance', "id"=> $maximo ]);
      $text .=  get_td($promedio, ["class"=>'num_alcance']);
      $text .=  get_td($minimo,   ["class"=>'num_alcance', "id"=> $maximo  ]);
    $text .=  "</tr>";

    $text .=  "<tr>";
      $text .=  get_td("Tope" ,     ["class"=>'num_alcance'  ]);
      $text .=  get_td("Promedio",  ["class"=>'num_alcance' ]);
      $text .=  get_td("Mínimo",    ["class"=>'num_alcance' ]); 
    $text .=  "</tr>";
    $text .=  "</table>";

    return $text;
  }
  function valida_active_tab($nombre_seccion , $estatus){

    
    $status = "";
    if(strlen($estatus) > 0 ){    
      $status =  ($nombre_seccion ==  $estatus)? " active " : "";
    }else{
      $status = ($nombre_seccion == "compras") ? " active " : "";
    }  
    return $status;
  }

}