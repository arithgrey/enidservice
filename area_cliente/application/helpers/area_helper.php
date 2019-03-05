<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


	if (!function_exists('get_hiddens_tickects')) {

		function get_hiddens_tickects($action, $ticket)
		{
			return append_data([
				input_hidden(["class" => "action", "value" => $action]),
				input_hidden(["class" => "ticket", "value" => $ticket])
			]);
		}
	}
	if (!function_exists('get_format_buzon')) {

		function get_format_buzon()
		{

			$r[] = heading_enid("BUZÓN", 3);
			$r[] = hr();
			$r[] = div(append_data(

				anchor_enid("HECHAS" .
					span("", ['class' => 'notificacion_preguntas_sin_leer_cliente']),
					["class" => "a_enid_black preguntas btn_preguntas_compras",
						"id" => '0'
					]
				)
				,

				anchor_enid(
					"RECIBIDAS" .
					span("", ['class' => 'notificacion_preguntas_sin_leer_ventas'])
					,
					[
						"class" => "a_enid_blue preguntas ",
						"id" => "1"
					])

			));

			$r[] = place("place_buzon");

			return append_data($r);

		}
	}
	if (!function_exists('get_format_valoraciones')) {
		function get_format_valoraciones($valoraciones, $id_usuario, $alcance)
		{


			$r[] = place("place_ventas_usuario col-lg-9");
			$x[] = heading_enid("MIS VALORACIONES Y RESEÑAS RECIBIDAS", 3);
			$x[] = $valoraciones;
			$x[] = br(2);

			$url = "../recomendacion/?q=" . $id_usuario;
			$x[] = div(
				anchor_enid("VER COMENTARIOS",
					[
						"href" => $url,
						"class" => "a_enid_blue "
					]
				), ["class" => "text-center"]);
			$x[] = div($alcance, ["class" => " text-center "]);
			$r[] = div(append_data($x), ["class" => "col-lg-3"]);

			return div(append_data($r), ["class" => "text-center"]);

		}
	}
	function crea_alcance($alcance)
	{

		$response = "";
		if (is_array($alcance) && count($alcance) > 0) {
			$maximo = $alcance[0]["maximo"];
			$minimo = $alcance[0]["minimo"];
			$promedio = $alcance[0]["promedio"];

			$r[] = heading_enid("ALCANCE DE TUS PRODUCTOS", 3);
			$r[] = "<table>";
			$r[] = "<tr>";
			$r[] = get_td($maximo, ["class" => 'num_alcance', "id" => $maximo]);
			$r[] = get_td($promedio, ["class" => 'num_alcance']);
			$r[] = get_td($minimo, ["class" => 'num_alcance', "id" => $maximo]);
			$r[] = "</tr>";

			$r[] = "<tr>";
			$r[] = get_td("Tope", ["class" => 'num_alcance']);
			$r[] = get_td("Promedio", ["class" => 'num_alcance']);
			$r[] = get_td("Mínimo", ["class" => 'num_alcance']);
			$r[] = "</tr>";
			$r[] = "</table>";
			$response = append_data($r);
		}
		return $response;

	}

	function valida_active_tab($nombre_seccion, $estatus)
	{

		if (strlen($estatus) > 0) {
			$status = ($nombre_seccion == $estatus) ? " active " : "";
		} else {
			$status = ($nombre_seccion == "compras") ? " active " : "";
		}
		return $status;
	}

	function get_menu($action)
	{
		$a_tab_pagos = anchor_enid("",
			[
				"href" => "#tab_pagos",
				"data-toggle" => "tab",
				"class" => 'black strong tab_pagos',
				"id" => 'btn_pagos'
			]);

		$a_vendedor = anchor_enid("VENDER",
			[
				"href" => "../planes_servicios/?action=nuevo",
				"class" => "white",
				"style" => "color: white!important"
			]);

		$icon = icon('fa fa-shopping-bag');
		$place_mis_ventas = place("place_num_pagos_notificados");
		$a_mis_ventas = anchor_enid($icon . "TUS VENTAS" . $place_mis_ventas,
			["id" => "mis_ventas",
				"href" => "#tab_mis_ventas",
				"data-toggle" => "tab",
				"class" => 'black strong btn_mis_ventas']);


		$icon = icon('fa fa-credit-card-alt');
		$place = place("place_num_pagos_por_realizar");
		$a_mis_compras = anchor_enid($icon . "TUS COMPRAS" . $place,
			["id" => "mis_compras", "href" => "#tab_mis_pagos", "data-toggle" => "tab", "class" => 'black strong btn_cobranza mis_compras']);

		$a_lista_deseo = anchor_enid(icon("fa fa-gift") . "LISTA DE DESEOS",
			["href" => "../lista_deseos/", "class" => 'black strong']);


		$list = [
			li($a_tab_pagos, ["class" => 'li_menu', "style" => "display: none;"]),
			li($a_vendedor, ["class" => "li_menu menu_vender " . valida_active_tab('ventas', $action)]),
			li($a_mis_ventas, ["class" => 'li_menu']),
			li($a_mis_compras, ["class" => 'li_menu ' . valida_active_tab('compras', $action)]),
			li($a_lista_deseo, ["class" => 'li_menu'])

		];
		return ul($list, ["class" => "nav tabs"]);
	}

}