<?php
	
	$extra_principal =" style='font-size:.8em!important;'  class='strong white' ";
	$extra_simple ="style='font-size:.8em!important;background:white;padding:5px;' ";
	/**/
	$fecha_vencimiento =  $historial_pagos[0]["fecha_vencimiento"]; 	
	/*Monto del servicio*/
	$monto_servicio =  $historial_pagos[0]["monto_a_pagar"];
	$nombre_cliente = $info_persona[0]["nombre"] ." " . 
	$info_persona[0]["a_paterno"] . " " . 
	$info_persona[0]["a_materno"];	
	/**/
		$fecha_inicio = "";
		$precio = "";
		$ciclo = "";
		$siguiente_vencimiento = "";
		$estado = "";
		$detalles = "";
		$IVA = "";
		$total = "";
		$proyecto = "";
		$descripcion = "";
		$url = "";
		$url_img = "";
		$id_servicio = ""; 	
		$dias_restantes_vencimiento =  "";	

	foreach ($info_proyecto as $row) {
		
			$fecha_inicio =  $row["fecha_inicio"]; 
			$precio =  $row["precio"]; 
			$ciclo =  $row["ciclo"]; 
			$siguiente_vencimiento =  $row["siguiente_vencimiento"]; 
			$estado =  $row["estado"]; 
			$detalles =  $row["detalles"]; 		
			$proyecto =  $row["proyecto"]; 
			$descripcion =  $row["descripcion"]; 		
			$url =  $row["url"]; 
			$id_servicio =  $row["id_servicio"];
			$ciclo_facturacion =  $row["ciclo_facturacion"];			
			$dias_restantes_vencimiento =  $row["dias_restantes_vencimiento"];
			$total = $row["total"];
	}
?>

<?=n_row_12()?>
                
                    <div class="col-lg-10 col-lg-offset-1">
	                    <div class="col-lg-4">
	                   		<img src="../img_tema/enid_service_logo.jpg" style="width: 100%">
	                    </div>
	                    <div class="col-lg-8">
	                        <div class="plan-header">
	                            <div class="mb30">
	                                <span class="badge badge-primary">
	                                    <?=$nombre_cliente;?>
	                                </span>
	                        </div>
	                            <h4>
	                            	<?=$proyecto;?>
	                            </h4>
	                            <h1 class="text-primary">$
	                            	<?=$total;?>
	                            	<small>
	                            	/ <?=$ciclo?>	                            		
	                            </small>
	                            </h1>
	                            <div 
	                            	style="background: #ebedf5;
											font-size: .8em;
											padding: 5px;">
	                            	<?=$detalles;?>
	                            </div>
	                        </div>
	                        <a href="#" class="btn btn-primary btn-lg btn-block" style="background: #0400BD!important"><?=$estado;?></a>
	                        <ul class="list-unstyled">
		                            <li >
		                                <i class="fa fa-check-circle-o">
		                            	</i>  
		                            	Solicitud
		                            	<strong>
		                            		<?=$fecha_inicio?>                            		
		                            	</strong>
		                        	</li>
		                            <li  >
		                                <i class="fa fa-check-circle-o">
		                            	</i> Vencimiento
		                            	<strong>
		                            		<?=$fecha_vencimiento;?>
		                            	</strong>
		                        	</li>
		                            <li  >
	                                <i class="fa fa-check-circle-o">
	                            	</i>
	                            		Próximo vencimiento(días)		
	                            		<strong>
	                            			<?=$dias_restantes_vencimiento;?>
	                            		</strong> 
									</li>
	                            
	                        </ul>
	                    </div>
                    </div>                
<?=end_row()?>
<?=n_row_12()?>

<?php 
if ($info_request["area_cliente"] !=  1 ) {
	
	$this->load->view("ventas/info_pagos");
}
?>

<?=end_row()?>