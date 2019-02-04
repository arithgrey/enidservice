        <?=heading_enid("ESCRIBE UNA PREGUNTA " . strtoupper($vendedor[0]["nombre"]." ".$vendedor[0]["apellido_paterno"])  , 2)?>
        <?=div("SOBRE SU" .$servicio[0]["nombre_servicio"] )?>
        <?=br(2)?>
		<form class="form_valoracion ">
			<?=textarea([
				"class"			=>	"form-control" ,
				"id"			=>	"pregunta" ,
				"name"			=>	"pregunta" ,
				"placeholder" 	=>	"Tu pregunta"
			])?>
			
			<?=input_hidden(["name"=>"servicio" ,  "value"=> $id_servicio ])?>
			<?=input_hidden(["name"=>"propietario" , "class"=> "propietario" ,   "value"=> $propietario ])?>
			<?=place(".place_area_pregunta")?>
			<?=place(".nuevo")?>
			<?=guardar("ENVIAR PREGUNTA".icon("fa fa-chevron-right ir") )?>
			<?=place(".place_registro_valoracion")?>
		</form>	
	



