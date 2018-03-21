<?php if (count($data_prospectos) > 0 ){?>
<div class='place_prospecto_propuesta_registro'>
</div>
<form class='form_registro_propuesta'>
	<div class='row'>
		<div class='col-lg-4'>
			<div class='text-left black'>
				Posible cliente
			</div>
			<?=create_select($data_prospectos , "prospecto" , "p_prospecto form-control" , "p_prospecto" , "nombre_compuesto" , "id_persona")?>		
		</div>
		<div class='col-lg-4'>
			<div class='text-left black'>
				Servicio de interes
			</div>			
			<?=create_select($data_servicios , "servicio" , "servicio form-control" , "servicio" , "nombre_servicio" , "id_servicio")?>				
		</div>
		<div class='col-lg-4'>
			<div class='text-left black'>
				Tipo de propuesta
			</div>			
			<?=create_select($data_tipo_propuesta , "tipo_propuesta" , "tipo_propuesta form-control" , "tipo_propuesta" , "nombre" , "idtipo_propuesta")?>				
		</div>
		<div class='col-lg-12'>
			<div class='text-left black'>
				Url de la propuesta (opcional)
			</div>					
			<input name='url_propuesta' class='form-control' type="url">
		</div>
		<div class='col-sm-4'>
			<span class='strong'>
				Promesa de respuesta 
			</span>
			<input  data-date-format="yyyy-mm-dd"
                    value="<?=now_enid();?>"  
                    name='promesa_de_respusta' 
                    class="form-control datetimepicker6" id='datetimepicker6' />
															 

		</div>
		<div class='col-lg-8'>
			<div class='text-left black'>
				Comentario 
			</div>			
			<textarea  name="comentario">
			</textarea>		
		</div>

		


		<div class='col-lg-12'>
			<button class='btn'>
				Registrar
			</button>
		</div>

	</div>
</form>

<?php }else{ ?>

<div class='red_enid_background white strong' style='padding:10px;'>
	<p>
		Prospecto no encontrado
	</p>
</div>
<div class='blue_enid_background white strong' style='padding:10px;'>
	<p>
		Asegúrese que el nombre esté bien escrito y que ya se encuentre registrado 
	</p>
</div>
<?php }?>