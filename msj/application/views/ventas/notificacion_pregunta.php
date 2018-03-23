<?php 
	
	$vendedor =  $vendedor[0]; 
	$nombre =  strtoupper(trim($vendedor["nombre"])); 
	$apellido_paterno =  strtoupper(trim($vendedor["apellido_paterno"])); 
	$apellido_materno =  strtoupper(trim($vendedor["apellido_materno"])); 
	$nombre_vendedor = $nombre . " ".$apellido_paterno ." " .$apellido_materno;

?>
<div class="jumbotron" 
	style="padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;">
  	<h1 class="display-4">
		Buen día <?=$nombre_vendedor?>
	</h1>
  	<p class="lead">
  		Un cliente está interesado en uno de tus productos que tienes en venta en 
  		<a 	class="btn btn-primary btn-lg" 
	    	href="http://enidservice.com/" 
	    	target="_blank" 
	    	style="background: #015ec8;padding: 10px;color: white;font-weight: bold;margin-top: 20px;">
  			Enid Service
  		</a>
	</p>
  <hr class="my-4">
  <p>
  	Apresúrate, estás a un paso de realizar una nueva venta!
  </p>
  <p class="lead">
    <a 	class="btn btn-primary btn-lg" 
    	href="http://enidservice.com/inicio/login/" 
    	target="_blank" 
    	style="background: #015ec8;padding: 10px;color: white;font-weight: bold;margin-top: 20px;">
    	Responde a tu cliente aquí!
	</a>
  </p>
</div>