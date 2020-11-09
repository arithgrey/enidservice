<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('invierte_date_time')) {
    function render($data)
    {

        $recibos = $data["recibos"];
        $recibos_pagos = $data["recibos_pagos"];
        $servicios_sugeridos = $data["servicios_sugeridos"];
        $cliente = $data["cliente"];

        $total_servicios_sugeridos = count($servicios_sugeridos);
        $totales = totales($recibos);

        $nombre_cliente = _titulo(format_nombre($cliente));
        $linea[] = d($nombre_cliente, 13);

        $telefono_cliente = _titulo(format_phone(pr($cliente, 'tel_contacto')), 5);
        $linea[] = d($telefono_cliente, 13);

        $texto = flex(count($recibos_pagos), 'Compras efectivas', '', 'mr-2 strong black');
        $linea[] = d($texto, 13);

        $texto = flex(count($servicios_sugeridos), 'Servicios sugeridos', '', 'mr-2 strong black');
        $linea[] = d($texto, 13);


        $formato_sintesis = formato_ordenes_compra($totales);
        $ids_procesos_compra = $totales["ids_servicios_procesando"];

        $linea[] = d($formato_sintesis["html"], 'd-flex row border-bottom mb-5');
        $texto = _titulo(
            _text_(
                'con base en las compras realizadas por este cliente hay',
                $total_servicios_sugeridos,
                'Artículos que podrían interezarle'
            )
            , 5);

        $linea[] = d(flex(icon(_text_(_estrellas_icon, 'fa-2x black')), $texto, _between_start, 'mr-2'), 'row mt-5 mb-5');
        $linea[] = formato_productos_relacionados($servicios_sugeridos, $recibos);

        $formato_vendidos = formato_productos_vendidos($recibos_pagos);

        $texto = _titulo(_text_($formato_vendidos["total"], 'articulos que el cliente ha comprado'), 5);
        $linea[] = d(flex(icon(_entregas_icon), $texto, _between_start, 'mr-2'), 'row mt-5');

        $texto = _titulo(_text_($formato_vendidos["total_distintos"], ' distintos'), 5);
        $linea[] = d(flex(icon('fa fa-circle'), $texto, _between_start, 'mr-2'), 'row mb-5');

        $linea[] = $formato_vendidos["html"];
        $linea[] = hiddens(['class' => 'id_usuario_cliente', 'value' => pr($cliente, 'id_usuario')]);
        $linea[] = hiddens(['class' => 'id_servicio_relacion', 'value' => 0]);


        $en_proceso_menos_sugeridos = en_proceso_menos_sugeridos($servicios_sugeridos, array_unique($ids_procesos_compra));
        $total_proceso_menos_sugeridos = $en_proceso_menos_sugeridos["total"];
        if ($total_proceso_menos_sugeridos > 0) {

            $texto =
                _titulo(
                    _text_('COMPRAS EN PROCESO', $total_proceso_menos_sugeridos),
                    5);
            $linea[] = d($texto, 'row mt-5 mb-5');

            $linea[] = d($en_proceso_menos_sugeridos["html"]);

        }

        $linea[] = gb_modal(opciones_reventa(), 'modal_opciones_reventa');

        return d($linea, 8, 1);

    }

    function formato_productos_relacionados($servicios, $recibos)
    {

        $response = [];
        $ids = [];
        $numero_servicio = 0;
        foreach ($servicios as $row) {

            $id_servicio_relacion = $row["id_servicio_relacion"];
            $imagen = img(
                [
                    "src" => $row["url_img_servicio"],
                    "class" => "mx-auto my-auto d-block mh_270 mh_250 mh_sm_310 mh-auto mt-5"
                ]
            );

            $imagen = d($imagen,
                [
                    'class' => 'servicio_sugerencia cursor_pointer',
                    'id' => $id_servicio_relacion
                ]
            );


            $fue_vendido = fue_vendido($id_servicio_relacion, $recibos);
            $es_proceso = es_proceso($id_servicio_relacion, $recibos);

            $texto = ($fue_vendido) ? d(_text_($fue_vendido, 'Comprado'), 'underline  text-center') : '';
            $texto .= ($es_proceso) ? d(_text_($es_proceso, 'En proceso ...'), 'text-center') : '';
            $item = flex($imagen, $texto, 'flex-column', '', 'text-uppercase black strong');

            $input = input(
                [
                    "type" => "checkbox",
                    "class" => "selector_sugerido",
                    "id" => $id_servicio_relacion
                ]
            );

            $selector = flex($item, $input, _text_('flex-column', _between),'mb-5');
            $response[] = d($selector, 2);
            $numero_servicio++;
            $ids[] = a_enid(
                _text("servicio", $numero_servicio),
                [
                    'href' => path_enid("producto", $id_servicio_relacion),
                ]
            );

        }

        if ($numero_servicio > 0) {

            $response[] = d(
                format_link(
                "Marcar como sugeridos al cliente",
                [
                    "class" => "marcar_sugerencia",

                ]
            ),"col-md-2 d-none marcar_sugerencia_seccion"
            );
        }


        $contenido[] = d($response, 'row mt-5');
        $contenido[] = d($ids,'mt-5');
        return append($contenido);


    }

    function formato_productos_vendidos($recibos)
    {


        $response = [];
        $ids = [];

        $ids_servicios = array_column($recibos, 'id_servicio');
        $servicios_comprados = array_count_values($ids_servicios);
        $a = 0;

        foreach ($recibos as $row) {

            $id_recibo = $row["recibo"];
            $id_servicio = $row["id_servicio"];
            if (!in_array($id_servicio, $ids)) {

                $imagen = img(
                    [
                        "src" => $row["url_img_servicio"],
                        "class" => "mx-auto my-auto d-block mh_270 mh_250 mh_sm_310 mh-auto mt-5"
                    ]
                );

                $imagen = a_enid($imagen,
                    [
                        "href" => path_enid("pedidos_recibo", $id_recibo),
                        "target" => "_blank"
                    ]
                );

                $numero_compras = 0;

                foreach ($servicios_comprados as $clave => $valor) {
                    if ($clave == $id_servicio) {
                        $numero_compras = $valor;
                        break;
                    }
                }

                $elemento = flex(
                    $numero_compras,
                    $imagen,
                    _text_('flex-column', _between),
                    'bg_black white p-2 mt-3 mb-3'
                );
                $response[] = d($elemento, 2);

                $ids[] = $id_servicio;
                $a++;
            }

        }

        return
            [
                "html" => d($response, 'row mt-5'),
                "total" => count($recibos),
                "total_distintos" => $a
            ];
    }


    function fue_vendido($id_servicio_relacion, $recibos)
    {

        $fue_vendido = 0;
        foreach ($recibos as $row) {

            $id_servicio = $row["id_servicio"];
            $saldo_cubierto = $row["saldo_cubierto"];
            if ($id_servicio_relacion === $id_servicio
                && !es_orden_cancelada($row)
                && $saldo_cubierto > 0) {
                $fue_vendido++;
            }

        }
        return $fue_vendido;

    }

    function es_proceso($id_servicio_relacion, $recibos)
    {

        $es_proceso = 0;
        foreach ($recibos as $row) {

            $id_servicio = $row["id_servicio"];
            $saldo_cubierto = $row["saldo_cubierto"];
            if ($id_servicio_relacion === $id_servicio
                && !es_orden_cancelada($row)
                && $saldo_cubierto < 1) {
                $es_proceso++;
            }

        }
        return $es_proceso;

    }


    function formato_ordenes_compra($totales)
    {

        $base = 'strong  text-uppercase black mt-5 mb-5 text-center';
        $base_numero = 'text-center bg_black white w-50 mx-auto';

        $ids = $totales["ids"];
        $path_total = path_enid('busqueda_pedidos_usuarios', implode(",", $ids));
        $link_total = a_enid(count($ids), ["class" => "white", "href" => $path_total]);


        $ids_cancelaciones = $totales["ids_cancelaciones"];
        $path_total = path_enid('busqueda_pedidos_usuarios', implode(",", $ids_cancelaciones));
        $link_cancelaciones = a_enid(count($ids_cancelaciones), ["class" => "white", "href" => $path_total]);


        $ids_pagos = $totales["ids_pagos"];
        $path_total = path_enid('busqueda_pedidos_usuarios', implode(",", $ids_pagos));
        $link_pagos = a_enid(count($ids_pagos), ["class" => "white", "href" => $path_total]);


        $ids_proceso = $totales["ids_proceso"];
        $path_total = path_enid('busqueda_pedidos_usuarios', implode(",", $totales["ids_proceso"]));
        $link_proceso = a_enid(count($ids_proceso), ["class" => "white", "href" => $path_total]);


        $items[] = flex('Ordenes de compra', $link_total, 'flex-column mr-5 mb-5 ', $base, $base_numero);
        $items[] = flex('Cancelaciones', $link_cancelaciones, 'flex-column mr-5 mb-5', $base, $base_numero);
        $items[] = flex('Compras efectivas', $link_pagos, 'flex-column mr-5 mb-5', $base, $base_numero);
        $items[] = flex('Ordenes en proceso', $link_proceso, 'flex-column mr-5 mb-5', $base, $base_numero);

        return [
            "html" => append($items),
            "ids_proceso" => $ids_proceso,
        ];

    }

    function en_proceso_menos_sugeridos($servicios_sugeridos, $ids_proceso)
    {

        $total = 0;
        $ids_sugeridos = array_unique(array_column($servicios_sugeridos, 'id_servicio_relacion'));
        $procesando = array_unique(array_diff($ids_proceso, $ids_sugeridos));
        $response = [];
        foreach ($procesando as $row) {

            $imagen = img(
                [
                    "src" => link_imagen_servicio($row),
                    "class" => "mx-auto my-auto d-block mh_270 mh_250 mh_sm_310 mh-auto mt-5"
                ]
            );

            $imagen = a_enid($imagen, get_url_servicio($row));
            $texto = d('Procesando ...', 'underline  text-center');
            $item = flex($imagen, $texto, 'flex-column', '', 'text-uppercase black strong');
            $response[] = d($item);
            $total++;
        }

        return
            [
                'html' => append($response),
                'total' => $total
            ];

    }

    function totales($recibos)
    {

        $total_pagos = 0;
        $total_cancelaciones = 0;
        $total_proceso = 0;
        $total = 0;
        $ids_cancelaciones = [];
        $ids_pagos = [];
        $ids_proceso = [];
        $ids = [];
        $ids_servicio = [];

        foreach ($recibos as $row) {

            $saldo_cubierto = $row["saldo_cubierto"];
            $id = $row["recibo"];
            $id_servicio = $row["id_servicio"];

            $ids[] = $id;
            if (es_orden_cancelada($row)) {

                $total_cancelaciones++;
                $ids_cancelaciones[] = $id;

            } else {

                if ($saldo_cubierto > 0) {
                    $total_pagos++;
                    $ids_pagos[] = $id;

                } else {

                    $total_proceso++;
                    $ids_proceso[] = $id;
                    $ids_servicio[] = $id_servicio;
                }
            }
            $total++;
        }

        return [
            "ids_pagos" => $ids_pagos,
            "ids_proceso" => $ids_proceso,
            "ids_cancelaciones" => $ids_cancelaciones,
            "ids" => $ids,
            "ids_servicios_procesando" => $ids_servicio
        ];

    }

    function opciones_reventa()
    {

        $response[] = format_link("Marcar intento de reventa",
            [
                'class' => 'servicio_intento_reventa',
            ]
        );
        return append($response);
    }


}
