<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  /**/
  function get_en_existencia($existencia , $flag_servicio , $in_session){
    
    if($existencia > 0 && $flag_servicio ==  0 && $in_session ==  1){
    
        return "<span 
                    style='margin-right:10px;'
                    title='Articulos en existencia y listos para ser vendidos'>
                    ". $existencia." En existencia "."
                </span>";
    }else{

        if($in_session == 1){
            return "<span class='white'
                          style='margin-right:10px;padding:2px;background:red;'>
                        INVENTARIO LIMITADO
                    </span>";
        }
          
    }
  }
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
  

}/*Termina el helper*/