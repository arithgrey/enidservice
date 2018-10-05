<?php
	
	$pendientes ="";	
	/*Metas u objetivos*/	
	$meta_ventas 						= 	0;
	$meta_envios_a_validar 				= 	0;
	$meta_email 						= 	0;
	$meta_llamadas 						=	0; 
	$meta_contactos 					= 	0;
	$meta_accesos 						= 	0; 
	$meta_tareas 						= 	0; 
	$meta_email_registrados 			= 	0; 
	$ventas_enid_service 				= 	$info_notificaciones["ventas_enid_service"];
	$envios_a_validar 					= 	$info_notificaciones["envios_a_validar_enid_service"];
	$email_enviados_enid_service 		= 	$info_notificaciones["email_enviados_enid_service"];
	$llamadas_enid_service 				=  	$info_notificaciones["llamadas_enid_service"];
	$contactos_enid_service 			=  	$info_notificaciones["contactos_enid_service"];
	$accesos_enid_service 				=  	$info_notificaciones["accesos_enid_service"];
	$tareas_enid_service 				=  	$info_notificaciones["tareas_enid_service"];
	$correos_registrados_enid_service 	= 	$info_notificaciones["correos_registrados_enid_service"];  

	$style_pedientes["style"] 	=	'padding:4px;background:red!important;color:white!important;';
	/*Sacamos valores del objetivo*/
	foreach ($info_notificaciones["objetivos_perfil"] as $row) {
		
		/*Meta ventas*/
		switch ($row["nombre_objetivo"]) {
			case "Ventas":
				$meta_ventas = $row["cantidad"];	

				if ($meta_ventas > $ventas_enid_service){						
						
					$ventas_restantes = ($meta_ventas - $ventas_enid_service);					
					$pendientes .= "<li class='black '> ";
					$pendientes .= icon('fa fa-credit-card');
					$pendientes .= "Ventas";							
					$pendientes .= span($ventas_restantes , $style);							
					$pendientes .= "</li>";	
						
				}

					
				break;
			
			case "Envios_a_validar":

				$meta_envios_a_validar = $row["cantidad"];	

				if ($meta_envios_a_validar  > $envios_a_validar){						

					$envios_a_validar_restantes =($meta_envios_a_validar - $envios_a_validar);
					$pendientes .= "<li class='black'>";
					$pendientes .= icon('fa fa-paper-plane');
					$pendientes .= "Envios a validar";
					$pendientes .= span($envios_a_validar_restantes , $style_pedientes);
					$pendientes .= "</li>";									         
				}

				break;

			case "Llamadas":
				$meta_llamadas = $row["cantidad"];	

				
				if($meta_llamadas  > $llamadas_enid_service){						

					$llamadas_restantes  = ($meta_llamadas - $llamadas_enid_service);
					$pendientes 	.= "<li class='black '> ";
					$pendientes 	.= icon('fa fa-mobile');
					$pendientes 	.= "Llamadas";
					$pendientes 	.= span($llamadas_restantes , $style_pedientes);
					$pendientes 	.= "</li>";									         
				}



				break;		
			
			case "contactos":
				$meta_contactos = $row["cantidad"];				

				if($meta_contactos  > $contactos_enid_service){						
						
					$contactos_restantes  = ($meta_contactos - $contactos_enid_service);
					$pendientes .= "<li class='black '> ";
					$pendientes .= icon('fa fa-user');
					$pendientes .= "Contactos";
					$pendientes .= span($contactos_restantes , $style_pedientes);
					$pendientes .= "</li>";									         
				}
				break;		

			case "Email":
				$meta_email = $row["cantidad"];				


				if ($meta_email  > $email_enviados_enid_service){						
					$email_restantes = ($meta_email -  $email_enviados_enid_service);
					$pendientes .= "<li class='black '> ";
					$pendientes .= icon('fa fa-envelope-o');
					$pendientes .= "Email ";
					$pendientes .= span($email_restantes , $style_pedientes);
					$pendientes .= "</li>";									         
				}
				break;

			case "Accesos":
				$meta_accesos = $row["cantidad"];			

				if ($meta_accesos  > $accesos_enid_service){						
					$accesos_restantes  = ($meta_accesos - $accesos_enid_service);
					$pendientes .= "<li class='black '> ";
					$pendientes .= icon('fa fa-globe');
					$pendientes .= "Accesos";
					$pendientes .= span($accesos_restantes , $style_pedientes);
					$pendientes .= "</li>";									         
				}

				break;
			
			case "Desarrollo_web":
				$meta_tareas = $row["cantidad"];				

				if ($meta_tareas  > $tareas_enid_service){						

					$tareas_restantes  = ($meta_tareas - $tareas_enid_service);					
					$pendientes .= "<li class='black '> ";
					$pendientes .= icon('fa fa-code');
					$pendientes .= "Desarrollo web";
					$pendientes .= span($tareas_restantes , $style_pedientes);
					$pendientes .= "</li>";									         
				}



				break;

				case "email_registrados":
				$meta_email_registrados = $row["cantidad"];				

				if ($meta_email_registrados  > $correos_registrados_enid_service){						

					$correos_pendientes  = ($meta_email_registrados - $correos_registrados_enid_service);
					$pendientes .= "<li class='black '> ";
					$pendientes .= "icon('fa fa-code'') ";
					$pendientes .= "Correos por cargar al sistema";
					$pendientes .= span($correos_pendientes , $style_pedientes);
					$pendientes .= "</li>";									         
				}



				break;

			default:
				
				break;
		}
	}
?>
<?=$pendientes;?>