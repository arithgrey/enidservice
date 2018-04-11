<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){  
  /**/
  function crea_data_deuda_pendiente($param){

      $data_complete["cuenta_correcta"] =0;
      if(count($param)>0){

        $recibo=  $param[0];
          $precio =  $recibo["precio"]; 
          
          $num_ciclos_contratados =  $recibo["num_ciclos_contratados"]; 
          $costo_envio_cliente =  $recibo["costo_envio_cliente"];

          $saldo_pendiente = ($precio * $num_ciclos_contratados) + $costo_envio_cliente;
          $data_complete["saldo_pendiente"] = $saldo_pendiente;
          $data_complete["cuenta_correcta"] =1;
          $data_complete["resumen"] =  $recibo["resumen_pedido"];
          $data_complete["costo_envio_cliente"] =  $recibo["costo_envio_cliente"];
          $data_complete["flag_envio_gratis"] =  $recibo["flag_envio_gratis"];
          $data_complete["id_recibo"] =  $recibo["id_proyecto_persona_forma_pago"];

      }
      return $data_complete;
      /**/
  }
  /**/
  function get_deuda_total_pendiente($costo_envio , $flag_envio_gratis , $saldo_pendiente){

    if($flag_envio_gratis == 0){
       return $saldo_pendiente + $costo_envio;
    }else{      
      return $saldo_pendiente;
    }
  }
  /**/
  function get_nombre_vendedor($param){

    $nombre_vendedor =  $param["nombre_vendedor"];    
    $apellido_vendedor =  $param["apellido_vendedor"];
    $apellido2_vendedor =  $param["apellido2_vendedor"];

    $vendedor  =  $nombre_vendedor . " " . $apellido_vendedor . " " .$apellido2_vendedor; 

    
    $usuario = '<span 
    style="padding: 2px;font-size: .7em;background:#0c005a !important" 
    class="white"
    >

    Vendedor '.$vendedor.'
    </span>';
    return $usuario;

  }
  /**/
  function get_nombre_cliente($param){

    $nombre_cliente =  $param["nombre_cliente"];    
    $a_paterno =  $param["apellido_cliente"];
    $a_materno =  $param["apellido2_cliente"];

    $cliente  =  $nombre_cliente . " " . $a_paterno . " " .$a_materno;  
    return $cliente;

  }
  /**/
  function get_panel_registro($forma_pago, $flag_registro_previo){
    /**/

    if($flag_registro_previo ==  1){
      
      $id_cuenta_pago =  "";
      $numero_tarjeta = "";
      $propietario_tarjeta = "";
      $id_banco_registrado = 0;
      $nombre = "";

      foreach ($forma_pago as $row) {
              
          $id_cuenta_pago =  $row["id_cuenta_pago"];
          $numero_tarjeta =  $row["numero_tarjeta"];
          $propietario_tarjeta =  $row["propietario_tarjeta"];
          $id_banco_registrado =  $row["id_banco"];
          $nombre = $row["nombre"];
      }         
      /**/
    }
    
    /**/
    
  }
  /**/
  /*
  function valida_nombre_propietario($flag_registro_previo ,  $nombre_persona , $propietario_tarjeta ){

    if ($flag_registro_previo ==  1) {
      return $propietario_tarjeta;
    }else{
      return $nombre_persona; 
    }
  }
  */
  /**/
  function valida_numero_tarjeta($tarjeta ,  $registro_previo){

      if($registro_previo ==  1){
          return $tarjeta;
      }
  }
  /*
  function valida_imagen_banco_pago($id_banco , $registro_previo){

      if ($registro_previo ==  1){
        $url_img_banco ="../img_tema/bancos/".$id_banco.".png"; 
        $img ="<img src='".$url_img_banco."' style='width:100%;'>";     
        return $img;
      }
      
  }
  */
  /**/
  function create_table_comentarios($comentarios){

    $lista_comentarios ='<ul class="media-list">';

    foreach($comentarios as $row){
            
      $comentario  =  $row["comentario"];    
      $fecha_registro  = $row["fecha_registro"];
      $id_usuario =  $row["id_usuario"];

      $url_imagen =  "../imgs/index.php/enid/imagen_usuario/".$id_usuario;
      
      /**/
      /**/
      $lista_comentarios .='
                          <li class="media">
                            <div class="media-left">
                                <div style="width:70px;">
                                  <img  src="'.$url_imagen .'" 
                                      class="img-circle" 
                                      style="width:100%;"
                                       >
                                </div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">                                    
                                    <small>
                                        <span class="strong">
                                          Registro
                                        </span>
                                          <a class="blue_enid">
                                          '.$fecha_registro .'
                                          </a>
                                    </small>
                                </h4>
                                <p style="font-size:.9em;">
                                   '.$comentario.'
                                </p>
                            </div>
                        </li>';
      

    }
    $lista_comentarios .="</ul>";
    return $lista_comentarios;
  }
  /**/
  function get_ficha_pago($info_notificados , $comentarios){
  
    $info =  $info_notificados[0];
    $nombre_persona =   $info["nombre_persona"];
    $id_notificacion_pago = $info["id_notificacion_pago"];
    $nombre_servicio =  $info["nombre_servicio"];
    $fecha_pago =  $info["fecha_pago"];
    $num_recibo =  $info["num_recibo"];
    $correo =  $info["correo"];
    $fecha_registro = $info["fecha_registro"];
    $forma_pago =  $info["forma_pago"];
    $cantidad =  $info["cantidad"];
    $estatus =  $info["status"];
    $estados_pago_notificado = ["Pendiente de validación" , "Pago aprobado" , "Negar pago"];

    $ficha ="";
    $ficha .= n_row_12();

    $ficha .="<div class='col-lg-10 col-lg-offset-1'> 
                <span style='font-size: 1.5em;background: #002062;color: white;padding: 5px;' class='strong'>
                  ".$estados_pago_notificado[$estatus]."
                </span>
              </div>
              <br>
            <div class='col-lg-10 col-lg-offset-1'>   
              <div class='col-lg-4' style='background: #0f3ec6;padding: 10px;color: white;'>    
                
                
                <div class='text-center'>
                  <span style='font-size: 1.5em;' class='strong'>
                    Monto
                    <br>
                    Notificado
                  </span>
                </div>
                <div class='text-center' style='font-size: 1.5em;' >
                  <span>
                    ".$cantidad."MXN
                  </span>
                </div>
                <br>
                <div class='text-center strong' style='font-size: 1.5em;' class='strong'>
                  <span>
                    Recibo
                  </span>       
                </div>      
                <div class='text-center' style='font-size: 1.5em;'>
                  <span>
                    #".$num_recibo."
                  </span>
                </div>
              </div>    
              <div class='col-lg-8' style='background: #f9fbff;padding: 10px;'>     
                <div class='col-lg-8'>
                  <div class='strong'>
                    Cliente
                  </div>
                  <div style='font-size: .8em;'>
                    ".$nombre_persona."
                  </div>
                  <div style='font-size: .8em;'>
                     ".$correo."
                  </div>
                  <div class='strong'>
                    Servicio
                  </div>
                  <div style='font-size: .8em;'>
                    ".$nombre_servicio."
                  </div>
                  <div class='strong'>
                    Forma de pago
                  </div>
                  <div style='font-size: .8em;'>
                    ".$forma_pago."
                  </div>
                </div>
                <div class='col-lg-4' >   
                  <div class='strong'>
                    Pago
                  </div>
                  <div style='font-size: .8em;'>
                    ".$fecha_pago."
                  </div>
                  <div class='strong'>
                    Registro
                  </div>
                  <div style='font-size: .8em;'>
                    ".$fecha_registro."
                  </div>
                  <form class='form_actualizacion_pago_pendiente'>
                    <select class='form-control estado_pago_nofificado' name='estado'>
                      <option value='0' disabled>            
                        Pendiente de validación
                      </option>
                      <option value='1'>
                        Aprobar pago
                      </option>
                      <option value='2'>
                        Negar pago
                      </option>         
                    </select>
                    <button class='btn input-sm col-lg-12'>
                      Registrar
                    </button>
                  </form>       
                </div>        
              </div>
            </div>
            <div class='col-lg-10 col-lg-offset-1'>   
              <div class='place_comentarios_notificados'>
              </div>
            </div>

            ";

      $lista_comentarios = create_table_comentarios($comentarios);          
      $ficha .="<div class='col-lg-10 col-lg-offset-1'>   
                  ".$lista_comentarios."
                </div>";          
      $ficha .= end_row();

      return $ficha;

  }
  /**/
  function get_deuda_total($data){
        
      $total  = 0;       
      $z =0;
      foreach($data as $row){
        $saldo_cubierto = $row["saldo_cubierto"];     
        $monto_a_pagar = $row["monto_a_pagar"];         
        $deuda_cliente =  $monto_a_pagar - $saldo_cubierto;
        $total =  $total + $deuda_cliente;
        $z ++;
      }
      $monto_total = round($total ,2);
      $total =  "<span style='font-size:.8em;'>
          Pedidos por cobrar: ".$z ." | Saldo pendiente: " . $monto_total ." MXN
        </span>";
      return $total; 


  }
  /**/
  function valida_monto_pendiente($monto_a_pagar , 
                                  $saldo_cubierto ){          
            
      $monto_a_pagar =  $monto_a_pagar -  $saldo_cubierto;
      $nuevo_monto =  ($monto_a_pagar > 0) ? $monto_a_pagar : "";

      if($nuevo_monto > 0){
          $text_deuda = '<span 
            class="white" 
            style="padding: 2px;font-size: .7em;
            background:#024C8C !important">
            Saldo pendiente '.$nuevo_monto.'MXN
          </span>';          
          return $text_deuda;

      }      
    
  }  
  /**/
  function valida_monto_pendiente_text($info_request){

      /**/
      $tipo =  $info_request["tipo"];              
      $text ="";
      switch ($tipo) {
        case 1:
            $text ="<th  style='background: #002674;' 
                          class='white text-center' NOWRAP>
                          Monto pendiente
                    </th>";  
          break;
      
        case 2:
            $text ="<th  style='background: #002674;' 
                          class='white text-center' NOWRAP>
                          Monto para renovar
                    </th>";  
          break;


          case 3:
            $text ="<th  style='background: #002674;' 
                          class='white text-center' NOWRAP>
                          Monto pendiente
                    </th>";  
          break;
  
          
        default:
          
          break;
      }
      return $text;
  }

  /**/  
  function valida_campo_dias_retraso($info_request , $dias_para_vencimiento , 
    $extra_proyecto_vencimiento){
      
      $tipo =  $info_request["tipo"];        
      //
       switch ($tipo) {
        case 1:
            
            return get_td($dias_para_vencimiento , $extra_proyecto_vencimiento);  
          break;
      
          case 3:
            return get_td($dias_para_vencimiento , $extra_proyecto_vencimiento);  
          break;        
        default:
          
          break;
      }


  }  
  /**/
  function valida_campo_dias_retraso_text($info_request){

      $tipo =  $info_request["tipo"];        
      $text ="";
      switch ($tipo) {
        case 1:
            $text ="<th  style='background: #002674;' 
                          class='white text-center' NOWRAP>
                         Días en retraso
                    </th>";  
          break;
      
          case 3:
            $text ="<th  style='background: #002674;' 
                          class='white text-center' NOWRAP>
                          Días en retraso
                    </th>";  
          break;        
        default:
          
          break;
      }
      return $text;



  }
  function valida_prioridad_pago($info_request ,  $dias_para_vencimiento , $siguiente_vencimiento , $dias_para_vencimiento_servicio){

    $tipo =  $info_request["tipo"];  
    $extra ="";
    switch ($tipo){
      
      case 1:        
        if($dias_para_vencimiento > -4 ){            
            $extra ="background:#a70c00!important;color:white!important;";    
        }                  
        break;
      

      case 3:        
        if($dias_para_vencimiento > 1 ){            
            $extra ="background:#a70c00!important;color:white!important;";    
        }                  
        break;
      default:

        break;
    }

    return $extra;
  }
  /**/
  function calcula_monto_a_pagar_resumen($param){

    $total =  $param["total"];
    $num_ciclos_contratados =  $param["num_ciclos_contratados"];

    $monto_a_liquidar =  $num_ciclos_contratados *  $total;
    return $monto_a_liquidar;
  }
  /**/
  function valida_servicio_meses($ciclo_facturacion_proyecto_persona){
  

    $num_meses =  $ciclo_facturacion_proyecto_persona["num_meses"];     
    $meses ="No aplica";
    if ($num_meses >0 ){
      $meses ="A ". $num_meses." Mensualidades ";
    }
    return $meses;

  }  
  /**/
  function get_listado_anticipo($data , $ciclo_facturacion_proyecto_persona){    

    $num_meses =  $ciclo_facturacion_proyecto_persona["num_meses"];    
    $base_mensualidad = $data[0]["anticipo"];

    $data_complete=   
        get_contenido_tabla_mensualidades(
          $data , 
          $ciclo_facturacion_proyecto_persona
        );
    /**/
    $list = "<div style='height:240px; overflow-x:auto;'>
              <table class='table_enid_service text-center' border='1' style='width:100%;'> ";
              
              $extra_cabeceras ="class='blue_enid_background white' style='font-size:.8em;' ";
              $list .= "<tr>";                
                $list .= get_td("#" , $extra_cabeceras);                    
                $list .= get_td("Concepto" , $extra_cabeceras);                    
                $list .= get_td("Fecha" , $extra_cabeceras);     
                $list .= get_td("Estado" , $extra_cabeceras);     
                $list .= get_td("Monto" , $extra_cabeceras);     
               $list .= "</tr>";
              $list .= $data_complete["tabla"];

    $list .= "</table>
          <br>
          <label>
              Siguiente vencimiento
              <br> 
              " .$data_complete["proxima_mensualidad"]
          ."</label>
          </div>
          
          ";
    
    $data_complete_global["tabla"] =  $list;
    $data_complete_global["proxima_mensualidad"] = $data_complete["proxima_mensualidad"];
    $data_complete_global["mensualidad"] =  $base_mensualidad;
    return $data_complete_global;

  }
  function get_contenido_tabla_mensualidades($data , $ciclo_facturacion_proyecto_persona){

    
    $z =1;           
    $list ="";
    $num_meses =  $ciclo_facturacion_proyecto_persona["num_meses"];    
    $extra_estilos="style='font-size:.8em;' ";

    $ultima_fecha_pago_anticipo = "";
    $monto_mensualidad ="";
    foreach ($data as $row){
        
        $id_anticipo =  $row["id_anticipo"];              
        $fecha_registro =  $row["fecha_registro_anicipo"];              
        $anticipo = $row["anticipo"];                              
        $fecha_vencimiento =  $row["fecha_vencimiento"];                     

        $list .= "<tr>";
          $list .= get_td($z , $extra_estilos);          
          $list .= get_td($z ." Mensualidad" , $extra_estilos);          
          $list .= get_td($fecha_registro , $extra_estilos);
          $list .= get_td("Liquidado" , $extra_estilos);          
          $list .= get_td($anticipo ." MXN" , $extra_estilos);          
        $list .= "</tr>";
        
        $monto_mensualidad = $anticipo;
        $ultima_fecha_pago_anticipo =  $fecha_registro;
        $z ++;
    }
    /**/

    $flag_siguiente_mensualidad =0; 

    $mensualidades_restantes = ($num_meses+ 1) - $z; 

    

    $ultima_fecha= $ultima_fecha_pago_anticipo;
    $nueva_mensualidad ="";
    $siguente_vencimiento ="";
    for ($a=0; $a < $mensualidades_restantes; $a++) { 
       

      $estado_mensualidad =  "-";   
      $extra_extilos_pendiente ="";

       $ultima_fecha =  agrega_mensualidad($ultima_fecha); 

       if($flag_siguiente_mensualidad == 0){
          $estado_mensualidad =  "Pendiente";   
          $extra_extilos_pendiente ="style='background:yellow!important;' ";
          $siguente_vencimiento =$ultima_fecha;
      }

     

       $list .= "<tr $extra_extilos_pendiente>";
          $list .= get_td($z , $extra_estilos);          
          $list .= get_td($z ." Mensualidad" , $extra_estilos);          
          $list .= get_td($ultima_fecha  , $extra_estilos);
          $list .= get_td($estado_mensualidad , $extra_estilos);          
          $list .= get_td($anticipo ." MXN" , $extra_estilos);          
        $list .= "</tr>";
        $z ++;

        $flag_siguiente_mensualidad ++; 
    }
    $data_complete["tabla"] =  $list;
    $data_complete["proxima_mensualidad"] = $siguente_vencimiento;
    return $data_complete;
  }
  /***/
  function agrega_mensualidad($fecha){

      $año= substr($fecha , 0, 4 );
      $mes = substr($fecha , 5, 2 );

      $mes_mas_1 = (int)$mes +1;
      $año_mas_1 =  (int)$año +1; 

      $dia =  substr($fecha , 8, 2 );
      
      if($mes < 12){
        return $año . "-" . $mes_mas_1 ."-". $dia;
      }else{
        return $año_mas_1 . "-" ."01" ."-". $dia;
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
  		return  "<label class='black mostrar_tareas_pendientes'> 
  					Mostrar sólo tareas pendientes
  				</label>
  				<label class='black mostrar_todas_las_tareas'> 
  					Mostrar todas las tareas
  				</label>";
  	}
  }

  
}/*Termina el helper*/