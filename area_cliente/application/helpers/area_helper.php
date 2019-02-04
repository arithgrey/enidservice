<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){  
  function crea_alcance($alcance){

    $maximo   =   $alcance[0]["maximo"];
    $minimo   =   $alcance[0]["minimo"];
    $promedio =   $alcance[0]["promedio"];
    
    $text =  heading_enid("ALCANCE DE TUS PRODUCTOS" , 3 );
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
      
    if(strlen($estatus) > 0 ){
      $status =  ($nombre_seccion ==  $estatus)? " active " : "";
    }else{
      $status = ($nombre_seccion == "compras") ? " active " : "";
    }  
    return $status;
  }
  function get_menu($action){
      $a_tab_pagos = anchor_enid("",
          [
              "href" => "#tab_pagos",
              "data-toggle" => "tab",
              "class" => 'black strong tab_pagos',
              "id" => 'btn_pagos'
          ]);

      $a_vendedor = anchor_enid("VENDER",
          [
              "href" => "../planes_servicios/?action=nuevo",
              "class" => "white",
              "style" => "color: white!important"
          ]);

      $icon = icon('fa fa-shopping-bag');
      $place_mis_ventas = place("place_num_pagos_notificados");
      $a_mis_ventas = anchor_enid($icon . "TUS VENTAS" . $place_mis_ventas,
          ["id" => "mis_ventas",
              "href" => "#tab_mis_ventas",
              "data-toggle" => "tab",
              "class" => 'black strong btn_mis_ventas']);


      $icon = icon('fa fa-credit-card-alt');
      $place = place("place_num_pagos_por_realizar");
      $a_mis_compras = anchor_enid($icon . "TUS COMPRAS" . $place,
          ["id" => "mis_compras", "href" => "#tab_mis_pagos", "data-toggle" => "tab", "class" => 'black strong btn_cobranza mis_compras']);

      $a_lista_deseo = anchor_enid(icon("fa fa-gift") . "LISTA DE DESEOS",
          ["href" => "../lista_deseos/", "class" => 'black strong']);



      $list = [
          li( $a_tab_pagos , [ "class" => 'li_menu' , "style"=>"display: none;"]),
          li( $a_vendedor, ["class"=>"li_menu menu_vender ".valida_active_tab('ventas', $action)] ),
          li($a_mis_ventas  , ["class"=>'li_menu']),
          li($a_mis_compras, ["class"=>'li_menu '.valida_active_tab('compras', $action)]),
          li($a_lista_deseo,["class"=>'li_menu'])

      ];
      return ul($list, ["class"=>"nav tabs"]);
  }

}