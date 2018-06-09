<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
/**/
function get_status_confirm($class ,  $name , $id ){

    $estados = array( "Seleccione", "Pendiente por confirmar", "Artista confirmado", "Cancela su asistencia", "Promesa de asistencia");
    $select =  "<select class='form-control input-sm ".$class ." ' name='".$name."' id='".$id."'>"; 
    for ($a=0; $a < count($estados); $a++){ 
        $select .=  "<option value='".$estados[$a]."'>".$estados[$a]."</option>"; 
    }
    $select .=  "</select>"; 
    return $select;
}
/**/
function get_tipos_paticipacion(){

    $tipos_participacion = array("-", "Estelar", "Especial", "Apertura", "General" , "Otro");    
    $select =  "<select name='tipo_artista'  class='tipo_escenario form-control input-sm' id='tipo_escenario' >"; 
    for($a=0; $a <count($tipos_participacion); $a++ ){         
        $select .=  "<option value='".$tipos_participacion[$a]."'>".$tipos_participacion[$a]."</option>";         
    }
    $select .=  "<select>"; 
    return $select;
}
/**/
function format_descripcion($desc){

    $text_desc =  ""; 

    if (trim(strlen($desc)) > 700 ){
        $part = substr($desc, 0 , 700);

        $text_desc = "<span class='hiddden_descripcion'>".$desc."</span>";
        $text_desc .= "<span class='show_descripcion'>".$part."</span>";
      

    }else{
        $text_desc = show_text_input($desc , 5 , "+ La experiencia que se vivirá" ); 
    }
    return $text_desc;        
}
/**/
function template_btn_tipos(){


    $tipos = array("General"  , "Principal" ,  "Especial");
    $btn =  "<ul class='dropdown-menu' aria-labelledby='btnGroupVerticalDrop1'>";
    for ($a=0; $a <count($tipos); $a++) { 
        $btn .=  "<li class='tipo-escenario' id='".$tipos[$a]."'>
                    <a id='".$tipos[$a]."'>
                     ". $tipos[$a]."   
                    </a>
                </li>"; 
    }
    $btn .=  "</ul>";
    return $btn;
}

/**/
function slider_item_escenario($imgs , $param){
    $item = '<div class="carousel-inner">';
      $x =0;
      foreach ($imgs as $row) {
        $flag_indicator =  "";
        $slider_num =  "slide-".$x;
        if ($x == 0 ) {
          $flag_indicator =  "active";     
        }
        $msj_extra =  "";                        
        if ($param["public"] == 1 ) {
          $msj_extra = '
              <span class="nombre-escenario-enid">
                '.$param["nombre_escenario"].'
              </span>                
            ';
        }          
        $item .=  '<div class="item slides '.$flag_indicator.' ">';
        
        $imagen  = create_img_url_sl( $row["id_imagen"]);
        
        $item .="<div> ".$imagen."</div>";
                 $item .='<div class="hero">                            
                              '.$msj_extra .'
                          </div>'; 
        $item .=  '</div>';
        $x ++;
      }
    $item .= '</div>';
    return $item;
}

/**/
function  slider_ol_escenario($num_imgs){
    $indicator =  '<ol class="carousel-indicators">'; 
    for ($x=0; $x <$num_imgs ; $x++) {       
      $flag_indicator =  "";
      if ($x == 0 ) {
        $flag_indicator =  "active";     
      }
      $indicator.=  '<li data-target="#bs-carousel" data-slide-to="'.$x.'" class="'.$flag_indicator .'"></li>';    
    }
    $indicator.= '</ol>';
    return $indicator;  
}

