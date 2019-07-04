<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_sin_resultados()
    {
        $r[] = heading_enid("NO HAY PRODUCTOS QUE COINCIDAN CON TU BÚSQUEDA", 3, "info_sin_encontrar");
        $r[] = div("SUGERENCIAS", "contenedor_sugerencias sugerencias");

        $r[] = ul(
            [
                "- REVISA LA " . strong("ORTOGRAFÍA DE LA PALABRA"),
                "- UTILIZA PALABRAS" . strong("MÁS SIMPLES"),
                "- NAVEGA POR CATEGORÍAS"


            ]);
        $r[] = div(
            guardar("ANUNCIA ESTE PRODUCTO!" . icon('fa fa-chevron-right ir'),
                [],
                1,
                1,
                1, path_enid("login")
            )
            ,
            "col-lg-5 top_20", 1);

        $response = div(append($r), "border padding_20 top_20 col-lg-10 col-lg-offset-1", 1);
        return $response;

    }

    function get_format_sin_resultados_tienda()
    {
        $r[] = place("separador_inicial");
        $r[] = btw(

            heading_enid("AÚN NO HAS ANUNCIADO PRODUCTOS EN TU TIENDA", 1),
            guardar("ANUNCIA TU PRIMER PRODUCTO " . icon('fa fa-chevron-right ir'),
                ["class" => "top_30"],
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

        if ($is_mobile > 0) {

            $response = div($filtro, 12);

        } else {


            $response = btw(
                div(div($filtro, "pull-left"), 6),
                div(div($paginacion, "pull-right"), 6),
                "row d-flex align-items-center justify-content-between"
            );

            $response = div($response, 12);
        }

        return $response;

    }

    function val_principal_img($q)
    {

        return (strlen(trim($q)) == 0) ? place("contenedor_img_principal") : "";

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
                    anchor_enid(
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

            $primer_nivel = $b_busqueda["primer_nivel"];
            $segundo_nivel = $b_busqueda["segundo_nivel"];
            $tercer_nivel = $b_busqueda["tercer_nivel"];
            $cuarto_nivel = $b_busqueda["cuarto_nivel"];
            $quinto_nivel = $b_busqueda["quinto_nivel"];

            $bloque_primer_nivel = crea_seccion_de_busqueda_extra($primer_nivel, $busqueda);
            $bloque_segundo_nivel = crea_seccion_de_busqueda_extra($segundo_nivel, $busqueda);
            $bloque_tercer_nivel = crea_seccion_de_busqueda_extra($tercer_nivel, $busqueda);
            $bloque_cuarto_nivel = crea_seccion_de_busqueda_extra($cuarto_nivel, $busqueda);
            $bloque_quinto_nivel = crea_seccion_de_busqueda_extra($quinto_nivel, $busqueda);

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
            $response = div(append($r), ["class" => "contenedor_sub_categorias"]);
            $response = div($response, ["class" => 'contenedor_menu_productos_sugeridos']);

        }
        return div($response,  "border-right padding_5");
    }

    function crea_sub_menu_categorias_destacadas($param)
    {
        $z = 0;
        $response = [];
        foreach ($param as $row) {



            if ($z == 0) {
                $response [] = "<ul class='clasificaciones_sub_menu_ul'>";
            }
            $href = "?q=&q2=" . $row["primer_nivel"];
            $response [] = li(anchor_enid($row["nombre_clasificacion"], ["href" => $href, "class" => 'text_categoria_sub_menu white text-uppercase']));
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
            $total = $row["total"];
            $nombre_clasificacion = "";
            foreach ($param["nombres_primer_nivel"] as $row2) {

                $id_clasificacion = $row2["id_clasificacion"];
                if ($primer_nivel == $id_clasificacion) {
                    $nombre_clasificacion = $row2["nombre_clasificacion"];
                    break;
                }


            }



            $response[$z]["primer_nivel"] = $primer_nivel;
            $response[$z]["total"] = $total;
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
            $r[] = anchor_enid($row["nombre_clasificacion"], ["href" => $url, "class" => 'categoria_text black'], 1);
        }

        $response = [
            "html" => append($r),
            "num_categorias" => count($info),
        ];
        return $response;


    }

}
