<?=heading_enid("+ Nuevo miembro" ,  3 , [], 1)?>
	<form class="form-miembro-enid-service" id='form-miembro-enid-service'>	
		<div class="row">
			<div class="col-lg-4">
				<?=div("Estatus")?>					
				<select class="form-control input-sm estado_usuario" name="status">
					<option  value="1">
						Activo
					</option>
					<option value="0">
						Baja
					</option>
					<option value="2">
						Suspendido
					</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<?=div("Nombre")?>
				<?=input([						
						"name"			=>			"nombre",
						"placeholder"	=>			"Nombre",
						"class"			=>			"nombre",
						"type"			=>			"text",
						"required"		=>          "true"
					])?>					  
			</div>

			<div class="col-lg-4">
				<?=div("A.paterno")?>
				<?=input([						
						"name"			=>	"apellido_paterno", 
						"placeholder"	=>	"placeholder", 
						"class"			=>	"apellido_paterno",
						"type"			=>	"text",						
						"required"		=> 	true 
					])?>					
			</div>

			<div class="col-lg-4">
				<?=div("A.Materno")?>
				<?=input(
					["name"			=> "apellido_materno" ,
					"placeholder"	=> "placeholder" ,
					"class"			=> "form-control input-sm apellido_materno",
					"type"			=> "text",					
					"required"		=> "true"])?>					  
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<?=div("Email")?>
				<?=input([
					"name"			=>	"email" ,
					"placeholder"	=>	"email" ,
					"class"			=>	"form-control input-sm email",
					"type"			=>	"email",					
					"required"		=>	true ,
					"readonly"		=>	true 
				])?>
				<?=place("place_correo_incorrecto")?>	
			</div>
			<div class="col-lg-4">				
				<?=div("Departamento")?>				
				<?=create_select(
					$departamentos , 
					"departamento" , 
					"form-control input-sm depto",
					"departamento" , 
					"nombre" , 
					"id_departamento" ,
					1 
				)?>
			</div>
			<div class="col-lg-4">
				<?=div("Puesto")?>
				<?=place("place_puestos")?>				  	
			</div>
		</div>
		<div class="row">
			<div class="col-lg-4">
				<?=div("Inicio de labores")?>
				<select class="form-control inicio_labor" name="inicio_labor">
				  	<option value='8AM'>8AM</option>
				  	<option value='9AM'>9AM</option>
				</select>
			</div>
			<div class="col-lg-4">
				<?=div("Fin de labores")?>			
				<select class="form-control fin_labor" name="fin_labor">
					<option value='8PM'>
						2PM	
					</option>
					<option value='2PM'>
						3PM
					</option>
					<option value='6PM'>
						6PM
					</option>
					<option value='7PM'>
						7PM
					</option>
				</select>			
			</div>

			<div class="col-lg-4">
				<?=div("Turno")?>			
				<select class="form-control input-sm turno" name="turno">			 
					<option value="Matutino">
						Matutino
					</option>
					<option value="Vespertino">
						Vespertino
					</option>					
					<option>
						Tiempo completo
					</option>
				</select>				
			</div>
		</div>
		<div class="row">			
			<div class="col-lg-4">
				<?=div("Sexo")?>
				<select class="form-control input-sm sexo" name="sexo">
				  	<option value="1">
				  		Masculino
				  	</option>
				  	<option value="0">
				  		Femenino
				  	</option>		  		
				</select>
			</div>
			<div class="col-lg-4">
				<?=div("Teléfono")?>
				<?=input([
					"type"=>"text", 
					"name"=>"tel_contacto"
				])?>
			</div>
		</div>
		<?=guardar("Registrar")?>
		<?=place("place_config_usuario")?>
	</form>