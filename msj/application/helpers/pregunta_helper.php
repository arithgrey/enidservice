<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function get_notificacion_interes_compra($vendedor)
	{

		$nombre = strtoupper(trim(get_campo($vendedor, "nombre")))
            . " " .
            strtoupper(trim(get_campo($vendedor, "apellido_paterno")))
            . " " .
            strtoupper(trim(get_campo($vendedor, "apellido_materno")));



		$r[] = h("Buen día" . $nombre, 1, "display-4" );
		$r[] = d("Un cliente está interesado en uno de tus productos que tienes en venta en");
		$r[] = a_enid("Enid Service",
			[
				"class" => "btn btn-primary btn-lg",
				"href" => "http://enidservice.com/",
				"target" => "_blank",
				"style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
			]);
		$r[] = hr("my-4" );
		$r[] = p("Apresúrate, estás a un paso de realizar una nueva venta!");
		$r[] = a_enid("Responde a tu cliente aquí!",
			[
				"class" => "btn btn-primary btn-lg",
				"href" => "http://enidservice.com/inicio/login/",
				"target" => "_blank",
				"style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
			]
		);


		$response[] = d(append($r), ["class" => "jumbotron", "style" => "padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;"]);
		$respónse[] = d(img("http://enidservice.com/inicio/img_tema/enid_service_logo.jpg"), ["style" => "width: 30%;margin: 0 auto;"]);

		return append($response);

	}

	function get_notificacion_respuesta_cliente($cliente)
	{

		$nombre =
            strtoupper(trim(get_campo($cliente, "nombre")))
            . " " .
            strtoupper(trim(get_campo($cliente, "apellido_paterno"))) .
            " " . strtoupper(trim(get_campo($cliente, "apellido_materno")));


		$r[] = heading("Buen día " . $nombre);
		$r[] = p("Tienes una nueva respuesta en tu buzón");
		$r[] = a_enid("Enid Service", ["href" => "http://enidservice.com/"]);
		$r[] = hr();
		$r[] = p("Apresúrate, estás a un paso de tener tu pedido!");
		$r[] = a_enid("Mira la respuesta aquí!", ["href" => "http://enidservice.com/inicio/login/"]);
		$r[] = d(
		    img("http://enidservice.com/inicio/img_tema/enid_service_logo.jpg"),
            [
                "style" => "width: 30%;margin: 0 auto;"
            ]
        );
		return append($r);


	}

	function get_accesos($q)
	{

		$r[] = d(
		    format_notificacion_subscrito($q["nombre"]),
            [
                "style" => "padding: 2rem 1rem;margin-bottom: 2rem;background-color: #fbfbfb;border-radius: .3rem;"
            ]
        );
		$r[] = d("Usuario: " . $q["email"]);
		$r[] = d("Acceso:" . $q["password_legible"]);

		$r[] = d(
		    img([
			"src" => "http://enidservice.com/inicio/img_tema/enid_service_logo.jpg",
			"style" => "width: 100%"
		]),
			[
				"style" => "width: 30%;margin: 0 auto;"
			]);

		return append($r);

	}
	function format_notificacion_subscrito($nombre)
	{

		$r[] = heading("Buen día" . $nombre);
		$r[] = d("Te notificamos que desde este momento puedes consultar más productos y servicios a través de ");
		$r[] = a_enid("Enid Service",
			[
				"class" => "btn btn-primary btn-lg",
				"href" => "http://enidservice.com/",
				"target" => "_blank",
				"style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
			]);


		$r[] = hr();
		$r[] = d("Desde ahora podrás comprar y vender tus productos o servicios ");
		$r[] = a_enid("Accede a tu cuenta aquí!",
			[
				"class" => "btn btn-primary btn-lg",
				"href" => "http://enidservice.com/inicio/login/",
				"target" => "_blank",
				"style" => "background: #015ec8;padding: 5px;color: white;margin-top: 23px;"
			]);

		return append($r);
	}
}