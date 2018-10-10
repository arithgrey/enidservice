<div class="row">						
	<?=div(create_select($servicios , "servicio" , 
			"input-sm servicio_red_social id_servicio form-control " , 
			"sfb" , 
			"nombre_servicio" , 
			"id_servicio"),
		["class" =>	"col-lg-6"])?>
	
	<?=div(create_select($tipos_negocios , 
		"tipo_negocio" , 
		"tipo_negocio   input-sm form-control" , 
		"tipo_negocio_fb" ,
		"nombre", 
		"idtipo_negocio" 
	), ["class" =>	"col-lg-6"])?>	
</div>				