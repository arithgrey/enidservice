<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    if (!function_exists('invierte_date_time')) {




        if (!function_exists('get_mensaje_bienvenida')) {
            function get_mensaje_bienvenida($param){

                $nombre     =   $param["nombre"];
                $email      =   $param["email"];

                $l          =   heading("Buen día " . $nombre . " ". $email);
                $l         .=   div(img([
                    "src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
                    "style" => "width: 100%"
                ]),
                    [
                        "style" => "width: 30%;margin: 0 auto;"
                    ]);

                $l  .=  div("TU USUARIO SE HA REGISTRADO!", ["style" => "font-size: 1.4em;font-weight: bold"]);
                $l  .=  hr();
                $l  .=  div("Desde ahora podrás adquirir y vender las mejores promociones a lo largo de México");
                $l  .=  br();
                $l  .=  anchor_enid("ACCEDE A TU CUENTA AHORA!",
                    [
                        "href" => "http://enidservice.com/inicio/login/",
                        "target" => "_blank",
                        "style" => "background: #001936;padding: 10px;color: white;margin-top: 23px;text-decoration: none;"
                    ]);
                return $l;

            }
        }



        if (!function_exists('base_valoracion')) {
            function base_valoracion()
            {

                $base   = ["class" => 'estrella'];
                $start  = label("★", $base);
                $start .= label("★", $base);
                $start .= label("★", $base);
                $start .= label("★", $base);
                $start .= label("★", $base);
                return $start;
            }
        }
        if (!function_exists('tareas_realizadas')) {
            function tareas_realizadas($realizado, $fecha_actual)
            {

                $valor = 0;
                foreach ($realizado as $row) {

                    $fecha_termino      = $row["fecha_termino"];
                    if ($fecha_termino == $fecha_actual) {
                        $tareas_termino = $row["tareas_realizadas"];
                        $valor = $tareas_termino;
                        break;
                    }
                }
                return $valor;

            }
        }

        if (!function_exists('valida_total_menos1')) {
            function valida_total_menos1($anterior, $nuevo, $extra = '')
            {
                $extra_class = ($anterior > $nuevo) ? 'style="background:#ff1b00!important; color:white!important;" ' : "";
                return get_td($nuevo, $extra_class . " " . $extra);
            }
        }

        if (!function_exists('valida_tareas_fecha')) {
            function valida_tareas_fecha($lista_fechas, $fecha_actual, $franja_horaria)
            {

                $num_visitas_web = 0;
                foreach ($lista_fechas as $row) {
                    $fecha  = $row["fecha"];
                    $hora   = $row["hora"];
                    if ($fecha == $fecha_actual && $hora == $franja_horaria) {
                        $num_visitas_web = $row["total"];
                        break;
                    }
                }
                return $num_visitas_web;
            }
        }

        if (!function_exists('get_fechas_global')) {
            function get_fechas_global($lista_fechas)
            {

                $dias   = ["", 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'];
                $fechas = "<tr>";
                $b      = 0;
                $estilos2 = "";
                foreach ($lista_fechas as $row) {
                    if ($b == 0) {

                        $fechas .= get_td("Horario", $estilos2);
                        $fechas .= get_td("Total", $estilos2);
                        $b++;
                    }
                    $fecha_text = $dias[date('N', strtotime($row))];
                    $text_fecha = $fecha_text . "" . $row;
                    $fechas .= get_td($text_fecha, $estilos2);
                }
                $fechas .= "</tr>";
                return $fechas;

            }
        }

        if (!function_exists('get_arreglo_valor')) {
            function get_arreglo_valor($info, $columna)
            {

                $tmp_arreglo    = [];
                $z              = 0;
                foreach ($info as $row) {

                    $fecha = $row[$columna];
                    if (strlen($fecha) > 1) {
                        $tmp_arreglo[$z] = $fecha;
                        $z++;
                    }
                }
                return array_unique($tmp_arreglo);
            }
        }
        if (!function_exists('get_franja_horaria')) {
            function get_franja_horaria()
            {

                $info_hora = [];
                for ($a = 23; $a >= 0; $a--) {

                    $info_hora[$a] = $a;
                }
                return $info_hora;
            }
        }


        if (!function_exists('get_mensaje_inicial_notificaciones')) {
            function get_mensaje_inicial_notificaciones($tipo, $num_tareas)
            {

                $seccion                = "";
                if ($num_tareas > 0) {
                    switch ($tipo) {
                        case 1:
                            $seccion    = div("NOTIFICACIONES ", 1);
                            break;
                        default:
                            break;
                    }
                }
                return $seccion;
            }
        }

        if (!function_exists('crea_tareas_pendientes_info')) {
            function crea_tareas_pendientes_info($f)
            {

                $new_flag = "";
                if ($f > 0) {

                    $new_flag = span($f,
                        [
                            "class" => 'notificacion_tareas_pendientes_enid_service',
                            "id" => $f
                        ]);
                }
                return $new_flag;
            }

        }
        if (!function_exists('add_direccion_envio')) {
            function add_direccion_envio($num_direccion)
            {

                $lista   = "";
                $f    = 0;
                if ($num_direccion < 1) {

                    $text   = 'Registra tu dirección de compra y venta';
                    $lista  = base_notificacion("../administracion_cuenta/", "fa fa-map-marker" , $text);


                    $f ++;
                }
                $response["html"] = $lista;
                $response["flag"] = $f;
                return $response;

            }

        }
        if (!function_exists('add_tareas_pendientes')) {
            function add_tareas_pendientes($meta, $hecho)
            {

                $lista = "";
                $f = 0;
                if ($meta > $hecho) {

                    $restantes  = ($meta - $hecho);
                    $text       = "Hace falta por resolver " . $restantes . " tareas!";
                    $lista      = base_notificacion("../desarrollo/?q=1", "fa fa-credit-card " , $text);

                    $f ++;
                }
                $response["html"] = $lista;
                $response["flag"] = $f;
                return $response;
            }

        }
        if (!function_exists('add_envios_a_ventas')) {
            function add_envios_a_ventas($meta, $hecho)
            {

                $lista  = "";
                $f      = 0;
                if ($meta > $hecho) {
                    $restantes  = ($meta - $hecho);
                    $text       = "Apresúrate completa tu logro sólo hace falta " . $restantes . " venta para completar tus labores del día!";
                    $lista      = base_notificacion("../reporte_enid/?q=2", " fa fa-money " , $text);
                    $f   ++;
                }
                $response["html"] = $lista;
                $response["flag"] = $f;
                return $response;
            }
        }

        if (!function_exists('add_accesos_pendientes')) {
            function add_accesos_pendientes($meta, $hecho)
            {

                $lista  = "";
                $f      = 0;
                if ($meta > $hecho) {
                    $restantes = ($meta - $hecho);

                    $text   = "Otros usuarios ya han compartido sus productos en redes sociales, alcanza a tu competencia sólo te hacen falta  " . $restantes . " vistas a tus productos";
                    $lista  = base_notificacion("../tareas/?q=2", " fa fa-clock-o " , $text);
                    $f   ++;
                }
                $response["html"] = $lista;
                $response["flag"] = $f;
                return $response;
            }
        }

        if (!function_exists('add_email_pendientes_por_enviar')) {
            function add_email_pendientes_por_enviar($meta_email, $email_enviados_enid_service)
            {

                $lista  = "";
                $f   = 0;
                if ($meta_email > $email_enviados_enid_service) {

                    $email_restantes = ($meta_email - $email_enviados_enid_service);
                    $text            = 'Te hacen falta enviar ' . $email_restantes . ' correos a posibles clientes para cumplir tu meta de prospección';
                    $lista           = base_notificacion("../tareas/?q=2", "fa fa-bullhorn " , $text);
                    $f  ++;
                }
                $response["html"] = $lista;
                $response["flag"] = $f;
                return $response;
            }
        }
        if (!function_exists('add_numero_telefonico')) {
            function add_numero_telefonico($num)
            {

                $lista  = "";
                $f   = 0;
                if ($num > 0) {

                    $text   = "Agrega un número para compras o ventas";
                    $lista  = base_notificacion("../administracion_cuenta/", "fa fa-mobile-alt" , $text);

                    $f++;
                }
                $response["html"] = $lista;
                $response["flag"] = $f;
                return $response;
            }
        }

        function add_valoraciones_sin_leer($num, $id_usuario)
        {
            $lista  = "";
            $f      = 0;
            if ($num > 0) {

                $text_comentario    =   div("Alguien han agregado sus comentarios sobre uno de tus artículos en venta ", 1) . base_valoracion();
                $text               =   div($num . " personas han agregado sus comentarios sobre tus artículos", 1) . base_valoracion();
                $text               =   ($num > 1) ? $text : $text_comentario;
                $lista              =   base_notificacion("../recomendacion/?q=" . $id_usuario, "fa fa-star" , $text);
                $f  ++;
            }
            $response["html"] = $lista;
            $response["flag"] = $f;
            return $response;
        }
        function add_pedidos_sin_direccion($param)
        {

            $sin_direcciones =  $param["sin_direcciones"];
            $lista           =  "";
            $f               =  0;
            if ($sin_direcciones > 0) {

                $text   = ($sin_direcciones > 1) ? $sin_direcciones . " de tus compras solicitadas, aún no cuentan con tu dirección de envio" : "Tu compra aún,  no cuentan con tu dirección de envio";
                $lista  = base_notificacion("../area_cliente/?action=compras", "fa fa-bus " , $text);
                $f++;
            }
            $response["html"] = $lista;
            $response["flag"] = $f;
            return $response;
        }


        function add_saldo_pendiente($param)
        {

            $adeudos_cliente    = $param["total_deuda"];
            $lista              = "";
            $f                  = 0;
            if ($adeudos_cliente > 0) {

                $total_pendiente = round($adeudos_cliente, 2);
                $text            =
                    'Saldo por liquidar ' . span($total_pendiente . 'MXN', ["class" => "saldo_pendiente_notificacion",
                            "deuda_cliente" => $total_pendiente
                        ]);

                $lista = base_notificacion("../area_cliente/?action=compras", "fa fa-credit-card"  , $text);

                $f++;
            }
            $response["html"] = $lista;
            $response["flag"] = $f;
            return $response;
        }

        function base_notificacion($url = '', $class_icono = '' , $text = '')
        {
            return li(anchor_enid(icon($class_icono) . $text, ["href" => $url , "class" => "black notificacion_restante"] ));
        }
        function add_mensajes_respuestas_vendedor($param, $tipo)
        {

            $lista = "";
            $f = 0;

            $num = ($tipo == 1) ? $param["modo_vendedor"] : $param["modo_cliente"];

            if ($num > 0) {

                $text   = ($tipo == 1) ? "Alguien quiere saber más sobre tu producto" : "Tienes una nueva respuesta en tu buzón";
                $lista  = base_notificacion("../area_cliente/?action=preguntas", "fa fa-comments" , $text);
                $f++;

            }
            $response["html"] = $lista;
            $response["flag"] = $f;
            return $response;
        }

        function get_tareas_pendienetes_usuario_cliente($info)
        {

            $num_telefonico     = $info["info_notificaciones"]["numero_telefonico"];
            $f                  = 0;
            $inf_notificacion   = $info["info_notificaciones"];


            $lista              = "";
            $deuda              = add_saldo_pendiente($inf_notificacion["adeudos_cliente"]);
            $f                  = $f + $deuda["flag"];


            $direccion              = add_pedidos_sin_direccion($inf_notificacion["adeudos_cliente"]);
            $f = $f + $direccion["flag"];


            $direccion_envio          = add_direccion_envio($info["flag_direccion"]);
            $f = $f + $direccion_envio["flag"];



            $numtelefonico      = add_numero_telefonico($num_telefonico);
            $f = $f + $numtelefonico["flag"];


            $mensajes_sin_leer  = add_mensajes_respuestas_vendedor($inf_notificacion["mensajes"], 1);
            $f = $f + $mensajes_sin_leer["flag"];



            $response["num_tareas_pendientes_text"] = $f;
            $response["num_tareas_pendientes"] = crea_tareas_pendientes_info($f);

            $list =  [
                $deuda,
                $direccion,
                $direccion_envio,
                $numtelefonico,
                $mensajes_sin_leer

            ];
            $response["lista_pendientes"] = get_mensaje_inicial_notificaciones(1, $f) . ul($list);

            return $response;

        }
        function get_tareas_pendienetes_usuario($info)
        {

            $inf    = $info["info_notificaciones"];
            $lista  = "";

            $f = 0;
            $ventas_enid_service = $info["ventas_enid_service"];
            $email_enviados_enid_service = $inf["email_enviados_enid_service"];
            $accesos_enid_service = $inf["accesos_enid_service"];
            $tareas_enid_service = $inf["tareas_enid_service"];
            $num_telefonico = $inf["numero_telefonico"];
            $mensajes_sin_leer = add_mensajes_respuestas_vendedor($inf["mensajes"], 1);
            $f = $f + $mensajes_sin_leer["flag"];
            $lista .= $mensajes_sin_leer["html"];
            $mensajes_sin_leer = add_mensajes_respuestas_vendedor($inf["mensajes"], 2);
            $f = $f + $mensajes_sin_leer["flag"];
            $lista .= $mensajes_sin_leer["html"];
            $deuda = add_saldo_pendiente($inf["adeudos_cliente"]);
            $f = $f + $deuda["flag"];
            $lista .= $deuda["html"];
            $deuda = add_pedidos_sin_direccion($inf["adeudos_cliente"]);
            $f = $f + $deuda["flag"];
            $lista .= $deuda["html"];
            $deuda = add_valoraciones_sin_leer($inf["valoraciones_sin_leer"], $info["id_usuario"]);
            $f = $f + $deuda["flag"];
            $lista .= $deuda["html"];


            $num_telefonico = add_numero_telefonico($num_telefonico);
            $f = $f + $num_telefonico["flag"];
            $lista .= $num_telefonico["html"];


            foreach ($info["objetivos_perfil"] as $row) {

                switch ($row["nombre_objetivo"]) {
                    case "Ventas":

                        $meta_ventas = $row["cantidad"];
                        $notificacion =
                            add_envios_a_ventas($meta_ventas, $ventas_enid_service);
                        $lista .= $notificacion["html"];
                        $f = $f + $notificacion["flag"];

                        break;


                    case "Email":

                        $meta_email = $row["cantidad"];
                        $notificacion_email = add_email_pendientes_por_enviar($meta_email, $email_enviados_enid_service);
                        $lista .= $notificacion_email["html"];
                        $f = $f + $notificacion_email["flag"];
                        break;

                    case "Accesos":
                        $meta_accesos = $row["cantidad"];
                        $notificacion =
                            add_accesos_pendientes($meta_accesos, $accesos_enid_service);
                        $lista .= $notificacion["html"];
                        $f = $f + $notificacion["flag"];

                        break;

                    case "Desarrollo_web":

                        $meta_tareas = $row["cantidad"];
                        $notificacion =
                            add_tareas_pendientes($meta_tareas, $tareas_enid_service);
                        $lista .= $notificacion["html"];
                        $f = $f + $notificacion["flag"];
                        break;
                    default:
                        break;
                }

            }


            $new_flag = "";
            if ($f > 0) {

                $new_flag = span($f,
                    [
                        "id" => $f,
                        "class" => 'notificacion_tareas_pendientes_enid_service'
                    ]);

            }
            $response["num_tareas_pendientes_text"] = $f;
            $response["num_tareas_pendientes"] = $new_flag;
            $response["lista_pendientes"] =
                get_mensaje_inicial_notificaciones(1, $f) . $lista;
            return $response;

        }

        function get_valor_fecha_solicitudes($solicitudes, $fecha_actual)
        {

            $valor = 0;
            foreach ($solicitudes as $row) {

                $fecha_registro = $row["fecha_registro"];
                if ($fecha_registro == $fecha_actual) {
                    $tareas_solicitadas = $row["tareas_solicitadas"];
                    $valor = $tareas_solicitadas;
                    break;
                }
            }
            return $valor;
        }
        /*


        function genera_color_notificacion_admin($tipo){

            switch ($tipo) {
              case 1:
                return "background: rgb(174, 13, 80);";
                break;
              case 2:
                return "background: black;";
                break;

              case 3:
                return "background : rgba(3, 125, 255, 0.82);";
                break;

              case 4:
                return "background:#F15B4F;";
                break;

              default:

                break;
            }

        }



        function create_icon_img($row , $class , $id , $extra= '' ,  $letra ='[Img]' ){

          $color_random = '';
          $base_img = base_url("application/img/img_def.png");
          $img =  "";
          if (isset($row["nombre_imagen"] )) {
              if (strlen($row["nombre_imagen"]) > 2  ){
                $img =  '<img '. $extra .' class="'. $class .'" id="'.$id.'"  style="display:block;margin:0 auto 0 auto; width: 100%;" src="data:image/jpeg;base64, '. base64_encode($row["img"])  .'  " />';

              }else{

                //return  "<div ". $extra."  style = '". $color_random."' style='margin: 0 auto;' class='img-icon-enid text-center ". $class ." ' id='".$id  ."'  >". $letra ."</div>";
                $img =  '<img '. $extra .' class="'. $class .'" id="'.$id.'"  style="display:block;margin:0 auto 0 auto; width: 100%;" src="'.$base_img.'  " />';
              }
          }else{
                //return  "<div ". $extra."  style = '". $color_random."' style='margin: 0 auto;' class='img-icon-enid text-center ". $class ." ' id='".$id  ."'  >". $letra ."</div>";
            $img =  '<img '. $extra .' class="'. $class .'" id="'.$id.'"  style="display:block;margin:0 auto 0 auto; width: 100%;" src="'.$base_img.'  " />';
          }
          return $img;

        }

        function simula_img($url , $class, $id , $title , $f , $letra ='A' ){
          $color_random = 'background : rgb(174, 13, 80); color:white; padding:50px;';
          return  "<div style = '". $color_random."' class='img-icon-enid". $class ." ' id='".$id  ."'  title='". $title ."' >". $letra ."</div>";

        }






        function filtro_enid($data,  $class , $id ,  $tupla , $in , $end , $msj  ){

          $filtro ="<div class='panel-heading blue-col-enid text-center' >
                      ". $msj ."
                      <hr>
                    ";
          $filtro .= "<h5 class='text-center'>Secciona para añadir</h5>";
          $filtro .= "</div>";
          $filtro .= "<div class='panel panel-body-enid'>
                     <ul>";

          $b = 0;
            foreach ($data as $row){

                $filtro .= "<li class='".$class." enid-filtro-busqueda' id='". $row[$id] ."'>";

                foreach ($tupla as $key => $value){

                  $param   =  $tupla[$key];
                  $valor   =  $row[$param];

                    if($b == 0 ){
                      $filtro .= create_icon_img($row , " ", " " );
                      $b ++;

                    }elseif($param == "nombre"){
                        $filtro .=  $valor;
                    }elseif($param ==  $in ){
                      $filtro .= "(" . $valor . " ) ";
                    }elseif ($param ==  $end) {
                        $filtro .= " - " . $valor ;
                    }else{

                    }


                }
                $b = 0;
                $filtro .= "</li>";
            }


            if (count($data) == 0 ){

                $filtro .=  "<em style='color:white; text-align:center;' >Sin resultados</em>";
            }
            $filtro .="</ul>";
            $filtro .="</div>";
            return $filtro;
        }

        function get_starts($val){

          $l =  "";
          for ($a=0; $a < $val; $a++) {
            $l .=  "icon('fa fa-star text-default'')";
          }
          return $l;
        }

        function get_start($val , $comparacion ){

            if ($val ==  $comparacion ) {
              return  $val . " icon('fa fa-star'')";
            }else{
              return  $val;
            }
        }

        function create_data_list($data  , $value  ,  $id_data_list){

          $data_list =  "<datalist id='". $id_data_list."'>";
          foreach ($data as $row) {
            $data_list .=  "<option value='". $row[$value]."' >";
          }
          $data_list .=  "</datalist>";
          return $data_list;
        }


        function get_td($valor , $extra = '' )
        {
          return "<th ". $extra ." NOWRAP >". $valor ."</th>";
        }

        function get_td($val , $extra = '' ){
          return "<td ". $extra ." NOWRAP >". $val ."</td>";
        }

        function get_td_val($val , $extra){
          if ($val!="" ) {
            return "<td style='font-size:.71em !important;' ". $extra .">". $val ."</td>";
          }else{
            return "<td style='font-size:.71em !important;' ". $extra .">0</td>";
          }

        }

        function get_count_select($inicio, $fin , $text_intermedio , $selected){


            $options ="";
            while ($inicio <= $fin) {

              if ($selected ==  $inicio ) {
                $options .="<option  selected value='". $inicio ."'>". $inicio ."</option>";
              }else{
                $options .="<option value='". $inicio ."'>". $inicio ."</option>";
              }


              $inicio ++;
            }


            return  $options;

        }


          function validatenotnullnotspace($cadena){

              if (strlen($cadena )>0  ) {
                  if ($cadena == null ) {
                      return false;
                  }else{
                      return true;
                  }
              }else{
                  return false;
              }


          }



        function validate_text($texto){

             $texto = str_replace('"','', strip_tags($texto ));
             $texto = str_replace("'",'', strip_tags($texto ));
             return $texto;

        }


        function valida_l_text($text){

          if (strlen($text) > 1 ){
            return $text;
          }else{
            return "";
          }
        }

        function valida_text_replace($texto_a_validar, $null_msj , $sin_text_msj, $class="" ){

          $dinamic_text ="";
              if ($texto_a_validar == null ) {
                  $dinamic_text=  $null_msj;
              }else if( strlen($texto_a_validar) ==  0 ){
                  $dinamic_text=  $sin_text_msj;
              }else if( trim($texto_a_validar) ==  "" ){
                  $dinamic_text=  $sin_text_msj;
              }else{
                  $dinamic_text=   $texto_a_validar;
              }



              return $texto_a_validar;
      }



        function now_enid(){
          return  date('Y-m-d');
        }

        function fechas_enid_format($f_inicio , $f_termino ){

          if ($f_inicio !=  $f_termino) {
            $f_inicio = $f_inicio  . " al " . $f_termino ;
          }
          return $f_inicio;
        }

        function hora_enid_format($hora_inicio , $hora_termino){
          if ($hora_inicio!= null OR strlen($hora_inicio)>3  ){
            $horario = "de ". $hora_inicio ." a ".  $hora_termino;
          }else{
            $horario = "";
          }
          return $horario;
        }

        function dinamic_class_table($a){
          $style ="";
          if ($a%2 == 0) {
            $style = "style='background:#F7F8F0;' ";
          }
          return $style;
        }


        function editar_btn($session , $href ){

            if ($session ==  1 ) {
                return '
                          <li class="btn_configurar_enid">
                            <a href="'.$href.'" >
                              icon('fa fa fa-cog">


                            </a>
                          </li>
                ';
            }else{
              return "";
            }
        }
        function agregar_btn($session , $href ){

            if ($session ==  1 ) {
                return '
                          <li class="btn_agregar_enid" title="Agregar nuevo">
                            <a href="'.$href.'" >
                              <?=icon("fa fa-plus")?>


                            </a>
                          </li>
                ';
            }else{
              return "";
            }
        }




        function show_text_input($val , $num , $msj ){

          if (strlen($val) < $num ){
            return $msj;
          }else{
            return $val;
          }
        }

        function resumen_descripcion_enid($text){


            $text_complete = "";
            if(strlen(trim($text)) > 100){
              $text_complete .=  "<div class='text_completo_log_def   text_completo_log'>". $text ." </div>";
            }else{
              $text_complete =  "<div class='text_completo_log_def '>" .$text ."</span>";
            }
            return  $text_complete;

        }

        function part_descripcion($descripcion ,  $min_lenght , $max_lenght ){


              if (strlen($descripcion) > $min_lenght ){
                  return substr($descripcion , 0 , $max_lenght);
              }else{
                  return  $descripcion;
              }

        }
        function create_dinamic_input($text_lab , $name ,  $class_input ,  $id_input  ,  $class_section ,  $value  , $extra = '' , $type=''){

          $input ="<div class='".$class_section."' >
                      <label>
                      ".$text_lab."
                      </label>
                      <input type='".$type."' class='".$class_input."' id='". $id_input."' value='". $value ."' $extra   onkeyup='javascript:this.value=this.value.toUpperCase();'  >
                   </div>";

          return $input;
        }


        function template_documentacion($titulo,  $descripcion , $url_img  ){
            $block =  "
                        <span>
                        <b>";
            $block .= $titulo;

            $block .= "</b>
                      </span>

                      <span>
                      ". $descripcion;

            $block .= "</span>
                        <img src='".$url_img."' class='desc-img'>
                      ";
            $block .= "
                      ";
            return $block;


        }
































        $new_flag = "";
        if ($f > 0 ) {
          $new_flag =  "<span id='".$f."' class='notificacion_tareas_pendientes_enid_service'>".$f."</span>";
        }
        $response["num_tareas_pendientes_text"] = $f;
        $response["num_tareas_pendientes"] = $new_flag;

        $response["lista_pendientes"]=
        get_mensaje_inicial_notificaciones(1 , $f). $lista;
        return $response;


        }




        function get_cabeceras_registros($param){

          $cabeceras =  get_td("Fechas" ,
            "style='color:white !important;' ");
          $cabeceras .=  get_td("Hasta el periodo" ,
            "style='color:white !important;' ");

          $dias = array("",  'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');


          foreach ($param as $row) {

            $fecha = $dias[date('N', strtotime($row["fecha_registro"]))];
            $cabeceras .= get_td( $fecha ."". $row["fecha_registro"] ,
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

      */
        /*
     function add_productos_publicados($num){


         $lista ="";
         $f = 0;
         if($num < 1 ){
             $lista   .=
             base_notificacion("../planes_servicios/?action=nuevo" ,"");
             $lista   .=
             div("¿TE GUSTARÍA ANUNCIAR TUS PRODUCTOS O SERVICIOS?");
             $lista   .= div("INICIA AQUÍ");

             $f ++;
         }
         $response["html"] =  $lista;
         $response["flag"] =  $f;
         return $response;

       }
     */
    }