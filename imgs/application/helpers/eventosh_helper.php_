<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){
/**/
function create_imgs_galeria($arreglo_imgs){

    $contenedor =  "";
    $x = 1;     
    for ($z=0; $z <count($arreglo_imgs); $z++){ 		
		$info_img_actual =  $arreglo_imgs[$z];

			foreach($info_img_actual as $row){
				
				$url_img =  url_img_id($row["id_imagen"]);				
				$estilos =  'style="background-image: url('.$url_img.');  background-size: cover; background-repeat: no-repeat;" ';				
				
				$slide = "slide".$x;

				if($x == 1 ){
					$contenedor .= '<div class="item active '.$slide.' " 
									style="background-image: url('.$url_img.');background-size: cover; background-repeat: no-repeat;">
                					</div>';             	
				}else{
					
					$contenedor .='<div class="item '.$slide.' " style="background-image: url('.$url_img.'); background-size: cover; background-repeat: no-repeat;">
								  	</div>';

				}

				$x ++; 
			}     
				
		
	}	
	return $contenedor;
	
	

}
/**/
function create_indicadores($total_img){

		$selectores =  '<ol class="carousel-indicators">';
	

			for($a=0; $a < $total_img; $a++) { 
				
				if ($a ==  0 ) {
					$selectores.= '<li data-target="#carousel-example-generic" data-slide-to="'.$a.'" class="active">
								  </li>';
				}else{
					$selectores .=  '<li data-target="#carousel-example-generic" data-slide-to="'.$a.'">
									 </li>';	
				}				
			}
			$selectores .=  '</ol>';
			return $selectores;
}

/**/
function flechas_preview($total_img){
	$def ="";
	if ($total_img> 0) {
		$def= '<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <i class="fa fa-angle-left">
            </i>
            <span class="sr-only">
            Anterior
          </span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <i class="fa fa-angle-right">
            </i>
            <span class="sr-only">Siguiente 
            </span>
        </a>';
    	
	}
	return $def;
}
/**/
function select_tipo_eventos($name ,  $class , $id ){
    $tipos = array(
              "Festival",
              "Club",
              "Antro",
              "Disco",
              "Open",
              "Showcase",
              "Expo",
              "70´s",
              "80´s",
              "90´s"
    );    

    $select =  "<select name='".$name."' class='".$class ."' id='". $id ."'> ";   
    $x = 0;       
    for ($x=0; $x <count($tipos); $x++) { 
      $select .= "<option value='". $tipos[$x]."'>". $tipos[$x]."</option>";
    }
    $select .=  "</select>";
    return $select; 
  }
/**/
	

	/**/
	function create_resumen_desc($text , $num  ,  $link){

		if (strlen($text) > $num ){
			return substr($text , 0 , 350 ) 
					. "<br> 
						<a href='".$link ."'> 
							+ info 
					   </a>";
		}else{
			return $text;
		}
	}
	
	/**/
	function show_status_asistencia($num_asistencia){

		if ($num_asistencia > 0 ){
			return  "<center><i class='fa fa-times'></i> <span clas='title-asistencia'> Has mencionado que ya no asistirás al evento</span></center>";	
		}else{			
			return  "<center> <i class='fa fa-check'> </i> <span clas='title-asistencia' >Asístirás al evento</span></center>";		
		}
	}
	/**/
	function valida_resum_edicion($edicion){
		$new_edicion =  ""; 
		if ( trim(strlen($edicion)) > 0) {
			$new_edicion = $edicion .'|';	
		}
		return $new_edicion;
		
	}
	/**/	
	
/**/
  function slider_item($imgs , $param){
  	
    $item = '<div class="carousel-inner">';
      $x =0;
      foreach ($imgs as $row) {

        $flag_indicator =  "";
        $slider_num =  "slide-".$x;
        if ($x == 0 ) {
          $flag_indicator =  "active";     
        }
        
        $id_imagen =  $row["id_imagen"];
        $msj_extra =  "";                        
        $text_slogan =  create_text_slogan($param["slogan"], $param["in_session"], $param["id_evento"]);  
        if ($param["public"] == 1 ) {
          $msj_extra = '              
              <h3>
               	'.$text_slogan .'
              </h3>                                          
            ';
        }          
        $item .=  '<div class="item slides '.$flag_indicator.' ">';       
        $imagen = create_img_url_sl($id_imagen);
        $item .="<div class='imagen-slider-enid'> 
        			".$imagen."
        		 </div>";
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
  function slider_ol($num_imgs){

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
function construye_resumen_eventos_e($data_eventos , $limit_text= 270 ,  $show_edit=0 , $show_delete = 0 , $show_view_like_public = 0 ){
	if ($data_eventos["num_eventos"]>0 ) {		
		return "ok";
	}else{
		return "<center><span class=''>No has publicado eventos durante los últimos 30 días</span></center>";
	}
}
/**/
function display_objs_pemitidos($objs){
    

    $total = 0;  
    $list_templa_contenido='';
    $class_enid = '';
    if (count($objs)> 5) {
        $class_enid = 'scroll-vertical-enid scroll-enid-public';
    }
    if (count($objs) > 0){    

    $list_templa_contenido='<div class=" '.$class_enid.' ">
                            <div >
                            <ul class="activity-list">';
    $flag = 1;                                       

    foreach ($objs as $row) {
       

       		$total ++; 
      		$idobjetopermitido = $row["idobjetopermitido"];
			$nombre = $row["nombre"];
			$descripcion = $row["descripcion"];
			$status = $row["status"];				  
        	$list_templa_contenido.= '
						        	<li>
						                <div class="avatar">
						                 '.$flag .'.- 
						                </div>
						                <div class="activity-desk">
						                    <h5>
						                        <a href="#">
						                        '. $nombre .'
						                        </a>                                                 
						                    </h5>
						                    <p class="text-muted">
						                	'.$descripcion.'
						                    </p>
						                </div>
						            </li>
			';
                       
        
                                $flag++;
    }
    $list_templa_contenido .= '</ul>
                            </div> 
                        </div>
                    ' ;                   
    }
    
    $total_resumen =  ""; 
    $total_resumen .=  $list_templa_contenido;
    return  $total_resumen; 

}
/**/	
function objs_pemitidos($objs , $in_session ,  $id_evento){
	$list_objs  =  ""; 
	$num_elementos = count($objs); 
	$href =  url_evento_view_config($id_evento). "/objs/#portlet_tab2";


	$editable = agregar_btn($in_session  , $href );
	if ($num_elementos > 0 ) {		
		$list_objs =  display_objs_pemitidos($objs);
	}else{
		$list_objs = tmp_objs_permitidos( $in_session ,  $id_evento);
	}
	return $list_objs;
}
/**/
function tmp_objs_permitidos( $in_session ,  $id_evento){
		
	if ($in_session ==  1  ) {
		$href =  url_evento_view_config($id_evento) . "/objs/#portlet_tab2";

		$editable = agregar_btn($in_session  , $href );
		return $editable; 			
	}else{
		return "<span class='msj_proximamente_objs'>Próximamente.!</span>";
	}		
	
}
/**/
function validacion_objs_permitidos($descripcion ,  $in_session ,  $id_evento , $t1 , $t2  , $tramo_url = ''  ){    
   

    $url_config  =  url_evento_view_config($id_evento)."/".$tramo_url;
    



    if(strlen(trim($descripcion)) > 10 ){ 
      return   n_row_12() 
      			.
	      			"<span class='btn-text-msj-user ".$t1." '>
			      			". editar_btn($in_session , $url_config ) ."
			      	</span> 
			      	<span class='text-msj-user ".$t2."  '>
			      		   	" .$descripcion . "
			      	</span> 	      		
	      		   "
	      		.
      		   end_row(); 
    }else{      
        if($in_session){            
            return 	n_row_12() 
            		.
	            		"<span class='btn-text-msj-user ".$t1."   '>
				      				". editar_btn($in_session , $url_config ) ."
				      		  </span> 	      		   
			            <span class='text-msj-user  msj_user_text_servicios msj_notificacion_config ".$t2."   '> 
			            			Has una especificación para el público
			            </span>	            		
	            		"
            		. 
            		end_row();    
        }else{
          return " "; 
        }       
    }
}  
/**/
function load_complete_genero($data){
	    $table = "";
	    $table .= '<table class="table table-bordered">
	    	<tr class="text-center enid-header-table">';
	    $table .= get_td("#" , "");  
	    $table .= get_td("Genero musical" , "");	   
	    
	    $table .= '</tr>';            
	    $flag =  1;
	    foreach ($data as $row) {

	        $table .=  "<tr>"; 
	        $table .= get_td($flag , "");
	        $table .= get_td($row["nombre"], "");
	        
	        $table .=  "</tr>"; 
	        $flag ++; 
	    }
	    return $table; 
}
/**/
function proximos_eventos($data){

	$proximos_eventos =  "";  
	foreach ($data as $row){		
		$id_evento		=  $row["idevento"];
		$nombre_evento	=  $row["nombre_evento"];
		$fecha_inicio =  $row["fecha_inicio"];	
		$url = create_url_evento_view($id_evento);
		$proximos_eventos .=  "<a href='". $url ."'><button style='background:#093245; color:white;' class='btn btn-default'>". $nombre_evento ."</button></a>";
	}
	return $proximos_eventos;
}

/**/
function listobjetosp( $arreglo ,  $id_evento ){ 	
	
	$height =  ""; 			
	if (count($arreglo) > 10 ){ $height ="style='overflow-y:scroll;  height: 300px;' "; }
	$btn =  "<i class='fa fa-check-square   btn-all-articulos'>
			</i>
		    ";


	$list ="<div $height >
			<table class='table_enid_service' border=1>
				<tr class='table_enid_service_header' >";
				$list .= get_td("#"); 
				$list .= get_td("Objeto permitido"); 
				$list .= get_td("Seleccionar " . $btn ); 
	$list .= "</tr>";
	$b =1;



	foreach ( $arreglo as $row) {	

		$idobjetopermitido = $row["idobjetopermitido"];
		$nombre = $row["nombre"];
		$descripcion = $row["descripcion"];
		$idevento = $row["idevento"];		

		if ($idevento != null  ) {
			$input ="<input type='checkbox' class='objpermitido' id='". $idobjetopermitido ."' checked >";	
		}else{
			$input ="<input type='checkbox' class='objpermitido' id='".$idobjetopermitido ."' >";
		}		
		
		$list .=  "<tr>";
			$list .= get_td($b); 
			$list .= get_td($nombre); 
			$list .= get_td($input); 
		$list .= "<tr>";
		$b++;
	}
	$list .= "</table>
		</div>";
	return $list;

}

/**/
function get_date_event_format($inicio , $termino){

	$date="";
	if ($inicio == $termino) {
		$date = $inicio;		
	}else{
		$date = $inicio ." al " . $termino;
	}
	return $date;
}
/*Últimos eventos */
function get_last_events_empresa($ultimos_eventos, $limit_text= 270 ,  $show_edit=0 , $show_delete = 0 ,
 $show_view_like_public = 0 , $show_emp = 0){	

		$elements ="<div>";		
		if ($ultimos_eventos["num_eventos"] == 0  ) {

			if ($show_edit ==  1) {
				$elements.= "<center>
								<span class='msj_notificacion_config'>
									No has publicado eventos durante los últimos 30 días
								</span>
							</center>";	
			}	
			
		}else{
				foreach ($ultimos_eventos["eventos"] as $row){
					$id_evento = $row["idevento"];					
					$url_edith =  url_evento_view_config($row["idevento"]);
					$url_next =  create_url_evento_view($id_evento); 			
					

					$nombre_evento = $row["nombre_evento"]; 
					$descripcion_evento =  substr($row["descripcion_evento"] ,  0 ,  250);
					$view_like= "";
					$estado_event =  "";
					$delete_event  =  ""; 	
					$fecha_inicio =  $row["fecha_inicio"];
					$fecha_termino = $row["fecha_termino"];
					$fecha_evento =  fechas_enid_format($fecha_inicio , $fecha_termino );  
					$eslogan =  $row["eslogan"];
					$edicion =  $row["edicion"]; 
					$escenarios  =  $row["escenarios"];
					$artistas =  $row["artistas"];			
					$evento_punto_venta =  $row["evento_punto_venta"];
					$accesos =  $row["accesos"];
					$dinamic_section = "dinamic_section".$id_evento;
					$config =""; 
					$url_maps=  url_tmp_maps() ."/". $id_evento."/0/";

					$reservacion_tel =  $row["reservacion_tel"];
					$reservacion_mail =  $row["reservacion_mail"]; 

					$resumen_section  = resumen_evento($show_edit , $escenarios , $id_evento , $artistas , $evento_punto_venta , $accesos  ,  $reservacion_tel ,  $reservacion_mail  ); 

					$btn_config ='';  


			$text_public =  ""; 
			if ($show_emp ==  1){

				$id_empresa =  $row["idempresa"];
				$url_empresa = url_la_historia($id_empresa);				
				$nombreempresa =  $row["nombreempresa"];	
				$text_public =  "<a href='". $url_empresa ."' class='btn-empresa-link'> By " .$nombreempresa ."</a>";
			}
			


			$btn_social_fb =  n_row_12()
								.' 
								<div class="fb-share-button" data-href="'.$url_next.'" data-layout="button" data-size="small" data-mobile-iframe="true">
									<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fenidservice.com%2Fhome%2F&amp;src=sdkpreparse">
										Compartir
									</a>
								</div>
								'.end_row(); 

			if($show_edit == 1){									
					$btn_config = '
					<a title = "Configura el evento " href="'.$url_edith.'" class="more resum_evento pull-right">
                        <i class="fa fa-cog"></i> 
                    </a>'; 
                    $btn_social_fb  = '';


			}


			$url_imagen_evento =  create_url_img_evento($id_evento);			
			$url_teplate =base_url('application/img/img_def.png');
			//$action_error = "onerror='this.src=$url_teplate ' ";

          	$part_imgs =  "<img  src='".$url_imagen_evento."'  onerror='this.src=$url_teplate'    width=100%; >";
			
			$elements .= '<div class="seccion_evento_enid"> 		
							'. n_row_12().'
			    	        	'.$btn_config.'
							'.end_row().'
            <div class="row">   

	            <div class="col-lg-5  col-md-5 col-sm-12">
			        <div class="blog-img-sm">
			            <a href="'.$url_next.'" >
						'.$part_imgs .'
			            <a>
			        </div>
			    </div>
			    <div class="col-lg-7 col-md-7 col-sm-12">
			    	<div class="seccion-r-eventos">
                		'. n_row_12().'    
		                        <a  href="'.$url_next.'">
		                           '.titulo_enid( $nombre_evento)   .'
		                        </a>
		                    
		                    '.$text_public .'
		                '.end_row().'    
	                   
		                
	                    '. n_row_12("contenedor-resum-event").'    
			                <span class="a_resum_event">
			                	'.valida_resum_edicion($edicion) .''.			                    
			                    $fecha_evento.'|
			                    
			                    <a href="'.$url_maps.'">
			                        <i class="fa fa-map-marker locacion" id="'.$id_evento.'" >
			                        </i>
			                    </a>
			                </span>                            
						'.end_row().'    

						'. n_row_12("contenedor-resum-event").'    
						 	'. $resumen_section   .'

						'.end_row().'    
	                   	

						'. n_row_12("contenedor-resum-event").'    
	                    	<span class="text-resumen-evento">	                    	
		                    	'. $descripcion_evento .'
		                    </span>
		                '.end_row().'    

	                   	'. n_row_12("contenedor-resum-event").'    
	                   		'.$btn_social_fb.'		
	                   	'.end_row().'    



	                    
		        	</div>               
		        </div>       
                                
            </div>

            <div class="'.$dinamic_section.'" >
            </div>
            </div>
            <hr>
        ';                            

        }      



		}
        
        $elements .=  "</div>";                      
		return $elements;                                    	
	}

function resumen_evento($public , $escenarios ,$id_evento  , $artistas , $evento_punto_venta , $accesos ,  $reservacion_tel  ,  $reservacion_mail ){


	$href_evento  =""; 
	$href_pv = ""; 
	if ($public ==  0 ) {
		$url_evento =  create_url_evento_view($id_evento);
		$href_evento =  "href= '". $url_evento ."' ";
		$url_puntos_venta = url_accesos_al_evento($id_evento);
		$href_pv =  "href= '". $url_puntos_venta ."' ";
	}
	

	$resumen_section = '							
        <a '.$href_evento.'  class="resum_evento escenarios_evento  " id="'. $id_evento .'"   >
        #'.$escenarios.' Escenarios
        </a>
        <a '.$href_evento.' class="resum_evento escenarios_artistas_principal " id="'. $id_evento .'"  >#'.$artistas .' artistas
        </a>
        
        <a '.$href_pv .' class="resum_evento acceso_evento  " id="'. $id_evento .'"  ># '.$accesos .'Promociones
        </a>
        

	';
	
	return $resumen_section; 
}
/*****************************************************************************************/
/*RETORNA LA PLANTILLA EN CASO DE QUE EL CLIENTE AÚN NO HAYA REGISTRADO EVENTOS */
	function default_template_eventos(){
					$elements = "
								<div class='panel' title='Ejemplo' >
                                    <div class='panel-body ' style='' >
                                        <div class='media blog-cmnt'>
                                                <a href='javascript:;' class='pull-left'>
                                                    <img alt='' src='". base_url('application/img/example.jpg') ."' class='media-object'>
                                                </a>
                                                <div class='media-body'>
                                                    <h4 class='media-heading' >
                                                        <a  href='#'>Fantastic event (ejemplo)</a>
                                                    </h4>
                                                    <p class='mp-less'>
                                                        Celebrando un exitoso año y cumpliendo ya 15 años haciendo historia de la música electrónica en México, nos enorgullecemos en presentar nuestra tercera edición del Festival I love this generation ...
                                                    </p>
                                                   <i class='fa fa-calendar-o'></i> 07/02/2015 - 07/04/2015 
                                                </div>
                                            </div>
                                        </div>
                                    </div>";
		return $elements;

}	

/**/
function get_slider_img_evento($data){

	$slider = '<div class="carousel-inner">'; 
	$flag = 0; 
	$class =''; 



	if (count($data) ==  0 ){

			
			$slider .=  '
	            <div class="item  active ">
	                <div class="row">
	                    <div class="col-xs-6 col-sm-5 col-md-5">
	                        <a href=""> 
	                         <img src="" class="thumbnail">
	                        </a>
	                    </div>
	                    <div class="col-xs-6 col-sm-7 col-md-7">
	                        Registra images al evento.!
	                    </div>
	                </div>                    
	            </div>
	            ';
	}		
    foreach ($data as $row) {    		
	   	$img =  create_icon_img($row , 'thumbnail' , ' ' );  	
	   	if ($flag == 0 ) {
	   		$class= ' active ';
	   		$flag++;
	   	}else{
	   		$class= '';
	   	}
	   	$slider .=  '
	            <div class="item  '. $class .' ">
	                <div class="row">
	                    <div class="col-xs-6 col-sm-5 col-md-5">
	                        <a href=""> 
	                          '. $img .'
	                        </a>
	                    </div>
	                    <div class="col-xs-6 col-sm-7 col-md-7">
	                              Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh
	                              euismod tincidunt ut laoreet..
	                    </div>
	                </div>                    
	            </div>
	            ';
	}

	    $slider .= '</div>';     
    return $slider;
}


	
	/***********************************************************************************/
	function get_slider_principal_evento($imgs , $data_evento){
		$imgs_evento ="";
		$class_extra ="";
		$flags ="";
		$flag =1; 
		$imgs_evento .= '<div class="item active">

								<div style="height:750px;">
									<center>
							            <label style="font-size:4em;" class="text-center">
							                	'. $data_evento["nombre_evento"]  .'
							            </label>				                
						            </center>
					            </div>
				                <div class="carousel-caption">
				                    <h3>
				                   	'. $data_evento["eslogan"] .'
				                    </h3>				                   
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
			
			$imgs_evento .= '<div class="item ">
				                '. $img .'
				                <div class="carousel-caption">
				                    <h3>
				                        Headline</h3>
				                    <p>
				                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod
				                        tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. Lorem
				                        ipsum dolor sit amet, consetetur sadipscing elitr.</p>
				                </div>
				            </div>';

			$flags .= '<li data-target="#myCarousel" data-slide-to="'.$flag.'" class="">
		                <a href="#">
		                    About
		                    <small>
		                    Lorem ipsum dolor sit
		                    </small>
		                </a>
		            </li>
           			'; 		            


			$flag ++;			            
		}

		$slider["imagenes"] =  $imgs_evento; 
		$slider["flags"] =  $flags;
		return $slider;
	}
	/**/
	function create_text_slogan( $slogan , $in_session ,  $id_evento ){

		$msj = ''; 
		$seccion = ''; 
		if ($in_session ==1  ) {						
			$msj =  "
					No has registrado un slogan para el evento. 
					"; 
			if ( strlen(trim($slogan))> 0) { $seccion =  seccion_slogan($slogan , $in_session ,  $id_evento   );}else{$seccion =  seccion_slogan($msj , $in_session ,  $id_evento );}		
		}else{			
			if (strlen(trim($slogan)) > 0 ) {$seccion =  seccion_slogan($slogan , $in_session ,  $id_evento  );	}
		}
		return $seccion; 
	}
	/**/
	function seccion_slogan($msj , $in_session,  $id_evento  ){

		$url = url_evento_view_config($id_evento).'/eslogan';
		$btn =  editar_btn($in_session , $url ); 
		$seccion = '<span>
						<small class="slogan">                   
						'.$msj.'
						</small>'.$btn.'
					</span>';
		return $seccion; 
	}
	/**/

	function create_text_descripcion($descripcion ,  $in_session   , $id_evento ){		

		$text =  c_seccion_descripcion($descripcion , $in_session  , $id_evento ); 

		$url =  url_evento_view_config($id_evento)."/#portlet_tab4";		
		$btn =  editar_btn($in_session , $url );
		$seccion = "					
						<div class='btn-config-enid-desc'>" . $btn . "</div>
						<div class='descripcion_seccion seccion-config-enid-desc'>
							". $text  ."			            
						</div>					
					";   
		return $seccion;
	}
	/**/
	function c_seccion_descripcion($descripcion , $in_session , $id_evento){		
		$text =  trim($descripcion); 
		$new_text =  $descripcion; 
		if ($in_session == 1 ){
			if (strlen($descripcion) < 5 ){ $new_text =  '
					<span class="msj_notificacion_config" > 
						Cargar la experiencia
					</span>'; 		
														}
		}else{
			if (strlen($descripcion) < 5){$new_text = 'Próximamente lo que vivirás  al asistir al evento.'; }
		}				
		if (strlen($text) > 800 ){			
			$primer_part = "<span class='hiddden_descripcion'>  "  .  $text . "</span>";
			$part_descripcion =  substr($text, 0 ,  799);  
			$new_text = $primer_part . "<span class='show_descripcion' >". $part_descripcion ."</span>

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
	function create_text_edicion($edicion ,  $in_session , $id_evento){

		$text =  ""; $new_text =  "";
		$url =  url_evento_view_config($id_evento);		
		$btn =  editar_btn($in_session , $url );

		if ($in_session == 1 ) {
			$new_text =  $edicion; 
			if(strlen($edicion) == 0 ){
				$new_text =  "<span class='msj_notificacion_config'> 
								Registra la edición del evento 
							  </span>";				
			}
		}else{
			if (strlen($edicion) > 0 ) {
				$new_text =  $edicion;
			}
		}
		return  "<div class='btn-config-edicion-desc-l'>" . $btn ."</div>".$new_text; 
	}
	/**/
	function construye_resumen_artista($data , $in_session){

		$num_agregados =  count($data); 
		
		$elements = "<h1 class='link_next_accesos'>
						Algunos artistas del evento 						
					</h1>"; 
		
		if ($in_session ==  1 ){			
			if ($num_agregados < 1 ){

				$elements .=  "<ul class='items'>
					                <li>
					                	No has cargado artistas al evento                        
					                </li>                   
					          </ul> "; 		

			}else{
				
				$elements .=  construye_resumen_artistas_data($data); 
			}	
		}else{
			/*Cuendo no está en sessión */
			if ($num_agregados < 1 ) {
				$elements =  ""; 		
			}else{
				$elements .=  construye_resumen_artistas_data($data); 
			}	
		}	
		return $elements; 
	}
	/**/
	function construye_resumen_artistas_data($data){

		$elements =  "<ul class='items'>";
		foreach ($data as $row){
			$elements .=  "
							<li>
								". $row["artista"] ."
							</li>
							";						
		}
			$elements .=  "
							<li>
							 .......
							</li>
							";						

		$elements .=  "</ul>";
		return $elements; 
	}
	/**/
	function construye_resumen_politicas_restricciones($politica , $restriccion , $in_session ){

		$element = ""; 
		$num_politica =  strlen($politica); 
		$num_restriccion =  strlen($restriccion); 
		$flag = 0; 
		$flag_b = 0; 
		if ($num_politica > 5 ){
			$flag = 1; 			
		}if ($num_restriccion > 5 ){
			$flag_b = 1; 			
		}	
		return evalua_politica_descripcion( $flag , $flag_b , $in_session , $politica , $restriccion ); 

	}
	/**/
	function evalua_politica_descripcion( $flag , $flag_b,  $in_session , $politica , $restriccion ){

		$element =  ""; 

		if($flag ==  0  && $flag_b ==  $flag ) {
			/* Cuando no hay nada de texto  */
			if ($in_session ==  1 ) {
				$element ='	
					<p class="disclosure">
						No has cargado ninguna política o descripción al evento. 
					</p>		
				';	
			}else{
				$element =  "";
			}
			return $element; 
		}
		/*break*/
		if ($flag == 1 ) {
			return '
					<p class="disclosure">
						'. $politica  .'
					</p>		
					';					
		}
		/**/
		if ($flag_b == 1 ) {
			return '
					<p class="disclosure">
						'. $restriccion .'
					</p>		
					';
		}	
	}
	/**/
	function contruye_ubicacion($ubicacion , $in_session ,  $id_evento ){
		/**/		
		$span =  ""; 
		$num_ubicacion =  strlen(trim($ubicacion)); 			
		if ($in_session ==  1 ){
			if ($num_ubicacion > 0 ){
				$span =  "<span class='text_ubicacion' >
							". $ubicacion ."
						  </span>";				
			}else{




				$btn = editar_btn($in_session, url_evento_view_config($id_evento).'/#mapaevento ' );
				$span = $btn. "<span class='text_ubicacion 	msj_notificacion_config' >
							No has registrado la locación del evento. 
						  </span>";				
			}		
		}else{
			if ($num_ubicacion > 0 ){
				$span =  "<span class='text_ubicacion' >
							". $ubicacion ."
						  </span>";				
			}else{
				$span =  "<span class='text_ubicacion' >
							Próximamente 
						  </span>";				
			}		
		}
		return $span; 
	}	   
	/**/	
	function estado_evento( $status , $in_session  ,  $id_evento , $dia = ''){
		$status_final =  ""; 

		if ($in_session == 1 ){
			$status_final = construye_status($status  , $id_evento , $dia);	
		}else{
			$status_final =  construye_status_client($status);
		}
		return $status_final; 
	}
	/**/
	function construye_status($status  , $id_evento  , $dia ){
		
		$status_final = ""; 
		switch ($status) {
			case 0:
				$status_final =  " En edición "; 
				break;
			case 1:
				$status_final =  " Actualmente disponible para el público "; 
				break;
			case 2:
				$status_final =  " El evento se encuentra actualmente cancelado"; 
				break;	
			case 4:
				$status_final =  " El evento se encuentra programado para ser público desde el día " . $dia ; 
						break;		
			default:				
				break;
		}

	

		$status_final_evento =  "
								<li class='pull-right info_estado config_estado_evento ' id='$id_evento' title='Este es el estado actual del evento, click para modificar'>
    								<a class='info_estado_a' >
    								". $status_final ."
    								</a>
    							</li>	
    							";

		return $status_final_evento; 
	}
	/**/
	function construye_status_client($status){
		$status_final =  "";
		if ($status ==  2){			
			/*Cargar que cuando */



			$status_final =  "	<li class='pull-right info_estado config_estado_evento ' id='$id_evento' title='Este es el estado actual del evento, click para modificar'>
    								<a class='info_estado_a' >
    									El evento ha sido cancelado. 
    								</a>
    							</li>	
    							"; 
		}
		return $status_final; 
	}
	/**/
	function construye_tipo_evento($tipo , $in_session , $id_evento ){
		/**/
		$tipo_evento = "";
		if ($in_session == 1){
			$tipo_evento =  "
				<li class='pull-right config_tipo_evento ' id='$id_evento' title='Tipo de evento, click para modificar'>
    				<a class='info_tipo_evento' >
    				". $tipo ."
    				</a>
    			</li>	
				";
		}
		return $tipo_evento;		
	}
	/**/

	/**/
	function muestra_estatus_event($status){

		$msj_extra =  "<br></br>
						<center>
						<button class='btn btn-default btn_save fijar_public' >
						Guardar como evento público ahora .!
					   </button>
					   </center>"; 
		if ($status == 1) {
			$msj_extra =  " Este ahora mismo es público para tus espectadores ";	
		}
		return $msj_extra; 
		
	}
	/**/
	/*
	function tipo_cancelacion($estado , $id_evento , $submotivos  , $f_cancelacion = '2016'  ){
			
		$url_form =  base_url("index.php/api/event/cancelacion/format/json/");		
		$status_final =  "El evento fue cancelado el día " . $f_cancelacion . " "; 

		
		$select =  "<select class='motivo_cancelacion form-control' name='motivo_cancelacion'>";

		foreach ($submotivos  as $row) {
			$id_motivo =  $row["id_motivo"];
			$descripcion =  $row["descripcion"];
			$select .=  "<option value='$id_motivo '>". $descripcion  ."</option>";
		}

		$select .=  "</select>";
		if ($estado !=  2) {
			$status_final = '	
				<form action="'.$url_form.'" id="form_cancelacion">
					<div>
						<div class="form-group">
						  '. $select .'
						  <label for="comment">
						  	Motivo de cancelación:
						  </label>
						  <textarea class="form-control nota_cancelacion" name="nota_cancelacion" rows="3" id="nota_cancelacion">
						  </textarea>
						  <button  class="btn  btn-default">
							Cancelar evento ahora
						  </button>
						</div>						
					</div>
				</form>
				';	
		}			
		return $status_final;
	}
	*/
	/**/
	function construye_select_estado_evento($estado_actual){

		$posibles  = array("Programar evento para que sea público en la fecha que indiques " , "Cambiar a evento público " , "Cancelar evento ");		
		$select =  "<select class='form-control input-sm select_estatus_evento' >"; 
		$b = 0; 
		for ($a=0; $a < count($posibles); $a++) { 

			if ($estado_actual !=  $a ){ 
				$select .=  "<option value='$a' >". $posibles[$a]."</option>";						
			}		
		}

		$select .=  "</select>"; 
		return $select;


	}
	/**/

/*
	function estado_evento_name($estado , $programado = '' ){
		$status_final = ""; 
		switch ($estado) {
			case 0:
				$status_final =  " en edición."; 
				break;
			case 1:
				$status_final =  " actualmente disponible para el público."; 
				break;
			case 2:
				$status_final =  " actualmente cancelado."; 
				break;		
			case 4:
				$status_final =  " programado para ser público desde el día "  . $programado ; 
				break;	
					
			default:				
				break;
		}
		return $status_final;
	}
	*/
	/*
function get_pagination_principal($limit_display){

	$anterior = "";
			switch ($limit_display) {
				case 3:
					$anterior = '<li class="active" title="Mostrar"><a href="'. base_url('index.php/inicio/eventos/') .'">3</a></li>
                    <li><a href="'. base_url('index.php/inicio/eventos/10') .'">10</a></li>
                    <li><a href="'. base_url('index.php/inicio/eventos/50').'">50</a></li>                    
                    <li><a href="'. base_url('index.php/inicio/eventos/1000').'">TODOS</a></li>';
					break;
				case 10:
					$anterior = '<li title="Mostrar" ><a href="'. base_url('index.php/inicio/eventos/') .'">ANTERIOR</a></li>
					<li><a href="'. base_url('index.php/inicio/eventos/') .'">3</a></li>
                    <li class="active"><a href="'. base_url('index.php/inicio/eventos/10') .'">10</a></li>
                    <li><a href="'. base_url('index.php/inicio/eventos/50').'">50</a></li>                    
                    <li><a href="'. base_url('index.php/inicio/eventos/1000').'">TODOS</a></li>';
					break;
				case 50:
					$anterior = '<li title="Mostrar"><a href="'. base_url('index.php/inicio/eventos/10') .'">ANTERIOR</a></li>
					<li ><a href="'. base_url('index.php/inicio/eventos/') .'">3</a></li>
                    <li><a href="'. base_url('index.php/inicio/eventos/10') .'">10</a></li>
                    <li class="active"><a href="'. base_url('index.php/inicio/eventos/50').'">50</a></li>                    
                    <li><a href="'. base_url('index.php/inicio/eventos/1000').'">TODOS</a></li>';
					break;

				break;
				case 1000:
					$anterior = '<li title="Mostrar" ><a href="'. base_url('index.php/inicio/eventos/50') .'">ANTERIOR</a></li>
					<li ><a href="'. base_url('index.php/inicio/eventos/') .'">3</a></li>
                    <li><a href="'. base_url('index.php/inicio/eventos/10') .'">10</a></li>
                    <li ><a href="'. base_url('index.php/inicio/eventos/50').'">50</a></li>                    
                    <li class="active"><a href="'. base_url('index.php/inicio/eventos/1000').'">TODOS</a></li>';
					break;
						

				default:
					$anterior = "";
					break;
			}


		$dinamic_pagination = '<div class="text-center">
                <ul class="pagination blog-pagination">                    
                	'. $anterior.'	
                </ul>

            </div>';
            return  $dinamic_pagination;

}
*/
/***********************************END PAGINATION ****************************/
/*
function get_experiencia_last_events_by_empresa($data_eventos){
$elements ="";


	foreach ($data_eventos as $row){
			
			$urlnext = base_url();
			$id_evento = $row["idevento"];			
			
			$estadoevento = get_statusevent($row["estadoevento"]);			 
			$elements .="<div class='panel'>
                                    <div class='panel-body ' style='' >

                                        <div class='media blog-cmnt'>
                                                
                                                <div class='media-body'>
                                                    <h4 class='media-heading' >
                                                        <a  href='$urlnext'> <label>".$row["nombre_evento"] ."</label>
                                                        ".  $row["edicion"] ." </a>

                                                    </h4>
                                                      <ul class='revenue-nav'>
				                                        <li><a href='#'>
				                                        <i class='fa fa-play'></i> Escenarios ". $row[""]."</a>
				                                        </li>		                                        		                                        
				                                    </ul>
                                                    
                                                </div>
                                            </div>
                                          

                                        </div>

                                    </div>";
        }                            
		return $elements;                                    	
}
*/	
}/*Termina el helper*/