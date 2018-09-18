<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){

  
  function get_valor_fecha_solicitudes($solicitudes, $fecha_actual){

    $valor =0;
    foreach ($solicitudes as $row){        
                  
        $fecha_registro =  $row["fecha_registro"];  
        if($fecha_registro ==  $fecha_actual) {
          
          $tareas_solicitadas = $row["tareas_solicitadas"];
          $valor  =  $tareas_solicitadas;
          break;  
        }        
    }
    return $valor;

  }
  
    
  /*  
  function width_productos_sugeridos($num_productos){
    
    $style_tabla ="";
    $style_producto =" style='width:250px!important;' ";
    switch (count($num_productos)){
      case 1:
        $style_tabla =" style='margin:0auto;' ";
        break;      
      case 2:
        $style_tabla =" style='margin:0auto;' ";
        break;
      case 3:
        $style_tabla =" style='margin:0auto;' ";
        break;
      case 4:
        $style_tabla =" style='margin:0auto;' ";
        break;
      case 5:
        $style_tabla =" style='margin:0auto;' ";
        break;
      default:      
        break;
    }

    $data_complete["tabla"] = $style_tabla;
    $data_complete["producto"] = $style_producto;
    return $data_complete;
  }
  
  
  
  
  
  function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
  }
  
  
  
  function tareas_realizadas($realizado, $fecha_actual){

    $valor =0;
    foreach ($realizado as $row){        
                  
        $fecha_termino =  $row["fecha_termino"];  
        if($fecha_termino ==  $fecha_actual){        

          $tareas_termino = $row["tareas_realizadas"];
          $valor  =  $tareas_termino;
          break;  
        }        
    }
    return $valor;

  }
  
  function get_comparativas_metricas( $hora_actual,  $info_global){

      
      $list ="";
      $num_tareas_menos_7 =0;

      $style ="";
      
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
  
  function get_franja_horaria(){

      $info_hora =[];
      for ($a=23; $a >= 0; $a--) { 
        
        $info_hora[$a] =  $a;
      }
      return $info_hora;
  }
  
  function get_fechas_data($info_global){

      $lista_fechas ="";
      $style =" ";
      foreach($info_global as $row){          

        $fecha = $row["fecha"];  
        $lista_fechas .= get_td($fecha , $style);        
      }
      return $lista_fechas;

  }
  
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
  
  function get_num_actual($num ){

    if($num > 0 ){
      return $num;
    }else{
      return  0; 
    }

  }

  
  function get_diferencia_metas($meta , $actual ){

    return   $meta - $actual; 
  }
  
  function valida_diferente_null($data ,  $campo){    
    
    
    if( count($data["data_usuario_email"]) > 0){
      return $data["data_usuario_email"][0][$campo];
    }else{
      return 0;
    }  
  }
  
  function create_img_enid($url_img){

    return "<img src='".$url_img."' class='img_enid'>";
  }
  
  function contenedor_page_start(){
    return "<div class='row contenedor-enid' >
              <div class='col-lg-12 col-md-12 col-sm-12'>";
  }
  function contenedor_page_end(){
    return "</div>
          </div>";
  }
  
  function construye_menu_enid_service($titulos , $extras ){
      $menu =  ""; 
      for ($a=0; $a < count($titulos ); $a++){ 
        $menu .=  "<a ".$extras[$a]." >" . $titulos[$a]." | </a>" ; 
      }
      return $menu;
  }
  
  
  
  function num_asistencia($max , $name){
    
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
  
  function get_mensaje_user_actualizado($f){
      $msj = ["", "Tu cuenta ha sido actualizada con éxito inicia ahora!" ,  
                "Ya tienes tu cuenta registrada inicia sessión "]; 
      return $msj[$f];
  }
  


  

  function navegador(){
    return $_SERVER['HTTP_USER_AGENT'];
  }
  
  function ip_user(){
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
    return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
  }  
  
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
      
      case 1:
          return base_url('index.php/enid/img_evento')."/".$val_extra;
        break;
      
      case 2:
          return base_url('application/img/landing/1.jpg');
        break;
      
      case 3:
        return base_url('application/img/landing/11.png');
        break;
        
      case 4:
        return base_url('application/img/landing/11.png');
        break;
        
      case 5:
        return base_url('application/img/landing/11.png');
        break;
        
      case 6:
        return base_url('index.php/enid/imagen_empresa')."/".$val_extra;
        break;    

      
      case 7:
        return base_url('application/img/landing/prospectos.jpg');
        break; 
      
      case 8:
        return base_url('application/img/landing/session.jpg');
        break;    
      
      case 9:
        return base_url('application/img/landing/prospectos.jpg');
        break;    
      
      case 10:
        return base_url('application/img/landing/25.jpg');
        break;
      
      case 11:
        return base_url('application/img/landing/encuesta.png');
      break;  
      
      case 12:
        return base_url('application/img/landing/21.jpg');
      break;  

      default:
          return base_url('application/img/landing/1.jpg');
        break;
    }
  }

  
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
  
  function get_def_grupo($name, $class , $id  ){
    
    $grupo =  ["Marketing" , "Audio y video" , "Iluminación" , "Calidad" , "Venta", "Escenografía" , "Comunicación" , "Información" , "Seguridad" , "Otro"];

    $select =  "<select name= '".$name."' class='".$class ."' id='".$id."'>"; 
    for ($a=0; $a < count($grupo); $a++){ 
        $select .=  "<option value='".$grupo[$a]."'>". $grupo[$a]."</option>"; 
    }
    $select .=  "</select>"; 
    return $select;      
  }
  
  function get_turnos_def($name, $class , $id  ){

    $turno =  ["Matutino" , "Vespertino" , "Nocturno" , "Mixto"];
    $select =  "<select name= '".$name."' class='".$class ."' id='".$id."'>"; 
    for ($a=0; $a < count($turno); $a++) { 
        $select .=  "<option value='".$turno[$a]."'>". $turno[$a]."</option>"; 
    }
    $select .=  "</select>"; 
    return $select;  
  }
  
  function evalua_url_youtube($url){
    
    $icon = "<a style='color: #93a2a9 !important;'>Youtube</a>"; 
    if(strlen(trim($url)) > 5 ){
      $icon = "<a href='".$url."'>Youtube</a>"; 
    }
    return $icon;
  }
  
  function evalua_url_social($url){
    
    $icon = "<a style='color: #93a2a9 !important;'>Facebook</a>"; 
    if(strlen(trim($url)) > 5 ){
      $icon = "<a href='".$url."'>Facebook</a>"; 
    }
    return $icon;
  }
  
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
  
  function get_random(){
    return  mt_rand();       
  }
  
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
  
  function construye_precios($data , $name){
    $select = "<select class='form-control precio_evento' name='".$name."'>"; 
      $select .= "<option value='-'> - </option>";
      foreach ($data as $row){      
        $select .= "<option value='".$row["precio"]."'>". $row["tipo_moneda"] ."</option>";
      }
    $select .= "</select>";     
    return $select; 
  }
  
  
  function valida_session_enid($session){      
        
      if ($session != 1  ) {
          header("Location:" . base_url());
      }else{
        return 1;
      }        
  }   


  
  function titulo_enid($titulo){

    $n_titulo =  n_row_12() 
                 ."<h1 class='titulo_enid_service'>
                    ". $titulo ."
                    </h1>".
                 end_row();

    return $n_titulo;             
  }
  

  
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
 
  function simula_img($url , $class, $id , $title , $flag , $letra ='A' ){      
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
      $l .=  "<i class='fa fa-star text-default'></i>";
    }
    return $l; 
  }
  
  function get_start($val , $comparacion ){
    
      if ($val ==  $comparacion ) {
        return  $val . " <i class='fa fa-star'></i>"; 
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
      function get_tareas_pendienetes_usuario_cliente($info){
    
      $info_notificaciones = $info["info_notificaciones"];
      $adeudos_cliente =  $info_notificaciones["adeudos_cliente"];  

      
      $lista_pendientes ="";                      
      $style_pedientes = "style='padding:4px;background:red!important;color:white!important;'";      
      $flag_notificaciones = 0;                         

      if($adeudos_cliente > 0 ){
        
          $lista_pendientes .= "<li class='black ' > ";
          $lista_pendientes .= "<a href='../area_cliente/'>";
          $lista_pendientes .= "<span $style_pedientes>
                                 Saldo pendiente ". round($adeudos_cliente, 2)." MXN
                              </span>";           
          $lista_pendientes .= "</a>";                  
          $lista_pendientes .= "</li>";  
          $flag_notificaciones ++;                           
      }
      
      $new_flag_notificaciones = "";
      if ($flag_notificaciones > 0 ) {
        $new_flag_notificaciones =  "<span class='notificacion_tareas_pendientes_enid_service'>
                                      ".$flag_notificaciones."
                                    </span>"; 
      }


      
      $data_complete["num_tareas_pendientes_text"] = $flag_notificaciones;  
      $data_complete["num_tareas_pendientes"] = $new_flag_notificaciones;
      $data_complete["lista_pendientes"] = $lista_pendientes;
      return $data_complete;
      
    
    
    }


    

    function get_tareas_pendienetes_usuario_soporte($info){


      $info_notificaciones = $info["info_notificaciones"];

      $lista_pendientes ="";  
      
      $meta_email = 0;
      $meta_email_registrados = 0; 
     
      $correos_registrados_enid_service = $info_notificaciones["correos_registrados_enid_service"];  
      

      $style_pedientes ="style='padding:4px;background:red!important;color:white!important;'";
      
      $flag_notificaciones = 0; 

    foreach ($info_notificaciones["objetivos_perfil"] as $row) {
      
      
      switch ($row["nombre_objetivo"]) {
        
          case "email_registrados":
          $meta_email_registrados = $row["cantidad"];       

          if ($meta_email_registrados  > $correos_registrados_enid_service){            

            $correos_pendientes  = 
            ($meta_email_registrados - $correos_registrados_enid_service);
            

                $lista_pendientes .= "<li class='black ' > ";
                $lista_pendientes .= "<a href='../cargar_base/'>
                                        <i class='fa fa-database'></i> ";
                $lista_pendientes .= "<span $style_pedientes>
                              ". $correos_pendientes
                              ."
                          </span>"; 
                $lista_pendientes .= "Registros
                                </a>";
                
                $lista_pendientes .= "</li>";  
                $flag_notificaciones ++;                         
          }



          break;
   
        default:
          
          break;
      }

    }


    $new_flag_notificaciones = "";
    if ($flag_notificaciones > 0 ) {
      $new_flag_notificaciones =  "<span class='notificacion_tareas_pendientes_enid_service'>".$flag_notificaciones."</span>"; 
    }


    
    $data_complete["num_tareas_pendientes_text"] = $flag_notificaciones;  
    $data_complete["num_tareas_pendientes"] = $new_flag_notificaciones;
    $data_complete["lista_pendientes"] = $lista_pendientes;
    return $data_complete;
  
  
  }
  
  function get_tareas_pendientes_vendedor($info){


      $info_notificaciones = $info["info_notificaciones"];
      $lista_pendientes ="";  
      
      $meta_ventas = 0;       
      $meta_envios_a_validar = 0;
      $meta_email = 0;
      $meta_llamadas =0; 
      $meta_contactos = 0;
      $meta_accesos = 0; 
      $meta_tareas = 0; 
      $meta_email_registrados = 0; 
      $meta_direccion = 0;
      $meta_temas_de_ayuda = 0;
      $meta_contactos_promociones =0; 

    
      $ventas_realizadas = $info_notificaciones["ventas_usuario"];      
      $contactos_enid_service =  $info_notificaciones["contactos_enid_service"];
      $llamadas_enid_service =  $info_notificaciones["llamadas_enid_service"];
      $contactos_promociones = $info_notificaciones["contactos_promociones_enid_service"];
      $email_enviados_enid_service = $info_notificaciones["email_enviados_enid_service"];
      $style_pedientes ="style='padding:4px;background:red!important;color:white!important;'";
      
      $flag_notificaciones = 0; 

    foreach ($info_notificaciones["objetivos_perfil"] as $row) {
      
      
      switch ($row["nombre_objetivo"]) {
        
          case "Ventas":
          
          $meta_ventas = $row["cantidad"];       

          if ($meta_ventas  > $ventas_realizadas){            

                $ventas_pendientes  = ($meta_ventas - $ventas_realizadas);            
                $lista_pendientes .= "<li class='black ' > ";
                $lista_pendientes .= "<a href='../ventas/'>
                                        <i class='fa fa-money' ></i> ";
                $lista_pendientes .= "<span $style_pedientes>". $ventas_pendientes."</span>"; 
                $lista_pendientes .= "Ventas</a>";                
                $lista_pendientes .= "</li>";  
                $flag_notificaciones ++;                         
          }
          break;
          
          case "Contactos":
          $meta_contactos = $row["cantidad"];       

          if($meta_contactos  > $contactos_enid_service){           
              
              $contactos_restantes  = ($meta_contactos - $contactos_enid_service);

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../tareas/'>
                                    <i class='fa fa-user'></i> ";
              $lista_pendientes .=  "<span $style_pedientes>".
                                      $contactos_restantes
                                     ."</span>"; 
                  $lista_pendientes .= "Prospectos
                                    </a>";
              
              $lista_pendientes .= "</li>";    
              $flag_notificaciones ++;                       
          }
          break;

          case "Llamadas":
          $meta_llamadas = $row["cantidad"];  

          
            if($meta_llamadas  > $llamadas_enid_service){           

                $llamadas_restantes = ($meta_llamadas - $llamadas_enid_service);

                $lista_pendientes .= "<li class='black ' > ";
                $lista_pendientes .= "<a href='../ventas/'>
                                      <i class='fa fa-mobile'></i> ";
                $lista_pendientes .= "<span $style_pedientes>".$llamadas_restantes."</span>"; 
                $lista_pendientes .= "Llamadas
                                      </a>";
               
                $lista_pendientes .= "</li>";    
                $flag_notificaciones ++;                      
            }



          break;    


          case "Contactos_promociones":
          $meta_contactos_promociones = $row["cantidad"];  

          
            if($meta_contactos_promociones  > $contactos_promociones){           

                $llamadas_restantes = ($meta_contactos_promociones - $contactos_promociones);

                $lista_pendientes .= "<li class='black ' > ";
                $lista_pendientes .= "<a href='../tareas/'>
                                      <i class='fa fa-star-o'></i> ";
                $lista_pendientes .= "<span $style_pedientes>".$llamadas_restantes."</span>"; 
                $lista_pendientes .= "Afiliados
                                      </a>";
               
                $lista_pendientes .= "</li>";    
                $flag_notificaciones ++;                      
            }

        break;        

        case "Email":
      
          $meta_email = $row["cantidad"];       
          
          if ($meta_email  > $email_enviados_enid_service){           
              $email_restantes = ($meta_email -  $email_enviados_enid_service);
                $lista_pendientes .= "<li class='black ' > ";
                $lista_pendientes .= "<a href='../tareas/'>
                                      <i class='fa fa-envelope-o'></i> ";
                $lista_pendientes .= "<span $style_pedientes>
                                      ".$email_restantes."
                                      </span>"; 
                $lista_pendientes .= "Email
                                      </a>";              
                $lista_pendientes .= "</li>";   
                $flag_notificaciones ++;                       
            }

          break;  
          
            

        default:
          
          break;
      }

    }


    $new_flag_notificaciones = "";
    if ($flag_notificaciones > 0 ) {
      $new_flag_notificaciones =  "<span class='notificacion_tareas_pendientes_enid_service'>".$flag_notificaciones."</span>"; 
    }

    $data_complete["num_tareas_pendientes_text"] = $flag_notificaciones;  
    $data_complete["num_tareas_pendientes"] = $new_flag_notificaciones;
    $data_complete["lista_pendientes"] = $lista_pendientes;
    return $data_complete;
  
  
  }
  
  function get_faltantes_meta($v , $v2){
    
  }
  
  function get_tareas_pendienetes_usuario($info){


    $info_notificaciones = $info["info_notificaciones"];

    $lista_pendientes ="";  
    
    $meta_ventas = 0;
    $meta_envios_a_validar = 0;
    $meta_email = 0;
    $meta_llamadas =0; 
    $meta_contactos = 0;
    $meta_accesos = 0; 
    $meta_tareas = 0; 
    $meta_email_registrados = 0; 
    $meta_direccion = 0;
    $meta_temas_de_ayuda = 0;


    $ventas_enid_service = $info_notificaciones["ventas_enid_service"];
    $envios_a_validar = $info_notificaciones["envios_a_validar_enid_service"];
    $email_enviados_enid_service = $info_notificaciones["email_enviados_enid_service"];
    $llamadas_enid_service =  $info_notificaciones["llamadas_enid_service"];
    $contactos_enid_service =  $info_notificaciones["contactos_enid_service"];
    $accesos_enid_service =  $info_notificaciones["accesos_enid_service"];
    $tareas_enid_service =  $info_notificaciones["tareas_enid_service"];
    $correos_registrados_enid_service = $info_notificaciones["correos_registrados_enid_service"];  
    $tareas_enid_service_marketing = $info_notificaciones["tareas_enid_service_marketing"];
    
    $tareas_enid_service_temas_ayuda = $info_notificaciones["blogs_enid_service"];

    
    $tareas_enid_service_direccion = $info_notificaciones["num_pendientes_direccion"];
    

    $style_pedientes ="style='padding:4px;background:red!important;color:white!important;'";
    
    $flag_notificaciones = 0; 

  foreach ($info_notificaciones["objetivos_perfil"] as $row) {
    
    
    switch ($row["nombre_objetivo"]) {
      case "Ventas":
        $meta_ventas = $row["cantidad"];  

          if ($meta_ventas > $ventas_enid_service){           
            
            $ventas_restantes = ($meta_ventas - $ventas_enid_service);
            
              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../ventas/'>
                                    <i class='fa fa-credit-card'></i> ";
              $lista_pendientes .= "<span $style_pedientes>".$ventas_restantes."</span>"; 
              $lista_pendientes .= "Ventas
                                    </a>";              
              
              $lista_pendientes .= "</li>"; 
            $flag_notificaciones ++; 
          }

          
        break;
      
      case "Envios_a_validar":

        $meta_envios_a_validar = $row["cantidad"];  

          if ($meta_envios_a_validar  > $envios_a_validar){           

            $envios_a_validar_restantes =($meta_envios_a_validar - $envios_a_validar);

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../validacion/'>
                                    <i class='fa fa-paper-plane'></i> ";
              $lista_pendientes .= "<span $style_pedientes>".
                                      $envios_a_validar_restantes
                                    ."</span>"; 
              $lista_pendientes .= "Envios a validar
                                    </a>";
              
              $lista_pendientes .= "</li>";
              $flag_notificaciones ++;                          
          }

        break;

      case "Llamadas":
        $meta_llamadas = $row["cantidad"];  

        
          if($meta_llamadas  > $llamadas_enid_service){           

              $llamadas_restantes = ($meta_llamadas - $llamadas_enid_service);

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../ventas/'>
                                    <i class='fa fa-mobile'></i> ";
              $lista_pendientes .= "<span $style_pedientes>
                                    ".
                                    $llamadas_restantes
                                    ."</span>"; 
              $lista_pendientes .= "Llamadas
                                    </a>";
             
              $lista_pendientes .= "</li>";    
              $flag_notificaciones ++;                      
          }



        break;    
      
      case "contactos":
        $meta_contactos = $row["cantidad"];       

        if($meta_contactos  > $contactos_enid_service){           
            
            $contactos_restantes  = ($meta_contactos - $contactos_enid_service);

            $lista_pendientes .= "<li class='black ' > ";
            $lista_pendientes .= "<a href='../ventas/'>
                                  <i class='fa fa-user'></i> ";
            $lista_pendientes .=  "<span $style_pedientes>".
                                    $contactos_restantes
                                   ."</span>"; 
            $lista_pendientes .= "Contactos
                                  </a>";
            
            $lista_pendientes .= "</li>";    
            $flag_notificaciones ++;                       
        }



        break;    

      case "Email":
        $meta_email = $row["cantidad"];       


        if ($meta_email  > $email_enviados_enid_service){           
            $email_restantes = ($meta_email -  $email_enviados_enid_service);
              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../tareas/'>
                                    <i class='fa fa-envelope-o'></i> ";
              $lista_pendientes .= "<span $style_pedientes>
                                    ".$email_restantes."
                                    </span>"; 
              $lista_pendientes .= "Email
                                    </a>";              
              $lista_pendientes .= "</li>";   
              $flag_notificaciones ++;                       
          }


        break;

      case "Accesos":
        $meta_accesos = $row["cantidad"];     




        if ($meta_accesos  > $accesos_enid_service){            

          $accesos_restantes  = ($meta_accesos - $accesos_enid_service);



              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../tareas/'>
                                    <i class='fa fa-globe'></i> ";
               $lista_pendientes .= "<span $style_pedientes>".$accesos_restantes.
                                    "</span>"; 
              $lista_pendientes .= "Accesos
                                    </a>";
             
              $lista_pendientes .= "</li>";    
              $flag_notificaciones ++;                       
          }


        break;
      
      case "Desarrollo_web":
        $meta_tareas = $row["cantidad"];        

        if ($meta_tareas  > $tareas_enid_service){            

          $tareas_restantes  = ($meta_tareas - $tareas_enid_service);        


              $lista_pendientes .= "<li class='black ' >
                                    <a href='../desarrollo'> ";
                $lista_pendientes .= "<i class='fa fa-code' ></i> ";
                $lista_pendientes .= "<span $style_pedientes>".$tareas_restantes."</span>";                
                $lista_pendientes .= "Desarrollo";
                $lista_pendientes .= "</a>
                                    </li>";           
              $flag_notificaciones ++;                
        }



        break;

        case "email_registrados":
        $meta_email_registrados = $row["cantidad"];       

        if ($meta_email_registrados  > $correos_registrados_enid_service){            

          $correos_pendientes  = 
          ($meta_email_registrados - $correos_registrados_enid_service);
          

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../cargar_base/'>
                                      <i class='fa fa-database'></i> ";
              $lista_pendientes .= "<span $style_pedientes>
                            ". $correos_pendientes
                            ."
                        </span>"; 
              $lista_pendientes .= "Registros
                              </a>";
              
              $lista_pendientes .= "</li>";  
              $flag_notificaciones ++;                         
        }



        break;




        case "marketing":
        $meta_marketing = $row["cantidad"];       

        if ($meta_marketing  > $tareas_enid_service_marketing){            

          $tareas_restantes_marketing  = 
          ($meta_marketing - $tareas_enid_service_marketing);
          

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../desarrollo/'>
                                    <i class='fa fa-flag'></i> ";
              $lista_pendientes .= "<span $style_pedientes>
                                      ". $tareas_restantes_marketing
                                      ."
                                  </span>"; 
              $lista_pendientes .= "Marketing";
              
              $lista_pendientes .= "</a>
                                    </li>";  
              $flag_notificaciones ++;                         
        }



        break;



       case "direccion":
        $meta_direccion = $row["cantidad"];       

        if ($meta_direccion  > $tareas_enid_service_direccion){            

          $tareas_restantes_direccion  = ($meta_direccion - $tareas_enid_service_direccion);
          

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../desarrollo/'>
                                    <i class='fa fa-building'></i> ";
              $lista_pendientes .= "<span $style_pedientes>
                                      ". 
                                      $tareas_restantes_direccion
                                      ."
                                  </span>"; 
              $lista_pendientes .= "Dirección";
              
              $lista_pendientes .= "</a>
                                    </li>";  
              $flag_notificaciones ++;                         
        }



        break;
      
        case "Temas de ayuda":
        $meta_temas_de_ayuda = $row["cantidad"];       

        if ($meta_temas_de_ayuda  > $tareas_enid_service_temas_ayuda){            

          $tareas_enid_service_temas_ayuda1  = ($meta_temas_de_ayuda - $tareas_enid_service_temas_ayuda);
          

              $lista_pendientes .= "<li class='black ' > ";
              $lista_pendientes .= "<a href='../faq/'>
                                    <i class='fa fa-television' ></i> ";
              $lista_pendientes .= "<span $style_pedientes>
                                      ". 
                                      $tareas_enid_service_temas_ayuda1
                                      ."
                                  </span>"; 

              $lista_pendientes .= "Temas de ayuda";              
              $lista_pendientes .= "</a>
                                    </li>";  
              $flag_notificaciones ++;                         
        }



        break;
      
 

      default:
        
        break;
    }

  }


  $new_flag_notificaciones = "";
  if ($flag_notificaciones > 0 ) {
    $new_flag_notificaciones =  "<span class='notificacion_tareas_pendientes_enid_service'>".$flag_notificaciones."</span>"; 
  }


  
  $data_complete["num_tareas_pendientes_text"] = $flag_notificaciones;  
  $data_complete["num_tareas_pendientes"] = $new_flag_notificaciones;
  $data_complete["lista_pendientes"] = $lista_pendientes;
  return $data_complete;
  
  
  }



  
  function get_fechas_cotizador($param){
    
    $fechas = get_td(
      "<span class=' text-tb'>
        Periodo
      </span>" , 
      "style='color:white!important;' ");
    
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
      
    
      $info_clientes = get_td(
        "<span class=' text-tb'>
          Clientes
        </span>" , 
        "class='titulo_table_descargas white' 
          style='background:#ea2900;color:white!important;'
         title='Nuevos clientes' ");
      
      $info_clientes_sistema =  get_td(
        "<span class=' text-tb'>
          Posibles clientes - web
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
            Servicios/Venta
          </span>" , 
          "class='titulo_table_descargas white' 
          title='Proyectos realizados' " );

         $info_prospecto_contacto =  get_td(
          "<span class=' text-tb white'>
            Posibles clientes
          </span>" , 
          "class='titulo_table_descargas white' 
          style='background:#2b2b9f;color:white; '
          title='Contacto con personas' ");



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

      $num_clientes =  valida_num($row["clientes"]);
      $num_prospectos =  valida_num($row["prospectos"]);
      $num_prospectos_sistema = valida_num($row["prospectos_sistema"]);

      $num_registrados =  valida_num($row["prospectos_registrados"] );  
      $num_enviados =  valida_num($row["email_enviados"]);
      
      $num_email_leidos =  valida_num($row["num_email_leidos"]);
      $num_blogs =  valida_num($row["num_blogs"]);
      
      $afiliados=  $row["afiliados"];  

      $num_tareas_resueltas =  $row["num_tareas_resueltas"];

      
      $extra_proyecto = 
      "class=' text-tb proyectos_registrados' id='".$row["fecha"]."' 
      num_proyectos= $num_proyectos   ";  


      $extra_clientes = 
        "class=' text-tb clientes_info' 
        id='".$row["fecha"]."' 
        style='background:#ea2900!important; color:white!important;'
        num_proyectos= $num_clientes  ";  


      $extra_clientes_sistema = 
        "class=' text-tb num_prospectos_sistema' 
        id='".$row["fecha"]."' 
        style='background:#2621ef!important; color:white!important;'
        num_proyectos= $num_prospectos_sistema  ";      


      $extra_prospectos_contacto = 
        "class=' text-tb posibles_clientes_contacto white' id='".$row["fecha"]."' 
        style='background:#2b2b9f;color:white; '
        num_proyectos= $num_prospectos ";      


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
      
      
      $fechas .=  get_td(      
      $fecha .  "" . $row["fecha"] , 
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

      
      
      
      $info_contactos .= 
        get_td(
          $numero_contactos ,
         $extra_contactos);



      $info_prospecto_contacto .= 
        get_td(
          $num_prospectos ,
          $extra_prospectos_contacto);


        $info_contactos_promociones .= 
        get_td(
          $num_contactos_promociones ,
         $extra_contactos_promociones);


        $info_clientes .= get_td(
                            $num_clientes ,
                            $extra_clientes);

        $info_clientes_sistema .= get_td( $num_prospectos_sistema, $extra_clientes_sistema);


      
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
    $data["info_visitas"] =  $info_visitas;

    $data["cotizaciones"] = $info_cotizaciones;    
    $data["info_clientes"] = $info_clientes;
    
    $data["info_afiliados"] =  $info_afiliados;
    $data["prospectos_contato"] = $info_prospecto_contacto;
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
  
  function valida_total_menos1($anterior , $nuevo , $extra ='' )
  {
    
    $extra_class='style=""';
    if ($anterior > $nuevo ){
      $extra_class='style="background:#ff1b00!important; color:white!important;" ';
    }
    return get_td(
      $nuevo ,  $extra_class .  " " . $extra);
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
  
  function valida_num($num)
  {
    $n_num =  0;
    if ($num > 0  ){
        $n_num  = $num;
    }
    return $n_num;


  }
  
  function get_fechas_global($lista_fechas ){

    $dias = array("",  'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo'); 
    $fechas ="<tr>";
    $b =0;

    $estilos2 =" style='font-size:.8em;background: #0022B7;color: white;' ";
    $estilos ="  ";
    foreach($lista_fechas as $row){   

        if($b == 0){
          $fechas .= get_td("Horario" , $estilos2);
          $fechas .= get_td("Total" , $estilos2);   
          $b++;
        }
        
        $fecha_text  = $dias[date('N', strtotime($row) )];    
        $text_fecha =  $fecha_text ."".$row;
        $fechas .= get_td( $text_fecha , $estilos2);
      }
      $fechas .="</tr>";
      return $fechas;
      
  }

  */

  

  
  
}