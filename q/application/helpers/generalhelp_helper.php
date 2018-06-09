<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  /**/
  function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
  }
  /**/
  function get_valor_fecha_solicitudes($solicitudes, $fecha_actual){

    $valor =0;
    foreach ($solicitudes as $row){        
        /**/          
        $fecha_registro =  $row["fecha_registro"];  
        if($fecha_registro ==  $fecha_actual) {          
          $tareas_solicitadas = $row["tareas_solicitadas"];
          $valor  =  $tareas_solicitadas;
          break;  
        }        
    }
    return $valor;

  }
  /**/
  function tareas_realizadas($realizado, $fecha_actual){

    $valor =0;
    foreach ($realizado as $row){        
        /**/          
        $fecha_termino =  $row["fecha_termino"];  
        if($fecha_termino ==  $fecha_actual){        

          $tareas_termino = $row["tareas_realizadas"];
          $valor  =  $tareas_termino;
          break;  
        }        
    }
    return $valor;

  }
  /**/
  function get_comparativas_metricas( $hora_actual,  $info_global){

      /********************/
      $list ="";
      $num_tareas_menos_7 =0;

      $style ="style='font-size:.8em;'";
      
      foreach($info_global["menos_7"] as $row){
      
        $num_tareas = $row["num_tareas"];
        $hora =  $row["hora"];
        if($hora ==  $hora_actual) {
          
          $num_tareas_menos_7 =$num_tareas;
          break;
        }      
      }
      $list .= get_td($num_tareas_menos_7 , $style);


      $num_tareas_ayer =0;
      
      foreach($info_global["ayer"] as $row){
      
        $num_tareas = $row["num_tareas"];
        $hora =  $row["hora"];
        if($hora ==  $hora_actual) {
          
          $num_tareas_ayer =$num_tareas;
          break;
        }      
      }
      $list .= get_td($num_tareas_ayer, $style);


      $num_tareas_hoy =0;
      
      foreach($info_global["hoy"] as $row){
      
        $num_tareas = $row["num_tareas"];
        $hora =  $row["hora"];
        if($hora ==  $hora_actual) {
          
          $num_tareas_hoy =$num_tareas;
          break;
        }      
      }
      $list .= get_td($num_tareas_hoy , $style);
      return $list;


  }
  /**/
  function get_franja_horaria(){

      $info_hora =[];
      for ($a=23; $a >= 0; $a--) { 
        
        $info_hora[$a] =  $a;
      }
      return $info_hora;
  }
  /**/
  function get_fechas_data($info_global){

      $lista_fechas ="";
      $style ="style='font-size:.8em;' ";
      foreach($info_global as $row){          

        $fecha = $row["fecha"];  
        $lista_fechas .= get_td($fecha , $style);        
      }
      return $lista_fechas;

  }
  /**/
  function valida_tareas_fecha($lista_fechas , $fecha_actual , $franja_horaria ){

    $num_visitas_web =0;
    foreach ($lista_fechas as $row) {                    
        $fecha =  $row["fecha"];
        $hora =  $row["hora"];
        if($fecha ==  $fecha_actual && $hora ==  $franja_horaria) {
            

            $num_visitas_web =$row["total"];
            break;
        }
      
    }

    return $num_visitas_web;
  }
  /**/
  function valida_accesos_url_fecha($info , $fecha_actual , $url_actual ){


    $num_visitas_web =0;
    foreach ($info as $row) {
                
        $url =  $row["url"];
        $fecha =  $row["fecha"];

        if($fecha_actual ==  $fecha && $url ==  $url_actual) {
          
          $num_visitas_web =  $row["num_visitas_web"];
          break;  
        }        
    }

    return $num_visitas_web;
  }
  /**/
  function get_arreglo_valor($info , $columna){

    $tmp_arreglo =[];
    $z =0;
    foreach($info as $row){
        
      $fecha =  $row[$columna];  
      if (strlen($fecha) > 1) {
        $tmp_arreglo[$z] = $fecha;
        $z ++;
      }
    }
    return array_unique($tmp_arreglo);
  }
  /**/
  function get_num_actual($num ){

    if($num > 0 ){
      return $num;
    }else{
      return  0; 
    }

  }

  /**/
  function get_diferencia_metas($meta , $actual ){

    return   $meta - $actual; 
  }
  /**/
  function valida_diferente_null($data ,  $campo){    
    
    
    if( count($data["data_usuario_email"]) > 0){
      return $data["data_usuario_email"][0][$campo];
    }else{
      return 0;
    }  
  }
  /**/
  function create_img_enid($url_img){

    return "<img src='".$url_img."' class='img_enid'>";
  }
  /**/
  function contenedor_page_start(){
    return "<div class='row contenedor-enid' >
              <div class='col-lg-12 col-md-12 col-sm-12'>";
  }
  function contenedor_page_end(){
    return "</div>
          </div>";
  }
  /**/
  function construye_menu_enid_service($titulos , $extras ){
      $menu =  ""; 
      for ($a=0; $a < count($titulos ); $a++){ 
        $menu .=  "<a ".$extras[$a]." >" . $titulos[$a]." | </a>" ; 
      }
      return $menu;
  }
  /**/
  function pagina_presentacion($perfil , $id_empresa){
    $url = ""; 
    switch ($perfil){
      case 9:        
        $url = url_ingresos_egresos();
        break;
      
      case 10:
        $url = url_cuenta_tu_historia($id_empresa);
        
        break;

      default:
        $url = url_inicio_eventos();
        break;
    }
    return $url;
    
  }
  /**/
  function num_asistencia($max , $name){
    /**/
    $select = "<select name='". $name ."' id='". $name   ."' class='form-control ". $name   ."'>";
    for($a=0; $a <= $max; $a++){         
        $select .= "<option value='". $a ."'>". $a ." Acompañantes  </option> ";
    }    
    $select .=  "</select>"; 
    return $select;
}
  
  
  
  function create_img_url_sl($id_imagen){

    $url =  url_tmp_img($id_imagen);
    $img =  "<img src='".$url ."' width=100%;>";
    return $img;
    
  }
  /**/
  function get_mensaje_user_actualizado($f){
      $msj = ["", "Tu cuenta ha sido actualizada con éxito inicia ahora!" ,  
                "Ya tienes tu cuenta registrada inicia sessión "]; 
      return $msj[$f];
  }
  /*EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  */
  function valida_empresa_prueba_name($nombre){
    $nombre_empresa =  $nombre;
    if (substr($nombre_empresa , 0 ,  10)  ==  "Empresa de") {
      $nombre_empresa =  "Aquí el nombre de tu empresa";
    }
    return $nombre_empresa;   
  }
  /*EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  EMPRESA  */




  /*NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN */
  function navegador(){
    return $_SERVER['HTTP_USER_AGENT'];
  }
  /**/
  function ip_user(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
  }  
  /**/
  function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){    
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
        }
        return $rstr;
  }
  function create_url_preview($tipo , $val_extra='' ){

    switch ($tipo) {
      /*Para los eventos */
      case 1:
          return base_url('index.php/enid/img_evento')."/".$val_extra;
        break;
      /**imagen general roja  */
      case 2:
          return base_url('application/img/landing/1.jpg');
        break;
      /**imagen resumen de eventos */
      case 3:
        return base_url('application/img/landing/11.png');
        break;
        /*Para solicita tu artista*/
      case 4:
        return base_url('application/img/landing/11.png');
        break;
        /*cuentanos tu historia*/
      case 5:
        return base_url('application/img/landing/11.png');
        break;
        /*La empresa */
      case 6:
        return base_url('index.php/enid/imagen_empresa')."/".$val_extra;
        break;    

      /*Página principal */
      case 7:
        return base_url('application/img/landing/prospectos.jpg');
        break; 
      /*Página inicio session  */
      case 8:
        return base_url('application/img/landing/session.jpg');
        break;    
      /*Página  de prospectos  */
      case 9:
        return base_url('application/img/landing/prospectos.jpg');
        break;    
      /*Nuevo miembro */    
      case 10:
        return base_url('application/img/landing/25.jpg');
        break;
      /*Las historias de la gente*/
      case 11:
        return base_url('application/img/landing/encuesta.png');
      break;  
      /**/
      case 12:
        return base_url('application/img/landing/21.jpg');
      break;  

      default:
          return base_url('application/img/landing/1.jpg');
        break;
    }
  }

  /**/
  function valida_template_perfil_home($perfil){

    switch ($perfil) {
      case 7:
          return "principal/center_page_general"; 
        break;
      case 4:
          return "principal/center_page_general_prospecto";   
        break;    
      case 3:
          return "principal/center_page_general_prospecto"; 
      break;  
      
      default:
        return ""; 
      break;
    }
  }                                                

  /*NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN NAVEGACIÓN */
  /**/
  function evalua_social($url , $type , $in_session ){

    $social =  ''; 
    $icon =  ''; 
    $n_social =  ''; 
    if ($type ==  "fb"){      
      $icon =  ' fa fa-facebook ';
      $n_social =  ' Facebook '; 
    }elseif ($type == 'yt') {
      $icon =  ' fa fa-google-plus ';
      $n_social =  ' youtube '; 
    }
    if ($in_session == 1 ){
      if ( strlen($url)< 1 ) {
        $msj = "No has registrado url de " . $n_social . " para el evento ";
        $social .=  '
            <span class="aviso_social">
              '.$msj .'
            </span>
                ';  
      }
      $social .=  '
            <li>
                    <a href="'.$url.'">
                        <i class="'.$icon.'">
                        </i>
                    </a>
                </li>
                ';
    }else{
      $social .=  '
            <li>
                    <a href="'.$url.'">
                        <i class="'.$icon.'">
                        </i>
                    </a>
                </li>
                ';          
    }   
    return $social;   
  }
