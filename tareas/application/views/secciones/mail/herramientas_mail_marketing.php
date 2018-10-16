
							<form id='form_update_correo'>		
								<?=n_row_12()?>
									
									<div style="display: none;">
										<?=create_select($servicios , "tipo_servicio" , "form-control", 
									"selectbasic" , "nombre_servicio" , "id_servicio")?>
									</div>
									<span >
										Correos	que enviaste
									</span>
									<?=textarea([
										"class"		=>	"form-control" ,
										"id"		=>	"textarea" ,
										"name"		=>	"text_info"
									])?>
									
								<?=end_row()?>
								<?=n_row_12()?>
									<div class='place_registro'>
									</div>
								<?=end_row()?>
								<?=n_row_12()?>
									<button 
										class='btn input-sm' 
										type='submit'
										style="background: black!important;">
										Actualizar
									</button>	
								<?=end_row()?>														
							</form>
							<div class="place_registro">
								
							</div>
			