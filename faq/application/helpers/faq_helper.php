<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function render($data)
    {

        $response[] = d(
            faqs(
                $data["categorias_publicas_venta"],
                $data["categorias_temas_de_ayuda"],
                $data['in_session']
            ),
            'col-sm-3 mb-0');


        $agregar = key_exists_bi($data, 'param', 'nueva');
        $categoria = key_exists_bi($data, 'param', 'categoria');
        $faq = key_exists_bi($data, 'param', 'faq');
        $es_configuracion = key_exists_bi($data, 'param', 'config');


        if ($agregar > 0) {

            $response[] = form_respuesta($data);

        } else if ($categoria > 0) {

            $response[] = categorias($data["faqs_categoria"]);

        } else if ($faq > 0 && $es_configuracion > 0) {

            $response[] = form_respuesta($data, 1);

        } else {


            if ($faq > 0) {
                $response[] = get_lista_faq($data["respuesta"], $data);;
            }


        }
        return append($response);
    }

    function categorias($faqs)
    {

        $r = [];

        foreach ($faqs as $row) {

            $img = img(
                [
                    "src" => $row["url_img"]
                ]
            );
            $titulo = _titulo($row['titulo'], 1);
            $bloque = flex($img, $titulo,'flex-column text-center','col-sm-8 mx-auto p-0','mt-5');
            $path = path_enid(
                "editar_faq", $row["id_faq"]
            );

            $r[] = d(a_enid($bloque, $path),'col-sm-4 p-0 mt-5');

        }

        return d($r,'col-md-9 my-md-auto mt-5');

    }

    function get_lista_faq($respuestas, $data)
    {

        $r = [];

        foreach ($respuestas as $row) {

            $extra = ($data["in_session"] > 0) ? a_enid(icon("fa fa-cogs"), ["href" => path_enid("editar_faq", $row["id_faq"] . "&config=1")]) : "";
            $x[] = d(h($extra . $row["titulo"], 4, "black text-uppercase underline"), 1);
            $x[] = d_p($row["respuesta"], "black mt-5");
            $x[] = d_p($row["fecha_registro"], "mt-5");

            $r[] = d(
                $x
                ,
                "col-lg-12  padding_10 "
            );
        }

        return append($r);
    }


    function get_format_listado_categorias($categorias_publicas_venta, $categorias_temas_de_ayuda)
    {

        $r[] = lista_categorias($categorias_publicas_venta);
        $r[] = place("place_categorias_extras");
        $r[] = lista_categorias($categorias_temas_de_ayuda);
        return d(_d($r), "categorias_frecuentes p-3 shadow  border ");

    }

    function form_respuesta($data, $editar = 0)
    {

        $response = [];
        if ($data['in_session']) {
            $lista_categorias = $data["lista_categorias"];
            $id_faq = 0;
            $respuesta = "";
            $titulo = "";
            $id_categoria = 0;
            $status = 0;

            if ($editar > 0) {


                $res = $data["respuesta"][0];
                $id_faq = $res["id_faq"];
                $respuesta = $res["respuesta"];
                $titulo = $res["titulo"];
                $id_categoria = $res["id_categoria"];
                $status = $res["status"];

            }

            $r[] = form_open("",
                [
                    "class" => "form_respuesta",
                    "id" => 'form_respuesta'
                ]
            );

            $select = create_select(
                $lista_categorias,
                "categoria",
                "form-control categoria",
                "categoria",
                "nombre_categoria",
                "id_categoria"
            );

            if ($editar > 0) {

                $select = create_select_selected(
                    $lista_categorias,
                    "id_categoria",
                    "nombre_categoria",
                    $id_categoria,
                    "categoria",
                    "form-control categoria"

                );
            }

            $r[] = flex(
                'categoría', $select, _between_end, _strong, _6p);

            $opt[] =
                [
                    "val" => 1,
                    "text" => "Pública"
                ];
            $opt[] =
                [
                    "val" => 0,
                    "text" => "Privada"
                ];
            $opt[] =
                [
                    "val" => 2,
                    "text" => "Solo para labor de venta"
                ];
            $opt[] =
                [
                    "val" => 3,
                    "text" => "Pos venta"
                ];


            if ($editar > 0) {

                $select_privacidad =
                    create_select_selected($opt, "val", "text",
                        $status, "status",
                        "form-control text-uppercase tipo_respuesta");

            } else {

                $select_privacidad = create_select($opt, "status",
                    "form-control tipo_respuesta text-uppercase",
                    "tipo_respuesta", "text", "val");
            }


            $r[] = flex('privacidad',
                $select_privacidad,
                _text_(_between_end, _mbt5),
                _strong, _6p
            );


            $r[] = input_frm('', 'titulo',
                [
                    "type" => "text",
                    "name" => "titulo",
                    "class" => 'titulo',
                    "id" => 'titulo',
                    "required" => true,
                    "value" => $titulo
                ], '', 'text-uppercase'
            );

            $r[] = d(place("", ["id" => "summernote"]), "col-lg-12 ");

            $r[] = btn("Registrar", ["class" => "btn", "type" => "submit"]);
            $r[] = hiddens(
                [
                    "class" => "id_faq",
                    "value" => $id_faq,
                    "name" => "id_faq"
                ]
            );
            $r[] = hiddens(
                [
                    "class" => "erespuesta",
                    "value" => $respuesta
                ]);
            $r[] = hiddens(
                [
                    "class" => "editar_respuesta",
                    "value" => $editar,
                    "name" => "editar_respuesta"
                ]
            );

            $r[] = form_close();
            $r[] = place("place_refitro_respuesta");

            if ($editar > 0) {

                $r[] = d(
                    _titulo("+ imagen"),
                    [
                        "class" => "cursor_pointer text_agregar_img",
                        "onclick" => "agrega_img_faq()"
                    ]
                );

                $r[] = d("", "place_load_img_faq");

            }

            $response[] = d(d($r, _8auto), 'col-md-9 my-md-auto mt-5');
        }
        return append($response);

    }

    function lista_categorias($categorias)
    {

        $l = [];
        foreach ($categorias as $row) {

            $str = _text_($row["nombre_categoria"], "(", $row["faqs"], ")");
            $link = _text("?categoria=", $row["id_categoria"]);
            $l[] = a_enid($str, $link);
        }
        return append($l);
    }
}