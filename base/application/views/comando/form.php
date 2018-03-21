<?php 
	
	$comando  =  $comando[0];
	$estado= $comando["estado"];
	$id_estado= $comando["id_estado"];
	$nombre= $comando["nombre"];
	$idtipo_negocio= $comando["idtipo_negocio"];	
	$nombre_busqueda= $comando["nombre_busqueda"];	
	$id_red_social =  $comando["id_red_social"];
	$id_base_prospecto	 =  $comando["id_base_prospecto"];

	$text_comando = $nombre_busqueda 
					." " . "'".$nombre ."'" . 
					" " . 
					" '" . $estado . "' " ."  " . "'@gmail.com' ";
	
?>



<br>
<br>


	<center>		
		<i class="fa fa-arrow-down fa-2x" ></i>
	</center>
	<center>
		<p style="font-size: 1.3em;">
			<?=$text_comando;?>
		</p>
	</center>
<br>
<br>
<br>


<br>
<p 
    class="white strong" 
    style="font-size: .9em;line-height: .8;background: black;padding: 5px;">
   	3.-Busca el comando en el navegador, selecciona todos los resultados y copia 
</p>
<img src="../img_tema/correo_empresarial/resultados.png" style="width: 100%">

<br>
<p 
    class="white strong" 
    style="font-size: .9em;line-height: .8;background: black;padding: 5px;">
   	4.- pega el contenido 
</p>
<br>

<form class="form_registro_contacto"  id='form_registro_contacto'>	

	<input name='red_social' type='hidden' value='<?=$id_red_social?>' >
    <input name='estado_republica' type='hidden' value='<?=$id_estado?>' >
    <input name='tipo_negocio' type='hidden' value='<?=$idtipo_negocio?>' >
    <input name='tipo_servicio' type='hidden' value='1' >
    <input type="hidden" name="id_base_prospecto" value="<?=$id_base_prospecto;?>">	
	<textarea  class="area_contenido">	
	</textarea>
	<button class="btn input-sm registrar_btn" style="background: black!important;">
		Registra
	</button>
	<div class="place_test_contactos">
	</div>
</form>