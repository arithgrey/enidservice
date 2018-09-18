<?php	
	$criterios = array("RELEVANTE" , "RECIENTE" );
?>

<?=n_row_12()?>	
	<h3 style="font-size: 2em;" class="black">										
		VALORACIONES Y RESEÑAS
	</h3>
	<a 
		class="a_enid_black" 
		href="../recomendacion/?q=<?=$id_usuario?>" 
		style="color: white!important">
		MÁS VALORACIONES DEl VENDEDOR
		<?=icon("fa fa-chevron-right ir")?>
	</a>	
<?=end_row()?>
<hr>
<table style="width: 100%">
	<tr>
		<td class="table_orden_1" >			
		</td>	
		<td class="table_orden_2">			
			<strong>
				ORDENAR POR
			</strong>
		</td>	
		<td class="table_orden_3">			
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
		<div class="row">
			<div 
				class="btn_escribir_valoracion">
				<a  class="escribir_valoracion" 
					href="../valoracion?servicio=<?=$servicio?> "
					 style="color:white!important">
						ESCRIBE UNA RESEÑA 
					<i class="fa fa-chevron-right ir">				
					</i>
				</a>	
			</div>				
			<?=crea_resumen_valoracion($numero_valoraciones);?>		
		</div>
	</div>
	<div class="col-lg-8">
		<div class="row contenedor_comentarios" >
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
	</div>
<?=end_row()?>



