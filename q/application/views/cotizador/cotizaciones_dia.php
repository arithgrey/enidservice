<?php
$list  =  "";
foreach ($cotizaciones as $row) {
	
	$id_cotizador          = $row["id_cotizador"];
	$nombre_empresa        = $row["nombre_empresa"];
	$email                 = $row["email"];
	$rubro                 = $row["rubro"];
	$objetivos             = $row["objetivos"];
	$sitio_similar         = $row["sitio_similar"];
	$contenidos_elaborados = $row["contenidos_elaborados"];
	$contenidos_web        = $row["contenidos_web"];
	$info_dominio_servidor = $row["info_dominio_servidor"];
	$presupuesto           = $row["presupuesto"];
	$fecha_registro        = $row["fecha_registro"];
	$tipo                  = $row["tipo"];
	$tel                   = $row["tel"];
	$direccion             = $row["direccion"];
	$facebook              = $row["facebook"];
	$twitter               = $row["twitter"];
	$youtube               = $row["youtube"];

	$list .=  '
			<div class="row">
				<div class="panel-body"> 
					 	<div class="pull-right">	 	
							<b>
								<a href="">
									Negocio - '.$nombre_empresa.'
								</a>
								<br>
								'.$email.'
								
								
							</b>
				    	</div>
				    <br>			  
				    <br>
					<center>
					  <h4>
					  Teléfono de contacto - '.$tel.'
					  </h4>
					  <br>
					  Rubro - 
					  '.$rubro.'
					  <br>
					  Registro - 
					  '.$fecha_registro.'
					  <br>
					  Sitio similar - 
					  '.$sitio_similar.'
					  <br>

				  	</center>
					<p>
					Objetivos que persigue - 
						'.$objetivos.'
						
						<div class="pull-left">
							<a>
								<b>
									'.$presupuesto.'
								</b>
							</a>  
							<a>
								<b>
									'.$direccion.'
								</b>
							</a>
						</div>
						<div class="pull-right">
							<a href="'.$facebook.'">
								<i class="fa fa-2x fa fa-facebook-square">
							</i>
							</a>  
							<a href="'.$youtube.'">
								<i class="fa fa-2x fa fa-google-plus-square">
							</i>
							</a>  
							<a href="'.$twitter.'">
								<i class="fa fa-2x fa fa-twitter-square">
							</i>
							</a>  
						</div>
					</p>
				</div>	
		</div>	
		<br>
		<hr>

		';

}
?>
	
    <div class="col-md-10 col-md-offset-1">
        <div>
        	<?=$list?>
		</div>        
    </div>