<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function propietario($data, $usurio_actual, $usuario_venta, $id_usuario_referencia, $si_falla = FALSE)
    {

        $puede_repartir = es_repartidor($data);
        $es_propietario = ($usurio_actual == $usuario_venta || $usurio_actual == $id_usuario_referencia || $puede_repartir);
        if ($si_falla !== FALSE) {
            if (!$es_propietario) {

                redirect($si_falla);
            } else {
                return $es_propietario;
            }

        } else {
            return $es_propietario;
        }
    }


    function render_pendidos($data)
    {

        $orden = $data["orden"];
        $status_ventas = $data["status_ventas"];
        $r = $data["recibo"];
        $r += [
            "id_usuaario_actual" => $data['id_usuaario_actual']
        ];

        $es_venta_comisionada = $data['es_venta_comisionada'];
        $usuario_comision = $data['usuario_comision'];
        $id_cliente = pr($r, 'id_usuario');
        $domicilio = $data["domicilio"];
        $num_compras = $data["num_compras"];
        $id_recibo = $data["id_recibo"];
        $cupon = $data['cupon'];
        $negocios = $data['negocios'];
        $usuario_tipo_negocio = $data['usuario_tipo_negocio'];
        $id_perfil = $data['id_perfil'];
        $usuario = $data["usuario"];
        $es_vendedor = $data['es_vendedor'];
        $es_venta_cancelada = es_orden_cancelada($data);
        $menu = menu($domicilio, $r, $id_recibo, $usuario, $es_vendedor);
        $re[] = d($menu, 'col-sm-12 mr-5 pr-5 d-md-none');

        $id_status = pr($r, 'status');

        $text_estado_venta = search_bi_array(
            $status_ventas, 'id_estatus_enid_service', $id_status, 'text_vendedor');

        $saldo_cubierto = pr($r, "saldo_cubierto");
        $re[] = notificacion_lista_negra($data);
        $re[] = frm_pedidos($data, $r, $id_perfil, $es_venta_comisionada, $usuario_comision, $orden, $text_estado_venta);
        $re[] = d(crea_estado_venta($status_ventas, $r));
        $re[] = crea_seccion_solicitud($r);
        $re[] = crea_seccion_productos($r);
        $re[] = crea_fecha_entrega($r);
        $re[] = create_fecha_contra_entrega($r, $domicilio, $es_venta_cancelada);
        $re[] = fecha_espera_servicio($r, $data["servicio"]);
        $re[] = notificacion_cambio_fecha(
            $r, $num_compras, $saldo_cubierto
        );
        $re[] = crea_seccion_recordatorios($data["recordatorios"]);
        $re[] = create_seccion_tipificaciones($data["tipificaciones"]);
        $re[] = frm_nota($id_recibo);
        $re[] = create_seccion_comentarios($data["comentarios"]);
        $respuestas = tags_arquetipo($data);
        $unicos = $respuestas['unicos'];

        $seccion_arquetipos[] = formulario_arquetipos(
            $data,
            $id_cliente,
            $negocios, $usuario_tipo_negocio,
            $unicos
        );


        $seccion_arquetipos[] = $respuestas['respuestas'];

        if (!is_mobile()) {
            $re[] = append($seccion_arquetipos);
        }
        $response[] = d(d($re, 12), 8);


        $seccion_venta[] = compra(
            $es_venta_cancelada,
            $r,
            $domicilio,
            $usuario,
            $id_recibo,
            $cupon, $es_vendedor,
            $id_perfil, $status_ventas,
            $data
        );

        if (is_mobile()) {
            $seccion_venta[] = d($seccion_arquetipos, 12);
        }
        $response[] = d(
            $seccion_venta, 4
        );
        $response[] = hiddens_detalle($r);
        $tipos_entregas = $data["tipos_entregas"];

        $response[] = opciones_compra(
            $data, $r, $id_recibo, $es_vendedor, $tipos_entregas, $es_venta_cancelada);

        $response[] = hiddens(['class' => 'id_usuario_referencia', 'value' => $data['id_usuario_referencia']]);

        $response[] = hiddens(['class' => 'es_lista_negra', 'value' => es_lista_negra($data)]);

        return d($response, _10auto);

    }

    function opciones_compra($data, $recibo, $id_recibo, $es_vendedor, $tipos_entregas, $es_venta_cancelada)
    {

        $contenido[] = d(_titulo('¿Hay algo que hacer?'), 'mb-5  text-center');
        $x[] = tracker($id_recibo, $es_venta_cancelada);
        $x[] = link_cambio_estado_venta();
        $x[] = link_cambio_fecha($recibo);
        $x = link_cambio_punto_encuentro($data, $x, $recibo);
        $x = link_cambio_domicilio($data, $x, $recibo);
        $x = link_recordatorio($recibo, $data, $x);
        $x[] = link_nota();
        $x = link_costo($x, $data, $id_recibo, $recibo, $es_vendedor);
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

    function link_cambio_punto_encuentro($data, $response, $recibo)
    {


        if (es_data($recibo) && !es_orden_cancelada($data)) {


            $id_recibo = pr($recibo, 'id_proyecto_persona_forma_pago');
            $form[] = frm_pe_avanzado($id_recibo);
            $form[] = d(
                a_enid(
                    text_cambio_fecha_hora($recibo, 1),
                    [
                        "class" => "lugar_horario_entrega",
                        "id" => $id_recibo,
                        "onclick" => "confirma_lugar_horario_entrega()",
                    ]
                )
            );
            $response[] = append($form);
        }
        return $response;

    }


    function link_cambio_domicilio($data, $response, $recibo)
    {

        if (es_data($recibo) && !es_orden_cancelada($data)) {

            $id_recibo = pr($recibo, 'id_proyecto_persona_forma_pago');
            $path = path_enid('pedido_seguimiento', _text($id_recibo, '&domicilio=1&asignacion_horario_entrega=1'));
            $form[] =
                a_enid(
                    text_cambio_fecha_hora($recibo, 2),
                    [

                        'class' => 'black',
                        "onclick" => "confirma_cambio_domicilio('" . $path . "')",
                    ]
                );
            $response[] = append($form);
        }
        return $response;

    }

    function text_cambio_fecha_hora($recibo, $tipo)
    {

        $tipo_entrega = (int)pr($recibo, 'tipo_entrega');
        $text = '';
        if ($tipo === 1) { // MENU PAGO CONTRA ENTREGA
            if ($tipo === $tipo_entrega) {

                $text = _text_('CAMBIAR PUNTO U HORA DE ENCUENTRO', icon(_check_icon));

            } else {

                $text = 'CAMBIAR A PUNTO DE ENCUENTRO';
            }

        } else {

            if ($tipo === $tipo_entrega) {
                $text = _text_('CAMBIAR DOMICILIO DE ENTREGA', icon(_check_icon));
            } else {
                $text = 'CAMBIAR A DOMICILIO DE ENTREGA';
            }
        }


        return $text;
    }


    function formulario_arquetipos($data, $id_usuario,
                                   $negocios, $usuario_tipo_negocio, $unicos)
    {

        $response = [];
        $contestados = array_unique($unicos);

        if (es_administrador($data)) {

            $response[] = _titulo('¿Como es tu cliente?', 2);
            $id_tipo_negocio = pr($usuario_tipo_negocio, "idtipo_negocio", 39);
            $negocio_registrado = pr($usuario_tipo_negocio, "nombre", '');
            $text_tipo = _titulo('tipo negocio', 5);
            $response[] = text_icon(
                _text_(_editar_icon, 'editar_usuario_tipo_negocio'),
                _titulo($negocio_registrado, 4));
            $config_form = ["class" => 'form_usuario_tipo_negocio d-none'];
            $response[] = form_open('', $config_form);
            $tipo = create_select_selected(
                $negocios, 'idtipo_negocio', 'nombre',
                $id_tipo_negocio, 'tipo_negocio', 'usuario_tipo_negocio'
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
                $input = input_frm('', $descripcion,
                    [
                        'class' => $class,
                        'id' => $class,
                        'name' => 'tag',
                        'onkeyup' => "this.value = this.value.toUpperCase();"

                    ], '¿Falta este dato no?'
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

    function render_seguimiento($data)
    {

        $recibo = $data["recibo"];
        $id_servicio = $data["id_servicio"];


        $r[] = $data['breadcrumbs'];
        $resumen_orden_compra = resumen_orden($data, $recibo, $id_servicio);
        if (is_mobile()) {

            $z[] = $resumen_orden_compra;
        }
        $z[] = seguimiento($recibo, $data);
        if (!is_mobile()) {
            $z[] = $resumen_orden_compra;
        }

        $r[] = append($z);

        $otros_articulis_titulo = _titulo('Aquí te dejamos más cosas que te podrían interesar!', 2);
        $r[] = d($otros_articulis_titulo, 'mt-5 d-none sugerencias_titulo col-sm-12 ');
        $r[] = d(
            place("place_tambien_podria_interezar"), "col-sm-12"
        );
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
            ]);
        $r[] = gb_modal(notifica_entrega_modal($recibo, $data), 'modal_notificacion_entrega');
        return append($r);

    }

    function seguimiento($recibo, $data)
    {

        $es_vendedor = $data["es_vendedor"];
        $domicilio = $data["domicilio"];

        $r[] = _titulo("¿Donde se encuentra mi pedido?");
        $tiempo = tiempo($data, $recibo, $domicilio, $es_vendedor);
        $r[] = d($tiempo, "timeline mt-5", 1);

        return d($r, 'col-sm-8 mt-5');

    }

    function resumen_orden($data, $recibo, $id_servicio)
    {

        $z = [];
        $servicio = $data["servicio"];
        $es_vendedor = $data["es_vendedor"];
        $evaluacion = evaluacion($recibo, $es_vendedor);
        $se_cancela = es_orden_cancelada($data);
        $es_orden_entregada = es_orden_entregada($recibo, $data);
        $tipo_entrega = pr($recibo, "tipo_entrega");
        $es_servicio = pr($servicio, "flag_servicio");
        $fecha_servicio = pr($recibo, "fecha_servicio");
        $fecha_contra_entrega = pr($recibo, "fecha_contra_entrega");
        $fecha_vencimiento = pr($recibo, "fecha_vencimiento");

        if ($se_cancela) {

            $text = "ORDEN CANCELADA";

        } elseif ($es_orden_entregada) {

            $text = "ORDEN ENTREGADA!";

        } else {


            $fecha = ($es_servicio) ? $fecha_servicio :
                ($tipo_entrega == 2) ? $fecha_contra_entrega : $fecha_vencimiento;

            $text = "";
            $es_orden_cancelada_engregada = es_orden_entregada_o_cancelada($recibo, $data);
            if (!$es_orden_cancelada_engregada && $tipo_entrega == 2) {

                $es_contra_entrega_domicilio = es_contra_entrega_domicilio($recibo);
                $formato_domicilio = ($es_contra_entrega_domicilio) ? 'TIENES UNA CITA EL ' : "SE  ESTIMA QUE TU PEDIDO LLEGARÁ EL";


                $text = ($es_servicio) ? "PLANEADO PARA EL DÍA " : $formato_domicilio;
                $fecha_hora_entrega = es_contra_entrega_domicilio($recibo, 1, $fecha);
                $text_entrega[] = _titulo(_text_($text, $fecha_hora_entrega), 2);

                if (puede_repartir($data)) {

                    $usuario_cliente = $data['usuario_cliente'];
                    $nombre_cliente = format_nombre($usuario_cliente);

                    $text_entrega[] = _titulo('cliente', 3, 'underline');
                    $text_entrega[] = d($nombre_cliente);
                    $text_entrega[] = d(phoneFormat(pr($usuario_cliente, 'tel_contacto')));

                }
                $text = append($text_entrega);
            }
        }

        $z[] = $evaluacion;
        $z[] = $text;
        $tipo_entrega_domicilio = ($tipo_entrega > 1) ? 'domicilio de entrega' : 'punto de encuentro';
        $z[] = _titulo($tipo_entrega_domicilio, 3, 'underline');
        $z[] = d(text_domicilio($data));
        $id_recibo = pr($recibo, "id_proyecto_persona_forma_pago");

        $text_orden = _text("ORDEN #", $id_recibo);
        $path_servicio = get_url_servicio($id_servicio);
        $path_resumen_servicio = path_enid('pedidos_recibo', $id_recibo);
        $path = (puede_repartir($data)) ? $path_resumen_servicio : $path_servicio;


        $a[] =
            a_enid(
                img(
                    [
                        "src" => pr($recibo, "url_img_servicio"),
                    ]
                )
                ,
                $path

            );
        $a[] = a_enid(_titulo($text_orden, 2, 'text-right mb-5'), $path);

        $a[] = append($z);
        if (!puede_repartir($data)) {

            $a[] = format_link('comprar nuevamente',
                [
                    'href' => path_enid('producto', $id_servicio),
                    'class' => 'mt-5'
                ]
            );
        }


        if ($data['es_administrador']) {


            $se_define_repartidor = (es_data($data['usuario_entrega']));
            $usuario_entrega = ($se_define_repartidor) ? format_nombre($data['usuario_entrega']) : '';


            $nombre = _text_('Entregará ', $usuario_entrega);
            $nombre = ($se_define_repartidor) ? $nombre : 'aún no hay repartidor asignado :(';
            $a[] = d($nombre, 'mt-5 text-center p-2 text-uppercase  bg-light border border-secondary');


            $usuario_venta = (es_data($data['vendedor'])) ? format_nombre($data['vendedor']) : '';
            $nombre = _text_('Agenda ', $usuario_venta);
            $a[] = d($nombre, 'mt-3 text-center p-2 text-uppercase  bg-light border border-secondary');

        }


        return d($a, 3);


    }

    function format_text_domicilio($domicilio, $data, $recibo, $adicionales = 0)
    {

        $text_domicilio = '';
        if (es_data($domicilio)) {
            if (es_data($recibo) && pr($recibo, 'ubicacion') < 1) {

                $domicilio = $domicilio[0];
                $calle = $domicilio['calle'];
                $entre_calles = $domicilio['entre_calles'];
                $numero_exterior = $domicilio['numero_exterior'];
                $asentamiento = $domicilio['asentamiento'];
                $municipio = $domicilio['municipio'];
                $ciudad = $domicilio['ciudad'];
                $cp = $domicilio['cp'];
                $numero_interior = $domicilio['numero_interior'];

                $str = ($adicionales > 0) ? pago_en_cita($data, $recibo) : '';

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
            } else {

                $text_ubicacion = pr($domicilio, 'ubicacion');

                $text_ubicacion = valida_texto_maps($text_ubicacion);
                $str = ($adicionales > 0) ? pago_en_cita($data, $recibo) : '';
                $text_domicilio = _text_($text_ubicacion, $str);
            }

        }
        return $text_domicilio;

    }

    function valida_texto_maps($domicilio)
    {
        $ubicacion_arreglo = explode(' ', $domicilio);
        $text = '';
        foreach ($ubicacion_arreglo as $row) {
            $text .= _text_($row);
            if (strpos($row, 'https') !== FALSE) {
                $text .= a_enid('abrir en google maps',
                    [
                        'href' => $row,
                        'target' => '_blank',
                        'style' => 'color:blue;',
                        'class' => 'text-uppercase text-right mt-3'
                    ]
                );
            }
        }
        return $text;
    }

    function text_domicilio($data)
    {

        $recibo = $data['recibo'];
        $domicilio = $data['domicilio'];
        $tipo_entrega = $domicilio['tipo_entrega'];
        $text = "";

        switch ($tipo_entrega) {

            case 1:

                $punto_encuetro = $domicilio['domicilio'];
                if (es_data($punto_encuetro)) {

                    $pe = $punto_encuetro[0];
                    $tipo = $pe['tipo'];
                    $nombre_linea = $pe['nombre_linea'];
                    $numero = $pe['numero'];
                    $nombre = $pe['nombre'];


                    $text_entrega[] = _text_(
                        'TIENES UNA CITA EL DÍA ',
                        strong(format_fecha(pr($recibo, 'fecha_contra_entrega'), 1)),
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
                        $text_entrega[] = _titulo('cliente', 3, 'underline');
                        $text_entrega[] = d($nombre_cliente);
                        $text_entrega[] = d(phoneFormat(pr($usuario_cliente, 'tel_contacto')));
                        $text_entrega[] = pago_en_cita($data, $recibo, 1);

                    }

                    $text = append($text_entrega);

                }

                break;

            case 2:

                $domicilio = $domicilio['domicilio'];
                $text = format_text_domicilio($domicilio, $data, $recibo, 1);
                break;

            default:

                break;

        }


        return $text;

    }


    function pago_en_cita($data, $recibo, $no_validar = 0)
    {

        $str = '';
        $es_contra_entrega_domicilio = es_contra_entrega_domicilio($recibo);
        if ($es_contra_entrega_domicilio || $no_validar) {
            $in_session = $data['in_session'];
            $text_entrega = ($in_session && prm_def($data, 'id_perfil') == 21)
                ? 'A TU ENTREGA COBRARÁS AL CLIENTE ' : 'A TU ENTREGA PAGARÁS';


            $boton_pagado = btn('Notificar como entregado!', ['class' => 'notifica_entrega mt-4']);
            $pago_efectivo = (puede_repartir($data)) ? $boton_pagado : '';
            $checkout = ticket_pago($recibo, [], 2);
            $saldo_pendiente = $checkout['saldo_pendiente_pago_contra_entrega'];

            $text_pago = _text_($text_entrega, money($saldo_pendiente));
            $pago_pendiente = _text_(_titulo($text_pago), $pago_efectivo);
            $es_orden_entregada = es_orden_entregada($recibo, $data);
            $str = (!$es_orden_entregada) ? d($pago_pendiente, 'mt-5 text-right') : '';

        }
        return $str;

    }


    function render_domicilio($data)
    {

        $r = $data["recibo"];
        $punto_entrega = $data['punto_entrega'];
        $lista_direcciones = $data["lista_direcciones"];
        $lista_puntos_encuentro = $data['puntos_encuentro'];
        $r = $r[0];
        $id_recibo = $r["id_proyecto_persona_forma_pago"];
        $tipo_entrega = $r["tipo_entrega"];
        $domicilio_entrega = $data['domicilio_entrega'];

        $response[] = $data['breadcrumbs'];
        $response[] =
            d(
                h('selecciona una dirección de envío',
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

        $response[] = frm_direccion($id_recibo);
        $response[] = frm_puntos($id_recibo);
        $response[] = frm_pe_avanzado($id_recibo);
        $response[] = d(
            _text(
                d_p(
                    'Haz click en el boton "Enviar a esta dirección". 
                        También puedes registrar un',
                    'mt-1'
                ),
                agregar_nueva_direccion(0),
                d(' ó ', 'ml-2 '),
                agregar_nueva_direccion()
            ),
            'mt-1 letter-spacing-1 d-lg-flex'
        );


        $response[] = hr(['class' => 'mt-5 mb-5'], 0);

        $response[] = d(
            h('usadas recientemente', 4, 'text-uppercase strong ')
        );


        $registradas = dd(
            create_direcciones($domicilio_entrega, $lista_direcciones, $id_recibo),
            crea_puntos_entrega($punto_entrega, $lista_puntos_encuentro, $id_recibo),
            10
        );
        $response[] = d(
            $registradas
            ,
            'col-lg-12 p-0 mt-5 mb-5'
        );
        $response[] = d(hr([], 0), 'col-lg-12 p-0 mt-3 mb-5');

        return d($response, 'col-lg-12 contenedor_domicilios d-none');

    }


    function frm_pedidos($data, $recibo, $id_perfil, $es_venta_comisionada, $usuario_comision, $orden, $text_estado_venta)
    {


        $r[] = d(
            a_enid(_titulo("MIS PEDIDOS"),
                [
                    "href" => path_enid("pedidos")
                ]
            ), 'row d-none d-md-block mt-5');


        $nombre_vendedor = nombre_comisionista($es_venta_comisionada, $usuario_comision, $data);
        $numero_orden = _titulo(_text_("# ORDEN ", $orden), 3);
        $recibo_vendedor = flex_md($numero_orden, $nombre_vendedor, _text(_between_md, 'text-left'));


        $r[] = d($recibo_vendedor, 'row mt-3');


        $saldo_cubierto = pr($recibo, 'saldo_cubierto');
        $se_paga_comision = pr($recibo, 'flag_pago_comision');
        $es_vendedor = in_array($id_perfil, [6, 3]);


        if ($saldo_cubierto > 0 && $se_paga_comision > 0 && $es_vendedor) {
            $comision = pr($recibo, 'comision_venta');
            $monto = p(money($comision), 'strong ml-4');
            $r[] = d(_text_('COBRASTE', $monto), 'row mt-1');
        }

        $str = _titulo($text_estado_venta, 4);

        $r[] = d("", 'row border-bottom mb-4');

        return append($r);

    }

    function nombre_comisionista($es_venta_comisionada, $usuario_comision, $data)
    {
        $response = [];
        if ($es_venta_comisionada && es_data($usuario_comision)) {


            $comisionista = $usuario_comision[0];

            $vendedor = _text_(
                'agenda',
                $comisionista['nombre'],
                $comisionista['apellido_paterno'],
                $comisionista['apellido_materno']
            );
            $response[] = p($vendedor, _text_('blue_enid3 pl-3 pr-3  white', _strong));

        } else {


            $recibo = $data['recibo'];
            $comision = pr($recibo, 'comision_venta');
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

            $vendedor = _text_('cliente',
                $usuario['nombre'],
                $usuario['apellido_paterno'],
                $usuario['apellido_materno']
            );
            $response[] = p($vendedor, _text_('pl-3 pr-3  border', _strong));

        }
        return append($response);
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
            $status_ventas, 'id_estatus_enid_service', 'nombre',
            $id_status, 'status_venta',
            'status_venta form-control status_venta_select', 0,
            $disponibilidad
        );

        $r[] = d_row($status_compra);
        $r[] = d('', "place_tipificaciones");

        $r[] = d(
            input_frm('w-100', "SALDO CUBIERTO MXM",
                [
                    "class" => "saldo_cubierto_pos_venta",
                    "id" => "saldo_cubierto_pos_venta",
                    "type" => "number",
                    "step" => "any",
                    "required" => true,
                    "name" => "saldo_cubierto",
                    "value" => $recibo[0]["saldo_cubierto"],
                ]
            )
            , 'row form_cantidad_post_venta');
        $r[] = form_cantidad($recibo);

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
        $recibo, $es_venta_comisionada, $usuario_comision, $usuario_compra
    )
    {

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
            ), "d-none contenedor_form_costos_operacion col-lg-12 p-0 "
        );
        $seccion = append($r);

        $response[] = flex_md(
            $seccion,
            format_img_recibo($path, $recibo),
            'row', _8, _4
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
            $seccion[] = d(a_enid(img($path),
                path_enid("pedidos_recibo", $r["id_proyecto_persona_forma_pago"])));

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

    function compra($es_venta_cancelada,
                    $recibo, $domicilio,
                    $usuario, $id_recibo,
                    $cupon, $es_vendedor,
                    $id_perfil,
                    $status_ventas,
                    $data
    )
    {


        $tipos_entregas = $data['tipos_entregas'];
        $menu = menu($domicilio, $recibo, $id_recibo, $usuario, $es_vendedor);
        $r[] = d($menu, 'd-none d-md-block');
        $r[] = create_seccion_tipo_entrega($recibo, $tipos_entregas);
        $r[] = enviar_a_reparto($data, $es_venta_cancelada, $domicilio, $id_recibo, $recibo, $status_ventas);
        $r[] = repatidor($data, $id_recibo);
        $r[] = tiene_domilio($domicilio);
        $r[] = format_estados_venta($data, $status_ventas, $recibo, $es_vendedor);
        $r[] = compras_cliente($data);
        $r[] = seccion_usuario($usuario, $recibo, $data);
        $r[] = frm_usuario($usuario);
        $r[] = create_seccion_domicilio($domicilio, $recibo, $data);
        $r[] = create_seccion_saldos($recibo);
        $r[] = seccion_cupon($cupon);


        return d($r, 12);

    }

    function repatidor($data, $id_recibo)
    {

        $response = [];
        $es_orden_cancelada = es_orden_cancelada($data);
        $status = pr($data['recibo'], 'status');

        if (es_administrador($data) && !$es_orden_cancelada && $status != 6) {

            $usuario = $data['repartidor'];
            $nombre = format_nombre($usuario);
            $id_usuario = pr($usuario, 'id_usuario');
            $es_orden_pagada_entregada = es_orden_pagada_entregada($data);
            $str = ($es_orden_pagada_entregada) ? 'Entregó' : 'Entregará';
            $text = _text_($str, $nombre);
            $text = text_icon(_editar_icon, $text, 0);
            $reparto = format_link($text,
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

    function tracker($id_recibo, $es_venta_cancelada)
    {
        $response = '';
        if (!$es_venta_cancelada) {

            $pedido = text_icon(_share_icon, 'Rastrear pedido', [], 0);
            $link = a_enid(
                $pedido,
                [
                    'href' => path_enid('pedido_seguimiento', $id_recibo),
                    'target' => '_black',
                    'class' => 'text-uppercase black'
                ]
            );
            $response = d($link);
        }
        return $response;

    }

    function enviar_a_reparto($data, $es_venta_cancelada, $domicilio, $id_recibo, $recibo, $status_ventas)
    {


        $response = [];
        if (!$es_venta_cancelada) {


            $punto_encuentro = "";
            $tipo_entrega = 0;
            $es_domicilio = es_data($domicilio);

            if ($es_domicilio) {

                $domicilio_entrega = $domicilio["domicilio"];
                $tipo_entrega = $domicilio["tipo_entrega"];
                $punto_encuentro = ($tipo_entrega != 1) ? "" : text_punto_encuentro($domicilio_entrega, $recibo);
            }


            if ($tipo_entrega == 1 || (es_contra_entrega_domicilio($recibo))) {


                $response[] = reparto_contra_entrega(
                    $data,
                    $status_ventas,
                    $recibo,
                    $id_recibo,
                    $punto_encuentro
                );

            }
        }

        return append($response);


    }

    function notifica_entrega_modal($recibo, $data)
    {

        $form_entrega[] = _titulo('¿Ya entregaste este pedido?');

        $checkout = ticket_pago($recibo, [], 2);
        $id_recibo = pr($recibo, 'id_proyecto_persona_forma_pago');
        $tipo_entrega = pr($recibo, 'tipo_entrega');
        $id_usuario_compra = pr($recibo, 'id_usuario');
        $saldo_pendiente = $checkout['saldo_pendiente_pago_contra_entrega'];
        $form_entrega[] = form_open('', ['class' => 'form_notificacion_entrega_cliente']);
        $form_entrega[] = hiddens(['name' => 'saldo_cubierto', 'class' => 'saldo_cubierto', 'value' => $saldo_pendiente]);
        $form_entrega[] = hiddens(['name' => 'recibo', 'value' => $id_recibo]);
        $form_entrega[] = hiddens(['name' => 'status', 'value' => 15]);
        $form_entrega[] = hiddens(['name' => 'es_proceso_compra', 'value' => '']);
        $form_entrega[] = hiddens(['name' => 'tipo_entrea', 'value' => $tipo_entrega]);
        $form_entrega[] = form_close();

        $confirmacion = format_link('Si', ['class' => 'selector_entrega']);
        $negacion = format_link('Aún no', ['class' => 'selector_negacion', 'data-dismiss' => 'modal'], 0);
        $form_entrega[] = flex($confirmacion, $negacion, _text_(_between, _mbt5));
        $form[] = d($form_entrega, 'form_confirmacion_entrega');

        $form_otros[] = _titulo('¿El cliente tiene interés sobre otros artículos?');

        $confirmacion = format_link('Si', ['class' => 'selector_interes']);
        $negacion = format_link('no, no nos comentó', ['class' => 'selector_negacion', 'data-dismiss' => 'modal'], 0);
        $form_otros[] = flex($confirmacion, d($negacion, 'selector_negacion'), _text_(_between, _mbt5));


        $form_otros[] = form_open('', ['class' => 'form_articulo_interes_entrega d-none mt-5']);
        $form_otros[] = input_frm('', '¿Qué artículo?',
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


        $form[] = d($form_otros, 'form_otros d-none');
        return append($form);
    }

    function reparto_contra_entrega($data, $status_ventas, $recibo, $id_recibo, $punto_encuentro)
    {
        $response = [];

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
            $confirmar_pedido = "confirma_reparto({$id_recibo}, '{$punto_encuentro}')";
            $text_punto_encuentro = trim(strip_tags(strip_tags_content(text_domicilio($data, 0))));
            $text_punto_encuentro = str_replace(PHP_EOL, '', $text_punto_encuentro);
            $confirm_pedido_domicilio = "confirma_reparto_contra_entrega_domicilio({$id_recibo}, '{$text_punto_encuentro}');";

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

                $path_tracker = path_enid('pedido_seguimiento', $id_recibo);
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
            $domicilio = $data['domicilio'];
            if (es_data($domicilio)) {
                $domicilio = $domicilio['domicilio'];
                $id_direccion = pr($domicilio, 'id_direccion');
            }
        }
        return $id_direccion;
    }

    function imprimir_recibo($response, $recibo, $tipos_entrega, $data)
    {

        $checkout = ticket_pago($recibo, $tipos_entrega, $format = 1);
        $es_lista_negra = es_lista_negra($data);
        if (es_data($checkout) && es_data($recibo) && !$es_lista_negra) {

            $recibo = $recibo[0];
            $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
            $id_usuario_venta = $recibo["id_usuario_venta"];
            $tipo_entrega = $recibo["tipo_entrega"];
            $descuento_entrega = $checkout['descuento_entrega'];
            $es_descuento = ($tipo_entrega == 1 && $descuento_entrega > 0);
            $saldo_pendiente = ($es_descuento) ? $checkout['saldo_pendiente_pago_contra_entrega'] : $checkout['saldo_pendiente'];
            $link = pago_oxxo('', $saldo_pendiente, $id_recibo, $id_usuario_venta);
            $contenido[] = a_enid('imprimir instrucciones de pago en oxxo',
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
        $r[] = hiddens(
            [
                "name" => "perfil",
                "class" => "perfil_consulta",
                "value" => $data["id_perfil"],
            ]
        );


        $select_comisionistas = create_select(
            $data['comisionistas'], 'id_usuario_referencia', 'comisionista form-control',
            'comisionista', 'nombre_usuario', 'idusuario', 0, 1, 0, '-');


        $r[] = form_busqueda_pedidos($data, $tipos_entregas, $status_ventas, $fechas);
        $es_busqueda = keys_en_arreglo($param,
            [
                'fecha_inicio',
                'fecha_termino',
                'type',
                'servicio'
            ]
        );


        $visibilidad = (!es_data($data['comisionistas'])) ? 'd-none' : '';
        $r[] = flex_md('Filtrar por vendedor', $select_comisionistas,
            _text_('col-sm-12 mt-md-m5 mt-3 p-0', _between_md, $visibilidad),
            _text_('text-left', $visibilidad),
            _text_('text-left', $visibilidad)
        );
        if ($es_busqueda) {

            $r[] = frm_fecha_busqueda($param["fecha_inicio"], $param["fecha_termino"], $ancho_fechas, $ancho_fechas);
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

        $titulo = _titulo("TUS ORDENES DE COMPRA");
        $busqueda = _titulo("busqueda", 3);

        $text_entregas = flex(icon(_calendario_icon), 'Próximas entregas', '', 'mr-1');
        $link = format_link($text_entregas, ['href' => path_enid('entregas')]);
        $busqueda_calendario = flex($busqueda, $link, _between);
        $response[] = d($titulo, ' col-sm-10 col-sm-offset-1 mt-5');
        $response[] = d($busqueda_calendario, ' col-sm-10 col-sm-offset-1 mt-5');
        $response[] = d($z, 10, 1);





        $secciones_tabs[] = tab_seccion(append($response), 'buscador_seccion', 1);
        $modal = gb_modal(pago_usuario_comisiones(), 'modal_pago_comision');
        $contenido_por_pago = comisiones_por_pago($data, $modal);
        $secciones_tabs[] = tab_seccion($contenido_por_pago, 'pagos_pendientes');

        $menu_pedidos = tab('Pedidos', '#buscador_seccion',['class'=>'strong']);
        $menu_pendientes = tab('Pagos pendientes', '#pagos_pendientes', ['class' => 'ml-5 strong']);
        $menu = flex($menu_pedidos, $menu_pendientes,'justify-content-end');
        $data_complete[] = d($menu, 10, 1);
        $data_complete[] = d(tab_content($secciones_tabs), 12);
        return append($data_complete);


    }

    function comisiones_por_pago($data,$modal)
    {

        $ordenes = $data['comisiones_por_pago'];
        $totales_en_pagos = 0;
        $response = [];
        $total_pago_comisiones = 0;
        $response[] = d('', 'mt-5 mb-5 row');
        if (es_data($ordenes)) {

            $ids = array_column($ordenes, 'id_usuario_referencia');
            $ids_usuario = array_unique($ids);

            foreach ($ids_usuario as $row) {

                $total = 0;
                foreach ($ordenes as $row2) {
                    if ($row == $row2['id_usuario_referencia']) {
                        $total = $total + $row2['comision_venta'];
                    }
                }
                $totales[] = [
                    'id_usuario' => $row,
                    'total_comisiones' => $total,
                ];


            }
            foreach ($totales as $row) {

                $id_usuario = $row['id_usuario'];
                $contenido = [];
                $nombre_completo = '';

                foreach ($ordenes as $row2) {

                    if ($row2['id_usuario_referencia'] == $id_usuario) {

                        $nombre_completo = format_nombre($row2);

                        break;
                    }

                }
                $total_comisiones_efectivo = $row['total_comisiones'];

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
                $config_pago['class'] = _text_($config_pago['class'], 'strong text-right');
                $contenido[] = d($total_comisiones, $config_pago);

                $response[] = d($contenido, 'border row');
            }

            $response[] = d('', 'mt-5 mb-5 row');
            foreach ($ordenes as $row) {


                $id_proyecto_persona_forma_pago = $row['id_proyecto_persona_forma_pago'];
                $comision_venta = $row['comision_venta'];


                $nombre_usuario = format_nombre($row);
                $contenido = [];

                $class = 'col-md-4 ';
                $img = img(
                    [
                        "src" => $row["url_img_servicio"],
                        "class" => "img_servicio w-25",

                    ]
                );
                $total_pago_comisiones = $total_pago_comisiones + $comision_venta;

                $contenido[] = d($img, $class);
                $contenido[] = d($nombre_usuario, $class);
                $contenido[] = d(money($comision_venta), _text_($class, 'strong'));

                $path = path_enid('pedidos_recibo', $id_proyecto_persona_forma_pago);

                $response[] = a_enid(append($contenido),
                    [
                        'class' => 'd-flex align-items-center row text-center border black',
                        'href' => $path,
                        'target' => '_blank'
                    ]
                );

            }

            $total = money($total_pago_comisiones);
            $response[] = d(_titulo(_text_('Cuenta por pagar', $total)), 'text-right mt-5');
        }

        $_response[] = d(_titulo('Cuentas por pagar',2),13);
        $_response[] =  append($response);
        $_response[] = $modal;
        return d($_response,10,1);
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

        $r[] = input_frm(_text_(_6p, 'mt-5'), 'Cliente',
            [
                "name" => "cliente",
                "id" => "cliente",
                "placeholder" => "Nombre, correo, telefono ...",
            ]);


        $r[] = hiddens(
            [
                "name" => "v",
                'value' => 1,
            ]
        );

        $r[] = input_frm(_text_(_6p, 'mt-5'), '#Recibo',
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

        $r[] = flex('Status',
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
            )
            ,
            "flex-column col-md-4 p-0 mt-3"
        );


        $busqueda_orden = create_select_selected($fechas, 'val', 'fecha', 5, 'tipo_orden', 'form-control');
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
    )
    {


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


    function menu($domicilio, $recibo, $id_recibo, $usuario, $es_vendedor)
    {


        $menu = d(icon("fa fa-plus-circle fa-3x"), "dropleft position-fixed menu_recibo");
        return d($menu, "row pull-right");


    }

    function evaluacion($recibo, $es_vendedor)
    {

        $response = "";
        if (es_data($recibo)) {

            $id_servicio = $recibo[0]["id_servicio"];
            $status = pr($recibo, "status");
            if ($status == 9 && $es_vendedor < 1) {

                $t[] = btn("ESCRIBE UNA RESEÑA");
                $t[] = d(
                    str_repeat("★", 5),
                    [
                        "class" => "text-center f2 black"
                    ]
                );
                $response = a_enid(
                    append($t),
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

        $recibo = prm_def($data, "recibo");
        $str = pr($recibo, "resumen_pedido");
        $usuario = prm_def($data, "usuario");
        if (es_data($usuario)) {

            $str .= " \n%0A" . pr($usuario, "nombre") . "\n%0A";
            $str .= pr($usuario, "tel_contacto");
        }

        $x = _titulo("RECORDATORIO", 0, 'mt-5');
        $r[] = form_open("",
            ["class" => "form_fecha_recordatorio"]);

        $input_fecha = input_frm(
            'mt-5', '¿FECHA?',
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
            "idtipo_recordatorio");
        $r[] = hiddens(
            [
                "class" => "recibo",
                "name" => "recibo",
                "value" => $data["orden"],
            ]
        );


        $r[] = textarea(
            [
                "name" => "descripcion",
                "class" => "descripcion_recordatorio mt-5",
                "rows" => 5,
            ], 0, $str);
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
        $r[] = form_open("", ["class" => "form_fecha_entrega"]);
        $r[] = d(_titulo("FECHA DE ENTREGA"), _mbt5);
        $r[] =
            input_frm('mt-5', 'NUEVA',
                [
                    "data-date-format" => "yyyy-mm-dd",
                    "name" => 'fecha_entrega',
                    "class" => "fecha_entrega",
                    'id' => 'fecha_entrega',
                    "type" => 'date',
                    "value" => date("Y-m-d"),
                    "min" => add_date(date("Y-m-d"), -15),
                    "max" => add_date(date("Y-m-d"), 15),
                ]);

        $horario_text = text_icon("fa fa-clock-o", "HORA DE ENCUENTRO");
        $horario = lista_horarios()["select"];

        $r[] = flex($horario_text, $horario, _text_(_between, 'mt-5'), _5p, _6p);

        $r[] = hiddens(
            [
                "class" => "recibo",
                "name" => "recibo",
                "value" => $orden,
            ]);
        $r[] = btn("CONTINUAR", ["class" => "mt-5"]);
        $r[] = format_load();
        $r[] = form_close(place("place_fecha_entrega"));
        $response = append($r);
        $response = d($response, 6, 1);

        return $response;


    }

    function form_cantidad($recibo)
    {

        $r[] = '<form class="form_cantidad top_20">';
        $r[] = hiddens(
            [
                "name" => "recibo",
                "class" => "recibo",
                "value" => pr($recibo, 'id_proyecto_persona_forma_pago'),
            ]);

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


        $response = d(h("Ya registraste todos los costos de operación para esta venta!",
            3), 8, 1);
        if (es_data($costos_registro)) {

            $r[] = d(_titulo("Gasto", 4, 'mt-5'));
            $form[] = form_open("", ["class" => "form_costos letter-spacing-5 mt-5"],
                ["recibo" => $id_recibo]);

            $input_monto = input_frm('', "MONTO GASTADO",
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


        $r[] = d(h("UPS! NO ENCONTRAMOS EL NÚMERO DE ORDEN", 1,
            "funny_error_message"), "text-center");
        $r[] = d(
            img(
                [
                    "src" => "../img_tema/gif/funny_error.gif",
                ]
            )
        );
        $r[] = d(a_enid("ENCUENTRA TU ORDEN AQUÍ",
            [
                "href" => path_enid("pedidos"),
                "class" => "busqueda_mensaje",
            ]
        ),
            "busqueda_mensaje_text"
        );

        return d(append($r));

    }

    function frm_direccion($id_recibo)
    {

        $r[] = '<form  class="form_registro_direccion" action="../procesar/?w=1" method="POST" >';
        $r[] = hiddens([
            "class" => "recibo",
            "name" => "recibo",
            "value" => $id_recibo,
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

    function frm_pe_avanzado($id_recibo, $es_vendedor = 0)
    {


        $r[] = '<form   class="form_puntos_medios_avanzado" action="../puntos_medios/?recibo=' . $id_recibo . '"  method="POST">';
        $r[] = hiddens([
            "name" => "recibo",
            "value" => $id_recibo,
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

    function frm_nota($id_recibo)
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
        $r[] = hiddens(["name" => "id_recibo", "value" => $id_recibo]);
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
                ), 'ml-lg-3 mt-2'
            ) :
            d(
                form_submit(
                    [
                        "class" => "agregar_direccion_pedido border-0 bg_black white ",
                    ],
                    "Domicilio de envío"
                )
                , 'ml-lg-3 mt-2'
            );

    }


    function create_direcciones($domicilio_entrega, $lista, $id_recibo)
    {

        $a = 1;
        $r = [];

        $id_domicilio = pr($domicilio_entrega, 'id_direccion', 0);
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

            $id_direccion = $row['id_direccion'];
            $en_uso = ($id_domicilio == $id_direccion);
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
                0);


            $r[] = d(append($text), _text("col-lg-4 mt-5 ", $extra));

        }

        return append($r);
    }

    function crea_puntos_entrega($punto_entrega, $lista_puntos_encuentro, $id_recibo)
    {

        $id_registro = pr($punto_entrega, 'id', 0);
        $r = [];
        if (es_data($lista_puntos_encuentro)) {
            $r[] = h('puntos de encuentro', 4, 'text-uppercase mt-5 strong text-right');
        }
        foreach ($lista_puntos_encuentro as $row) {

            $id = $row['id'];
            $nombre = ($id != $id_registro) ? $row['nombre'] : text_icon('fa fa-check-circle',
                $row['nombre']);

            $class = ($id != $id_registro) ? "dropdown-toggle bg-white w-100 text-right border-top-0 border-right-0 border-left-0 solid_bottom_2 mt-3" :
                "dropdown-toggle bg_black white w-100 text-right border-top-0 border-right-0 border-left-0 solid_bottom_2 mt-3";
            $button = form_button(
                [
                    "class" => $class,
                    "data-toggle" => "dropdown",
                    "aria-haspopup" => true,
                    "aria-expanded" => false,

                ], $nombre
            );

            $acciones = [];
            $acciones[] = d_p($nombre, 'strong');
            if ($id != $id_registro) {

                $acciones[] = format_link(
                    "Entregar en esta estación",
                    [
                        "class" => "establecer_direccion mt-2 mt-3",
                        "id" => $id,
                        'tipo' => 1,
                        "id_recibo" => $id_recibo,


                    ]
                );
            }

            $acciones[] = format_link(
                "Eliminar",
                [
                    'class' => 'eliminar_domicilio mt-3',
                    "id" => $id,
                    'tipo' => 1,
                    "id_recibo" => $id_recibo,

                ],
                0
            );

            $menu = d($acciones,
                [
                    "class" => "dropdown-menu mw_300 mh_100 p-4 border-0",

                ]
            );
            $punto_encuentro = d(add_text($button, $menu), 'dropleft');
            $r[] = d($punto_encuentro, 'text-right col-lg-12 p-0 mt-3');


        }

        return append($r);
    }

    function desc_direccion_entrega($data_direccion)
    {

        $text = [];

        if (es_data($data_direccion)) {
            if ($data_direccion["tipo_entrega"] == 2 && es_data($data_direccion["domicilio"])) {


                $domicilio = $data_direccion["domicilio"][0];
                $calle = $domicilio["calle"];

                $text[] = _text_($calle,
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

                if (is_array($data_direccion)
                    && array_key_exists("domicilio", $data_direccion)
                    && is_array($data_direccion["domicilio"])
                    && count($data_direccion["domicilio"]) > 0) {

                    $pe = $data_direccion["domicilio"][0];
                    $numero = "NÚMERO " . $pe["numero"];
                    $text[] = h("LUGAR DE ENCUENTRO", 3, ["class" => "top_20"]);
                    $text[] = d($pe["tipo"] . " " . $pe["nombre"] . " " . $numero . " COLOR " . $pe["color"],
                        1);
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
                    text_icon("fa fa-2x fa-shopping-cart",
                        "PROCEDER A LA COMPRA ", [], 0)
                    ,
                    [
                        "style" => "background:blue!important",
                        "class" => "top_30 f12",
                    ],
                    1,
                    1,
                    0,
                    path_enid("area_cliente_compras",
                        $recibo["id_proyecto_persona_forma_pago"])
                ), 1
            );

        }

        return $response;
    }

    function tiempo($data, $recibo, $domicilio, $es_vendedor)
    {

        $linea = [];
        $flag = 0;
        $recibo = $recibo[0];
        $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
        $in_session = $data['in_session'];

        for ($i = 5; $i > 0; $i--) {

            $status = texto_status($i);
            $activo = 1;

            if ($flag == 0) {
                $activo = 0;
                if ($recibo["status"] == $status["estado"]) {
                    $activo = 1;
                    $flag++;
                }
            }

            $status_actual = $recibo['status'];
            switch ($i) {


                case 1:
                    $class = "timeline__item__date_active";
                    $seccion_2 = seccion_ordenado();


                    break;

                case 2:
                    $class = (tiene_domilio($domicilio,
                            1) == 0) ? "timeline__item__date" : "timeline__item__date_active";
                    $seccion_2 = seccion_domicilio($domicilio, $id_recibo,
                        $recibo["tipo_entrega"], $es_vendedor);

                    break;
                case 3:

                    $class = ($recibo["saldo_cubierto"] > 0) ? "timeline__item__date_active" : "timeline__item__date";
                    $seccion_2 = seccion_compra($in_session, $recibo, $id_recibo, $es_vendedor);

                    break;

                case 4:

                    $paso_en_camino = in_array($status_actual, [16, 7, 15, 9]);
                    $class = ($paso_en_camino) ? "timeline__item__date_active" : 'timeline__item__date';
                    $seccion_2 = seccion_en_camino($status);
                    break;


                case 5:

                    $se_entrego = in_array($status_actual, [9, 15]);
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

        return d(p($status["text"], "timeline__item__content__description strong"),
            "timeline__item__content strong");

    }

    function seccion_compra($in_session, $recibo, $id_recibo, $es_vendedor)
    {

        $path_ticket = path_enid('area_cliente_compras', $id_recibo);
        $pago_realizado = text_icon("fa fa-check black", "COMPRASTÉ!");
        $comprar = format_link("COMPRA AHORA!", ["href" => $path_ticket]);
        $text = ($recibo["saldo_cubierto"] > 0) ? $pago_realizado : $comprar;
        $text = (!$in_session) ? 'PREPARANDO TU PEDIDO' : $text;

        return d(
            p(
                $text
                ,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content");

    }

    function seccion_en_entregado()
    {

        return d(
            p(
                'ENTREGADO'
                ,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content");

    }

    function seccion_ordenado()
    {

        return d(
            p(
                'ORDEN REALIZADA    '
                ,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content");

    }


    function seccion_en_camino()
    {

        $text = text_icon(_check_icon, 'TU PEDIDO ESTÁ EN CAMINO', [], 0);
        return d(
            p(
                $text
                ,

                "timeline__item__content__description strong"

            ),
            "timeline__item__content");

    }


    function seccion_domicilio($domicilio, $id_recibo, $tipo_entrega, $es_vendedor)
    {

        $url = path_enid(
            'pedido_seguimiento', _text($id_recibo, '&domicilio=1&asignacion=1')
        );

        $tipos_entrega = [
            "INDICA TU PUNTO DE ENTREGA",
            "INDICA EL DOMICILIO DE ENVÍO",
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

    function create_seccion_comentarios($data)
    {

        $nota = [];
        if (es_data($data)) {

            $nota[] = _titulo("Seguimiento al cliente", 4);


            foreach ($data as $row) {

                $registro = date_format(date_create($row["fecha_registro"]), 'd M Y H:i:s');
                $seccion_registro = text_icon("fa fa-clock-o", $registro);
                $nota[] = flex($seccion_registro, strip_tags($row['comentario']), 'mt-3 mb-3', _4p, 'col-sm-8 text-right');

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

    function create_seccion_tipificaciones($data)
    {

        $tipificacon = [];
        $r = [];
        foreach ($data as $row) {


            $tipificacon[] = flex(

                text_icon("fa fa-clock-o", $row["fecha_registro"])
                ,
                $row["nombre_tipificacion"]
                ,
                "row mt-4 d-flex align-items-center  border-bottom",
                "col-lg-4 p-0", "col-lg-8 p-0 text-right"
            );


        }

        if (es_data($data)) {

            $r[] = d(h("MOVIMIENTOS", 4, "strong row mt-5 mb-5"),
                " top_30 bottom_30 padding_10 row");
            $r[] = append($tipificacon);

        }

        return append($r);
    }

    function crea_seccion_productos($recibo)
    {

        $recibo = $recibo[0];
        $response = [];
        for ($a = 0; $a < $recibo["num_ciclos_contratados"]; $a++) {


            $imagen =
                img(
                    [
                        "src" => $recibo["url_img_servicio"],
                        "class" => "img_servicio mah_200",

                    ]
                );
            $imagen = a_enid(
                $imagen,
                [
                    "href" => path_enid("producto", $recibo["id_servicio"]),
                    "target" => "_black",
                ]
            );


            $contenido = flex_md($imagen, money($recibo["precio"]), _text_(_between_md, 'mt-5 border-bottom'), '', 'strong h4 mx-auto');
            $response[] = d_row($contenido);


        }

        return append($response);

    }

    function create_fecha_contra_entrega($recibo, $domicilio, $es_venta_cancelada)
    {

        $fecha = "";

        if (es_data(prm_def($domicilio, "domicilio")) > 0 && es_data($recibo)) {

            $recibo = $recibo[0];
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
                _titulo('ups! esta orden no cuenta 
                con domicilio de entrega registrado', 4);
            $fecha = d($titulo, 'row bg-warning p-1');
        }

        return $fecha;

    }

    function fecha_espera_servicio($recibo, $servicio)
    {


        $fecha = "";
        if (es_data($recibo) && es_data($servicio) && pr($servicio,
                "flag_servicio")) {

            $recibo = $recibo[0];
            $t[] = d("FECHA EN QUE SE ESPERA REALIZAR EL SERVICIO ",
                "strong underline");
            $t[] = d(date_format(date_create($recibo["fecha_contra_entrega"]),
                'd M Y H:i:s'), "ml-auto");
            $text = d(append($t),
                " d-flex p-3 row bg-light border border-primary border-top-0 border-right-0 border-left-0 strong mb-5");
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

                case 0  :
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

    function create_seccion_saldos($recibo)
    {

        $recibo = $recibo[0];
        $pagado = $recibo["saldo_cubierto"];

        $costo_envio_cliente = $recibo["costo_envio_cliente"];

        $total = ($recibo["precio"] * $recibo["num_ciclos_contratados"]) + $costo_envio_cliente;
        $direccion = 'flex-column text-center col-sm-6';
        $strong = _text_('mb-4', _strong);


        $text[] = flex("envio", money($costo_envio_cliente), $direccion, $strong);

        $text[] = flex("total", money($total), $direccion, $strong);

        $ext = ($pagado < 1) ? "sin_pago" : "pago_realizado";
        $flex = _text_(
            'justify-content-center col-sm-12 flex-column text-center mt-5', $ext, _strong);


        $text[] = flex("abonado", money($pagado), $flex);

        return bloque($text);

    }

    function bloque($text, $ext = '')
    {
        return d($text, _text_("border border-secondary p-3 mt-3 mb-3 row borde_accion solid_bottom_2", $ext));
    }


    function create_seccion_tipo_entrega($recibo, $tipos_entregas)
    {

        $r = [];
        if (es_data($recibo)):
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
        if (es_data($recibo)):
            $recibo = $recibo[0];
            $t[] = d(icon("fa fa-check-circle") . "PEDIDO ENTREGADO", "strong");
            $t[] = d($recibo["fecha_entrega"]);
            $text = ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9) ? append($t) : "";

            if ($recibo["saldo_cubierto"] > 0 && $recibo["status"] == 9):
                $response = d($text,
                    "letter-spacing-5 top_30 border padding_10 botttom_20 contenedor_entregado mb-5 row");
            endif;

        endif;

        return $response;
    }

    function crea_estado_venta($status_ventas, $recibo)
    {

        $response = "";
        if (es_data($recibo)):

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
            $r[] = d(format_link_nombre($data, $row));
            $r[] = d(phoneFormat($telefonono), 'mt-3');


            if ($row["sexo"] != 2) {
                $r[] = d($opt[$row["sexo"]]);
            }


            $r[] = d(icon("fa-pencil configurara_informacion_cliente black"),
                "dropdown pull-right mt-3");

        }

        $icon = icon("fa fa-cart-plus agenda_compra",
            [
                "id" => $id_usuario
            ]
        );
        $cliente = flex(
            _titulo("cliente", 2),
            $icon,
            _text_(_between, 'col-lg-12 p-0 mb-4'), _strong
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
        $text_compras = flex($ext, $num, _between, 'fp9', $total);
        $starts = ($num > 0) ? label("★★★★★", 'estrella') : "";

        $ext = " ORDENES DE COMPRA QUE HA REALIZADO ESTE USUARIO ";
        $link = path_enid('busqueda_pedidos_usuarios', $ids_compras);
        $solicitudes_pasadas_usuario = a_enid($solicitudes_pasadas_usuario,
            [
                'href' => $link, 'class' => 'white'
            ]
        );
        $text = flex($ext, $solicitudes_pasadas_usuario, $base, 'fp9', $total);

        $response[] = d(_titulo('calificación', 2));

        $response[] = $text_compras;
        $response[] = $starts;
        $response[] = $text;
        return bloque(append($response));

    }

    function tiene_domilio($domicilio, $numero = 0)
    {

        $domicilio_compra = "";
        $tiene_entrega = 0;

        if (es_data($domicilio["domicilio"])) {

            $tiene_entrega++;

        } else {

            $str = text_icon(_close_icon, del("SIN DOMICILIO", _strong));
            $domicilio_compra = bloque($str);
        }

        return ($numero == 0) ? $domicilio_compra : $tiene_entrega;
    }

    function create_seccion_domicilio($domicilio, $recibo, $data)
    {
        $response = "";

        if (es_data($domicilio)) {

            $d_domicilio = $domicilio["domicilio"];
            $response = ($domicilio["tipo_entrega"] != 1) ? create_domicilio_entrega($d_domicilio, $recibo, $data) : create_punto_entrega($d_domicilio, $recibo);


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
                'far fa-envelope', $text
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
        return d(a_enid("AGREGAR NOTA",
            ["class" => "agregar_comentario", "onClick" => "agregar_nota();"]));
    }

    function link_costo($response, $data, $id_recibo, $recibo, $es_vendedor)
    {

        if (!$es_vendedor && es_data($recibo)) {

            $saldo = pr($recibo, "saldo_cubierto");
            $ext = _text("/?costos_operacion=", $id_recibo, "&saldado=", $saldo);
            $url = path_enid("pedidos", $ext);
            $link = a_enid("COSTOS DE OPERACIÓN",
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
                    a_enid("LISTA NEGRA",
                        [

                            "onclick" => "confirma_envio_lista_negra({$id_usuario})",
                        ]
                    )
                );
            } else {
                $response[] = d(
                    a_enid("SACAR DE LA LISTA NEGRA",
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
            a_enid("STATUS DE LA COMPRA",
                [

                    'class' => 'editar_estado_compra'
                ]
            )
        );
    }

    function intento_reventa($x, $recibo, $data)
    {


        $id_usuario = pr($recibo, "id_usuario");
        $id_recibo = pr($recibo, "id_proyecto_persona_forma_pago");
        $es_lista_negra = es_lista_negra($data);
        if (!$es_lista_negra) {

            $x[] = d(
                a_enid("REVENTA",
                    [

                        "onclick" => "confirma_intento_reventa({$id_usuario}, {$id_recibo})",
                    ]
                )
            );
        }

        return $x;

    }

    function intento_recuperacion($recibo, $data)
    {

        $id_usuario = pr($recibo, "id_usuario");
        $id_recibo = pr($recibo, "id_proyecto_persona_forma_pago");
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
                a_enid(_d("RECUPERACIÓN", $tiempo_trasncurrido),
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


    function link_cambio_fecha($recibo)
    {

        if (es_data($recibo)) {

            $recibo = $recibo[0];
            $id_recibo = $recibo["id_proyecto_persona_forma_pago"];
            $status = $recibo["status"];
            $saldo_cubierto_envio = $recibo["saldo_cubierto_envio"];
            $monto_a_pagar = $recibo["monto_a_pagar"];
            $se_cancela = $recibo["se_cancela"];
            $fecha_entrega = $recibo["fecha_entrega"];

            return d(
                a_enid("MODIFICAR LA FECHA DE ENTREGA",
                    [
                        "class" => "editar_horario_entrega",
                        "id" => $id_recibo,
                        "onclick" => "confirma_cambio_horario({$id_recibo} , {$status } , {$saldo_cubierto_envio} , {$monto_a_pagar} , {$se_cancela} , '" . $fecha_entrega . "' )",
                    ])
            );

        }
    }

    function link_recordatorio($recibo, $data, $response)
    {

        $es_lista_negra = es_lista_negra($data);
        if (!$es_lista_negra) {

            $id_recibo = pr($recibo, "id_proyecto_persona_forma_pago");
            $path = path_enid("pedidos", "/?recibo=" . $id_recibo . "&recordatorio=1");
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

    function text_punto_encuentro($domicilio, $recibo)
    {
        $response = "";
        $fecha_contra_entrega = pr($recibo, 'fecha_contra_entrega');
        foreach ($domicilio as $row) {

            $id = $row["id_tipo_punto_encuentro"];
            $lugar_entrega = strong($row["lugar_entrega"]);
            $tipo = $row["tipo"];
            $nombre_linea = $row["nombre_linea"];


            switch ($id) {

                //1 | LÍNEA DEL METRO
                case 1:
                    $response =
                        _text_("ESTACIÓN DEL METRO ", $lugar_entrega, " LINEA ",
                            $row["numero"], $nombre_linea, " COLOR ", $row["color"],
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

    function create_domicilio_entrega($domicilio, $recibo, $data)
    {

        $contra_entrega_domicilio = pr($recibo, 'contra_entrega_domicilio');
        $fecha_contra_entrega = format_fecha(pr($recibo, 'fecha_contra_entrega'), 1);
        $direccion = [];
        $es_ubicacion = pr($recibo, 'ubicacion');
        foreach ($domicilio as $row) {

            if ($es_ubicacion < 1) {

                $direccion[] =
                    _text_($row["calle"], "NÚMERO", $row["numero_exterior"],
                        "NÚMERO INTERIOR", $row["numero_interior"], "COLONIA",
                        $row["asentamiento"], "DELEGACIÓN/MUNICIPIO", $row["municipio"],
                        "ESTADO ", $row["estado"], "CÓDIGO POSTAL ", $row["cp"]
                    );
            } else {
                $direccion[] = $row["ubicacion"];
            }


        }

        if ($contra_entrega_domicilio > 0) {

            $direccion[] = _titulo('pago contra entrega a domicilio, se entregará el', 2);
            $direccion[] = _titulo($fecha_contra_entrega, 2);
        }


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
            $action = "../../q/index.php/api/usuario/index/format/json/";
            $attr = [
                "METHOD" => "PUT",
                "id" => "form_set_usuario",
                "class" => "border form_set_usuario padding_10 row",
            ];
            $form[] = form_open($action, $attr);
            $form[] = d(_titulo('cliente', 2));


            $form[] = input_frm('col-sm-12 mt-5 p-0', 'NOMBRE',
                [
                    "name" => "nombre",
                    "value" => $usuario["nombre"],
                    "type" => "text",
                    "required" => "true",
                    "class" => 'nombre_cliente',
                    "id" => 'nombre_cliente',
                    "uppercase" => True
                ]
            );


            $form[] = input_frm('col-sm-12 mt-5 p-0', 'APELLIDO PATERNO:',
                ([
                    "name" => "apellido_paterno",
                    "class" => "apellido_paterno",
                    "id" => "apellido_paterno",
                    "value" => $usuario["apellido_paterno"],
                    "type" => "text",
                    "uppercase" => True
                ])
            );


            $form[] = input_frm('col-sm-12 mt-5 p-0', 'APELLIDO MATERNO:',
                ([
                    "name" => "apellido_materno",
                    'class' => 'apellido_materno',
                    'id' => 'apellido_materno',
                    "value" => $usuario["apellido_materno"],
                    "type" => "text",
                    "uppercase" => True
                ])
            );


            $form[] = input_frm('col-sm-12 mt-5 p-0', 'CORREO ELECTRÓNICO:',
                ([
                    'name' => 'email',
                    'value' => $usuario["email"],
                    "required" => "true",
                    "class" => "email email",
                    "id" => "email_cliente",
                    "onkeypress" => "minusculas(this);",
                ])
            );


            $form[] = input_frm('col-sm-12 mt-5 p-0', 'TELÉFONO:',
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
            $form[] = create_select($opt, "sexo", "sexo mt-5 form-control", "sexo", "text", "val", 0,
                $usuario["sexo"]);
            $form[] = btn("GUARDAR", ["class" => "top_30 bottom_50"]);
            $form[] = form_close(place("place_form_set_usuario"));
            return d($form, ["id" => "contenedor_form_usuario"]);


        }


    }

    function es_orden_pagada_entregada($data)
    {
        $response = false;

        if (es_data($data['recibo'])) {
            $recibo = $data['recibo'];
            $saldo_cubierto = pr($recibo, 'saldo_cubierto');
            $response = ($saldo_cubierto > 0 && es_orden_entregada($recibo, $data));
        }
        return $response;
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
