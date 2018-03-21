<div class="col-lg-6 col-lg-offset-3">
	<div>
		<center>
			<h3 style="font-weight: bold;font-size: 3em;">		
				ESCRIBE UNA PREGUNTA AL VENDEDOR
			</h3>
			<div style="font-size: 1.4em">
				<span >Sobre su </span>
				<strong><?=$nombre_servicio?></strong>				
			</div>
		</center>
		<form class="form_valoracion" >
			<textarea 
				class="form-control" 
				id="pregunta" 
				name="pregunta" 
				style="resize:none" 
				placeholder="Alguna pregunta">   
			</textarea>
			<input type="hidden" name="servicio" value="<?=$id_servicio?>">
			<input type="hidden" name="usuario" value="<?=$id_usuario?>">
			<div>
				<div class="place_area_pregunta">
					
				</div>
			</div>		

			<div class="nuevo"></div>
			<?=n_row_12()?>
				<button 
					type="submit" 
					style="background: #015ec8;
					padding: 10px;color: white;font-weight: bold;">
					ENVIAR PREGUNTA <i class="fa fa-chevron-right ir"></i>
					
				</button>
			<?=end_row()?>			
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
