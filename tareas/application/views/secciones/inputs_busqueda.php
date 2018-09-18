			<div class="row">						
				<div class="col-lg-6">
					<?=create_select($servicios , "servicio" , 
					"input-sm servicio_red_social id_servicio form-control " , 
					"sfb" , 
					"nombre_servicio" , 
					"id_servicio")?>
				</div>
				<div class="col-lg-6">
					<?=create_select($tipos_negocios , 
					"tipo_negocio" , 
					"tipo_negocio   input-sm form-control" , 
					"tipo_negocio_fb" ,
					"nombre", 
					"idtipo_negocio" )?>
				</div>
			</div>				