<div style="background: white;padding: 5px;height: 300px;">
	<?=n_row_12()?>		
			<form id='form_descargar_contactos'>								
				<div class="row">
					<div class='col-lg-4'>
						<button class='btn input-sm btn_descargar_email' 
								style="background: black!important;">
								<i class="fa fa-cloud-download">
								</i>
							Descargar
						</button>
					</div>
					<div class='col-lg-8'>						
						<input type="hidden" name="tipo_servicio" value="1">						
						<div style="margin-top: 10px;">							
						</div>
						<div style="display: none;">
							<?=get_select_descargas_email()?>			
						</div>
					</div>

				</div>
			</form>		
	<?=end_row()?>	
	<?=place('place_contactos_disponibles')?>
</div>		