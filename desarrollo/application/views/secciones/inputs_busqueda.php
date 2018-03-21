<div class='blue_enid_background' style='padding:10px;'>

					<div style='display:none;'>
						<?=$this->load->view("../../../view_tema/inputs_fecha_busqueda")?>
						<input  name="id_usuario" type='hidden'  value='<?=$id_usuario;?>'>              
					</div>
					<label class='white'>
						Nombre
						<input type='text' name='nombre' class='form-control input-sm'>
					</label>
					<label class='white'>
						Tel
						<input type='text' name='telefono' class='form-control input-sm'>
					</label>															
					<?=create_select($servicios ,
					  "servicio" , 
					  " ",
					  "selectbasic" , 
					  "nombre_servicio" , 
					  "id_servicio")?>   
					
					<button class='btn btn-sm'>
						<i class="fa fa-search">
						</i>
					</button>

</div>