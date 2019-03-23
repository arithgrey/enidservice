<?php

$nombre = strtoupper(trim(get_campo($cliente, "nombre")));
$apellido_paterno = strtoupper(trim(get_campo($cliente, "apellido_paterno")));
$apellido_materno = strtoupper(trim(get_campo($cliente, "apellido_materno")));
$nombre_cliente = $nombre . " " . $apellido_paterno . " " . $apellido_materno;

?>
<div class="jumbotron"
     style="padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;">
    <?=heading("Buen día ".$nombre_cliente)?>

	<p class="lead">
		Tienes una nueva respuesta en tu buzón
		<a class="btn btn-primary btn-lg"
		   href="http://enidservice.com/"
		   target="_blank"
		   style="background: #015ec8;padding: 5px;color: white;margin-top: 23px;">
			Enid Service
		</a>
	</p>
	<hr class="my-4">
	<p>
		Apresúrate, estás a un paso de tener tu pedido!
	</p>
	<p class="lead">
		<a class="btn btn-primary btn-lg"
		   href="http://enidservice.com/inicio/login/"
		   target="_blank"
		   style="background: #015ec8;padding: 5px;color: white;margin-top: 23px;">
			Mira la respuesta aquí!
		</a>
	</p>
</div>


<div style="width: 30%;margin: 0 auto;">
	<img src="http://enidservice.com/inicio/img_tema/enid_service_logo.jpg" style="width: 100%">
</div>