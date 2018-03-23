<?php 
	/**/
	$nombre =  strtoupper(trim( entrega_data_campo($vendedor , "nombre"  ))); 
	$apellido_paterno =  strtoupper(trim(entrega_data_campo($vendedor , "apellido_paterno"))); 
	$apellido_materno =  strtoupper(trim(entrega_data_campo($vendedor , "apellido_materno"  ))); 
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
	    	style="background: #015ec8;padding: 5px;color: white;font-weight: bold;margin-top: 23px;">
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
    	style="background: #015ec8;padding: 5px;color: white;font-weight: bold;margin-top: 23px;">
    	Responde a tu cliente aquí!
	</a>
  </p>
</div>


<div style="width: 30%;margin: 0 auto;">
    <img src="http://enidservice.com/inicio/img_tema/enid_service_logo.jpg" style="width: 100%">
</div>