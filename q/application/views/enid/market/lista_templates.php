<?php
        $complete  ="";		
        $list_publicidad = "";			
        $secciones_publicidad =  "";  
		$height ="style='overflow-x: hidden;'"; 
		if (count($data_templates) >= 2 ){
			$height ="style='overflow-y:scroll;  overflow-x: hidden; height: 550px;' " ; 
		}
		$b =1;	

		foreach ($data_templates as $row){
			$list_publicidad .='<tr>';			
				
				$id_publicidad   =  $row["id_publicidad"];
				$nombre          =  $row["nombre"];
				$descripcion     =  $row["descripcion"];
				$fecha_registro  =  $row["fecha_registro"];			
					


				$url_imgs =  url_publicidad_template($id_publicidad);
				$img_frames =  "<iframe width = '100%'  height = '500px' src='".$url_imgs."'></iframe>"; 		
				$modal_def =  " data-toggle='modal' data-target='#img-template'  "; 		
				$modal_def_horario =  " data-toggle='modal' data-target='#horario-templ'  "; 		
				$secciones_publicidad .=  " 										<div class='row'>														                                   
												
													<div>
														<div class='col-lg-12 col-md-12 col-sm-12'>
															<section>
																<h1 class='seccion-title'>
																	".$nombre."
																</h1>																
																<a>
						                                            <i  
							                                            class='img-publicidad fa fa-camera' 
							                                            id='".$id_publicidad."'  ".$modal_def." >
						                                            </i>
						                                        </a>
						                                        <a>
						                                        	<i 
						                                        		class='fa fa-clock-o horario-template' 
						                                        		id='".$id_publicidad."'   ".$modal_def_horario."  
						                                        		>
						                                        	</i>
						                                        </a>
															</section>
														</div>
													</div>	

													<section>
														<span>
														".$descripcion ."
														</span>
													</section>
													<section>
													".$img_frames ."
													</section>
													<hr>
													<hr>
													<br>
													<br>											  	
										  	</div>"; 



			$list_publicidad .='</tr>';			
			$b++;
		}	
?>

<?=n_row_12()?>		
	<span class='num_registros_encontrados'>
		# Plantillas encontradas 
		<?=count($data_templates);?>
	</span>					
<?=end_row()?>

<?=n_row_12()?>
	<div <?=$height?> >			
		<?=$secciones_publicidad ?>	
	</div>		
<?=end_row()?>