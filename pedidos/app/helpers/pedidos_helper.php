<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function texto_pre_pedido($recibo, $data)
    {

        $path = pr($recibo, "url_img_servicio");
        $nombre_cliente = '';
        $numero_telefonico = '';

        $usuario_cliente = prm_def($data, 'usuario_cliente');
        if (es_data($usuario_cliente)) {
            $nombre_cliente = format_nombre($usuario_cliente);
            $numero_telefonico = phoneFormat(pr($usuario_cliente, 'tel_contacto'));
        }

        $texto_previo = _text_(
            'Orden de compra #',
            pr($recibo, 'id'),
            'cliente',
            $nombre_cliente,
            'tel',
            $numero_telefonico
        );

        $data['url_img_post'] = path_imagen_web($path);
        $data['titulo'] = strtoupper($texto_previo);
        return $data;
    }

    function propietario($data, $usurio_actual, $usuario_venta, $id_usuario_referencia, $si_falla = FALSE)
    {

        $puede_repartir = es_repartidor($data);
        $es_propietario = ($usurio_actual == $usuario_venta
            ||
            $usurio_actual == $id_usuario_referencia
            ||
            $puede_repartir
        );

        if ($si_falla !== FALSE) {
            if (!$es_propietario) {
                redirect($si_falla);
            }
        }

        return $es_propietario;
    }


    function info_estado_venta($status_ventas, $recibo, $data, $es_venta_cancelada, $id_recibo)
    {

        if (!is_mobile()) {

            $response = d(crea_estado_venta($status_ventas, $recibo));
        } else {

            $contenido[] = enviar_a_reparto($data, $es_venta_cancelada, $status_ventas);
            $contenido[] = repatidor($data, $id_recibo);
            $response = append($contenido);
        }
        return $response;
    }

    function render_pendidos($data)
    {

        $id_orden_compra = $data["orden"];
        $status_ventas = $data["status_ventas"];
        $productos_orden_compra = $data["productos_orden_compra"];
        $es_venta_comisionada = $data['es_venta_comisionada'];
        $usuario_comision = $data['usuario_comision'];
        $id_cliente = pr($productos_orden_compra, 'id_usuario');
        $domicilios = $data["domicilios"];
        $num_compras = $data["num_compras"];
        $id_recibo = $data["id_recibo"];
        $cupon = $data['cupon'];
        $negocios = $data['negocios'];
        $usuario_tipo_negocio = $data['usuario_tipo_negocio'];
        $id_perfil = $data['id_perfil'];
        $usuario = $data["usuario"];
        $es_vendedor = $data['es_vendedor'];
        $es_venta_cancelada = es_orden_cancelada($data);
        $menu = menu();
        $re[] = d($menu, 'col-sm-12 mr-5 pr-5 d-md-none');

        $id_status = pr($productos_orden_compra, 'status');

        $saldo_cubierto = pr($productos_orden_compra, "saldo_cubierto");
        $re[] = notificacion_lista_negra($data);
        $re[] = frm_pedidos($data, $es_venta_comisionada, $usuario_comision, $id_orden_compra);
        $re[] = info_estado_venta($status_ventas, $productos_orden_compra, $data, $es_venta_cancelada, $id_recibo);
        $re[] = crea_seccion_solicitud($productos_orden_compra);
        $re[] = crea_seccion_productos($productos_orden_compra);
        $re[] = crea_fecha_entrega($productos_orden_compra);
        $re[] = create_fecha_contra_entrega($productos_orden_compra, $domicilios, $es_venta_cancelada);
        $re[] = fecha_espera_servicio($productos_orden_compra, $data["servicio"]);
        $re[] = notificacion_cambio_fecha(
            $productos_orden_compra,
            $num_compras,
            $saldo_cubierto
        );

        $re[] = crea_seccion_recordatorios($data["recordatorios"]);


        $re[] = frm_nota($id_orden_compra);
        $re[] = create_seccion_comentarios($data["comentarios"]);
        $re[] = seccion_historia_cliente($data);
        $re[] = create_seccion_comentarios(
            $data["historia_compra_tiempo"],
            'Notas y comentarios de ordenes de compra pasadas',
            1
        );

        $response[] = d(d($re, 12), 8);


        $seccion_venta[] = compra(
            $es_venta_cancelada,
            $productos_orden_compra,
            $domicilios,
            $usuario,
            $id_recibo,
            $cupon,
            $es_vendedor,
            $id_perfil,
            $status_ventas,
            $data
        );

        $response[] = d(
            $seccion_venta,
            4
        );
        $response[] = hiddens_detalle($productos_orden_compra);
        $tipos_entregas = $data["tipos_entregas"];

        $response[] = opciones_compra(
            $data,
            $productos_orden_compra,
            $id_recibo,
            $es_vendedor,
            $tipos_entregas,
            $es_venta_cancelada
        );

        $response[] = hiddens(['class' => 'id_usuario_referencia', 'value' => $data['id_usuario_referencia']]);
        $response[] = hiddens(['class' => 'es_lista_negra', 'value' => es_lista_negra($data)]);

        return d($response, _10auto);
    }

    function opciones_compra($data, $recibo, $id_recibo, $es_vendedor, $tipos_entregas, $es_venta_cancelada)
    {


        $id_orden_compra = $data["orden"];
        $contenido[] = d(_titulo('¿Hay algo que hacer?'), 'mb-5  text-center');
        $x[] = tracker($id_orden_compra, $es_venta_cancelada);
        $x[] = link_cambio_estado_venta();

        $x[] = link_cambio_fecha($recibo, $id_orden_compra);
        $x = link_cambio_domicilio($data, $x);
        $x = link_recordatorio($data, $x);
        $x = link_garantia($data, $x);

        $x[] = link_nota();
        $x = lista_negra($x, $recibo, $es_vendedor);

        $text = intento_recuperacion($recibo, $data);
        if ($text['es_visible']) {
            $x[] = $text['text'];
        }
        $x = intento_reventa($x, $recibo, $data);
        $x = imprimir_recibo($x, $recibo, $tipos_entregas, $data);

        $contenido[] = d_c($x, ['class' => 'mt-4 elemento_menu border-bottom']);
        return gb_modal($contenido, 'modal_opciones_compra');
    }

    function link_cambio_domicilio($data, $response)
    {

        $id_orden_compra = $data["orden"];
        if (!es_orden_cancelada($data)) {
            $path = path_enid(
                'pedido_seguimiento',
                _text($id_orden_compra, '&domicilio=1&asignacion_horario_entrega=1')
            );
            $form[] =
                a_enid(
                    "Cambiar dirección de entrega",
                    [
                        'class' => 'black text-uppercase',
                        "onclick" => "confirma_cambio_domicilio('" . $path . "')",
                    ]
                );
            $response[] = append($form);
        }
        return $response;
    }


    function formulario_arquetipos(
        $data,
        $id_usuario,
        $negocios,
        $usuario_tipo_negocio,
        $unicos
    ) {

        $response = [];
        $contestados = array_unique($unicos);

        if (es_administrador($data)) {

            $response[] = _titulo('¿Como es tu cliente?', 2);
            $id_tipo_negocio = pr($usuario_tipo_negocio, "idtipo_negocio", 39);
            $negocio_registrado = pr($usuario_tipo_negocio, "nombre", '');
            $text_tipo = _titulo('tipo negocio', 5);
            $response[] = text_icon(
                _text_(_editar_icon, 'editar_usuario_tipo_negocio'),
                _titulo($negocio_registrado, 4)
            );
            $config_form = ["class" => 'form_usuario_tipo_negocio d-none'];
            $response[] = form_open('', $config_form);
            $tipo = create_select_selected(
                $negocios,
                'idtipo_negocio',
                'nombre',
                $id_tipo_negocio,
                'tipo_negocio',
                'usuario_tipo_negocio'
            );

            $response[] = flex($text_tipo, $tipo, _between);
            $response[] = hiddens(['name' => 'id_usuario', 'value' => $id_usuario]);

            $response[] = form_close();
            $tipo_tag_arquetipo = $data['tipo_tag_arquetipo'];


            foreach ($tipo_tag_arquetipo as $row) {

                $descripcion = $row['tipo'];
                $tipo = $row['id_tipo_tag_arquetipo'];
                $clase_form = 'form_tag_arquetipo mt-5';
                $response[] = form_open("", ["class" => $clase_form]);
                $class = _text('tag', $tipo);
                $input = input_frm(
                    '',
                    $descripcion,
                    [
                        'class' => $class,
                        'id' => $class,
                        'name' => 'tag',
                        'onkeyup' => "this.value = this.value.toUpperCase();"

                    ],
                    '¿Falta este dato no?'
                );

                $fue_contestado = in_array($tipo, $contestados);
                $icon_registro = ($fue_contestado) ? icon(_text_(_check_icon, 'border-bottom')) : '';
                $margen = ($fue_contestado) ? 'mr-4' : 'mr-5';
                $submit = flex(btn('Guardar'), $icon_registro, _between, $margen);

                $response[] = flex_md($input, $submit, _text_(_between, _mbt5), _8p);
                $response[] = hiddens(['name' => 'usuario', 'value' => $id_usuario]);
                $response[] = hiddens(['name' => 'tipo', 'value' => $tipo]);
                $response[] = form_close();
            }

            return d(d($response, 'col-sm-12 p-0'), _text_('row', _mbt5));
        }
        return append($response);
    }

    function tags_arquetipo($data)
    {


        $response = [];
        $es_administrador = es_administrador($data);
        $unicos = [];
        $respuestas = '';
        if ($es_administrador) {
            $tag_arquetipo = $data['tag_arquetipo'];
            $tipo_tag_arquetipo = $data['tipo_tag_arquetipo'];

            $tipo = pr($tipo_tag_arquetipo, 'tipo');
            $prioridad_1[] = d_p($tipo, _text_('mt-3 ', _strong));
            $prioridad_2[] = d_p(search_bi_array($tipo_tag_arquetipo, 'id_tipo_tag_arquetipo', 2, 'tipo'), _text_('mt-3 ', _strong));
            $prioridad_3[] = d_p(search_bi_array($tipo_tag_arquetipo, 'id_tipo_tag_arquetipo', 3, 'tipo'), _text_('mt-3 ', _strong));
            $prioridad_4[] = d_p(search_bi_array($tipo_tag_arquetipo, 'id_tipo_tag_arquetipo', 4, 'tipo'), _text_('mt-3 ', _strong));
            $prioridad_5[] = d_p(search_bi_array($tipo_tag_arquetipo, 'id_tipo_tag_arquetipo', 5, 'tipo'), _text_('mt-3 ', _strong));
            $prioridad_6[] = d_p(search_bi_array($tipo_tag_arquetipo, 'id_tipo_tag_arquetipo', 6, 'tipo'), _text_('mt-3 ', _strong));
            $prioridad_7[] = d_p(search_bi_array($tipo_tag_arquetipo, 'id_tipo_tag_arquetipo', 7, 'tipo'), _text_('mt-3 ', _strong));

            foreach ($tag_arquetipo as $row) {


                $tag = $row['tag'];
                $id_tipo_tag_arquetipo = $row['id_tipo_tag_arquetipo'];

                $base = 'ml-5 f9';

                $icono_baja = _text_(_eliminar_icon, 'baja_tag_arquetipo');
                $respuesta = _text_('-', $tag);
                $config = ['id' => $row['id']];
                $str = text_icon($icono_baja, $respuesta, $config, 0);
                switch ($id_tipo_tag_arquetipo) {

                    case 1:
                        $prioridad_1[] = li($str, $base);
                        $unicos[] = 1;
                        break;
                    case 2:
                        $prioridad_2[] = li($str, $base);
                        $unicos[] = 2;
                        break;
                    case 3:
                        $prioridad_3[] = li($str, $base);
                        $unicos[] = 3;
                        break;
                    case 4:
                        $prioridad_4[] = li($str, $base);
                        $unicos[] = 4;
                        break;
                    case 5:
                        $prioridad_5[] = li($str, $base);
                        $unicos[] = 5;
                        break;
                    case 6:
                        $prioridad_6[] = li($str, $base);
                        $unicos[] = 6;
                        break;
                    case 7:
                        $prioridad_7[] = li($str, $base);
                        $unicos[] = 7;
                        break;
                    default:
                }
            }
            $ext = 'border p-3 border-secondary';
            $response[] = d($prioridad_1, $ext);
            $response[] = d($prioridad_2, $ext);
            $response[] = d($prioridad_3, $ext);
            $response[] = d($prioridad_4, $ext);
            $response[] = d($prioridad_5, $ext);
            $response[] = d($prioridad_6, $ext);
            $response[] = d($prioridad_7, $ext);

            $respuestas = d(d($response, 'col-sm-12 p-0'), _text_('row', _mbt5));
        }
        return [
            'respuestas' => $respuestas,
            'unicos' => $unicos
        ];
    }

    function render_seguimiento($data, $params)
    {

        $productos_orden_compra = $data["productos_orden_compra"];
        $id_servicio = $data["id_servicio"];

        $resumen_orden_compra = resumen_orden($data);
        if (is_mobile()) {
            $z[] = $resumen_orden_compra;
        }
        $z[] = seguimiento($data);
        if (!is_mobile()) {
            $z[] = $resumen_orden_compra;
        }

        $r[] = append($z);

        $otros_articulis_titulo = _titulo('Aquí te dejamos más cosas que te podrían interesar!', 2);
        $r[] = d($otros_articulis_titulo, 'mt-5 d-none sugerencias_titulo col-sm-12 ');
        $r[] = d(
            place("place_tambien_podria_interezar"),
            "col-sm-12"
        );
        $r[] = botones_ver_mas();
        $r[] = hiddens(
            [
                "value" => $data["notificacion_pago"],
                "class" => "notificacion_pago",
            ]
        );
        $r[] = hiddens(
            [
                "value" => $data["orden"],
                "class" => "orden"
            ]
        );
        $r[] = hiddens(
            [
                "value" => $id_servicio,
                "class" => "qservicio"
            ]
        );
        $r[] = gb_modal(notifica_entrega_modal($productos_orden_compra, $data), 'modal_notificacion_entrega');


        $response[] = d($r, 8, 1);
        $response[] = modal_opciones_cancelacion($data, $params);
        $response[] = modal_ingreso_cancelacion($data, $params);
        return append($response);
    }
    function botones_ver_mas()
    {

        $link_productos =  format_link("Ver más promociones", [
            "href" => path_enid("search", _text("/?q2=0&q=&order=", rand(0, 8), '&page=', rand(0, 5))),
            "class" => "border"
        ]);

        $link_facebook =  format_link("Facebook", [
            "href" => path_enid("facebook", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_'
        ], 0);

        $link_instagram =  format_link("Instagram", [
            "href" => path_enid("fotos_clientes_instagram", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_'
        ], 0);


        $response[] = d($link_productos, 4, 1);
        $response[] = d($link_facebook, 4, 1);
        $response[] = d($link_instagram, 4, 1);

        return d($response, 'col-sm-12 row mt-5');
    }
    function modal_opciones_cancelacion($data, $params)
    {
        $response = '';
        if ($data['in_session']) {


            $nueva_fecha = btn(
                'Cambiar fecha de entrega',
                [
                    'class' => 'mt-4'
                ]
            );

            $razon_cancelacion = btn(
                'Cancelar orden de compra',
                [
                    'class' => 'mt-4 confirma_cancelacion',
                    'style' => 'background:red!important;'
                ]
            );


            $id_recibo = prm_def($params, 'seguimiento');
            $link = path_enid('pedidos_recibo', _text($id_recibo, '&fecha_entrega=1'));

            $botones[] = a_enid($nueva_fecha, ['href' => $link]);
            $botones[] = $razon_cancelacion;
            $contenido[] = d($botones, 'seccion_opciones');
            $contenido[] = d('', 'seccione_opciones_cancelado d-none');
            $contenido[] = hiddens(['class' => 'recibo', 'id' => 'recibo', 'value' => $id_recibo]);

            $response = gb_modal(append($contenido), 'modal_opciones_cancelacion');
        }
        return $response;
    }

    function modal_ingreso_cancelacion($data, $params)
    {
        $response = '';
        if ($data['in_session']) {


            $form_otros[] = _titulo('¿Cual fue el motivo?');
            $form_otros[] = form_open('', ['class' => 'form_ingreso_cancelacion mt-5']);
            $form_otros[] = input_frm(
                '',
                '¿Motivo?',
                [
                    'class' => 'tipificacion',
                    'id' => 'tipificacion',
                    'name' => 'tipificacion',
                    'placeholder' => '',
                    'type' => 'text',
                    'required' => true
                ]
            );
            $id_recibo = prm_def($params, 'seguimiento');
            $form_otros[] = hiddens(['name' => 'recibo', 'value' => $id_recibo]);
            $form_otros[] = hiddens(['name' => 'tipo', 'value' => 2]);
            $form_otros[] = hiddens(['name' => 'status', 'value' => 2]);
            $form_otros[] = hiddens(['name' => 'cancelacion', 'value' => 1]);
            $form_otros[] = d(btn('Agregar'), 'mt-5');
            $form_otros[] = form_close();

            $response = gb_modal($form_otros, 'modal_ingresar_cancelacion');
        }
        return $response;
    }

    function seguimiento($data)
    {

        $es_vendedor = $data["es_vendedor"];
        $r[] = _titulo("¿Dónde se encuentra mi pedido?");
        $tiempo = tiempo($data, $es_vendedor);
        $r[] = d($tiempo, "timeline mt-5", 1);

        return d($r, 'col-sm-8 mt-5');
    }

    function texto_no_puede_repartir($data, $texto, $saldo_cubierto, $id_orden_compra, $id_servicio)
    {
        if (!puede_repartir($data)) {

            $texto[] = nota_compra($saldo_cubierto, $id_orden_compra);
            $texto[] = format_link(
                'comprar nuevamente',
                [
                    'href' => path_enid('producto', $id_servicio),
                    'class' => 'mt-5'
                ]
            );
        }
        return $texto;
    }

    function texto_orden_administrador($data, $es_orden_entregada, $texto)
    {

        if ($data['es_administrador']) {

            $se_define_repartidor = (es_data($data['usuario_entrega']));
            $usuario_entrega = ($se_define_repartidor) ? format_nombre($data['usuario_entrega']) : '';

            $nombre = _text_('Entregará ', $usuario_entrega);
            $nombre = ($se_define_repartidor) ? $nombre : 'aún no hay repartidor asignado :(';

            if (!$es_orden_entregada && !$se_define_repartidor) {

                $texto[] = d($nombre, 'mt-5 text-center p-2 text-uppercase  bg-light border border-secondary');
            }

            $usuario_venta = (es_data($data['vendedor'])) ? format_nombre($data['vendedor']) : '';
            $nombre = _text_('Agenda ', $usuario_venta);
            $texto[] = d($nombre, 'mt-3 text-center p-2 text-uppercase bg-light border border-secondary');
        }
        return $texto;
    }

    function seccion_orden_por_entregar($productos_orden_compra, $data, $tipo_entrega, $es_servicio, $fecha)
    {

        $response = "";
        $es_orden_cancelada_engregada = es_orden_entregada_o_cancelada($productos_orden_compra, $data);
        if (!$es_orden_cancelada_engregada && $tipo_entrega == 2) {

            $es_contra_entrega_domicilio = es_contra_entrega_domicilio($productos_orden_compra);
            $formato_domicilio = ($es_contra_entrega_domicilio) ?
                'TIENES UNA CITA EL ' : "SE  ESTIMA QUE TU PEDIDO LLEGARÁ EL";

            $response = ($es_servicio) ? "PLANEADO PARA EL DÍA " : $formato_domicilio;
            $fecha_hora_entrega = es_contra_entrega_domicilio($productos_orden_compra, 1, $fecha);
            $text_entrega[] = _titulo(_text_($response, $fecha_hora_entrega), 2);

            $usuario_cliente = prm_def($data, 'usuario_cliente');
            if (es_data($usuario_cliente)) {

                $nombre_cliente = format_nombre($usuario_cliente);

                $text_entrega[] = _titulo('cliente', 3, 'underline mt-4');
                $text_entrega[] = d($nombre_cliente);
                $text_entrega[] = d(phoneFormat(pr($usuario_cliente, 'tel_contacto')));
            }

            $response = append($text_entrega);
        }
        return $response;
    }

    function resumen_orden($data)
    {

        $z = [];
        $productos_orden_compra = $data["productos_orden_compra"];

        $es_vendedor = $data["es_vendedor"];
        $evaluacion = evaluacion_orden_compra($productos_orden_compra, $es_vendedor);
        $se_cancela = es_orden_cancelada($data);
        $es_orden_entregada = es_orden_entregada($data);
        $tipo_entrega = pr($productos_orden_compra, "tipo_entrega");
        $es_servicio = pr($productos_orden_compra, "flag_servicio");
        $fecha_servicio = pr($productos_orden_compra, "fecha_servicio");
        $fecha_contra_entrega = pr($productos_orden_compra, "fecha_contra_entrega");
        $fecha_vencimiento = pr($productos_orden_compra, "fecha_vencimiento");
        $saldo_cubierto = intval(pr($productos_orden_compra, "saldo_cubierto"));
        $id_orden_compra = $data["id_orden_compra"];

        if ($se_cancela) {

            $text = "ORDEN CANCELADA";
        } elseif ($es_orden_entregada) {

            $text = "ORDEN ENTREGADA!";
        } else {

            $fecha_contra_entrega_vencimiento =
                ($tipo_entrega == 2) ? $fecha_contra_entrega : $fecha_vencimiento;
            $fecha = ($es_servicio) ? $fecha_servicio : $fecha_contra_entrega_vencimiento;
            $text = seccion_orden_por_entregar(
                $productos_orden_compra,
                $data,
                $tipo_entrega,
                $es_servicio,
                $fecha
            );
        }

        $z[] = $evaluacion;
        $z[] = $text;
        $z[] = _titulo('domicilio de entrega', 3, 'underline');
        $z[] = d(text_domicilio($data));
        $id_servicio = pr($productos_orden_compra, "id_servicio");
        $text_orden = _text("ORDEN #", $id_orden_compra);
        $path_servicio = get_url_servicio($id_servicio);
        $path_resumen_servicio = path_enid('pedidos_recibo', $id_orden_compra);
        $path = (puede_repartir($data)) ? $path_resumen_servicio : $path_servicio;
        $imagenes = imagenes_orden_compra($productos_orden_compra);

        $a[] = a_enid($imagenes, $path);
        $titulo = _titulo($text_orden, 2, 'text-right mb-5');
        $texto[] = a_enid($titulo, $path);
        $texto[] = append($z);
        $texto = texto_no_puede_repartir(
            $data,
            $texto,
            $saldo_cubierto,
            $id_orden_compra,
            $id_servicio
        );

        $texto = texto_orden_administrador($data, $es_orden_entregada, $texto);
        $a[] = d($texto, 'texto_pedido bg_white p-3');

        return d(d($a, 'p-3 azul_contraste_deporte'), 'col-sm-4');
    }

    function nota_compra($saldo_cubierto, $id_recibo)
    {

        $response = [];
        $pago = ($saldo_cubierto > 0);
        if (!$pago) {

            $path = path_enid("area_cliente_compras", $id_recibo);
            $response[] = format_link(
                'Finalizar compra',
                [
                    'href' => $path,
                    'class' => 'mt-5'
                ]
            );
        }
        return append($response);
    }

    function format_imagen_repartidor($recibo)
    {

        $id_usuario_entrega = pr($recibo, 'id_usuario_entrega');
        $id_recibo = pr($recibo, 'id');
        $path = path_enid('usuario_contacto', _text($id_usuario_entrega, _text('&servicio=', $id_recibo)));

        $path_img_usuario_entrega = pr($recibo, "url_img_usuario");
        $imagen = get_img_usuario($path_img_usuario_entrega, 'rounded-circle');

        $estrellas = crea_estrellas(4);
        $texto_calificacion = flex('califícame', $estrellas, 'flex-column');

        $evalua_cliente = flex($imagen, $texto_calificacion, 'black flex-column strong text-uppercase');
        $evalua_cliente = a_enid($evalua_cliente, $path);
        $titulo_entrega = _titulo('Entrega', 5, 'underline');

        return flex($titulo_entrega, $evalua_cliente, _between_md);
    }

    function format_text_domicilio($domicilios, $data, $adicionales = 0)
    {


        $text_domicilio = pago_en_cita($data);
        $productos_orden_compra = $data["productos_orden_compra"];
        $imagen_texto_entrega = format_imagen_repartidor($productos_orden_compra);


        if (pr($productos_orden_compra, 'ubicacion') < 1) {
            if (es_data($domicilios)) {


                $calle = pr($domicilios, 'calle');
                $entre_calles = pr($domicilios, 'entre_calles');
                $numero_exterior = pr($domicilios, 'numero_exterior');
                $asentamiento = pr($domicilios, 'asentamiento');
                $municipio = pr($domicilios, 'municipio');
                $ciudad = pr($domicilios, 'ciudad');
                $cp = pr($domicilios, 'cp');
                $numero_interior = pr($domicilios, 'numero_interior');

                $str = ($adicionales > 0) ? pago_en_cita($data) : '';

                $text_domicilio = _text_(
                    $calle,
                    '#',
                    $numero_exterior,
                    'Interior',
                    '#',
                    $numero_interior,
                    $asentamiento,
                    ', ',
                    $municipio,
                    $ciudad,
                    'C.P.',
                    $cp,
                    br(2),
                    strong('referencia o entre calles'),
                    $entre_calles,
                    $str
                );
            }
        } else {

            $text_ubicacion = pr($domicilios, 'ubicacion');
            $text_ubicacion = valida_texto_maps($text_ubicacion);
            $str = ($adicionales > 0) ? pago_en_cita($data) : '';
            $text_domicilio = _text_($text_ubicacion, $imagen_texto_entrega, $str);
        }


        return $text_domicilio;
    }


    function text_domicilio($data)
    {

        $productos_orden_compra = $data["productos_orden_compra"];
        $domicilios = $data['domicilios'];
        $tipo_entrega = pr($productos_orden_compra, "tipo_entrega");
        $text = "";
        $imagen_texto_entrega = format_imagen_repartidor($productos_orden_compra);

        switch ($tipo_entrega) {

            case 1:

                if (es_data($domicilios)) {

                    $pe = $domicilios[0];
                    $tipo = $pe['tipo'];
                    $nombre_linea = $pe['nombre_linea'];
                    $numero = $pe['numero'];
                    $nombre = $pe['nombre'];


                    $fecha_contra_entrega = pr($productos_orden_compra, 'fecha_contra_entrega');

                    $text_entrega[] = _text_(
                        'TIENES UNA CITA EL DÍA ',
                        strong(format_fecha($fecha_contra_entrega, 1)),
                        'EN',
                        'ESTACIÓN DEL METRO DE CIUDAD DE MÉXICO, ',
                        strong($nombre),
                        $tipo,
                        '#',
                        $numero,
                        $nombre_linea
                    );

                    if (prm_def($data, 'usuario_cliente')) {

                        $usuario_cliente = $data['usuario_cliente'];
                        $nombre_cliente = format_nombre($usuario_cliente);
                        $text_entrega[] = _titulo('cliente', 5, 'underline');
                        $text_entrega[] = d($nombre_cliente);
                        $text_entrega[] = d(phoneFormat(pr($usuario_cliente, 'tel_contacto')));
                        $text_entrega[] = $imagen_texto_entrega;
                        $text_entrega[] = pago_en_cita($data, 1);
                    }

                    $text = append($text_entrega);
                }

                break;

            case 2:


                $text = format_text_domicilio($domicilios, $data, 1);

                break;

            default:

                break;
        }


        return $text;
    }


    function pago_en_cita($data)
    {

        $productos_orden_compra = $data["productos_orden_compra"];
        $recompensa = $data["recompensa"];
        $es_orden_cancelada = es_orden_cancelada($data);
        $in_session = $data['in_session'];
        $text_entrega = ($in_session && prm_def($data, 'id_perfil') == 21)
            ? 'A TU ENTREGA COBRARÁS AL CLIENTE ' : 'A TU ENTREGA PAGARÁS';


        $boton_pagado = btn(
            'Notificar como entregado!',
            [
                'class' => 'notifica_entrega mt-4'
            ]
        );

        $boton_cancelar = '';
        $boton_garantia = '';
        if ($data['in_session'] && !$es_orden_cancelada) {

            $boton_cancelar = btn(
                'informar cancelación!',
                [
                    'class' => 'notifica_entrega_cancelada mt-4',
                    'style' => 'background:red!important;'
                ]
            );

            
            $boton_garantia = d(format_garantia($data["id_orden_compra"]),"col-xs-12 mt-3 mb-3");


        }


        $puede_repartir = puede_repartir($data);
        $boton_cancelar = (!es_cliente($data)) ? $boton_cancelar : '';
        $pago_efectivo = ($puede_repartir) ? $boton_pagado : '';
        $deuda = total_pago_pendiente($productos_orden_compra, $recompensa);
        $descuento_aplicado = $deuda["descuento_aplicado"];
        $descuento_subtotal = ($deuda["subtotal"] - $descuento_aplicado);
        $text_pago = _text_($text_entrega, $descuento_subtotal);
        $pago_pendiente = _text_(_titulo($text_pago), $pago_efectivo, $boton_cancelar, $boton_garantia);

        $es_orden_entregada = es_orden_entregada($data);
        return (!$es_orden_entregada) ? d($pago_pendiente, 'mt-5 text-right') : '';
    }


    function render_domicilio($data)
    {

        $productos_ordenes_compra = $data["productos_orden_compra"];
        $id_orden_compra = $data["id_orden_compra"];
        $lista_direcciones = $data["lista_direcciones"];
        $domicilios_orden_compra = $data["domicilios_orden_compra"];
        $tipo_entrega = pr($productos_ordenes_compra, "tipo_entrega");
        $ubicaciones = $data['ubicaciones'];

        $response[] =
            d(
                h(
                    'selecciona una dirección de envío',
                    3,
                    'strong text-uppercase'
                )
            );

        $response[] = hiddens(
            [
                "value" => $tipo_entrega,
                "class" => 'tipo_entrega',
            ]
        );
        $response[] = hiddens(
            [
                "value" => $data['num_domicilios'],
                "class" => 'num_domicilios',
            ]
        );
        $response[] = hiddens(
            [
                "value" => $data['asignacion_horario_entrega'],
                "class" => 'asignacion_horario_entrega',
            ]
        );

        $response[] = frm_direccion($id_orden_compra);
        $response[] = d(
            _text(
                d_p(
                    'Haz click en el boton "Enviar a esta dirección". 
                        También puedes registrar un',
                    'mt-5 mt-md-1'
                ),
                agregar_nueva_direccion(0),
                d(' ó ', 'ml-2 text-center'),
                agregar_nueva_direccion()
            ),
            'mt-1 letter-spacing-1 d-lg-flex'
        );


        $response[] = hr(['class' => 'mt-5 mb-5'], 0);

        $response[] = d(
            h('Direcciones usadas recientemente', 4, 'text-uppercase strong ')
        );

        $direcciones = create_direcciones($domicilios_orden_compra, $lista_direcciones, $id_orden_compra);
        $registradas = d($direcciones, 10);

        $response[] = d($registradas, 'col-lg-12 p-0 mt-5 mb-5');
        $response[] = d(
            h('Ubicaciones frecuentes', 4, 'text-uppercase strong ')
        );
        $response[] = d(crea_ubicaciones($ubicaciones, $id_orden_compra, $domicilios_orden_compra), 'col-lg-12 mt-5 mb-5');
        $response[] = d(hr([], 0), 'col-lg-12 p-0 mt-3 mb-5');

        return d($response, 'col-lg-12 contenedor_domicilios d-none');
    }

    function crea_ubicaciones($ubicaciones, $id_recibo, $domicilios_orden_compra)
    {

        $response = [];
        if (es_data($ubicaciones)) {

            $ubicaciones = unique_multidim_array($ubicaciones, 'ubicacion');
            foreach ($ubicaciones as $row) {

                $id_ubicacion = $row["id_ubicacion"];
                $es_seleccion = es_selecccion($id_ubicacion, $domicilios_orden_compra, 3);


                $text = [];
                $ubicacion = $row['ubicacion'];
                $texto_ubicacion = ($es_seleccion) ? text_icon('fa fa-check-circle', $ubicacion) : $ubicacion;
                $text[] = d($texto_ubicacion, 'p-1');

                $text[] = d(btn(
                    "usar esta ubicacion",
                    [
                        "class" => "establecer_ubicacion mt-2",
                        "id" => $id_ubicacion,
                        "id_recibo" => $id_recibo,
                        'tipo' => 2,

                    ]
                ), 'p-1');
                $response[] = d(append($text), _text("col-lg-3 mt-5 "));
            }
        }
        return append($response);
    }

    function frm_pedidos($data, $es_venta_comisionada, $usuario_comision, $orden)
    {

        $productos_orden_compra = $data["productos_orden_compra"];
        $id_perfil = $data["id_perfil"];



        $nombre_vendedor = nombre_comisionista($es_venta_comisionada, $usuario_comision, $data);
        $numero_orden = _titulo(_text_("# ORDEN ", $orden), 3);
        $recibo_vendedor = flex_md($numero_orden, $nombre_vendedor, _text(_between_md, 'text-left'));

        $r[] = d($recibo_vendedor, 'row mt-3');

        $text = es_orden_pagada_entregada($data) ? 'Vendió' : 'Agendó';
        $repartidor = $data['repartidor'];
        $id_usuario_reparto = pr($repartidor, 'id_usuario');
        $url_img_usuario = pr($repartidor, 'url_img_usuario');



        $imagen =
            img(
                [
                    "src" => $url_img_usuario,
                    "onerror" => "this.src='../img_tema/user/user.png'",
                    'class' => 'mx-auto d-block rounded-circle mah_25 uuuuuuuuuuu'
                ]
            );


        $nombre_reparto = format_nombre($repartidor);

        $repartidor = a_enid(
            flex(
                $nombre_reparto,
                $imagen,
                'd-flex align-items-start   w-100',
                'mr-5'
            ),
            [
                'class' => 'ml-3 underline black',
                'href' => path_enid('usuario_contacto', $id_usuario_reparto)
            ]
        );
        $text_nombre = _text_($text, $repartidor);
        $r[] = d($text_nombre, 'row mt-3');

        $saldo_cubierto = pr($productos_orden_compra, 'saldo_cubierto');
        $se_paga_comision = pr($productos_orden_compra, 'flag_pago_comision');
        $es_vendedor = in_array($id_perfil, [6, 3]);


        if ($saldo_cubierto > 0 && $se_paga_comision > 0 && $es_vendedor) {
            $comision = pr($productos_orden_compra, 'comision_venta');
            $monto = p(money($comision), 'strong ml-4');
            $r[] = d(_text_('COBRASTE', $monto), 'row mt-1');
        }


        $r[] = d("", 'row border-bottom mb-4');

        return append($r);
    }

    function nombre_comisionista($es_venta_comisionada, $usuario_comision, $data)
    {
        $response = [];
        if ($es_venta_comisionada && es_data($usuario_comision)) {

            $comisionista = $usuario_comision[0];
            $id_vendedor = $comisionista['id_usuario'];
            $imagen =
                img(
                    [
                        "src" => path_enid('imagen_usuario', $id_vendedor),
                        "onerror" => "this.src='../img_tema/user/user.png'",
                        'class' => 'mx-auto d-block rounded-circle mah_25'
                    ]
                );


            $vendedor = _text_('agenda', format_nombre($comisionista));
            $response[] =
                a_enid(
                    flex($vendedor, $imagen, 'borde_amarillo blue_enid3 white text-capitalize', 'mr-5'),
                    path_enid('usuario_contacto', $id_vendedor)

                );
        } else {


            $productos_orden_compra = $data["productos_orden_compra"];
            $comision = pr($productos_orden_compra, 'comision_venta');
            $text = d(_text_('Lograsté una comisión de ', money($comision)), 'underline');
            $se_entrego = es_orden_pagada_entregada($data);
            $response[] = (es_usuario_referencia($data) && $se_entrego) ? $text : '';
        }
        return append($response);
    }

    function nombre_cliente($usuario)
    {
        $response = [];
        if (es_data($usuario)) {

            $usuario = $usuario[0];

            $vendedor = _text_(
                'cliente',
                $usuario['name'],
                $usuario['apellido_paterno'],
                $usuario['apellido_materno']
            );
            $response[] = p($vendedor, _text_('pl-3 pr-3  border', _strong));
        }
        return append($response);
    }

    function format_calendario($id_recibo)
    {
        $path = "https://enidservices.com/web/pedidos/?recibo=$id_recibo";
        return d(format_link(
            "Agendar recordatorio",
            [
                "href" => "https://calendar.google.com/calendar/r/eventedit?text=Orden de compra - $path &details=$path",
                "class" => "mb-2",
                "target" => '_blanck'
            ],
            0
        ), 13);
    }
    function format_garantia($id_recibo)
    {
        $id_orden_compra = $id_recibo;
        $path = path_enid("garantia", $id_orden_compra);

        return d(format_link(
            "Garantia",
            [
                "href" => $path,
                "class" => "mb-2",
                "target" => '_blanck'
            ],
            0
        ), 13);
    }

    function format_estados_venta($data, $status_ventas, $recibo, $es_vendedor)
    {

        $restriccion_status_comisionista = $data['restricciones']['restriccion_status_comisionista'];
        $disponibilidad = ($es_vendedor) ? $restriccion_status_comisionista : [];
        $realizo_pago = (pr($recibo, 'saldo_cubierto') > 0);
        if (!$es_vendedor && $realizo_pago) {
            $disponibilidad = [16];
        }
        $disponibilidad[] = 18;

        $id_status = pr($recibo, 'status');


        $status_compra = create_select_selected(
            $status_ventas,
            'id_estatus_enid_service',
            'nombre',
            $id_status,
            'status_venta',
            'status_venta form-control status_venta_select',
            0,
            $disponibilidad
        );

        $r[] = d_row($status_compra);
        $r[] = d('', "place_tipificaciones");

        $r[] = d(
            input_frm(
                'w-100',
                "SALDO CUBIERTO MXM",
                [
                    "class" => "saldo_cubierto_pos_venta",
                    "id" => "saldo_cubierto_pos_venta",
                    "type" => "number",
                    "step" => "any",
                    "required" => true,
                    "name" => "saldo_cubierto",
                    "value" => $recibo[0]["saldo_cubierto"],
                ]
            ),
            'row form_cantidad_post_venta'
        );
        $r[] = form_cantidad($data);

        $text_estado_venta = search_bi_array(
            $status_ventas,
            'id_estatus_enid_service',
            $id_status,
            'text_vendedor'
        );

        $response[] = d(_titulo($text_estado_venta, 2), 'col-sm-12 p-0 text-center');
        $response[] = d($r, "selector_estados_ventas mt-5 col-sm-12");
        $contenido = d($response);

        return gb_modal($contenido, 'modal_estado_venta');
    }

    function crea_seccion_solicitud($recibo)
    {

        $r[] = d("solicitud  ");
        $fecha = pr($recibo, "fecha_registro");
        $fecha = format_fecha($fecha, 1);

        $r[] = d($fecha);

        return d(flex("solicitud", $fecha, '', _strong, 'ml-md-1'), 13);
    }

    function get_format_costo_operacion(
        $data,
        $table_costos,
        $resumen,
        $tipo_costos,
        $id_recibo,
        $path,
        $costos_operacion,
        $recibo,
        $es_venta_comisionada,
        $usuario_comision,
        $usuario_compra
    ) {

        $r[] = _titulo("COSTOS DE OPERACIÓN");
        $r[] = nombre_comisionista($es_venta_comisionada, $usuario_comision, $data);
        $r[] = nombre_cliente($usuario_compra);
        $r[] = d($table_costos, 'mt-5 mb-5');
        $r[] = d($resumen);
        $link = format_link(
            "Agregar",
            [
                "onclick" => "muestra_formulario_costo();",
                "class" => "mt-5 col-md-3 link_agregar",
            ]
        );
        $r[] = row_d($link);

        $r[] = d(
            frm_costos(
                $recibo,
                $tipo_costos,
                $id_recibo,
                $costos_operacion
            ),
            "d-none contenedor_form_costos_operacion col-lg-12 p-0 "
        );
        $seccion = append($r);

        $response[] = flex_md(
            $seccion,
            format_img_recibo($path, $recibo),
            'row',
            _8,
            _4
        );

        return d($response, 10, 1);
    }

    function format_img_recibo($path, $r)
    {
        $response = [];
        if (es_data($r)) {

            $r = $r[0];
            $articulos = $r["num_ciclos_contratados"];
            $monto_a_pagar = $r["monto_a_pagar"] * $articulos;
            $seccion[] = d(a_enid(
                img($path),
                path_enid("pedidos_recibo", $r["id"])
            ));

            $seccion[] = _titulo(flex("TOTAL ", money($monto_a_pagar), _flex_right, 'mr-md-4'));
            $seccion[] = _titulo(flex("CUBIERTO", money($r["saldo_cubierto"]), _flex_right, 'mr-md-4'), 5);
            $seccion[] = _titulo(flex("ARTÍCULOS", $articulos, _flex_right, 'mr-md-4'), 5);

            if ($r["cancela_cliente"] > 0 || $r["se_cancela"] > 0 || $r["status"] == 10) {

                $seccion[] = _titulo("ORDEN CANCELADA", 3, "red_enid");
            }
            $response[] = d($seccion, "text-right mt-5");
        }

        return append($response);
    }

    function compra(
        $es_venta_cancelada,
        $recibo,
        $domicilio,
        $usuario,
        $id_recibo,
        $cupon,
        $es_vendedor,
        $id_perfil,
        $status_ventas,
        $data
    ) {


        $tipos_entregas = $data['tipos_entregas'];
        $menu = menu();
        $r[] = d($menu, 'd-none d-md-block');

        $r[]  = format_calendario($id_recibo);
        $r[] = format_garantia($id_recibo);
        $r[] = create_seccion_tipo_entrega($recibo, $tipos_entregas);

        if (!is_mobile()) {

            $r[] = enviar_a_reparto($data, $es_venta_cancelada, $status_ventas);
            $r[] = repatidor($data, $id_recibo);
        }


        $r[] = tiene_domilio($domicilio);
        $r[] = format_estados_venta($data, $status_ventas, $recibo, $es_vendedor);

        $r[] = compras_cliente($data);
        $r[] = seccion_usuario($usuario, $recibo, $data);
        $r[] = frm_usuario($usuario);
        $r[] = create_seccion_domicilio($domicilio, $data);
        $r[] = create_seccion_saldos($recibo, $data);
        $r[] = seccion_cupon($cupon);


        return d($r, 12);
    }

    function repatidor($data, $id_recibo)
    {

        $response = [];
        $es_orden_cancelada = es_orden_cancelada($data);
        $productos_orden_compra = $data["productos_orden_compra"];
        $status = pr($productos_orden_compra, 'status');

        if (es_administrador($data) && !$es_orden_cancelada && $status != 6) {

            $usuario = $data['repartidor'];
            $nombre = format_nombre($usuario);
            $id_usuario = pr($usuario, 'id_usuario');
            $es_orden_pagada_entregada = es_orden_pagada_entregada($data);
            $str = ($es_orden_pagada_entregada) ? 'Entregó' : 'Entregará';
            $text = _text_($str, $nombre);
            $text = text_icon(_editar_icon, $text, 0);
            $reparto = format_link(
                $text,
                [
                    'class' => 'repartidor',
                    'id' => $id_recibo,
                    'usuario' => $id_usuario
                ],
                0
            );
            $response[] = d($reparto, 'row mb-5');
        }

        return append($response);
    }

    function tracker($id_orden_compra, $es_venta_cancelada)
    {
        $response = '';
        if (!$es_venta_cancelada) {

            $pedido = text_icon(_share_icon, 'Rastrear pedido', [], 0);
            $link = a_enid(
                $pedido,
                [
                    'href' => path_enid('pedido_seguimiento', $id_orden_compra),
                    'target' => '_black',
                    'class' => 'text-uppercase black'
                ]
            );
            $response = d($link);
        }
        return $response;
    }

    function enviar_a_reparto($data, $es_venta_cancelada, $status_ventas)
    {

        $productos_ordenes_compra = $data["productos_orden_compra"];
        $domicilios = $data["domicilios"];
        $response = [];
        if (!$es_venta_cancelada) {

            $punto_encuentro = "";
            $tipo_entrega = 0;
            $es_domicilio = es_data($domicilios);

            if ($es_domicilio) {

                $tipo_entrega = pr($productos_ordenes_compra, "tipo_entrega");
                $punto_encuentro = ($tipo_entrega != 1) ? "" : text_punto_encuentro($domicilios, $productos_ordenes_compra);
            }


            if ($tipo_entrega == 1 || (es_contra_entrega_domicilio($productos_ordenes_compra))) {


                $response[] = reparto_contra_entrega(
                    $data,
                    $status_ventas,
                    $productos_ordenes_compra,
                    $punto_encuentro
                );
            }
        }

        return append($response);
    }

    function notifica_entrega_modal($recibo, $data)
    {

        $id_orden_compra = $data["id_orden_compra"];
        $form_entrega[] = _titulo('¿Ya entregaste este pedido?');

        $productos_orden_compra = $data["productos_orden_compra"];
        $recompensa = $data["recompensa"];
        $deuda = total_pago_pendiente($productos_orden_compra, $recompensa);


        $checkout = ticket_pago($deuda, [], 2);
        $id_recibo = pr($recibo, 'id');
        $tipo_entrega = pr($recibo, 'tipo_entrega');
        $id_usuario_compra = pr($recibo, 'id_usuario');
        $saldo_pendiente = $checkout['saldo_pendiente_pago_contra_entrega'];

        $form_entrega[] = form_open('', ['class' => 'form_notificacion_entrega_cliente']);
        $form_entrega[] = hiddens(['name' => 'saldo_cubierto', 'class' => 'saldo_cubierto', 'value' => $saldo_pendiente]);
        $form_entrega[] = hiddens(['name' => 'orden_compra', 'value' => $id_orden_compra]);
        $form_entrega[] = hiddens(['name' => 'status', 'value' => 15]);
        $form_entrega[] = hiddens(['name' => 'es_proceso_compra', 'value' => '']);
        $form_entrega[] = hiddens(['name' => 'tipo_entrea', 'value' => $tipo_entrega]);
        $form_entrega[] = form_close();

        $confirmacion = format_link('Si', ['class' => 'selector_entrega']);
        $negacion = format_link('Aún no', ['class' => 'selector_negacion', 'data-dismiss' => 'modal'], 0);
        $form_entrega[] = flex($confirmacion, $negacion, _text_(_between, _mbt5));
        $form[] = d($form_entrega, 'form_confirmacion_entrega');
        $form[] = form_envio_puntos($id_usuario_compra, $id_recibo, $deuda);
        $form[] = form_otros($id_usuario_compra, $id_recibo);

        return append($form);
    }
    function form_otros($id_usuario_compra, $id_recibo)
    {


        $form_otros[] = _titulo('¿El cliente tiene interés sobre otros artículos?');
        $confirmacion = format_link('Si', ['class' => 'selector_interes']);
        $negacion = format_link('no, no nos comentó', ['class' => 'selector_negacion', 'data-dismiss' => 'modal'], 0);
        $form_otros[] = flex($confirmacion, d($negacion, 'selector_negacion'), _text_(_between, _mbt5));


        $form_otros[] = form_open('', ['class' => 'form_articulo_interes_entrega d-none mt-5']);
        $form_otros[] = input_frm(
            '',
            '¿Qué artículo?',
            [
                'class' => 'nuevo_articulo_interes',
                'id' => 'nuevo_articulo_interes',
                'name' => 'tag',
                'placeholder' => 'Ej. camisa',
                'type' => 'text',
                'required' => true
            ]
        );
        $form_otros[] = hiddens(['name' => 'usuario', 'value' => $id_usuario_compra]);
        $form_otros[] = hiddens(['name' => 'recibo', 'value' => $id_recibo]);
        $form_otros[] = hiddens(['name' => 'tipo', 'value' => 2]);
        $form_otros[] = d(btn('Agregar'), 'mt-5');
        $form_otros[] = form_close();

        return d($form_otros, 'form_otros d-none');
    }

    function form_envio_puntos($id_usuario_compra, $id_recibo, $deuda)
    {

        $saldo_pendiente = $deuda["saldo_pendiente"];
        $puntos = porcentaje($saldo_pendiente, 4.9);
        $form_puntos[] = _titulo(_text_('El cliente tiene', $puntos, "puntos de recompensa"));

        $form_puntos[] = form_open('', ['class' => 'mt-5']);
        $form_puntos[] = input_frm(
            '',
            '¿A qué correo electrónico enviamos sus puntos?',
            [
                'class' => 'correo_puntos',
                'id' => 'correo_puntos',
                'name' => 'email',
                'type' => 'text',
                'required' => true
            ]
        );
        $form_puntos[] = hiddens(['name' => 'usuario', 'value' => $id_usuario_compra]);
        $form_puntos[] = hiddens(['name' => 'recibo', 'value' => $id_recibo]);
        $form_puntos[] = hiddens(['name' => 'tipo', 'value' => 2]);
        $form_puntos[] = d(btn('Enviar'), 'mt-5');
        $form_puntos[] = form_close();
        $form_puntos[] = d(d('Da click aquí si el cliente no desea sus puntos', "red_enid sin_deseo_puntos cursor_pointer"), 'mt-5');
        return d($form_puntos, 'form_puntos d-none');
    }

    function reparto_contra_entrega($data, $status_ventas, $recibo, $punto_encuentro)
    {
        $response = [];
        $id_orden_compra = $data["orden"];
        $es_orden_pagada_entregada = es_orden_pagada_entregada($data);
        $es_contra_entrega_domicilio = es_contra_entrega_domicilio($recibo);
        if (es_administrador_o_vendedor($data) && !$es_orden_pagada_entregada) {

            $status_recibo = pr($recibo, 'status');
            $ubicacion = pr($recibo, 'ubicacion');
            $clasificacion = search_bi_array(
                $status_ventas,
                "id_estatus_enid_service",
                $status_recibo,
                "text_vendedor",
                ""
            );

            $pedido = btn(_text_('Enviar al repartidor', icon(_repato_icon)));
            $id_direccion = id_direccion_recibo($data, $es_contra_entrega_domicilio);
            $confirmar_pedido = "confirma_reparto({$id_orden_compra}, '{$punto_encuentro}')";
            $text_punto_encuentro = trim(strip_tags(strip_tags_content(text_domicilio($data, 0))));
            $text_punto_encuentro = str_replace(PHP_EOL, '', $text_punto_encuentro);
            $confirm_pedido_domicilio = "confirma_reparto_contra_entrega_domicilio({$id_orden_compra}, '{$text_punto_encuentro}');";

            $confirm = ($es_contra_entrega_domicilio) ? $confirm_pedido_domicilio : $confirmar_pedido;


            $config = ['class' => _text_(_mbt5_md, 'w-100')];

            $es_contra_entrega_domicilio_registro = ($es_contra_entrega_domicilio && $id_direccion > 0);
            $es_contra_entrega_domicilio_ubicacion = ($es_contra_entrega_domicilio && $ubicacion > 0);
            if (!$es_contra_entrega_domicilio || $es_contra_entrega_domicilio_registro || $es_contra_entrega_domicilio_ubicacion) {

                $config["onclick"] = $confirm;
            }

            $link = a_enid($pedido, $config);

            if (!in_array($status_recibo, [16])) {

                $response[] = d($link, 'row mb-3');
            } else {

                $path_tracker = path_enid('pedido_seguimiento', $id_orden_compra);
                $link = format_link($clasificacion, ['href' => $path_tracker]);
                $response[] = d($link, 'row mb-3');
            }
        }
        return append($response);
    }

    function id_direccion_recibo($data, $es_contra_entrega_domicilio)
    {
        $id_direccion = 0;
        if ($es_contra_entrega_domicilio) {
            $domicilios = $data['domicilios'];
            if (es_data($domicilios)) {

                $id_direccion = pr($domicilios, 'id_direccion');
            }
        }
        return $id_direccion;
    }

    function imprimir_recibo($response, $recibo, $tipos_entrega, $data)
    {

        $id_orden_compra = $data["orden"];
        $productos_orden_compra = $data["productos_orden_compra"];
        $recompensa = $data["recompensa"];
        $deuda = total_pago_pendiente($productos_orden_compra, $recompensa);

        $checkout = ticket_pago($deuda, $tipos_entrega);
        $es_lista_negra = es_lista_negra($data);
        if (es_data($checkout) && es_data($recibo) && !$es_lista_negra) {

            $recibo = $recibo[0];
            $id_usuario_venta = $recibo["id_usuario_venta"];
            $tipo_entrega = $recibo["tipo_entrega"];
            $descuento_entrega = $checkout['descuento_entrega'];
            $es_descuento = ($tipo_entrega == 1 && $descuento_entrega > 0);
            $saldo_pendiente = ($es_descuento) ? $checkout['saldo_pendiente_pago_contra_entrega'] : $checkout['saldo_pendiente'];
            $link = pago_oxxo('', $saldo_pendiente, $id_orden_compra, $id_usuario_venta);
            $contenido[] = a_enid(
                'imprimir instrucciones de pago en oxxo',
                [
                    'href' => $link,
                    'class' => 'black text-uppercase',
                    'target' => '_black'
                ]
            );
            $response[] = d($contenido);
        }

        return $response;
    }

    function get_form_busqueda_pedidos($data, $param)
    {


        $es_busqueda_reparto = prm_def($param, 'reparto');
        $ancho_fechas = 'col-sm-6 mt-5 p-0 p-md-1 ';
        $tipos_entregas = $data["tipos_entregas"];
        $status_ventas = $data["status_ventas"];
        $fechas[] =
            [
                "fecha" => "FECHA REGISTRO",
                "val" => 1,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA CONTRA ENTREGA",
                "val" => 5,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA ENTREGA",
                "val" => 2,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA CANCELACION",
                "val" => 3,
            ];
        $fechas[] =
            [
                "fecha" => "FECHA PAGO",
                "val" => 4,
            ];

        $r[] = form_open("", ["class" => "form_busqueda_pedidos mt-5", "method" => "post"]);
        $r[] = hiddens(['class' => 'usuarios', 'name' => 'usuarios', 'value' => prm_def($param, 'usuarios')]);
        $r[] = hiddens(['class' => 'ids', 'name' => 'ids', 'value' => prm_def($param, 'ids')]);
        $r[] = hiddens(['class' => 'es_busqueda_reparto', 'name' => 'es_busqueda_reparto', 'value' => $es_busqueda_reparto]);
        $r[] = hiddens([
            'class' => 'es_administrador', 'name' => 'es_administrador',
            'value' => es_administrador($data)
        ]);

        $r[] = hiddens(
            [
                "name" => "perfil",
                "class" => "perfil_consulta",
                "value" => $data["id_perfil"],
            ]
        );


        $select_comisionistas = create_select(
            $data['comisionistas'],
            'id_usuario_referencia',
            'comisionista form-control',
            'comisionista',
            'nombre_usuario',
            'id',
            0,
            1,
            0,
            '-'
        );

        $r[] = form_busqueda_pedidos($data, $tipos_entregas, $status_ventas, $fechas);
        $es_busqueda = keys_en_arreglo(
            $param,
            [
                'fecha_inicio',
                'fecha_termino',
                'type',
                'servicio'
            ]
        );

        $visibilidad = (!es_data($data['comisionistas'])) ? 'd-none' : '';
        $r[] = flex_md(
            'Filtrar por vendedor',
            $select_comisionistas,
            _text_('col-sm-12 mt-md-m5 mt-3 p-0', _between_md, $visibilidad),
            _text_('text-left', $visibilidad),
            _text_('text-left', $visibilidad)
        );

        if ($es_busqueda && es_data($param)) {


            $r[] = frm_fecha_busqueda(
                $param["fecha_inicio"],
                $param["fecha_termino"],
                $ancho_fechas,
                $ancho_fechas
            );
            $r[] = hiddens(
                [
                    "name" => "consulta",
                    "class" => "consulta",
                    "value" => 1,
                ]
            );
            $r[] = hiddens(
                [
                    "name" => "servicio",
                    "class" => "servicio",
                    "value" => $param["servicio"],
                ]
            );
            $r[] = hiddens(
                [
                    "name" => "type",
                    "class" => "type",
                    "value" => $param["type"],
                ]
            );
        } else {

            $r[] = frm_fecha_busqueda(0, 0, $ancho_fechas, $ancho_fechas);
        }


        $r[] = form_close();
        $z[] = append($r);
        $z[] = place("place_pedidos ");
        $z[] = frm_busqueda();


        $titulo = _titulo("ORDENES DE COMPRA");
        $busqueda = _titulo("busqueda", 3);

        $text_entregas = flex(icon(_calendario_icon), 'Próximas entregas', '', 'mr-1');
        $link = format_link($text_entregas, ['href' => path_enid('entregas')]);
        $busqueda_calendario = flex($busqueda, $link, _between);
        $response[] = d($titulo, ' col-sm-10 col-sm-offset-1 mt-5');
        $response[] = d($busqueda_calendario, ' col-sm-10 col-sm-offset-1 mt-5');
        $response[] = d($z, 10, 1);

        $secciones_tabs[] = tab_seccion(append($response), 'buscador_seccion', 1);
        $modal = gb_modal(pago_usuario_comisiones(), 'modal_pago_comision');
        $modal_comisiones = gb_modal(pago_comisiones(), 'modal_pago_comisiones');
        $contenido_por_pago = comisiones_por_pago($data, $modal);
        $secciones_tabs[] = tab_seccion($contenido_por_pago, 'pagos_pendientes');
        $class_pedidos = es_vendedor($data) ? 'd-none' : ' ';
        $menu_pedidos = tab('Pedidos', '#buscador_seccion', ['class' => 'strong']);
        $menu_pendientes = tab('Pagos pendientes', '#pagos_pendientes', ['class' => 'ml-5 strong']);
        $menu_pendientes = es_administrador($data) ? $menu_pendientes : '';
        $menu = flex(d($menu_pedidos, $class_pedidos), $menu_pendientes, 'justify-content-end');

        $data_complete[] = $modal_comisiones;
        $data_complete[] = d($menu, 10, 1);
        $data_complete[] = d(tab_content($secciones_tabs), 12);
        return append($data_complete);
    }

    function total_comision($ids_usuario, $ordenes)
    {
        $totales = [];
        foreach ($ids_usuario as $row) {

            $total = 0;
            $id_cliente = 0;
            foreach ($ordenes as $row2) {
                if ($row == $row2['id_usuario_referencia']) {
                    $total = $total + $row2['comision_venta'];
                    $id_cliente = $row2['id_usuario'];
                }
            }
            $totales[] = [
                'id_usuario' => $row,
                'total_comisiones' => $total,
                'id_cliente' => $id_cliente
            ];
        }
        return $totales;
    }

    function formato_nombre_comisionista($ordenes, $id_usuario)
    {
        $nombre_completo = '';
        foreach ($ordenes as $row2) {

            if ($row2['id_usuario_referencia'] == $id_usuario) {

                $nombre_completo = format_nombre($row2);

                break;
            }
        }
        return $nombre_completo;
    }

    function formato_nombre_cliente($clientes, $id_usuario)
    {
        $nombre_completo = '';
        if (es_data($clientes)) {
            foreach ($clientes as $row) {

                if ($row['id_usuario'] == $id_usuario) {

                    $nombre_completo = format_nombre($row);

                    break;
                }
            }
        }
        return $nombre_completo;
    }

    function comisiones_por_pago($data, $modal)
    {

        $ordenes = $data['comisiones_por_pago'];
        $clientes_por_pago = $data['clientes_por_pago'];

        $totales_en_pagos = 0;
        $response = [];
        $total_pago_comisiones = 0;
        $response[] = d('', 'mt-5 mb-5 row');
        $ids_cuentas_pagos = [];
        if (es_data($ordenes)) {

            $ids = array_column($ordenes, 'id_usuario_referencia');
            $ids_usuario = array_unique($ids);
            $totales = total_comision($ids_usuario, $ordenes);

            foreach ($totales as $row) {

                $id_usuario = $row['id_usuario'];

                $contenido = [];
                $nombre_completo = formato_nombre_comisionista($ordenes, $id_usuario);
                $total_comisiones_efectivo = $row['total_comisiones'];

                $total_comisiones = money($row['total_comisiones']);
                $totales_en_pagos = $totales_en_pagos + $row['total_comisiones'];
                $config = ['class' => 'usuario_venta cursor_pointer col-md-4 border', 'id' => $id_usuario];
                $ids_cuentas_pagos[] = $id_usuario;
                $config_pago = [
                    'class' => 'usuario_venta_pago cursor_pointer col-md-4 border',
                    'id' => $id_usuario,
                    'total_comisiones' => $total_comisiones_efectivo,
                    'nombre_comisionista' => $nombre_completo,

                ];
                $contenido[] = d($id_usuario, $config);
                $config_venta =
                    [
                        'class' => 'nombre_usuario_venta text-uppercase cursor_pointer col-md-4 border',
                        'id' => $id_usuario
                    ];
                $contenido[] = d($nombre_completo, $config_venta);

                $config_pago['class'] = _text_($config_pago['class'], 'strong text-right');
                $contenido[] = d($total_comisiones, $config_pago);
                $response[] = d(
                    $contenido,
                    _text_('border row', _text('sintesis nombre_vendedor_sintesis_', $id_usuario))
                );
            }


            $totales_[] = d('', 'col-lg-9');
            $totales_[] = d(money($totales_en_pagos), 'col-lg-3');

            $response[] = d($totales_, 'row text-right h3 strong');
            $response[] = d('', 'mt-5 mb-5 row');

            foreach ($ordenes as $row) {

                $id_orden_compra = $row['id_orden_compra'];
                $comision_venta = $row['comision_venta'];
                $nombre_usuario = format_nombre($row);
                $id_usuario_referencia = $row['id_usuario_referencia'];

                $nombre_usuario_cliente = formato_nombre_cliente($clientes_por_pago, $row['id_usuario']);
                $contenido = [];

                $class = 'col-md-3 ';
                $img = img(
                    [
                        "src" => $row["url_img_servicio"],
                        "class" => "img_servicio w-25",

                    ]
                );
                $total_pago_comisiones = $total_pago_comisiones + $comision_venta;

                $contenido[] = d($img, $class);
                $contenido[] = d($nombre_usuario, $class);
                $contenido[] = d($nombre_usuario_cliente, $class);
                $contenido[] = d(money($comision_venta), _text_($class, 'strong'));
                $path = path_enid('pedidos_recibo', $id_orden_compra);

                $tag_usuario = _text('usuario_', $id_usuario_referencia);
                $response[] = d(
                    a_enid(
                        append($contenido),
                        [
                            'class' => 'd-flex align-items-center row text-center border black',
                            'href' => $path,
                            'target' => '_blank',
                        ]
                    ),
                    _text_('linea_venta', $tag_usuario)
                );
            }

            $total = money($total_pago_comisiones);
            $response[] = d(_titulo(_text_('Cuenta por pagar', $total)), 'text-right mt-5');
        }

        $_response[] = d(_titulo('Cuentas por pagar', 2), 13);
        if (es_data($ids_cuentas_pagos)) {
            $_response[] = d(
                format_link(
                    'Marcar todos como pagados',
                    [
                        "class" => "marcar_pagos col-sm-3"
                    ]
                ),
                13
            );
        }


        $_response[] = append($response);
        $_response[] = $modal;
        $_response[] = hiddens(["class" => "ids_pagos", "value" => implode(",", $ids_cuentas_pagos)]);
        return d($_response, 10, 1);
    }


    function totales_comisiones($usuarios_por_pago, $usuarios)
    {

        $totales_en_pagos = 0;
        $totales = [];
        if (es_data($usuarios_por_pago)) {

            $ids = array_column($usuarios_por_pago, 'id_usuario');
            $ids_usuario = array_unique($ids);

            foreach ($ids_usuario as $row) {

                $total = 0;
                foreach ($usuarios_por_pago as $row2) {
                    if ($row == $row2['id_usuario']) {
                        $total = $total + $row2['comision'];
                    }
                }
                $totales[] = [
                    'id_usuario' => $row,
                    'total_comisiones' => $total,

                ];
            }
        }

        $response = [];
        $totales = 0;


        foreach ($totales as $row) {

            $id_usuario = $row['id_usuario'];
            $contenido = [];
            $nombre_completo = '';

            foreach ($usuarios as $row2) {

                if (es_data($row2) && array_key_exists(0, $row2)) {

                    $usuario = $row2[0];
                    $id_usuario_busqueda = $usuario['id_usuario'];
                    if ($id_usuario_busqueda == $id_usuario) {

                        $nombre_completo = format_nombre($usuario);


                        break;
                    }
                }
            }
            $total_comisiones_efectivo = $row['total_comisiones'];
            $totales_en_pagos = $totales_en_pagos + $total_comisiones_efectivo;
            $total_comisiones = money($row['total_comisiones']);


            $config = ['class' => 'usuario_venta cursor_pointer col-md-4 border', 'id' => $id_usuario];
            $config_pago = [
                'class' => 'usuario_venta_pago cursor_pointer col-md-4 border',
                'id' => $id_usuario,
                'total_comisiones' => $total_comisiones_efectivo,
                'nombre_comisionista' => $nombre_completo,

            ];

            $contenido[] = d($id_usuario, $config);
            $contenido[] = d($nombre_completo, $config);
            $contenido[] = d($total_comisiones, $config_pago);

            $response[] = d($contenido, 'border row');
        }
        $_response[] = append($response);
        $_response[] = d(_titulo(money($totales_en_pagos)), 'pull-right row mt-5');

        return append($_response);
    }

    function pago_usuario_comisiones()
    {

        $form[] = form_open('', ['class' => 'form_pago_comisiones']);
        $form[] = d(_titulo('¿Marcar como pagado?'), 'text-center');
        $form[] = d('', 'resumen_pago_comisionista');
        $form[] = hiddens(['class' => 'usuario_pago', 'name' => 'usuario']);
        $form[] = hiddens(['class' => 'monto_pago', 'name' => 'monto_pago']);
        $form[] = hiddens(['class' => 'fecha_inicio', 'name' => 'fecha_inicio']);
        $form[] = hiddens(['class' => 'fecha_termino', 'name' => 'fecha_termino']);

        $confirmacion = d(btn('Marcar como pagado!', ['class' => 'marcar_pago']), 'mt-5');

        $form[] = $confirmacion;
        $form[] = form_close();
        return append($form);
    }

    function pago_comisiones()
    {

        $form[] = form_open('', ['class' => 'form_pago_comisiones']);
        $form[] = d(_titulo('¿Notificarás todas las cuentas como pagadas?'), 'text-center');
        $form[] = d('', 'resumen_pago_comisionista');
        $confirmacion = d(btn('Marcar como pagado!', ['class' => 'marcar_cuentas_pagas']), 'mt-5');

        $form[] = $confirmacion;
        $form[] = form_close();
        return append($form);
    }

    function frm_busqueda()
    {

        $r[] = form_open("", ["class" => "form_search", "method" => "GET"]);
        $r[] = hiddens(["name" => "recibo", "value" => "", "class" => "numero_recibo"]);

        $r[] = form_close();

        return append($r);
    }


    function form_busqueda_pedidos($data, $tipos_entregas, $status_ventas, $fechas)
    {

        $id_perfil = $data['id_perfil'];
        $restriciones_comisionista_busqueda = $data['restricciones']['restriccion_status_comisionista_busqueda'];
        $restricciones_administrador_busqueda = $data['restricciones']['restricciones_administrador_busqueda'];
        $restricciones = ($id_perfil == 6) ? $restriciones_comisionista_busqueda : [];
        $restricciones = (!in_array($id_perfil, [20, 6])) ? $restricciones_administrador_busqueda : $restricciones;

        $r[] = input_frm(
            _text_(_6p, 'mt-5'),
            'Cliente',
            [
                "name" => "cliente",
                "id" => "cliente",
                "placeholder" => "Nombre, correo, telefono ...",
                "class" => "input_busqueda",
                "onpaste" => "paste_busqueda();"
            ]
        );


        $r[] = hiddens(
            [
                "name" => "v",
                'value' => 1,
            ]
        );

        $r[] = input_frm(
            _text_(_6p, 'mt-5'),
            '#Recibo',
            [
                "name" => "recibo",
                "id" => 'busqueda_recibo'
            ]
        );


        $r[] = flex(
            "Tipo de entrega",
            create_select(
                $tipos_entregas,
                "tipo_entrega",
                "tipo_entrega form-control",
                "tipo_entrega",
                "nombre",
                "id",
                0,
                1,
                0,
                "-"
            ),
            "flex-column col-md-4 p-0 mt-3"
        );

        $r[] = flex(
            'Status',
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
                "-",
                $restricciones
            ),
            "flex-column col-md-4 p-0 mt-3"
        );


        $busqueda_orden = create_select_selected($fechas, 'val', 'fecha', 5, 'tipo_orden', 'tipo_orden form-control');
        $r[] = flex(
            "Ordenar",
            $busqueda_orden,
            "flex-column col-md-4 p-0 mt-3"
        );


        return append($r);
    }


    function puntos_encuentro(
        $tipo_entrega,
        $puntos_encuentro,
        $id_recibo,
        $domicilio
    ) {


        $r[] = agregar_nueva_direccion();

        return append($r);
    }


    function hiddens_detalle($recibo)
    {

        $r = [];

        if (es_data($recibo)) {
            $rb = $recibo[0];

            $r[] = hiddens(
                [
                    "class" => "status_venta_registro",
                    "name" => "status_venta",
                    "value" => $rb["status"],
                    "id" => "status_venta_registro",
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "saldo_actual_cubierto",
                    "name" => "saldo_cubierto",
                    "value" => $rb["saldo_cubierto"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "tipo_entrega_def",
                    "name" => "tipo_entrega",
                    "value" => $rb["tipo_entrega"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "id_servicio",
                    "name" => "id_servicio",
                    "value" => $rb["id_servicio"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "articulos",
                    "name" => "articulos",
                    "value" => $rb["num_ciclos_contratados"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "registro_articulo_interes",
                    "name" => "registro_articulo_interes",
                    "value" => $rb["registro_articulo_interes"],
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "id_usuario_compra",
                    "name" => "id_usuario_compra",
                    "value" => $rb["id_usuario"],
                ]
            );
        }


        return append($r);
    }


    function menu()
    {


        $menu = d(icon("fa fa-plus-circle fa-3x"), "dropleft position-fixed menu_recibo");
        return d($menu, "row pull-right");
    }

    function evaluacion_orden_compra($productos_orden_compra, $es_vendedor)
    {

        $response = "";
        $se_entrego = 0;

        foreach ($productos_orden_compra as $row) {

            $id_servicio = $row["id_servicio"];
            if ($row["status"] == 9 && $es_vendedor < 1) {
                $se_entrego++;
            }
            if ($se_entrego > 0) {

                $evaluacion[] = btn("ESCRIBE UNA RESEÑA");
                $evaluacion[] = d(
                    str_repeat("★", 5),
                    [
                        "class" => "text-center f2 black"
                    ]
                );
                $response = a_enid(
                    append($evaluacion),
                    [
                        "href" => path_enid("valoracion_servicio", $id_servicio),
                        "class" => "mb-5"
                    ]
                );
            }
        }
        return $response;
    }


    function form_fecha_recordatorio($data, $tipo_recortario)
    {

        $x = _titulo("RECORDATORIO", 0, 'mt-5');
        $r[] = form_open(
            "",
            ["class" => "form_fecha_recordatorio"]
        );

        $input_fecha = input_frm(
            'mt-5',
            '¿FECHA?',
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_cordatorio',
                "class" => "fecha_cordatorio",
                "id" => "fecha_cordatorio",
                "type" => 'date',
                "value" => date("Y-m-d"),
                "min" => add_date(date("Y-m-d"), -15),
                "max" => add_date(date("Y-m-d"), 15),
            ]
        );

        $horario = flex("HORA", horarios(), _between, _text_(_4p, _strong, 'text-left text-md-center'), _8p);

        $r[] = flex_md($input_fecha, $horario, _between_md, _5p, _7p);


        $r[] = create_select(
            $tipo_recortario,
            "tipo",
            "tipo_recordatorio d-none",
            "tipo_recordatorio",
            "tipo",
            "idtipo_recordatorio"
        );
        $r[] = hiddens(
            [
                "class" => "recibo",
                "name" => "orden_compra",
                "value" => $data["orden"],
            ]
        );


        $r[] = textarea(
            [
                "name" => "descripcion",
                "class" => "descripcion_recordatorio mt-5",
                "rows" => 5,
            ],
            0
        );
        $r[] = place("nota_recordatorio d-none ");
        $r[] = btn("CONTINUAR", ['class' => 'mt-5']);
        $r[] = form_close();
        $r[] = place("place_recordatorio");
        $form = d($r, "form_separador ");

        return d(add_text($x, $form), 6, 1);
    }

    function get_form_fecha_entrega($data)
    {

        $orden = $data["orden"];
        $productos_orden_compra = $data["productos_orden_compra"];

        $r[] = form_open("", ["class" => "form_fecha_entrega"]);
        $r[] = d(_titulo("FECHA DE ENTREGA"), _mbt5);
        $r[] = input_frm(
            'mt-5',
            'NUEVA',
            [
                "data-date-format" => "yyyy-mm-dd",
                "name" => 'fecha_entrega',
                "class" => "fecha_entrega",
                'id' => 'fecha_entrega',
                "type" => 'date',
                "value" => date("Y-m-d"),
                "min" => add_date(date("Y-m-d"), -15),
                "max" => add_date(date("Y-m-d"), 15),
            ]
        );

        $horario_text = text_icon("fa fa-clock-o", "HORA DE ENCUENTRO");
        $horario = lista_horarios()["select"];

        $r[] = flex($horario_text, $horario, _text_(_between, 'mt-5'), _5p, _6p);

        $r[] = hiddens(
            [
                "class" => "recibo",
                "name" => "orden_compra",
                "value" => $orden,
            ]
        );
        $r[] = hiddens(
            [
                "class" => "ubicacion",
                "name" => "ubicacion",
                "value" => pr($productos_orden_compra, "ubicacion"),
            ]
        );
        $r[] = hiddens(
            [
                "class" => "tipo_entrega",
                "name" => "tipo_entrega",
                "value" => pr($productos_orden_compra, "tipo_entrega"),
            ]
        );
        $r[] = hiddens(
            [
                "class" => "fecha_contra_entrega",
                "name" => "fecha_contra_entrega",
                "value" => pr($productos_orden_compra, "fecha_contra_entrega"),
            ]
        );

        $r[] = hiddens(
            [
                "class" => "contra_entrega_domicilio",
                "name" => "contra_entrega_domicilio",
                "value" => pr($productos_orden_compra, "contra_entrega_domicilio"),
            ]
        );

        $r[] = btn("CONTINUAR", ["class" => "mt-5"]);
        $r[] = format_load();
        $r[] = form_close(place("place_fecha_entrega"));
        $response = append($r);
        $response = d($response, 4, 1);

        return $response;
    }

    function form_cantidad($data)
    {

        $r[] = '<form class="form_cantidad top_20">';
        $r[] = hiddens(
            [
                "name" => "recibo",
                "class" => "recibo",
                "value" => $data["orden"],
            ]
        );

        $r[] = place("mensaje_saldo_cubierto");
        $r[] = form_close();

        return append($r);
    }


    function frm_costos($recibo, $tipo_costos, $id_recibo, $costos_registrados)
    {

        $costos_registro = [];
        foreach ($tipo_costos as $row) {

            $repetible = $row["repetible"];
            $id = $row["id_tipo_costo"];
            $f = 1;
            foreach ($costos_registrados as $row2) {

                if ($id == $row2["id_tipo_costo"]) {
                    $f = 0;
                    if ($repetible > 0) {
                        $f = 1;
                    }
                    break;
                }
            }
            if ($f > 0) {
                $costos_registro[] = $row;
            }
        }


        $response = d(h(
            "Ya registraste todos los costos de operación para esta venta!",
            3
        ), 8, 1);
        if (es_data($costos_registro)) {

            $r[] = d(_titulo("Gasto", 4, 'mt-5'));
            $form[] = form_open(
                "",
                ["class" => "form_costos letter-spacing-5 mt-5"],
                ["recibo" => $id_recibo]
            );

            $input_monto = input_frm(
                '',
                "MONTO GASTADO",
                [
                    "type" => "number",
                    "required" => true,
                    "class" => "precio costo_operativo",
                    "name" => "costo",
                    "id" => "precio",
                ]
            );


            $select_costo = create_select(
                $costos_registro,
                "tipo",
                "id_tipo_costo form-control select_gastos ml-2",
                "tipo",
                "tipo",
                "id_tipo_costo"
            );

            $form[] = hiddens(['class' => 'costo_comision_venta', 'value' => pr($recibo, 'comision_venta', 0)]);
            $form[] = flex_md($input_monto, $select_costo, _between_md, _7p, _5p);
            $form[] = d(btn("AGREGAR"), "mt-5 col-md-3 pull-right p-0");
            $form[] = form_close(place("notificacion_registro_costo"));
            $r[] = d($form);
            $response = d($r);
        }

        return $response;
    }

    function get_error_message()
    {


        $r[] = d(h(
            "UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN",
            1,
            "funny_error_message"
        ), "text-center");
        $r[] = d(
            img(
                [
                    "src" => "../img_tema/gif/funny_error.gif",
                ]
            )
        );
        $r[] = d(
            a_enid(
                "ENCUENTRA TU ORDEN AQUÍ",
                [
                    "href" => path_enid("pedidos"),
                    "class" => "busqueda_mensaje",
                ]
            ),
            "busqueda_mensaje_text"
        );

        return d(append($r));
    }

    function frm_direccion($id_orden_compra)
    {

        $r[] = '<form  class="form_registro_direccion" action="../procesar/?w=1" method="POST" >';
        $r[] = hiddens([
            "class" => "orden_compra",
            "name" => "orden_compra",
            "value" => $id_orden_compra,
        ]);
        $r[] = form_close();

        return append($r);
    }

    function frm_puntos($id_recibo)
    {

        $r[] = '<form   class="form_puntos_medios" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
        $r[] = hiddens([
            "name" => "recibo",
            "value" => $id_recibo,
        ]);
        $r[] = hiddens([
            "name" => "carro_compras",
            "value" => 0,
        ]);

        $r[] = hiddens([
            "name" => "id_carro_compras",
            "value" => 0,
        ]);
        $r[] = hiddens([
            "class" => "punto_encuentro_asignado",
            "name" => "punto_encuentro",
            "value" => 0,
        ]);


        $r[] = form_close();

        return append($r);
    }

    function frm_pe_avanzado($id_orden_compra, $es_vendedor = 0)
    {


        $r[] = '<form   class="form_puntos_medios_avanzado" action="../puntos_medios/?recibo=' . $id_orden_compra . '"  method="POST">';
        $r[] = hiddens([
            "name" => "recibo",
            "value" => $id_orden_compra,
        ]);

        $r[] = hiddens([
            "name" => "avanzado",
            "value" => 1,
        ]);

        $r[] = hiddens([
            "class" => "punto_encuentro_asignado",
            "name" => "punto_encuentro",
            "value" => 0,
        ]);
        $r[] = hiddens([
            "name" => "carro_compras",
            "value" => 0,
        ]);

        $r[] = hiddens([
            "name" => "id_carro_compras",
            "value" => 0,
        ]);
        $r[] = hiddens([
            "name" => "vendedor",
            "value" => $es_vendedor,
        ]);

        $r[] = form_close();

        return append($r);
    }

    function frm_nota($id_orden_compra)
    {

        $r[] = form_open("", [
            "class" => "form_notas row mt-5 mb-5 ",
            "style" => "display:none;",
        ]);
        $r[] = _titulo("NOTA", 4);
        $r[] = textarea([
            "name" => "comentarios",
            "class" => "comentarios form-control top_30 bottom_30",
        ]);
        $r[] = hiddens(["name" => "orden_compra", "value" => $id_orden_compra]);
        $r[] = btn("AGREGAR", ["name" => "comentarios"]);
        $r[] = form_close(place("place_nota row"));

        return append($r);
    }

    function agregar_nueva_direccion($direccion = 1)
    {
        return ($direccion > 0) ?
            d(
                form_submit(
                    [
                        "class" => "agregar_punto_encuentro_pedido border-0 bg_black white",
                    ],
                    "Punto de entrega"
                ),
                'ml-lg-3 mt-2'
            ) :
            d(
                form_submit(
                    [
                        "class" => "agregar_direccion_pedido border-0 bg_black white ",
                    ],
                    "Domicilio de envío"
                ),
                'ml-lg-3 mt-md-2 mt-5'
            );
    }


    function create_direcciones($domicilios_orden_compra, $lista, $id_recibo)
    {

        $r = [];
        foreach ($lista as $row) {


            $text = [];
            $calle_numero = d(
                _text(
                    $row["calle"],
                    ' ',
                    'número ',
                    ' ',
                    $row["numero_exterior"]
                )
            );
            $interior_asentamiento = d(
                _text(

                    ' interior ',
                    $row["numero_interior"],
                    ' ',
                    $row["asentamiento"],
                    ' '
                )
            );

            $municipio_estado = d(
                _text(
                    $row["municipio"],
                    ' ',
                    $row["estado"]

                )
            );
            $codigo_postal = d(
                _text(
                    'C.P. ',
                    $row["cp"]

                )
            );
            $telefono = d(
                _text(
                    'teléfono:',
                    $row['telefono_receptor']
                )
            );

            $receptor = d(
                h(
                    substr($row['nombre_receptor'], 0, 19),
                    4,
                    'strong'
                )
            );
            $direccion = _text(
                $receptor,
                $calle_numero,
                $interior_asentamiento,
                $municipio_estado,
                $codigo_postal,
                $telefono
            );

            $id_direccion = $row["id_direccion"];
            $en_uso = es_selecccion($id_direccion, $domicilios_orden_compra, 2);
            $extra = ($en_uso) ? 'bg-light' : '';

            $text[] = d($direccion, 'text-uppercase mb-5 letter-spacing-1 p-2 ');
            if (!$en_uso) {
                $text[] = d(btn(
                    "entregar a esta dirección",
                    [
                        "class" => "establecer_direccion mt-2",
                        "id" => $row["id_direccion"],
                        "id_recibo" => $id_recibo,
                        'tipo' => 2,

                    ]
                ), 'p-1');
            }
            if ($en_uso) {

                $text[] = h(
                    text_icon('fa fa-check-circle', "domicilio de envío", [], 0),
                    5,
                    'text-uppercase text-right strong'

                );
            }

            $text[] = format_link(
                'eliminar',
                [
                    'class' => 'eliminar_domicilio mt-4 mb-5',
                    "id" => $row["id_direccion"],
                    "id_recibo" => $id_recibo,
                    'tipo' => 2,
                ],
                0
            );


            $r[] = d(append($text), _text("col-lg-4 mt-5 ", $extra));
        }

        return append($r);
    }

    function es_selecccion($id, $domicilios_orden_compra, $tipo)
    {

        $response = false;
        foreach ($domicilios_orden_compra as $row) {

            $tipo_entrega = intval($row["tipo_entrega"]);
            $es_ubicacion = $row["es_ubicacion"];
            $es_entrega_domicilio = ($tipo_entrega === 2);
            $es_domicilio = ($es_entrega_domicilio && $es_ubicacion < 1 && array_key_exists("id", $row));
            $es_entrega_ubicacion = ($es_entrega_domicilio && $es_ubicacion > 0 && array_key_exists("id_ubicacion", $row));

            switch ($tipo) {

                    /*Domicilio**/
                case 2:

                    if ($es_domicilio && $id === $row["id"]) {
                        $response = true;
                        break;
                    }
                    break;

                    /*Ubicación**/
                case 3:

                    if ($es_entrega_ubicacion && $id === $row["id_ubicacion"]) {
                        $response = true;
                        break;
                    }
                    break;

                default:

                    break;
            }
        }
        return $response;
    }

    function desc_direccion_entrega($data_direccion)
    {

        $text = [];

        if (es_data($data_direccion)) {
            if ($data_direccion["tipo_entrega"] == 2 && es_data($data_direccion["domicilio"])) {


                $domicilio = $data_direccion["domicilio"][0];
                $calle = $domicilio["calle"];

                $text[] = _text_(
                    $calle,
                    "NÚMERO",
                    $domicilio["numero_exterior"],
                    "NÚMERO INTERIOR ",
                    $domicilio["numero_interior"],
                    "COLONIA",
                    $domicilio["asentamiento"],
                    " DELEGACIÓN/MUNICIPIO ",
                    $domicilio["municipio"],
                    " ESTADO ",
                    $domicilio["estado"],
                    " CÓDIGO POSTAL ",
                    $domicilio["cp"]
                );
            } else {

                if (
                    is_array($data_direccion)
                    && array_key_exists("domicilio", $data_direccion)
                    && is_array($data_direccion["domicilio"])
                    && count($data_direccion["domicilio"]) > 0
                ) {

                    $pe = $data_direccion["domicilio"][0];
                    $numero = "NÚMERO " . $pe["numero"];
                    $text[] = h("LUGAR DE ENCUENTRO", 3, ["class" => "top_20"]);
                    $text[] = d(
                        $pe["tipo"] . " " . $pe["nombre"] . " " . $numero . " COLOR " . $pe["color"],
                        1
                    );
                    $text[] = d("ESTACIÓN " . $pe["lugar_entrega"], "strong", 1);
                }
            }
        }
        return append($text);
    }

    function accion_pago($recibo)
    {

        $response = "";
        if ($recibo["saldo_cubierto"] < 1) {

            $response = d(
                btn(
                    text_icon(
                        "fa fa-2x fa-shopping-cart",
                        "PROCEDER A LA COMPRA ",
                        [],
                        0
                    ),
                    [
                        "style" => "background:blue!important",
                        "class" => "top_30 f12",
                    ],
                    1,
                    1,
                    0,
                    path_enid(
                        "area_cliente_compras",
                        $recibo["id"]
                    )
                ),
                1
            );
        }

        return $response;
    }

    function tiempo($data, $es_vendedor)
    {

        $linea = [];
        $flag = 0;
        $productos_orden_compra = $data["productos_orden_compra"];
        $id_orden_compra = $data["id_orden_compra"];
        $in_session = $data['in_session'];
        $status_orden_compra = pr($productos_orden_compra, "status");
        $tipo_entrega = pr($productos_orden_compra, "tipo_entrega");
        $saldo_cubierto = pr($productos_orden_compra, "saldo_cubierto");
        $domicilios = $data["domicilios"];

        for ($i = 5; $i > 0; $i--) {

            $status = texto_status($i);
            $activo = 1;

            if ($flag == 0) {
                $activo = 0;
                if ($status_orden_compra == $status["estado"]) {
                    $activo = 1;
                    $flag++;
                }
            }


            switch ($i) {


                case 1:
                    $class = "timeline__item__date_active";
                    $seccion_2 = seccion_ordenado();


                    break;

                case 2:

                    $tiene_domicilio = tiene_domilio($domicilios, 1);
                    $class = ($tiene_domicilio == 0) ? "timeline__item__date" : "timeline__item__date_active";
                    $seccion_2 = seccion_domicilio(
                        $data,
                        $domicilios,
                        $tipo_entrega,
                        $es_vendedor
                    );

                    break;
                case 3:

                    $class = ($saldo_cubierto > 0) ? "timeline__item__date_active" : "timeline__item__date";
                    $seccion_2 = seccion_compra($in_session, $saldo_cubierto, $id_orden_compra);

                    break;

                case 4:

                    $paso_en_camino = in_array($status_orden_compra, [16, 7, 15, 9]);
                    $class = ($paso_en_camino) ? "timeline__item__date_active" : 'timeline__item__date';
                    $seccion_2 = seccion_en_camino($status);
                    break;


                case 5:

                    $se_entrego = in_array($status_orden_compra, [9, 15]);
                    $class = ($se_entrego) ? "timeline__item__date_active" : 'timeline__item__date';
                    $seccion_2 = seccion_en_entregado($status);
                    break;


                default:
                    $class = ($activo > 0) ? "f12 timeline__item__date_active" : "timeline__item__date";
                    $seccion_2 = seccion_base($status);
                    break;
            }
            $seccion = d(icon("fa fa-check-circle-o"), $class);
            $linea[] = d(_text_($seccion, $seccion_2), "timeline__item");
        }

        return append($linea);
    }

    function seccion_base($status)
    {

        return d(
            p($status["text"], "timeline__item__content__description strong"),
            "timeline__item__content strong"
        );
    }

    function seccion_compra($in_session, $saldo_cubierto, $id_orden_compra)
    {

        $path_ticket = path_enid('area_cliente_compras', $id_orden_compra);
        $pago_realizado = text_icon("fa fa-check black", "COMPRASTÉ!");
        $comprar = format_link("COMPRA AHORA!", ["href" => $path_ticket]);
        $text = ($saldo_cubierto > 0) ? $pago_realizado : $comprar;
        $text = (!$in_session) ? 'PREPARANDO TU PEDIDO' : $text;

        return d(
            p(
                $text,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content"
        );
    }

    function seccion_en_entregado()
    {

        return d(
            p(
                'ENTREGADO',

                "timeline__item__content__description strong black"

            ),
            "timeline__item__content"
        );
    }

    function seccion_ordenado()
    {

        return d(
            p(
                'ORDEN REALIZADA    ',

                "timeline__item__content__description strong black"

            ),
            "timeline__item__content"
        );
    }


    function seccion_en_camino()
    {

        $text = text_icon(_check_icon, 'TU PEDIDO ESTÁ EN CAMINO', [], 0);
        return d(
            p(
                $text,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content"
        );
    }


    function seccion_domicilio($data, $domicilio, $tipo_entrega, $es_vendedor)
    {

        $id_orden_compra = $data["id_orden_compra"];
        $url = path_enid(
            'pedido_seguimiento',
            _text($id_orden_compra, '&domicilio=1&asignacion=1')
        );

        $tipos_entrega = [
            "INDICA TU PUNTO DE ENTREGA",
            "AÚN NO INDICAS EL DOMICILIO DE ENTREGA",
        ];


        $entrega = text_icon(_check_icon, "DOMICILIO DE ENTREGA CONFIRMADO");
        if (tiene_domilio($domicilio, 1) < 1) {
            $entrega = format_link($tipos_entrega[$tipo_entrega - 1], ['href' => $url]);
        }


        $url = ($es_vendedor > 0) ? "" : $url;
        return d(
            p(
                a_enid(
                    $entrega,
                    [
                        "href" => $url,
                        "class" => "black strong",
                    ]
                ),
                "timeline__item__content__description black mt-4"
            ),
            "timeline__item__content"
        );
    }

    function texto_status($status)
    {

        $text = "";
        $estado = 6;

        switch ($status) {
            case 2:
                $text = "PAGO VERIFICADO";
                $estado = 1;
                break;

            case 1:
                $text = text_icon("fa fa-check", "ORDEN REALIZADA");
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

        return [
            "text" => $text,
            "estado" => $estado,
        ];
    }

    function seccion_historia_cliente($data)
    {

        $ordenes = [];
        $ordenes_de_compra_usuarios_similares = $data["ordenes_de_compra_usuarios_similares"];
        if (es_data($ordenes_de_compra_usuarios_similares)) {


            $ordenes[] = _titulo("Esta información tenemos sobre ordenes de compra pasadas", 4);

            foreach ($ordenes_de_compra_usuarios_similares as $row) {


                $se_cancela = es_orden_cancelada($row);
                $es_orden_lista_negra = es_orden_lista_negra($row);
                $id_orden_compra = $row["id_orden_compra"];
                $texto_id_orden_compra = _text_('Orden de compra ', $id_orden_compra);

                $path = path_enid('pedidos_recibo', $id_orden_compra);
                $texto_id_orden_compra = a_enid($texto_id_orden_compra, ['href' => $path, 'target' => '_blank']);

                $saldo_cubierto = _text_('Saldo Cubierto', money($row["saldo_cubierto"]));
                $texto_cancelado = ($se_cancela) ? 'Cancelado' : '';
                $texto_es_orden_lista_negra = ($es_orden_lista_negra) ? d('Es lista negra', 'black_enid_background p-2 f14') : '';
                $class_cancelado = ($se_cancela) ? 'cancelado white' : '';

                $resumen_pedido = span($row["resumen_pedido"], 'f12 black');
                $registro = date_format(date_create($row["fecha_registro"]), 'd M Y H:i:s');


                $linea_orden = d_c([
                    $texto_id_orden_compra,
                    $resumen_pedido, $registro,
                    $saldo_cubierto, $texto_cancelado,
                    $texto_es_orden_lista_negra
                ], '');


                $ordenes[] = d($linea_orden, _text_('border mt-3 p-3', $class_cancelado));
            }
        }

        $response = d(d($ordenes, 12), 'row mt-5 mb-5 border');
        return es_data($data) ? $response : '';
    }

    function create_seccion_comentarios($data, $titulo = 'Notas y comentarios', $link = 0)
    {

        $nota = [];
        if (es_data($data)) {

            $nota[] = _titulo($titulo, 4);

            foreach ($data as $row) {

                $id_orden_compra = $row["id_orden_compra"];
                $registro = date_format(date_create($row["fecha_registro"]), 'd M Y H:i:s');
                $seccion_registro = text_icon("fa fa-clock-o", $registro);
                $path = path_enid('pedidos_recibo', $id_orden_compra);

                $linea = flex($seccion_registro, strip_tags($row['comentario']), 'mt-3 mb-3', _4p, 'col-sm-8 text-right');;
                if ($link > 0) {
                    $linea = a_enid($linea, ["href" => $path, 'target' => "_blank"]);
                }


                $nota[] = $linea;
            }
        }

        $response = d(d($nota, 12), 'row mt-5 mb-5 border');
        return es_data($data) ? $response : '';
    }

    function crea_seccion_recordatorios($recordatorios)
    {

        $response = [];
        if (es_data($recordatorios)) {

            $response[] = _titulo("Recordatorios", 4);
        }
        foreach ($recordatorios as $row) {

            $id_recordatorio = $row["id_recordatorio"];
            $status = ($row["status"] > 0) ? 0 : 1;

            $config = [
                "type" => "checkbox",
                "class" => "item_recordatorio checkbox_enid",
                "onclick" =>
                "modifica_status_recordatorio({$id_recordatorio} , {$status})",
            ];

            if ($row["status"] > 0) {

                $config = [
                    "checked" => true,
                    "type" => "checkbox",
                    "class" => "checkbox_enid item_recordatorio",
                    "onclick" =>
                    "modifica_status_recordatorio({$id_recordatorio} , {$status})",
                ];
            }

            $item = [];
            $item[] = flex(input($config), $row["descripcion"], _between);
            $registro =
                date_format(date_create($row["fecha_cordatorio"]), 'd M Y H:i:s');

            $item[] = d($registro, 'text-right');

            $response[] = d($item, 'mt-4 border-bottom');
        }

        $response = d(d($response, 12), 'row mt-5 mb-5 border');
        return es_data($recordatorios) ? $response : '';
    }

    function seccion_tipificaciones($tipificaciones)
    {

        $response = [];
        foreach ($tipificaciones as $row) {

            $response[] = flex(

                text_icon("fa fa-clock-o", $row["fecha_registro"]),
                $row["nombre_tipificacion"],
                "row mt-4 d-flex align-items-center  border-bottom",
                "col-lg-4 p-0",
                "col-lg-8 p-0 text-right"
            );
        }
        return append($response);
    }

    function crea_seccion_productos($productos_orden_compra)
    {

        $response = [];
        foreach ($productos_orden_compra as $row) {

            $linea_producto_orden_compra = [];
            $total = $row["num_ciclos_contratados"];
            $id_proyecto_persona_forma_pago = $row["id"];
            $imagen =
                img(
                    [
                        "src" => $row["url_img_servicio"],
                        "class" => "img_servicio mah_150",

                    ]
                );
            $imagen = a_enid(
                $imagen,
                [
                    "href" => path_enid("producto", $row["id_servicio"]),
                    "target" => "_black",
                ]
            );

            $precios = d(money($row["precio"]), 'strong h4 mx-auto');
            $texto_precio = flex("Costo por unidad", $precios, 'flex-column');

            $editar_cantidad = icon(
                _text_(_editar_icon, "edicion_cantidad"),
                [

                    "id" => $id_proyecto_persona_forma_pago
                ]
            );

            $clase_cantidad = _text(
                "cantidad_",
                $id_proyecto_persona_forma_pago
            );

            $selector_cantidad = selector_cantidad(0, 100, $clase_cantidad);
            $icon = flex($total, $editar_cantidad, '', 'mr-3 f11 texto_cantidad');
            $actualizar = format_link("actualizar", ["class" => "botton_actualizar"]);


            $clase_cantidades = _text(
                "seccion_edicion_cantidad_",
                $id_proyecto_persona_forma_pago
            );

            $clase_icono_cantidades = _text(
                "icono_edicion_cantidad_",
                $id_proyecto_persona_forma_pago
            );

            $elementos = [
                d($icon, _text_('seccion_cantidad', $clase_icono_cantidades)),
                d($selector_cantidad, _text_($clase_cantidades, 'd-none')),
                d($actualizar, _text_($clase_cantidades, 'mt-3 d-none'))
            ];

            $clase_iconos = _text_(
                'flex-column ',
                _text("seccion_edicion_cantidad_", $id_proyecto_persona_forma_pago)
            );

            $icono_edicion = d($elementos, $clase_iconos);

            $linea = [
                $imagen,
                $texto_precio,
                $icono_edicion
            ];

            $clases = _text_(_between_md, 'mt-5 border-bottom d-flex');
            $contenido = d($linea, $clases);
            $linea_producto_orden_compra[] = d_row($contenido);

            $response[] = append($linea_producto_orden_compra);
        }

        $response[] = hiddens(["class" => "id_producto_orden_compra"]);


        return append($response);
    }

    function selector_cantidad($es_servicio, $existencia, $extra = '')
    {

        $config = [
            "name" => "cantidad",
            "class" => _text_("cantidad form-control ", $extra),
            "id" => "cantidad"
        ];

        $select[] = _text_("<select ", add_attributes($config), ">");
        for ($a = 1; $a < max_compra($es_servicio, $existencia); $a++) {

            $select[] = "<option value=" . $a . ">" . $a . "</option>";
        }
        $select[] = "</select>";

        return append($select);
    }


    function create_fecha_contra_entrega($productos_orden_compra, $domicilio, $es_venta_cancelada)
    {

        if (es_data($domicilio) > 0 && es_data($productos_orden_compra)) {

            $recibo = $productos_orden_compra[0];
            $entrega = ($es_venta_cancelada) ?
                "SE CANCELÓ LA ENTREGA, LA FECHA QUE SE HABÍA PLANEADO FUÉ EL" :
                "SE ENTREGARÁ EL ";


            $tipos_fechas = [0, "fecha_contra_entrega", "fecha_entrega"];
            $id_tipo = (int)$recibo["tipo_entrega"];
            $tipo = ($recibo['contra_entrega_domicilio']) ? $tipos_fechas[1] : $tipos_fechas[$id_tipo];
            $fecha_entrega = $recibo[$tipo];


            $color = ($es_venta_cancelada) ? 'red_enid_background' : 'blue_enid2';
            $formato_entrega = _text_(_between, " shadow p-3 white mb-5 mt-5", $color);
            $contenido = flex($entrega, $fecha_entrega, $formato_entrega);
            $fecha = d_row($contenido);
        } else {


            $titulo =
                _titulo('ups! esta orden no cuenta con domicilio de entrega registrado', 4);
            $fecha = d($titulo, 'row bg-warning p-1');
        }

        return $fecha;
    }

    function fecha_espera_servicio($recibo, $servicio)
    {


        $fecha = "";
        if (es_data($recibo) && es_data($servicio) && pr(
            $servicio,
            "flag_servicio"
        )) {

            $recibo = $recibo[0];
            $t[] = d(
                "FECHA EN QUE SE ESPERA REALIZAR EL SERVICIO ",
                "strong underline"
            );
            $t[] = d(date_format(
                date_create($recibo["fecha_contra_entrega"]),
                'd M Y H:i:s'
            ), "ml-auto");
            $text = d(
                append($t),
                " d-flex p-3 row bg-light border border-primary border-top-0 border-right-0 border-left-0 strong mb-5"
            );
            $fecha = ($recibo["tipo_entrega"] > 1) ? $text : "";
        }

        return $fecha;
    }


    function notificacion_cambio_fecha($recibo, $num_compras, $saldo_cubierto)
    {


        if (es_data($recibo)) {
            return "";
        }
        $tipo = $recibo[0]["tipo_entrega"];
        if ($tipo == 1 && $saldo_cubierto < 1) {

            $class = 'nula';
            $str_prob = "PROBABILIDAD NULA DE COMPRA";

            switch ($recibo[0]["modificacion_fecha"]) {

                case 0:
                    $class = 'alta';
                    $str_prob = "PROBABILIDAD ALTA DE COMPRA";
                    break;
                case 1:

                    $class = 'media';
                    $str_prob = "PROBABILIDAD MEDIA DE COMPRA";
                    if ($num_compras > 0) {
                        $class = 'alta';
                        $str_prob = "PROBABILIDAD ALTA DE COMPRA";
                    }
                    break;
                case 2:
                    $class = 'baja';
                    $str_prob = "PROBABILIDAD BAJA DE COMPRA";
                    if ($num_compras > 0) {
                        $class = 'media';
                        $str_prob = "PROBABILIDAD MEDIA DE COMPRA";
                    }

                    break;
            }

            if ($recibo[0]["status"] == 10) {

                $class = 'baja';
                $str_prob = "PROBABILIDAD BAJA NULA (SE CANCELÓ)";
            }

            return d($str_prob, $class . " border shadow row", 1);
        }
    }

    function create_seccion_saldos($productos_orden_compra, $data)
    {


        $recompensa = $data["recompensa"];
        $costo_envio_cliente = 100;
        $deuda = total_pago_pendiente($productos_orden_compra, $recompensa);
        $descuento_premium = $deuda["descuento_aplicado"];
        $monto_total = $deuda["subtotal"];
        $monto_pagado = $deuda["monto_pagado"];
        $monto_pagado_recompensa = ($monto_pagado > 0) ? ($monto_pagado - $recompensa) : 0;

        $ext = ($monto_pagado < 1) ? "text-danger" : "text-primary";

        $subtotal_descuento = 'col-md-12 text-secondary';

        $text[] = d(_text_("Subtotal", money($monto_total)), $subtotal_descuento);
        $total = ($monto_total - $descuento_premium);
        $text[] = d(_text_("Descuento", _text(money($descuento_premium))), $subtotal_descuento);
        $text[] = d(_text_("Total", money($total)), "col-md-12 mt-3 black display-5");
        $text[] = d(_text_("Abonado", money($monto_pagado_recompensa)), _text_($ext, 'col-md-12 text-right f12'));


        return bloque($text);
    }


    function create_seccion_tipo_entrega($recibo, $tipos_entregas)
    {

        $r = [];
        if (es_data($recibo)) :
            $tipo = "";
            $id_tipo_entrega = $recibo[0]["tipo_entrega"];
            foreach ($tipos_entregas as $row) {

                if ($row["id"] == $id_tipo_entrega) {
                    $tipo = $row["nombre"];
                    $r[] = hiddens(
                        [
                            "class" => "text_tipo_entrega",
                            "value" => $tipo,
                        ]
                    );
                    break;
                }
            }


            $text[] = d(_titulo($tipo, 1), _12p);
            $text[] = d(icon('fa fa fa-pencil'), 'editar_tipo_entrega ml-auto');
            $response[] = append($text);
            $response[] = create_select(
                $tipos_entregas,
                "tipo_entrega",
                "tipo_entrega form_edicion_tipo_entrega mt-3 mb-3",
                "tipo_entrega",
                "nombre",
                "id",
                0,
                1,
                0,
                "-"
            );

            return bloque($response, 'd-none');

        endif;
    }


    function crea_fecha_entrega($recibo)
    {

        $response = "";
        if (es_data($recibo)) :
            $recibo = $recibo[0];
            $t[] = d(icon("fa fa-check-circle") . "PEDIDO ENTREGADO", "strong");
            $t[] = d($recibo["fecha_entrega"]);
            $text = ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) ? append($t) : "";

            if ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) :
                $response = d(
                    $text,
                    "letter-spacing-5 top_30 border padding_10 botttom_20 contenedor_entregado mb-5 row"
                );
            endif;

        endif;

        return $response;
    }

    function crea_estado_venta($status_ventas, $recibo)
    {

        $response = "";
        if (es_data($recibo)) :

            $status = pr($recibo, "status");
            $text_status = "";

            foreach ($status_ventas as $row) {

                if ($status == $row["id_estatus_enid_service"]) {
                    $text_status = $row["text_vendedor"];
                    break;
                }
            }
            $class = "row bg_black white p-4 mb-5 text-uppercase 
            rounded-0 text-center format_action font-weight-bold";
            $response = d($text_status, $class);

        endif;

        return $response;
    }

    function seccion_usuario($usuario, $recibo, $data)
    {

        $r = [];

        $id_usuario = pr($recibo, "id_usuario");
        $telefonono = '';
        foreach ($usuario as $row) {

            $opt = ["MUJER", "HOMBRE", "INDEFINIDO"];


            $telefonono = $row["tel_contacto"];
            $r[] = d(format_link_nombre_perfil($row));
            $r[] = d(phoneFormat($telefonono), 'mt-3');

            $facebook = $row["facebook"];
            if (strlen($facebook) > 10) {

                $link = a_enid(
                    "Facebook",
                    ['href' => $row["facebook"], 'target' => "_blanck"]
                );
                $r[] = d($link, 'mt-3');
            }

            $url_lead = $row["url_lead"];
            if (strlen($url_lead) > 10) {

                $link = a_enid(
                    "Conversación en Facebook",
                    ['href' => $row["url_lead"], 'target' => "_blanck"]
                );
                $r[] = d($link, 'mt-3');
            }

            if ($row["sexo"] != 2) {
                $r[] = d($opt[$row["sexo"]]);
            }


            $r[] = d(
                icon("fa-pencil configurara_informacion_cliente black"),
                "dropdown pull-right mt-3"
            );
        }

        $icon = icon(
            "fa fa-cart-plus agenda_compra",
            [
                "id" => $id_usuario
            ]
        );
        $cliente = flex(
            _titulo("cliente", 2),
            $icon,
            _text_(_between, 'col-lg-12 p-0 mb-4'),
            _strong
        );
        $response[] = $cliente;
        $response[] = d($r, _12p);
        $response[] = hiddens(['class' => 'telefono_contacto_recibo', 'value' => $telefonono]);


        return bloque($response);
    }

    function compras_cliente($data)
    {

        $num = $data['num_compras'];
        $ids_compras = $data['ids_compras'];

        $solicitudes_pasadas_usuario = $data['solicitudes_pasadas_usuario'];


        $ext = "COMPRAS A LO LARGO DEL TIEMPO ";
        $base = _text_(_between, 'mt-5');
        $total = 'bg_custom_blue p-2 white';
        $text_compras = flex($ext, $num, _between, 'black', $total);
        $starts = ($num > 0) ? label("★★★★★", 'estrella') : "";

        $ext = "ANTECEDENTES DEL CLIENTE ";
        $link = path_enid('busqueda_pedidos_usuarios', $ids_compras);

        $text = flex($ext, $solicitudes_pasadas_usuario, $base, 'strong', $total);

        $response[] = d(_titulo('calificación', 2));

        $response[] = $text_compras;
        $response[] = $starts;
        $response[] = a_enid($text, ['href' => $link, 'class' => 'w-100']);

        return bloque(append($response));
    }


    function create_seccion_domicilio($domicilio, $data)
    {
        $response = "";
        $productos_orden_compra = $data["productos_orden_compra"];
        if (es_data($domicilio)) {

            $tipo_entrega = pr($productos_orden_compra, "tipo_entrega");
            $response = ($tipo_entrega != 1) ?
                create_domicilio_entrega($domicilio, $productos_orden_compra, $data) :
                create_punto_entrega($domicilio, $productos_orden_compra);
        } else {
            /*solicita dirección de envio*/
        }

        return $response;
    }

    function create_seccion_recordatorios($recibo)
    {


        $response = [];
        if (es_data($recibo) && pr($recibo, "status") == 6) {

            $text = _text_(
                "recordatorios de compra ",
                pr($recibo, "num_email_recordatorio")
            );
            $contenido[] = text_icon(
                'far fa-envelope',
                $text
            );


            $response[] = bloque($contenido);
        }

        return append($response);
    }

    function seccion_cupon($cupon)
    {

        $response = [];
        if (es_data($cupon)) {

            $valor = pr($cupon, 'valor');
            $contenido[] = d(_titulo("cupón promocional", 4));
            $ext = _text_(_registro, 'mt-5');
            $contenido[] = d(pr($cupon, 'cupon'), $ext);

            $contenido[] = d("Valido por", 'mt-4');
            $contenido[] = d(money($valor), 'h4');

            $seccion = d($contenido, 'col-sm-8 mx-auto text-center');
            $response[] = bloque($seccion);
        }
        return append($response);
    }


    function link_nota()
    {
        return d(a_enid(
            "AGREGAR NOTA",
            ["class" => "agregar_comentario", "onClick" => "agregar_nota();"]
        ));
    }

    function link_costo($response, $data, $recibo, $es_vendedor)
    {

        $id_orden_compra = $data["orden"];
        if (!$es_vendedor && es_data($recibo)) {

            $saldo = pr($recibo, "saldo_cubierto");
            $ext = _text("/?costos_operacion=", $id_orden_compra, "&saldado=", $saldo);
            $url = path_enid("pedidos", $ext);
            $link = a_enid(
                "COSTOS DE OPERACIÓN",
                [
                    "href" => $url,
                    'class' => 'black'
                ]
            );

            $response[] = d($link);
        }
        return $response;
    }

    function lista_negra($response, $recibo, $es_vendedor)
    {


        $es_orden_lista_negra = es_orden_lista_negra($recibo);
        if (!$es_vendedor) {


            $id_usuario = pr($recibo, "id_usuario");
            if (!$es_orden_lista_negra) {

                $response[] = d(
                    a_enid(
                        "LISTA NEGRA",
                        [

                            "onclick" => "confirma_envio_lista_negra({$id_usuario})",
                        ]
                    )
                );
            } else {
                $response[] = d(
                    a_enid(
                        "SACAR DE LA LISTA NEGRA",
                        [

                            "onclick" => "confirma_desbloqueo_lista_negra({$id_usuario})",
                        ]
                    )
                );
            }
        }
        return $response;
    }

    function link_cambio_estado_venta()
    {

        return d(
            a_enid(
                "STATUS DE LA COMPRA",
                [

                    'class' => 'editar_estado_compra'
                ]
            )
        );
    }

    function intento_reventa($x, $recibo, $data)
    {


        $id_usuario = pr($recibo, "id_usuario");
        $id_orden_compra = $data["orden"];
        $es_lista_negra = es_lista_negra($data);
        if (!$es_lista_negra) {

            $x[] = d(
                a_enid(
                    "REVENTA",
                    [

                        "onclick" => "confirma_intento_reventa({$id_usuario}, {$id_orden_compra})",
                    ]
                )
            );
        }

        return $x;
    }

    function intento_recuperacion($recibo, $data)
    {

        $id_usuario = pr($recibo, "id_usuario");
        $id_recibo = pr($recibo, "id");
        $response = [];

        $es_intento = (pr($recibo, 'saldo_cubierto') < 1);
        $tipo_entrega = pr($recibo, 'tipo_entrega');
        $fecha_contra_entrega = pr($recibo, 'fecha_contra_entrega');
        $fecha_entrega = pr($recibo, 'fecha_entrega');
        $fecha = ($tipo_entrega == 1) ? $fecha_contra_entrega : $fecha_entrega;
        $fecha_entrega = date_create($fecha)->format('Y-m-d');
        $fecha = horario_enid();
        $hoy = $fecha->format('Y-m-d');
        $dias = date_difference($hoy, $fecha_entrega);

        $pasaron_dias = ($dias > 0);
        $es_lista_negra = es_lista_negra($data);
        $es_visible = ($es_intento && $pasaron_dias && !$es_lista_negra);
        if ($es_visible) {

            $aviso = _text_('pasaron ', $dias, 'dias desde que inció su proceso de compra hasta la fecha');
            $tiempo_trasncurrido = d($aviso, 'text-danger text-uppercase fp8');
            $response[] = d(
                a_enid(
                    _d("RECUPERACIÓN", $tiempo_trasncurrido),
                    [

                        "onclick" => "confirma_intento_recuperacion({$id_usuario}, {$id_recibo}, {$dias})",
                    ]
                )
            );
        }


        return [
            'es_visible' => $es_visible,
            'text' => append($response)
        ];
    }


    function link_cambio_fecha($recibo, $id_orden_compra)
    {

        if (es_data($recibo)) {

            $recibo = $recibo[0];
            $id_recibo = $recibo["id"];
            $status = $recibo["status"];
            $saldo_cubierto_envio = $recibo["saldo_cubierto_envio"];
            $monto_a_pagar = $recibo["monto_a_pagar"];
            $se_cancela = $recibo["se_cancela"];
            $fecha_entrega = $recibo["fecha_entrega"];
            $ubicacion = $recibo["ubicacion"];
            $tipo_entrega = $recibo["tipo_entrega"];

            return d(
                a_enid(
                    "MODIFICAR LA FECHA DE ENTREGA",
                    [
                        "class" => "editar_horario_entrega",
                        "id" => $id_recibo,
                        "onclick" => "confirma_cambio_horario({$tipo_entrega}, {$ubicacion}, {$id_orden_compra} , {$status} , {$saldo_cubierto_envio} , {$monto_a_pagar} , {$se_cancela} , '" . $fecha_entrega . "' )",
                    ]
                )
            );
        }
    }

    function link_recordatorio($data, $response)
    {

        $id_orden_compra = $data["orden"];
        $es_lista_negra = es_lista_negra($data);
        if (!$es_lista_negra) {


            $extra = _text("/?recibo=", $id_orden_compra, "&recordatorio=1");
            $path = path_enid("pedidos", $extra);
            $link = a_enid(
                "AGENDAR RECORDATORIO",
                [
                    'class' => 'black',
                    'href' => $path
                ]
            );
            $response[] = d($link);
        }
        return $response;
    }
    function link_garantia($data, $response)
    {

        $id_orden_compra = $data["orden"];
        $es_lista_negra = es_lista_negra($data);
        if (!$es_lista_negra) {

            $path = path_enid("garantia", $id_orden_compra);
            $link = a_enid(
                "Garantía",
                [
                    'class' => 'black',
                    'href' => $path
                ]
            );
            $response[] = d($link);
        }
        return $response;
    }


    function text_punto_encuentro($domicilio, $productos_ordenes_compra)
    {
        $response = "";
        $fecha_contra_entrega = pr($productos_ordenes_compra, 'fecha_contra_entrega');
        foreach ($domicilio as $row) {

            $id = $row["id_tipo_punto_encuentro"];
            $lugar_entrega = strong($row["lugar_entrega"]);
            $tipo = $row["tipo"];
            $nombre_linea = $row["nombre_linea"];


            switch ($id) {

                    //1 | LÍNEA DEL METRO
                case 1:
                    $response =
                        _text_(
                            "ESTACIÓN DEL METRO ",
                            $lugar_entrega,
                            " LINEA ",
                            $row["numero"],
                            $nombre_linea,
                            " COLOR ",
                            $row["color"],
                            _titulo(format_fecha($fecha_contra_entrega, 1), 2)
                        );
                    break;
                    //2 | ESTACIÓN DEL  METRO BUS
                case 2:
                    $response = _text_($tipo, $lugar_entrega, $nombre_linea);

                    break;

                default:

                    break;
            }
        }
        return $response;
    }

    function create_punto_entrega($domicilio, $recibo)
    {

        $punto_encuentro = text_punto_encuentro($domicilio, $recibo);
        $encabezado = d_p(_titulo("punto de encuentro", 2));
        $encuentro = d_p($punto_encuentro, "contenido_domicilio mt-3");
        $contenido = add_text($encabezado, $encuentro);
        return bloque($contenido);
    }

    function seccion_texto_ubicacion($domicilios, $es_ubicacion)
    {
        $response = [];

        foreach ($domicilios as $row) {

            if ($es_ubicacion < 1) {

                $response[] =
                    _text_(
                        $row["calle"],
                        "NÚMERO",
                        $row["numero_exterior"],
                        "NÚMERO INTERIOR",
                        $row["numero_interior"],
                        "COLONIA",
                        $row["asentamiento"],
                        "DELEGACIÓN/MUNICIPIO",
                        $row["municipio"],
                        "ESTADO ",
                        $row["estado"],
                        "CÓDIGO POSTAL ",
                        $row["cp"]
                    );
            } else {

                $response[] = valida_texto_maps($row["ubicacion"]);
                $response[] = format_adicional_asentamiento_ubicaciones($row);
            }

            break;
        }
        return $response;
    }

    function create_domicilio_entrega($domicilios, $productos_orden_compra, $data)
    {

        $contra_entrega_domicilio = pr($productos_orden_compra, 'contra_entrega_domicilio');
        $fecha_contra_entrega = format_fecha(pr($productos_orden_compra, 'fecha_contra_entrega'), 1);
        $es_ubicacion = pr($productos_orden_compra, 'ubicacion');
        $direccion = seccion_texto_ubicacion($domicilios, $es_ubicacion);

        if ($contra_entrega_domicilio > 0) {

            $direccion[] = _titulo('pago contra entrega a domicilio, se entregará el', 2);
            $direccion[] = _titulo($fecha_contra_entrega, 2);
        }

        $path = path_enid(
            'pedido_seguimiento',
            _text($data["orden"], '&domicilio=1&asignacion_horario_entrega=1')
        );

        $direccion[] = d(
            icon(
                _editar_icon,
                [
                    "onclick" => "confirma_cambio_domicilio('" . $path . "')"
                ]
            ),
            'text-right'
        );

        $str_direccion = append($direccion);
        $extra = ($es_ubicacion) ?: 'text-uppercase';

        $bloque = flex(
            "domicilio de envío",
            $str_direccion,
            _text_('flex-column', $extra),
            _strong
        );

        return bloque($bloque);
    }

    function notificacion_lista_negra($data)
    {

        $response = [];
        $fue_lista_negra = es_data($data['usuario_lista_negra']);
        if (es_data($data['es_lista_negra']) || $fue_lista_negra) {

            $texto = ($fue_lista_negra) ?
                'Ya no vendemos a esta persona quedó mal en el pasado, fue enviado a lista negra' :
                'este usuario fué enviado a lista negra';
            $str = _titulo($texto, '', 'white');
            $response[] = d($str, 'row red_enid_background p-2 white mb-5');
        }

        return append($response);
    }


    function frm_usuario($usuario)
    {
        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $action = "../../q/index.php/api/usuario/index/";
            $attr = [
                "METHOD" => "PUT",
                "id" => "form_set_usuario",
                "class" => "border form_set_usuario padding_10 row",
            ];
            $form[] = form_open($action, $attr);
            $form[] = d(_titulo('cliente', 2));


            $form[] = input_frm(
                'col-sm-12 mt-5 p-0',
                'Nombre',
                [
                    "name" => "name",
                    "value" => $usuario["name"],
                    "type" => "text",
                    "required" => "true",
                    "class" => 'nombre_cliente',
                    "id" => 'nombre_cliente',
                    "uppercase" => True
                ]
            );


            $form[] = input_frm(
                'col-sm-12 mt-5 p-0',
                'Apellido paterno:',
                ([
                    "name" => "apellido_paterno",
                    "class" => "apellido_paterno",
                    "id" => "apellido_paterno",
                    "value" => $usuario["apellido_paterno"],
                    "type" => "text",
                    "uppercase" => True
                ])
            );


            $form[] = input_frm(
                'col-sm-12 mt-5 p-0',
                'Apellido materno:',
                ([
                    "name" => "apellido_materno",
                    'class' => 'apellido_materno',
                    'id' => 'apellido_materno',
                    "value" => $usuario["apellido_materno"],
                    "type" => "text",
                    "uppercase" => True
                ])
            );

            $form[] = input_frm(
                'col-sm-12 mt-5 p-0',
                'Facebook:',
                ([
                    'name' => 'facebook',
                    'value' => $usuario["facebook"],
                    "class" => "facebook",
                    "id" => "facebook_cliente",
                    "onkeypress" => "minusculas(this);",
                ])
            );

            $form[] = input_frm(
                'col-sm-12 p-0',
                'Link de conversación en Facebook:',
                ([
                    'name' => 'url_lead',
                    'value' => $usuario["url_lead"],
                    "class" => "url_lead",
                    "id" => "url_lead_cliente",
                    "onkeypress" => "minusculas(this);",
                ])
            );


            $form[] = input_frm(
                'col-sm-12 mt-5 p-0',
                'Correo electrónico:',
                ([
                    'name' => 'email',
                    'value' => $usuario["email"],
                    "required" => "true",
                    "class" => "email email",
                    "id" => "email_cliente",
                    "onkeypress" => "minusculas(this);",
                ])
            );


            $form[] = input_frm(
                'col-sm-12 mt-5 p-0',
                'Teléfono:',
                ([
                    'name' => 'tel_contacto',
                    'value' => $usuario["tel_contacto"],
                    "required" => "true",
                    'type' => "tel",
                    "maxlength" => 13,
                    "minlength" => 8,
                    "class" => "telefono telefono_info_contacto",
                    'id' => 'telefono_cliente'
                ])
            );

            $form[] = input([
                "value" => $usuario["id_usuario"],
                "name" => "id_usuario",
                "type" => "hidden",

            ]);
            $opt[] = [
                "text" => "Femenino",
                "val" => 0
            ];
            $opt[] = [
                "text" => "Masculino",
                "val" => 1
            ];
            $opt[] = [
                "text" => "Indefinido",
                "val" => 2
            ];
            $form[] = create_select(
                $opt,
                "sexo",
                "sexo mt-5 form-control",
                "sexo",
                "text",
                "val",
                0,
                $usuario["sexo"]
            );
            $form[] = btn("GUARDAR", ["class" => "top_30 bottom_50"]);
            $form[] = form_close(place("place_form_set_usuario"));
            return d($form, ["id" => "contenedor_form_usuario"]);
        }
    }

    function es_orden_pagada_entregada($data)
    {
        $response = false;
        $productos_orden_compra = $data['productos_orden_compra'];

        if (es_data($productos_orden_compra)) {

            $saldo_cubierto = pr($productos_orden_compra, 'saldo_cubierto');
            $response = ($saldo_cubierto > 0 && es_orden_entregada($data));
        }
        return $response;
    }

    function es_orden_pagada($data)
    {

        $productos_orden_compra = $data["productos_orden_compra"];
        $cancelada_no_pagada = 0;
        foreach ($productos_orden_compra as $row) {

            $saldo_cubierto = $row["saldo_cubierto"];
            $se_cancela = $row["se_cancela"];
            if ($saldo_cubierto < 1 || $se_cancela > 0) {
                $cancelada_no_pagada++;
            }
        }


        return ($cancelada_no_pagada < 1);
    }

    function es_lista_negra($data)
    {
        return es_data($data['usuario_lista_negra']);
    }

    function es_usuario_referencia($data)
    {

        return ($data['id_usuario_referencia'] === $data['id_usuario']);
    }
}
