<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
	if (!function_exists('valida_valor_por_fecha')) {
		function valida_valor_por_fecha($fecha_actual, $key, $data)
		{
			$num = 0;
			foreach ($data as $row) {
				$fecha = $row["fecha"];
				if ($fecha_actual == $fecha) {
					$num = $row[$key];
					break;
				}
			}
			return $num;
		}
	}

}