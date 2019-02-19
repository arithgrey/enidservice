<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function create_vista($servicio)
	{

		$in_session = $servicio["in_session"];
		$extra_color = "";
		$list = "";
		$nombre_servicio = $servicio["nombre_servicio"];
		$id_servicio = $servicio["id_servicio"];
		$url_img = get_url_request("imgs/index.php/enid/imagen_servicio/" . $id_servicio);
		$metakeyword = $servicio["metakeyword"];
		$color = (get_param_def($servicio, "color") !== 0) ? $servicio["color"] : "";
		$flag_servicio = $servicio["flag_servicio"];
		$precio = $servicio["precio"];
		$id_usuario = $servicio["id_usuario"];
		$id_usuario_actual = $servicio["id_usuario_actual"];


		$url_info_producto = get_url_servicio($id_servicio);
		$vista = ($in_session > 0) ? $servicio["vista"] : 0;
		$existencia = ($in_session > 0) ? $servicio["existencia"] : 0;


		$id_error = "imagen_" . $id_servicio;
		$config = [
			'src' => $url_img,
			'id' => $id_error,
			'class' => 'imagen_producto',
			'alt' => $metakeyword,
			'onerror' => "reloload_img( '" . $id_error . "','" . $url_img . "');"
		];

		$img = img($config);

		$p[] = addNRow(get_session_color($color, $flag_servicio, $url_info_producto, $extra_color, $existencia, $in_session));
		$p[] = valida_botton_editar_servicio($in_session, $id_servicio, $id_usuario, $id_usuario_actual);
		$p[] = div(div(get_text_nombre_servicio($nombre_servicio), []), 1);
		$p[] = div(muestra_vistas_servicio($in_session, $vista), 1);
		$producto = div(append_data($p));
		$contenedor_producto = div($producto);


		$b[] = div(anchor_enid($img, ["href" => $url_info_producto]), 1);
		$b[] = div(get_precio_producto($url_info_producto, $precio), 1);
		$b[] = $contenedor_producto;
		$bloque_producto = div(append_data($b), ["class" => "producto_base"]);
		return $bloque_producto;

	}

	function get_base_empresa($paginacion, $busqueda, $num_servicios, $productos)
	{

		$paginacion = addNRow(div($paginacion, 1));
		$l = "";
		foreach ($productos as $row) {
			$l .= div($row, ["class" => 'col-lg-3', "style" => 'margin-top:30px;']);
		}
		$t = addNRow(icon("fa fa-search") . "Tu búsqueda de" . $busqueda . "(" . $num_servicios . "Productos)");
		$t .= addNRow($paginacion);
		$bloque = addNRow(div($t . $l, 1));
		$bloque .= addNRow($paginacion);
		return $bloque;

	}

	function get_text_costo_envio($es_servicio, $costo_envio)
	{

		$text = ($es_servicio == 0) ? div($costo_envio, ["class" => 'informacion_costo_envio'], 1) : "";
		return $text;

	}

	function get_session_color($color, $flag_servicio, $url_info_producto, $extra_color, $existencia, $in_session)
	{

		$color = get_td(get_numero_colores($color, $flag_servicio, $url_info_producto, $extra_color));
		$existencia = get_td(get_en_existencia($existencia, $flag_servicio, $in_session));
		$t = "<tr>" . $color . $existencia . "<tr>";
		$table = "<table class='resumen_colores_producto'>" . $t . "</table>";
		return $table;

	}

	function get_menu_config($num, $num_imagenes, $url_productos_publico)
	{

		$foto_config = ['href' => "#tab_imagenes", 'data-toggle' => "tab"];
		$precios_config = ['href' => "#tab_info_precios", 'data-toggle' => "tab"];

		$precios_inf = ['href' => "#tab_info_producto",
			'data-toggle' => "tab",
			'id' => 'tab_info_producto_seccion',
			'class' => 'detalle'
		];

		$meta_inf = ['href' => "#tab_terminos_de_busqueda", 'data-toggle' => "tab"];

		$list = [
			li(anchor_enid(icon('fa fa-picture-o'), $foto_config), ["class" => valida_active($num, 1)]),
			li(anchor_enid(icon('fa fa-credit-card'), $precios_config), ["class" => valida_active($num, 4), "style" => valida_existencia_imagenes($num_imagenes)]),
			li(anchor_enid(icon('fa fa-info detalle'), $precios_inf), ["style" => valida_existencia_imagenes($num_imagenes)]),
			li(anchor_enid(icon('fa fa-fighter-jet menu_meta_key_words'), $meta_inf),
				["class" => valida_active($num, 3), "style" => valida_existencia_imagenes($num_imagenes)]
			),
			li(anchor_enid(icon("fa fa-shopping-bag") . "VER PUBLICACIÓN",
				[
					"href" => $url_productos_publico,
					"target" => "_blank",
					"style" => 'background: #002565;color: white!important;'
				]), ["style" => valida_existencia_imagenes($num_imagenes)]
			)
		];

		return ul($list, ["class" => "nav nav-tabs"]);

	}

	function get_config_categorias($data, $param)
	{

		$nivel = "nivel_" . $data["nivel"];
		$config = array(
			'class' => 'num_clasificacion ' . $nivel . ' selector_categoria ',
			'size' => '20');

		if ($param["is_mobile"] == 1) {

			$config = array(
				'class' => 'num_clasificacion ' . $nivel . ' 
                          num_clasificacion_phone selector_categoria '
			);
		}

		$info_categorias = $data["info_categorias"];
		$select = select_enid($info_categorias,
			"nombre_clasificacion",
			"id_clasificacion",
			$config);
		return $select;

	}

	function get_add_categorias($data, $param)
	{

		$data["padre"] = $param["padre"];
		$select = div(
			"AGREGAR NUEVO" . icon('fa fa-angle-double-right'),
			["class" => "a_enid_black nueva_categoria_producto top_20",
				"id" => $data["padre"]
			],
			1);
		return $select;
	}

	function get_estado_publicacion($status, $id_servicio)
	{

		$text = ($status == 1) ? "PAUSAR PUBLICACIÓN" : "ACTIVAR PUBLICACIÓN";
		$btn =
			anchor_enid(
				$text,
				[
					"id" => $id_servicio,
					"status" => $status,
					"class" => 'button_enid_eleccion activar_publicacion'
				],
				1);
		return $btn;


	}

	function get_url_venta($extra)
	{
		return "http://enidservice.com/inicio/producto/?producto=" . $extra;
	}

	function une_data($data_servicios, $data_intentos_entregas)
	{

		$new_data = [];
		$data_complete = [];
		$a = 0;
		foreach ($data_servicios as $row) {

			$new_data[$a] = $row;
			$id_servicio = $row["id_servicio"];
			$b = 0;
			foreach ($data_intentos_entregas as $row2) {
				if ($row2["id_servicio"] == $id_servicio) {
					$new_data[$a]["intentos_compras"] = $row2;
					unset($data_intentos_entregas[$b]);
					break;
				}
				$b++;
			}
			$a++;
		}


		$z = 0;
		foreach ($new_data as $row) {

			$data_complete[$z] = [

				"id_servicio" => $row["id_servicio"],
				"vista" => $row["vista"],
				"nombre_servicio" => $row["nombre_servicio"],
				"deseado" => $row["deseado"],
				"valoracion" => $row["valoracion"],
			];
			if (array_key_exists("intentos_compras", $row)) {

				$data_complete[$z]["intentos"] = $row["intentos_compras"]["intentos"];
				$data_complete[$z]["punto_encuentro"] = $row["intentos_compras"]["punto_encuentro"];
				$data_complete[$z]["mensajeria"] = $row["intentos_compras"]["mensajeria"];
				$data_complete[$z]["visita_negocio"] = $row["intentos_compras"]["visita_negocio"];

			} else {
				$data_complete[$z]["intentos"] = 0;
				$data_complete[$z]["punto_encuentro"] = 0;
				$data_complete[$z]["mensajeria"] = 0;
				$data_complete[$z]["visita_negocio"] = 0;
			}

			$z++;
		}
		return $data_complete;
	}

	function create_dropdown_button($id_imagen, $principal = 0)
	{

		$button = div(icon("fa fa-chevron-circle-down"),
			[
				"class" =>
					"btn btn-secondary dropdown-toggle contenedor_imagen_muestra_producto",
				"type" => "button",
				"id" => "dropdownMenuButton",
				"data-toggle" => "dropdown",
				"aria-haspopup" => "true",
				"aria-expanded" => "false"
			]);

		$text = ($principal == 0) ? "Definir como principal" : "Imagen principal";
		$extra_principal = ($principal == 0) ? "" : "blue_enid";
		$item = div(
			icon('fa fa-star',
				[
					"id" => $id_imagen,
					"class" => "dropdown-item imagen_principal " . $extra_principal
				],
				0,
				$text
			));


		$item .=
			div(
				icon('fa fa-times',
					[
						"id" => $id_imagen,
						"class" => "dropdown-item foto_producto"
					],
					0,
					"Quitar")
			);


		$menu = div(
			$item
			,
			[
				"class" => "dropdown-menu",
				"aria-labelledby" => "dropdownMenuButton",
				"style" => "width:220px;border-style:solid;height:50px;z-index:3000;position:absolute;border-style: solid;border-color: #92a8d1;padding:3px;"
			]);

		return div($button . $menu, ["class" => "dropdown cursor"]);

	}

	function valida_tipo_promocion($param)
	{
		$tipo = ($param[0]["flag_servicio"] == 1) ? "SERVICIO" : "PRODUCTO";
		return $tipo;
	}

	function get_nombre_ciclo_facturacion($ciclos, $id_ciclo)
	{
		foreach ($ciclos as $row) {
			$id_ciclo_facturacion = $row["id_ciclo_facturacion"];
			if ($id_ciclo_facturacion == $id_ciclo) {
				return $row["ciclo"];
			}
		}
	}

	function create_colores_disponibles($text_colores)
	{

		$arreglo_colores = explode(",", $text_colores);
		$a = 0;
		$lista_completa = "";
		for ($a = 0; $a < count($arreglo_colores); $a++) {

			$codigo_color = $arreglo_colores[$a];
			$contenido = icon('fa fa-times elimina_color', ["id" => $codigo_color]) . " " . $codigo_color;
			$lista_completa .= div($contenido, ["style" => "background:" . $codigo_color . ";color:white;padding:3px;"]);
		}
		return div($lista_completa, ["id" => 'contenedor_colores_disponibles']);
	}

	function valida_text_numero_articulos($num)
	{

		$text = span("Alerta", ["class" => 'mjs_articulo_no_disponible']) . "este artúculo no se encuentra disponible, agregar nuevo";
		if ($num > 0) {
			$s1 = $num . " Artículo disponible";
			$s2 = $num . " Artículos disponibles";
			$text = ($num > 1) ? $s1 : $s2;
		}
		return $text;
	}

	function agrega_data_servicio($data, $key, $valor)
	{

		$data[$key] = $valor;
		return $data;
	}

	function evalua_utilidad_mas_envio($flag_envio_gratis, $costo_envio, $utilidad)
	{

		if ($flag_envio_gratis == 1) {
			return $utilidad - $costo_envio;
		} else {
			return $utilidad;
		}
	}

	function get_valor_envio($costo_envio, $flag_envio_gratis)
	{
		$costo = ($flag_envio_gratis == 1) ? -100 : 100;
		return $costo;
	}

	function select_producto_usado($valor_actual)
	{

		$usado = ["No", "Si"];
		$list = "<select class='form-control producto_nuevo'>";
		for ($z = 0; $z < count($usado); $z++) {
			if ($z == $valor_actual) {
				$list .= "<option value='" . $z . "' selected>" . $usado[$z] . "</option>";
			} else {
				$list .= "<option value='" . $z . "'>" . $usado[$z] . "</option>";
			}
		}
		$list .= "</select>";
		return $list;
	}

	function get_producto_usado($tipo)
	{
		$usado = ["No", "Si"];
		return $usado[$tipo];
	}

	function create_url_procesar_compra($producto_text,
	                                    $id_servicio,
	                                    $total,
	                                    $ciclo_facturacion,
	                                    $num_ciclos,
	                                    $dominio = "",
	                                    $extension_dominio = "")
	{


		$url_procesar_compra =
			"../procesar/?producto=" . $producto_text . "&plan=" . $id_servicio . "&ciclo_facturacion=" .
			$ciclo_facturacion . "&num_ciclos=" . $num_ciclos . "&total=" . $total . "&dominio=" . $dominio . "&extension_dominio=" . $extension_dominio;
		return $url_procesar_compra;

	}

	function create_table_servicios($servicios)
	{

		$list = "";
		$z = 1;
		$extra = "";
		foreach ($servicios as $row) {

			$id_servicio = $row["id_servicio"];
			$nombre_servicio = $row["nombre_servicio"];
			$status = $row["status"];
			$especificacion = icon('servicio fa fa-file-text-o', ["id" => $id_servicio]);
			$text_estatus = ($status == 0) ? "Inactivo" : "Activo";


			$list .= "<tr>";
			$list .= get_td($especificacion, ["class" => 'especificacion_servicio']);
			$list .= get_td($nombre_servicio, $extra);
			$list .= get_td($text_estatus, ["class" => 'text-center strong']);
			$list .= "</tr>";
			$z++;
		}
		return $list;

	}

	function scroll_terminos($num_terminos)
	{

		$extra = ($num_terminos > 3) ? "scroll_terms" : "";
		return $extra;
	}

	function get_text_ciclo_facturacion($id_ciclo_facturacion)
	{

		$nuevo_text = "";
		switch ($id_ciclo_facturacion) {
			case '1':
				$nuevo_text = "365 Días";

				break;
			case '2':
				$nuevo_text = "30 Días";

				break;

			case '3':
				$nuevo_text = "7 Días";

				break;

			case '4':
				$nuevo_text = "15 Días";

				break;

			case '5':
				$nuevo_text = "Págo único";
				break;


			case '6':
				$nuevo_text = "365 Días";
				break;

			case '7':
				$nuevo_text = "365 Días";
				break;

			case '8':
				$nuevo_text = "365 Días";
				break;

			default:
				# code...
				break;
		}
		return $nuevo_text;
	}

	function is_servicio($row)
	{

		$flag_precio_definido = 0;
		$flag_envio_gratis = $row["flag_envio_gratis"];
		$flag_servicio = $row["flag_servicio"];
		$precio = $row["precio"];
		$extra = "";

		switch ($flag_servicio) {
			case 1:

				if ($flag_precio_definido == 1) {

					$extra = "";
				} else {
					$extra = "A convenir";
				}
				break;
			case 0:

				$extra = ($flag_envio_gratis == 1) ? "Envios gratis a todo México" : "Envios a todo México";

				break;
			default:
				break;
		}
		return $extra;
	}

	function get_precio_producto($url_info_producto, $precio)
	{

		$precio = anchor_enid($precio . 'MXN', ["href" => $url_info_producto, "class" => "text_precio"], 1);
		return $precio;

	}

	function get_numero_colores($color, $flag_servicio, $url_info_producto, $extra)
	{

		if ($flag_servicio != 1) {
			$arreglo_colores = explode(",", $color);
			$num_colores = count($arreglo_colores);
			if ($num_colores > 0) {
				if ($num_colores > 1) {

					return anchor_enid($num_colores . " colores", ["href" => $url_info_producto]);

				} else {

					return anchor_enid($num_colores . " color", ["href" => $url_info_producto]);
				}

			}
		}
	}

	function get_text_nombre_servicio($nombre_servicio)
	{
		$text_nombre_servicio = heading_enid(substr($nombre_servicio, 0, 70), 3,
			["class" => "nombre_servicio"]);
		return $text_nombre_servicio;
	}

	function get_en_existencia($existencia, $flag_servicio, $in_session)
	{
		if ($flag_servicio == 0) {
			return informacion_existencia_producto($existencia, $in_session);
		}
	}

	function informacion_existencia_producto($existencia, $in_session)
	{

		if ($in_session == 1) {
			$msj = ($existencia > 0) ? span($existencia . " En existencia ") : span("INVENTARIO LIMITADO");
			return $msj;
		}
	}

	function muestra_vistas_servicio($in_session, $vistas)
	{
		if ($in_session == 1) {
			return div($vistas . " personas alcanzadas");
		}
	}

	function valida_botton_editar_servicio($in_session, $id_servicio, $id_usuario, $id_usuario_registro_servicio)
	{


		if ($in_session > 0) {
			if ($id_usuario == $id_usuario_registro_servicio) {
				return icon("servicio fa fa-pencil", ["id" => $id_servicio]);
			}
		}

	}

	function get_rango_entrega($id_perfil, $actual, $attributes = '', $titulo, $minimo = 1, $maximo = 10)
	{


		$select = "";
		if ($id_perfil == 3) {

			$att = add_attributes($attributes);
			$titulo = heading_enid($titulo, 4);
			$select .= "<select " . $att . ">";

			for ($a = $minimo; $a < $maximo; $a++) {
				if ($a == $actual) {
					$select .= "<option value='" . $a . "' selected>" . $a . "</option>";
				} else {
					$select .= "<option value='" . $a . "'>" . $a . "</option>";
				}

			}
			$select .= "</select>";
			$select .= place("response_tiempo_entrega");

			return div(div($titulo, ["class" => "col-lg-6"]) . div($select, ["class" => "col-lg-6"]), 1);
		}

	}

	function get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping)
	{

		$select = "";
		if ($id_perfil == 3) {

			$link_dropshipping = (strlen($link_dropshipping) > 3) ? $link_dropshipping : icon("fa fa fa-pencil");
			$titulo = heading_enid("LINK DROPSHIPPING", 4);
			$select .= div($link_dropshipping, ["class" => "text_link_dropshipping", "onclick" => "muestra_cambio_link_dropshipping('" . $id_servicio . "')"]);
			$select .= div(input([
					"class" => "form-control",
					"name" => "link_dropshipping",
					"required" => "true",
					"placeholder" => "Link de compra",
					"type" => "url",
					"value" => $link_dropshipping
				]) . guardar("GUARDAR")
				,
				["class" => "input_link_dropshipping"]);
			$select .= place("response_link_dropshipping");
			$select .= input_hidden(["name" => "servicio", "value" => $id_servicio]);


			return div(div($titulo, ["class" => "col-lg-6"]) . div($select, ["class" => "col-lg-6"]), 1);
		}

	}

	function sumatoria_array($array, $key)
	{

		return array_sum(array_column($array, $key));
	}

	function agregar_imgs()
	{

		$cancelar = anchor_enid(
			icon('fa fa fa-times'),
			[
				'class' => 'btn_enid_blue cancelar_carga_imagen cancelar_img pull-right',
				'style' => "color:white!important"
			]
			, 1
		);

		$agregar = heading_enid("AGREGAR IMAGENES", 3, ["class" => "titulo_agregar_imagenes"], 1);
		$place = place("place_img_producto");
		$imgs = div(append_data([$agregar, $place]), ["class" => "col-lg-4 col-lg-offset-4"]);

		return div(append_data([$cancelar, $imgs]), ["class" => "contenedor_agregar_imagenes"]);

	}

	function get_base_youtube($url)
	{

		$text = "";
		$f = 0;
		for ($a = strlen($url) - 1; $a > 1; $a--) {

			if ($url[$a] === "=" || $url[$a] === "/") {

				$f = $a;
				break;
			}
		}

		for ($b = ($f + 1); $b < strlen($url); $b++) {
			$text .= $url[$b];
		}
		$url = "https://www.youtube.com/embed/" . $text;
		return $url;

	}

	function get_heading_servicio($tipo_promocion, $nuevo_nombre_servicio, $servicio)
	{

		$response = [];

		$ie_nombre = input([
			"type" => "text",
			"name" => "q2",
			"class" => "nuevo_producto_nombre",
			"onkeyup" => "transforma_mayusculas(this)",
			"value" => get_campo($servicio, 'nombre_servicio'),
			"required" => true],
			1);

		$h = append_data([icon('fa fa-pencil text_nombre_servicio'), $tipo_promocion, $nuevo_nombre_servicio]);

		array_push($response, heading_enid($h, 4));
		array_push($response, form_open("", ['class' => 'form_servicio_nombre_info input_nombre_servicio_facturacion ']));
		array_push($response, input_hidden(["name" => "q", "value" => "nombre_servicio"], 1));
		array_push($response, div($ie_nombre, ['class' => 'col-lg-9']));
		array_push($response, div(guardar("GUARDAR", ["class" => "info_guardar_nombre_servicio"], 1), ['class' => 'col-lg-3']));
		array_push($response, form_close());
		$response = addNRow(append_data($response));
		return $response;

	}

	function get_form_youtube($valor_youtube)
	{

		$r = [];
		$i = input([
			"type" => "hidden",
			"name" => "q",
			"value" => "url_vide_youtube"
		],
			1);


		$p = div("", ["class" => "place_url_youtube"], 1);

		array_push($r, form_open("", ["class" => "form_servicio_youtube input_url_youtube contenedor_info_youtube"]));

		array_push($r, input([
			"type" => "url",
			"name" => "q2",
			"class" => 'url_youtube',
			"value" => $valor_youtube,
			"required" => true
		], 1));

		array_push($r, div($i . $p, ['class' => 'col-lg-9']));
		array_push($r, div(guardar("GUARDAR", ["class" => "guardar_video_btn"], 1), ['class' => 'col-lg-3']));
		array_push($r, form_close());

		return append_data($r);

	}

	function get_form_descripcion($nueva_descripcion)
	{

		$r = [];
		array_push($r, form_open("", ["class" => "form_servicio_desc input_desc_servicio_facturacion"]));
		array_push($r, input([
				"type" => "hidden",
				"name" => "q",
				"value" => "descripcion"
			], 1)
		);

		array_push($r, div("-" . $nueva_descripcion, ["id" => "summernote"], 1));
		array_push($r, div(guardar("GUARDAR", ["class" => "btn_guardar_desc"], 1)));
		array_push($r, form_close());
		return append_data($r);
	}

	function get_form_rango_entrega($id_perfil, $stock)
	{


		$r = [];
		array_push($r, form_open("", ["class" => "form_stock"]));
		array_push($r, get_rango_entrega(
			$id_perfil,
			$stock,
			["name" => "stock",
				"class" => "stock form-control"
			],
			"ARTICULOS EN STOCK", 0, 100));

		array_push($r, form_close());
		return append_data($r);
	}

	function get_form_link_drop_shipping($id_perfil, $id_servicio, $link_dropshipping)
	{

		$r = [];
		array_push($r, form_open("", ["class" => "form_dropshipping"]));
		array_push($r, get_link_dropshipping($id_perfil, $id_servicio, $link_dropshipping));
		array_push($r, form_close());
		return append_data($r);

	}

	function get_seccion_compras_casa($flag_servicio, $entregas_en_casa)
	{

		$atencion_en_casa = ($flag_servicio == 1) ? "NO" : "NO, SOLO HAGO ENVÍOS";
		$extra_extrega_casa_si = valida_activo_entregas_en_casa(1, $entregas_en_casa);
		$extra_extrega_casa_no = valida_activo_entregas_en_casa(0, $entregas_en_casa);

		$confirmar =
			anchor_enid(
				"SI",
				[
					"id" => '1',
					"class" => 'button_enid_eleccion entregas_en_casa_si entregas_en_casa ' . $extra_extrega_casa_si
				]);


		$omitir =
			anchor_enid(
				$atencion_en_casa,
				[
					"id" => '0',
					"class" => 'button_enid_eleccion entregas_en_casa_no entregas_en_casa ' . $extra_extrega_casa_no
				]
			);

		return get_btw($confirmar, $omitir, "display_flex_enid");

	}

	function get_seccion_telefono_publico($has_phone, $telefono_visible, $activo_visita_telefono, $baja_visita_telefono)
	{

		$visible = div(append_data([

			anchor_enid(
				"SI",
				['id' => 1,
					'class' => 'button_enid_eleccion 
                telefono_visible ' . $activo_visita_telefono
				]
			),
			text_agregar_telefono($has_phone, $telefono_visible)


		]), ["class" => "seccion_agregar_telefono"]);


		$no_visible = anchor_enid("NO, OCULTAR MI TELÉFONO",
			[
				'id' => 0,
				'class' => 'button_enid_eleccion  no_tel telefono_visible 
                ' . $baja_visita_telefono
			]);


		return get_btw($visible, $no_visible, "display_flex_enid");

	}

	function get_configuracion_contra_entrega($contra_entrega, $id_servicio)
	{

		$v = valida_activo_vista_telefono($contra_entrega, 1);
		$v2 = valida_activo_vista_telefono($contra_entrega, 0);
		$si = div(
			anchor_enid(
				"SI",
				[
					'id' => 1,
					'class' => 'button_enid_eleccion  ' . $v,
					'onClick' => "contra_entrega(1, '{$id_servicio}')"
				]
			)
		);

		$no = anchor_enid("NO, SOLO ENVÍOS A DOMICILIO POR PAQUETERÍA",
			[
				'id' => 0,
				'class' => 'button_enid_eleccion ' . $v2,
				'onClick' => "contra_entrega(0, '{$id_servicio}')"
			]
		);

		return get_btw($si, $no, "display_flex_enid");

	}


	function get_seccion_ventas_mayoreo($venta_mayoreo)
	{

		$activo = valida_activo_ventas_mayoreo(1, $venta_mayoreo);
		$baja = valida_activo_ventas_mayoreo(0, $venta_mayoreo);

		$mayoreo
			= anchor_enid("SI",
			[
				"id" => '1',
				"class" => 'button_enid_eleccion venta_mayoreo ' . $activo
			]);


		$menudeo = anchor_enid("NO",
			[
				"id" => '0',
				"class" =>
					'button_enid_eleccion venta_mayoreo ' . $baja
			]
		);

		return get_btw($mayoreo, $menudeo, "ventas_mayoreo display_flex_enid");

	}

	function get_form_tags($id_servicio, $metakeyword_usuario)
	{

		$r = [];

		$meta_format = create_meta_tags($metakeyword_usuario, $id_servicio);
		$r[] = div($meta_format, ["class" => "info_meta_tags"], 1);
		$r[] = form_open("", ["class" => "form_tag", "id" => "form_tag"]);
		$r[] = input([
			"type" => "hidden",
			"name" => "id_servicio",
			"class" => "id_servicio",
			"value" => $id_servicio
		]);
		$in = get_btw(div("AGREGAR"), input([
			"type" => "text",
			"name" => "metakeyword_usuario",
			"required" => true,
			"placeholder" => "Palabra como buscan tu producto",
			"class" => "metakeyword_usuario"]),
			"agregar_tags display_flex_enid"
		);
		$r[] = $in;
		$r[] = form_close(place("contenedor_sugerencias_tags"));
		return append_data($r);


	}

	function get_form_costo_unidad($precio, $text_precio_unidad)
	{

		$r = [];

		array_push($r, heading_enid("PRECIO POR UNIDAD", 4));

		array_push($r, anchor_enid(
				$text_precio_unidad,
				["class" => "a_precio_unidad text_costo informacion_precio_unidad"],
				1)
		);

		array_push($r, form_open("", ["class" => "form_costo input_costo contenedor_costo"]));

		$in = get_btw(input([
			"type" => "number",
			"name" => "precio",
			"step" => "any",
			"class" => "form-control ",
			"value" => $precio
		]), div("MXN", ["class" => "mxn"]), "display_flex_enid");

		array_push($r, $in);


		array_push($r, guardar("GUARDAR"));
		array_push($r, form_close(place("place_registro_costo")));
		return append_data($r);

	}

	function get_tabla_colores()
	{

		$colores_esp = ["Turquesa", "Emerland", "Peterriver", "Amatista", "Wetasphalt", "Mar verde", "Nefritis", "Belizehole", "Glicinas", "Medianoche azul", "Girasol", "Zanahoria", "Alizarina", "Nubes", "Hormigón", "Naranja", "Calabaza", "Granada", "Plata", "Amianto", "Blanco", "Blue", "Cafe", "Morado", "Morado 2", "Azul", "Azul", "Verde", "Verde", "Verde 2", "Amarillo", "Amarillo 2", "Amarillo 3", "Amarillo 4", "Amarillo 5 ", "Gris", "Gris 2", "Gris 3", "Gris 4", "Gris 5", "Gris 6"];
		$codigo_colores = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400",
			"#c0392b", "#bdc3c7", "#7f8c8d", "#fbfcfc", "#1b4f72", "#641e16", "#512e5f", "#4a235a", "#154360", "#1b4f72", " #0e6251", " #0b5345", " #186a3b", " #7d6608", " #7e5109", "#784212", "#6e2c00", "#626567", "#7b7d7d", "#626567", "#4d5656", " #424949", " #1b2631", "#17202a"];

		$response = [];
		for ($a = 0; $a < count($colores_esp); $a++) {

			$response[] = div("",
				["class" => "colores", "style" => "background:{$codigo_colores[$a]}", "id" => $codigo_colores[$a]]);

		}
		return div(append_data($response), ["class" => "colores_disponibles"]);

	}

	function get_view_sugerencias($servicios, $is_mobile)
	{


		$r = [];
		$imagenes = [];
		foreach ($servicios as $row) {

			$extra_color = "style='margin-left:5px;color: black;font-weight:bold;'";
			$list = "";
			$flag = 0;
			$nombre_servicio = $row["nombre_servicio"];
			$id_servicio = $row["id_servicio"];
			$flag_envio_gratis = $row["flag_envio_gratis"];
			$url_img = get_url_request("imgs/index.php/enid/imagen_servicio/" . $id_servicio);

			$metakeyword = $row["metakeyword"];
			$color = isset($row["color"]) ? $row["color"] : "";
			$flag_servicio = $row["flag_servicio"];
			$precio = $row["precio"];
			$costo_envio = "";
			if ($flag_servicio == 0) {
				$costo_envio = $row["costo_envio"]["text_envio"]["cliente_solo_text"];
			}
			$url_info_producto = "../producto/?producto=" . $id_servicio;
			$url_venta = "../../producto/?producto=" . $id_servicio;
			$extra = "";
			$flag = 0;
			$flag++;

			$existencia = 0;
			$vista = 0;

			$img = img([
				'src' => $url_img,
				'title' => 'Ver artículo',
				'alt' => $metakeyword,
				'onerror' => "this.onerror=null;this.src='" . $url_img . "';"
			]);

			$imagenes[] = div(anchor_enid($img, ["href" => $url_info_producto]), ["class" => "img_sugerencia"]);

		}
		$r[] = div(append_data($imagenes), ["class" => "contenedor_sugeridos"]);
		return append_data($r);

	}

}