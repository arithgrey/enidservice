<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


	if (!function_exists('get_format_asociar_cuenta_bancaria')) {

		function get_format_asociar_cuenta_bancaria()
		{

			$r[] = heading("ASOCIAR CUENTA BANCARIA Ó TARJETA DE CRÉDITO O DÉBITO", 3);
			$r[] = anchor_enid(
				div("Asociar  tarjeta de crédito o débito",

					[
						"class" => "asociar_cuenta_bancaria",
						"style" => "border-style: solid;border-width: .9px;padding: 10px;margin-top: 50px;"
					]
				),
				["href" => "?q=transfer&action=1&tarjeta=1", "class" => "black"]);
			$r[] = anchor_enid(div("Asociar cuenta bancaria",
				[
					"style" => "border-style: solid;border-width: .9px;padding: 10px;
	                            margin-top: 10px;color: white!important!important",
					"class" => "a_enid_blue asociar_tarjeta"
				]),
				["href" => "?q=transfer&action=1", "class" => "white", "style" => "color: white!important"]);

			return  append_data($r);

		}

	}
	if (!function_exists('get_format_cuentas_existentes')) {

		function get_format_cuentas_existentes($cuentas_gravadas)
		{
			return div(anchor_enid(agrega_cuentas_existencia($cuentas_gravadas),
				[
					"href" => "?q=transfer&action=1&seleccion=1",
					"class" => "white",
					"style" => "color: white!important;background:#004faa;padding: 3px;"
				]), ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]);

		}

	}
	if (!function_exists('get_format_fondos')) {
		function get_format_fondos($saldo_disponible)
		{

			$response = div(div("AUN NO CUENTAS CON FONDOS EN TU CUENTA",
				[
					"style" => "border-radius:20px;background: black;padding:10px;color: white;"
				]), ["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]);


			if ($saldo_disponible > 100) {

				$response = div(div("CONTINUAR " . icon("fa fa-chevron-right"),
					[
						"class" => "btn_transfer",
						"style" => "border-radius: 20px;background: black;padding: 10px;color: white;"
					]),
					["style" => "width: 80%;margin: 0 auto;margin-top: 20px;"]);


			}
			return $response;


		}

	}
	if (!function_exists('get_format_saldo_disponible')) {
		function get_format_saldo_disponible($saldo_disponible)
		{

			$response =   ul([
				div(icon('icon fa fa-money'), ["class" => "icon"]),
				div("Saldo disponible"),
				heading_enid("$" . number_format(get_data_saldo($saldo_disponible), 2) . "MXN", 2, ["class" => "value white"]),
				div("Monto expresado en Pesos Mexicanos")
			]);
			return div($response, ["class"=>"panel income db mbm"]);

		}
	}
	if (!function_exists('get_format_agregar_saldo_cuenta')) {
		function get_format_agregar_saldo_cuenta()
		{

			$r[] = heading_enid("AÑADE SALDO A TU CUENTA DE ENID SERVICE AL REALIZAR ", 3);
			$r[] = get_format_pago_efectivo();
			$r[] = get_format_solicitud_amigo();
			return append_data($r);

		}
	}
	if (!function_exists('get_format_solicitud_amigo')) {
		function get_format_solicitud_amigo()
		{

			return anchor_enid(get_btw(

				div("SOLICITA SALDO A UN AMIGO",
					[
						"class" => "tipo_pago underline"
					]
					,
					1
				),

				div(
					"Pide a un amigo que te transfira saldo desde su cuenta",
					[
						"style" => "text-decoration: underline;",
						"class" => "tipo_pago_descripcion"
					]
					,
					1),

				"option_ingresar_saldo"

			), ["href" => "?q=transfer&action=9"]);

		}
	}
	if (!function_exists('get_format_pago_efectivo')) {

		function get_format_pago_efectivo()
		{

			return anchor_enid(get_btw(

				div("UN PAGO EN EFECTIVO EN OXXO ",
					[
						"class" => "tipo_pago",
						"style" => "text-decoration: underline;color: black"
					],
					1),

				div(
					"Depositas 
						saldo a tu cuenta de Enid service desde  cualquier sucursal de oxxo ",
					["class" => "tipo_pago_descripcion"],
					1),

				"option_ingresar_saldo tipo_pago"

			), ["href" => "?q=transfer&action=7"]);


		}

	}
	if (!function_exists('get_form_pago_oxxo')) {
		function get_form_pago_oxxo($id_usuario)
		{

			$r[] = '<form method="GET" action="../orden_pago_oxxo">';
			$r[] = append_data([
				input_hidden(["name" => "q2", "value" => $id_usuario]),
				input_hidden(["name" => "concepto", "value" => "1"]),
				input_hidden(["name" => "q3", "value" => $id_usuario])
			]);

			$r[] = get_btw(

				input([
					"type" => "number",
					"name" => "q",
					"class" => "form-control input-sm input monto_a_ingresar",
					"required" => true
				])
				,
				heading_enid("MXN", 2)
				,
				"contenedor_form display_flex_enid"

			);
			$r[] = div("¿MONTO QUÉ DESEAS INGRESAR A TU SALDO ENID SERVICE?",
				[
					"colspan" => "2",
					"class" => "underline"
				]
			);
			$r[] = br();
			$r[] = guardar("Generar órden");
			$r[] = form_close();
			return append_data($r);

		}

	}


	if (!function_exists('get_resumen_cuenta')) {
		function get_resumen_cuenta($text)
		{
			return substr($text, 0, 4) . "********";
		}
	}
	if (!function_exists('agrega_cuentas_existencia')) {
		function agrega_cuentas_existencia($flag_cuentas)
		{
			$text = ($flag_cuentas == 0) ? "Asociar nueva cuenta" : "Asociar otra cuenta";
			return $text;
		}
	}
	if (!function_exists('valida_siguiente_paso_cuenta_existente')) {
		function valida_siguiente_paso_cuenta_existente($flag_cuentas_registradas)
		{
			$text = ($flag_cuentas_registradas == 0) ? "readonly" : "";
			return $text;
		}

	}
	if (!function_exists('despliega_cuentas_registradas')) {
		function despliega_cuentas_registradas($cuentas)
		{
			$option = "";
			foreach ($cuentas as $row) {

				$id_cuenta_pago = $row["id_cuenta_pago"];
				$numero_tarjeta = $row["numero_tarjeta"];
				$nuevo_numero_tarjeta = substr($numero_tarjeta, 0, 4);
				$nombre = "Cuenta - " . $row["nombre"] . " " . $nuevo_numero_tarjeta . "************";
				$option .= add_option_select($nombre, $id_cuenta_pago);
			}
			return $option;
		}
	}
	if (!function_exists('add_option_select')) {
		function add_option_select($text, $value)
		{
			return "<option value='" . $value . "'>" . $text . "</option>";
		}
	}

	if (!function_exists('get_data_saldo')) {
		function get_data_saldo($saldo)
		{

			$text = (get_param_def($saldo, "saldo") > 0) ? $saldo["saldo"] : 0;
			return $text;
		}
	}

	if (!function_exists('get_submenu')) {
		function get_submenu()
		{

			$list = [
				li(anchor_enid("Añadir ó solicitar saldo", ["href" => "?q=transfer&action=6", "class" => "black"]), ["class" => "list-group-item"]),
				li(anchor_enid("Trasnferir fondos " . icon("fa fa-fighter-jet"), ["href" => "?q=transfer&action=2", "class" => "black"]), ["class" => "list-group-item"]),
				li(anchor_enid("Mis tarjetas y cuentas", ["href" => "?q=transfer&action=3", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"]),
				li(anchor_enid("Asociar cuenta bancaria", ["href" => "?q=transfer&action=1", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"]),
				li(anchor_enid("Asociar tarjeta de crédito o débito" . icon("fa fa-credit-card-alt"), ["href" => "?q=transfer&action=1&tarjeta=1", "class" => "black"]), ["class" => "list-group-item metodo_pago_disponible"])

			];

			return ul($list, ["class" => "list-group list-group-flush"]);
		}
	}

}