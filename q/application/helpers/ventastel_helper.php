<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){	

	function get_resumen_venta_usuario($labor_venta){


		$le_interesa  = "";
		$llamar_despues  = "";	
		$no_contesta   = "";
		$venta  = "";		
		$fecha_registro  =  "";	
		$contactos_efectivos = "";
		$referidos = "";
		$envios_a_validacion = "";
		$llamadas = "";
		$contactos_solo_referencia = "";
		$le_interesa = "";
		$l = "";


		$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
		$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
 


		foreach ($labor_venta["resumen"] as $row) {
			
			$fecha_registro =  $row["fecha_registro"];											
			$venta  = $row["clientes"];
			$contactos_efectivos = $row["contactos"];					
			$extra_stilo = "style='font-size:.8em!important;' ";

			
			$l .="<tr>";
				$l.= get_td($fecha_registro ,  $extra_stilo);

				$dia_semana = strtotime($fecha_registro); 

				switch (date('w', $dia_semana)){
				    case 0: $dia_semana =  "Domingo"; break;
				    case 1: $dia_semana =  "Lunes"; break;
				    case 2: $dia_semana =  "Martes"; break;
				    case 3: $dia_semana =  "Miercoles"; break;
				    case 4: $dia_semana =  "Jueves"; break;
				    case 5: $dia_semana =  "Viernes"; break;
				    case 6: $dia_semana =  "Sabado"; break;
				}  


				$l.= get_td($dia_semana ,  $extra_stilo);
				//$l.= get_td($llamadas ,  $extra_stilo);
				

				$l.= get_td( "<a 
									class='tipificacion ventas_info'
									id='".$fecha_registro."'
									contacto_efectivo = '1'
									href='#tab_posibles_clientes' 
	                        		data-toggle='tab'
								>
								". 
									$venta
								."
							</a>" ,  $extra_stilo);								
		


				$l.= get_td( "<a 
									class='tipificacion contactos_info'
									id='".$fecha_registro."'
									contacto_efectivo = '1'
									href='#tab_posibles_clientes' 
	                        		data-toggle='tab'
								>
								". 
								$contactos_efectivos
								."
							</a>" ,  $extra_stilo);								
		
				
			$l .="</tr>";

		}
		return  $l;
	}	

	/**/
}/*Termina el helper*/