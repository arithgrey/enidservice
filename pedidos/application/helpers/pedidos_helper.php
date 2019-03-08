<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {





	if (!function_exists('form_form_search')) {
		function form_form_search(){

			$r[] = form_open("", ["class"=>"form_search",  "method"=>"GET"]);
			$r[] = input_hidden(["name" => "recibo", "value" => "", "class" => "numero_recibo"]);
			$r[] = form_close();
			return append_data($r);

		}

	}
	if (!function_exists('form_busqueda_pedidos')) {

		function form_busqueda_pedidos($tipos_entregas, $status_ventas)
		{


			$r[] = get_btw(
				strong("CLIENTE"),
				input([
					"name" => "cliente",
					"class" => "form-control",
					"placeholder" => "Nombre, correo, telefono ..."
				]),
				"col-lg-3"
			);
			$r[] = input_hidden([
				"name" => "v",
				'value' => 1

			]);
			$r[] = get_btw(
				strong("#Recibo"),
				input([
					"name" => "recibo",
					"class" => "form-control"
				]),
				"col-lg-2"
			);

			$r[] = get_btw(
				strong("TIPO ENTREGA"),

				create_select($tipos_entregas,
					"tipo_entrega",
					"tipo_entrega form-control",
					"tipo_entrega",
					"nombre",
					"id",
					0,
					1,
					0,
					"-"),
				"col-lg-3"

			);
			$r[] = get_btw(
				strong("STATUS"),
				create_select(
					$status_ventas,
					"status_venta",
					"status_venta  form-control",
					"status_venta",
					"text_vendedor",
					"id_estatus_enid_service",
					0,
					1,
					0,
					"-"
				),
				"col-lg-3"

			);


			return append_data($r);

		}
	}

	if (!function_exists('get_format_pre_orden')) {

		function get_format_pre_orden($id_servicio, $id_error, $recibo)
		{


			$r[] = div(img(
				[
					"src" => link_imagen_servicio($id_servicio),
					"class" => "rounded-circle",
					"id" => $id_error,
					"onerror" => "reloload_img( '" . $id_error . "','" . link_imagen_servicio($id_servicio) . "');",
					"style" => "width:100px!important;height:100px!important;"

				]),
				["class" => "mr-2"]);

			$r[] = div(heading_enid(
				"ORDEN #" . $recibo["id_proyecto_persona_forma_pago"],
				5,
				["class" => "h5 m-0"]
			),
				["class" => "ml-2"]
			);

			return append_data($r);


		}

	}
	if (!function_exists('get_format_listado_puntos_encuentro')) {
		function get_format_listado_puntos_encuentro($puntos_encuentro, $id_recibo, $domicilio)
		{

			$r[] = br();
			$r[] = div("TUS PUNTOS DE ENCUENTRO ", ["class" => "text_puntos_registrados"]);
			$r[] = agregar_nueva_direccion(1);
			$r[] = ul([get_lista_puntos_encuentro($puntos_encuentro, $id_recibo, $domicilio)]);
			$r[] = br(2);

			return append_data($r);
		}

	}
	if (!function_exists('get_hiddens_detalle')) {

		function get_hiddens_detalle($recibo)
		{

			$r[] = input_hidden(
				[
					"class" => "status_venta_registro",
					"name" => "status_venta",
					"value" => $recibo[0]["status"],
					"id" => "status_venta_registro"
				]);
			$r[] = input_hidden(
				[
					"class" => "saldo_actual_cubierto",
					"name" => "saldo_cubierto",
					"value" => $recibo[0]["saldo_cubierto"]
				]);
			$r[] = input_hidden(
				[
					"class" => "tipo_entrega_def",
					"name" => "tipo_entrega",
					"value" => $recibo[0]["tipo_entrega"]
				]);
			$r[] = input_hidden(
				[
					"class" => "id_servicio",
					"name" => "id_servicio",
					"value" => $recibo[0]["id_servicio"]
				]);
			$r[] = input_hidden(
				[
					"class" => "articulos",
					"name" => "articulos",
					"value" => $recibo[0]["num_ciclos_contratados"]
				]);

			return append_data($r);

		}
	}
	if (!function_exists('get_format_menu')) {

		function get_format_menu($domicilio, $recibo, $id_recibo)
		{


			$x[] = get_link_cambio_fecha($domicilio, $recibo);
			$x[] = get_link_recordatorio($id_recibo);
			$x[] = get_link_nota();
			$x[] = get_link_costo($id_recibo, $recibo);

			$r[] = div(icon("fa fa-plus-circle fa-3x"), ["class" => " dropdown-toggle", "data-toggle" => "dropdown"]);
			$r[] = div(append_data($x), ["class" => "dropdown-menu contenedor_opciones_pedido", "aria-labelledby" => "dropdownMenuButton"]);


			return div(append_data($r), ["class" => "dropdown pull-right top_20 "]);


		}

	}

	if (!function_exists('get_motificacion_evaluacion')) {

		function get_motificacion_evaluacion($recibo, $es_vendedor, $evaluacion)
		{


			$response = "";

			if ($recibo[0]["status"] == 9 && $es_vendedor < 1 && $evaluacion == 0) {

				$id_servicio = $recibo[0]["id_servicio"];
				$url = "../valoracion/?servicio=" . $id_servicio;
				$text = guardar("ESCRIBE UNA RESEÑA");
				$text .= div(str_repeat("★", 5), ["class" => "text-center f2", "style" => "color: #010148;"]);
				$response = anchor_enid($text, ["href" => $url]);

			} elseif ($recibo[0]["status"] == 9 && $es_vendedor < 1 && $evaluacion > 0) {

				$id_servicio = $recibo[0]["id_servicio"];
				$url = "../producto/?producto=" . $id_servicio . "&valoracion=1";
				$text = guardar("ESCRIBE UNA RESEÑA");
				$text .= div(str_repeat("★", 5), ["class" => "text-center f2", "style" => "color: #010148;"]);
				$response = anchor_enid($text, ["href" => $url]);

			} else {
			}
			return $response;


		}
	}

	if (!function_exists('get_form_fecha_recordatorio')) {
		function form_fecha_recordatorio($orden, $tipo_recortario)
		{


			$r[] = form_open("", ["class" => "form_fecha_recordatorio"]);
			$r[] = heading_enid("RECORDATORIO",
				4,
				["class" => "strong titulo_horario_entra"]);
			$r[] = br();
			$r[] = label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-4 control-label"]);
			$r[] = div(input([
				"data-date-format" => "yyyy-mm-dd",
				"name" => 'fecha_cordatorio',
				"class" => "form-control input-sm ",
				"type" => 'date',
				"value" => date("Y-m-d"),
				"min" => add_date(date("Y-m-d"), -15),
				"max" => add_date(date("Y-m-d"), 15)
			]),
				["class" => "col-lg-8"]);

			$r[] = label(icon("fa fa-clock-o") . " HORA",
				["class" => "col-lg-4 control-label"]
			);
			$r[] = div(lista_horarios(), ["class" => "col-lg-8"]);
			$r[] = input_hidden([
				"class" => "recibo",
				"name" => "recibo",
				"value" => $orden
			]);
			$r[] = br();
			$r[] = label(" TIPO",
				["class" => "col-lg-4 control-label"]
			);
			$r[] = div(create_select($tipo_recortario, "tipo", "form-control tipo_recordatorio", "tipo_recordatorio", "tipo", "idtipo_recordatorio"), ["class" => "col-lg-8"]);
			$r[] = textarea(["name" => "descripcion", "class" => "form-control"]);;
			$r[] = guardar("CONTINUAR", ["class" => "top_20"]);
			$r[] = form_close();

			return append_data($r);


		}
	}
	if (!function_exists('get_form_fecha_entrega')) {
		function get_form_fecha_entrega( $orden)
		{


			$r[] = form_open("", ["class" => "form_fecha_entrega"]);
			$r[] = heading_enid("FECHA DE ENTREGA", 4, ["class" => "strong titulo_horario_entra"]);
			$r[] = br();
			$r[] = label(icon("fa fa-calendar-o") . " FECHA ", ["class" => "col-lg-4 control-label"]);
			$r[] = div(input([
				"data-date-format" => "yyyy-mm-dd",
				"name" => 'fecha_entrega',
				"class" => "form-control input-sm ",
				"type" => 'date',
				"value" => date("Y-m-d"),
				"min" => add_date(date("Y-m-d"), -15),
				"max" => add_date(date("Y-m-d"), 15)
			]),
				["class" => "col-lg-8"]);

			$r[] = label(icon("fa fa-clock-o") . " HORA DE ENCUENTRO",
				["class" => "col-lg-4 control-label"]
			);
			$r[] = div(lista_horarios(), ["class" => "col-lg-8"]);
			$r[] = input_hidden([
				"class" => "recibo",
				"name" => "recibo",
				"value" => $orden
			]);
			$r[] = br();
			$r[] = guardar("CONTINUAR", ["class" => "top_20"]);
			$r[] = place("place_notificacion_punto_encuentro");
			$r[] = form_close();
			return append_data($r);


		}

	}
	if (!function_exists('get_form_cantidad')) {
		function get_form_cantidad($recibo, $orden)
		{


			$r[] = '<form class="form_cantidad top_20">';
			$r[] = div(strong("SALDO CUBIERTO"), 1);

			$r[] = div(input(
				[
					"class" => "form-control saldo_cubierto",
					"id" => "saldo_cubierto",
					"type" => "number",
					"step" => "any",
					"required" => "true",
					"name" => "saldo_cubierto",
					"value" => $recibo[0]["saldo_cubierto"]

				]),
				["class" => "col-lg-10"]);
			$r[] = input_hidden(
				[
					"name" => "recibo",
					"class" => "recibo",
					"value" => $orden
				]);
			$r[] = div("MXN", ["class" => "mxn col-lg-2"]);

			$r[] = place("mensaje_saldo_cubierto");
			$r[] = form_close();

			return append_data($r);

		}

	}

	if (!function_exists('get_form_costos')) {


		function get_form_costos($tipo_costos, $id_recibo)
		{


			$r[] = form_open("", ["class" => "form_costos"], ["recibo" => $id_recibo]);

			$a = div("MONTO GASTADO", ["class" => "text_gasto strong"]);
			$b = input([
				"type" => "number",
				"required" => true,
				"class" => "form-control input precio",
				"name" => "costo"
			]);

			$r[] = get_btw($a, $b, "display_flex_enid top_30");

			$r[] = create_select(
				$tipo_costos,
				"tipo",
				"id_tipo_costo form-control",
				"tipo",
				"tipo",
				"id_tipo_costo");


			$r[] = guardar("AGREGAR", ["class" => "top_20"]);


			$r[] = form_close(place("notificacion_registro_costo"));
			return append_data($r);

		}


	}
	if (!function_exists('get_error_message')) {
		function get_error_message()
		{


			$r[] = div(heading_enid("UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN", 1, ["class" => "funny_error_message"]), ["class" => "text-center"]);
			$r[] = div(img(["src" => "../img_tema/gif/funny_error.gif"]));
			$r[] = div(anchor_enid("ENCUENTRA TU ORDEN AQUÍ",
				[
					"href" => "../pedidos",
					"class" => "busqueda_mensaje"
				]),
				["class" => "busqueda_mensaje_text"]
			);
			$response = div(append_data($r));

			return $response;
		}
	}


	if (!function_exists('get_form_registro_direccion')) {
		function get_form_registro_direccion($id_recibo)
		{

			$r[] = '<form  class="form_registro_direccion" action="../procesar/?w=1" method="POST" >';
			$r[] = input_hidden(["class" => "recibo", "name" => "recibo", "value" => $id_recibo]);
			$r[] = form_close();
			return append_data($r);

		}
	}

	if (!function_exists('get_form_puntos_medios')) {
		function get_form_puntos_medios($id_recibo)
		{

			$r[] = '<form   class="form_puntos_medios" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
			$r[] = input_hidden([
				"name" => "recibo",
				"value" => $id_recibo]);
			$r[] = form_close();
			return append_data($r);

		}
	}
	if (!function_exists('get_form_puntos_medios_avanzado')) {

		function get_form_puntos_medios_avanzado($id_recibo)
		{


			$r[] = '<form   class="form_puntos_medios_avanzado" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
			$r[] = input_hidden([
				"name" => "recibo",
				"value" => $id_recibo
			]);

			$r[] = input_hidden([
				"name" => "avanzado",
				"value" => 1
			]);

			$r[] = input_hidden([
				"class" => "punto_encuentro_asignado",
				"name" => "punto_encuentro",
				"value" => 0
			]);
			$r[] = form_close();

			return append_data($r);

		}

	}
	if (!function_exists('get_form_nota')) {
		function get_form_nota($id_recibo)
		{

			$r[] = form_open("", ["class" => "form_notas", "style" => "display:none;"]);
			$r[] = div("NOTA", ["class" => "strong text_nota", "style" => "font-size:1.5em;"]);
			$r[] = textarea(["name" => "comentarios", "class" => "comentarios form-control"]);
			$r[] = input_hidden(["name" => "id_recibo", "value" => $id_recibo]);
			$r[] = guardar("AGREGAR", ["name" => "comentarios"]);
			$r[] = form_close(place("place_nota"));
			return append_data($r);

		}
	}
	if (!function_exists('agregar_nueva_direccion')) {
		function agregar_nueva_direccion($direccion = 1)
		{


			if ($direccion > 0) {
				return li(guardar("Agregar punto de encuentro ",
					["class" => "agregar_punto_encuentro_pedido"]));
			} else {

				return li(guardar("Agregar direccion ",
					["class" => "agregar_direccion_pedido"]));
			}


		}
	}
	if (!function_exists('get_lista_puntos_encuentro')) {
		function get_lista_puntos_encuentro($puntos_encuentro, $id_recibo, $domicilio = '')
		{

			$asignado = (is_array($domicilio) && $domicilio["tipo_entrega"] == 1) ? $domicilio["domicilio"][0]["id"] : 0;
			$lista = "";
			$a = 0;
			foreach ($puntos_encuentro as $row) {

				$id = $row["id"];
				$nombre = $row["nombre"];
				$extra = ($id === $asignado) ? "asignado_actualmente" : "";


				$encuentro = div("#" . $a, ["class" => "h6 text-muted"]);
				$encuentro .= div(strtoupper($nombre), ["class" => "h5"]);
				$encuentro .= div("ESTABLECER COMO PUNTO DE ENTREGA",
					[
						"class" => "h6 text-muted text-right establecer_punto_encuentro cursor_pointer",
						"id" => $id,
						"id_recibo" => $id_recibo

					]
				);

				$lista .= li($encuentro, ["class" => "list-group-item " . $extra]);
				$a++;
			}
			return $lista;
		}
	}
	if (!function_exists('create_lista_direcciones')) {
		function create_lista_direcciones($lista, $id_recibo)
		{

			$text = "";
			$a = 1;
			foreach ($lista as $row) {

				$id_direccion = $row["id_direccion"];
				$calle = $row["calle"];
				$numero_exterior = $row["numero_exterior"];
				$numero_interior = $row["numero_interior"];
				$cp = $row["cp"];
				$asentamiento = $row["asentamiento"];
				$municipio = $row["municipio"];
				$estado = $row["estado"];
				$text .= "<li class='list-group-item'>";

				$direccion =
					$calle . " " . " NÚMERO " . $numero_exterior . " NÚMERO INTERIOR " . $numero_interior . " COLONIA " . $asentamiento . " DELEGACIÓN/MUNICIPIO " . $municipio . " ESTADO " . $estado . " CÓDIGO POSTAL " . $cp;

				$text .= div("#" . $a, ["class" => "h6 text-muted"]);
				$text .= div(strtoupper($direccion), ["class" => "h5"]);
				$text .=
					div("ESTABLECER COMO DIRECCIÓN DE ENTREGA",
						[
							"class" => "h6 text-muted text-right establecer_direccion cursor_pointer",
							"id" => $id_direccion,
							"id_recibo" => $id_recibo

						]);
				$text .= "</li>";
				$a++;
			}

			return $text;
		}
	}
	if (!function_exists('create_descripcion_direccion_entrega')) {
		function create_descripcion_direccion_entrega($data_direccion)
		{

			$text = "";

			if (is_array($data_direccion)){
				if ($data_direccion["tipo_entrega"] == 2 && count($data_direccion["domicilio"]) > 0) {


					$domicilio = $data_direccion["domicilio"][0];
					$calle = $domicilio["calle"];

					$numero_exterior = $domicilio["numero_exterior"];
					$numero_interior = $domicilio["numero_interior"];
					$cp = $domicilio["cp"];
					$asentamiento = $domicilio["asentamiento"];
					$municipio = $domicilio["municipio"];
					$estado = $domicilio["estado"];

					$text
						=
						$calle . " " . " NÚMERO " . $numero_exterior . " NÚMERO INTERIOR " . $numero_interior . " COLONIA " . $asentamiento . " DELEGACIÓN/MUNICIPIO " . $municipio . " ESTADO " . $estado . " CÓDIGO POSTAL " . $cp;
					$text = p(strtoupper($text), ["class" => "card-text"]);

				} else {

					if (is_array($data_direccion)
						&& array_key_exists("domicilio" , $data_direccion)
						&& is_array($data_direccion["domicilio"])
						&& count($data_direccion["domicilio"]) > 0) {

						$punto_encuentro = $data_direccion["domicilio"][0];
						//$costo_envio = $punto_encuentro["costo_envio"];
						$tipo = $punto_encuentro["tipo"];
						$color = $punto_encuentro["color"];
						$nombre_estacion = $punto_encuentro["nombre"];
						$lugar_entrega = $punto_encuentro["lugar_entrega"];
						$numero = "NÚMERO " . $punto_encuentro["numero"];
						$text = heading_enid("LUGAR DE ENCUENTRO", 3, ["class" => "top_20"]);
						$text .= div($tipo . " " . $nombre_estacion . " " . $numero . " COLOR " . $color, 1);
						$text .= div("ESTACIÓN " . $lugar_entrega, ["class" => "strong"], 1);


					}

				}
			}

			return $text;
		}

	}
	if (!function_exists('valida_accion_pago')) {
		function valida_accion_pago($recibo)
		{

			if ($recibo["saldo_cubierto"] < 1) {

				$id_recibo = $recibo["id_proyecto_persona_forma_pago"];
				$url = "../area_cliente/?action=compras&ticket=" . $id_recibo;
				return guardar("PROCEDER A LA COMPRA " . icon("fa fa-2x fa-shopping-cart"),
					[
						"style" => "background:blue!important",
						"class" => "top_20"
					],
					1,
					1,
					0,
					$url);
			}
		}
	}
	if (!function_exists('create_linea_tiempo')) {

		function create_linea_tiempo($status_ventas, $recibo, $domicilio, $es_vendedor)
		{

			$linea = "";
			$flag = 0;
			$recibo = $recibo[0];
			$id_estado = $recibo["status"];
			$tipo_entrega = $recibo["tipo_entrega"];
			$id_recibo = $recibo["id_proyecto_persona_forma_pago"];


			for ($i = 5; $i > 0; $i--) {

				$status = get_texto_status($i, $recibo);
				$activo = 1;

				if ($flag == 0) {
					$activo = 0;
					if ($id_estado == $status["estado"]) {
						$activo = 1;
						$flag++;
					}
				}

				switch ($i) {

					case 2:
						$class = (tiene_domilio($domicilio, 1) == 0) ? "timeline__item__date" : "timeline__item__date_active";
						$seccion_2 = get_seccion_domicilio($domicilio, $id_recibo, $tipo_entrega, $es_vendedor);

						break;
					case 3:

						$class = ($recibo["saldo_cubierto"] > 0) ? "timeline__item__date_active" : "timeline__item__date";
						$seccion_2 = get_seccion_compra($recibo, $id_recibo, $es_vendedor);

						break;



					default:
						$class = ($activo == 1) ? "timeline__item__date_active" : "timeline__item__date";
						$seccion_2 = get_seccion_base($status);
						break;

				}
				$seccion = div(icon("fa fa-check-circle-o"), ["class" => $class]);
				$linea .= div($seccion . $seccion_2, ["class" => "timeline__item"]);


			}
			return $linea;
		}
	}
	if (!function_exists('get_seccion_base')) {
		function get_seccion_base($status)
		{
			$seccion =
				div(p($status["text"],
					[
						"class" => "timeline__item__content__description"
					]),
					["class" => "timeline__item__content"]);

			return $seccion;

		}
	}
	if (!function_exists('get_seccion_compra')) {
		function get_seccion_compra($recibo, $id_recibo, $es_vendedor)
		{

			$text = ($recibo["saldo_cubierto"] > 0) ? "REALIZASTE TU COMPRA" . icon("fa fa-check") : "REALIZA TU COMPRA";
			$url = "../area_cliente/?action=compras&ticket=" . $id_recibo;
			$url = ($es_vendedor > 0) ? "" : $url;

			$seccion = div(p(
				anchor_enid($text,
					[
						"href" => $url,
						"class" => "text-line-tiempo"
					]
				),
				[
					"class" => "timeline__item__content__description"
				]),
				["class" => "timeline__item__content"]);

			return $seccion;
		}
	}
	if (!function_exists('get_seccion_domicilio')) {
		function get_seccion_domicilio($domicilio, $id_recibo, $tipo_entrega, $es_vendedor)
		{

			$texto_entrega = "DOMICILIO DE ENTREGA CONFIRMADO " . icon("fa fa-check");

			if (tiene_domilio($domicilio, 1) == 0) {
				$texto_entrega = ($tipo_entrega == 1) ? "REGISTRA TU DIRECCIÓN DE ENTREGA" : "INDICA TU PUNTO DE DE ENTREGA";
			}


			$url = "../pedidos/?seguimiento=" . $id_recibo . "&domicilio=1";
			$url = ($es_vendedor > 0) ? "" : $url;
			$seccion = div(p(
				anchor_enid($texto_entrega,
					[
						"href" => $url,
						"class" => "text-line-tiempo"
					]),
				[
					"class" => "timeline__item__content__description"
				]),
				["class" => "timeline__item__content"]);
			return $seccion;
		}
	}
	if (!function_exists('get_texto_status')) {
		function get_texto_status($status, $recibo)
		{

			$text = "";
			$response = [];
			$estado = 6;

			switch ($status) {
				case 2:
					$text = "PAGO VERIFICADO";
					$estado = 1;
					break;

				case 1:
					$text = "ORDEN REALIZADA" . icon("fa fa-check");
					$estado = 6;
					break;


				case 4:
					$text = "PEDIDO EN CAMINO";
					$estado = 7;
					break;

				case 5:
					$text = "ENTREGADO";
					$estado = 9;
					break;

				case 3:
					$text = "EMPACADO";
					$estado = 12;
					break;

				default:

					break;
			}
			$response["text"] = $text;
			$response["estado"] = $estado;
			return $response;

		}
	}
	if (!function_exists('create_seccion_comentarios')) {
		function create_seccion_comentarios($data, $id_recibo)
		{

			$notas = "";
			foreach ($data as $row) {

				$fecha_registro = div(icon("fa fa-clock-o") . $row["fecha_registro"], ["class" => "col-lg-3"]);
				$comentario = div($row["comentario"], ["class" => "col-lg-9"]);
				$nota = div($fecha_registro . $comentario, 1);
				$notas .= div($nota, ["class" => "seccion_tipificacion top_20 padding_10"]);

			}

			$title = heading_enid("NOTAS", 4, ["class" => "white"]);
			return br() . div($title . $notas, ["class" => "global_tipificaciones"]);

		}
	}
	if (!function_exists('crea_seccion_recordatorios')) {
		function crea_seccion_recordatorios($recordatorios, $tipo_recortario)
		{


			$list = [];
			foreach ($recordatorios as $row) {

				$id_recordatorio = $row["id_recordatorio"];
				$status = ($row["status"] > 0) ? 0 : 1;
				$fecha_cordatorio = $row["fecha_cordatorio"];
				$id_tipo = $row["id_tipo"];
				$text_tipo = $row["tipo"];

				$config = ["type" => "checkbox", "class" => "form-control item_recordatorio", "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})"];
				if ($row["status"] > 0) {
					$config = ["checked" => true, "type" => "checkbox", "class" => "form-control item_recordatorio", "onclick" => "modifica_status_recordatorio({$id_recordatorio} , {$status})"];
				}
				$check = input($config);
				$item = div($check . $row["descripcion"], 1) .
					div(icon("fa fa-clock-o") . $fecha_cordatorio, 1) .
					div($text_tipo);
				$list[] = li($item);
			}
			return ul($list);
		}
	}
	if (!function_exists('create_seccion_tipificaciones')) {
		function create_seccion_tipificaciones($data)
		{

			$tipificaciones = "";

			foreach ($data as $row) {

				$fecha_registro = div(icon("fa fa-clock-o") . $row["fecha_registro"], ["class" => "col-lg-3 fecha_registro_text"]);
				$nombre_tipificacion = div($row["nombre_tipificacion"], ["class" => "col-lg-9"]);
				$tipificacion = div($fecha_registro . $nombre_tipificacion, 1);
				$tipificaciones .= div($tipificacion, ["class" => "seccion_tipificacion top_20 padding_10"]);

			}
			if (count($data) > 0) {
				$title = heading_enid("MOVIMIENTOS", 4, ["class" => "white"]);
				return div($title . $tipificaciones, ["class" => "global_tipificaciones"]);
			}

		}
	}
	if (!function_exists('crea_seccion_productos')) {
		function crea_seccion_productos($recibo)
		{

			$recibo = $recibo[0];
			$num_ciclos_contratados = $recibo["num_ciclos_contratados"];
			$precio = $recibo["precio"];
			$id_servicio = $recibo["id_servicio"];
			$response = "";

			for ($a = 0; $a < $num_ciclos_contratados; $a++) {

				$link = link_imagen_servicio($id_servicio);
				$id_error = "imagen_" . $id_servicio;
				$img = img([
					"src" => $link,
					"class" => "img_servicio",
					"id" => $id_error,
					'onerror' => "reloload_img( '" . $id_error . "','" . $link . "');"
				]);


				$text_producto = div($precio . "MXN", ["class" => "text-center top_20 text_precio_producto"]);
				$r = div($img, ["class" => "col-lg-4"]);
				$r .= div($text_producto, ["class" => "col-lg-8"]);

				$url_servicio = "../producto/?producto=" . $id_servicio;
				$r =
					div(anchor_enid($r,
						[
							"href" => $url_servicio,
							"target" => "_black"
						]),
						[
							"class" => "top_20 row "
						]) . hr();


				$response .= $r;
			}
			return $response;

		}
	}

	if (!function_exists('create_fecha_contra_entrega')) {
		function create_fecha_contra_entrega($recibo, $domicilio)
		{

			if (get_param_def($domicilio, "domicilio") > 0 && count($recibo) > 0) {
				$recibo = $recibo[0];
				/*
				$id_recibo = $recibo["id_proyecto_persona_forma_pago"];
				$status = $recibo["status"];
				$saldo_cubierto_envio = $recibo["saldo_cubierto_envio"];
				$monto_a_pagar = $recibo["monto_a_pagar"];
				$se_cancela = $recibo["se_cancela"];
				$fecha_entrega = $recibo["fecha_entrega"];
				*/
				$text = div(div("HORARIO DE ENTREGA", 1) . div($recibo["fecha_contra_entrega"], 1), ["class" => "contenedor_entrega"]);


				$fecha_contra_entrega = ($recibo["tipo_entrega"] == 1) ? $text : "";
				return $fecha_contra_entrega;
			}
		}
	}
	if (!function_exists('notificacion_por_cambio_fecha')) {
		function notificacion_por_cambio_fecha($recibo, $num_compras, $saldo_cubierto)
		{


			$tipo = $recibo[0]["tipo_entrega"];
			if ($tipo == 1 && $saldo_cubierto < 1) {
				$cambio_fecha = $recibo[0]["modificacion_fecha"];
				$class = 'nula';
				$text_probabilidad = "PROBABILIDAD NULA DE COMPRA";
				switch ($cambio_fecha) {

					case 0:
						$class = 'alta';
						$text_probabilidad = "PROBABILIDAD ALTA DE COMPRA";
						break;
					case 1:

						$class = 'media';
						$text_probabilidad = "PROBABILIDAD MEDIA DE COMPRA";
						if ($num_compras > 0) {
							$class = 'alta';
							$text_probabilidad = "PROBABILIDAD ALTA DE COMPRA";
						}


						break;
					case 2:
						$class = 'baja';
						$text_probabilidad = "PROBABILIDAD BAJA DE COMPRA";
						if ($num_compras > 0) {
							$class = 'media';
							$text_probabilidad = "PROBABILIDAD MEDIA DE COMPRA";

						}

						break;
				}

				return div($text_probabilidad, ["class" => $class], 1);

			}


		}
	}

	if (!function_exists('create_seccion_saldos')) {
		function create_seccion_saldos($recibo)
		{

			$recibo = $recibo[0];
			$saldo_cubierto = $recibo["saldo_cubierto"];
			$precio = $recibo["precio"];
			$num_ciclos_contratados = $recibo["num_ciclos_contratados"];
			$costo_envio_cliente = $recibo["costo_envio_cliente"];
			$cargos_envio = $recibo["costo_envio_cliente"];
			$total_a_pagar = $precio * $num_ciclos_contratados + $costo_envio_cliente;
			$base = "col-lg-4 text_saldo_pendiente";
			$text = div(strong("CARGO DE ENVIO") . "<?=br()?>" . $cargos_envio . "MXN", ["class" => $base]);
			$text .= div(strong("MONTO DEL PEDIDO") . "<?=br()?>" . $total_a_pagar . "MXN", ["class" => $base]);
			$saldo_cubierto = $saldo_cubierto . "MXN";
			$saldo_cubierto = ($saldo_cubierto == 0) ? span($saldo_cubierto, ["class" => "sin_pago"]) : span($saldo_cubierto, ["class" => "pago_realizado"]);
			$text .= div(strong("MONTO TOTAL CUBIERTO") . "<?=br()?>" . $saldo_cubierto, ["class" => "col-lg-4 text_saldo_cubierto"]);
			return div($text, ["class" => "row"]);

		}
	}
	if (!function_exists('create_seccion_tipo_entrega')) {
		function create_seccion_tipo_entrega($recibo, $tipos_entregas)
		{

			$tipo = "";
			$id_tipo_entrega = $recibo[0]["tipo_entrega"];
			foreach ($tipos_entregas as $row) {

				if ($row["id"] == $id_tipo_entrega) {
					$tipo = $row["nombre"];
					echo input_hidden(
						[
							"class" => "text_tipo_entrega",
							"value" => $tipo
						]
					);
					break;
				}
			}

			$encabezado = div(strong("TIPO DE ENTREGA"), ["class" => "encabezado_tipo_entrega"], 1);
			$tipo = div(strtoupper($tipo), ["class" => "encabezado_tipo_entrega"], 1);
			return div($encabezado . $tipo, ["class" => "contenedor_tipo_entrega"], 1) . hr();

		}

	}
	if (!function_exists('crea_fecha_entrega')) {
		function crea_fecha_entrega($recibo)
		{

			if (count($recibo) > 0) {
				$recibo = $recibo[0];
				$text = ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) ? icon("fa fa-check-circle") . "PEDIDO ENTREGADO EL " . $recibo["fecha_entrega"] : "";
				return $text;
			}
		}
	}
	if (!function_exists('crea_estado_venta')) {
		function crea_estado_venta($status_ventas, $recibo)
		{

			$status = $recibo[0]["status"];
			$text_status = "";
			foreach ($status_ventas as $row) {

				$id_estatus_enid_service = $row["id_estatus_enid_service"];
				$text_vendedor = $row["text_vendedor"];

				if ($status == $id_estatus_enid_service) {

					$text_status = $text_vendedor;
					break;
				}
			}
			return div($text_status, ["class" => "status_compra"]);
		}
	}
	if (!function_exists('create_seccion_usuario')) {
		function create_seccion_usuario($usuario)
		{


			$text = "";
			foreach ($usuario as $row) {

				$nombre = $row["nombre"];
				$apellido_paterno = $row["apellido_paterno"];
				$apellido_materno = $row["apellido_materno"];
				$email = $row["email"];
				$tel_contacto = $row["tel_contacto"];
				$tel_contacto_alterno = $row["tel_contacto_alterno"];

				$text .= div(strtoupper(append_data([$nombre, $apellido_paterno, $apellido_materno])), 1);
				$text .= div($email, 1);
				$text .= div($tel_contacto, 1);
				$text .= div($tel_contacto_alterno, 1);


				$icon = icon("fa-pencil configurara_informacion_cliente black");
				$text .= div($icon, ["class" => "pull-right dropdown"], 1);

			}

			$encabezado = div("CLIENTE", ["class" => "encabezado_cliente"]);
			$text_usuario = div($text, ["class" => "contenido_domicilio"]);

			return div($encabezado . $text_usuario, ["class" => "contenedor_cliente"]) . hr();

		}
	}
	if (!function_exists('resumen_compras_cliente')) {
		function resumen_compras_cliente($num)
		{

			$text = ($num > 0) ? $num . " COMPRAS A LO LARGO DEL TIEMPO " : "NUEVO PROSPECTO";
			return div($text, ["class" => "compras_en_tiempo"]);
		}
	}

	if (!function_exists('tiene_domilio')) {
		function tiene_domilio($domicilio, $numero = 0)
		{

			$final_text = "";
			$final_numeric = 0;
			if (array_key_exists("domicilio", $domicilio)
				&&
				is_array($domicilio["domicilio"])
				&&
				count($domicilio["domicilio"]) > 0) {

				$final_numeric++;

			} else {
				$final_text = div("SIN DOMICIO REGISTRADO", ["class" => "sin_domicilio padding_10 white"], 1);
			}

			$response = ($numero == 0) ? $final_text : $final_numeric;
			return $response;
		}
	}
	if (!function_exists('create_seccion_domicilio')) {
		function create_seccion_domicilio($domicilio)
		{
			$response = "";

			if (array_key_exists("domicilio", $domicilio) && is_array($domicilio["domicilio"]) && count($domicilio["domicilio"]) > 0) {

				$data_domicilio = $domicilio["domicilio"];
				if ($domicilio["tipo_entrega"] != 1) {

					$response = create_domicilio_entrega($data_domicilio);
				} else {

					$response = create_punto_entrega($data_domicilio);
				}

			} else {
				/*solicita dirección de envio*/
			}

			return $response;
		}
	}
	if (!function_exists('create_seccion_recordatorios')) {
		function create_seccion_recordatorios($recibo)
		{

			$response = "";
			if (count($recibo) > 0) {
				$response = ($recibo[0]["status"] == 6) ? "EMAIL RECORDATORIOS COMPRA " . $recibo[0]["num_email_recordatorio"] : "";
			}
			return $response;
		}
	}

	if (!function_exists('get_link_nota')) {
		function get_link_nota()
		{
			return div(anchor_enid("NOTA", ["class" => "agregar_comentario", "onClick" => "agregar_nota();"]), 1);
		}
	}
	if (!function_exists('get_link_costo')) {
		function get_link_costo($id_recibo, $recibo)
		{


			$recibo = $recibo[0];
			$saldo_cubierto = $recibo["saldo_cubierto"];

			$url = "../pedidos/?costos_operacion=" . $id_recibo . "&saldado=" . $saldo_cubierto;
			return div(anchor_enid("COSTO DE OPERACIÓN", ["href" => $url]), 1);

		}
	}


	if (!function_exists('get_link_cambio_fecha')) {
		function get_link_cambio_fecha($domicilio, $recibo)
		{

			if (get_param_def($domicilio, "domicilio") > 0 && count($recibo) > 0) {
				$recibo = $recibo[0];
				$id_recibo = $recibo["id_proyecto_persona_forma_pago"];
				$status = $recibo["status"];
				$saldo_cubierto_envio = $recibo["saldo_cubierto_envio"];
				$monto_a_pagar = $recibo["monto_a_pagar"];
				$se_cancela = $recibo["se_cancela"];
				$fecha_entrega = $recibo["fecha_entrega"];

				$text = div(div("HORARIO DE ENTREGA", 1) . div($recibo["fecha_contra_entrega"], 1), ["class" => "contenedor_entrega"]);

				//$fecha_contra_entrega = ($recibo["tipo_entrega"] == 1) ? $text : "";
				return div(anchor_enid("FECHA DE ENTREGA",
					[
						"class" => "editar_horario_entrega  text-right ",
						"id" => $id_recibo,
						"onclick" => "confirma_cambio_horario({$id_recibo} , {$status } , {$saldo_cubierto_envio} , {$monto_a_pagar} , {$se_cancela} , '{$fecha_entrega}' )"
					]), 1);

			}


		}
	}
	if (!function_exists('get_link_recordatorio')) {
		function get_link_recordatorio($id_recibo)
		{

			$url = "../pedidos/?recibo=" . $id_recibo . "&recordatorio=1";
			return div(anchor_enid("RECORDATORIO", ["href" => $url]), 1);

		}
	}
	if (!function_exists('create_punto_entrega')) {
		function create_punto_entrega($domicilio)
		{

			$punto_encuentro = "";
			foreach ($domicilio as $row) {

				$id = $row["id_tipo_punto_encuentro"];
				$lugar_entrega = $row["lugar_entrega"];
				$tipo = $row["tipo"];
				$nombre_linea = $row["nombre_linea"];
				$color = $row["color"];
				$numero = $row["numero"];

				switch ($id) {

					//1 | LÍNEA DEL METRO
					case 1:
						$punto_encuentro .=
							strtoupper(strong("ESTACIÓN DEL METRO ") . $lugar_entrega . " LINEA " . $numero . " " . $nombre_linea . " COLOR " . $color);
						break;
					//2 | ESTACIÓN DEL  METRO BUS
					case 2:
						$punto_encuentro .=
							$tipo . " " . $lugar_entrega . " " . $nombre_linea;
						break;

					// 3 | CENTRO COMERCIAL
					case 3:

						break;

					default:

						break;
				}

			}
			$encabezado = div("PUNTO DE ENCUENTRO", ["class" => "encabezado_domicilio"], 1);
			$encuentro = div(strtoupper($punto_encuentro), ["class" => "contenido_domicilio"], 1);
			return div($encabezado . $encuentro, ["class" => "contenedor_domicilio"], 1) . hr();

		}
	}
	if (!function_exists('create_domicilio_entrega')) {
		function create_domicilio_entrega($domicilio)
		{

			$direccion = "";
			foreach ($domicilio as $row) {

				$calle = $row["calle"];
				$numero_exterior = $row["numero_exterior"];
				$numero_interior = $row["numero_interior"];
				$cp = $row["cp"];
				$asentamiento = $row["asentamiento"];
				$municipio = $row["municipio"];
				$estado = $row["estado"];
				$direccion = $calle . " " . " NÚMERO " . $numero_exterior . " NÚMERO INTERIOR " . $numero_interior . " COLONIA " . $asentamiento . " DELEGACIÓN/MUNICIPIO " . $municipio . " ESTADO " . $estado . " CÓDIGO POSTAL " . $cp;

			}
			$encabezado = div("DOMICIO DEL ENVIO", ["class" => "encabezado_domicilio"], 1);
			$direccion = div(strtoupper($direccion), ["class" => "contenido_domicilio"], 1);
			return div($encabezado . $direccion, ["class" => "contenedor_domicilio"], 1) . hr();
		}
	}
	if (!function_exists('get_form_usuario')) {
		function get_form_usuario($usuario)
		{


			if (count($usuario) > 0) {

				$usuario = $usuario[0];
				$nombre = $usuario["nombre"];
				$apellido_paterno = $usuario["apellido_paterno"];
				$apellido_materno = $usuario["apellido_materno"];
				$email = $usuario["email"];
				$telefono = $usuario["tel_contacto"];
				$id_usuario = $usuario["id_usuario"];


				$action = "../../q/index.php/api/usuario/index/format/json/";
				$attr = ["METHOD" => "PUT", "id" => "form_set_usuario", "class" => "form_set_usuario"];

				$form = form_open($action, $attr);
				$form .= div("NOMBRE:", ["class" => "strong"], 1);
				$form .= input(["name" => "nombre", "value" => $nombre, "type" => "text", "required" => "true"]);
				$form .= div("APELLIDO PATERNO:", ["class" => "strong"], 1);
				$form .= input(["name" => "apellido_paterno", "value" => $apellido_paterno, "type" => "text"]);
				$form .= div("APELLIDO MATERNO:", ["class" => "strong"], 1);
				$form .= form_input(["name" => "apellido_materno", "value" => $apellido_materno, "type" => "text"]);
				$form .= div("EMAIL:", ["class" => "strong"], 1);


				$form .= form_input([
					'name' => 'email',
					'value' => $email,
					"required" => "true",
					"class" => "input-sm email email",
					"onkeypress" => "minusculas(this);"
				]);


				$form .= div("TELÉFONO:", ["class" => "strong"], 1);

				$form .= form_input([
					'name' => 'tel_contacto',
					'value' => $telefono,
					"required" => "true",
					'type' => "tel",
					"maxlength" => 13,
					"minlength" => 8,
					"class" => "form-control input-sm  telefono telefono_info_contacto"
				]);

				$form .= form_input([
					"value" => $id_usuario,
					"name" => "id_usuario",
					"type" => "hidden"

				]);


				$form .= guardar("GUARDAR");
				$form .= form_close(place("place_form_set_usuario"));
				$f = addNRow($form, ["id" => "contenedor_form_usuario"]);
				return $f;
			}


		}
	}
}