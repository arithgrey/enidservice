<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	if (!function_exists('get_form_monto_pago')) {


		function get_form_monto_pago($info_pago){

			$r[] =  heading("MONTO A PAGAR") ;
			$r[] =  heading("$" . $info_pago["q"] . "MXN") ;
			$r[] =  div("OXXO Cobrará una comisión adicional al momento de realizar el pago") ;
			return append_data($r);
		}

	}
	if (!function_exists('get_form_saldos')) {
		function get_form_saldos($beneficiario, $folio, $monto, $concepto)
		{
			$numero_cuenta = "4152 3131 0230 5609";
			$r[] = '<form action="../pdf/orden_pago.php" method="POST">';
			$r[] = input_hidden([
				"name" => "beneficiario",
				"value" => $beneficiario

			]);
			$r[] = input_hidden([
				"name" => "folio",
				"value" => $folio

			]);
			$r[] = input_hidden([
				"name" => "monto",
				"value" => $monto

			]);
			$r[] = input_hidden([
				"name" => "numero_cuenta",
				"value" => $numero_cuenta

			]);
			$r[] = input_hidden([
				"name" => "concepto",
				"value" => $concepto

			]);
			$r[] = guardar("IMPRIMIR", ["class" => " imprimir", "style" => "background:#0a0e39!important;"], 1, 1);
			$r[] = br();
			$r[] = form_close();
			return append_data($r);


		}
	}

	if (!function_exists('get_instrucciones')) {
		function get_instrucciones()
		{


			$r [] = div(
				"INSTRUCCIONES",
				["style" => "background: black;color: white;padding: 5px;"],
				1);
			$r [] = div("1.-Acude a la tienda OXXO más cencana ");
			$r [] = div("2.- Indica en caja que quieres realizar un
                                                depósito en cuenta BBVA Bancomer ");
			$r [] = div("3.- Proporciona el número de cuenta señalado");
			$r [] = div("4.-Realiza el 
                        pago exacto correspondiente, que se indica en el monto a pagar");
			$r [] = div("5.-Al confirmar tu pago, el cajero te entregará un comprobante impreso.");
			$r [] = div("En el podrás verificar que se haya realizado correctamente, conserva este comprobante.");

			$r [] = div("6.- Notifica tu pago desde tu área de cliente");
			$r [] = anchor_enid("http://enidservice.com/inicio/login/",
				[
					"href" => "http://enidservice.com/inicio/login/"
				]);
			$r [] = div("ó");
			$r [] = div("Notifica tu pago  al área de ventas ventas@enidservice.com");
			$r [] = div(img([
					"src" => "../img_tema/enid_service_logo.jpg",
					"style" => "width: 300px;"
				])
				,
				1);

			return div(append_data($r), ["style" => "width: 80%;margin: 0 auto;"]);


		}
	}
	if (!function_exists('get_instruccion_pago')) {
		function get_instruccion_pago()
		{

			$numero_cuenta = "4152 3131 0230 5609";

			$r[] = div(div(img(
					["src" => "http://enidservice.com/inicio/img_tema/portafolio/logo-bbv.png"]
				)
				, ["class" => "col-lg-6"]), ["class" => "contenedor-img-logo"]);
			$r[] = div(div($numero_cuenta, ["class" => "col-lg-6"]), ["class" => "contenedor-img-logo"], 1);
			$r[] = get_instrucciones();
			return addNRow(append_data($r));

		}
	}
	if (!function_exists('get_monto_pago')) {
		function get_monto_pago($monto)
		{

			$r[] = heading("MONTO A PAGAR");
			$r[] = heading("$" . $monto . "MXN", 2);
			$r[] = div("OXXO Cobrará una comisión adicional al momento de realizar el pago", 1);
			return div(div(append_data($r), ["style" => "width: 80%;margin: 0 auto;"]), ["style" => "margin-top:20px;"]);

		}
	}

}
