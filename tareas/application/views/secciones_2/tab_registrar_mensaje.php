<div>	
	<?=div("+ Agregar promoción en " , span(""  ,  ["class" => "place_mensaje_mensaje_social"]), 1)?>
    <form 
    class='mensaje_red_social' 
    id='mensaje_red_social' 
    action="../base/index.php/api/mensaje/red_social/format/json/">

			<?=n_row_12()?>
				<div class="contenedor_modal_mensaje row">											
					<div class="col-lg-8 contenedor_clasificacion">						
						<div class="row">
							<div class="form-group">
							  <span class="col-lg-3">
							  	<?=span("¿Producto?" , ["class"=>"text_info_modalidad"])?>
							  </span>  
							  <div class="col-lg-9">
							  	<?=input([
							  		"id"			=>	"Producto" ,
							  		"name"			=>	"nombre_producto" ,
							  		"placeholder"	=>	"Artículo ó servicio" ,
							  		"class"			=>	"form-control input-sm nombre_producto" ,
							  		"type"			=>	"text",
							  		"autocomplete"	=>	"off"
							  	])?>							  
							  </div>
							</div>					
						</div>
					</div>
			<div class="col-lg-4">						
				<?=div(place("place_busqueda_nombre_servicio") ,  ["class"=>"contenedor_opciones"])?>
			</div>
			</div>		
			<?=end_row()?>														
			<?=input_hidden([
					"name"		=>	'id_mensaje' ,
					"class"		=>	'form-control id_mensaje'  ,
					"type"		=>	'hidden' ,
					"value"		=>	"0"
			])?>
			<?=span("Promoción")?>
			<?=div("-",["class" => "summernote"] ,1)?>
			<?=place("place_notificacion_mensaje")?>
			<?=guardar("Registrar")?>				
			<?=place("place_mensaje_red_social")?>			
		</form>
</div>	
<style type="text/css">
		.contenedor_opciones{
			height: 20px;
			overflow-y: auto;
		}
</style>