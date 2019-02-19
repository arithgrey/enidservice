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


	/*

	function valida_url_youtube($url_youtube){

	  $url ="";
	  if(strlen($url_youtube)>5){
		$url = "<iframe width='560'
				height='315' src='".$url_youtube."'
				frameborder='0'
				allow='autoplay; encrypted-media' allowfullscreen>
				</iframe>";
	  }
	  return $url;
	}

	function get_table_porcentaje_servicios($data){

	  $extra ="";
	  $list ="";
	  foreach($data as $row){

		$id_servicio =  $row["id_servicio"];
		$nombre_servicio = $row["nombre_servicio"];
		$descripcion  =  $row["descripcion"];
		$porcentaje_ganancia_venta =  $row["porcentaje_ganancia_venta"];

		$list .="<tr>";
		  $list .=get_td($id_servicio , $extra);
		  $list .=get_td($nombre_servicio , $extra);
		  $list .=get_td($porcentaje_ganancia_venta ."%" , $extra);
		$list .="</tr>";
	  }
	  return  $list;
	}

	*/
}