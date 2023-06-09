<?php

use BaconQrCode\Renderer\Path\Path;

use function Sodium\add;

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_search($data)
    {

        $paginacion = $data["paginacion"];
        $response[] = $data["busqueda_paginas"];
        $response[] = baner_compra_tipo_producto($data);
        $lista_productos[] = d($data["lista_productos"], 13);
        $lista_productos[] = d($paginacion, 13);
        $response[] = d(d($lista_productos, 10, 1), 13);

        if (prm_def($data, "es_sorteo") > 1) {

            $textos_rifas_pasadas = _text_(
                crea_estrellas(3),
                "Resultados 
                    de nustros sorteos
                    pasados",
                crea_estrellas(3)
            );
            $response[] = d(a_enid(
                $textos_rifas_pasadas,
                [
                    "class" => 'col-sm-10 col-sm-offset-1 text-center display-7 
                borde_accion resultados_sorteo p-2 pb-2 pt-2 bg_black white borde_green cursor_pointer',
                    "href" => path_enid("resultados_rifas"),

                ]
            ), 13);
        }

        $seccion_compras_conjunto = d("", "promociones_sugeridas col-md-5 col-xs-12 p-0");
        $seccion_compras_conjunto_top = d("", "promociones_sugeridas_top col-md-5 col-xs-12 p-0");

        $adicionales[] = $seccion_compras_conjunto_top;
        $adicionales[] = d("", 2);
        $adicionales[] = $seccion_compras_conjunto;



        $response[] = d(d(d($adicionales, 13), 10, 1), "row mt-5 ssss");
        $response[] = d(d(d("", "place_recien_agregados"), " col-sm-10 col-sm-offset-1 p-0"), 13);
        
        return d($response, 12);
    }    
    function baner_compra_tipo_producto($data)
    {

        $q = prm_def($data, "q", "");

        $mas_vendidos = $data["mas_vendidos"];

        $response = [];
        foreach ($mas_vendidos as $row) {
            $path = $row["path"];

            if ($path === $q) {
                $response_ = [];
                $titulo = $row["titulo"];
                $sub_titulo = $row["sub_titulo"];
                $link_video = $row["link_video"];

                if (str_len($titulo, 3)) {
                    $response_[] = d(
                        $titulo,
                        'display-5 strong text-uppercase black mt-5 col-sm-12 p-0'
                    );
                }

                if (str_len($sub_titulo, 3)) {

                    $response_[] = d($sub_titulo, 'black col-sm-12 p-0 mt-3 mb-3');
                }

                if (str_len($link_video, 3)) {
                    $response_[] =  d(d(
                        _text_('<iframe width="560" 
                            height="315" 
                            src="', $link_video, '" 
                            title="YouTube video player" 
                            frameborder="0" 
                            allow="accelerometer; 
                            autoplay; clipboard-write; 
                            encrypted-media; gyroscope; 
                            picture-in-picture; web-share" allowfullscreen></iframe>'),
                        'mt-4 row'
                    ), 12);
                }

                $extra = is_mobile() ? 12 : '';
                $response[] = d($response_, $extra);
            }
        }
       
        return d(d(d($response, 13), ' col-sm-10 col-sm-offset-1'), 13);
    }
    function oferta_delivery()
    {

        $anuncio[] = d('¿Necesitas enviar un paqueten dentro de cdmx?', "black strong f12");
        $anuncio[] = d('Nosotros lo llevamos por ti!');
        $anuncio[] = d(format_link(
            "Cotiza ahora!",
            [
                "href" => path_enid("whatsapp_viajes", 0, 1),
                "class" => "mt-3"
            ],
            2
        ));

        return d(
            d($anuncio),
            [
                'class' => 'black borde_black mt-5 p-3',
            ]
        );
    }
    function sin_resultados($data,$param)
    {
        $textos[] = $data["busqueda_paginas"];
        
        $textos[] = d(h("LO SENTIMOS, NO HAY NINGÚN RESULTADO PARA ", 4, "strong letter-spacing-15 fz_30"));
        $textos[] = d(h('"' . prm_def($param, "q", "") . '".', 4, "strong letter-spacing-15 fz_30"));
        $textos[] = d(d("¡No te desanimes! Revisa el texto o intenta buscar algo menos específico. ", "mt-5 fp9 mb-5"));

        $response[] = d($textos, 'col-sm-12 mt-5');
        $formulario[] = "<form action='../search' >";
        $formulario[] = d(
            add_text(
                icon('fa fa-search icon'),
                input([
                    "class" => "input-field mh_50 border border-dark  solid_bottom_hover_3  ",
                    "placeholder" => "buscar",
                    "name" => "q"
                ])
            ),
            "input-icons"
        );
        $formulario[] = form_close();


        $response[] = d($formulario, "col-lg-6");


        $otros_articulos_titulo = _titulo('Aquí te dejamos más cosas que te podrían interesar!', 2);
        $response[] = d($otros_articulos_titulo, 'top_100 d-none sugerencias_titulo col-sm-12 ');

        $response[] = d(
            place("place_tambien_podria_interezar"),
            "col-lg-12"

        );

        $response[] = d(hr(), 'mt-5 col-sm-12 d-none otros');
        //$response[] = d(botones_ver_mas(), 'mt-5 col-sm-12 d-none otros');
        $response[] = d(hr(), 'mt-5 col-sm-12 d-none otros');

        return d(d($response, 13), 10, 1);
    }
    function botones_ver_mas()
    {

        $link_productos =  format_link("Ver más promociones", [
            "href" => path_enid("search", _text("/?q2=0&q=&order=", rand(0, 8), '&page=', rand(0, 5))),
            "class" => "border",
            "onclick" => "log_operaciones_externas(39)"
        ]);

        $link_facebook =  format_link("Facebook", [
            "href" => path_enid("facebook", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_',
            "onclick" => "log_operaciones_externas(40)"
        ], 0);

        $link_instagram =  format_link("Instagram", [
            "href" => path_enid("fotos_clientes_instagram", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_',
            "onclick" => "log_operaciones_externas(41)"
        ], 0);


        $response[] = d($link_productos, 4, 1);
        $response[] = d($link_facebook, 4, 1);
        $response[] = d($link_instagram, 4, 1);

        return d($response, 13);
    }
    function get_format_filtros_paginacion($data, $filtros, $order, $paginacion, $is_mobile)
    {

        $es_sorteo =  prm_def($data, "es_sorteo");
        $paginacion = d($paginacion, 'd-none d-md-block');

        //$filtro = filtro($filtros, $order);
        //$extra = ($is_mobile) ? 'w-100' : '';
        /*
        $response[] = ($is_mobile > 0) ? d($filtro, 'col-lg-12 mt-4 mb-4 p-0') :
            flex($filtro, $paginacion, 'd-md-flex justify-content-between col-sm-12 p-0', $extra);
            */

        $response[] = d(textos_transmision_sorteo($es_sorteo), 'col-sm-12');
        return append($response);
    }
    function textos_transmision_sorteo($es_sorteo)
    {

        $path = path_enid("enid_service_facebook", 0, 1);
        $link_facebook = a_enid(
            "Facebook",
            [
                "class" => "text-center borde_accion p-2 pb-2 pt-2 bg_black white borde_green cursor_pointer",
                "href" => $path
            ],
            0
        );


        $path = path_enid("youtube_vivo", 0, 1);
        $link_youtube = a_enid(
            "Youtube",
            [
                "class" => "text-center borde_accion p-2 pb-2 pt-2 bg_black white borde_green cursor_pointer",
                "href" => $path
            ],
            0
        );

        $response = "";
        if ($es_sorteo > 1) {

            $response = d([
                d("Las rifas son transmitidas en"),
                d($link_facebook),
                d(" y en "),
                d($link_youtube)
            ], 'row mt-4 black d-flex');
        }
        return $response;
    }
    function filtro($filtros, $order)
    {

        $r[] = '<select class="form-control order filtro_orden_categorias " name="order" id="order">';
        $a = 0;
        foreach ($filtros as $row) :
            $str = strtoupper($row);
            if ($a == $order) :

                $r[] = '<option value="' . $a . '" selected>';
                $r[] = $str;
                $r[] = '</option>';
            else :
                $r[] = '<option value="' . $a . '">';
                $r[] = $str;
                $r[] = '</option>';

            endif;
            $a++;
        endforeach;
        $r[] = '</select>';

        $response =  append($r);
        if (is_mobile()) {
            $response = d(
                flex("Ordenar por", $response, _between, 'display-7 black ml-2 color_orden'),
                " mt-5"
            );
        }
        return $response;
    }

    function get_format_menu_categorias_destacadas($is_mobile, $categorias_destacadas)
    {

        $r = [];

        if ($is_mobile < 1) {


            foreach (crea_menu_principal_web($categorias_destacadas) as $row) :

                $nombre = explode(' ', $row["nombre_clasificacion"])[0];
                $response[] = d(a_enid(
                    $nombre,
                    [
                        "href" => "?q=&q2=" . $row['primer_nivel'],
                        "class" => "categorias_mas_vistas "
                    ],
                    0
                ), 2);
            endforeach;
            $r[] =  d($response, 'contenedor_anuncios_home d-flex w-100 text-center mb-5 p-3');
        }
        return append($r);
    }

    function get_formar_menu_sugerencias($is_mobile, $b_busqueda, $busqueda)
    {

        $response = "";
        if ($is_mobile < 1) {

            $bloque_primer_nivel = crea_seccion_de_busqueda_extra($b_busqueda["primer_nivel"], $busqueda);
            $bloque_segundo_nivel = crea_seccion_de_busqueda_extra($b_busqueda["segundo_nivel"], $busqueda);
            $bloque_tercer_nivel = crea_seccion_de_busqueda_extra($b_busqueda["tercer_nivel"], $busqueda);
            $bloque_cuarto_nivel = crea_seccion_de_busqueda_extra($b_busqueda["cuarto_nivel"], $busqueda);
            $bloque_quinto_nivel = crea_seccion_de_busqueda_extra($b_busqueda["quinto_nivel"], $busqueda);

            $r = [];
            $separador = hr(['class' => 'solid_bottom_2'], 0);
            if ($bloque_primer_nivel["num_categorias"] > 0) {
                $r[] = $bloque_primer_nivel["html"];
            }
            if ($bloque_segundo_nivel["num_categorias"] > 0) {
                $r[] = $separador;
                $r[] = $bloque_segundo_nivel["html"];
            }
            if ($bloque_tercer_nivel["num_categorias"] > 0) {
                $r[] = $separador;
                $r[] = $bloque_tercer_nivel["html"];
            }
            if ($bloque_cuarto_nivel["num_categorias"] > 0) {
                $r[] = $separador;
                $r[] = $bloque_cuarto_nivel["html"];
            }
            if ($bloque_quinto_nivel["num_categorias"] > 0) {
                $r[] = $separador;
                $r[] = $bloque_quinto_nivel["html"];
            }
            $response = d($r, "contenedor_sub_categorias");
        }
        return d(d($response, 'contenedor_menu_productos_sugeridos p-3 bg_white'), "d-none d-md-block  mt-md-5 w-100");
    }

    function crea_sub_menu_categorias_destacadas($param)
    {
        $extra = (is_mobile()) ? ' p-0 ' : '';
        $categorias = [];
        foreach ($param as $row) {

            $categorias[] = a_enid(
                $row["nombre_clasificacion"],
                [
                    "href" => _text("?q=&q2=", $row["primer_nivel"]),
                    "class" => 'text-uppercase black mt-2 mt-1 decoration_underline'
                ]

            );
        }

        $imagen = d(
            img(
                [
                    "src" => "https://media.giphy.com/media/2hAjRJoLzYLqoRHvq2/giphy.gif",
                    "class" => "card-img"
                ]
            ),
            'col-md-6 col-sm-12 ' . $extra
        );

        $textos_categorias[] = d("Más categorías", 'text-uppercase black display-6 mt-5');
        $textos_categorias[] = d($categorias, 'mt-4  p-3');
        $seccion_izquierda = d($textos_categorias);

        $bloque_categorias = flex($imagen, $seccion_izquierda, _between);

        $izq = $bloque_categorias;
        $der = "";
        return flex_md(
            $izq,
            $der,
            _between,
            ' borde_end col-xs-12 col-md-6',
            "col-xs-12 col-md-6"
        );
    }
    function adicionales()
    {

        $response[] = format_link(
            "Prueba en casa",
            [
                "class" => "white  cursor_pointer  
                frecuentes borde_amarillo p-1 prueba_en_casa ",
                "onclick" => "log_operaciones_externas(48)",
            ]
        );

        return d($response, 10, 1);
    }
    function crea_menu_principal_web($param)
    {


        $z = 0;
        $response = [];

        foreach ($param["clasificaciones"] as $row) {

            $primer_nivel = $row["primer_nivel"];
            $nombre_clasificacion = search_bi_array(
                $param["nombres_primer_nivel"],
                "id_clasificacion",
                $primer_nivel,
                "nombre_clasificacion",
                ""
            );

            $response[$z]["primer_nivel"] = $primer_nivel;
            $response[$z]["total"] = $row["total"];
            $response[$z]["nombre_clasificacion"] = $nombre_clasificacion;

            if ($z == 4) {
                break;
            }
            $z++;
        }
        return $response;
    }

    function crea_seccion_de_busqueda_extra($info, $busqueda)
    {


        $r = [];
        $categorias = [];
        $a = 0;
        foreach ($info as $row) {

            $nombre_clasificacion = $row["nombre_clasificacion"];
            if ($a < 1) {

                $categorias[] = $nombre_clasificacion;
                $a++;
            } else {

                if (!in_array($nombre_clasificacion, $categorias)) {

                    $extra_busqueda = _text("?q=", $busqueda, "&q2=", $row["id_clasificacion"]);
                    $url = path_enid("search", $extra_busqueda);
                    $r[] = a_enid(
                        $nombre_clasificacion,
                        [
                            "href" => $url,
                            "class" => 'categoria_text black'
                        ],
                        1
                    );
                    $categorias[] = $nombre_clasificacion;
                }
            }
        }

        return [
            "html" => append($r),
            "num_categorias" => count($info),
        ];
    }
}
