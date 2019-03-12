<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	if (!function_exists('get_call_to_action_registro')) {
		function get_call_to_action_registro($in_session)
		{
			if ($in_session != 1) {
				return anchor_enid("ACCEDE A TU CUENTA PARA SOLICITAR INFORMACIÓN!", [], 1);
			}
		}
	}
	function get_view_pregunta($formulario_valoracion, $id_servicio)
	{

		$r[] = br(2);
		$r[] = addNRow(div($formulario_valoracion, ["class" => "col-lg-8 col-lg-offset-2"]));
		$r[] = addNRow(div(div("ENVIAMOS TU PREGUNTA AL VENDEDOR!", ["class" => "blue_enid_background white registro_pregunta display_none padding_10 top_30"]), ["class" => "col-lg-8 col-lg-offset-2"]));
		$r[] = br(5);
		$r[] = addNRow(div(place("place_valoraciones", ["id" => "place_valoraciones"]), ['class' => "col-lg-8 col-lg-offset-2", "style" => "background: white;"], 1), ["style" => "background: #002693;"]);
		$r[] = br(5);
		$r[] = div(place("place_tambien_podria_interezar", ["id" => "place_tambien_podria_interezar"]), ['class' => "col-lg-10 col-lg-offset-1"], 1);
		$r[] = input_hidden(["class" => "servicio", "value" => $id_servicio]);
		return append_data($r);
	}

}