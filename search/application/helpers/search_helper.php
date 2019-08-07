<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_orden()
    {
        return [
            "ORDENAR POR",
            "LAS NOVEDADES PRIMERO",
            "LO MÁS VENDIDO",
            "LOS MÁS VOTADOS",
            "LOS MÁS POPULARES ",
            "PRECIO  [de mayor a menor]",
            "PRECIO  [de menor a mayor]",
            "NOMBRE DEL PRODUCTO [A-Z]",
            "NOMBRE DEL PRODUCTO [Z-A]",
            "SÓLO  SERVICIO",
            "SÓLO PRODUCTOS"
        ];

    }

    function render_search($data)
    {


        $paginacion = $data["paginacion"];
        $is_mobile = $data["is_mobile"];
        $categorias_destacadas = $data["categorias_destacadas"];
        $busqueda = $data["busqueda"];


        $x = [];
        $x[] = get_format_filtros_paginacion($data["filtros"], $data["order"], $paginacion, $is_mobile);
        $x[] = append($data["lista_productos"]);

        $r[] = val_principal_img($data);
        $r[] = d(get_format_menu_categorias_destacadas($is_mobile, $categorias_destacadas), 'contenedor_anuncios_home');


        $z = [];
        $z[] = heading("FILTRA TU BÚSQUEDA"
            .
            small($busqueda . "(" . $data["num_servicios"] . "PRODUCTOS)")
            ,
            3,
            ["class" => "text_filtro bg_black"]);
        $z[] = get_formar_menu_sugerencias($is_mobile, $data["bloque_busqueda"], $busqueda);

        $fil[] = d(d(append($z), 10, 1), 3);
        $fil[] = btw(

            d(append($x), 12)
            ,
            d($paginacion, 12)
            ,
            9
        );

        $r[] = d(append($fil), "row mt-3");


        $cat[] = d("", 2);
        $cat[] = d(btw(
            heading(
                "CATEGORIAS DESTACADAS",
                3
            )
            ,
            d(crea_sub_menu_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas)), 1)
            ,
            ""
        ), 10);

        $r[] = append($cat, ["class" => "row white top_30", "style" => "background:  #080221;"]);
        return append($r);


    }

    function sin_resultados()
    {
        $r[] = h("NO HAY PRODUCTOS QUE COINCIDAN CON TU BÚSQUEDA", 3, "info_sin_encontrar");
        $r[] = d("SUGERENCIAS", "contenedor_sugerencias sugerencias");

        $r[] = ul(
            [
                "- REVISA LA " . strong("ORTOGRAFÍA DE LA PALABRA"),
                "- UTILIZA PALABRAS" . strong("MÁS SIMPLES"),
                "- NAVEGA POR CATEGORÍAS"
            ]
        );
        $r[] = d(
            btn(
                text_icon('fa fa-chevron-right ir', "ANUNCIA ESTE PRODUCTO!")
                ,
                [],
                1,
                1,
                1, path_enid("login")
            )
            ,
            "col-lg-5 top_20", 1);

        return
            d(append($r), "border padding_20 top_20 col-lg-10 col-lg-offset-1", 1);


    }

    function sin_resultados_tienda()
    {
        $r[] = place("separador_inicial");
        $r[] = btw(

            h("AÚN NO HAS ANUNCIADO PRODUCTOS EN TU TIENDA", 1),
            btn(
                text_icon('fa fa-chevron-right ir', "ANUNCIA TU PRIMER PRODUCTO ")
                ,
                [
                    "class" => "top_30"
                ],
                1,
                1,
                1,
                "../planes_servicios/?action=nuevo"
            )
            ,
            "col-lg-6  col-lg-offset-3 text-center"
        );
        $r[] = place("separador_final");

        return append($r);

    }

    function get_format_filtros_paginacion($filtros, $order, $paginacion, $is_mobile)
    {

        $filtro = get_format_filtro($filtros, $order);

        $response = ($is_mobile > 0) ? d($filtro, 12) :

            d(
                btw(
                    d(
                        d($filtro, "pull-left"), 6),
                    d(
                        d($paginacion, "pull-right"), 6),
                    "row d-flex align-items-center justify-content-between"
                ), 12);

        return $response;

    }

    function val_principal_img($data)
    {

        return (prm_def($data,  "q") === "") ? img(["src" => "../img_tema/portafolio/llamada_gratis_2.png"]) : "";

    }

    function get_format_filtro($filtros, $order)
    {

        $r[] = '<select class="form-control order" name="order" id="order">';
        $a = 0;
        foreach ($filtros as $row):
            if ($a == $order):

                $r[] = '<option value="' . $a . '" selected>';
                $r[] = $row;
                $r[] = '</option>';
            else:
                $r[] = '<option value="' . $a . '" selected>';
                $r[] = $row;
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

            foreach (crea_menu_principal_web($categorias_destacadas) as $row):

                $r[] =
                    a_enid(
                        mayus($row["nombre_clasificacion"]),
                        [
                            "href" => "?q=&q2=" . $row['primer_nivel'],
                            "class" => 'categorias_mas_vistas'
                        ]
                    );
            endforeach;

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
            if ($bloque_primer_nivel["num_categorias"] > 0) {
                $r[] = $bloque_primer_nivel["html"];
            }
            if ($bloque_segundo_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_segundo_nivel["html"];
            }
            if ($bloque_tercer_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_tercer_nivel["html"];
            }
            if ($bloque_cuarto_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_cuarto_nivel["html"];
            }
            if ($bloque_quinto_nivel["num_categorias"] > 0) {
                $r[] = hr();
                $r[] = $bloque_quinto_nivel["html"];
            }
            $response = d(append($r), "contenedor_sub_categorias");

        }
        return d(d($response, 'contenedor_menu_productos_sugeridos'), "border-right padding_5");
    }

    function crea_sub_menu_categorias_destacadas($param)
    {
        $z = 0;
        $response = [];
        foreach ($param as $row) {


            if ($z == 0) {
                $response [] = "<ul class='clasificaciones_sub_menu_ul'>";
            }

            $response [] = li(

                a_enid($row["nombre_clasificacion"],
                    [
                        "href" => "?q=&q2=" . $row["primer_nivel"],
                        "class" => 'text_categoria_sub_menu white text-uppercase'
                    ]
                )
            );
            $z++;
            if ($z == 5) {
                $z = 0;
                $response [] = "</ul>";
            }
        }
        return append($response);
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
        foreach ($info as $row) {

            $url = path_enid("search", "?q=" . $busqueda . "&q2=" . $row["id_clasificacion"]);
            $r[] = a_enid($row["nombre_clasificacion"], ["href" => $url, "class" => 'categoria_text black'], 1);
        }

        $response = [
            "html" => append($r),
            "num_categorias" => count($info),
        ];
        return $response;


    }

}
