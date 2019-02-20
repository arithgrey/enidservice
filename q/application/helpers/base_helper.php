<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
	function valida_active($num, $num_tab)
	{
		if ($num == $num_tab) {
			return ' class="active" ';
		}
	}
	function lista_categorias($categorias)
	{

		$l = "";
		foreach ($categorias as $row) {

			$id_categoria = $row["id_categoria"];
			$nombre_categoria = $row["nombre_categoria"];
			$faqs = $row["faqs"];
			$href = "?categoria=" . $id_categoria;
			$text_lista = icon("fa fa-file-text-o") . span($nombre_categoria . "(" . $faqs . ")");
			$link = anchor_enid($text_lista, ['href' => $href]);
			$l .= div($link, ["class" => "col-lg-4"]);
		}
		return $l;
	}

	function create_meta_tags($string, $id_servicio)
	{

		$tags = explode(",", $string);
		$lista_tags = "";
		foreach ($tags as $row) {

			$icon = icon('fa fa-times');
			$lista_tags .= div($icon . $row,
				[
					"class" => 'tag_servicio btn btn-primary btn-sm',
					"id" => $row,
					"onclick" => "eliminar_tag('" . $row . "' ,  '" . $id_servicio . "' );"

				]);

		}
		return $lista_tags;
	}

	function valida_active_pane($num, $num_tab)
	{

		if ($num == $num_tab) {
			return ' active ';
		}
	}

	function valida_existencia_imagenes($num_images)
	{
		return ($num_images > 0) ? "" : " display:none; ";
	}

	function text_agregar_telefono($has_phone, $telefono_visible)
	{

		$link = "";
		if ($has_phone == 0) {

			$link = anchor_enid('INDICA TU NÚMERO TELEFÓNICO', ['href' => '../administracion_cuenta/']);

		}
		return $link;
	}

	function valida_activo_ventas_mayoreo($estado_actual, $ventas_mayoreo)
	{

		if ($estado_actual == $ventas_mayoreo) {
			return "button_enid_eleccion_active";
		}
	}


	function valida_activo_vista_telefono($valor, $valor_usuario)
	{

		$v = ($valor == $valor_usuario) ? "button_enid_eleccion_active" : "";
		return $v;
	}

	function valida_activo_entregas_en_casa($valor, $valor_usuario)
	{

		if ($valor == $valor_usuario) {
			return "button_enid_eleccion_active";
		}
	}

	function valida_text_imagenes($tipo_promocion, $num_images)
	{

		$tipo_promocion = strtoupper($tipo_promocion);
		if ($num_images == 0) {


			$msj = "MUESTRA IMAGENES SOBRE TU " . $tipo_promocion . " A TUS CLIENTES";
			$text = heading_enid($msj, 4, ["class" => 'mensaje_imagenes_visible'], 1);
			$notificacion = "TU " . $tipo_promocion . " NO SERÁ VISIBLE HASTA QUE INCLUYAS ALGUNAS IMÁGENES";
			$text .= div($notificacion, ["class" => "notificacion_publicar_imagenes"], 1);
			return $text;
		}
	}

	function valida_descartar_promocion($num_images, $id_servicio)
	{

		if ($num_images == 0) {
			return div(anchor_enid("DESCARTAR PROMOCIÓN", ["class" => 'descartar_promocion', "id" => $id_servicio]), ["class" => "text-right"]) . br(2);
		}
	}

}
