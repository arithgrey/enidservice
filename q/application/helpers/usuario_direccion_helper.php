<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  function val_btn_pago($param , $id_proyecto_persona_forma_pago){
  
    $btn =    anchor_enid("Liquida ahora!" , 
      [
        'class' => 'resumen_pagos_pendientes ' ,
                  'id'    =>  $id_proyecto_persona_forma_pago,
                  'href'  =>  '#tab_renovar_servicio',
                  'data-toggle' => 'tab'
      ]);
    

    if(get_info_usuario_valor_variable($param , "externo") == 1){
      
      $url ="../forma_pago/?recibo=".$id_proyecto_persona_forma_pago;
      $extra="";

      $f_btn =   anchor_enid("LIQUIDAR AHORA!" , 
                  array(
                  'class' => 'resumen_pagos_pendientes' ,
                  'id'    =>  $id_proyecto_persona_forma_pago,
                  'href'  =>  $url,
                  'style' => 'color: white!important;background:black;padding: 5px;'
                ));

      $s_btn =   anchor_enid("ACCEDE A TU CUENTA PARA VER EL ESTADO DE TU PEDIDO" , 
                  array(
                  'class' => 'resumen_pagos_pendientes' ,
                  'id'    =>  $id_proyecto_persona_forma_pago,
                  'href'  => '../area_cliente/?action=compras',
                  'style' =>  'color:black;'

                ));

      
      
      $contenido  =  add_element($f_btn , "div");
      $contenido .=  add_element($s_btn , "div");
      return $contenido;     
    }
    return $btn;
  }
  
}