/**/
function evalua_fechas_enid_format($format){

    $n_format =  ""; 
    if (trim($format) > 4) {
        $n_format =  $format ." |";
    }
    return $n_format;
}
/**/
function evalua_desc($descripcion , $in_session , $id_escenario  ){      
        
        $url =   create_url_config_escenario($id_escenario)."/#experiencia";        
        $btn =  editar_btn($in_session , $url );
        $text =  trim($descripcion); 
        $new_text =  $descripcion; 
        if ($in_session == 1 ){
            if (strlen($descripcion) < 5 ){ 
                $new_text =  $btn .'<span class="msj_notificacion_config" > Cargar experiencia. </span>';      
            }
        }else{
            if (strlen($descripcion) < 5){
                $new_text = 'Próximamente lo que vivirás  al asistir al evento.'; 
            }
        }    

        /*ahora validamos que no pase de los 300*/
        if ( strlen($new_text)>700){        
            $primer_part = "<span class='hiddden_descripcion'>  
                            ".$new_text ."
                            </span>";
            $part_descripcion =  substr($new_text, 0 ,  700);  
            $new_text = $primer_part . "<span class='show_descripcion' >
                                            ". $part_descripcion ."
                                        </span>
                                        <center>
                                            <span class='row more-info-f more-info-f-down'>
                                                <i class='fa fa-chevron-down' aria-hidden='true'>
                                                </i>
                                            </span>
                                            <span class='row more-info-f more-info-f-up'>
                                                <i class='fa fa-chevron-up' aria-hidden='true'>
                                                </i>
                                            </span>

                                        </center>";                 
        }
        return $new_text;               
    }
/**/
function get_escenarios_block($escenario, $id_evento  , $limit_text= 270 ,  $show_edit=0 , $show_delete = 0 , $show_view_like_public = 0){   

   
        $elements ="<div class='col-12 col-md-12 col-sm-12'>";      
        if (count($escenario) == 0 ) {
            $elements.= "<br> <center><h1> No se han cargado escenarios ni artistas al evento aún</h1></center>";
        }
        foreach ($escenario as $row){
            
            $nombre = $row["nombre"];  
            $tipo =  $row["tipoescenario"]; 
            $fecha_presentacion_inicio =  $row["fecha_presentacion_inicio"]; 
            $fecha_presentacion_termino =  $row["fecha_presentacion_termino"]; 
            $id_escenario =  $row["id_escenario"];           
            $num_artistas =  $row["num_artistas"]; 
            $descripcion_escenario =  $row["descripcion_escenario"]; 

            $url_next = create_url_escenario_in_evento($id_escenario , $id_evento);
             
            $url_config =  create_url_config_escenario($id_escenario);            
            /**/
            $img  = create_icon_img($row ,  "  " , " " );             
            $fecha_presentacion  =   fechas_enid_format($fecha_presentacion_inicio , $fecha_presentacion_termino  ); 
                 
            $config ="";             
            if($show_edit == 1){                                                    
                $config = '
                    <a href="'.$url_config.'" class="more resum_evento pull-right">
                        <i class="fa fa-cog"></i> 
                    </a>'; 
            }            
            $elements .= '                  
        <div class="panel"> 
                            
                '.$config.'
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="blog-img-sm">
                                <a href="'.$url_next.'" >
                                '. $img .'
                                <a>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h1 class="">
                                <a href="'.$url_next.'">
                                '.  $nombre  .'
                                </a>
                            </h1>

                            <p>
                            <p class=" auth-row">
                                <a href="#"></a> '. $tipo .'  |  '.$fecha_presentacion .'   | <a href="#">'. $num_artistas .'</a>
                            </p>                            
                            '. $descripcion_escenario .'
                            </p>                          
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        ';                            

        }      
        $elements .=  "</div>";                      
        return $elements;              
}


