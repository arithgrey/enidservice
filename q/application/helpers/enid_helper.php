<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

    /**/
    function add_pedidos_sin_direccion($param){

      $sin_direcciones =  $param["sin_direcciones"];
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($sin_direcciones > 0 ){       

          $lista_pendientes .= 
          inicio_base_notificacion("../area_cliente/?action=compras", "fa fa-bus " );
          
          if($sin_direcciones>1){
            $lista_pendientes .= $sin_direcciones." de tus compras solicitadas, aún no cuentan con tu dirección de envio";  
          }else{
            $lista_pendientes .= "Tu compra aún,  no cuentan con tu dirección de envio";  
          }
          
          $lista_pendientes .= fin_base_notificacion();   
          
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    /**/
    
    /**/
    function add_mensajes_respuestas_vendedor($param, $tipo){      

      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      
      $num = ($tipo == 1)?$param["modo_vendedor"]:$param["modo_cliente"];      

      if($num > 0 ){                   

          $lista_pendientes .= 
          inicio_base_notificacion("../area_cliente/?action=preguntas" ,"fa fa-comments");
          $text = ($tipo ==  1)?"Alguien quiere saber más sobre tu producto":
          "Tienes una nueva respuesta en tu buzón";
          $lista_pendientes .= $text;
          $lista_pendientes .= fin_base_notificacion();   
          $flag_notificaciones ++;                           

      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }    
    /**/
    function add_valoraciones_sin_leer($num , $id_usuario){
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($num > 0 ){                   

          $lista_pendientes .= 
          inicio_base_notificacion("../recomendacion/?q={$id_usuario}","fa fa-star");
          
          $text ="Una persona han agregado sus comentarios 
                  sobre uno de tus artículos   en venta ".base_valoracion();
          if($num>1){
            $text =$num ." personas han agregado sus comentarios 
                          sobre tus artículos
                          ".base_valoracion();
                                                
          }
          $lista_pendientes .=$text;
          $lista_pendientes .= fin_base_notificacion();   
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    /**/    
    function add_productos_publicados($num){

      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($num < 1 ){         
          
          $lista_pendientes .= 
          inicio_base_notificacion("../planes_servicios/?action=nuevo" ,"");
          $lista_pendientes .='<div style="background:black;color:white;padding:5px;">
                                ¿TE GUSTARÍA ANUNCIAR TUS PRODUCTOS O SERVICIOS?
                              </div>                              
                              <div class="a_enid_blue_sm" style="color:white!important;margin-top:10px;">                                
                                  INICIA AQUÍ                                
                              </div>
          ';
          $lista_pendientes .= fin_base_notificacion();   
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;

    }    

    /**/
    function get_mensaje_inicial_notificaciones($tipo ,$num_tareas){

      $seccion ="";
      if ($num_tareas>0){        
        
        switch ($tipo){
          case 1:          
            $seccion ="<div  style='background:black;color:white;padding:2px;'>
                        <center>
                          <span style='font-size:1.5em;text-decoration:underline'>
                            PENDIENTES
                          </span>
                        </center>
                       </div>";          
            break;
          
          default:
            
            break;
        }
      }
      return $seccion;
    }
    /**/
    function inicio_base_notificacion($url='' , $class_icono='' ){      
      $base = n_row_12().
              '<a href="'.$url.'" >
                <div 
                style="padding:10px;" 
                  class="contenedor_notificacion black">
                    <div>
                        <i class="'.$class_icono.'"></i> 
                      <span>';
      return $base;
    }
    /**/
    function fin_base_notificacion(){
        $fin ="</span>          
              </div>                                                
            </div>
          </a>
          <hr>";
          return $fin;
    }
    /**/
    function add_tareas_pendientes($meta , $hecho ){              
      /**/
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($meta  > $hecho){   
          $restantes = ($meta -  $hecho);                
          $lista_pendientes .= inicio_base_notificacion("../desarrollo/?q=1" , "fa fa-credit-card " );
          $lista_pendientes .= "Hace falta por resolver ".$restantes." tareas!";
          $lista_pendientes .= fin_base_notificacion();                                          
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }

    /**/
    function add_envios_a_validar($meta , $hecho ){              
      /**/
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($meta  > $hecho){   
          $restantes = ($meta -  $hecho);                
          $lista_pendientes .= inicio_base_notificacion("../reporte_enid/?q=2" , "fa fa-credit-card " );
          $lista_pendientes .= "Apresúrate hace falta que ".$restantes." personas realicen sus ordenes de compra  ";
          $lista_pendientes .= fin_base_notificacion();                                          
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    /**/
    function add_envios_a_ventas($meta , $hecho ){              
      /**/
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($meta  > $hecho){   
          $restantes = ($meta -  $hecho);                
          $lista_pendientes .= inicio_base_notificacion("../reporte_enid/?q=2" , " fa fa-money " );
          $lista_pendientes .= "Apresúrate completa tu logro sólo hace falta ".$restantes." venta para completar tus labores del día!";
          $lista_pendientes .= fin_base_notificacion();                                          
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    
    /**/
    function add_accesos_pendientes($meta , $hecho ){              
      /**/
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($meta  > $hecho){   
          $restantes = ($meta -  $hecho);                
          $lista_pendientes .= inicio_base_notificacion("../tareas/?q=2" , " fa fa-clock-o " );
          $lista_pendientes .= "Otros usuarios ya han compartido sus productos en redes sociales,
                                alcanza a tu competencia sólo te hacen falta  
                                ".$restantes." vistas a tus productos";
          $lista_pendientes .= fin_base_notificacion();                                          
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    /**/
    function add_email_pendientes_por_enviar($meta_email , $email_enviados_enid_service ){
      
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($meta_email  > $email_enviados_enid_service){   

          $email_restantes = ($meta_email -  $email_enviados_enid_service);      
          $lista_pendientes .= inicio_base_notificacion("../tareas/?q=2" , "fa fa-bullhorn " );          
          $lista_pendientes .='Te hacen falta enviar '.$email_restantes.' 
                              correos a posibles clientes para cumplir tu meta de prospección';
          $lista_pendientes .= fin_base_notificacion();                                         
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    /**/
    function add_saldo_pendiente($param){
      
      $adeudos_cliente =  $param["total_deuda"];
      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($adeudos_cliente > 0 ){       

          $lista_pendientes .= inicio_base_notificacion("../area_cliente/?action=compras", "fa fa-credit-card " );
          $total_pendiente = round($adeudos_cliente, 2);
          $lista_pendientes .= 'Saldo pendiente 
                    <span 
                      style="padding:2px;"
                      class="blue_enid_background white saldo_pendiente_notificacion " 
                      deuda_cliente="'.$total_pendiente.'">
                            '.$total_pendiente .' MXN

                    </span>';
          $lista_pendientes .= fin_base_notificacion();   
          
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;
    }
    /**/
    function add_direccion_envio($num_direccion){

      $lista_pendientes ="";
      $flag_notificaciones = 0;           
      if($num_direccion < 1 ){         
          
          $lista_pendientes .= 
          inicio_base_notificacion("../administracion_cuenta/" ,"fa fa-map-marker");
          $lista_pendientes .='Registra tu dirección de compra y venta';
          $lista_pendientes .= fin_base_notificacion();   
          $flag_notificaciones ++;                           
      }
      $data_complete["html"] =  $lista_pendientes;
      $data_complete["flag"] =  $flag_notificaciones;
      return $data_complete;

    }    
    /**/
    function crea_tareas_pendientes_info($flag_notificaciones){

      $new_flag_notificaciones = "";
      if ($flag_notificaciones > 0 ) {

        $new_flag_notificaciones = "<span 
          class='notificacion_tareas_pendientes_enid_service' 
          id='".$flag_notificaciones."'>
            ".$flag_notificaciones."
        </span>"; 
      }
      return $new_flag_notificaciones;
    }
    /**/    
    function get_tareas_pendienetes_usuario_cliente($info){
      
      $flag =0; 
      $inf_notificacion = $info["info_notificaciones"];
            
      $lista_pendientes ="";        

      /*Agregamos notificación deuda pendiente**/
      $deuda = add_saldo_pendiente($inf_notificacion["adeudos_cliente"]);      
      $flag = $flag + $deuda["flag"];
      $lista_pendientes .= $deuda["html"];        
      /*Agregamos notificación de dirección, cuando esta no está registrada 
      hay que mostrar msj*/

      $deuda = add_pedidos_sin_direccion($inf_notificacion["adeudos_cliente"]);
      $flag = $flag + $deuda["flag"];
      $lista_pendientes .= $deuda["html"]; 


      $direccion = add_direccion_envio($inf_notificacion["flag_direccion"]);
      $flag = $flag + $direccion["flag"];
      $lista_pendientes .= $direccion["html"];        
      /**/

      $direccion = add_productos_publicados($inf_notificacion["productos_anunciados"]);
      $flag = $flag + $direccion["flag"];
      $lista_pendientes .= $direccion["html"];              
      
      /**/
      $mensajes_sin_leer = add_mensajes_respuestas_vendedor($inf_notificacion["mensajes"] ,1);
      $flag = $flag + $mensajes_sin_leer["flag"];
      $lista_pendientes .= $mensajes_sin_leer["html"];            
      /**/

      $data_complete["num_tareas_pendientes_text"] = $flag;  
      $data_complete["num_tareas_pendientes"] = crea_tareas_pendientes_info($flag);
      $data_complete["lista_pendientes"] = 
      get_mensaje_inicial_notificaciones(1 , $flag).
      $lista_pendientes;
      return $data_complete;
      
    
    /*end*/
  }
  /**/
  function get_tareas_pendienetes_usuario($info){

    $inf = $info["info_notificaciones"];
    $lista_pendientes ="";  
    /*Metas u objetivos*/ 
    $meta_ventas              = 0;
    $meta_envios_a_validar    = 0;
    $meta_email               = 0;
    $meta_llamadas            = 0; 
    $meta_contactos           = 0;
    $meta_accesos             = 0; 
    $meta_tareas              = 0; 
    $meta_email_registrados   = 0; 
    $meta_direccion           = 0;
    $meta_temas_de_ayuda      = 0;
    $flag_notificaciones      = 0; 

    $ventas_enid_service          =   $inf["ventas_enid_service"];
    $envios_a_validar             =   $inf["envios_a_validar_enid_service"];
    $email_enviados_enid_service  =   $inf["email_enviados_enid_service"];
    $accesos_enid_service         =   $inf["accesos_enid_service"];
    $tareas_enid_service          =   $inf["tareas_enid_service"];
    
    

    $style_pedientes ="style='padding:4px;background:red!important;color:white!important;'";
    /*Sacamos valores del objetivo*/
    $mensajes_sin_leer = add_mensajes_respuestas_vendedor($inf["mensajes"] ,1);
    $flag_notificaciones = $flag_notificaciones + $mensajes_sin_leer["flag"];    
    $lista_pendientes .= $mensajes_sin_leer["html"];        
    
    $mensajes_sin_leer = add_mensajes_respuestas_vendedor($inf["mensajes"] ,2);
    $flag_notificaciones = $flag_notificaciones + $mensajes_sin_leer["flag"];    
    $lista_pendientes .= $mensajes_sin_leer["html"];        
    

    
    
    $deuda = add_saldo_pendiente($inf["adeudos_cliente"]);
    $flag_notificaciones = $flag_notificaciones + $deuda["flag"];
    $lista_pendientes .= $deuda["html"]; 


    $deuda = add_pedidos_sin_direccion($inf["adeudos_cliente"]);
    $flag_notificaciones = $flag_notificaciones + $deuda["flag"];
    $lista_pendientes .= $deuda["html"]; 

    /**/
  
    $deuda = add_valoraciones_sin_leer($inf["valoraciones_sin_leer"], 
      $info["id_usuario"]);
    $flag_notificaciones = $flag_notificaciones + $deuda["flag"];
    $lista_pendientes .= $deuda["html"]; 
    
    /**/
    
      

  foreach ($inf["objetivos_perfil"] as $row) {
    
    /*Meta ventas*/
    switch ($row["nombre_objetivo"]) {
      case "Ventas":
          
          $meta_ventas = $row["cantidad"];  
              
          $notificacion = add_envios_a_ventas( $meta_ventas ,  $ventas_enid_service);
          $lista_pendientes .= $notificacion["html"];
          $flag_notificaciones =  $flag_notificaciones + $notificacion["flag"];
        
        break;
      
      case "Envios_a_validar":

          $meta_envios_a_validar = $row["cantidad"];  
          $notificacion = add_envios_a_validar($meta_envios_a_validar , $envios_a_validar);
          $lista_pendientes .= $notificacion["html"];
          $flag_notificaciones =  $flag_notificaciones + $notificacion["flag"];      
        break;

      case "Email":

          $meta_email = $row["cantidad"];             
          $notificacion_email= 
          add_email_pendientes_por_enviar($meta_email , $email_enviados_enid_service );
          $lista_pendientes .= $notificacion_email["html"];
          $flag_notificaciones =  $flag_notificaciones + $notificacion_email["flag"];
        break;

      case "Accesos":
        $meta_accesos = $row["cantidad"];     
        $notificacion = add_accesos_pendientes($meta_accesos , $accesos_enid_service);
        $lista_pendientes .= $notificacion["html"];
        $flag_notificaciones =  $flag_notificaciones + $notificacion["flag"];
        
        break;
      
      case "Desarrollo_web":
        
        $meta_tareas = $row["cantidad"];        
        
        $notificacion = add_tareas_pendientes($meta_tareas , $tareas_enid_service);
        $lista_pendientes .= $notificacion["html"];
        $flag_notificaciones =  $flag_notificaciones + $notificacion["flag"];
        break;
      default:
        
        break;
    }

  }



  $new_flag_notificaciones = "";
  if ($flag_notificaciones > 0 ) {
    $new_flag_notificaciones =  "<span id='".$flag_notificaciones."' class='notificacion_tareas_pendientes_enid_service'>".$flag_notificaciones."</span>"; 
  }
  $data_complete["num_tareas_pendientes_text"] = $flag_notificaciones;  
  $data_complete["num_tareas_pendientes"] = $new_flag_notificaciones;
  
  $data_complete["lista_pendientes"]=
  get_mensaje_inicial_notificaciones(1 , $flag_notificaciones). $lista_pendientes;
  return $data_complete;
  
  /*end*/
  }

  /**/
  function get_fechas_cotizador($param){
    
    $fechas = get_td(
      "<span class=' text-tb'>
        Periodo
      </span>" , 
      "style='color:white!important;' ");
  


    $info_ventas_efectivas  = get_td(
      "<span class='black text-tb'>Ventas efectivas
      </span>", 
      "class='titulo_table_descargas' 
      title='Visitas totales Enid Service' ");

    
    $info_visitas  = get_td(
      "<span class='black text-tb'>Visitas </span>", 
      "class='titulo_table_descargas' title='Visitas totales Enid Service' ");

    
    $info_afiliados = get_td(
      "<span class=' text-tb'>
        Afiliados
      </span>", 
      "class='' title='Visitas totales Enid Service' style='background:#273b47;color:white;' ");

    
      $info_cotizaciones = get_td(
        "<span class='black text-tb'>
          Personas que envian
          sus datos en la web", 
          "class='titulo_table_descargas white' 
          Personas que han solicitado su cotización por el formulario web");    


      $info_contactos = get_td(
        "<span class='black text-tb'>
          Mensajes 
        </span>" , 
        "class='titulo_table_descargas white' 
         title='Personas que dejas sus datos en la sección de contáctanos' ");
    

      $info_contactos_promociones = get_td(
        "<span class='black text-tb'>
          Contactos/promociones
        </span>" , 
        "class='titulo_table_descargas white' 
         title='Personas que dejas sus datos en la sección de contáctanos' ");
      
    
      

      $info_clientes_sistema =  get_td(
        "<span class=' text-tb'>
          Posibles clientes
        </span>" , 
        "class='titulo_table_descargas white' 
          style='background:#2621ef;color:white!important;'
         title='Nuevos clientes' ");
      

          $info_email_enviados =  get_td(
         "<span class=' text-tb' >
            Email enviados
          </span>" , 
        "class='titulo_table white ' style='background:#004CA2;color:white;'
          
        "
        );

        
        $info_email_leidos =  get_td(
          "<span class=' text-tb' >
            Email leidos
          </span>" , 
          "class='titulo_table white' style='background:#004CA2;color:white;'
          ");




        $info_prospecto =  get_td("
            <span class=' text-tb' >
              Email registrados
            </span>" , 
          "class='titulo_table white' style='background:#004CA2;color:white;'
          ");

      

        

        $info_proyecto =  get_td(
          "<span class='black text-tb'>
            Ventas efectivas
          </span>" , 
          "class='titulo_table_descargas white' title='Proyectos realizados' " );


        $info_proyecto =  get_td(
          "<span class='black text-tb'>
            Solicitudes de compra
          </span>" , 
          "class='titulo_table_descargas white' 
          title='Proyectos realizados' " );



  
        $info_blogs =  get_td(
          "<span class='text-tb'>
              Articulos creados
          </span>" , 
          " class='titulo_table white' title='Articulos creados en el blog' style='background:#EC0000;color:white;' ");

        $info_tareas_resueltas 
          =  get_td(
          "<span class='text-tb'>
              Tareas resueltas
          </span>" , 
          "  title='Tareas resueltas al cliente' style='background:#112236!important; color:white;' ");


    $dias = array(
      "",  'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');

    foreach ($param as $row) {

      
      $num_proyectos =  valida_num($row["numero_proyectos"] );      
      $numero_contactos = valida_num($row["numero_contactos"]);  
      $num_contactos_promociones = valida_num($row["num_contactos_promociones"]);
      $num_prospectos_sistema = valida_num($row["prospectos_sistema"]);
      $num_registrados =  valida_num($row["prospectos_registrados"] );  
      $num_enviados =  valida_num($row["email_enviados"]);      
      $num_email_leidos =  valida_num($row["num_email_leidos"]);
      $num_blogs =  valida_num($row["num_blogs"]);      
      $afiliados=  $row["afiliados"];  
      $num_tareas_resueltas =  $row["num_tareas_resueltas"];
      /**/
      $extra_proyecto = 
      "class=' text-tb proyectos_registrados' id='".$row["fecha"]."' 
      num_proyectos= $num_proyectos   ";  


      $extra_clientes_sistema = 
        "class=' text-tb num_prospectos_sistema' 
        id='".$row["fecha"]."' 
        style='background:#2621ef!important; color:white!important;'
        num_proyectos= $num_prospectos_sistema  ";      


      $extra_prospectos_sistema = 
        "class=' text-tb proyectos_registrados white' id='".$row["fecha"]."' 
        style='background:#2b2b9f;color:white; '
        num_proyectos= $num_proyectos   ";      
    
      $extra_contactos =
        "class='text-tb contactos_registrados' 
        id='".$row["fecha"]." ' 
        num_contactos= $numero_contactos";

      $extra_contactos_promociones =
        "class='text-tb num_contactos_promociones' 
        id='".$row["fecha"]." ' 
        num_contactos= $num_contactos_promociones";
              
        
      $extra_registros = 
      "class=' text-tb base_registrada '
      style='background:#004CA2;color:white;' 
      id='".$row["fecha"]."' 
      num_registros= $num_registrados";

      $extra_leidos = 
      "class='text-tb base_leida '
      style='background:#004CA2;color:white;' 
      id='".$row["fecha"]."' 
      num_leidos= $num_email_leidos";

      $extra_enviados = 
      "class=' text-tb base_enviados '
      style='background:#004CA2;color:white;' 
      id='".$row["fecha"]."' 
      num_enviados= $num_enviados";

      $extra_blogs = 
      "class=' text-tb blogs_creados white' 
      id='".$row["fecha"]."' 
      style='background:#EC0000;color:white;' 
      num_blogs= $num_blogs";


      $extra_tareas_resueltas = "class=' text-tb tareas_resueltas ' 
                                id='".$row["fecha"]."' 
                                style='background:#112236;color:white!important;'
                              num_blogs= $num_blogs";

    
      $fecha = $dias[date('N', strtotime($row["fecha"]))]; 
      
      

      $fechas .=  get_th(      $fecha .  "<br>" . $row["fecha"] , 
        "style='color:white!important;' 
        class='text-tb '  ");
      

      $info_visitas .= get_td(
        valida_num($row["visitas"]) , 
        "class = 'text-tb' " );

      $info_afiliados .= get_td(
        valida_num($afiliados) , 
        "class = 'text-tb num_afiliados' id='".$row["fecha"]."'

        style='background:#273b47;color:white!important;'
        num_afiliados = $afiliados  " );

      
      $info_contactos .= get_td($numero_contactos , $extra_contactos);


      $info_contactos_promociones .= 
      get_td($num_contactos_promociones , $extra_contactos_promociones);



      $info_clientes_sistema .= 
      get_td( $num_prospectos_sistema, $extra_clientes_sistema);

      
      $info_email_enviados .= 
        get_td(
          $num_enviados ,
         $extra_enviados);

      
      $info_email_leidos .= 
        get_td(
          $num_email_leidos ,
         $extra_leidos);

      $info_prospecto .=  
        get_td(
          $num_registrados ,
         $extra_registros);

      $info_proyecto .=  
        get_td(
          $num_proyectos ,
          $extra_proyecto );

      $info_blogs .=  
        get_td(
          $num_blogs ,
          $extra_blogs );



      $info_tareas_resueltas .=  
        get_td(
          valida_num($num_tareas_resueltas) ,
          $extra_tareas_resueltas );

    }

    $data["fechas"] =   $fechas;
    //$data["num_ventas_efectivas"] =  $info_ventas_efectivas;
    $data["info_visitas"] =  $info_visitas;

    $data["cotizaciones"] = $info_cotizaciones;    
    //$data["info_clientes"] = $info_clientes;
    
    $data["info_afiliados"] =  $info_afiliados;
    //$data["prospectos_contato"] = $info_prospecto_contacto;
    $data["info_clientes_sistema"] = $info_clientes_sistema;
    $data["contactos"] =  $info_contactos;
    $data["contactos_promociones"] =  $info_contactos_promociones;
    
    
    $data["email_enviados"] =  $info_email_enviados;
    
    
    $data["email_leidos"] =  $info_email_leidos;
    $data["prospectos"] =  $info_prospecto;
    $data["proyectos"] =  $info_proyecto;
    $data["blogs"] =  $info_blogs;

    $data["tareas_resueltas"] =  $info_tareas_resueltas;

    return $data;
    
  }
  /**/
  function valida_total_menos1($anterior , $nuevo , $extra ='' )
  {
    
    $extra_class='style="font-size:.9em!important;"';
    if ($anterior > $nuevo ){
      $extra_class='style="background:#ff1b00!important; color:white!important;font-size:.9em!important;" ';
    }
    return get_td(
      $nuevo ,  $extra_class .  " " . $extra);
  }
  /**/
  function get_cabeceras_registros($param){

    $cabeceras =  get_td("Fechas" , 
      "style='color:white !important;' ");
    $cabeceras .=  get_td("Hasta el periodo" , 
      "style='color:white !important;' ");

    $dias = array("",  'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');


    foreach ($param as $row) {

      $fecha = $dias[date('N', strtotime($row["fecha_registro"]))]; 
      $cabeceras .= get_td( $fecha ."<br>". $row["fecha_registro"] , 
        "style='color:white!important;'");  
    }
    return $cabeceras;    
  }
  function get_data_registros($param){

    $cabeceras =  get_td("Registros" );
    $cabeceras2 =  "";
    $total = 0;
    $ultimo =  0;
    foreach ($param as $row){

      $total += $row["registros"];

      $extra =  "";
      if ($ultimo > $row["registros"] ){
        $extra =  "style='background:#FB1C5B; color:white !important;' ";  
      }

      $cabeceras2 .= get_td($row["registros"] , $extra );  
      $ultimo =  $row["registros"];
    }
    $cabeceras .= get_td($total);
    $cabeceras .= $cabeceras2;
    return $cabeceras;    
  }
  /**/
  function valida_num($num){
    $n_num =  0;
    if ($num > 0  ){
        $n_num  = $num;
    }
    return $n_num;
  }
  /**/
  function get_fechas_global($lista_fechas ){

    $dias = array("",  'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'); 
    $fechas ="<tr>";
    $b =0;

    $estilos2 =" style='font-size:.8em;background: #0022B7;color: white;' ";
    $estilos ="  ";
    foreach($lista_fechas as $row){   

        if($b == 0){
          $fechas .= get_th("Horario" , $estilos2);
          $fechas .= get_th("Total" , $estilos2);   
          $b++;
        }
        
        $fecha_text  = $dias[date('N', strtotime($row) )];    
        $text_fecha =  $fecha_text ."<br>".$row;
        $fechas .= get_th( $text_fecha , $estilos2);
      }
      $fechas .="</tr>";
      return $fechas;
      /**/
  }
  /**/
  function base_valoracion(){
    return "<div class='contenedor_promedios'> 
                            <label class='estrella' style='font-size: 1em;color: #0070dd;'>★
                            </label>
                            <label class='estrella' style='font-size: 1em;color: #0070dd;'>★
                            </label>
                            <label class='estrella' style='font-size: 1em;color: #0070dd;'>★
                            </label>
                            <label class='estrella' style='font-size: 1em;color: #0070dd;'>★
                            </label>
                            <label class='estrella' style='font-size: 1em;
                                  -webkit-text-fill-color: white;
                                  -webkit-text-stroke: 0.5px rgb(0, 74, 252);'>★
                            </label>
          </div>
          <span class='blue_enid_background white'>
                            Mira los comentarios aquí!
          </span>";
  }

}/*Termina el helper*/