<?=place("response_img" , ["id"=>'response_img'])?>
<?=place("lista-imagene" , ["id"=>'lista-imagene'])?>
<form 	accept-charset="utf-8" 
		method="POST" 
		id="form_img_galeria_empresa"  
		class="form_img_galeria_empresa" 
		enctype="multipart/form-data" >      

   	<input type="file" id='imagen_gal_empresa' class='imagen_gal_empresa' name="imagen"/>	
	<?=input_hidden([		
		"value"	=>	'galeria_empresa',
		"name"	=>	'q'
	])?>	
	<?=input_hidden([
		"class"	=>	'dinamic_logo_empresa',
		"id"	=>	'dinamic_logo_empresa',
		"name"	=>	'dinamic_logo_empresa'
	])?>	
	<?=guardar(icon("fa fa-check") , ["class"=>'btn btn btn-sm guardar_img_enid pull-right' ] )?>	
	<?=div("lista_imagenes_galeria" , ["id"=>'lista_imagenes_galeria'] , 1)?>	
</form>
<?=place("place_load_imgs_galeria")?>