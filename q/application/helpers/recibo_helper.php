<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  function create_resumen_pedidos($recibos , $lista_estados){

    $default = ["class" => "header_table_recibos"];
    $tb  = "<hr class='top_20'>
    <table class='table_enid_service top_20' >
          <thead>";
      $tb  .= "<tr class='header_table'>";
        $tb  .= get_th("ORDEN",  $default);
        $tb  .= get_th("", $default);
        $tb  .= get_th("STATUS", $default);
        $tb  .= get_th("TIPO ENTREGA", $default);
        $tb  .= get_th("SALDO CUBIERTO", $default);
        $tb  .= get_th("MONTO COMPRA", $default);
        $tb  .= get_th("ENTREGA", $default);
      $tb  .= "</thead></tr><tbody>";
    foreach ($recibos as $row) {
      
      $recibo                   = $row["recibo"];
      $saldo_cubierto           = $row["saldo_cubierto"];
      $fecha_registro           = $row["fecha_registro"];
      $monto_a_pagar            = $row["monto_a_pagar"];

      $num_ciclos_contratados   = $row["num_ciclos_contratados"];
      $costo_envio_cliente      = $row["costo_envio_cliente"];
      $monto_a_pagar            = ($monto_a_pagar * $num_ciclos_contratados)+$costo_envio_cliente;
      $cancela_cliente          = $row["cancela_cliente"];
      $se_cancela               = $row["se_cancela"];
      $status                   = $row["status"];
      $fecha_contra_entrega     = $row["fecha_contra_entrega"];
      $tipo_entrega        = $row["tipo_entrega"];
      $fecha_entrega                  = $row["fecha_entrega"];
      
      $estado_compra            =  ($se_cancela == 1 || $cancela_cliente == 1 ) ? "CANCELACIÓN" : 0;
      $estado_compra            =  
      ($estado_compra == 0 ) ? get_text_status($lista_estados, $status)  : $estado_compra;
      $tipo_entrega             = ($tipo_entrega == 1) ? "PAGO CONTRA ENTREGA": "MENSAJERÍA";


      $entrega = ($tipo_entrega ==  1) ? $fecha_contra_entrega : $fecha_entrega;

      
      
      $extra = ($status == 9) ? "entregado" : "";
      

      $tb   .= "<tr id='".$recibo."' class='desglose_orden cursor_pointer ".$extra."' >";

      $id_servicio =  $row["id_servicio"];
      $url_img     =  "../imgs/index.php/enid/imagen_servicio/".$id_servicio;
      $img    = img(["src"=> $url_img , "style"=>"width: 40px !important"]);
        $tb  .= get_td($recibo);
        $tb  .= get_td($img);
        $tb  .= get_td($estado_compra);
        $tb  .= get_td($tipo_entrega);
        $tb  .= get_td($saldo_cubierto."MXN");        
        $tb  .= get_td($monto_a_pagar."MXN");  
        $tb  .= get_td($entrega);  
        
      $tb  .= "</tr>";
      
    }
    
    $tb  .= "</tbody>";
    $tb  .= "</table>";
    return $tb;
  }
  function get_text_status($lista, $estado_compra){

    foreach ($lista  as $row) {
      
      $id_estatus_enid_service = $row["id_estatus_enid_service"];  
      if ($estado_compra ==  $id_estatus_enid_service) {
          return strtoupper($row["text_vendedor"]);
      }
    }
  }
  function get_link_paypal($saldo_pendiente){
      
    if ($saldo_pendiente > 0) {
      /*Aplico la comisión del paypal 3**/
      $comision_paypal   =  porcentaje($saldo_pendiente,3.7); 
      $saldo             = $saldo_pendiente + $comision_paypal;
      return "https://www.paypal.me/eniservice/".$saldo;        
    }
    return 0;  
    
  }  
  /**/
  function get_link_saldo_enid($id_usuario , $id_recibo){
    return  "../movimientos/?q=transfer&action=8&operacion=".$id_usuario."&recibo=".$id_recibo;    
  }
  /**/
  function get_link_oxxo($url_request, $saldo , $id_recibo , $id_usuario){      
    
    $url   =  $url_request ."orden_pago_oxxo/?q=".$saldo."&q2=".$id_recibo."&q3=".$id_usuario;
    $url   = ($saldo > 0 && $id_recibo > 0  && $id_usuario >0 ) ? $url : "";
    return $url;

  }
  /**/
  function get_saldo_pendiente($monto, 
    $ciclos, 
    $cubierto ,     
    $envio_cliente,  
    $envio_sistema,
    $tipo_entrega){

    

    $cubierto       =   ($cubierto < 0 ) ? 0 : $cubierto;    
    $total          =   ($monto > 0  && $ciclos > 0 ) ? ($monto * $ciclos ) - $cubierto : 0;      
    $text_envio     =   "";
    $cargo_envio    =   0;


    if ($tipo_entrega ==  2 || $tipo_entrega ==  4) {

        $text_envio         =  $envio_sistema["text_envio"]["cliente"];   
        $cargo_envio        =  $envio_sistema["costo_envio_cliente"];
 

    }else{

      /*Lo que pertenece a puntos de encuentro*/      
      $text_envio =  
      ($envio_cliente > 0) ? 
      "Cargos de entrega ".$envio_cliente."MXN":$envio_sistema["text_envio"]["cliente"];  


      $cargo_envio =  ($envio_cliente > 0) ? $envio_cliente : 0; 
            
    }    

    $total_mas_envio            =   $total + $cargo_envio;
    $response =  [
        'saldo_pendiente'       =>  $total ,          
        'text_envio'            =>  $text_envio,
        'total_mas_envio'       =>  $total_mas_envio
    ];
    return $response;
      
  }
  /**/
  function crea_data_deuda_pendiente($param){

      $data_complete["cuenta_correcta"] =0;
      if(count($param)>0){

          $recibo                                 =  $param[0];
          $precio                                 =  $recibo["precio"];           
          $num_ciclos_contratados                 =   $recibo["num_ciclos_contratados"]; 
          $costo_envio_cliente                    =   $recibo["costo_envio_cliente"];
          $saldo_pendiente                        =   
          ($precio * $num_ciclos_contratados) + $costo_envio_cliente;
          $data_complete["saldo_pendiente"]       =   $saldo_pendiente;
          $data_complete["cuenta_correcta"]       =   1;
          $data_complete["resumen"]               =  $recibo["resumen_pedido"];
          $data_complete["costo_envio_cliente"]   =  $recibo["costo_envio_cliente"];
          $data_complete["flag_envio_gratis"]     =  $recibo["flag_envio_gratis"];
          $data_complete["id_recibo"]             =  $recibo["id_proyecto_persona_forma_pago"];
          $data_complete["id_usuario"]            =  $recibo["id_usuario"];
          $data_complete["id_usuario_venta"]      =  $recibo["id_usuario_venta"];

      }
      return $data_complete;
      
  }
  function get_texto_saldo_pendiente($monto_a_liquidar , $monto_a_pagar , $modalidad_ventas){

    $texto ="";
    if($modalidad_ventas == 1){
        
        if($monto_a_liquidar >0){      
            $text = div("MONTO DE LA COMPRA" , 
                      [  "class"   =>  'text-saldo-pendiente']) .
                    div($monto_a_pagar."MXN" , 
                        ["class"  =>  "text-saldo-pendiente-monto"]);
        }             
    }else{

        if($monto_a_liquidar >0){         
            
            $text  = div("SALDO PENDIENTE" , ["class"   =>  'text-saldo-pendiente']);
            $text .= div($monto_a_liquidar."MXN" , ["class"  =>  "text-saldo-pendiente-monto"]);  
        }

    }
    return div($texto , ["class"=>'contenedor-saldo-pendiente']);                     

  }
  
  function monto_pendiente_cliente($monto,$saldo_cubierto,$costo,$num_ciclos){
    
      $total_deuda  =  $monto * $num_ciclos;  
      return $total_deuda + $costo;  
  }
  function evalua_acciones_modalidad_anteriores($num_acciones , $modalidad_ventas){
    
    $text = "";
    if($num_acciones > 0){      
      if($modalidad_ventas ==  1){        
        $text =  ($num_acciones >1) ? "MIRA TUS ÚLTIMAS $num_acciones  VENTAS" :  "MIRA TUS ULTIMAS VENTAS";  
      }else{
        $text = "MIRA TUS ÚLTIMAS COMPRAS";          
      } 
      $config = ["class"=> "a_enid_black ver_mas_compras_o_ventas"];
      return anchor_enid($text , $config);    
    }
    return $text;
  }
  function evalua_acciones_modalidad($en_proceso , $modalidad_ventas){

    $text ="";
    $flag =0;
    $simbolo =icon("fa  fa-fighter-jet");
    if($modalidad_ventas == 0 && $en_proceso["num_pedidos"]>0){
        $flag       ++;
        $num        = $en_proceso["num_pedidos"];
        $text   = ($num>1) ? $simbolo." TUS ".$num." PEDIDOS ESTÁN EN CAMINO " : $simbolo." TU PEDIDO ESTÁ EN CAMINO ";
    }
    if($modalidad_ventas == 1 && $en_proceso["num_pedidos"]>0){
        $flag ++;
        $num  = $en_proceso["num_pedidos"];
        $text = ($num>1) ? $simbolo." ENVIASTÉ $num PAQUETES QUE  ESTÁN POR LLEGAR A TU CLIENTE" : $simbolo." TU ENVÍO ESTÁ EN CAMINO " ;
        
    }
    
    $final =  (strlen($text) > 10 ) ? div( $text, ["class"=>"alert alert-info text-center"]) : $text; 
    return $final;

  }  
  function get_numero_articulos_en_venta_usuario($modalidad , $numero_articulos_en_venta){

      if ($modalidad == 1) {
              
        $link = anchor_enid(
                icon("fa fa-cart-plus"). " Artículos en promoción" , 
                [ "href" =>  '../planes_servicios/', 
                  "class"=>'vender_mas_productos']
                );

        $link2 = anchor_enid(
                " Agregar" , 
                [ 
                  "href" =>  '../planes_servicios/?action=nuevo', 
                  "class"=>'vender_mas_productos']
                );

        return div($link . $link2 , 1);
      }
  }
  function evalua_texto_envios_compras($modalidad_ventas , $num_orden , $tipo){ 
    
    $text ="";
    
    switch($tipo) {
      case 1:      
        if($modalidad_ventas ==  1){                  
            $text="DATE PRISA MANTÉN EXCELENTE REPUTACIÓN ENVIA TU ARTÍCULO EN VENTA DE FORMA PUNTUAL";

            $text_2="
                Date prisa, 
                mantén una buena reputación enviando 
                tus  $num_orden articulos vendidos de forma puntual";    
            $text = ($num_orden == 1)?$text : $text_2;
            
        }
        
      break;


       case 6:      
        if($modalidad_ventas ==  0){                  
            $text="DATE PRISA REALIZA TU COMPRA ANTES DE QUE OTRA PERSONA SE LLEVE TU 
                  PEDIDO!";            
        }        
      break;
            
      default:
      
      break;
    }        
    return $text;
  }
  function get_text_direccion_envio($id_recibo , $modalidad_ventas , $direccion_registrada,$estado_envio ){

      $texto ="";
      if($modalidad_ventas == 0){
        
        if($direccion_registrada ==  1){        
            switch ($estado_envio){
              case 0:
                $texto = icon("fa fa-bus")."A LA BREVEDAD EL VENDEDOR TE ENVIARÁ TU PEDIDO";
                break;
              
              default:
                $texto =icon('fa fa-bus btn_direccion_envio' , ["id"=> $id_recibo ])."DIRECCIÓN DE ENVÍO";    
                break;
            }
            
        }else{
            $texto =icon('fa fa-bus btn_direccion_envio' , ["id"=>$id_recibo ]). 
            "¿DÓNDE ENVIAMOS TU PEDIDO?";
        }
      }else{
        
        if($direccion_registrada ==  1){  
            $texto =icon('fa fa-bus btn_direccion_envio', ["id" => $id_recibo]) ."VER DIRECCIÓN DE ENVÍO";
        }
      }

      return $texto;
    }
  
  function get_estados_ventas($data , $indice ,$modalidad_ventas){

    $nueva_data = []; 
    $estado_venta ="";   
    foreach ($data as $row){      
        $id_estatus_enid_service = $row["id_estatus_enid_service"];
        if($id_estatus_enid_service ==  $indice) {        
          if($modalidad_ventas ==  1){          
            $estado_venta = $row["text_vendedor"];  
          }else{
            $estado_venta = $row["text_cliente"];  
          }          
          break; 
        }
    }
    return $estado_venta;
  }
  function carga_estado_compra($monto_por_liquidar, $id_recibo , $status, $status_enid_service, $vendedor=0){
        
        $extra_tab_pagos  = 'href="#tab_renovar_servicio" data-toggle="tab" ';
        $estilos          = "";
        $text             = "";        
        if($vendedor ==  1) {

            $text = div("DETALLES DE LA COMPRA" , 
              [
                "class"       => 'resumen_pagos_pendientes',
                "id"          => $id_recibo,
                "href"        => "#tab_renovar_servicio",
                "data-toggle" => "tab"
              ]);

        }else{          
            if($monto_por_liquidar <= 0){      
              
              $text = div(icon('fa fa-check-circle'). "COMPRA REALIZADA" , 
              [
                "class"       => 'resumen_pagos_pendientes',
                "id"          => $id_recibo,
                "href"        => "#tab_renovar_servicio",
                "data-toggle" => "tab"
              ]);

            }else{  


              $estilos = "";
              $text = div(icon('fa fa-credit-card-alt'). "LIQUIDAR AHORA!" , 
              [
                "class"       => 'resumen_pagos_pendientes',
                "id"          => $id_recibo,
                "href"        => "#tab_renovar_servicio",
                "data-toggle" => "tab"
              ]);
                            
            }  
        }
        return div($text , ["class"=>'btn_comprar']);
  }
    
  function texto_costo_envio_info_publico(
    $flag_envio_gratis , $costo_envio_cliente , $costo_envio_vendedor){

    $data_complete = [];        
    if($flag_envio_gratis > 0){

      $text                     = "ENVÍO GRATIS!";
      $data_complete["cliente"] = $text;
      $data_complete["cliente_solo_text"]     = "ENVÍO GRATIS!";
      $data_complete["ventas_configuracion"]  = 
      "TU PRECIO YA INCLUYE EL ENVÍO";
    }else{        
      $data_complete["ventas_configuracion"]  = 
      "EL CLIENTE PAGA SU ENVÍO, NO GASTA POR EL ENVÍO";      
      $text                                   = "MÁS ".$costo_envio_cliente." MXN DE ENVÍO";
      $data_complete["cliente_solo_text"]     = "Más ".$costo_envio_cliente." MXN de envío";
      $data_complete["cliente"] = $text;      
    }
    return $data_complete;
  }
    function valida_texto_periodos_contratados($periodos, $flag_servicio , $id_ciclo_facturacion){
    
    $text ="";
    if($flag_servicio ==  1){

        $ciclos =[
        "",
        "Anualidad",
        "Mensualidad",
        "Semana",
        "Quincena",
        "",
        "Anualidad a 3 meses",
        "Anualidad a 6 meses",
        "A convenir"];
        
        $ciclos_largos =[
        "",
        "Anualidades",
        "Mensualidades",
        "Semanas",
        "Quincenas",
        "",
        "Anualidades a 3 meses",
        "Anualidades a 6 meses",
        "A convenir"];
        $text_ciclos = "";

        if($periodos>1){
          $text_ciclos =$ciclos_largos[$id_ciclo_facturacion];
        }else{
          $text_ciclos =$ciclos[$id_ciclo_facturacion];
        }
        

        $text = "Ciclos contratados: ".$periodos." ".$text_ciclos;        
    }else{
        $text = ($periodos > 1) ? "Piezas ":"Pieza ";
        $text = heading_enid($periodos." ".$text , 3); 
    }    
    return $text;
  }
  function get_text_modalidad_compra($modalidad , $ordenes ){

    $text = ($modalidad == 1 ) ? "TUS VENTAS"  : "TUS COMPRAS";
    if ($modalidad ==  0 && $ordenes  == 0) {
      return "";
    }
    return heading_enid($text , 2);
      
  }

  function get_mensaje_compra($modalidad , $ordenes){

    /*Compras*/
    if ($modalidad == 0 && $ordenes == 0) {
        $final =  div(img([
            "src" => "../img_tema/tienda_en_linea/carrito_compra.jpg" ,
            "class" => "img_invitacion_compra" 
        ])
        ,
        ["class" => "img_center_compra"]
      );

      $final  = anchor_enid($final , ["href" => "../"]);   
      $final .= anchor_enid(heading_enid("EXPLORAR TIENDA", 3 , ["class" => "text-center text_explorar_tienda"]), 
        [
          "href" => "../"
        ]);
      return $final;



    }
  }

}