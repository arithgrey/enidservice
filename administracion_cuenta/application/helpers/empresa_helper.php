<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
/**/
function validador_session_map($in_session){
  $v = 0;
  if ($in_session ==  1 ){
      $v =   "99999999";
  }
  return $v;
}  
/**/
function construye_galeria($data , $param ){

  $b = 0; 
  $a =  ""; 
  $galeria =  ""; 
  $in_session =  $param["in_session"];
  foreach ($data as $row) {
      
    $id_imagen = $row["id_imagen"];  
    $url_img =url_tmp_img($id_imagen);       
    $toggle =  "toggle-".($b +1);
    $class_panel_img='panel-image';
    if ($b > 0 ) {
        $class_panel_img='panel-image hide-panel-body';
    }
    if ($a == 0 ) {
      $galeria .= '<div class="row form-group"> ';
    }


    $galeria .= '<div class="col-xs-12 col-md-3 col-lg-3">'; 
        
        $img_galeria_delete =  "img_delete_".$id_imagen;
        $galeria .=  '<div class="'.$class_panel_img.'">';

          if ($in_session ==  1 ) {
            $galeria .=  '<i data-toggle="modal" data-target="#modal-eliminar-img"  class="fa fa-times eliminar_img '.$img_galeria_delete.'  " id="'.$id_imagen.'" style="display:none"></i>';  
          }        
          $galeria .=  '<img src="'.$url_img.'" class="img_galeria panel-image-preview" id="'.$id_imagen.'"/>';
        $galeria .= '</div>';
      
    $galeria .= '</div>';


    $b ++;
    if ($b >  1 ){
      $b = 0; 
    }

    $a ++; 


    if ($a ==  4 ) {    
      $galeria .= '</div>'; 
      $a = 0;    
    }


  }

  return $galeria;

}

