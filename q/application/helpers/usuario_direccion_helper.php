<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


	function get_parte_direccion_envio($cp, $param, $calle, $entre_calles, $numero_exterior, $numero_interior)
	{

		$r[] = div("Código postal", ["class" => "label-off"]);
		$r[] = input([
			"maxlength" => "5",
			"name" => "cp",
			"value" => $cp,
			"placeholder" => "* Código postal",
			"required" => "required",
			"class" => "codigo_postal",
			"id" => "codigo_postal",
			"type" => "text",

		]);
		$r[] = place("place_codigo_postal");
		$r[] = input_hidden([
			"type" => "hidden",
			"name" => "id_usuario",
			"value" => $param['id_usuario']

		]);
		$r[] = get_btw(
			div("Calle", ["class" => "label-off", "for" => "dwfrm_profile_address_address1"]),

			input([
				"class" => "textinput",
				"name" => "calle",
				"value" => $calle,
				"maxlength" => "30",
				"placeholder" => "* Calle",
				"required" => "required",
				"autocorrect" => "off",
				"type" => "text"

			]),
			"value"
		);
		$r[] = get_btw(
			div("Entre la calle y la calle, o información adicional", ["class" => "label-off", "for" => "dwfrm_profile_address_address3"])
			,
			input([
				"required" => true,
				"class" => "textinput address3",
				"name" => "referencia",
				"value" => $entre_calles,
				"placeholder" => "Entre la calle y la calle, o información adicional",
				"type" => "text"
			])
			,
			"value"
		);
		$r[] = get_btw(
			div("Número Exterior", ["class" => "label-off", "for" => "dwfrm_profile_address_houseNumber"])
			,
			input([
				"class" => "required numero_exterior",
				"name" => "numero_exterior",
				"value" => $numero_exterior,
				"maxlength" => "8",
				"placeholder" => "* Número Exterior",
				"required" => "true",
				"type" => "text"
			])
			,
			"value"
		);
		$r[] = get_btw(
			div("Número Interior", [
				"class" => "label-off",
				"for" => "dwfrm_profile_address_address2"
			])
			,
			input([
				"class" => "numero_interior",
				"name" => "numero_interior",
				"value" => $numero_interior,
				"maxlength" => "10",
				"autocorrect" => "off",
				"type" => "text",
				"required" => "true"
			])
			,
			"value"
		);
		return append_data($r);

	}

	function get_format_domicilio($info_envio_direccion)
	{

		$r[] = get_campo($info_envio_direccion, "direccion", "Dirección", 1);
		$r[] = get_campo($info_envio_direccion, "calle", "Calle", 1);
		$r[] = get_campo($info_envio_direccion, "numero_exterior", " Número exterior ", 1);
		$r[] = get_campo($info_envio_direccion, "numero_interior", " Número interior ", 1);
		$r[] = get_campo($info_envio_direccion, "entre_calles", "Entre ", 1);
		$r[] = get_campo($info_envio_direccion, "cp", " C.P. ", 1);
		$r[] = get_campo($info_envio_direccion, "asentamiento", " Colonia ", 1);
		$r[] = get_campo($info_envio_direccion, "municipio", " Delegación/Municipio ", 1);
		$r[] = get_campo($info_envio_direccion, "ciudad", " Ciudad ", 1);
		$r[] = get_campo($info_envio_direccion, "estado", " Estado ", 1);


	}

	/**/
	function val_btn_pago($param, $id_proyecto_persona_forma_pago)
	{

		$btn = anchor_enid("Liquida ahora!",
			[
				'class' => 'resumen_pagos_pendientes ',
				'id' => $id_proyecto_persona_forma_pago,
				'href' => '#tab_renovar_servicio',
				'data-toggle' => 'tab'
			]);


		if (get_info_usuario_valor_variable($param, "externo") == 1) {

			$url = "../forma_pago/?recibo=" . $id_proyecto_persona_forma_pago;
			//$extra = "";
			$f_btn = anchor_enid("LIQUIDAR AHORA!",
				[
					'class' => 'resumen_pagos_pendientes top_20',
					'id' => $id_proyecto_persona_forma_pago,
					'href' => $url
				], 1, 1);

			$s_btn = anchor_enid("ACCEDE A TU CUENTA PARA VER EL ESTADO DE TU PEDIDO",
				[
					'class' => 'resumen_pagos_pendientes black top_20',
					'id' => $id_proyecto_persona_forma_pago,
					'href' => '../area_cliente/?action=compras'
				]);


			$contenido = div($f_btn);
			$contenido .= div($s_btn);
			return $contenido;
		}
		return $btn;
	}

}