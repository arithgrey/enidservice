<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	if (!function_exists('get_format_listado')) {
		function get_format_listado($preguntas_format){

			$r[] =  div(heading_enid("TUS PREGUNTAS ENVIADAS"), ["class" => "col-lg-8 col-lg-offset-2 top_20"]);
			$r[] =  $preguntas_format;
			return append_data($r);


		}

	}
	if (!function_exists('get_format_preguntas')) {
		function get_format_preguntas($preguntas, $es_vendedor )
		{

			$r = [];
			foreach ($preguntas as $row) {

				$pregunta = $row["pregunta"];
				$fecha_registro = $row["fecha_registro"];
				$id_servicio = $row["id_servicio"];
				$id_vendedor = $row["id_vendedor"];
				$id_usuario = $row["id_usuario"];
				$id_pregunta = $row["id_pregunta"];
				$num = $row["num"];


				$p = [];
				$p[] = div($pregunta, ["class" => "texto_pregunta"]);
				$p[] = div(icon("fa fa-clock-o") . $fecha_registro, ["class" => "fecha_registro"]);

				if ($num >  0 ){

					$t  =  ($num >  1 ) ?  $num . " COMENTARIOS" : "1 COMENTARIO ";

					$p[] =  div($t ,
						[
							"class" => "cursor_pointer",
							"onclick" => "carga_respuestas('".$id_pregunta."', '".$es_vendedor."');"
						]);
				}else{

					$p[] =  div(icon("fa fa-comment")." AGREGAR RESPUESTA " ,
						[
							"class" => "cursor_pointer",
							"onclick" => "carga_respuestas('".$id_pregunta."' , '".$es_vendedor."');"
						]);

				}

				$texto = div(append_data($p), ["class" => "bloque_texto top_20"]);
				$img_servicio = anchor_enid(get_img_servicio($id_servicio),
					[
						"href" => get_url_servicio($id_servicio),
						"class" => "anchor_imagen_servicio"

					]);
				$principal_seccion = get_btw(
					div($img_servicio, ["class" => "col-lg-2"]),
					div($texto, ["class" => "col-lg-10"]),
					""
				);


				$id = "pregunta" . $id_pregunta;
				$id_pĺace = "comentarios_" . $id_pregunta;

				$r[] = div($principal_seccion,
					[
						"class" => "descripcion_pregunta top_10 padding_20 col-lg-8 col-lg-offset-2",
						"id" => $id
					]);


				$r[] = div(place($id_pĺace),
					[
						"class" => "top_10 padding_20 col-lg-8 col-lg-offset-2"
					]);




			}


			return div(append_data($r), ["class" => "contenedor_pregunta"]);

		}
	}
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