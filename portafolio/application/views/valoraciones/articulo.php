<?php	
	$criterios = array("RELEVANTE" , "RECIENTE" );
?>
<div>
	<center>
		<h3 style="font-size: 2em;" class="black">										
			VALORACIONES Y RESEÑAS
		</h3>
		<a class="a_enid_black" href="../recomendacion/?q=<?=$id_usuario?>" 
			style="color: white!important">
			VE MÁS VALORACIONES DEl VENDEDOR
			<i class="fa fa-chevron-right ir"></i>
		</a>
	</center>
</div>
<hr>
<table style="width: 100%">
	<tr>
		<td style="width:60%">			
		</td>	
		<td style="width:10%">			
			<strong>
				ORDENAR POR
			</strong>
		</td>	
		<td style="width:30%">			
				<table border="1">
					<tr>
						<?php 
							for($z=0; $z <count($criterios); $z++){ 
								$extra_criterios = "style='padding:8px;' 
												class='criterio_busqueda ordenar_valoraciones_button' id='".$z."' ";	
								if($z == 0) {
									$extra_criterios = 
										"style='padding:8px;background:#002753;color:white'
										class='criterio_busqueda ordenar_valoraciones_button' 
										id='".$z."'";
								}

								echo get_td($criterios[$z], $extra_criterios);	

							}
						?>
					</tr>
				</table>				
		</td>
	</tr>
</table>
<hr>




<?=n_row_12()?>
	<div class="col-lg-4">	
		<center>
			<div class="btn_escribir_valoracion">
				<a  class="escribir_valoracion" 
					href="../valoracion?servicio=<?=$servicio?> "
					 style="color:white!important">
						ESCRIBE UNA RESEÑA 
					<i class="fa fa-chevron-right ir">				
					</i>
				</a>	
			</div>
		</center>
		<center>
			<?=crea_resumen_valoracion($numero_valoraciones);?>
			
		</center>
	</div>
	<div class="col-lg-8">
		<?=crea_resumen_valoracion_comentarios($comentarios , $respuesta_valorada);?>
		<?php if(count($comentarios) >5){?>
			<center>
				<div class="btn_escribir_valoracion">
					<?php if($numero_valoraciones[0]["num_valoraciones"] > 6){?>
						<a  
							class="cargar_mas_valoraciones" 
							style="color:white!important">
							CARGAR MÁS
							<i class="fa fa-chevron-right ir">				
							</i>
						</a>	
					<?php }?>
					<a  class="escribir_valoracion" 
						href="../valoracion?servicio=<?=$servicio?> "
						 style="color:white!important">
						ESCRIBE UNA RESEÑA 
						<i class="fa fa-chevron-right ir">				
						</i>
					</a>	
				</div>
			</center>
		<?php }?>
	</div>
<?=end_row()?>

<link rel="stylesheet" type="text/css" href="../css_tema/template/valoracion.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinysort/2.3.6/jquery.tinysort.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinysort/2.3.6/jquery.tinysort.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tinysort/2.3.6/tinysort.charorder.js"></script>
