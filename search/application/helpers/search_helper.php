<?php use function Sodium\add;

if (!defined('BASEPATH')) exit('No direct script access allowed');
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


        $x[] = get_format_filtros_paginacion($data["filtros"], $data["order"], $paginacion, $is_mobile);
        $x[] = append($data["lista_productos"]);
        $r[] = get_format_menu_categorias_destacadas($is_mobile, $categorias_destacadas);

        $z[] = _titulo("filtra tu búsqueda", 0, 'mt-5 mt-md-0 ');

        if ($is_mobile < 1) {
            $z[] = img(
                [
                    "src" => "../img_tema/productos/ejemplo.png",
                    'class' => 'd-none d-md-block'
                ]
            );
        }


        $z[] = get_formar_menu_sugerencias($is_mobile, $data["bloque_busqueda"], $busqueda);

        $fil[] = d($z, 3);


        $seccion = _text(

            append($x)
            ,
            d($paginacion, "mt-md-5")
        );


        $fil[] = d($seccion, 'col-lg-9 p-0');
        $r[] = d($fil, "col-lg-12 mt-md-5");
        $cat[] = crea_sub_menu_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas));
        $r[] = append($cat);
        return append($r);


    }

    function sin_resultados($param)
    {

        $r[] = d(h("LO SENTIMOS, NO HAY NINGÚN RESULTADO PARA ", 4, "strong letter-spacing-15 fz_30"));
        $r[] = d(h('"' . prm_def($param, "q","") . '".', 4, "strong letter-spacing-15 fz_30"));
        $r[] = d(d("¡No te desanimes! Revisa el texto o intenta buscar algo menos específico. ", "mt-5 fp9 mb-5"));

        $z[] = "<form action='../search' class='mt-5'>";
        $z[] = d(
            add_text(
                icon('fa fa-search icon'),
                input([
                    "class" => "input-field mh_50 border border-dark  solid_bottom_hover_3  ",
                    "placeholder" => "buscar",
                    "name" => "q"
                ])
            )
            , "input-icons col-lg-6 row");
        $z[] = form_close();
        $ext = (is_mobile() < 1) ? "" : "top_200";
        $r[] = d($z, "mt-5 " . $ext);

        return d($r, " mt-5 col-lg-10 col-lg-offset-1", 1);


    }

    function get_format_filtros_paginacion($filtros, $order, $paginacion, $is_mobile)
    {

        $paginacion = d($paginacion, 'd-none d-md-block');
        $filtro = filtro($filtros, $order);
        return ($is_mobile > 0) ? d($filtro, 'col-lg-12 mt-4 mb-4 ') :
            flex($filtro, $paginacion, 'd-md-flex justify-content-between');


    }


    function filtro($filtros, $order)
    {

        $r[] = '<select class="form-control order" name="order" id="order">';
        $a = 0;
        foreach ($filtros as $row):
            $str = strtoupper($row);
            if ($a == $order):

                $r[] = '<option value="' . $a . '" selected>';
                $r[] = $str;
                $r[] = '</option>';
            else:
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

            $r[] =
                d(a_enid(
                    "Audio",
                    [
                        "href" => "../../repros",
                        "class" => 'categorias_mas_vistas ',
                        "target" => "_black"
                    ]
                ), 2);

            foreach (crea_menu_principal_web($categorias_destacadas) as $row):

                $nombre = explode(' ', $row["nombre_clasificacion"])[0];
                $r[] =
                    d(
                        a_enid(
                            $nombre,
                            [
                                "href" => "?q=&q2=" . $row['primer_nivel'],
                                "class" => 'categorias_mas_vistas '
                            ]
                        ),
                        2
                    );
            endforeach;

        }
        return d(
            d($r, "col-lg-8 col-lg-offset-2 d-flex  flex-row align-items-end text-center black strong"), 'contenedor_anuncios_home col-lg-12  mb-5 p-3 bg-light d-none d-md-block');


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
        return d(d($response, 'contenedor_menu_productos_sugeridos'), "d-none d-md-block  mt-md-5");
    }

    function crea_sub_menu_categorias_destacadas($param)
    {
        $extra = (is_mobile()) ? ' p-0 ' : '';
        $response = [];
        foreach ($param as $row) {

            $response [] = a_enid(
                $row["nombre_clasificacion"],
                [
                    "href" => "?q=&q2=" . $row["primer_nivel"],
                    "class" => ' text-uppercase black fp9 mt-1 mt-md-0'
                ]

            );

        }

        $t[] = d(
            img(
                [
                    "src" => "../img_tema/productos/ejemplo2.jpg",
                    "class" => "card-img"
                ]
            ), 'col-md-6 col-sm-12 ' . $extra);

        $s[] = _titulo("Más categorías", 0);
        $s[] = p(d($response, 'mt-4'));
        $sec[] = d($s, 'col-md-6 col-sm-12 mt-3 mt-md-0');
        $r[] = append($t);
        $r[] = append($sec);

        return d($r, 'col-lg-6 mt-5 d-md-flex  align-items-center ' . $extra);

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

        return [
            "html" => append($r),
            "num_categorias" => count($info),
        ];
    }
}
