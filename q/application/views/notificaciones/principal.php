<?php
	
	$lista_pendientes ="";	
	/*Metas u objetivos*/	
	$meta_ventas = 0;
	$meta_envios_a_validar = 0;
	$meta_email = 0;
	$meta_llamadas =0; 
	$meta_contactos = 0;
	$meta_accesos = 0; 
	$meta_tareas = 0; 
	$meta_email_registrados = 0; 

	$ventas_enid_service = $info_notificaciones["ventas_enid_service"];
	$envios_a_validar = $info_notificaciones["envios_a_validar_enid_service"];
	$email_enviados_enid_service = $info_notificaciones["email_enviados_enid_service"];
	$llamadas_enid_service =  $info_notificaciones["llamadas_enid_service"];
	$contactos_enid_service =  $info_notificaciones["contactos_enid_service"];
	$accesos_enid_service =  $info_notificaciones["accesos_enid_service"];
	$tareas_enid_service =  $info_notificaciones["tareas_enid_service"];
	$correos_registrados_enid_service = $info_notificaciones["correos_registrados_enid_service"];  

	$style_pedientes ="style='padding:4px;background:red!important;color:white!important;'";
	/*Sacamos valores del objetivo*/
	foreach ($info_notificaciones["objetivos_perfil"] as $row) {
		
		/*Meta ventas*/
		switch ($row["nombre_objetivo"]) {
			case "Ventas":
				$meta_ventas = $row["cantidad"];	

					if ($meta_ventas > $ventas_enid_service){						
						
						$ventas_restantes = ($meta_ventas - $ventas_enid_service);
						
							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-credit-card'></i> ";
							$lista_pendientes .= "Ventas";							
							$lista_pendientes .= "<span $style_pedientes>".
													$ventas_restantes
													."</span>"; 
							$lista_pendientes .= "</li>";	
						
					}

					
				break;
			
			case "Envios_a_validar":

				$meta_envios_a_validar = $row["cantidad"];	

					if ($meta_envios_a_validar  > $envios_a_validar){						

						$envios_a_validar_restantes =($meta_envios_a_validar - $envios_a_validar);

							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-paper-plane'></i> ";
							$lista_pendientes .= "Envios a validar";
							$lista_pendientes .= "<span $style_pedientes>".
													$envios_a_validar_restantes
												."</span>"; 
							$lista_pendientes .= "</li>";									         
					}

				break;

			case "Llamadas":
				$meta_llamadas = $row["cantidad"];	

				
					if($meta_llamadas  > $llamadas_enid_service){						

							$llamadas_restantes = ($meta_llamadas - $llamadas_enid_service);

							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-mobile'></i> ";
							$lista_pendientes .= "Llamadas";
							$lista_pendientes .= "<span $style_pedientes>
													".
													$llamadas_restantes
													."</span>"; 
							$lista_pendientes .= "</li>";									         
					}



				break;		
			
			case "contactos":
				$meta_contactos = $row["cantidad"];				

				if($meta_contactos  > $contactos_enid_service){						
						
						$contactos_restantes  = ($meta_contactos - $contactos_enid_service);

						$lista_pendientes .= "<li class='black '> ";
						$lista_pendientes .= "<i class='fa fa-user'></i> ";
						$lista_pendientes .= "Contactos";
						$lista_pendientes .=  "<span $style_pedientes>".
												$contactos_restantes
											 ."</span>"; 
						$lista_pendientes .= "</li>";									         
				}



				break;		

			case "Email":
				$meta_email = $row["cantidad"];				


				if ($meta_email  > $email_enviados_enid_service){						
						$email_restantes = ($meta_email -  $email_enviados_enid_service);
							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-envelope-o'></i> ";
							$lista_pendientes .= "Email ";
							$lista_pendientes .= "<span $style_pedientes>".$email_restantes
												."</span>"; 
							$lista_pendientes .= "</li>";									         
					}


				break;

			case "Accesos":
				$meta_accesos = $row["cantidad"];			




				if ($meta_accesos  > $accesos_enid_service){						

					$accesos_restantes  = ($meta_accesos - $accesos_enid_service);



							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-globe'></i> ";
							$lista_pendientes .= "Accesos";
							$lista_pendientes .= "<span $style_pedientes>".$accesos_restantes.
												 "</span>"; 
							$lista_pendientes .= "</li>";									         
					}


				break;
			
			case "Desarrollo_web":
				$meta_tareas = $row["cantidad"];				

				if ($meta_tareas  > $tareas_enid_service){						

					$tareas_restantes  = ($meta_tareas - $tareas_enid_service);
					



							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-code'></i> ";
							$lista_pendientes .= "Desarrollo web";
							$lista_pendientes .= "<span $style_pedientes>
														". $tareas_restantes
														."
												</span>"; 
							$lista_pendientes .= "</li>";									         
				}



				break;

				case "email_registrados":
				$meta_email_registrados = $row["cantidad"];				

				if ($meta_email_registrados  > $correos_registrados_enid_service){						

					$correos_pendientes  = 
					($meta_email_registrados - $correos_registrados_enid_service);
					



							$lista_pendientes .= "<li class='black '> ";
							$lista_pendientes .= "<i class='fa fa-code'></i> ";
							$lista_pendientes .= "Correos por cargar al sistema";
							$lista_pendientes .= "<span $style_pedientes>
														". $correos_pendientes
														."
												</span>"; 
							$lista_pendientes .= "</li>";									         
				}



				break;

			default:
				
				break;
		}

	}
	


?>



<?=$lista_pendientes;?>