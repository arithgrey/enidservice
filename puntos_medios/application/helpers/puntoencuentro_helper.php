<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function get_format_pagina_form_horario($recibo, $punto_encuentro)
	{

		$response = get_form_punto_encuentro_horario([
			input_hidden([
				"class" => "recibo",
				"name" => "recibo",
				"value" => $recibo
			]),

			input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro])
		]);

		$response =  div($response , ["class"=>"col-lg-6 col-lg-offset-3"]);
		return $response;
	}

	function get_form_punto_encuentro($num_ciclos, $in_session, $servicio)
	{
		$r[] = form_open("", ["class" => "form-horizontal form_punto_encuentro"]);
		$r[] = label(" NOMBRE ", ["class" => "col-lg-3 "]);
		$r[] = div(input([
			"id" => "nombre",
			"name" => "nombre",
			"type" => "text",
			"placeholder" => "Persona que recibe",
			"class" => "form-control input-md nombre",
			"required" => true
		]), ["class" => "col-lg-9"]);

		$r[] = label("CORREO ", ["class" => "col-lg-3 "]);
		$r[] = div(input([
			"id" => "correo",
			"name" => "email",
			"type" => "email",
			"placeholder" => "@",
			"class" => "form-control input-md correo",
			"required" => true
		]), ["class" => "col-lg-9"]);

		$r[] = label(" TELÉFONO ", ["class" => "col-lg-3 "]);
		$r[] = div(input([
			"id" => "tel",
			"name" => "telefono",
			"type" => "tel",
			"class" => "form-control input-md  telefono",
			"required" => true
		]), ["class" => "col-lg-9"]);

		$r[] = label(" CONTRASEÑA", ["class" => "col-lg-3 "]);

		$r[] = div(input([
			"id" => "pw",
			"name" => "password",
			"type" => "password",
			"class" => "form-control input-md  pw",
			"required" => true
		]), ["class" => "col-lg-9"]);

		$r[] = br(2);
		$r[] = div(heading_enid("¿En qué horario te gustaría recibir tu pedido?",
			4,
			["class" => "strong pull-right"]), ["class" => "col-lg-12"]);

		$r[] = label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-2 "]);

		$r[] = div(input(
			[
				"data-date-format" => "yyyy-mm-dd",
				"name" => 'fecha_entrega',
				"class" => "form-control input-sm ",
				"type" => 'date',
				"value" => date("Y-m-d"),
				"min" => date("Y-m-d"),
				"max" => add_date(date("Y-m-d"), 4)
			]), ["class" => "col-lg-8"]);

		$r[] = label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO",
			["class" => "col-lg-4 "]
		);
		$r[] = div(lista_horarios(), ["class" => "col-lg-8"]);

		$r[] = div("+ agregar nota", ["class" => "col-lg-12 cursor_pointer text_agregar_nota", "onclick" => "agregar_nota();"]);
		$r[] = get_btw(
			div("NOTAS", ["class" => "strong col-lg-12"]),
			textarea(["name" => "comentarios"], 1),
			"input_notas"
		);
		$r[] = input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form"]);
		$r[] = input_hidden(["name" => "num_ciclos", "class" => "num_ciclos", "value" => $num_ciclos]);
		$r[] = br();
		$r[] = guardar("CONTINUAR", ["class" => "top_20"]);
		$r[] = get_formar_usuario_registrado($in_session, $servicio, $num_ciclos);
		$r[] = form_close();
		return append_data($r);


	}

	function get_formar_usuario_registrado($in_session, $servicio, $num_ciclos)
	{

		$r = [];
		if ($in_session < 1) {

			$x[] = br();
			$x[] = heading_enid("YA TIENES UN USUARIO REGISTRADO", 2,
				["class" => "display_none text_usuario_registrado"]);
			$x[] = heading_enid("¿Ya tienes una cuenta? ", 3,
				["class" => " text_usuario_registrado_pregunta"]);

			$x[] = div("ACCEDE AHORA!", [
				"plan" => $servicio,
				"num_ciclos" => $num_ciclos,
				"class" => "link_acceso cursor_pointer"
			], 1);

			$r[] = div(append_data($x), ["class" => "contenedor_ya_tienes_cuenta"]);
			$r[] = place("place_notificacion_punto_encuentro_registro");

		}
		return append_data($r);

	}

	function get_format_identificacion($tipos_puntos_encuentro)
	{

		$r[] = heading_enid("IDENTIFICA TU PUNTO MÁS CERCANO", 2, ["class" => "strong titulo_punto_encuentro"]);
		$r[] = create_select($tipos_puntos_encuentro,
			"tipos_puntos_encuentro",
			"tipos_puntos_encuentro hide",
			"tipos_puntos_encuentro",
			"tipo",
			"id"
			, 0, 1, 0, "-");

		return div(append_data($r), ["class" => "col-lg-10 col-lg-offset-1 titulo_principal_puntos_encuentro"]);


	}

	function get_form_quien_recibe($primer_registro, $punto_encuentro, $recibo)
	{


		$r = [];

		$r[] = div(get_form_punto_encuentro_horario(
			[
				input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]),
				input_hidden(["class" => "recibo", "name" => "recibo", "value" => $recibo])
			]
		), ["class" => "col-lg-6 col-lg-offset-3"]);

		$response = div(append_data($r), ["class" => 'formulario_quien_recibe display_none']);

		return $response;

	}

	function get_form_punto_encuentro_horario($extra = [])
	{


		$r[] = form_open("", ["class" => "form_punto_encuentro_horario"]);
		$r[] = append_data($extra);
		$r[] = heading_enid("¿En qué horario te gustaría recibir tu pedido?",
			4,
			["class" => "strong titulo_horario_entra"]);
		$r[] = br();
		$r[] = label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-4 control-label"]);

		$r[] = div(input([
			"data-date-format" => "yyyy-mm-dd",
			"name" => 'fecha_entrega',
			"class" => "form-control input-sm ",
			"type" => 'date',
			"value" => date("Y-m-d"),
			"min" => date("Y-m-d"),
			"max" => add_date(date("Y-m-d"), 4)
		]),
			["class" => "col-lg-8"]);

		$r[] = label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO",
			["class" => "col-lg-4 control-label"]
		);
		$r[] = div(lista_horarios(), ["class" => "col-lg-8"]);

		/*
		if ($tipo < 0 ) {
			$r[] = input_hidden([
				"class" => "recibo",
				"name" => "recibo",
				"value" => $recibo
			]);
		}

		if ($servicio > 0 ){

			$r[] = input_hidden([
				"class" => "servicio",
				"name" => "servicio",
				"value" => $servicio
			]);
		}
		$r[] = input_hidden(["name" => "punto_encuentro", "class" => "punto_encuentro_form", "value" => $punto_encuentro]);
		*/

		$r[] = br();
		$r[] = guardar("CONTINUAR", ["class" => "top_20"]);
		$r[] = form_close(place("place_notificacion_punto_encuentro"));
		return append_data($r);


	}


}