/*******************************************************************************************************/
function load_complete_escenario($data){
    $table = "";
    $table .= '<table class="table table-bordered">
                <tr class="enid-header-table">';
    $table .= get_td("#" , "");  
    $table .= get_td("Escenario" , "");
    $table .= get_td("Tipo" , "");
    $table .= get_td("Descripción" , "");
    $table .= get_td("Fecha registro" , "");
    $table .= get_td("Fecha presentación" , "");
    $table .= get_td("Fin presentación" , "");
    $table .= '</tr>';            
    $flag =  1;
    foreach ($data as $row) {

        $table .=  "<tr>"; 
        $table .= get_td($flag , "");
        $table .= get_td($row["nombre"], "");
        $table .= get_td($row["tipoescenario"], "");
        $table .= get_td($row["descripcion"], "");
        $table .= get_td($row["fecha_registro"], "");
        $table .= get_td($row["fecha_presentacion_inicio"], "");
        $table .= get_td($row["fecha_presentacion_termino"], "");
        $table .=  "</tr>"; 
        $flag ++; 
    }
    $table .="</table>";
    return $table; 
}
/********************************************************************************************************/
function list_resum_escenarios($array_escenario, $id_evento , $limit_text, $background='' , $horizontal = '0'){


    $list ='';
    foreach ($array_escenario as $row){

        $nombre = $row["nombre"];
        $descripcion = $row["descripcion_escenario"];
        $url_escenario = create_url_escenario_in_evento($row["id_escenario"] , $id_evento );         
        $url_sound_cloud  = "";     
        $dinamic_content = '';

        if ($row["url_sound_cloud"] !=  null  && strlen($row["url_sound_cloud"] ) > 10 ) {

            $url_sound_cloud  =    $row["url_sound_cloud"];
            $dinamic_content  .='
            <div class="audio-wrapper">
                <iframe class="margin-clear" src="https://w.soundcloud.com/player/?url='. $url_sound_cloud.' " height="166">
                </iframe>
            </div>';

        }else{

            $img =  create_icon_img($row , " ", " " ); 
            
            $dinamic_content  .='
            <div class="audio-wrapper">
                '. $img  .'
            </div>';    
        }

       
            $list .='
                                <div class="article">
                                    <div class="col-md-6">
                                        ' . $dinamic_content .' 
                                    </div>
                                    <div class="col-md-6">
                                        <header>
                                            <h2>
                                            <a  style="color:#1DB3BF !important;" href="'. $url_escenario .'">'.$nombre .'</a>
                                            </h2>
                                            <div class="post-info">
                                                <span class="post-date">
                                                    <i class="icon-calendar">
                                                    </i>
                                                    <span class="day">
                                                    '. $row["fecha_presentacion_inicio"].'
                                                    </span>
                                                    <span class="month"> 
                                                    al '. $row["fecha_presentacion_termino"] .'
                                                    </span>
                                                </span>
                                                    <span class="submitted">
                                                        <i class="icon-user-1">
                                                        </i> 
                                                        , Tipo  
                                                        <a  style="color:#1DB3BF !important;"  href="#">
                                                            '. $row["tipoescenario"] .'
                                                        </a>
                                                    </span>
                                                <span class="comments">
                                                    <i class="icon-chat">
                                                    </i> 
                                                    <a style="color:#1DB3BF !important;"  href="#">
                                                    '. $row["num_artistas"] .' Artistas
                                                    </a>
                                                </span>
                                            </div>
                                        </header>
                                        <div class="">
                                            <p>'.substr( $descripcion , 0 , $limit_text )  .'</p>
                                        </div>
                                    </div>
                                </div>';    

        

    }
    
    return $list;

}


 
/*TEMPLATE EN CUANTO REGISTRE UN EVENTO*/
function get_default_template_escenario(){
    
    $list_template ="<li>                                          
                <div class='avatar'>
                    <img src=". base_url('application/img/blue.png'). " >
                        </div>
                            <div class='activity-desk'>                                            
                                <h5><a data-toggle='modal' data-target='#modalesenarios' href='#modalesenarios'>Escenario principal </a> 
                                    <br><span>La experiencia que se vivirá aquí será única ...</span></h5>
                                        <p class='text-muted'>Artistas incluidos # 10</p>
                            </div>
            </li>                                                                              
            ";
            return $list_template;
}


