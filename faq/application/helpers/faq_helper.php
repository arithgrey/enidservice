<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_faqs($data)
    {
        $response = hrz(
            get_format_izquierdo($data["categorias_publicas_venta"], $data["categorias_temas_de_ayuda"], 1),
            lista_fq($data),
            3
        );

        return d($response, 1);

    }

    function lista_fq($data)
    {

        $response = "";
        $es_categoria = (array_key_exists("faqs_categoria", $data) && $data["faqs_categoria"] > 0);
        if ($es_categoria) {

            $response = get_cat($data["faqs_categoria"]);

        } else {


            if (prm_def($data, "respuesta") > 0) {

                $es_configuracion = array_key_exists(
                        "param", $data) && array_key_exists("config", $data["param"]);
                $response =
                    ($es_configuracion) ? form_respuesta(
                        $data, 1) : get_lista_faq($data["respuesta"], $data);

            } else {

                $response = ($data["es_form"] > 0) ? form_respuesta($data) : $response;
            }

        }
        return $response;
    }

    function get_cat($faqs)
    {

        $r = [];

        foreach ($faqs as $row) {

            $bloque =
                hrz(
                    img(
                        [
                            "src" => $row["url_img"],
                            "class" => "mh_270"
                        ]
                    ),
                    h($row["titulo"], 4, "black text-uppercase")
                    ,
                    3, "row mh_200 border mt-5 "
                );
            $r[] = a_enid($bloque, path_enid("editar_faq", $row["id_faq"]));

        }

        return append($r);

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
                "col-lg-12 top_30 padding_10 "
            );
        }

        return append($r);
    }


    function get_format_listado_categorias($categorias_publicas_venta, $categorias_temas_de_ayuda)
    {

        $r[] = d(lista_categorias($categorias_publicas_venta));
        $r[] = d(place("place_categorias_extras"));
        $r[] = d(lista_categorias($categorias_temas_de_ayuda));
        return d($r, "categorias_frecuentes p-3 shadow top_30 border ");

    }

    function form_respuesta($data, $editar = 0)
    {

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


        $r[] = form_open("", ["class" => "form_respuesta", "id" => 'form_respuesta']);
        $r[] = d("CATEGORÍA", 3);

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
        $r[] = d($select, 9);
        $r[] = d("TIPO", "col-lg-3 mt-5");
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

            $r[] = d(create_select_selected($opt, "val", "text", $status, "status", "form-control tipo_respuesta top_20"), 9);

        } else {

            $r[] = d(create_select($opt, "status", "form-control tipo_respuesta top_20", "tipo_respuesta", "text", "val"), 9);
        }


        $r[] = d("TITULO", "col-lg-4 mt-5");
        $r[] = d(
            input(
                [
                    "type" => "text",
                    "name" => "titulo",
                    "class" => 'form-control titulo  top_20',
                    "required" => true,
                    "value" => $titulo
                ]
            ), 8);
        $r[] = d(place("", ["id" => "summernote"]), "col-lg-12 top_40");
        $r[] = d(btn("Registrar", ["class" => "btn", "type" => "submit"]), "col-lg-12 top_20");
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
        $r[] = d(place("place_refitro_respuesta"), "col-lg-12 top_40");

        if ($editar > 0) {

            $r[] = d(h("+ imagen", 4, ["class" => "cursor_pointer text_agregar_img", "onclick" => "agrega_img_faq()"]), "col-lg-12 top_40");
            $r[] = d(d("", "place_load_img_faq"), "col-lg-12 top_40");

        }

        return d(d(append($r), 8, 1), "top_30");
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

    /*
function valida_format_respuestas_menu($in_session, $lista_categorias)
{
  $response = "";
  if ($in_session > 0) {
      $response = d(
          form_respuesta($lista_categorias),
          [
              "class" => "tab-pane fade",
              "id" => "tab2default"
          ]
      );
  }
  return $response;

}
function get_format_fq($flag_categoria, $flag_busqueda_q, $faqs_categoria, $respuesta, $in_session, $perfil)
{

  $r[] = ($flag_categoria > 0) ?   get_format_faq_categorias($faqs_categoria) : "";
  $r[] = ($flag_busqueda_q > 0) ? get_formar_respuesta($respuesta, $in_session, $perfil) : "";
  return append($r);

}

*/
    /*
    function get_format_faq_categorias($faqs_categoria)
    {

        $r = [];
        $z = 1;
        foreach ($faqs_categoria as $row) {

            $titulo = $row["titulo"];
            $id_faq = $row["id_faq"];
            $href = "?faq=" . $id_faq;
            $source = "../imgs/index.php/enid/img_faq/" . $id_faq;

            $x[] = d($z, "day");
            $x[] = img($source);
            $x[] = h($titulo);
            $text = ul(li(append($x)), "event-list");
            $r[] = a_enid($text, ["href" => $href]);
            $z++;
        }

        return d(append($r));
    }*/

    /*
    function get_formar_respuesta($respuesta, $in_session, $perfil)
    {

        $r = [];
        foreach ($respuesta as $row) {
            $titulo = $row["titulo"];
            $respuesta = $row["respuesta"];
            $id_faq = $row["id_faq"];

            $btn_conf = "";
            if ($in_session > 0 && $perfil != 20 && $perfil != 19 && $perfil != 17) {

                $btn_conf = a_enid("", [
                    "href" => '#tab2default',
                    "data-toggle" => 'tab',
                    "class" => 'btn_edicion_respuesta fa fa-cog',
                    "id" => $id_faq
                ]);
            }
            $response = d(d($btn_conf . $titulo), "row");
            $r[] = $response;
            $r[] = $respuesta;

        }
        return d(append($r));

    }
    function get_btn_registro_faq($in_session, $perfil)
    {

        $response = "";
        $n = [20 ,19 ,17];
        if ($in_session == 1 && !in_array($perfil,$n)) {

            $response = a_enid(
                text_icon("fa fa-plus-circle", "AGREGAR")
                ,
                [
                    "href" => "#tab2default",
                    "id" => "enviados_a_validacion",
                    "class" => "btn_registro_respuesta "
                ]
            );

        }
        return $response;
    }

    */
//
//    function get_format_menu($in_session, $perfil)
//    {
//
//        return ul([
//                a_enid(
//                    path_enid("fa fa-question-circle", "PREGUNTAS FRECUENTES")
//                    ,
//                    [
//                        "href" => "#tab1default"
//                    ]
//                )
//            ]
//            ,
//            "nav nav-tabs"
//        );
//    }


}