<div>
	<form class="form-miembro-enid-service" id='form-miembro-enid-service'>
		<div>
			<div class="row">
				<div class="col-lg-4">
					<span>
						Estatus
					</span> 
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
					<div>
					  <span>
					  	Nombre
					  </span>  
					  <div>
					  <input 
						  id="" 
						  name="nombre" 
						  placeholder="Nombre" 
						  class="form-control input-sm nombre"
						  type="text"
						  value="" 
						  required>  
					  </div>
					</div>
				</div>

				<!-- Text input-->
				<div class="col-lg-4">
					<div>
					  <span>
					  	A.paterno
					  </span>  
					  <div>
					  <input 
					  id="" 
					  name="apellido_paterno" 
					  placeholder="placeholder" 
					  class="form-control input-sm apellido_paterno"
					  type="text"
					  value=""
					  required>  
					  </div>
					</div>
				</div>

				<!-- Text input-->
				<div class="col-lg-4">
					<div>
					  <span>
					  	A.Materno
					  </span>  
					  <div>
					  <input 
					  id="" 
					  name="apellido_materno" 
					  placeholder="placeholder" 
					  class="form-control input-sm apellido_materno"
					  type="text"
					  value="" 
					  required
					  >  
					  </div>
					</div>
				</div>
			</div>












		<div class="row">

			<div class="col-lg-4">
				<div>
				  <span>
				  	Email
				  </span>  
				  <div>
				  <input 
					  id="" 
					  name="email" 
					  placeholder="email" 
					  class="form-control input-sm email"
					  type="email"
					  value="" 
					  required
					  readonly
					  >  
				  </div>
				</div>
				<div class="place_correo_incorrecto">
					
				</div>
			</div>

			<!-- Text input-->
			<div class="col-lg-4">
				<div>
				  <span>
				  	Departamento  	
				  </span>  
				  <div>
				  	<?=create_select($departamentos , 
				  	"departamento" , "form-control input-sm depto" , "departamento" , "nombre" , "id_departamento" )?>	
				  </div>
				</div>
			</div>


			<div class="col-lg-4">
				<div>
				  <span>
				  	Puesto
				  </span>  
				  <div>
				  	<div class="place_puestos">		  		
				  	</div>
				  </div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-lg-4">
				<div>
				  <span>
				  	Inicio de labores
				  </span>  
				  <div>

				  	<select class="form-control inicio_labor" name="inicio_labor">
				  		<option value='8AM'>
				  			8AM	
				  		</option>
				  		<option value='9AM'>
				  			9AM	
				  		</option>
				  	</select>

				  </div>
				</div>
			</div>


			<div class="col-lg-4">
				<div>
				  <span>
				  	Fin de labores
				  </span>  
				  <div>
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
				</div>
			</div>

			<div class="col-lg-4">
				<div>
				  <span>
				  	Turno
				  </span>  
				  <div>
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
			</div>





		</div>





		<div class="row">
			
			<div class="col-lg-4">
				<div>
				  <span>
				  	Sexo
				  </span>  
				  <div>
				  	<select class="form-control input-sm sexo" name="sexo">
				  		<option value="1">
				  			Masculino
				  		</option>
				  		<option value="0">
				  			Femenino
				  		</option>		  		
				  	</select>
				  </div>
				</div>
			</div>



			<div class="col-lg-4">
				<div>
				  <span>
				  	Teléfono
				  </span>  
				  <div>
				  	<input type="text" name="tel_contacto">
				  </div>
				</div>
			</div>



		</div>

		<button class="btn">
			Registrar
		</button>
		<div class="place_config_usuario">
			
		</div>
	</form>

</div>
