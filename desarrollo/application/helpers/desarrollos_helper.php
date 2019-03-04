<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	if (!function_exists('get_menu')) {
		function get_menu($activa)
		{


			$list = [
				li(
					anchor_enid("ABRIR TICKET",
						[
							"href" => "#tab_nuevo_ticket",
							"data-toggle" => "tab",
							"class" => "a_enid_blue abrir_ticket"
						]),
					["class" => 'black  ' . valida_seccion_activa(3, $activa)]

				),

				li(anchor_enid(
					icon("fa fa-area-chart") . "Métricas",
					[
						"href" => "#tab_charts"
						, "data-toggle" => "tab"
						, "id" => "ver_avances"
						, "class" => 'black strong'
					]), ["class" => 'black top_20 ' . valida_seccion_activa(2, $activa), "style" => 'background:white;']),


				li(
					anchor_enid(icon('fa fa-check-circle') . "Pendientes",
						[
							"href" => "#tab_abrir_ticket"
							, "data-toggle" => "tab"
							, "id" => 'base_tab_clientes'
							, "class" => 'black strong base_tab_clientes'
						]) . place('place_tareas_pendientes'),


					["class" => 'black  ' . valida_seccion_activa(1, $activa), "style" => 'background:white;']
				)


			];

			return ul($list);
		}
	}
	if (!function_exists('get_menu_metricas')) {

		function get_menu_metricas()
		{

			$list = [
				li(
					anchor_enid("Atención al cliente", ["href" => "#tab_1_actividad", "data-toggle" => "tab"]),
					["class" => "active"]
				),
				li(
					anchor_enid("Comparativa", ["href" => "#tab_2_comparativa", "data-toggle" => "tab"]), ["class" => "comparativa"]
				),
				li(
					anchor_enid("Calidad y servicio", ["href" => "#tab_3_comparativa", "data-toggle" => "tab"]), ["class" => "calidad_servicio"]
				)
			];
			return ul($list, ["class" => "nav nav-tabs"]);


		}
	}
}

