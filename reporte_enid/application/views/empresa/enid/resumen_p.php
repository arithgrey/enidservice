 <?php

 $list =  "";  
 foreach ($info_prospectos as $row) {
 	
 	$id_empresa =  $row["idempresa"];
 	$url_empresa =  url_la_historia($id_empresa); 
 	$nombreempresa =  $row["nombreempresa"];
 	$fecha_registro =  $row["fecha_registro"];
 	

 	$facebook =  $row["facebook"];
 	$tweeter =  $row["tweeter"];
 	$www =  $row["www"];

 	$reservacion_tel =  $row["reservacion_tel"];
 	$reservacion_mail = $row["reservacion_mail"];
 	$tramo_reservacion=  valida_reservaciones( 0 , $reservacion_tel  , $reservacion_mail , ""  ); 
 	$list .= '
 	<div class="row">         					        		      		                               
	    <div class="col-lg-5  col-md-5 col-sm-12">
	        <div class="blog-img-sm">
	            <a href="'.$url_empresa.'">
	                <img  style="display:block;margin:0 auto 0 auto; width: 100%;" src="'.base_url('application/img/img_def.png').'">
	                </a>                        
	         </div>                    
	     </div>
	     <div class="col-lg-7 col-md-7 col-sm-12">
	            <div class="row">
	            	<div class="col-lg-12 col-md-12 col-sm-12">
	            		<h1 class="nombre_evento_text">
	            			<a class="nombre_evento_a" href="'.$url_empresa.'">
			                    '.$nombreempresa.'
			                </a>
			            </h1>		                    
		            </div>	                    
		        </div>	
		       <div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">			                   								
		    			<a>Fecha regitro '.$fecha_registro .'</a>
		    			<a>'.$tramo_reservacion.'</a>
		    			<a></a>

					</div>
				</div>
		</div>
	</div>';


 }
 ?>
 <?=$list?>