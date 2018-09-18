<?php 
	
	$lista ='<div class="list-group">';
	$x =0;

	foreach($info_servicio as $row){
		

		$id_servicio =  $row["id_servicio"];
		$nombre_servicio =  $row["nombre_servicio"];					
		$x_active ="";
		$color ="";
		if ($x ==  1){
			$x_active ="active";		
			$color ="white";
		}
		$lista .=  '<a  						
						class="list-group-item 
						list-group-item-action 						
						align-items-start servicio '.$x_active.' "
						nombre_servicio="'.$nombre_servicio.'" 
						id="'.$id_servicio.'" 
						title="'.$nombre_servicio.'">						   
						<div class="d-flex w-100 justify-content-between " >
							<h5 class="mb-1 '.$color.'" >
							<i class="fa fa-check">
								</i>
							    '.$nombre_servicio.'						      
							</h5>
							<!--
							<div class="text-right">
								<i class="fa fa-check">
								</i>
								<small class="'.$color.'"  >				
								    Agregar
								</small>
							</div>-->
						</div>						  
						</a>';
						$x ++;
	}

	if ($x == 0 ) {


		$text_extra ="Ningún producto encontrado";
		if ($modalidad == 1 ){
			$text_extra ="Ningun servicio encontrado";				
		}
		$lista .='<a  	class="list-group-item 
						list-group-item-action 						
						align-items-start ">						   
						<div class="d-flex w-100 justify-content-between " >							
							<h5 class="mb-1 black">								
							    '.$text_extra.'
							</h5>							
							<div class="text-right">
								<a href="../planes_servicios/?q=1" style="color:white!important;">	
									<i class="fa fa-check">
									</i>								
									<small 
										class="blue_enid_background2 white"
										style="padding:5px;">	
												
									    	Agregar a la lista 
									    
									</small>
								</a>
							</div>
						</div>						  
						</a>';
	}

	$lista .='</div>';




?>
<div style="position: fixed;z-index: 2000;">
	<?=$lista?>
</div>