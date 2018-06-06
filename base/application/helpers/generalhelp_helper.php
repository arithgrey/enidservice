<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
/**/
function text_agregar_telefono($has_phone , $telefono_visible){
  
  if ($has_phone ==0 && $telefono_visible == 1) {
    
    $config["class"] =  "invitacion_registro_telefono";
    $config["style"] =  "color:white!important";
    $link =  anchor('../../administracion_cuenta/',  
                    'INDICA A TUS CLIENTES ALGÚN NÚMERO 
                      TELEFÓNICO DONDE PUEDAN SOLICITAR 
                      MÁS INFORMES SOBRE TUS PRODUCTOS'
                    , $config );  

    return "<div class='add_phone'>".$link."</div>";
  }
}
function valida_activo_ventas_mayoreo($estado_actual , $ventas_mayoreo){

    if ($estado_actual == $ventas_mayoreo ) {
      return "button_enid_eleccion_active";
    }
}
/**/
function valida_activo_informes_por_telefono($valor , $valor_usuario){
  if($valor ==  $valor_usuario){
      return "button_enid_eleccion_active";
  }  
}  
/**/
function valida_activo_entregas_en_casa($valor , $valor_usuario){

  if($valor ==  $valor_usuario){
      return "button_enid_eleccion_active";
  }
} 
/**/
function valida_activo_vista_telefono($valor , $valor_usuario){

  if($valor ==  $valor_usuario){
      return "button_enid_eleccion_active";
  }
} 
/**/
function porcentaje($cantidad,$porciento){
  //return number_format($cantidad*$porciento/100 ,$decimales);
  return $cantidad*$porciento/100;
}
/**/
function entrega_data_campo($param , $key , $label="", $add_label=0 ){        
    if($add_label == 1){      
      return $label ."  ". $param[0][$key];    
    }else{
      return $param[0][$key];    
    }    
}
/**/
function valida_valor_variable($option , $key){

  /**/
  $valor ="";
  if(isset($option[$key])) {
    $valor =  $option[$key];  
  }
  return $valor;
}

/**/
function valida_active($num , $num_tab){

  if ($num ==  $num_tab) {
    return ' class="active" ';
  }

}
/**/
function valida_active_pane($num , $num_tab){
  
  if ($num ==  $num_tab) {
    return ' active ';
  }  
}
/**/
function  valida_text_imagenes($tipo_promocion, $imgs){
    if(count($imgs) == 0){                       
      $tipo_promocion=  strtolower($tipo_promocion); 
      $text =  n_row_12();
          $text .="<div class='mensaje_imagenes_visible'>
                        Muestra imagenes sobre tu ". $tipo_promocion."
                        a posibles clientes
                    </div>";
      $text .= end_row();
      $text .= n_row_12();
          $text .="<div>
                    <small class='small_agregar_imagenes' style='font-size: .7em!important;'>
                       Tu ".$tipo_promocion." NO será visible hasta que incluyas algunas imágenes
                    </small>
                  </div>";
      $text .= end_row();
      return  $text;
    }      
}
/**/
function valida_existencia_imagenes($imgs){

    $estilos =" style='display:none;' ";
    if(count($imgs)> 0){
      $estilos ="";
    }
    return $estilos;
}
/**/
function get_info_variable($param , $nomber_variable ){
    /**/
    $valor =0;
    if(isset($param[$nomber_variable]) && $param[$nomber_variable] != null ){             
        $valor = $param[$nomber_variable];
    }
    return $valor;
  }

