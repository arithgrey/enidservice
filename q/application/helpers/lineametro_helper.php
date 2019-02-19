<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function create_listado_linea_metro($array)
	{
		$l = "";
		foreach ($array as $row) {

			$nombre = $row["nombre"];
			$id = $row["id"];
			//$numero = $row["numero"];
			$icon = $row["icon"];


			$img = img([
				"src" => $icon,
				"id" => $id,
				"class" => "cursor_pointer linea_metro",
				"nombre_linea" => $nombre
			]);
			$l .= div($img, ["class" => "col-lg-4"]);
		}
		return br() . $l;
	}

	function create_listado_metrobus($array)
	{
		$l = "";
		foreach ($array as $row) {

			$nombre = $row["nombre"];
			$id = $row["id"];
			$numero = $row["numero"];
			//$icon = $row["icon"];


			$linea = div("LINEA " . $numero, [
				"id" => $id,
				"class" => "cursor_pointer linea_metro nombre_linea_metrobus top_20",
				"nombre_linea" => $nombre
			]);

			$l .= div($linea, ["class" => "col-lg-3"]);
		}
		return $l;
	}


}