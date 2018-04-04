<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  function get_url_servicio($id_servicio){

    return "../producto/?producto=".$id_servicio;
  }
  /**/
  function verifica_scroll_respuesta($num){

    if($num>4){
      return " scroll_chat_enid ";
    }
  }
  /**/
  function carga_imagen_usuario_respuesta($id_usuario){
      /**/
      return "../imgs/index.php/enid/imagen_usuario/".$id_usuario;
  }
  /**/
  function valida_respuestas_nuevas($modalidad , $param){

    $text ="";
    if($modalidad ==  0) {      
        $text = carga_iconos_buzon_compras($param);
    }else{  

      $text = carga_iconos_buzon_ventas($param);
    }
    return $text;
  }
  /**/
  function carga_iconos_buzon_ventas($param){

        /**/
        $id_pregunta =  $param["id_pregunta"];
        $pregunta =  $param["pregunta"];
        $fecha_registro =  $param["fecha_registro"];
        $id_usuario = $param["id_usuario"];
        $leido_vendedor =  $param["leido_vendedor"];        
        $respuestas =  $param["respuestas"][0];
        $num  = $respuestas["respuestas"];
        $nombre_servicio =  $param["nombre_servicio"];
        $id_servicio =  $param["id_servicio"];

        $base_servicio = " pregunta='".$pregunta."'
                            registro='".$fecha_registro."'
                            usuario =  '".$id_usuario."'
                            leido_vendedor =  '".$leido_vendedor."'
                            nombre_servicio ='".$nombre_servicio."' 
                            servicio = '".$id_servicio."' ";

        if($leido_vendedor == 0 ){
          
            $text ="<div class='pull-right'> 
                        <span 
                          style='font-size: .7em!important;padding:4px;' 
                          class='blue_enid_background white pregunta fa fa-envelope' 
                            id='".$id_pregunta."'
                            ".$base_servicio.">
                            
                            Nueva
                        </span>
                    </div>";                            
        }else{
          if($num<1){
            
            $num =  "";    
          }
              $text ="<div class='pull-right'> 
                        <span 
                          style='font-size: .7em!important;padding:4px;background:black;' 
                          class='white pregunta fa fa-envelope' id='".$id_pregunta."'
                            ".$base_servicio.">
                            
                            ".$num."
                        </span>
                    </div>";                            

        }      
        
        return $text;        
        
  }
  /**/
  function carga_iconos_buzon_compras($param){

        /**/
        $id_pregunta =  $param["id_pregunta"];
        $pregunta =  $param["pregunta"];
        $fecha_registro =  $param["fecha_registro"];
        $id_usuario = $param["id_usuario"];
        $leido_vendedor =  $param["leido_vendedor"]; 
        $leido_cliente =  $param["leido_cliente"];        
        $respuestas =  $param["respuestas"][0];
        $num  = $respuestas["respuestas"];
        $nombre_servicio =  $param["nombre_servicio"];
        $id_servicio =  $param["id_servicio"];
        $text ="";
        $base_servicio = " pregunta='".$pregunta."'
                            registro='".$fecha_registro."'
                            usuario =  '".$id_usuario."'
                            leido_vendedor =  '".$leido_vendedor."'
                            nombre_servicio ='".$nombre_servicio."' 
                            servicio = '".$id_servicio."' ";

        
        if($leido_cliente == 0 && $num > 0){      
            $text ="<div class='pull-right'> 
                        <span 
                          style='font-size: .7em!important;padding:4px;' 
                          class='blue_enid_background white pregunta fa fa-envelope' 
                            id='".$id_pregunta."'
                            ".$base_servicio.">
                            
                            Nueva respuesta
                        </span>
                    </div>";                            
        }else{
              
              if ($num > 0){
                  $text ="<div class='pull-right'> 
                        <span 
                          style='font-size: .7em!important;padding:4px;background:black;' 
                          class='white pregunta fa fa-envelope' 
                          id='".$id_pregunta."'
                            ".$base_servicio.">

                            
                            ".$num."
                        </span>
                    </div>";                              
              }
              
        }      
        return $text;        
        
  }
  
  /**/
  function get_texto_sobre_el_producto($modalidad , $param){

    $text ="";
    if($modalidad == 0){          
        $url_servicio = "../producto/?producto=".$param["id_servicio"];  
        $text = "<a href='".$url_servicio."' class='blue_enid'> 
                  <strong class='black'>
                    Sobre -
                  </strong> 
                  ".$param["nombre_servicio"]."</a>";
    }else{
        /**/
        $url_servicio = "../producto/?producto=".$param["id_servicio"];  
        $text = "<a href='".$url_servicio."' class='blue_enid'> 
                  <strong class='black'>
                    Sobre -
                  </strong> 
                  ".$param["nombre_servicio"]."</a>";
    }
    return $text;
  }  
  /**/
  function get_url_imagen_pregunta($modalidad , $param){
    if($modalidad == 0){
      $id_usuario_venta =  $param["id_usuario_venta"];
      $url_imagen =  "../imgs/index.php/enid/imagen_usuario/".$id_usuario_venta;
      return $url_imagen;
    }else{
      $id_usuario = $param["id_usuario"];
      $url_imagen =  "../imgs/index.php/enid/imagen_usuario/".$id_usuario;  
      return $url_imagen;
    }
    
  }
  /**/
  function get_texto_usuario($modalidad ,  $param){

    $texto ="";
    /**/
    if($modalidad == 0){
        $texto ="TU A - "; 
    }
    return $texto;
  }   
  /**/
  function get_titulo_preguntas_modalidad($modalidad){
    /**/
    $texto = "LO QUE PREGUNTASTÉ A VENDEDORES";  
    if($modalidad ==  1) {
      $texto = " LO QUE TE HAN PREGUNTADO";    
    }    
    return $texto;
  }   
  /**/
  function get_texto_por_modalidad($modalidad){

    $texto = "VENTAS";  
    if($modalidad ==  1) {
      $texto = "COMPRAS ";    
    }
    $texto_modalidad = "TU HISTORIAL DE ".$texto;
    return $texto_modalidad;
  }
  /**/
  function ver_totalidad_por_modalidad($modalidad , $total){

    $icon = "<i class='fa fa-shopping-bag'></i>"; 
    $texto_compras = $icon."TUS COMPRAS HASTA EL MOMENTO ".$total;
    if($modalidad == 1){
      $texto_compras = $icon."TUS VENTAS HASTA EL MOMENTO ".$total;
    }
    return $texto_compras;
  }
  /**/
  function evalua_acciones_modalidad_anteriores($num_acciones , $modalidad_ventas){

    $text = "";
    $a = "<div style='margin-top:20px;'>
              <a class='a_enid_black ver_mas_compras_o_ventas' style='color:white!important;'>";
    $a_end = "</a>
          </div>";    

    if($num_acciones > 0){      
      if($modalidad_ventas ==  1){        
        /**/          
        $text = $a."MIRA TUS ULTIMAS VENTAS".$a_end;  
        if($num_acciones >1){
          $text = $a."MIRA TUS ÚLTIMAS $num_acciones  VENTAS".$a_end;  
        }        
      }else{
        $text = $a."MIRA TUS ÚLTIMAS COMPRAS".$a_end;          
      } 
    }
    return $text;
    /**/
  }
  /*Evalua acciones en progreso*/ 
  function evalua_acciones_modalidad($en_proceso , $modalidad_ventas){

    $text ="";
    $flag =0;
    $simbolo ="<i class='fa fa-2x fa-fighter-jet'> </i>";
    /**/
    if($modalidad_ventas == 0 && $en_proceso["num_pedidos"]>0){
        $flag ++;
        $num = $en_proceso["num_pedidos"];
        $text = $simbolo." TU PEDIDO ESTÁ EN CAMINO ";
        if($num>1) {
            $text = $simbolo." TUS $num PEDIDOS ESTÁN EN CAMINO ";
        }  
        
    }
    /*Modalidad ventas*/
    if($modalidad_ventas == 1 && $en_proceso["num_pedidos"]>0){
        $flag ++;
        $num = $en_proceso["num_pedidos"];
        $text = $simbolo." TU ENVÍO ESTÁ EN CAMINO ";
        if($num>1) {
            $text = $simbolo." ENVIASTÉ $num PAQUETES QUE  ESTÁN POR LLEGAR A TU CLIENTE";
        }          
    }

    $panel_ini ="";
    $panel_end ="";
    if($flag >0 ){
      $panel_ini ='<div class="alert alert-info text-center" 
                        style="margin-top: 10px;background: 
                        #00264b;color: white;">';  
      $panel_end ="</div>";
    }

    return $panel_ini.$text.$panel_end;

  }
  /**/
  function evalua_texto_envios_compras($modalidad_ventas , $num_orden , $tipo){ 
    /*Tipo 1= nueva orden */
    $text ="";
    
    switch($tipo) {
      case 1:      
        if($modalidad_ventas ==  1){                  
            $text="
                Date prisa, 
                mantén una buena reputación enviando 
                tu artículo en venta de forma puntual";

            $text_2="
                Date prisa, 
                mantén una buena reputación enviando 
                <strong>
                tus 
                $num_orden articulos vendidos de forma puntual
                </strong>";    
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
  /**/
  function porcentaje($total, $parte, $redondear = 2) {
    if($total > 0 && $parte > 0 ){
      return round($parte / $total * 100, $redondear);
    }
    
  }
  /**/
  function crea_estrellas($calificacion , $sm=0){

      $estrellas_valoraciones ="";
      $restantes = ""; 
      $num_restantes =1;
      $size="2.4em";
      if($sm ==1 ){
            $size="1em";
      }
      for($x=1; $x <= $calificacion; $x++){ 
          
          $extra ="style='font-size: ".$size.";color: #0070dd;' ";
          $estrellas_valoraciones .="<label class='estrella' $extra >★</label>";
          $num_restantes ++;
      }
      /*Agregamos aquello que hace falta*/
      for($num_restantes; $num_restantes <= 5; $num_restantes++ ){ 
          $extra ="style='font-size: ".$size.";
                    -webkit-text-fill-color: white;
                    -webkit-text-stroke: 0.5px rgb(0, 74, 252);' ";
          $restantes  .="<label class='estrella' $extra >★</label>";
          
      }
      $estrellas =  $estrellas_valoraciones.$restantes;
      return $estrellas;
  }
  /**/
  function crea_resumen_valoracion_comentarios($comentarios , $respuesta_valorada){

      $lista_comentario ="";
      $a =0;
      foreach ($comentarios as $row){

        $id_valoracion= $row["id_valoracion"];
        $num_util = $row["num_util"];
        $num_no_util= $row["num_no_util"];
        $valoracion =$row["valoracion"];
        $titulo = $row["titulo"];
        $comentario =  $row["comentario"];
        $recomendaria =  $row["recomendaria"];
        $nombre = $row["nombre"];
        $fecha_registro =  $row["fecha_registro"];
        $fecha_registro= $row["fecha_registro"];

        $lista_comentario .="<div class='contenedor_global_recomendaciones'>
                            <div 
                              class='contenedor_valoracion_info' 
                              numero_utilidad='".$num_util."'
                              fecha_info_registro = '".$fecha_registro."'  >
                            <div >".crea_estrellas($valoracion ,1)."
                              </div>";
        $lista_comentario .="<div class='titulo_valoracion'>".$titulo."</div>";
        $lista_comentario .="<div class='comentario_valoracion'>".$comentario."</div>";

        if($recomendaria ==  1){
          $lista_comentario .="<div class='recomendaria_valoracion'>
                                  <i class='fa fa-check-circle'></i>
                                  Recomiendo este producto
                                </div>";          
        }
        $lista_comentario .="<div class='nombre_comentario_valoracion'>
                              <strong class='black' 
                                >".$nombre."</strong> - ".$fecha_registro."

                            </div>";

        $function_valoracion_funciona 
        = 'onclick="agrega_valoracion_respuesta('.$id_valoracion.' , 1)"';                    

        $function_valoracion_NO_funciona 
        = 'onclick="agrega_valoracion_respuesta('.$id_valoracion.' , 0)"';                    


        $texto_valoracion ="";
        if($respuesta_valorada ==  $id_valoracion){
            $texto_valoracion ="<span class='text_recibimos_valoracion'>
                                  Recibimos tu valoracion! 
                                </span>";
        }

        $lista_comentario .="<hr>
                            <div class='contenedor_utilidad'>
                              <table width='100%'>
                                <tr>
                                  <td>
                                    <strong>
                                      ¿Te ha resultado útil?
                                    </strong>
                                  </td>
                                  <td>
                                    <a class='respuesta_util' 
                                        id='".$id_valoracion."' 
                                      ".$function_valoracion_funciona.">
                                      <strong 
                                        class='respuesta_ok valorar_respuesta' 
                                        id='".$id_valoracion."'
                                        title='Da click para votar por esta respuesta'>
                                        SI 
                                      </strong>
                                      <span class='num_respuesta'>
                                        [".$num_util."]
                                      </span>
                                    </a>
                                    <a class='respuesta_util' id='".$id_valoracion."' 
                                    ".$function_valoracion_NO_funciona.">
                                      <strong 
                                        class='respuesta_no valorar_respuesta'
                                        id='".$id_valoracion."'
                                        title='Da click para votar por esta respuesta'
                                        
                                        >
                                        NO 
                                      </strong>
                                      <span class='num_respuesta'>
                                        [".$num_no_util."]
                                      <span>
                                    </a>
                                  </td>
                                </tr>
                                <tr>
                                  <td>
                                    ".$texto_valoracion."
                                  </td>
                                </tr>
                              </table>

                              
                            </div>
                          ";                    
        $lista_comentario .="<hr>";
        $a ++;
      }
      $lista_comentario .="</div>
                        </div>";
      return $lista_comentario;
  }
  /**/
  function crea_resumen_valoracion($numero_valoraciones ,  $persona =0){
    
      $mensaje_final ="de los consumidores recomiendan este producto";
      if($persona == 1){
          $mensaje_final ="de los consumidores recomiendan";          
      }
      $valoraciones =  $numero_valoraciones[0];
      $num_valoraciones =  $valoraciones["num_valoraciones"];
      $comentarios = $num_valoraciones." COMENTARIOS";
      $promedio =  $valoraciones["promedio"];
      $personas_recomendarian =  $valoraciones["personas_recomendarian"];



      $promedio_general=  number_format($promedio, 1, '.', '');            
      $parte_promedio =  "<div class='contenedor_promedios'> 
                            ".crea_estrellas($promedio_general)."
                            <span class='promedio_num'>".$promedio_general."</span>"."
                          </div>";
      $parte_promedio .= "<table width='100%' class='text-center'>
                            <tr>
                              ".get_td("<div class='info_comentarios'>".$comentarios."</div>")."
                            </tr>
                          </table>";

      $parte_promedio .= "<div class='porcentaje_recomiendan'>".
                            porcentaje($num_valoraciones, $personas_recomendarian ,1).
                            "%
                          </div>
                          <div>
                            <strong>
                              ".$mensaje_final."
                            </strong>
                          </div>";

      return $parte_promedio;
  }
  /**/
  function get_numero_articulos_en_venta_usuario($numero_articulos_en_venta){

      return "<div class='contenedor_ventas_info_basica'>
                
                <span>
                  <a href='../planes_servicios/' class='vender_mas_productos'>
                    <i class='fa fa-cart-plus'></i>
                      Artículos en promoción 
                    ".$numero_articulos_en_venta."                  
                  </a>
                  |
                  <a 
                    href='../planes_servicios/?action=ventas' 
                    class='vender_mas_productos black'>
                    Agregar
                  </a>
                </span>
              </div>";
  }
  /**/
  function get_text_direccion_envio(
          $id_recibo , 
          $modalidad_ventas , 
          $direccion_registrada,
          $estado_envio ){

      $texto ="";
      if($modalidad_ventas == 0){
        /*Verificamos que esté registrada la dirección*/        
        if($direccion_registrada ==  1){        
            /*Registrada más pagado =  en camino*/
            

            switch ($estado_envio){
              case 0:
                $texto ="<i class='fa fa-bus'></i> 
                      A LA BREVEDAD EL 
                      VENDEDOR TE ENVIARÁ TU PEDIDO";
                break;
              
              default:
                $texto ="<i class='fa fa-bus btn_direccion_envio' id='".$id_recibo."'></i> 
                      DIRECCIÓN DE ENVÍO";    
                break;
            }
            
        }else{


            $texto ="<i class='fa fa-bus btn_direccion_envio' id='".$id_recibo."'></i> 
                      ¿DÓNDE ENVIAMOS TU COMPRA?";
        }
      }else{
        /*Verificamos que esté registrada la dirección*/        
        if($direccion_registrada ==  1){  

            
            $texto ="<i class='fa fa-bus btn_direccion_envio' id='".$id_recibo."'></i> 
                      VER DIRECCIÓN DE ENVÍO";


        }
      }

      return $texto;
  }
  /**/
  function get_texto_saldo_pendiente($monto_a_liquidar , $monto_a_pagar , $modalidad_ventas){

    $texto ="";
    if($modalidad_ventas == 1){
        
        if($monto_a_liquidar >0){            
            $texto ="<span class='text-saldo-pendiente'> MONTO DE LA COMPRA </span>".
                    "<span class='text-saldo-pendiente-monto'>". $monto_a_pagar." MXN <span>";
        }             
    }else{

        if($monto_a_liquidar >0){            
            $texto ="<span class='text-saldo-pendiente'> SALDO PENDIENTE </span>".
                    "<span class='text-saldo-pendiente-monto'>".$monto_a_liquidar." MXN <span>";
        }

    }
    return "<div class='contenedor-saldo-pendiente'>".$texto."</div>";                     

  }
  /**/  
  function get_estados_ventas($data , $indice ,$modalidad_ventas){
    /**/        
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
  /**/
  function monto_pendiente_cliente($monto , $saldo_cubierto , $costo_envio_cliente , $num_ciclos){

      $monto_pedido =  $num_ciclos * $monto; 
      return ($monto_pedido + $costo_envio_cliente) - $saldo_cubierto;
  }
  /**/
  function valida_url_facebook($url_facebook){

    $url ="";
    if(strlen($url_facebook) > 5){    

      $url = "<iframe width='560' 
              height='315' 
              src='". $url_facebook ."'               
              allow='autoplay; encrypted-media' allowfullscreen>
              </iframe>";
    }
    return $url;
  }
  /**/
  function valida_url_youtube($url_youtube){

    $url ="";
    if(strlen($url_youtube)>5){    
      $url = "<iframe width='560' 
              height='315' src='".$url_youtube."' 
              frameborder='0' 
              allow='autoplay; encrypted-media' allowfullscreen>
              </iframe>";
    }
    return $url;
  }
  /**/
  function get_direccion_envio($monto_por_liquidar , 
                              $id_proyecto_persona_forma_pago , 
                              $proyecto ,
                              $estado ){

    $lista_info_attr = " info_proyecto= '$proyecto' info_status =  '$estado' ";
    $btn_config_direccion_envio = "<i  class='black btn_direccion_envio fa fa-bus'
                                        id='".$id_proyecto_persona_forma_pago."'  
                                    $lista_info_attr >
                                  </i>";            

    $btn_articulo_enviado = "<i class='black fa fa-bus'></i><br>
                                <span style='font-size:.8em;'>
                                  Enviado!
                                <span>";            

    $btn_direccion_envio = ($monto_por_liquidar <= 0) ? $btn_articulo_enviado : 
    $btn_config_direccion_envio;
    return $btn_direccion_envio;
  
  }
  /**/
  function carga_estado_compra($monto_por_liquidar, $id_recibo , $status, $status_enid_service,  
                               $vendedor=0){
        
        $extra_tab_pagos =' href="#tab_renovar_servicio" data-toggle="tab" ';
        $estilos = "style='width: 100%;
                    padding: 5px;
                    border-style: solid;
                    background: #19193c;
                    color: white;
                    '";

        $text = "";        

        if($vendedor ==  1) {
            $text =  "<span  
                            class='resumen_pagos_pendientes' 
                            id='".$id_recibo."' 
                            $extra_tab_pagos 
                            >
                            DETALLES DE LA COMPRA
                      </span>";
        }else{          
            if($monto_por_liquidar <= 0){                              
              $text =  "
              <span  
                class='resumen_pagos_pendientes' 
                id='".$id_recibo."' 
                $extra_tab_pagos >
                COMPRA REALIZADA
                <i class='fa fa-check-circle'></i>
              </span>";
            }else{  

              $estilos = "style='width: 100%;
              padding: 5px;
              border-style: solid;
              background: #1d0ff3;
              color: white;
              border-color: #1d0ff3;'";

              $text = "<span  
                            class='resumen_pagos_pendientes' 
                            id='".$id_recibo."' 
                            $extra_tab_pagos 
                            >
                              LIQUIDAR AHORA!
                              <i class='fa fa-credit-card-alt' id='".$id_recibo."'>
                              </i>                         
                      </span> ";                
            }  
        }
        

     
      return "<div class='btn_comprar'><span $estilos>".$text."</span></div>";
  }
  /**/
  function create_seccion_saldo_pendiente($saldo_pendiente){
    return $saldo_pendiente;
  }
  /**/  
  function create_notificacion_ticket($info_usuario ,  $param ,  $info_ticket){
      
      $usuario =  $info_usuario[0];       
      $nombre_usuario =  $usuario["nombre"] ." " . 
                         $usuario["apellido_paterno"] . 
                         $usuario["apellido_materno"] ." -  " .
                         $usuario["email"];

      
      $asunto_email = "Nuevo ticket abierto [".$param["ticket"]."]";

      $ticket =  "<label> 
                      Nuevo ticket abierto [".$param["ticket"]."]
                  </label>
                  <br>";                        

      $ticket .= "<div style='margin-top:20px;'>
                    <span>
                      Cliente que solicita ".$nombre_usuario."
                    </span>
                  </div>";                              

  
        $lista_prioridades =["" , "Alta" , "Media" , "Baja"];
        $lista =  "";
        $asunto = "";
        $mensaje = "";
        $prioridad = "";
        $nombre_departamento = "";

        foreach ($info_ticket as $row) {
              
          $asunto =  $row["asunto"]; 
          $mensaje =  $row["mensaje"];     
          $prioridad = $row["prioridad"];
          $nombre_departamento =  $row["nombre_departamento"]; 
           
        }

        $ticket .='
        <div style="margin-top: 20px;">
          <span>
            <strong>
              Prioridad:
            </strong>
          </span>  
          '.$lista_prioridades[$prioridad].'
        </div>
        <div style="margin-top: 20px;">
          <span>
            <strong>
              Departamento a quien está dirigido:
            </strong>
          </span>          
          '.$nombre_departamento.'
        </div>

        <div style="margin-top: 20px;">
          <span>
            <strong>
              Asunto:
            </strong>
          </span>            
          '.$asunto.'
        </div>

        <div style="margin-top: 20px;">
          <span>
            <strong>
              Reseña:
            </strong>
          </span>  
          '.$mensaje.'
        </div>';
            
      
      $msj_email["info_correo"] =  $ticket;    
      $msj_email["asunto"] =  $asunto_email;
      
      return $msj_email;
 
  }    
  /**/
  function valida_tipo_usuario_tarea($id_perfil){

    $text ="Equipo Enid Service";
    if ($id_perfil == 20) {        
        $text ="Cliente";
    }
    return $text;
  }
  /**/
  function valida_check_tarea($id_tarea ,  $valor_actualizar , $status , $id_perfil ){    
    

    if($id_perfil !=  20 ){
      
        $extra_checkbox =" "; 
        if ($status ==  1){
          $extra_checkbox =" checked  ";  
        }
        $input =" <input type='checkbox' 
                        class='tarea '                         
                        id='".$id_tarea ."' 
                        value='".$valor_actualizar."'
                        $extra_checkbox>";   
    }else{

      if($status == 1){
        $input =" Tarea terminada";
      }else{
        $input =" | En proceso";
      }

    }
    
    return $input;              

  }
  /**/
  function crea_tabla_resumen_ticket($info_ticket  , $info_num_tareas){
     

    $tareas =  $info_num_tareas[0]["tareas"];  
    $pendientes =  $info_num_tareas[0]["pendientes"];      

    
    /**/    
    $id_ticket =  ""; 
    $asunto =  ""; 
    $mensaje =  ""; 
    $status = "";
    $fecha_registro = "";    
    $prioridad = "";
    $id_proyecto = "";
    $id_usuario = "";
    $nombre_departamento = "";

    foreach($info_ticket as $row){
            
          $id_ticket =  $row["id_ticket"];
          $status = $row["status"];     
          $fecha_registro = $row["fecha_registro"];          
          $prioridad = $row["prioridad"];     
          $nombre_departamento = $row["nombre_departamento"];    
          $lista_prioridad = ["Alta" , "Media" , "Baja"];
          $lista_status = ["Abierto", "Cerrado" , "Visto"];
          $asunto =  $row["asunto"];
      }

       $l ="
            <div class='panel' style='background:#0632c9;color:white;'>
              <div class='row'>
                <div class='col-lg-8'>
                  <span style='font-size:.9em;' class='strong'>
                    ". $asunto."                 
                  </span>                  
                </div>  
                <div class='col-lg-4'>
                  <div>
                    <span style='font-size:.9em;'>
                      #Tareas ".$tareas." |
                    </span>
                    <span style='font-size:.9em;'>
                      #Pendientes ".$pendientes."
                    </span>
                  </div>  
                  
                </div>
              </div>  
            </div>

            <div class='panel'>
              <table style='width:100;'>
                <tr>
                  <td>
                  <div>
                    <span style='font-size:.8em;'>
                    ".$info_ticket[0]["asunto"]."
                    </span>
                  </div>  
                  </td>
                  <td>
                    <div>
                      <span style='font-size:.8em;'>
                      ".$info_ticket[0]["mensaje"]."
                      </span>
                    </div>  
                  </td>  
                </tr>
              </table>
            </div>




            
            <div 
              class='panel' style='background:#000a44;padding:5px;'>                                     
                  
                  <div>
                    <span style='font-size:.8em;background:white;padding:5px;' >
                      <span>
                        Ticket #".$id_ticket." | 
                        ". $nombre_departamento ." 
                        | 
                        ". $lista_status[$status] ."
                        | ". 
                        $lista_prioridad[$prioridad]  ."
                        |
                        ".$fecha_registro."

                    </span>                  
                  </div> 
              </div>
            
            

              ";
        return $l;        

  }
  /**/
  function get_bnt_retorno($id_perfil){

      if ($id_perfil != 20 ){
        return "
        <a  href='#tab_clientes'
            data-toggle='tab' 
            class='btn_clientes strong  black'>
            <i class='fa fa-chevron-circle-left'>            
            </i>
            Regresar a clientes 
        </a>";
      }
  }
  /**/

  function get_nombre_saldo($modulo){

    $nombre_saldo ="Saldo cubierto";
    if ($modulo ==  "ventas") {
      $nombre_saldo ="Monto mínimo para arrancar el proyecto";
    }
  }
  /**/
  function get_lista_status($valor_actual){

    $lista_servicios = ["Pendiente", "Proyecto activo y público", "Muestra - público" ];
    $lista_servicios_val = [0, 1, 2,3];
    
    $select ="<select class='input-sm form-control' name='status'>";
  
      for ($z=0; $z <count($lista_servicios); $z++) { 
        

        if($valor_actual == $lista_servicios_val[$z] ){
          $select .="<option value='".$lista_servicios_val[$z]."' selected>
                        ".$lista_servicios[$z]."
                     </option>";  
        }else{
          $select .="<option value='".$lista_servicios_val[$z]."' >
                        ".$lista_servicios[$z]."
                     </option>";
        }
                  
      }
      
    $select .="</select>";
    return $select;
  }
  /**/
  function get_text_ciclo_facturacion($ciclo){

    $ciclo_facturacion = ["", "Anual","Mensual","Semanal"];
    return $ciclo_facturacion[$ciclo];


  }
  /**/
  function valida_btn_agregar_servicio($info_recibida ){

    if(isset($info_recibida["usuario_validacion"])) {      
        
      if ($info_recibida["usuario_validacion"] ==  1) {

        $extra_tab ="
        id='tab_registrar_servicio_persona'
        href='#tab_registrar_servicio'
        data-toggle='tab'";



        return "<button 
                  ".$extra_tab."
                  class='agregar_proyecto_btn input-sm btn' 
                  id='".$info_recibida["id_persona"]."' 
                  style='background:black!important;'>
                  +  Agregar servicio
                </button>";
      }

    }
  }
  /**/
  function valida_mostrar_tareas($data){

  	if (count($data) > 0 ){
  		return  "<label class='mostrar_tareas_pendientes blue_enid'> 
  					       Mostrar sólo tareas pendientes
  				    </label>
    				<label class='mostrar_todas_las_tareas blue_enid' > 
    					Mostrar todas las tareas
    				</label>";
  	}
  }

  
}/*Termina el helper*/