function list_escenarios_on_loadevent($responsedbescenario){

    /*
	$list = "<ul class='activity-list'>";

        foreach ($responsedbescenario as $row) {        

            $idescenariovalidation  = $row["idescenario"];
            $tipoescenario =  $row["tipoescenario"];
            $numero_artistas = 0;
            $numero_artistas =  $row["numero_artistas"];            
            $fecha_escenario = $row["fecha_presentacion_inicio"] ."-".$row["fecha_presentacion_termino"];
            $url_escenario = base_url('index.php/escenario/configuracionavanzada/'.$row["idescenario"]);            

            $p_letra =  substr($row["nombre"], 0, 1);


            $img =  create_icon_img($row , " " ,  ""  );           
            
            $list .=" 
                        <li>                                          
                            <a href='". $url_escenario ."'>      
                                <div class='col-lg-2  col-md-2 col-sm-2 '>                            
                                    <div>
                                    ".$img ."
                                    </div>                            
                                </div>
                                <div class='col-lg-10  col-md-10 col-sm-10 '>                            
                                    <h5>
                                        ". $row["nombre"] ."
                                    </h5>                                                                            
                                </div>
                                <div class='col-lg-12  col-md-12 col-sm-12 pull-right'>
                                    <span class='text-muted text-center'>
                                        Artistas #".$numero_artistas." | ".$tipoescenario." | ".$fecha_escenario." 
                                    </span>  
                            </a>                              
                                <i data-toggle='modal' data-target='#confirmationdeleteescenario' class='fa fa-times deleteescenario' id='". $row["idescenario"] ."' >
                                </i>
                            </div>

                        </li> 
                    ";
    }        
    
	$list .="</ul>";
    $data["info"] = $list;
    $data["numero_escenarios"] = count($responsedbescenario);
	return $data;
	*/
}
    




        

/*****************+****************+****************+****************+****************+*/

    function infoescenario($arrayinfo){


        $e ="";

        
        $nombreescenario ="";
        $tipoescenario = $arrayinfo["general"][0]["tipoescenario"];
        $nombreescenario =  $arrayinfo["general"][0]["nombre"];
        $descripcion = $arrayinfo["general"][0]['descripcion']; 
        



                                



            $listartistas ="";
            foreach ($arrayinfo["artistas"] as $xrow) {
                

                $idartista = $xrow["idartista"];
                $horainicioterminoartista = $xrow["hora_inicio"] . " - " . $xrow["hora_termino"];

                $listartistas .= "<li class='clearfix'>
                                    <span class='drag-marker'>
                                    <i></i>
                                    </span>
                                    <div class='todo-check pull-left'>
                                        <i data-toggle='modal' data-target='#horarioartista' class='fa fa-clock-o horario_artista' id='".$idartista."'></i>
                                    </div>
                                    <p class='todo-title'>
                                        ". $xrow["nombre_artista"] ."   , ". $horainicioterminoartista."
                                    </p>
                                    <div class='todo-actionlist pull-right clearfix'>

                                        <a href='#' ><i class='fa fa-times todo-remove remove-artista' id='".$idartista."' ></i></a>
                                    </div>
                                </li>
                            ";
    
            }

            





        $data[0] = $e;


        if (strlen($descripcion)<1 ) {
            $descripcion =  "+ agregar descripción";
        }


        $iniciotermino =  $arrayinfo["general"][0]["fecha_presentacion_inicio"] . "-" .  $arrayinfo["general"][0]["fecha_presentacion_termino"];
        
        $data['descripcion'] =   validate_text($descripcion); 
        $data['artistas'] =  $listartistas;
        $data['tipoescenario'] =  $tipoescenario;
        $data['nombreescenariomodal'] = $nombreescenario;
        $data['iniciotermino'] = $iniciotermino;


        return $data;

    }