function create_meta_tags($string , $id_servicio){

  $tags=   explode(",", $string);
  $listado_tag ="";
  foreach ($tags as $row){?>      
    <span 
        class='tag_servicio' 
        id="<?=$row?>">         
        <i 
          onclick="eliminar_tag('<?=$row?>' ,  '<?=$id_servicio?>' );"
          class="fa fa-times " >        
        </i>
        <?=$row?>
    </span>

  <?php } 
}
/**/
function get_dominio($url){
    $protocolos = array('http://', 'https://', 'ftp://', 'www.');
    $url = explode('/', str_replace($protocolos, '', $url));
    return $url[0];
}
function get_background_secciones(){
  
  $colores_por_red_social = ["" , 
  "background:#3b5998; color:white;" , 
  "background:#fff059; color:black;" , 
  "" , 
  "background:#283e4a; color:white;" , 
  "background:#1da1f2; color:white;" , 
  "background:red; color:white;" , 
  "background:#bd081c; color:white;" , 
  "background:black; color:white;", 
  "background:blue; color:black;",
  "background:#006621; color:white;", 
  "background:#529ecc; color:white;" ];

  return $colores_por_red_social;

}
/**/
function get_nombre_usuario_registro($msj){
  
    $nombre =  $msj["nombre"];
    $apellido_paterno =  $msj["apellido_paterno"]; 
    $apellido_materno =  $msj["apellido_materno"];      
    $email  = $msj["email"];    
    $usuario_registro =  $nombre . " " . $apellido_materno ." " . $apellido_paterno;
    $fecha_registro = $msj["fecha_registro"];

    $id_usuario= $msj["id_usuario"];

    /**/
    $url_img ="../imgs/index.php/enid/imagen_usuario/".$id_usuario;
    $img ="<img src='".$url_img."' style='width:100%;'>";
    //return $img.$usuario_registro ." | ".$email ." | ". $fecha_registro;  

    $usuario ='
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <div class="media">
                <a class="pull-left">
                    <img 
                      class="media-object dp img-circle" 
                      src="'.$url_img.'" style="width: 100px;height:100px;">
                </a>
                <div>
                    <span>
                    '.$usuario_registro.'
                    </span> 
                    <br>
                    <span>
                      '.$email.'
                    </span>            
                    <br>
                    <span>
                      '.$fecha_registro.'
                    </span>                   
                </div>
            </div>
        </div>
    </div>';
    return $usuario;

}