/**/
function precio_editable_icon($a){
  $icono =  ["fa fa-times" , "fa fa-check"];
  return "<i class='".$icono[$a]."' ></i>";
}
/**/
function page_principal_empresa_cabecera(){
  $class_default =  "links_enid"; 

   $titulos = ["Inicio",
              "Historia" ,
              "Galeria" ,               
              "Reservaciones",
              "Ubicación",                 
              "Eventos"];

  $extras =  ['href="#pill-2" role="tab" data-toggle="tab" class="'.$class_default.' active" id="section-us"  ',                            
              'href="#pill-3" role="tab" data-toggle="tab" class="'.$class_default.' " id="historia-emp"  ',
              'href="#pill-4" role="tab" data-toggle="tab" class="'.$class_default.' galeria_imgs" id="galeria"  ',
              'href="#pill-5" role="tab" data-toggle="tab" class="'.$class_default.'"  ',
              'href="#pill-6" role="tab" data-toggle="tab" class="'.$class_default.'" id="section-ubicacion"  ',              
              'href="#pill-7" role="tab" data-toggle="tab" class="'.$class_default.'" id="section-eventos"  '
             ];


  return  construye_menu_enid_service($titulos , $extras );             
    
}
/**/
function page_principal_empresa(){

  $paginas =  ["empresa/detalle_historia" , 
              "empresa/historia_imagenes", 
              "empresa/galeria", 
              "empresa/secciones/reservaciones",
              "empresa/secciones/ubicacion",               
              "empresa/secciones/eventos"];
    return  $paginas;            
}
/**/
function muestra_seccion_ingresos_egresos_cabecera($perfiles){
    
    $id_perfil =  $perfiles[0]["idperfil"];    
    
    /**/
      $secciones_sup = ["Ingresos y Gastos" , "Inteligencia de negocio" , "Productos y promociones"];     
      $secciones_administrador =  ["Cuentas de la empresa" ,   "Productos y promociones" ];
      $secciones_cajero = ["Registrar ingresos" , "Registrar hecho a proveedor" ];    
    
    if($id_perfil ==  9 ){

      $a_cajero  =' href="#pago_de_consumidor" role="tab" data-toggle="tab" class="links_enid active" id="pago_de_consumidor_s" ';
      $b_cajero  =' href="#pago_a_proveedor" role="tab" data-toggle="tab" class="links_enid" id="pago_a_proveedor_s" ';
      $secciones_cajero_extra =  [$a_cajero , $b_cajero];
      return construye_menu_enid_service($secciones_cajero , $secciones_cajero_extra );

    }
    if ($id_perfil == 4 ){
      
      $a_admin  =' href="#registro_cuentas" role="tab" data-toggle="tab" class="links_enid active" id="registro_cuentas_s" ';
      $b_admin  =' href="#inteligencia_negocio_admin" role="tab" data-toggle="tab" class="links_enid active" id="inteligencia_negocio_admin_s" ';
      $c_admin  =' href="#productos_promociones" role="tab" data-toggle="tab" class="links_enid active" id="productos_promociones_s" ';
      $secciones_cajero_extra_sup =[$a_admin ,  $c_admin];  
      return construye_menu_enid_service($secciones_administrador , $secciones_cajero_extra_sup);
      
    }
    /**/
    if($id_perfil ==  3 ){
        

      $a_sup  =' href="#registro_cuentas" role="tab" data-toggle="tab" class="links_enid active" id="registro_cuentas_s" ';
      $b_sup  =' href="#inteligencia_negocio" role="tab" data-toggle="tab" class="links_enid" id="inteligencia_negocio_s" ';
      $c_sup  =' href="#productos_promociones" role="tab" data-toggle="tab" class="links_enid active" id="productos_promociones_s" ';
      $secciones_cajero_extra_sup =[$a_sup , $b_sup , $c_sup];
      return  construye_menu_enid_service($secciones_sup , $secciones_cajero_extra_sup );
      
    }

}
/**/
function muestra_seccion_ingresos_egresos($perfiles){

    $id_perfil =  $perfiles[0]["idperfil"];
    $secciones_admin = ["ingresos_egresos/view_admin" , "ingresos_egresos/view_admin_bi" , "ingresos_egresos/view_productos_prociones" ];
    $secciones_cajero = ["ingresos_egresos/view_nuevo_pago" , "ingresos_egresos/pago_a_proveedores" ];

    $secciones_super_administrador = ["ingresos_egresos/view_admin" , "ingresos_egresos/view_inteligencia_negocio" , "ingresos_egresos/view_productos_prociones"];
    if ($id_perfil ==  4 ){
      return $secciones_admin;  
    }
    /**/
    if($id_perfil ==  9 ){
      return $secciones_cajero;
    }
    if ($id_perfil ==  3 ){
      return $secciones_super_administrador;
    }

}

