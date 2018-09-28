<?php 
	
	
	$nombre_vendedor = "";
	$telefono_visible =  $servicio[0]["telefono_visible"]; 
	$telefono_contacto ="";
	if ($in_session ==  1) {
		$nombre_vendedor = $vendedor[0]["nombre"]." ".$vendedor[0]["apellido_paterno"];

		
		$telefono_contacto = 
		(strlen($vendedor[0]["tel_contacto"]) >4)?$vendedor[0]["tel_contacto"]:
		$vendedor[0]["tel_contacto_alterno"];	

	}
	

	
?>
<div class="col-lg-8 col-lg-offset-2">
		<center>
			<?=heading_enid("ESCRIBE UNA PREGUNTA A" . strtoupper($nombre_vendedor)  , 2)?>
			<?=div("Sobre su" .$servicio[0]["nombre_servicio"] )?>
		</center>
		<form class="form_valoracion">
			<textarea 
				class="form-control" 
				id="pregunta" 
				name="pregunta" 
				style="resize:none" 
				placeholder="Alguna pregunta">   
			</textarea>
			<?=input_hidden(["name"=>"servicio" ,  "value"=> $id_servicio ])?>
			<?=input_hidden(["name"=>"usuario" ,  "value"=> $id_usuario ])?>
			<?=input_hidden(["name"=>"propietario" , "class"=> "propietario" ,   "value"=> $propietario ])?>
			<?=place(".place_area_pregunta")?>
			<?=place(".nuevo")?>
			<?=guardar("ENVIAR PREGUNTA".icon("fa fa-chevron-right ir") , ["style"=>"background: #015ec8;padding: 10px;color: white;width: 100%"])?>
			<?=place(".place_registro_valoracion")?>
			<?php if ($telefono_visible == 1 && strlen($telefono_contacto)>4 ):?>
				<?=n_row_12()?>
					<?=div("TAMBIÉN PUEDES SOLICITAR INFORMACIÓN SOBRE TU COMPRA AL" , ["style"=>"margin-top: 10px;background: black;color: white;padding: 10px;"])?>
					<?=div(icon("fa fa-phone").$vendedor[0]["tel_contacto"] , [ "style"=>"background: #f9fcff;padding: 6px;text-decoration: underline;" ])?>
				<?=end_row()?>
			<?php endif;?>
		</form>	
	
</div>



<style type="text/css">
	
	input[type="radio"] {
	  display: none;
	}.estrella:hover{
		cursor: pointer;
	}	
	label:hover, label:hover ~ label{	  
	  -webkit-text-fill-color: white;
	  -webkit-text-stroke-color: #004afc;
	  -webkit-text-stroke-width: .5px;

	}
	.estrella{
		font-size: 2.4em;color: #0070dd;
	}
	.recomendaria{
		background: white;
		color: black;
		border: solid 1px;
		padding: 10px;
	}	
	.text-valoracion{
		font-size: 1.1em;
	}
	.nuevo{
		margin-top: 20px;
	}
	.nota_recomendarias{
		background: red;
		padding: 5px;
		color: white;
	}
</style>