/*****************+******_es**********+****************+****************+****************+*/
/*generos musicales del evento */
function get_generos($data){
$generos = '';

    foreach ($data as $row){
                $idgenero_musical = $row["idgenero_musical"];
                $nombre   =    $row["nombre"];
                $status = $row["status"];
                $descripcion = $row["descripcion"];
                        
                $generos .= '<div class="tag">
                                <a href="#">'.$nombre.'</a>
                            </div>';
                        
                    }                                        
 return $generos;                               
}
/**/
/*
function get_slider_img($imgs ,  $param ){    

        $imgs_escenario =""; $class_extra =""; $flags =""; $flag =1;  $edicion ="";
        $a = 0; 
        if ($param["in_session"] == 0 ) {
            $edicion = '            
                <div class="section-nombre-evento-in">
                    <div class="input-group">                    
                        <span class="input-group-addon">                                                
                            Escenario
                        </span>
                        <input  class="form-control in-nombre-escenario input-sm" id="in-nombre-escenario" value="'. $param['nombre_escenario'] .'" name="nuevo_nombre" type="text"  placeholder="Escenario ">                      
                        <input type="hidden" name="action" value="carga-imgenes-escenario">                    
                    </div>                    
                </div>
                <div class="place_nombre_escenario">
                </div>            
            ';                
        }
        $imgs_escenario .= '<div class="item active">
                                <div class="portada_principal">                                    
                                    <span class="titulo_evento_slider nombre-escenario-text "  title="Actualizar nombre del escenario"  >
                                            '. show_text_input($param['nombre_escenario'], 4 , " Escenario " ).' 
                                    </span>                                           
                                    '. $edicion .'
                                </div>                                
                            </div>';

        
        $flags .= '<li data-target="#myCarousel" data-slide-to="0" class="active">
                        <a href="#">                            
                            <small>
                            La experiencia 
                            </small>
                        </a>
                    </li>
                    ';                  

                        

        foreach($imgs as $row){

            $img =  create_icon_img($row , " "  , " " ); 
            $a  ++; 
            $imgs_escenario .= '<div class="item ">
                                    <div class="portada_principal">    
                                    '. $img .'
                                    </div>                                    
                                    <div class="carousel-caption">
                                        <h3>
                                        '.$param["nombre_escenario"].'
                                        </h3>                                    
                                    </div>
                                </div>';

            $flags .= '<li data-target="#myCarousel" data-slide-to="'.$flag.'" >
                            <a href="#">
                            '.$a .'                            
                            </a>
                        </li>
                        ';                  
            $flag ++;                       
        }

        $slider = '
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">        
                        <div class="carousel-inner">           
                          '.$imgs_escenario.'  
                        </div>        
                        <div class="pagination_enid">
                            <ul class="nav nav-pills nav-justified">
                                '. $flags .'
                            </ul>
                        </div>
                    </div>
                    <div class="separate-enid">
                    </div>
    ';




        return $slider;
}
*/

/**/
/*
function escenarios_in_evento($data , $id_escenario ){   
    
    

    $dinamic_class=""; 
    if(count($data) == 3){
        $dinamic_class="otros_escenarios2";
    }else if(count($data) > 3 ){
        $dinamic_class="otros_escenarios3";
    }

    $escenarios_section =  "<div class='$dinamic_class'>";      
    foreach ($data as $row) {

        $url = base_url('index.php/escenario/configuracionavanzada') ."/". $row["idescenario"];        
        $nombre = $row["nombre"];         
        $tipoescenario =  $row["tipoescenario"];        
        $fecha_escenario =  fechas_enid_format($row["fecha_presentacion_inicio"]  , $row["fecha_presentacion_termino"] ); 
        $img =  create_icon_img($row , " img_sm_enid ", " "); 

        $descripcion ="La experiencia en este escenario aún no ha sido asignada , <span class='config_now_escenario'> configurar ahora </span> "; 
        if (strlen( $row["descripcion"]) > 5) {
            $descripcion =  substr( $row["descripcion"] , 0 , 250 );     
        }
        
            

        $footer_escenarios =  '<span class="footer_escenarios ">
                                '.$fecha_escenario.'|
                                '. $tipoescenario .'
                                </span>
                            ';

       
            $escenarios_section .= '
                        
<div class="section_e">
    <div class="contenido_escenario">       
      <a href="'.$url.'" >
          <div class="col-lg-6 col-md-6 col-sm-12" >                               
          '. $img .'                               
          </div>
          <div>
              <span class="col-lg-6 col-md-6 col-sm-12 text-center nombre_escenario_otros">                                                                        
              '. $nombre .'                                    
                  <br>
              '.$footer_escenarios.'
              </span>
          </div>    
      </a>    
      <div class="row">
          <div class="seccion_descripcion">
              <p class="p-escenario-enid col-lg-12 col-md-12 col-sm-12">
                  <span class="experiencia_esc">
                  La experiencia
                  </span>
                    <br>
                  '.$descripcion.'
              </p>
          </div>
      </div>
    </div>  
</div>
<br>
<hr>                            
';
                
     
    }

    
    $escenarios_section .=  "</div>";
    return $escenarios_section;

}
*/
/**/
function contruye_info_escenario_cliente($nota ){
    $nota_recorte =  substr($nota, 0, 110 ); 
    $mas_info =  "";
    if (strlen($nota) > 110) {
        $mas_info =  '
                    <span class="pull-right">
                        + info
                    </span>
                    ';
    }  

    $seccion_nota  = '<div class="info_artista">          
                        Del artista              
                        <span >
                            '. $nota_recorte .' 
                        </span>                        
                            '.$mas_info.'                              
                       <!-- <span>
                            '.$nota .'
                        </span>                        -->
                    </div>';                 

    return $seccion_nota;                
}
/**/



