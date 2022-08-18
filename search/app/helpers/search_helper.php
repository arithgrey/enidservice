<?php

use function Sodium\add;

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_search($data)
    {

        $paginacion = $data["paginacion"];
        $is_mobile = $data["is_mobile"];
        $categorias_destacadas = $data["categorias_destacadas"];

        $response[] = d(get_format_menu_categorias_destacadas($is_mobile, $categorias_destacadas), 13);
        $lista_productos[] = d(get_format_filtros_paginacion($data["filtros"], $data["order"], $paginacion, $is_mobile), 13);
        $lista_productos[] = d($data["lista_productos"], 13);
        $lista_productos[] = d($paginacion, 13);
        $response[] = d(d($lista_productos, 10, 1), 13);        
        
        $seccion_compras_conjunto = d("","promociones_sugeridas col-md-5 col-xs-12 p-0");
        $seccion_compras_conjunto_top = d("","promociones_sugeridas_top col-md-5 col-xs-12 p-0");
        $seccion_categorias = crea_sub_menu_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas));
        
        $adicionales[] = $seccion_compras_conjunto;
        $adicionales[] = d("", 2);
        $adicionales[] = $seccion_compras_conjunto_top;
        $response[] = d(d(d($adicionales,13),10,1), "row mt-5");    
        $response[] = d($seccion_categorias,10,1);    
        

        return d($response, 12);
    }

    function sin_resultados($param)
    {

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
        $response[] = d(botones_ver_mas(), 'mt-5 col-sm-12 d-none otros');
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
    function get_format_filtros_paginacion($filtros, $order, $paginacion, $is_mobile)
    {

        $paginacion = d($paginacion, 'd-none d-md-block');
        $filtro = filtro($filtros, $order);
        $extra = ($is_mobile) ? 'w-100' : '';
        return ($is_mobile > 0) ? d($filtro, 'col-lg-12 mt-4 mb-4 p-0') :
            flex($filtro, $paginacion, 'd-md-flex justify-content-between col-sm-12 p-0', $extra);
    }


    function filtro($filtros, $order)
    {

        $r[] = '<select class="form-control order border border-dark filtro_orden_categorias " name="order" id="order">';
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

        return append($r);
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
            $r[]=  d($response, 'contenedor_anuncios_home d-flex w-100 text-center mb-5 p-3');
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
        $response = [];
        foreach ($param as $row) {

            $response[] = a_enid(
                $row["nombre_clasificacion"],
                [
                    "href" => _text("?q=&q2=", $row["primer_nivel"]),
                    "class" => 'text-uppercase white fp9 mt-1 mt-md-0 decoration_underline'
                ]

            );
        }

        $t[] = d(
            img(
                [
                    "src" => "https://media.giphy.com/media/2hAjRJoLzYLqoRHvq2/giphy.gif",
                    "class" => "card-img"
                ]
            ),
            'col-md-6 col-sm-12 ' . $extra
        );

        $s[] = d("Más categorías", 'text-uppercase white strong f14 mt-5');
        $s[] = p(d($response, 'mt-4 bg_blue p-3'));
        $sec[] = d($s, 'col-md-6 col-xs-12 mt-3 mt-md-0');
        $r[] = append($t);
        $r[] = append($sec);

        return d(d($r, ' mt-5 d-md-flex  align-items-center categorias_extras ' . $extra), 13);
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

