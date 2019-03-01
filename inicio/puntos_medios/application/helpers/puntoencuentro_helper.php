<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


	function get_form_punto_encuentro_horario($extra=[])
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