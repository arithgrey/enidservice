<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


	function get_format_faq_categorias($faqs_categoria)
	{

		$r = [];
		$z = 1;
		foreach ($faqs_categoria as $row) {

			$titulo = $row["titulo"];
			$id_faq = $row["id_faq"];
			$href = "?faq=" . $id_faq;
			$source = "../imgs/index.php/enid/img_faq/" . $id_faq;

			$x[] = div($z, ["class" => "day"]);
			$x[] = img($source);
			$x[] = heading($titulo);
			$text = ul(li(append_data($x)) , ["class"=>"event-list" ]);
			$r[] =  anchor_enid($text, ["href" => $href]);
			$z++;
		}

		return div(append_data($r));
	}

	function get_formar_respuesta($respuesta, $in_session, $perfil)
	{

		$r = [];
		foreach ($respuesta as $row) {
			$titulo = $row["titulo"];
			$respuesta = $row["respuesta"];
			$id_faq = $row["id_faq"];

			$btn_conf = "";
			if ($in_session > 0 && $perfil != 20 && $perfil != 19 && $perfil != 17) {

				$btn_conf = anchor_enid("", [
					"href" => '#tab2default',
					"data-toggle" => 'tab',
					"class" => 'btn_edicion_respuesta fa fa-cog',
					"id" => $id_faq]);
			}
			$response = div(div($btn_conf . $titulo), ["class" => "row"]);
			$r[] = $response;
			$r[] = $respuesta;

		}
		return div(append_data($r));

	}

	function get_format_menu($in_session, $perfil)
	{

		return ul([
			anchor_enid("CATEGORIAS", ["href" => "../faq", "class" => "text_categorias"]),

			anchor_enid(
				icon("fa fa-question-circle") .
				"PREGUNTAS FRECUENTES",
				[
					"href" => "#tab1default",
					"data-toggle" => "tab"
				])
			,
			get_btn_registro_faq($in_session, $perfil)
		], ["class" => "nav nav-tabs"]

		);

	}

	function get_info_serviciosq($q)
	{
		$status = (isset($q) && strlen($q) > 0) ? 1 : 0;
		return $status;
	}

	function get_info_categoria($q)
	{

		$status = (isset($q) && strlen($q) > 0) ? 1 : 0;
		return $status;
	}

	function get_btn_registro_faq($in_session, $perfil)
	{

		$response = "";
		if ($in_session == 1) {

			if ($perfil != 20 && $perfil != 19 && $perfil != 17) {
				$response = anchor_enid(icon("fa fa-plus-circle") . "AGREGAR",
					[
						"href" => "#tab2default",
						"id" => "enviados_a_validacion",
						"data-toggle" => "tab",
						"class" => "btn_registro_respuesta "
					]);

			}

		}
		return $response;
	}

	function lista_categorias($categorias)
	{

		$l = [];
		foreach ($categorias as $row) {

			$id_categoria = $row["id_categoria"];
			$nombre_categoria = $row["nombre_categoria"];
			$faqs = $row["faqs"];
			$href = "?categoria=" . $id_categoria;
			$link = anchor_enid(div($nombre_categoria . "(" . $faqs . ")"), ["href" => $href]);
			$l[] = div($link, ["class" => "col-lg-4"]);
		}
		return append_data($l);
	}
}