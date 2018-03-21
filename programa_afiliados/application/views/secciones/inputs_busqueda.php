<div style="padding:10px;background: #03153B !important;">
	

					<div style='display:none;'>
						<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						<input  name="id_usuario" type='hidden'  value='<?=$id_usuario;?>'>
					</div>
					
					<div class="col-lg-3">
						<label class='white'>
							Nombre
							<input type='text' name='nombre' class='form-control input-sm'>
						</label>
					</div>
					<div class="col-lg-3">
						<label class='white'>
							Tel
							<input type='text' name='telefono' class='form-control input-sm'>
						</label>															
					</div>			
					<button class='btn btn-sm'>
						<i class="fa fa-search">
						</i>
					</button>

</div>