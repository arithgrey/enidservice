 <?php

 $list =  "";  
 foreach ($info_prospectos as $row) {


 	$idevento =  $row["idevento"];
 	$fecha_inicio  = $row["fecha_inicio"];       
 	$fecha_termino = $row["fecha_termino"];       
 	$id_empresa =  $row["idempresa"];
 	$url_empresa =  url_la_historia($id_empresa);  	
 	$nombre_evento =  $row["nombre_evento"];
 	$fecha_registro =  $row["fecha_registro"]; 		
 	$reservacion_tel =  $row["reservacion_tel"];
 	$reservacion_mail = $row["reservacion_mail"];
 	$tramo_reservacion=  valida_reservaciones( 0 , $reservacion_tel  , $reservacion_mail , ""  ); 
 	$url_evento = create_url_evento_view($idevento);
 	$list .= '
 	<div class="row">         					        		      		                               
	    <div class="col-lg-5  col-md-5 col-sm-12">
	        <div class="blog-img-sm">
	            <a href="'.$url_empresa.'">
	                <img  style="display:block;margin:0 auto 0 auto; width: 100%;" src="'.base_url('application/img/img_update.png').'">
	                </a>                        
	         </div>                    
	     </div>
	     <div class="col-lg-7 col-md-7 col-sm-12">
	            <div class="row">
	            	<div class="col-lg-12 col-md-12 col-sm-12">
	            		<h1 class="nombre_evento_text">
	            			<a class="nombre_evento_a" href="'. $url_evento .'">
			                    '.$nombre_evento.'
			                </a>
			            </h1>		                    
		            </div>	                    
		        </div>	
		       <div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">			                   								
		    			<a>Fecha regitro '.$fecha_registro .'</a>
		    			<a>'.$tramo_reservacion.'</a>
		    			<a href="'.$url_empresa.'">Empresa</a>

					</div>
				</div>
		</div>
	</div>';


 }
 ?>
 <?=$list?>
