<?=construye_header_modal('liberar_tipo_negocio_modal', 'Liberar tipo de negocio');?>                           			

	<?=n_row_12()?>
		<div class='col-lg-6 col-lg-offset-3'>
			<form class='form_liberar_tipo_negocio' id='form_liberar_tipo_negocio'>
				<label>
					Tipo de negocio realizado 
				</label>
				<input type='hidden' name='activo' value='0'>
				<?=create_select($tipos_negocios , "tipo_negocio", "form-control" , "selectbasic" , "nombre" , "idtipo_negocio" );?>
				<button class='btn'>
					<i class="fa fa-check-circle-o" aria-hidden="true"></i>
					Marchar como hecho
				</button>
			</form>
		</div>
	<?=end_row()?>

	<?=n_row_12()?>
		<div class='place_libera_tipo_negocio'>
		</div>
	<?=end_row()?>
<?=construye_footer_modal()?>  

<?=construye_header_modal('registra_info_comando', 'Nuevo comando');?>                           			
<section>
	<form class='form_comando' id='form_comando'>
         <div>
         	<div class='text-left'>
             <label>
                Referencia
             </label>
            </div>
             <input 
                type="text" 
                name="referencia" 
				id="referencia" 
                class="form-control"
                required>
         </div>
        <div class="form-group">
        	<div class='text-left'>
	            <label>
	                Comando
	            </label>
        	</div>
            <input 
            type="text" 
            name="comando" 
            id="comando" 
            class="form-control"
            required>
            
        </div>
		<div class="checkbox">           	
            <span class="label">
               	Registrar
            </span>
		</div>
		<button class='btn' type="submit">
			Registrar
		</button>    
		<div class='row'>
			<div class='place_registro_comandos'>
			</div>                                       	   
		</div>		
	</form>     
</section>
<?=construye_footer_modal()?>  



<?=construye_header_modal('delete_mensaje_modal', "Eliminar" );?>                           		
	<div class='row'>
		<label class='red_enid_background white' style='padding:10px;'>
			¿Deseas eliminar el mensaje?
		</label>
	</div>
	<br>
	<br>
	<button class='btn btn_confirm_delete' style='background:#0606FF!important;'>
		Eliminar mensaje 
	</button>
	<div class='place_delete_mensaje'>
	</div>
	<br>
	<br><br><br><br><br><br><br><br>
<?=construye_footer_modal()?>  


<?=construye_header_modal('registrar_info_red_social', "+ Mensaje" );?>                           		
	<div class='row'>
		<div class='col-lg-8 col-lg-offset-2'>
		<form class='mensaje_red_social' action="../base/index.php/api/mensaje/red_social/format/json/">
			<?=n_row_12()?>
				<div class='row'>
					<div class='col-lg-6'>
						<label>
							SERVICIO
						</label>
						<select class='form-control' name='servicio'>
							<option value='1'>
								Páginas web
							</option>
							<option value='2'>
								Tienda en linea 
							</option>
							<option value='3'>
								CRM
							</option>
							<option value='4'>
								Adwords
							</option>

						</select>
					</div>
					<div class='col-lg-6'>
						<label>
							TIPO DE NEGOCIO A QUIEN VA DIRIGIDO
						</label>			
						<?=create_select($tipos_negocios , 
							"tipo_negocio" , 
							"tipo_negocio   form-control" , 
							"tipo_negocio" ,
						    "nombre", 
						    "idtipo_negocio" )?>
					</div>

				</div>
			<?=end_row()?>
					
			<?=n_row_12()?>
				<div class='text-left'>
					<label >
						Titular
					</label>
				</div>
				<input name='titular' class='form-control' required >
			<?=end_row()?>

			<?=n_row_12()?>
				
				<input name='enlace' class='form-control'  type='hidden'>
			<?=end_row()?>
			
			<?=n_row_12()?>
				<div class='text-left'>
					<label>
						Mensaje
					</label>
				</div>
				<textarea name='mensaje'  class='form-control' required>
				</textarea>			
			<?=end_row()?>

			<?=n_row_12()?>

				<div class='text-left'>
					<label>
						Llamada a la acción
					</label>
				</div>
				<input name='llamada_a_la_accion' class='form-control'  required>
			<?=end_row()?>
			<div class='text-right'>
				<button class='btn' type='submit'>
					Registrar
				</button>		
			</div>
			<?=n_row_12()?>
				<div class='place_mensaje_red_social'>
				</div>
			<?=end_row()?>
		</form>
		</div>
	</div>
	<br>
	<br><br><br><br><br><br><br>
<?=construye_footer_modal()?>  