function form_artista($public , $id_escenario  ){ 
    
    $form =  ""; 
    if ($public == 0) {
        $form .='                                                                  
                
        ';
    }
    return $form; 
}

/**/
function tag_tipo_artista($public , $id_artista ,  $tipo  ){

    $d_class = ' registrado '; 
    if (strlen($tipo) == "Ninguno") {
        $d_class = 'sin_registro';     
    }
    $tipo =  "<span class='tipo_artista_tag'> Artista ". $tipo ."</span>"; 
    if ($public ==  0 ) {
        $m_tipo = ' title="participación del artista" href="" data-toggle="modal" data-target="#modal_tipo_artista"  ';
        $tipo ='
            <a "'. $m_tipo .'">
                <i class="fa fa-star tipo_artista icon_config '.$d_class.' " id="'.$id_artista.'">
                </i>
            </a> 
        ';        
    }
    return $tipo; 
}
/**/
function show_configs_resumen_escenario( $id_escenario , $show_edit=0){
    $config = ''; 
    $url_config = create_url_config_escenario($id_escenario); 
    if($show_edit == 1){                                                    
        $config = '<a href="'.$url_config.'" class="more resum_evento pull-right">
                        <i class="fa fa-cog"></i> 
                    </a>'; 
    }        
    return $config;    
}
function msj_cliente_escenarios($lista , $in_session ){

    $msj =  ""; 
    if (count($lista) == 0 ){

        if ($in_session ==  1 ){

            $msj.= "
                    <center>
                        <div class='separate-enid'>
                        </div>
                        <span class='t_reporte msj_notificacion_config'>
                            No se han cargado escenarios ni artistas al evento aún
                        </span>
                    </center>    
                    ";    
        }else{
            $msj.= "<center> 
                        <span class='t_reporte'>
                            próximamente .! 
                        </span>
                    </center>";    
        }
        
    }
    return $msj;
}
/**/
function resumen_experiencia($descripcion){

    $resumen =  substr($descripcion, 0 , 190) . " ... ";     
    $msj  = ""; 

    if (strlen($descripcion) > 5 ){
        
        $experiencia_completa =  "<div class='seccion_experiencia_completa'>                                    
                                    <span class='text_experiencia_completa'>
                                    ". $descripcion."
                                    </span>
                                  </div>
                                  ";


        $msj .= "<div class='bloque_descripcion'>";                          
        $msj .=  "<div class='seccion_experiencia' >";
        $msj .=  "<span class='text_experiencia'>";     
            $msj .= $resumen; 
        $msj .=  "</span>"; 
        $msj .=  "</div>";            
        $msj .=  $experiencia_completa; 
        $msj .= "</div>";

   }else{
        $msj .=  "<div class='seccion_experiencia' >";
        $msj .=  "<span class='text_experiencia sin_experiencia'>";     
            $msj .= "Experiencia aún no descrita "; 
        $msj .=  "</span>"; 
        $msj .=  "</div>";            
    }
    return $msj;
}
/*******************************************************************/
}/*Termina el helper*/