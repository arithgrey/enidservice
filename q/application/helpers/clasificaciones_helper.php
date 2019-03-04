<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function formatAgregar($param)
	{
		$mas_nivel = "mas_" . $param["nivel"];
		$seleccion = "seleccion_" . $param["nivel"];
		$btn = "<button class='button-op " . $seleccion . "'>AGREGAR A LA LISTA</button>";
		$response = div($btn, ["class" => $mas_nivel]);
		return $response;
	}

	function get_form_clasificacion_talla()
	{

		$r[] = form_open("", ["class" => "form-agregar-clasificacion-talla"]);
		$r[] = input(["type" => "text", "name" => "clasificacion", "placeholder" => "Busca por clasificación"]);
		$r[] = form_close(place("info_tags"));
		return append_data($r);

	}

}
