<?php

	$extra_table="class='blue_enid_background white text-center' style='font-size: .8em;' ";
	$l ="";
	foreach ($saldos_pendientes as $row) {
		
		$proyecto                 		 = $row["proyecto"]; 
		$saldo_cubierto                  = $row["saldo_cubierto"]; 		
		$status                          = $row["status"]; 
		$fecha_vencimiento               = $row["fecha_vencimiento"]; 		
		$monto_a_pagar                   = $row["monto_a_pagar"]; 		
		$razon_social                    = $row["razon_social"]; 		
		
		$ciclo =  $row["ciclo"];
		
		$flag_meses = $row["flag_meses"];
		$num_meses = $row["num_meses"];

		$id_proyecto_persona_forma_pago =  $row["id_proyecto_persona_forma_pago"];

		/**/
		$flag_red = " "; 
		$fecha_actual  =  now_enid();
		
		$servicio_meses ="No aplica";
		if ($flag_meses ==  1) {
			$servicio_meses ="<i class='fa fa-check' ></i>";
		}if($num_meses ==  0) {
			$num_meses ="-";
		}


		$l .="<tr>";									
			$l .= get_td($id_proyecto_persona_forma_pago ,  " ");
			
			$l .= get_td("<i 
							href='#tab_renovar_servicio' 
                        	data-toggle='tab' 
							class='fa fa-file-pdf-o resumen_pagos_pendientes' 
							id='".$id_proyecto_persona_forma_pago."'>							
							</i>" ,  " ");
			$l .= get_td($proyecto ,  " ");

			 $estados = ["Inactivo" , 
		                "Activo" , 
		                "Suspendido" , 
		                "Lista negra" , 
		                "En desarrollo" , 
		                "Próximo a expirar" ,  
		                "Pendiente por liquidar"
                
            	];
            $nuevo_estado =  $estados[$status];

			$l .= get_td($nuevo_estado ,  " class='".$flag_red ."' ");
			
			
			/**/
			$l .= get_td($ciclo ,  " ");
			$l .= get_td($fecha_vencimiento ,  " ");			

			/**/
			
			
			$l .= get_td($monto_a_pagar - $saldo_cubierto ."MXN" ,  "style='font-size:.8em;background:red;color:white!important;' ");
			$l .= get_td($monto_a_pagar ."MXN",  " ");
			
		$l .="</tr>";
	}
	
?>


<div class="contenedor_listado_info contenedor_listado">	
<table class="table table-striped table-bordered text-center" 
		width="100%">
		<thead 
			class='text-center' 
			style='font-size:1em;' >                       		       	   		
			


			<th class="blue_enid_background white text-center" NOWRAP 
				>
				#Recibo
			</th>
			<th 
				class="blue_enid_background white text-center" NOWRAP 			
				>
				Pagar ahora!
			</th>
			
			<th class="blue_enid_background white text-center" NOWRAP 
				>
				Proyecto/Servicio
			</th>	

			<th class="blue_enid_background white text-center" NOWRAP 
				>
				Estado	
			</th>				
			
			<th class="blue_enid_background white text-center" NOWRAP 
				>
				Ciclo facturación
			</th>
			<th class="blue_enid_background white text-center" NOWRAP 
				>
				Próximo vencimiento
			</th>
			
			
				
			<th class="blue_enid_background white text-center" NOWRAP 
				>
				Monto pendiente
			</th>
			<th class="blue_enid_background white text-center" NOWRAP 
				>
				Inversión servicio 
			</th>				
			
		</thead>    
		<?=$l;?>                     
	</table>            
</div>
<style type="text/css">
	.flag_red{
		background: red!important;
		color: white!important;
	}
</style>