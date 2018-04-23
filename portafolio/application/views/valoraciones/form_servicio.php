<?php 	
	
	$nombre ="";
	$email ="";
	if($extra["in_session"] ==  1) {
		$nombre =  $extra["nombre"];
		$email = $extra["email"];
	}
	$calificacion = array("","Insuficiente" , "Aceptable" , "Promedio" , "Bueno" , "Excelente");
?>
<div class="col-lg-6 col-lg-offset-3">
	<div>
		<center>
			<h3 style="font-weight: bold;font-size: 3em;">		
				ESCRIBE UNA RESEÑA
			</h3>
			<div style="font-size: 1.4em">
				<span >Sobre tu </span>
				<strong><?=$servicio[0]["nombre_servicio"]?></strong>
			</div>
		</center>
		<form class="form_valoracion" >
			<div class="nuevo"></div>
			<?=n_row_12()?>
				<div>
					<table style='width:100%'>
						<tr>
							<td>
								<strong class="text-valoracion">
									Valoración*
								</strong>
							</td>
							<td>
								<?php for($x=1; $x <= 5; $x++){ 
										$id_input ="radio".$x;
										$num_estrella ="estrella_".$x;
										 ?>			
										<input id="<?=$id_input?>" 
											value="<?=$x?>" 
											class='input-start' 
											type="radio">    			

										<label 
											class='estrella <?=$num_estrella?>' 
											for="<?=$id_input?>" 
											id="<?=$x?>"
											title="<?=$x?> - <?=$calificacion[$x]?>">
											★
										</label>    											
								<?php }?>
							</td>
						</tr>
					</table>
				</div>
			<?=end_row()?>
			<div class="nuevo"></div>
			<?=n_row_12()?>
				
				<table style='width:100%'>
					<tr>
						<td>
							<strong class="text-valoracion">
								¿Recomendarías este producto?*
							</strong>
						</td>
						<td>
							<table style='width:100%'>
								<tr>
									<td>
										<a class='recomendaria' id='1' >
											SI
										</a>
									</td>
									<td>
										<a class='recomendaria' id='0' >
											NO
										</a>
									</td>
								</tr>
							</table>
						</td>
					</tr>	
				</table>
				<div class="place_recomendaria"></div>
			<?=end_row()?>
			<div class="nuevo"></div>
			<?=n_row_12()?>
				<table style='width:100%'>
					<tr>
						<td>
							<strong class="text-valoracion">
								Tu opinión en una frase*
							</strong>
						</td>
						<td>
							<input 
								type="text" 
								name="titulo"
								class="input-sm input" 
								placeholder="Por ejemplo: Me encantó!"
								required="Agrega una breve descripción" 
								>
						</td>
					</tr>	

				</table>
			<?=end_row()?>
			<div class="nuevo"></div>
			<?=n_row_12()?>
				<table style='width:100%'>
					<tr>
						<td>
							<strong class="text-valoracion">
								Tu reseña*
							</strong>
						</td>
						<td>
							<input 
								type="text" 
								name="comentario"
								placeholder="¿Por qué te gusta el producto o por qué no?"
								required="Comenta tu experiencia">

						</td>
					</tr>	

				</table>
			<?=end_row()?>
			<div class="nuevo"></div>
			<?=n_row_12()?>
				<table style='width:100%'>
					<tr>
						<td>
							<strong class="text-valoracion">
								Nombre*
							</strong>
						</td>
						<td>
							<input 
								type="text" 
								name="nombre"
								placeholder="Por ejemplo: Jonathan"
								value="<?=$nombre?>" 
								<?=valida_readonly($nombre)?>
								required>
								<input type="hidden" name="id_servicio" value="<?=$id_servicio?>">
						</td>
					</tr>	

				</table>
			<?=end_row()?>
			<div class="nuevo"></div>
			<?=n_row_12()?>
				<table style='width:100%'>
					<tr>
						<td>
							<strong class="text-valoracion">
								Tu correo electrónico*
							</strong>
						</td>
						<td>
							<input 
							type="email" 
							name="email"
							placeholder="Por ejemplo: jmedrano@enidservice.com" 
							required
							<?=valida_readonly($email)?>
							value="<?=$email?>">
						</td>
					</tr>	

				</table>
			<?=end_row()?>
			<div class="nuevo"></div>
			<?=n_row_12()?>
				<button 
					type="submit" 
					style="background: #015ec8;padding: 10px;color: white;font-weight: bold;">
					ENVIAR RESEÑA
					<i class="fa fa-chevron-right ir">						
					</i>
				</button>
			<?=end_row()?>
			
			<br><br>
			<?=n_row_12()?>
				<div class="place_registro_valoracion"></div>
			<?=end_row()?>

		</form>	
	</div>
</div>



<style type="text/css">
	
	input[type="radio"] {
	  display: none;
	}.estrella:hover{
		cursor: pointer;
	}	
	label:hover, label:hover ~ label{	  
	  -webkit-text-fill-color: white;
	  -webkit-text-stroke-color: #004afc;
	  -webkit-text-stroke-width: .5px;

	}
	.estrella{
		font-size: 2.4em;color: #0070dd;
	}
	.recomendaria{
		background: white;
		color: black;
		border: solid 1px;
		padding: 10px;
	}	
	.text-valoracion{
		font-size: 1.1em;
	}
	.nuevo{
		margin-top: 20px;
	}
	.nota_recomendarias{
		background: red;
		padding: 5px;
		color: white;
	}
</style>