/**/


function btn_modal_config($public , $modal , $id ){

    if ($public ==  1 ){        
          return '  
                    <li data-toggle="modal" data-target="#'.$modal .'"  class="btn_configurar_enid_w " 
                    id="'.$id.'"> 
                      
                        <i class="fa fa fa-cog reservaciones_event" id="'.$id .'">
                        </i>                      
                      
                    </li>               
          ';
      }else{
        return ""; 
      }

}

/**/


  /**/
  function get_def_cargo($name, $class , $id ){

    $cargo = ["Director","Director comercial","Director de comunicación","Director de tecnología","Coordinador","Gerente","Subdirector","Supervisor","Jefe de operaciones","Staff","Staff","Otro"];
    $select =  "<select name= '".$name."' class='".$class ."' id='".$id."'>"; 
    for ($a=0; $a < count($cargo); $a++){

        if ($cargo[$a] ==  "Otro") {
              $select .=  "<option value='".$cargo[$a]."' selected >". $cargo[$a]."</option>";   
          }else{
            $select .=  "<option value='".$cargo[$a]."'>". $cargo[$a]."</option>"; 
        }
        
    }
    $select .=  "</select>"; 
    return $select;      
  }
  /**/
  function get_def_grupo($name, $class , $id  ){
    /**/
    $grupo =  ["Marketing" , "Audio y video" , "Iluminación" , "Calidad" , "Venta", "Escenografía" , "Comunicación" , "Información" , "Seguridad" , "Otro"];

    $select =  "<select name= '".$name."' class='".$class ."' id='".$id."'>"; 
    for ($a=0; $a < count($grupo); $a++){ 
        $select .=  "<option value='".$grupo[$a]."'>". $grupo[$a]."</option>"; 
    }
    $select .=  "</select>"; 
    return $select;      
  }
  /**/
  function get_turnos_def($name, $class , $id  ){

    $turno =  ["Matutino" , "Vespertino" , "Nocturno" , "Mixto"];
    $select =  "<select name= '".$name."' class='".$class ."' id='".$id."'>"; 
    for ($a=0; $a < count($turno); $a++) { 
        $select .=  "<option value='".$turno[$a]."'>". $turno[$a]."</option>"; 
    }
    $select .=  "</select>"; 
    return $select;  
  }
  /**/
  function evalua_url_youtube($url){
    /**/
    $icon = "<a style='color: #93a2a9 !important;'>Youtube</a>"; 
    if(strlen(trim($url)) > 5 ){
      $icon = "<a href='".$url."'>Youtube</a>"; 
    }
    return $icon;
  }
  /**/
  function evalua_url_social($url){
    /**/
    $icon = "<a style='color: #93a2a9 !important;'>Facebook</a>"; 
    if(strlen(trim($url)) > 5 ){
      $icon = "<a href='".$url."'>Facebook</a>"; 
    }
    return $icon;
  }
  /**/
  function evalua_direccion_enid($direccion ,  $id_evento ){

    $locacion = ""; 
    if (strlen(trim($direccion))>4){    
      $locacion =  "<i class='locacion fa fa-map-marker ' id='".$id_evento."' 
                        data-toggle='modal' data-target='#locacion-modal'  title='". $direccion."'>
                      </i>";  
    }else{
      $locacion =  "<i class='locacion fa fa-map-marker direccion_registrada' 
                        id='".$id_evento."' 
                        data-toggle='modal' data-target='#locacion-modal'  title='". $direccion."'>
                      </i>";  
    }   
    return $locacion; 

  }  
  
  function template_evento_admin($nombre_evento , $id_evento){
    $url =  url_evento_view_config($id_evento);
    $template =  "
              <div class='col-lg-12 col-sm-12 col-md-12 seccion-presentacion' >
                <div class='row'>
                  <a class='link-event-enid'  href='".$url."'>
                    <div class='nombre-evento-mov'>
                      ".$nombre_evento."
                    </div>                  
                  </a>  
                </div>
              </div>
              ";

      return $template;        
  }

  /**/
  function template_evento($nombre_evento ,  $id_evento , $id_empresa ,  $reservaciones = 1  , $flag_artistas = 0 ){
                          

    $url = create_url_evento_view($id_evento);
    $url_empresa = url_la_historia($id_empresa);
    $url_enid =  base_url();

    
    $btn_reservaciones  =  ""; 
    if ($reservaciones ==  1 ){      
        $btn_reservaciones =  btn_reservaciones();      
    }
    
    $template =  "
                ".n_row_12()."  
                <div class='seccion-presentacion' >                                    
                  ".n_row_12()."
                      <a style='color:#174163; font-size:3em; font-weight:bold; text-decoration:none; '  href='".$url."'>
                        ".$nombre_evento."
                      </a> 
                  ". end_row() ."

                  ".n_row_12()."  
                      <a style='text-decoration:none; font-weight: bold;' href='".$url_empresa."'>                                              
                        By 
                        <span class='place_nombre_empresa'>
                        </span>
                        <span class='nombre_empresa'>
                        </span>                        
                      </a>     
                  ". end_row() ."
                  <div>
                    
                    ".btn_asistencia() ."                                    
                    ".$btn_reservaciones."                                        
                    ".btn_solicita_tu_artista($id_empresa)."                    
                    ".btn_servicios($id_evento)."                    
                    ".btn_acceso($id_evento)."                                                         
                    ".btn_aristas_escenarios($id_evento ,  $flag_artistas) ."                    
                    </ul>                    
                  </div>
                </div>
              ". end_row() ."
            <hr>
              ";

      return $template;        
  }
  /**/
  function btn_aristas_escenarios($id_evento ,  $flag_artistas){


    $url = url_dia_evento($id_evento);
    if ( $flag_artistas ==  1 ){
      return "<a href='".$url."'> 
              <button class='load_resumen_escenarios_event btn_call_to_emp'  href='#section_dinamic_escenarios' role='tab' data-toggle='tab' class='tab_enid'  >
                Artistas
              </button> 
            </a>";       
    }else{
      return "";
    }

    
    
  }
  /**/
  function btn_servicios($id_evento){
    $url = url_dia_evento($id_evento);
    
    return "<a href='".$url."'> 
              <button class='empresa_reservacion btn_call_to_emp'>
                El día del evento
              </button> 
            </a>";     
    
  }
  /**/
  function btn_acceso($id_evento){
    $url =url_accesos_al_evento($id_evento);
    
    return "<a href='".$url."'> 
              <button class='empresa_reservacion btn_call_to_emp'>
                Precios
              </button> 
            </a>";     

  }
  /**/
  function btn_solicita_tu_artista($id_empresa){
    
    $url = url_solicita_artista($id_empresa);
    return "<a href='".$url."'> 
              <button class='empresa_reservacion btn_call_to_emp'>
                Solicita tu artista!
              </button> 
            </a>";     
  }
  /***/
  function btn_reservaciones(){

    
      return "<button data-toggle='modal' data-target='#reservaciones'  class='empresa_reservacion btn_call_to_emp'>
                Quiero reservar!
              </button> ";     

  }
  /**/
  /*
  function btn_comunidad($id_empresa){    
      $url =  base_url('index.php/emp/lahistoria')."/".$id_empresa;
      $btn =  "
                <li class='tab_accesos tab_enid pull-right'>
                  <span>             
                    <a class='text_link_accesos_enid' href='".$url."' >
                      Comunidad
                    </a>                
                  </span>
                </li>  
                ";
      return $btn;
  }
  */
  /**/
  function get_random(){
    return  mt_rand();       
  }
  /**/
  function get_select_divisas($name , $class , $id ){   
   
      $divisas = array("MXN", "USD", "AUD", "CAD", "CHF", "JPY", "NZD", "EUR", "GBP", "SEK", "DKK", "NOK", "SGD", "CZK", "HKD",  "PLN", "RUB", "TRY", "ZAR", "CNH");
      $select =  "<select name='".$name."' class='".$class ."' id='". $id ."'> ";   
      $x = 0;       
      for ($x=0; $x <count($divisas); $x++) { 
        $select .= "<option value='". $divisas[$x]."'>". $divisas[$x]."</option>";
      }
      $select .=  "</select>";
      return $select;    
  }
  /**/
  function construye_precios($data , $name){
    $select = "<select class='form-control precio_evento' name='".$name."'>"; 
      $select .= "<option value='-'> - </option>";
      foreach ($data as $row){      
        $select .= "<option value='".$row["precio"]."'>". $row["tipo_moneda"] ."</option>";
      }
    $select .= "</select>";     
    return $select; 
  }
  /**/
  
  function valida_session_enid($session){      
        
      if ($session != 1  ) {
          header("Location:" . base_url());
      }else{
        return 1;
      }        
  }   


  /**/
  function titulo_enid($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  /**/

  /**/
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

  /**/
        
  function create_icon_img($row , $class , $id , $extra= '' ,  $letra ='[Img]' ){      

    $color_random = '';  
    $base_img = base_url("application/img/img_def.png");
    $img =  "";
    if (isset($row["nombre_imagen"] )) {
        if (strlen($row["nombre_imagen"]) > 2  ){        
          $img =  '<img '. $extra .' class="'. $class .'" id="'.$id.'"  style="display:block;margin:0 auto 0 auto; width: 100%;" src="data:image/jpeg;base64, '. base64_encode($row["img"])  .'  " />';
          
        }else{
          /*Generamos color al de fondo */           
          //return  "<div ". $extra."  style = '". $color_random."' style='margin: 0 auto;' class='img-icon-enid text-center ". $class ." ' id='".$id  ."'  >". $letra ."</div>";          
          $img =  '<img '. $extra .' class="'. $class .'" id="'.$id.'"  style="display:block;margin:0 auto 0 auto; width: 100%;" src="'.$base_img.'  " />';
        }      
    }else{
          //return  "<div ". $extra."  style = '". $color_random."' style='margin: 0 auto;' class='img-icon-enid text-center ". $class ." ' id='".$id  ."'  >". $letra ."</div>";
      $img =  '<img '. $extra .' class="'. $class .'" id="'.$id.'"  style="display:block;margin:0 auto 0 auto; width: 100%;" src="'.$base_img.'  " />';
    }
    return $img;      
    
  }  
 /**/
  function simula_img($url , $class, $id , $title , $flag , $letra ='A' ){      
    $color_random = 'background : rgb(174, 13, 80); color:white; padding:50px;';    
    return  "<div style = '". $color_random."' class='img-icon-enid". $class ." ' id='".$id  ."'  title='". $title ."' >". $letra ."</div>";
    
  }
     


  /*
  */

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
          /* Tupla de indormación */
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
              /**/  

          } 
          $b = 0;         
          $filtro .= "</li>";
      } 

      /****************************************************************************************/      
      if (count($data) == 0 ){

          $filtro .=  "<em style='color:white; text-align:center;' >Sin resultados</em>"; 
      }
      $filtro .="</ul>";
      $filtro .="</div>";
      return $filtro; 
  }
  /**/
  function get_dias_restantes_evento($data){


    $dias_restantes  = $data[0]["dias"];
    $fecha_inicio  =  $data[0]["fecha_inicio"]; 
    $fecha_termino  =  $data[0]["fecha_termino"]; 

    $part =  "<span> ".fechas_enid_format($fecha_inicio , $fecha_termino )."  </span>";  

    if ($dias_restantes  == 0 ) {
      $dias_restantes = "Hoy es el evento " .$part  ; 
    }elseif ($dias_restantes  == 1 ) {      
      $dias_restantes = "Falta un día para el evento " . $part;  
    }elseif ($dias_restantes > 0 &&  $dias_restantes != 1   ) {
      $dias_restantes = "Falta " . $dias_restantes . " días " .$part ;  
    }else{
     $dias_restantes = "El evento sucedío hace " . abs($dias_restantes) . " días  ".$part; 
    }
    return "<a class='icon-maps' href='#enid-maps'>
                    <i class='fa fa-map-marker'>
                    </i>
                </a>".
                $dias_restantes;
  }
  function get_starts($val){

    $l =  "";
    for ($a=0; $a < $val; $a++) { 
      $l .=  "<i class='fa fa-star text-default'></i>";
    }
    return $l; 
  }
  /**/
  function get_start($val , $comparacion ){
    
      if ($val ==  $comparacion ) {
        return  $val . " <i class='fa fa-star'></i>"; 
      }else{
        return  $val;
      }
  }
  /**/
  function create_data_list($data  , $value  ,  $id_data_list){

    $data_list =  "<datalist id='". $id_data_list."'>"; 
    foreach ($data as $row) {
      $data_list .=  "<option value='". $row[$value]."' >";
    }
    $data_list .=  "</datalist>"; 
    return $data_list; 
  }
  /*Crea select*/
  
  function get_th($valor , $extra = '' )
  {
    return "<th ". $extra ." NOWRAP >". $valor ."</th>";
  }
  /**/
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
/**/
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
	/*Mes en letras*/
  
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


	}/*End function*/

  /*Filtros */

  function validate_text($texto){

       $texto = str_replace('"','', strip_tags($texto ));  
       $texto = str_replace("'",'', strip_tags($texto ));   
       return $texto;

  }

  /**/
  function valida_l_text($text){

    if (strlen($text) > 1 ){
      return $text;
    }else{
      return "";
    }
  }
  /**/
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
        /*Mandamos scroll si es necesario*/

        
        return $texto_a_validar;
}
function get_statusevent($status){

      $estado_evento ="";
      switch ($status) {
            case 0:
              $estado_evento = "Edición";
              break;
            case 1:
              $estado_evento = "Visible";
              break;
            case 2:
              $estado_evento = "Visible cancelado";
              break;            
            case 3:
              $estado_evento = "Visible pospuesto";
              break;            
            case 4:
              $estado_evento = "Cancelado";             
              break;                            
            case 5:
              $estado_evento = "Programado";              
              break;                              
            default:

              break;
          }

    return $estado_evento;      

  } 
  /**/
  /***/
  function dias_evento($dias_evento){
    /**/
    $response =  ""; 
    if ($dias_evento < 0 ){
      $response =  "El evento ya ha sucedido"; 
    }else if($dias_evento == 0 ){
      $response =  "Éste día es el evento";           
    }else{
      $response =   "Días para el evento " .  $dias_evento;
    }

    return $response;
  }
  /**/
  function now_enid(){
    return  date('Y-m-d');
  }
  /**/
  function fechas_enid_format($f_inicio , $f_termino ){
      
    if ($f_inicio !=  $f_termino) {
      $f_inicio = $f_inicio  . " al " . $f_termino ;
    }
    return $f_inicio;
  }
  /**/
  function hora_enid_format($hora_inicio , $hora_termino){
    if ($hora_inicio!= null OR strlen($hora_inicio)>3  ){
      $horario = "de ". $hora_inicio ." a ".  $hora_termino;  
    }else{
      $horario = "";
    }
    return $horario;
  }
  /**/
  function dinamic_class_table($a){
    $style ="";
    if ($a%2 == 0) {
      $style = "style='background:#F7F8F0;' ";   
    }
    return $style;
  }
  /*Construimos la url de l evento público */
  /**/
  function editar_btn($session , $href ){
    
      if ($session ==  1 ) {        
          return '  
                    <li class="btn_configurar_enid">
                      <a href="'.$href.'" >
                        <i class="fa fa fa-cog">
                        </i> 
                     
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
                        <i class="fa fa-plus">
                        </i> 
                     
                      </a>
                    </li>               
          ';
      }else{
        return ""; 
      }
  }  
  /**/  
  

  /**/
  function show_text_input($val , $num , $msj ){

    if (strlen($val) < $num ){
      return $msj;   
    }else{
      return $val; 
    }    
  }
  /**/
  function resumen_descripcion_enid($text){

      /**/
      $text_complete = ""; 
      if(strlen(trim($text)) > 100){        
        $text_complete .=  "<div class='text_completo_log_def   text_completo_log'>". $text ." </div>";
      }else{
        $text_complete =  "<div class='text_completo_log_def '>" .$text ."</span>";
      }
      return  $text_complete;

  }
  /**/
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
  /**/
  /**/
  function template_documentacion($titulo,  $descripcion , $url_img  ){    
      $block =  "
                  <span>
                  <b>"; 
      $block .= $titulo;
      
      $block .= "</b>
                </span>
                <br>
                <span>
                ". $descripcion;

      $block .= "</span>
                  <img src='".$url_img."' class='desc-img'>
                ";                          
      $block .= "<br>
                <br>";
      return $block;


  }
  
  /**/
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