<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	if (!function_exists('get_top_ventas')) {
		function get_top_ventas($top_servicios)
		{

			$response = [];
			foreach ($top_servicios as $row) {

				$url = "../producto/?producto=" . $row['id_servicio'];
				$nombre = $row["nombre_servicio"];
				$titulo_corto = substr($nombre, 0, 18) . "...";
				$articulo = (strlen($nombre) > 18) ? $titulo_corto : $nombre;
				$link_articulo =
					anchor_enid($articulo,
						['href' => $url, 'class' => 'black'], 1);


				$response[] = get_btw(
					$link_articulo,
					$row["vistas"],
					"display_flex_enid");

			}

			return append_data($response);

		}

	}
	if (!function_exists('get_format_articulos_venta')) {

		function get_format_articulos_venta($list_orden)
		{

			$r[] = heading_enid("TUS ARTÍCULOS EN VENTA", 3);
			$r[] = div(get_format_busqueda($list_orden), ["class" => "contenedor_busqueda_articulos row top_50"]);
			$r[] = div(place("place_servicios top_50"),1);
			return append_data($r);

		}
	}
	if (!function_exists('get_format_busqueda')) {
		function get_format_busqueda($list_orden)
		{

			$r[] = div("BUSCAR ENTRE TUS ARTÍCULOS", ["class"=>"col-lg-4 align-self-center"]);
			$r[] = div(get_list_orden($list_orden), 4);
			$r[] = div(input([
				"id" => "textinput",
				"name" => "textinput",
				"placeholder" => "Nombre de tu producto o servicio",
				"class" => "form-control input-sm q_emp",
				"onkeyup" => "onkeyup_colfield_check(event);"
			]),
				4);
			return div(append_data($r),["class"=>"--"]);

		}

	}
	if (!function_exists('get_list_orden')) {
		function get_list_orden($list_orden)
		{

			$r[] = '<select class="form-control" name="orden" id="orden">';
			$a = 1;
			foreach ($list_orden as $row) {
				$r[] = '<option value="' . $a . '">';
				$r[] = $row;
				$r[] = '</option>';
				$a++;
			}
			$r[] = '</select>';

			return append_data($r);

		}


	}
	if (!function_exists('get_top_articulos')) {
		function get_top_articulos($top_servicios, $is_mobile)
		{

			$response = "";
			if (count($top_servicios) > 0 && $is_mobile > 0) {

				$r = [];
				foreach ($top_servicios as $row):

					$r[] = icon("fa fa-angle-right");
					$articulo = (trim(strlen($row["nombre_servicio"])) > 22) ? substr($row["nombre_servicio"], 0, 22) . "..." : strlen($row["nombre_servicio"]);
					$r[] = $articulo;
					$r[] = div(span($row["vistas"], ["class" => "a_enid_black_sm_sm"]),
						[
							"class" => "pull-right",
							"title" => "Personas que han visualizado este  producto"
						]);


					$r[] = anchor_enid(append_data($r), ["href" => "../producto/?producto=" . $row['id_servicio']]);
				endforeach;


				if (count($top_servicios) > 0) {

					array_pop($r, heading_enid("TUS ARTÍCULOS MÁS VISTOS DE LA SEMANA", 2));
				}

				$response = div(append_data($r), ["class" => "card contenedor_articulos_mobil"]);

			}
			return $response;
		}
	}
	if (!function_exists('get_selector_categoria')) {
		function get_selector_categoria($is_mobile)
		{

			$r = [];
			if ($is_mobile > 0) {


				$r[] = heading_enid('SELECIONA LAS CATEGORÍAS', 3);
				$r[] = hr();
				$r[] = get_places(0);


			} else {


				$r[] = heading_enid("GRUPO AL CUAL PERTENECE TU PRODUCTO", 3);
				$r[] = anchor_enid(
					"CANCELAR",
					[
						"class" => "cancelar_registro",
						"style" => "color: white!important"
					],
					1);
				$r[] = hr();
				$r[] = get_places();


			}

			return div(append_data($r), ["class" => "contenedor_categorias_servicios"]);

		}
	}
	if (!function_exists('get_formar_hiddens')) {

		function get_formar_hiddens($is_mobile, $action, $extra_servicio)
		{


			$r[] = input_hidden(
				[

					"name" => "version_movil",
					"value" => $is_mobile,
					"class" => 'es_movil'
				]
			);
			$r[] = input_hidden(
				[

					"value" => $action,
					"class" => "q_action"
				]
			);
			$r[] = input_hidden(
				[

					"value" => $extra_servicio,
					"class" => "extra_servicio"
				]
			);

			return append_data($r);

		}
	}
	if (!function_exists('get_places')) {
		function get_places($class = 1)
		{

			$response = "";
			if ($class > 0) {

				$text = append_data(
					[
						div(place("primer_nivel_seccion"), ["class" => "info_categoria"]),
						div(place("segundo_nivel_seccion"), ["class" => "info_categoria"]),
						div(place("tercer_nivel_seccion"), ["class" => "info_categoria"]),
						div(place("cuarto_nivel_seccion"), ["class" => "info_categoria"]),
						div(place("quinto_nivel_seccion"), ["class" => "info_categoria"]),
						div(place("sexto_nivel_seccion"), ["class" => "info_categoria"])
					]

				);

				$response = addNRow($text);


			} else {
				$response = ul([
					place("primer_nivel_seccion"),
					place("segundo_nivel_seccion"),
					place("tercer_nivel_seccion"),
					place("cuarto_nivel_seccion"),
					place("quinto_nivel_seccion"),
					place("sexto_nivel_seccion")

				]);
			}

			return $response;

		}

	}
	if (!function_exists('valida_action')) {
		function valida_action($param, $key)
		{

			$action = 0;
			if (get_param_def($param, $key) !== 0) {
				$action = $param[$key];
				switch ($action) {
					case 'nuevo':
						$action = 1;
						break;
					case 'vender':
						$action = 1;
						break;
					case 'lista':
						$action = 0;
						break;
					case 'editar':
						$action = 2;
						break;
					default:
						break;
				}
			}
			return $action;
		}
	}
	if (!function_exists('valida_active_tab')) {
		function valida_active_tab($seccion, $valor_actual, $considera_segundo = 0)
		{
			$response = " active ";
			if ($considera_segundo == 0) {
				$response = ($seccion == $valor_actual) ? " active " : "";
			}
			return $response;
		}
	}
	if (!function_exists('get_menu')) {
		function get_menu($is_mobile, $action)
		{
			if ($is_mobile == 0) {
				$list = [
					li(
						anchor_enid(
							icon('fa fa-cart-plus') . " VENDER PRODUCTOS ",
							[
								"href" => "../planes_servicios/?action=nuevo",
								"class" => "agregar_servicio btn_agregar_servicios"
							]
						),
						["class" => valida_active_tab('nuevo', $action) . " li_menu "]
					),

					li(
						anchor_enid(
							icon("fa fa-shopping-cart") . " TUS ARTÍCULOS EN VENTA",
							[
								'data-toggle' => "tab",
								'class' => "black  btn_serv",
								'href' => "#tab_servicios"
							]
						),
						["class" => 'li_menu li_menu_servicio btn_servicios ' . valida_active_tab('lista', $action)]
					)
				];
				return ul($list, ["class" => "nav tabs contenedor_menu_enid_service_lateral"]);
			} else {

				$list = [
					li(
						anchor_enid(
							"",
							[
								"href" => "../planes_servicios/?action=nuevo",
								"class" => "agregar_servicio btn_agregar_servicios"
							]
						),
						["class" => valida_active_tab('nuevo', $action)]
					),

					li(anchor_enid(
						"",
						[
							'data-toggle' => "tab",
							'class' => "black  btn_serv",
							'href' => "#tab_servicios"
						]
					),
						["class" => "li_menu li_menu_servicio btn_servicios " . valida_active_tab('lista', $action)]
					)

				];
				return ul($list, ["class" => "nav tabs contenedor_menu_enid_service_lateral"]);

			}
		}
	}

}