/**/
function valida_usuario_registro_mensaje($id_usuario, $id_usuario_registro , $id_mensaje){

  $btn_editar = "";
  if($id_usuario ==  $id_usuario_registro){

      $btn_editar ="<i 
                    class='fa fa-pencil edicion_mensaje' 
                    id='".$id_mensaje."'           
                    data-toggle='tab'
                    href='#tab_registro_msj'>           
                  </i>";
  }
  return $btn_editar;

}
/**/
function get_nombre_servicios($info_servicios){

  $nombre_servicio ="";
  foreach ($info_servicios as $row){    
    $nombre_servicio  =  $row["nombre_servicio"];     
  }
  return $nombre_servicio;
}
/**/
function get_url_social($id_usuario , 
                        $id_tipo_negocio , 
                        $red_social , 
                        $id_mensaje , 
                        $id_servicio , 
                        $flag_servicio,
                        $url_web_servicio,
                        $url_request){    
    
                


    $extra_url ="";
    switch($red_social){

      case 1:
        $extra_url = get_parte_facebook($id_usuario, $id_tipo_negocio , $id_mensaje);                     
        break;      
      case 2:
        $extra_url = get_parte_mercado_libre($id_usuario , $id_tipo_negocio ,  $id_mensaje);   
        break;      
      case 3:
        $extra_url = get_parte_gmail($id_usuario , $id_tipo_negocio ,  $id_mensaje);    
        break;
      case 4:
        $extra_url = get_parte_linkeding($id_usuario, $id_tipo_negocio ,  $id_mensaje);
        break;    
      case 5:
        $extra_url = get_parte_twitter($id_usuario , $id_tipo_negocio ,  $id_mensaje);
        break;      
      case 6:
        $extra_url = get_parte_gmail($id_usuario , $id_tipo_negocio ,  $id_mensaje);
        break;   
      case 7:
        $extra_url = get_parte_pinterest($id_usuario , $id_tipo_negocio ,  $id_mensaje);
        break;              
      case 8:
        $extra_url = get_parte_instagram($id_usuario , $id_tipo_negocio ,  $id_mensaje);
        break;            
      default:
        break;
    }

    /******************/
    
    
    $url_servicio =$url_request."producto/?producto=".$id_servicio."&".$extra_url;
    
    if(strlen(trim($url_web_servicio)) > 1){
      $url_servicio = $url_web_servicio."?&".$extra_url;  
    }

    return $url_servicio;
}
/**/
/**/
function lista_categorias($categorias){
  $l = "";
  /*Ventas y soporte*/
  foreach($categorias as $row){
    
    $id_categoria = $row["id_categoria"];
    $nombre_categoria = $row["nombre_categoria"];
    $faqs = $row["faqs"];   
     
    $l.= "<div class='col-lg-4' style='margin-top:25px;'>";         
      $href ="?categoria=".$id_categoria;
      $l.= "<a href='". $href."' style='font-size:.8em;'>";
        $l.= "<i class='fa fa-file-text-o'>
            </i>
            <span class='strong' style='color:#0242C5;'>".$nombre_categoria."</span>"."(".$faqs.")";
      $l.= "</a>";    
    $l.= "</div>";
  }
  return $l;
  
}
function multiexplode($delimiters,$string) {
   
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

/**/
function filtar_correos($param){
 
  $cadena = $param["text_info"];
  
  $array=  multiexplode(array("'", ",","|",":","[", "]", '"', "*","!" , " ", "\n", "\r" , "á" , "é", "í", "ó", "ú" , "?" , "¿" , "/", ")" , "(" , "`" , "", "-" , ";", "%", "…" , "……" , "ã" , "(*)" , "<" , ">") ,$cadena);  
  $correos = $array;
  $arreglo_solo_gmail = filtra_lineas_con_gmail($correos);  
  return $arreglo_solo_gmail;  
}
/**/
function filtra_lineas_con_gmail($correos){

  $arreglo_solo_gmail = [];
  $b = 0; 
  for($a=0; $a < count($correos); $a++){ 
      if(preg_match("/@gmail.com/", $correos[$a])  ==  1 ){          
          $arreglo_solo_gmail[$b] = $correos[$a];                      
          $b++;            
      }  
  }

  $arreglo_sin_punto =  quita_punto($arreglo_solo_gmail);
  $correos_limpios =  pasa_a_minusculas_y_valida_extension($arreglo_sin_punto);
  return $correos_limpios;  
}
/**/
function pasa_a_minusculas_y_valida_extension($arreglo){
    
  $nuevo_arreglo =[];
  $b =0;
  for ($z=0; $z <count($arreglo); $z++){ 
    
      if(strlen($arreglo[$z])>14 ){                
        $nuevo_arreglo[$b] = strtolower($arreglo[$z]);
      }
      $b++;
  }
  return $nuevo_arreglo;

}
/**/
function quita_punto($arreglo){
  

  $arreglo_solo_gmail = [];
  $b = 0;
  for ($z=0; $z < count($arreglo); $z++) { 
      

      $palabra =  $arreglo[$z];
      $nueva_palabra =  "";
      
      for($i=0; $i < strlen($palabra); $i++) { 
        
          if($palabra[$i] != "@"){            
              if ($i == 0 ){                  
                  if($palabra[$i] == "."){
                      $nueva_palabra .= "";                  
                  }else{
                    $nueva_palabra .= $palabra[$i];                  
                  }
              }else{
                $nueva_palabra .= $palabra[$i];              
              }      
              
          }else{
                $nueva_palabra .= "@gmail.com";            
            break;
          }  
            
      }
      $arreglo_solo_gmail[$b] = trim($nueva_palabra);

      $b ++;
  }
  return $arreglo_solo_gmail;
}
/**/
function valida_class_extra_scroll($data){

    if (count($data) > 20) {
      return "contenedor_movil contenedor_listado_info";
    }else{
      return "contenedor_listado_info";
    }
}

/**/
function get_url_servicio_def( $servicio , $red_social , $id_usuario ){

  $url_servicio = ["",
           "http://enidservice.com/inicio/paginas_web/?",            
           "http://enidservice.com/inicio/tienda_en_linea/?",
           "http://enidservice.com/inicio/crm/?" , 
           "http://enidservice.com/inicio/adwords/?",
           "http://enidservice.com/inicio/paginas_web/?"]; 


  if ($red_social ==  1 ){
   return $url_servicio[$servicio]."?q=1&q2=$id_usuario";          
  }if($red_social ==  2 ){
    return $url_servicio[$servicio]."?q=2&q2=$id_usuario";              
  }        
   
}
/**/
function get_tag_delete_perfiles($num){

  if ($num > 0 ) {
    return "<button class='btn limpiar_perfiles_dia pull-right' style='background:blue !important;'>
                Limpiar
            </button>";    
  }  
}
/**/
function get_lista_perfiles($perfiles , $extra){
  
  $listado = "";
  $extra2= "";
  if($extra["solo_lectura"] ==  1) {
    $extra2 ="readonly";
  }
  foreach ($perfiles  as $row){

    $idtipo_negocio =  $row["idtipo_negocio"];
    $nombre = $row["nombre"];
    $prospeccion =  $row["prospeccion"];

    $extra =  "";
    $extra_val  =  0;
    if( $prospeccion == 1 ){
      $extra =  "checked";  
      $extra_val  =  1;
    }
    $listado .= '<tr>';    
      $input = '<input 
          name="tipo_servicio" 
          id="'.$idtipo_negocio.'" 
          value="'.$extra_val.'" 
          type="checkbox"
          '.$extra.'
          '.$extra2.'
          class="tipo_servicio form-control">';     
      $listado .= get_td($input . "<span>".$nombre."</span>");
    $listado .= '</tr>';
    
  }
  return $listado;
}  
/**/
function get_perfiles_disponible_dia($data){
    
    $lb ="";
    $a =0;
    $z =0;
    foreach ($data as $row) {

      if ($a > 1 ) {
        $lb .= "<br>";  
        $a =0;
      }
      $lb .= "<i style='margin-left: 10px;'            
            class='fa fa fa-times-circle-o red_enid_background white lb_nota tipo_servicio'
            id='".$row["idtipo_negocio"]."'
            value='1'>
          </i>
          <span class='lb_nota white blue_enid_background strong'>".$row["nombre"]."
          </span>";
          $a++;
          $z ++;
    }
    return $lb;
}

/**/
function get_tels($id_usuario){        
    $l ='<div style="font-size:.8em;">(55)8395-4993 <br> (55)3269-3811</div>';
    return $l;
}
/**/  
function get_parte_facebook($id_usuario, $id_tipo_negocio ,  $id_mensaje){    
      return "q=1&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
function get_parte_mercado_libre($id_usuario ,  $id_tipo_negocio ,  $id_mensaje){    
      return "q=2&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
function get_parte_linkeding($id_usuario,  $id_tipo_negocio ,  $id_mensaje){    
      return "q=3&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
function get_parte_twitter($id_usuario,  $id_tipo_negocio ,  $id_mensaje){    
      return "q=4&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
function get_parte_gmail($id_usuario,  $id_tipo_negocio ,  $id_mensaje){    
      return "q=5&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
function get_parte_blog($id_usuario,  $id_tipo_negocio ,  $id_mensaje){    
      return "q=6&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}/**/
function get_parte_pinterest($id_usuario,  $id_tipo_negocio ,  $id_mensaje){
  return "q=7&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
/**/
function get_parte_instagram($id_usuario,  $id_tipo_negocio ,  $id_mensaje){
  return "q=8&q2=$id_usuario&q3=$id_tipo_negocio&q4=$id_mensaje";
}
  /**/
  function evalua_titulo_menu_principal($nombre ,  $email ){
    
    $menu =  ""; 
    if ( strlen($menu )> 0 ){
      $menu =  $nombre;
    }else{
      $menu = $email;
    }
    return $menu;
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
  
  function valida_maps_public_org($formatted_address ,  $id_empresa){

    $maps =  "<span class='text-map-prox'>
                Próximamente se publicará el lugar del evento
              </span>"; 

    if (trim(strlen($formatted_address)) >  3 ){
      $url = url_tmp_maps(). "/".$id_empresa."/0/";
      $maps ="
          <span class='text_map'>
              ".$formatted_address." 
            </span>
            <iframe  height='500px;' width='100%'   id='iframe_maps_conf'  
                 src='".$url."'>
            </iframe> 
            ";  
    }

    $maps_complete =  "<div class='maps_enid '>
                ".$maps."     
              </div>";
    return $maps_complete;        
}

  /**/
  function valida_maps_public($formatted_address ,  $id_evento  ){

    $maps =  "<span class='text-map-prox'>
            Próximamente se publicará el lugar del evento
          </span>"; 

    if (trim(strlen($formatted_address)) >  3 ){
      $url = url_tmp_maps(). "/".$id_evento."/0/";
      $maps ="
          <span class='text_map'>
              ".$formatted_address." 
            </span>
            <iframe  height='500px;' width='100%'   id='iframe_maps_conf'  
                 src='".$url."'>
            </iframe> 
            ";  
    }

    $maps_complete =  "<div class='maps_enid '>
                ".$maps."     
              </div>";
    return $maps_complete;        
}
  /**/
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
      $horario = "por definir";
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
  function valida_reservaciones( $public , $tel , $mail ,  $modal ,  $id ='' ){

  $text_user_complete =  "";  
  $text_user = "";  
  $num_tel =  strlen(trim($tel));
  $num_mail =  strlen(trim($mail));


    $flag =0; 
    if ($num_tel > 0 ){
      $text_user .=  "Tel.  ".$tel ;
      $flag ++; 
    }if ($num_mail > 0 ) {
      $text_user .=  "  ".$mail; 
      $flag ++; 
    }


    if ($public ==  1 ){
      
        $text_user_complete =  "Reservaciones "; 
      

    }else{
      
      if ($flag == 0  ) {
        $text_user_complete =  "Reservaciones pŕoximanente"; 
      }else{
        $text_user_complete =  "Reservaciones  ";
      }

    }

  return  btn_modal_config($public ,  $modal  ,  $id ). "          
          <span class='text-reservaciones'> 
            " . $text_user_complete. $text_user ."
          </span>"; 
  }
  /**/
  

}/*Termina el helper*/