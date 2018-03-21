<?=n_row_12()?>
	<div class="col-lg-4 col-lg-offset-4">
		<?=n_row_12()?>
			<h3 style="font-weight: bold;font-size: 3em;">										
				ACTUALIZAR DATOS DE ACCESO
			</h3>
		<?=end_row()?>
		<?=n_row_12()?>
					<form id="form_update_password" class="form-horizontal" method="POST">            			
						<div class="form-group">            
				            <span class="strong">
				              Contraseña actual 
				            </span>
				            <input 
				              name="password" 
				              id="password" 
				              class="form-control input-sm"
				              type="password" 
				              required>

					        <div class='place_pw_1'>
					        </div>          	            

				            <span class="strong">
				              Nueva
				            </span>
				            <input 
				            	name="pw_nueva" 
				            	id="pw_nueva" 
				            	type="password" 
				            	class='form-control input-sm'
				             	required>

				            <div class='place_pw_2'>	            	
				            </div>
				            <span class="strong">
				              Confirmar nueva
				            </span>

				            <input 
				            	name="pw_nueva_confirm" 
				            	id="pw_nueva_confirm"  
				            	type="password" 
				            	class="form-control input-sm" 
				            	required>

				            <input name="secret" id="secret" type="hidden">            
				            <div class='place_pw_3'>
				            </div>          
				            <label id="reportesession" class="reportesession">
				            </label>                                                                    
				            <button id="inbutton" class="btn btn_save input-sm">
				              Actualizar 
				            </button>                          
				        </div>    
			      	</form>
		<?=end_row()?>
		<?=n_row_12()?>
			<span class='msj_password'> 
			</span>
		<?=end_row()?>
	</div>
<?=end_row()?>