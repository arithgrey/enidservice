<?php
$list  =  "";
foreach ($cotizaciones as $row) {

	$id_contacto       =  $row["id_contacto"];
	$nombre            =  $row["nombre"];
	$email             =  $row["email"];
	$mensaje           =  $row["mensaje"];
	$fecha_registro    =  $row["fecha_registro"];	
	$telefono          =  $row["telefono"];
	

	$list .= "<div class='cta-skin contact-info'>
				<div class='row'>
					<div class='col-sm-12 text-left'>
						<span style='background:#000;color:white;padding:5px;' class='strong'>
							#".$id_contacto."
						</span>
					</div>
	            </div>
	            <div class='container' style='background:#0044bc;color:white;'>
	                <div class='row'>

	                    <div class='col-sm-4 margin-b-30'>

	                        <div class='overflow-hidden'>
	                            <h4 class='white'>Email</h4>
	                            <p class='lead ' style='font-size:.8em;'>
	                                ".$email."
	                            </p>
	                        </div>
	                    </div>
	                    <div class='col-sm-4 margin-b-30'>
	                        <i class='ion-email'></i>
	                        <div class='overflow-hidden'>
	                            <h4 class='white'>Teléfono</h4>
	                            <p class='lead' style='font-size:.8em;'>
	                               ".$telefono."
	                            </p>
	                        </div>
	                    </div>
	                    <div class='col-sm-4 margin-b-30'>
	                        <i class='ion-map'></i>
	                        <div class='overflow-hidden'>
	                            <h4 class='white'>Nombre</h4>
	                            <p class='lead' style='font-size:.8em;'>
	                               ".$nombre."
	                            </p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class='container'>

	            	<div class='panel' style='font-size:.8em;padding:15px;' >
	            		".$mensaje  ."
	            	</div>
	            </div>
	        </div>";
	

}
?>
<?=n_row_12()?>	
	<div class="col-lg-8 col-lg-offset-2">
		<?=$list?>
	</div>
<?=end_row()?>
