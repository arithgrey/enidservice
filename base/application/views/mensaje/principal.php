<?php 		
	
	$host =  $_SERVER['HTTP_HOST'];
    $url_request =  "http://".$host."/inicio/"; 	

	$colores_por_red_social = get_background_secciones();
	$mensaje =  $info_mensaje["mensaje"];  
	$num_msj = count($mensaje);

	$x =  $num_msj -1;
	
		$msj=  $info_mensaje["mensaje"][$x];		
		$nombre_servicio =  "";  
		$url_web_servicio =  "";
		$id_mensaje = 0; 	
		$descripcion ="";	
		$red_social_mensaje =  $red_social;
		$id_usuario_registro = $id_usuario;	
		$flag_servicio  =0;	
		$id_tipo_negocio =0;
		$nombre   =  ""; 




	$url_preview_servicio =  "../imgs/index.php/enid/imagen_servicio/".$servicio;

	if($num_msj>0){	

		foreach($mensaje as $row){		

			$id_tipo_negocio  =  $row["idtipo_negocio"];
			$nombre  =  $row["nombre"];
		}
		
		$id_mensaje = $msj["id_mensaje"];  
		$id_usuario=  $msj["id_usuario"];
		$red_social_mensaje =  $msj["red_social"];
		$flag_servicio = $msj["flag_servicio"];
		$nombre_servicio =  $msj["nombre_servicio"];  		
		$url_web_servicio =  $msj["url_web_servicio"];		
		$descripcion =  $msj["descripcion"];			        
		$url_promocion_servicio = get_url_social(
									$id_usuario , 
									$id_tipo_negocio , 
									$red_social_mensaje , 
									$id_mensaje, 
									$servicio , 
									$flag_servicio, 
									$url_web_servicio, 
									$url_request);

		$nombre_creador_completo = get_nombre_usuario_registro($msj);	                
		
	}
?>



<?=n_row_12()?>		
	
	<div style="background: white;">
		<div style="border-style: solid; border-width: 1px;padding: 5px;<?=$colores_por_red_social[$red_social_mensaje]?>;">			
			<div class=' strong black'>	        							
				
					<a 	
						title="Copiar texto" 
						style="background:white!important;" 
						class='btn copy_contenedor_msj_facebook black input-sm text-right' 
						onclick="copiarAlPortapapeles()">
						<i class="fa fa-clone black">
						</i>
					</a>
			</div>                              		
		</div>	                                    	
		<!---->			                                   
		
		



		<div>
			<div class="row">
				<div class="[ col-xs-12 col-sm-12 ]">
					<div id='contenedor_msj_facebook' class='contenedor_msj_facebook'>
						<ul class="event-list">
							<li>															
								<div class="info" style="text-align: left!important;">
									<h2 class="title">
										<?=$nombre_servicio?>
									</h2>
									<p class="desc" style="font-size: .8em;">
										<?=$descripcion;?>
									</p>
									<div>
										<span style="font-size: .8em;">
											+ Info
											<?=get_tels($id_usuario);?>										
										</span>
									</div>
									<div style="font-size: .7em;">
										<?=$url_promocion_servicio?>
									</div>
								</div>							
							</li>
							<li>
								<img src="<?=$url_preview_servicio?>"/>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div>
			<span style="font-size: .7em">				
				<?=$nombre_creador_completo?>				
			</span>
		</div>
	</div>	
<?=end_row()?>




<style type="text/css">
	.media
    {
       
        margin: 20px 0;
        padding:30px;
    }
    .dp
    {
        border:10px solid #eee;
        transition: all 0.2s ease-in-out;
    }
    .dp:hover
    {
        border:2px solid #eee;
        transform:rotate(360deg);
        -ms-transform:rotate(360deg);  
        -webkit-transform:rotate(360deg);  
        /*-webkit-font-smoothing:antialiased;*/
    }
</style>
















    





	<style type="text/css">
		    
    .event-list {
		list-style: none;
		font-family: 'Lato', sans-serif;
		margin: 0px;
		padding: 0px;
	}
	.event-list > li {
		background-color: rgb(255, 255, 255);
		box-shadow: 0px 0px 5px rgb(51, 51, 51);
		box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
		padding: 0px;
		margin: 0px 0px 20px;
	}
	.event-list > li > time {
		display: inline-block;
		width: 100%;
		color: rgb(255, 255, 255);
		background-color: rgb(197, 44, 102);
		padding: 5px;
		text-align: center;
		text-transform: uppercase;
	}
	.event-list > li:nth-child(even) > time {
		background-color: rgb(165, 82, 167);
	}
	.event-list > li > time > span {
		display: none;
	}
	.event-list > li > time > .day {
		display: block;
		font-size: 56pt;
		font-weight: 100;
		line-height: 1;
	}
	.event-list > li time > .month {
		display: block;
		font-size: 24pt;
		font-weight: 900;
		line-height: 1;
	}
	.event-list > li > img {
		width: 100%;
	}
	.event-list > li > .info {
		padding-top: 5px;
		text-align: center;
	}
	.event-list > li > .info > .title {
		font-size: 17pt;
		font-weight: 700;
		margin: 0px;
	}
	.event-list > li > .info > .desc {
		font-size: 13pt;
		font-weight: 300;
		margin: 0px;
	}
	
    

	</style>