<?php

	$info_proyect = $info_proyecto[0];

	$id_proyecto  =  $info_proyect["id_proyecto"];
	$proyecto      =  $info_proyect["proyecto"]; 
	$descripcion      =  $info_proyect["descripcion"]; 
	$fecha_registro      =  $info_proyect["fecha_registro"]; 
	$idtipo_proyecto      =  $info_proyect["idtipo_proyecto"]; 
	$url      =  $info_proyect["url"]; 
	$url_img      =  $info_proyect["url_img"]; 
	$status      =  $info_proyect["status"]; 	
	$id_servicio      =  $info_proyect["id_servicio"]; 
	$nombre_servicio      =  $info_proyect["nombre_servicio"]; 

?>

<br>
<div class="col-lg-8 col-lg-offset-2">
	<form class="form_proyecto_actualizacion">
		

		<div class="row">
			<div class="col-lg-4">
			  <span style="font-size: .8em;">
			  	Proyecto
			  </span>  		  
				<input 
				id="proyecto" 
				name="proyecto" 
				placeholder="Nombre del proyecto" 
				class="input-sm form-control"
				value='<?=$proyecto?>' 
				type="text" required>		  	  
			</div>
			
			<div class="col-lg-4">
				<span style="font-size: .8em;">
					Servicio
				</span>
				
				<?=create_select_selected($servicios ,
				 "id_servicio", 
				 "nombre_servicio" , 
				 $id_servicio , 
				 "id_servicio" ,  
				 "form-control input-sm")?>
			</div>

			<div class="col-lg-4">
				<span style="font-size: .8em;">
					Status
				</span>			
				<?=get_lista_status($status);?>
			</div>
		</div>




		<div class="row">
			<div class="col-lg-4">
				<span style="font-size: .8em;">
				  Url
				</span>  		  
				<input 
				  id="url" 
				  name="url" placeholder="Url del proyecto" 
				  class="input-sm form-control"
				  value='<?=$url?>' 
				  type="text">			 
			</div>

			<input type="hidden" name="id_proyecto" value="<?=$id_proyecto;?>">
			<div class="col-lg-4">
				<span style="font-size: .8em;">
				  	Url Imagen
				</span>  			  
				  <input 
						id="url_img" 
						name="url_img" 
						value='<?=$url_img?>' 
						placeholder="URL  Imagen" 
						class="input-sm form-control" 
						type="url" required>		  
			  
			</div>
		</div>


		<button class="btn input-sm" style="background: black!important;">
			Actualizar
		</button>
	</form>
</div>

<?=n_row_12()?>
	<div class="place_info_proyecto_actualizacion">
	</div>
<?=end_row()?>
