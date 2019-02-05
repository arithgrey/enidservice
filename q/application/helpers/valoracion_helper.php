<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  if(!function_exists('invierte_date_time')){

      function get_notificacion_valoracion($usuario, $id_servicio){

          $nombre     =   $usuario[0]["nombre"];
          $email      =   $usuario[0]["email"];
          $asunto     =   "HOLA {$nombre} UN NUEVO CLIENTE ESTÁ INTERESADO EN UNO DE TUS ARTÍCULOS";
          $text       =   "Que tal {$nombre}  un nuevo cliente dejó una reseña sobre uno de tus artículos 
          puedes consultarla aquí ".anchor_enid("buzón aquí", ["href" =>  "https://enidservice.com/inicio/producto/?producto={$id_servicio}&valoracion=1"]);
          $cuerpo     =  img_enid([] , 1  , 1  ).heading_enid($text , 5);
          $sender     =   get_request_email($email, $asunto , $cuerpo);
          return $sender;

      }


      function valida_readonly($text){
    if(trim(strlen($text)) > 1) {
        return "readonly";
    }
  }        
  function get_texto_por_modalidad($modalidad){

    $texto = "VENTAS";  
    if($modalidad ==  1) {
      $texto = "COMPRAS ";    
    }
    $texto_modalidad = "TU HISTORIAL DE ".$texto;
    return $texto_modalidad;
  }
  function ver_totalidad_por_modalidad($modalidad , $total){

    $icon          = icon("fa fa-shopping-bag"); 
    $texto_compras = ($modalidad == 1) ? $icon."TUS VENTAS HASTA EL MOMENTO ".$total : $icon."TUS COMPRAS HASTA EL MOMENTO ".$total;
    return $texto_compras;
  }
  function create_seccion_saldo_pendiente($saldo_pendiente){
    return $saldo_pendiente;
  }

      /**
       * @param $calificacion
       * @param int $sm
       * @return string
       */
      function crea_estrellas($calificacion , $sm=0){

      $estrellas_valoraciones   =   "";
      $restantes                =   "";
      $num_restantes            =   1;

      for($x=1; $x <= $calificacion; $x++){         
        $extra = "font-size: 2em;";          
        $estrellas_valoraciones .=  label("★" ,["class"=>'estrella' , "style" => $extra]);
        $num_restantes ++;
      }      
      for($num_restantes; $num_restantes <= 5; $num_restantes++ ){ 
          $extra ="font-size: 2em;-webkit-text-fill-color: white;-webkit-text-stroke: 0.5px rgb(0, 74, 252);";
          
          $restantes  .=  label("★" , 
                          [
                            "class" =>'estrella'  ,
                            "style" => $extra
                          ]);
          
      }
      $estrellas =  $estrellas_valoraciones.$restantes;
      return $estrellas;
  }
  
  function crea_resumen_valoracion($numero_valoraciones ,  $persona =0){
    
      $mensaje_final ="de los consumidores recomiendan este producto";
      if($persona == 1){
          $mensaje_final ="de los consumidores recomiendan";          
      }
      $valoraciones     =   $numero_valoraciones[0];
      $num_valoraciones =   $valoraciones["num_valoraciones"];
      $text_comentarios =   ($num_valoraciones>1)?"COMENTARIOS":"COMENTARIO";
      $comentarios      =   $num_valoraciones.$text_comentarios;
      $promedio         =   $valoraciones["promedio"];
      $personas_recomendarian =  $valoraciones["personas_recomendarian"];

      $promedio_general =  number_format($promedio, 1, '.', '');            
      $parte_promedio   =  div(crea_estrellas($promedio_general).span($promedio_general , ["class"=>'promedio_num']) , ["class"=>'contenedor_promedios']);
      
      $config =  ["class"   =>  'info_comentarios'];
      $parte_promedio   .= "<table>
                            <tr>
                              ".get_td( $comentarios , $config )."
                            </tr>
                          </table>";

      $parte_promedio .= div(porcentaje($num_valoraciones, $personas_recomendarian ,1)."%" , ["class"=>'porcentaje_recomiendan']);
      $parte_promedio .= div($mensaje_final);
      return $parte_promedio;
  }
  
  function crea_resumen_valoracion_comentarios($comentarios , $respuesta_valorada){

      $lista_comentario ="";
      $a =0;
      foreach ($comentarios as $row){

        $id_valoracion          = $row["id_valoracion"];
        $num_util               = $row["num_util"];
        $num_no_util            = $row["num_no_util"];
        $valoracion             = $row["valoracion"];
        $titulo                 = $row["titulo"];
        $comentario             = $row["comentario"];
        $recomendaria           = $row["recomendaria"];
        $nombre                 = $row["nombre"];
        $fecha_registro         =  $row["fecha_registro"];
        $fecha_registro         = $row["fecha_registro"];
        
        $config_comentarios = [
          "class"               =>'contenedor_valoracion_info' ,
          "numero_utilidad"     => $num_util ,
          "fecha_info_registro" => $fecha_registro
        ];
        $extra_config_comentarios =  add_attributes($config_comentarios);
        $lista_comentario .="<div class='contenedor_global_recomendaciones'>
                            <div ".$extra_config_comentarios.">".div(crea_estrellas($valoracion ,1));
        
        $lista_comentario .= div($titulo ,     ["class" =>  'titulo_valoracion']);
        $lista_comentario .= div($comentario , ["class" =>  'comentario_valoracion']);

        if($recomendaria ==  1){
          $lista_comentario .= div(icon("fa fa-check-circle") . "Recomiendo este producto" , 
            ["class"=>'recomendaria_valoracion'] );          
        }
        $lista_comentario .= div($nombre . "- " .$fecha_registro , ["class"=>'nombre_comentario_valoracion'] );
        $function_valoracion_funciona   = 'onclick="agrega_valoracion_respuesta('.$id_valoracion.' , 1)"';                    
        $function_valoracion_NO_funciona = 'onclick="agrega_valoracion_respuesta('.$id_valoracion.' , 0)"';                    
        $texto_valoracion ="";
        if($respuesta_valorada ==  $id_valoracion){
            $texto_valoracion =div("Recibimos tu valoracion! " , ["class"=>'text_recibimos_valoracion']);
        }


        $btn_es_util = anchor_enid("SI" . span("[".$num_util."]" , ["class"=>'num_respuesta'] ), 
                    [
                      "class"     =>'respuesta_util respuesta_ok valorar_respuesta' ,
                      "id"        => $id_valoracion ,
                      "onclick"   =>  "agrega_valoracion_respuesta('".$id_valoracion."' , 1)"
                    ]);

        $btn_no_util = anchor_enid("NO" . span("[".$num_no_util."]" , ["class"=>'num_respuesta'] ), 
                    [
                      "class"     =>'respuesta_no valorar_respuesta' ,
                      "id"        => $id_valoracion ,
                      "onclick"   => "agrega_valoracion_respuesta('".$id_valoracion."' , 0)"
                    ]);


        $lista_comentario .="<hr>
                            <div class='contenedor_utilidad'>
                              <table>
                                <tr>
                                  ".get_td(span("¿Te ha resultado útil?" , ['class'=>'strong']))."
                                  ".get_td($btn_es_util . $btn_no_util)."
                                </tr>
                                <tr>
                                    ".get_td($texto_valoracion)."
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
  /*
  function evalua_acciones_modalidad_anteriores($num_acciones , $modalidad_ventas){
    $text = "";
    if($num_acciones > 0){      
      if($modalidad_ventas ==  1){        
        $text = "MIRA TUS ULTIMAS VENTAS";  
        if($num_acciones >1){
          $text = "MIRA TUS ÚLTIMAS $num_acciones  VENTAS";  
        }        
      }else{
        $text = "MIRA TUS ÚLTIMAS COMPRAS";          
      } 
    }
    $config = ["class"=> "a_enid_black ver_mas_compras_o_ventas"];
    return anchor_enid($text , $config);    
  }  
  */
  


  
  /*
  
  
  function carga_imagen_usuario_respuesta($id_usuario){
      
      return "../imgs/index.php/enid/imagen_usuario/".$id_usuario;
  }
  
  
  
  
  
  
  
  function get_texto_usuario($modalidad ,  $param){

    $texto ="";
    
    if($modalidad == 0){
        $texto ="TU A - "; 
    }
    return $texto;
  }   
  
  
 
  
  
  
  
  
  
  
  
  
  
  
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
  
  function get_direccion_envio($monto_por_liquidar , 
                              $id_proyecto_persona_forma_pago , 
                              $proyecto ,
                              $estado ){

    $lista_info_attr = " info_proyecto= '$proyecto' info_status =  '$estado' ";
    $btn_config_direccion_envio = "<i  class='black btn_direccion_envio fa fa-bus'
                                        id='".$id_proyecto_persona_forma_pago."'  
                                    $lista_info_attr >
                                  ";            

    $btn_articulo_enviado = "icon('black fa fa-bus'')
                                <span >
                                  Enviado!
                                <span>";            

    $btn_direccion_envio = ($monto_por_liquidar <= 0) ? $btn_articulo_enviado : 
    $btn_config_direccion_envio;
    return $btn_direccion_envio;
  
  }
  
  
  
  
  
  
  
  

  
  
  
  function get_bnt_retorno($id_perfil){

      if ($id_perfil != 20 ){
        return "
        <a  href='#tab_clientes'
            data-toggle='tab' 
            class='btn_clientes strong  black'>
            icon('fa fa-chevron-circle-left'>            
            
            Regresar a clientes 
        </a>";
      }
  }
  

  function get_nombre_saldo($modulo){

    $nombre_saldo ="Saldo cubierto";
    if ($modulo ==  "ventas") {
      $nombre_saldo ="Monto mínimo para arrancar el proyecto";
    }
  }
  
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
  
  function get_text_ciclo_facturacion($ciclo){

    $ciclo_facturacion = ["", "Anual","Mensual","Semanal"];
    return $ciclo_facturacion[$ciclo];


  }
  
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
  
  
*/
  
}