/**/
function get_class_estado_cuenta($ingreso , $egreso){

    $class= '';
    if ($ingreso >  $egreso){        
        $class ='buen_estado';
    }elseif ($ingreso < $egreso ) {
      $class ='mal_estado';
    }elseif ($ingreso ==  $egreso ){
      $class = 'sin_estado';
    }else{
      $class = 'sin_estado';
    }
    return $class;
}
/**/
function get_saldo($ingreso , $egreso){

  $total =  $ingreso  - $egreso;
  return $total;
}
/**/
function create_tmp_cuentas($data){

    

    
      $l =  "<table>
            <tr>";
      $l .= get_td( "<div class='btn_nuevo_link'> 
              <span> 
              + Agregar cuenta
              </span>
            </div>" , ' data-toggle="modal" data-target="#nueva-cuenta-modal"  '); 
      $a =0;
      foreach ($data as $row) {
      
        $id_cuenta =  $row["id_cuenta"];
        $nombre_cuenta  =  $row["nombre_cuenta"];
        $fecha_registro  =  $row["fecha_registro"];
        $descripcion =  $row["descripcion"];
        $extra_class= '';
        if ($a == 0 ) {
          $extra_class=' activa_cuenta ';
        }
        $cuenta_actual  =   $nombre_cuenta;
        $l .=  get_td($cuenta_actual ,  "class='btn_cuenta ".$extra_class." '  id='".$id_cuenta."'");

        $a ++;


      }
      $l .=  "</tr>
              </table>"; 
      return $l;
  
    
    
}
/**/
function create_tmp_select_categorias($data){

    $options ="<div class='input-group m-bot15'>          
              <span class='input-group-addon'>
                Categoría 
              </span>";
    $options .= "<select class='form-control input-sm' id='categoria_ingreso' name='categoria_ingreso'>";    
    foreach ($data as $row) {

      $options .="<option value='".$row["nombre"]. "' >". $row["nombre"] ."</option>";
    }

  $options .=  "</select>
                </div>";  
  return $options;

}
/**/
function btn_def_metricas( $in_session, $url){

  $btn =  ""; 
  if($in_session == 1){
    $btn =  "<a href='$url' class='btn_metricas'>
              <i class='fa fa-line-chart'>
              </i>
            </a>"; 
        
  }
  return $btn;  
}
/**/
function valida_call_comentarios( $url ,  $text ){

      
      $part_fb =  '<div class="fb-share-button" data-href="'.$url.'" data-layout="button" data-size="small" data-mobile-iframe="true">
                    <a class="fb-xfbml-parse-ignore" target="_blank" href="'.$url.'">
                    Compartir
                    </a>
                  </div>';
      $btn =  " <span style='font-weight:bold;'>
                  ".$text ."
                </span><br>                
                ".$part_fb."
                ";
  
  return $btn;

}
/**/
function validate_info_emp($val, $in_session  ,  $class ){
  $new_text =""; 
  if(trim( strlen($val)) == 0 ){
    $new_text =  "<span class='text-emp   ".$class ."'> historia de la empresa. </span>";
  }else{
    $new_text =  "<span class='text-emp  ".$class ."'>" . $val ."</span>";
  }
  return $new_text;
}
/**/
function get_select_paises($paises, $class , $id, $name ){

    
  $select =  "<select class='form-control ".$class." ' id='". $id ."' name='".$name ."'>";
  foreach ($paises as $row) {
    
    $select .=  "<option value='".$row["idCountry"]."' >".$row["countryName"] ."</option>";  
  }
  $select .= "</select>";
  return $select;

}
/**/
function modal_localizacion($in_session,  $localizacion){


  $text =  ""; 
  if ($in_session ==  1 ) {
      $text = "<label class='lb-pais' data-toggle='modal' data-target='#modal-locacion' >  
                ". $localizacion ."
                </label>";
  }else{
    $text = "<label class='lb-pais'>  
                ". $localizacion ."
              </label>";
  }
  return $text;
    

}
/**/
function edita_section_mensaje_comunidad($val, $session , $class=""){      
    $mensaje ="";    
    $new_text = "";    

    if (trim( strlen($val) ) == 0 ){
      $new_text = "<span>Mensaje para tu comunidad</span>";
    }else{
      $new_text = "<span> 
                    ".$val."
                  </span>";
    }        

    if ($session == 1){     

      

        $mensaje .="<textarea rows='5' 
                    style='display:none;'                     
                    class='form-control' 
                    id='comunidad-mensaje-input'     
                    name='mensaje-comunidad' 
                    placeholder='Mensaje para tu comunidad'>
                      ".$val."
                    </textarea>";                           
    }else{
      $mensaje = $new_text; 
    }
    return $mensaje; 
    /**/
}
/**/
function contruye_iconos_experiencia_cliente($data){

        /*7,1,2 artistas  , evetos, escenarios  */        
        $f_artistas =  0;         
        $f_eventos =  0; 
        $f_escenarios =  0; 
        $clases = ''; 
        $nombre =''; 
        $imgs =  ''; 


                
        
        $links = '';
        if (count($data)> 0){
          $links = '
                <li>
                    <a  class="tag-enid-galery" href="#" data-filter="*"> 
                        + 
                    </a>
                </li>
                ';     
        }
        
        
        

        foreach ($data as $row){

            $idimagen =  $row["idimagen"];
            $nombre_imagen =  $row["nombre_imagen"];
            $type  =  $row["type"]; 
            $img  =  $row["img"]; 
            $extension =  $row["extension"];

            switch ($type) {
                case 7:
                    $clases = '.artistas';
                    $nombre = 'artistas';    
                    if ($f_artistas == 0 ) {
                         $links .= '
                                    <li>
                                        <a class="tag-enid-galery"  href="#" data-filter="'.$clases.'">
                                            '.$nombre.'
                                        </a>
                                    </li>
                                    ';

                    }
                    $f_artistas++; 


                    break;

                case 1:
                    $clases = '.eventos';
                    $nombre = 'eventos';
                    if ($f_eventos == 0 ) {
                         $links .= '
                                <li>
                                    <a class="tag-enid-galery"  href="#" data-filter="'.$clases.'">
                                        '.$nombre.'
                                    </a>
                                </li>
                                ';
                    }
                    $f_eventos ++; 
                    break;

                case 2:
                    $clases = '.escenarios';                    
                    $nombre = 'escenarios';

                    if ($f_escenarios == 0 ) {
                         $links .= '
                                <li>
                                    <a class="tag-enid-galery"  href="#" data-filter="'.$clases.'">
                                        '.$nombre.'
                                    </a>
                                </li>
                                ';    
                    }
                    $f_escenarios ++; 
                    break;        
                
                default:
                    
                    break;
            }


            $img =  create_icon_img($row , ' ', ' '  ); 

            $imgs .= '
                    <div class=" '. $nombre .' item " >
                        <a href="#myModal" data-toggle="modal">
                            '. $img .'
                        </a>
                        <!--<p>
                            img01.jpg 
                        </p>-->
                    </div>            
                    ';
           
           
        }
        
        $icons["links"] = $links; 
        $icons["imagenes"] = $imgs;
        return $icons;
    }

/**/
function evalua_msj_solicitudes($public ){

  
}

/**/
function valida_seccion_config_expericia($seccion ,  $status , $idexperiencia){

  $extra =  "";
  if ($seccion == 3){    
    $extra .=  "<label class='lb-estado-comentario'>Estado actual del comentario</label><br>";     
    $extra .= "<div class='select_update_status'>" . get_select_tipo_comentario($status,  $idexperiencia ) . "</div>"; 
  }
  return $extra;
}
/**/
function get_select_tipo_comentario($tipo, $idexperiencia){

  $tipo_comentario = array("Comentario registrado sin ser aún aprobado pera ser público." ,
                           "Comentario publico para todos los espectadores." , 
                           "Comentario público soló para los administradores" );

  $d_class  =  "status_" . $idexperiencia; 
  $select =  "<select class='select-estado-exp form-control ".$d_class ." ' id=''>";  
    for ($x=0; $x <count($tipo_comentario) ; $x++) { 

      if ($tipo ==  $x ) {
          $select .=  "<option value='$x' selected>". $tipo_comentario[$x] ."</option>";    
      }else{
        $select .=  "<option value='$x'>". $tipo_comentario[$x] ."</option>";    
      }

    }
  $select .=  "</select>";  
  $select .=  "
              <br>                                                
              <button id='$idexperiencia' class='btn-estado-exp btn btn-default btn_save btn-registrar-cambios'>
                Registrar cambios
              </button>";  
  return $select; 
}
/**/
function get_tipo_comentario($tipo){
  $msj =  ""; 
  switch ($tipo){
    case 0:
      $msj =  "Comentario registrado sin ser aún aprobado pera ser público.";
      break;
    case 1:
      $msj =  "Comentario publico para todos los espectadores.";
      break;
    case 1:
      $msj =  "Comentario público soló para los administradores";
      break;
    default:      
      break;
  }
  return $msj;
}

/**/
function valida_title_experiencia($seccion,  $in_session = 0 ,  $id_empresa = 0){

  $title = '';
  switch ($seccion) {
    case 1:

      $title .= titulo_enid("La experiencia de otras personas.");
      break;
    case 2:


      $extra =  ""; 
      if ($in_session ==  1 ){
        $extra =  "<a style='color:white;' title='Ver los comentarios de la comunidad' href='".url_global()."'>
                    <i class='fa fa-line-chart'>
                    </i>
                  </a>                  
                  ";
      }


      $title .=  titulo_enid("Nuestros casos de éxito") . "<br> 


                  <a href='". create_url_historias($id_empresa) ."' class='comparte-tu-historia' style='padding: 10px;
                        background: #030f19;
                        color: white;'>
                    Compártenos tu historia!
                  </a>
                  <br><br>";                  
                  
      break;    
      case 3:
        $title .=  titulo_enid("Lo que tu comunidad opida de  tu empresa");
        break;
      
    default:
      
      break;
  }
  return $title; 
}

/*
function experiencias($data){

  $bloque = ""; 
  foreach ($data["experiencias"] as $row) {

      $id_empresa =  $row["idempresa"];        
      $calificacion =  $row["calificacion"];
      $nombre =  $row["nombre"];      
      $fecha_registro =  $row["fecha_registro"];
      $descripcion =   $row["descripcion"];      
      $bloque .= '
                <section class="blurb">
                  <div class="row">

                    <div class="title-autor">
                      '.$nombre.' 
                    </div>
                    <div class="calificaciones-info">                    
                      '.$fecha_registro.' | '. create_start($calificacion).'                                          
                    </div>

                  </div>                  
                  <div class="seccion-descripcion">                    
                      <span>
                        '.$descripcion .'
                      </span>                    
                  </div>                
              </section>
              ';
  }
  return $bloque;
}
*/
function create_start($num){
  
  $starts =""; 
  $default_start = "&#9733;";   
  for ($x=1; $x <= $num; $x++){ 
    $starts .= "<span> " . $default_start . "</span>";         
  }
  return $starts;

}
/**/
function get_inputs_starts($limit){
  $inputs  = '';
  for ($x=1; $x <=$limit ; $x++ ){     
          $inputs .= "
                  <input id='$x' class='input-start' type='radio' name='calificacion' value='$x'>
                  <label for='$x'> &#9733;
                  </label>
                ";     
  }
  return $inputs;
}
/**/
function comentarios_administrador($data){
  
  $comentarios = "";               
  $dinamic_class="";                
  $flag =0;
  foreach ($data as $row) {

      $text_comentario  =    $row["descripcion_contenido"];
      $calificacion = $row["calificacion"];
      $nombre_user_commnet  =  $row["nombre"];   
      $nombre_contenido =  $row["nombre_contenido"];     
      $fecha_registro =  $row["fecha_registro"];

      $mail  =  $row["mail"]; 
      $tel =  $row["tel"];

      $starts =  get_starts($calificacion); 

      if ($flag %2 == 0 ){
        $dinamic_class="in";
      }else{
        $dinamic_class="out";
      }

      $comentarios .='
        <li class="'.$dinamic_class.'">
            <img src="images/photos/user1.png" alt="" class="avatar">
            <div class="message ">
                <span class="arrow">
                </span>
                <a  href="#">
                  '. $nombre_user_commnet .'
                </a>
                <span class="datetime">
                  '. $fecha_registro .'
                </span>
                <span>
                  '.$starts.'
                </span>

                <span class="body">
                  '. $text_comentario  .'
                </span>
                <a class="pull-right">
                  '.$tel .' | '.$mail .'
                </a>

            </div>
        </li>
        ';
     $flag ++; 
    }
    return $comentarios;
}


/**/
function comentarios_clientes($data){ 

  $comentarios =  "<div>
      <h2 class='page-header'>La experiencia en nuestros eventos </h2>
        <section class='comment-list'>";  
       $flag=0; 
  foreach ($data as $row) {

      $text_comentario  =    $row["descripcion_contenido"];
      $calificacion = $row["calificacion"];
      $nombre_user_commnet  =  $row["nombre"];   
      $nombre_contenido =  $row["nombre_contenido"];     
      $fecha_registro =  $row["fecha_registro"];


      $starts =  get_starts($calificacion); 
     
         $comentarios .= '<article class="row">
            <div class="col-md-2 col-sm-2 col-md-offset-1 col-sm-offset-0 hidden-xs">
              <figure class="thumbnail">
                <center>
                  '. $starts .'
                </center>
                <figcaption class="text-center">                  
                  Puntuación
                </figcaption>
              </figure>
            </div>
            <div class="col-md-9 col-sm-9">
              <div class="panel panel-default arrow left">              
                <div class="panel-heading right">
                  Reply
                </div>              
                <div class="panel-body">
                  <header class="text-left">
                    <div class="comment-user"  style="font-size:.9em !important;">
                      <i class="fa fa-user">
                      </i>
                      '.$nombre_user_commnet.'
                    </div>
                    <time class="comment-date" style="font-size:.8em !important;">
                      <i class="fa fa-clock-o">
                      </i> 
                      '. $fecha_registro .'
                    </time>
                  </header>
                  <div class="comment-post">
                    <p>
                    '.$text_comentario.'
                    </p>
                  </div>   
                  <!--              
                  <p class="text-right">                  
                    <a href="#" class="btn btn-default btn-sm">
                      <i class="fa fa-reply">
                      </i> 
                      reply
                    </a>
                  </p>
                  -->                  
                </div>
              </div>
            </div>
          </article>
          '; 



      

    $flag++;
  }
  
  $comentarios .=  "  
        </section>
    </div>
  "; 

  return $comentarios;
}

/**/
function carga_logo_empresa($data_empresa  ){
 

  $img = ''; 
  $path_img  = ''; 
  $class_default =  "links_enid"; 
  $extra = 'href="#pill-3" role="tab" data-toggle="tab" class="'.$class_default.' " id="historia-emp"';  
  $url_img =  url_imagen_empresa($data_empresa["idempresa"]);
  return "<div class='img-logo-emp-section'>
            <img id='img-logo-emp' class='img-tmp-empresa'  ". $extra ." src='".$url_img ."' width='100%' >
          </div>"; 
      
}
/**/
function get_icono_social($in_session , $id_empresa , $url , $class_social  , $class_icon , $a ){

  $btn = '';
  $style_fb = "style='color: white !important; background: #133783; padding: 2px;' ";
  $style_tw = "style='color: #1DA1F2 !important;' ";
  $style_g =  "style='background: #CC181E !important; color: white;padding: 2px;' ";
  
  $estilos = [$style_fb , $style_tw , $style_g ];


  if ($in_session ==  1 ){
    $btn = '
    <span  class="'.$class_social.'" id="'.$id_empresa.'" 
      data-toggle="modal" data-target="#modal-social-empresa">
        <i class="'.$class_icon.'" '.$estilos[$a].' >
        </i>      
    </span>';
  
  }else{
    $btn = '
    <span class="'.$class_social.'"   id="'.$id_empresa.'" >
      <a href="'.$url.'" target="_blank">        
        <i class="'.$class_icon.'" '.$estilos[$a].'  >
        </i>
      </a>
    </span>';
      
  }
  return $btn;
}
/**/
function select_country($data){

  $select =""; 
  foreach ($data as $row) {
      $select .= "<option value='". $row["idCountry"]."'>". $row["countryName"]."</option>";
  }
  

  return $select;
}

/**/
function select_pais($data){
  
  $options ="";
  foreach ($data as $row) {
    
    if ($row["nombreempresa"] != null ) {

      $options .="<option value='". $row["idCountry"] ."' selected>". $row["countryName"] . "</option>";  
    }else{
      $options .="<option value='". $row["idCountry"] ."'>". $row["countryName"] . "</option>";
    }
    
  }
  return $options;


}

/**/
function usuarios_reportados($data){

  $options ="";
  $options .= "<select class='form-control usuario_reportado' id='usuario_reportado' name='usuario_reportado'>";
    foreach ($data as $row) {

      $options .="<option value='".$row["idusuario"]. "' >". $row["nombre"]  ."   (" .$row["email"] .")" ."</option>";
    }

  $options .=  "</select>";  
  return $options;
}
function sub_tipos_inicidencia_options($data){

  $options ="";
  $options .= "<select class='form-control sub-tipo' id='sub-tipo' name='sub-tipo'>";
    foreach ($data as $row) {

      $options .="<option value='".$row["idsub_tipo_incidencia"]. "' >". $row["subtipo"] ."</option>";
    }

  $options .=  "</select>";  
  return $options;
}

/**/
function tipos_inicidencia_options($data){

  $options = "";

    foreach ($data as $row) {
      $options .="<option value='". $row["idtipo_incidencia"]  . "' >". $row["tipo_incidencia"] ."</option>";
    }

  return $options;
}

/**/
/*
function data_contactos_empresa($data){

  $list ="<table class='table table-bordered'>";
    $list .="<tr class='text-center enid-header-table'>";
            $list .=  get_td(" IMG" , "");
            $list .= get_td("Contacto", "");
            $list .= get_td("Organización  ", "");
            $list .= get_td("Tel <", "");
            $list .= get_td("Móvil ", "");
            $list .= get_td("Página web ", "");
            $list .= get_td(" +agregar </", "");
    $list.=  "</tr>";
    $flag=0;
    $contacos_asociados =0;

    foreach ($data as $row) {
      
      $nombre  = $row["nombre"];
      $organizacion  =  $row["organizacion"];     
      $tel =  $row["tel"];
      $movil  = $row["movil"];
      $pagina_web = $row["pagina_web"];

      $contactoemp =  $row["contactoemp"];
      $input ="";
      $id_contacto  =  $row["idcontacto"];
      if ($contactoemp != null ){
        
        $input ="<input type='checkbox' id='". $id_contacto ."' class='contactos_asociados' checked>";
        $contacos_asociados ++;
      }else{
        $input ="<input type='checkbox' id='".$id_contacto."' class='contactos_asociados'>";
        
      }

      $list.="<tr class='text-center media usr-info' >";
          if ($row["nombre_imagen"] != null ){

            $img = base_url( $row["base_path_img"].$row["nombre_imagen"]);

            $list.="<td class='prog-avatar'>          
                      <img style='width:35px !important; height:35px !important;'  class='thumb'  src='".$img ."'>            
                    </td>";       
          }else{
            $list.="<td class='prog-avatar'> 
                      <i class='fa fa-picture-o fa-2x'   ></i>
                    </td>";

          }


      $list.="<td class='franja-vertical'>".$nombre."</td><td>".$organizacion ."</td>";
          

      $list.="<td>".$tel."</td> 
            <td>".$movil ."</td>
            <td>".$pagina_web ."</td>
            <td>". $input ."</td>
            </tr>";

      $flag++;        
    }

    $list .="</table>
    <div><span>Contactos disponibles: ". $flag.", asociados a la empresa: ". $contacos_asociados  ."</span></div>
    <div>

      <div id='response_contacto_empresa' class='response_contacto_empresa' ></div>
      <span><a href='". base_url('index.php/directorio/contactos') ."'><button class='btn btn-block btn-info'>+ir  a la sección de contactos</button></a></span>
    </div>";
    return $list;
  }
  */
}/*Termina el helper*/