<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('invierte_date_time')){	

	
	/**/
	function get_resumen_venta_usuario($labor_venta){

		$le_interesa  = "";
		$llamar_despues  = "";
		$no_le_interesa  = "";
		$no_volver_a_llamar   = "";
		$no_contesta   = "";
		$venta  = "";
		$venta_confirmada = "";
		$fecha_registro  =  "";
		/**/
		$contactos_efectivos = "";
		$referidos = "";
		/**/
		$l = "";
		foreach ($labor_venta["resumen"] as $row) {
			
			$fecha_registro =  $row["fecha_registro"];		
			$le_interesa  = $row["le_interesa"];
			$llamar_despues  = $row["llamar_despues"];
			$no_le_interesa  = $row["no_le_interesa"];
			$no_volver_a_llamar   = $row["no_volver_a_llamar"];
			$no_contesta   = $row["no_contesta"];
			$venta  = $row["venta"];
			$venta_confirmada = $row["venta_confirmada"];
			
			$contactos_efectivos = $row["contactos_efectivos"];
			$referidos = $row["referidos"];



			$l .="<tr>";
				$l .= get_td($fecha_registro);
				$l.= get_td($venta );
				$l.= get_td($venta_confirmada );
				$l.= get_td($contactos_efectivos);
				$l.= get_td($referidos);				
				$l.= get_td($le_interesa );
				$l.= get_td($llamar_despues );
				$l.= get_td($no_le_interesa );
				$l.= get_td($no_volver_a_llamar  );
				$l.= get_td($no_contesta  );
				
			$l .="</tr>";

		}
		return  $l;
	}	
	/**/
	function get_resumen_venta_usuario_periodo($labor_venta){

		$le_interesa  = "";
		$llamar_despues  = "";
		$no_le_interesa  = "";
		$no_volver_a_llamar   = "";
		$no_contesta   = "";
		$venta  = "";
		$venta_confirmada = "";
		$hora_registro ="";
		/**/
		$l = "";
		foreach ($labor_venta["resumen_periodo"] as $row) {
					
			$le_interesa  = $row["le_interesa"];
			$llamar_despues  = $row["llamar_despues"];
			$no_le_interesa  = $row["no_le_interesa"];
			$no_volver_a_llamar   = $row["no_volver_a_llamar"];
			$no_contesta   = $row["no_contesta"];
			$venta  = $row["venta"];
			$venta_confirmada = $row["venta_confirmada"];
			$hora_registro =  $row["hora_registro"];

			$l .="<tr>";

				$l .= get_td($hora_registro);
				$l.= get_td($venta );
				$l.= get_td($venta_confirmada );
				$l.= get_td($le_interesa );
				$l.= get_td($llamar_despues );
				$l.= get_td($no_le_interesa );
				$l.= get_td($no_volver_a_llamar  );
				$l.= get_td($no_contesta  );
				
			$l .="</tr>";

		}
		return  $l;
	}	
	/**/
}/*Termina el helper*/