<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	if (!function_exists('get_format_temas_ayuda')) {
		function get_format_temas_ayuda()
		{
			$r[] = heading_enid("TEMAS DE AYUDA", 3);
			$r[] = heading_enid("¿Tienes alguna duda?", 4);
			$r[] = p("¡Llámanos! Podemos ayudarte." . icon('fa icon-mobile contact'));
			$r[] = anchor_enid(
				"",
				[
					"class" => "black strong",
					"target" => "_blank",
					"href" => "tel:5552967027"
				]);
			$r[] = div("De Lunes a Viernes de 8:00 a 19:00 y Sábados de 09:00 a 18:00.", 1);
			$r[] = div("Podemos utilizar tu correo para mantenerte informado..", 1);
			$r[] = div("O si lo prefieres Comunícate directamente", 1);

			$r[] = anchor_enid(
				"FAQS",
				["href" => "../faq/?categoria=5", "class" => "top_20"],
				1,
				1,
				1
			);

			return append_data($r);

		}
	}

}