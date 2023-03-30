<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function costos($param, $data)
    {

        $buscador_cp[] = buscador();
        $buscador_cp[] = costo_entrega($data);

        $buscador_alcaldia[] = buscador_alcaldia($data);

        $response[] = d(_titulo('Calcula el costo de entrega de tu pedido'), 'col-sm-12 mb-5 mt-5');
        $response[] = d("Entregas gratis en Alcaldia Iztacalco, algunas colonias de Iztapalapa e igual algunos codigos postales de Nezahualcóyotl
        ", 'col-sm-12 mb-5 mt-5 strong bg_black white f12 p-2');
        $response[] = d($buscador_alcaldia, 'col-md-6 border-right p-0');
        $response[] = d($buscador_cp, 'col-md-6  p-0');
        $response[] = form_costo_entrega();
        $response[] = form_costo_entrega_alcaldia($data["alcaldias"]);
        $response[] = hr();
        $otros_articulis_titulo = _titulo('Aquí te dejamos más cosas que te podrían interesar!', 2);

        
        $ext = (is_mobile() ? "mt-5" : "top_400");
        $response[] = d(hr(), _text_($ext , 'd-none sugerencias_titulo col-sm-12 '));
        $response[] = d($otros_articulis_titulo, 'mt-5 d-none sugerencias_titulo col-sm-12 ');
        $response[] = d(
            place("place_tambien_podria_interezar row"),
            "col-sm-12"
        );

        $response[] = d(hr(), 'mt-5 col-sm-12 ');
        //$response[] = d(botones_ver_mas(), 'mt-5');

        return d($response, 10, 1);
    }

    function buscador()
    {
        $z[] = d("También puedes");
        $z[] = d(h("Ingresar tu código postal para saber el costo de tu entrega ", 4, "strong"));
        $z[] = "<form action='../costo_entrega' class='mt-5'>";
        $z[] = d(
            add_text(
                icon('fa fa-search icon'),
                input([
                    "class" => "input-field mh_50 border border-dark  solid_bottom_hover_3  ",
                    "placeholder" => "buscar",
                    "name" => "q"
                ])
            ),
            "input-icons "
        );
        $z[] = form_close();
        return d($z, 12);
    }
    function buscador_alcaldia($data)
    {
        $alcaldias = $data["alcaldias"];
        $es_amministrador = $data["es_administrador"];
        $z[] = "<form action='../costo_entrega' class='mt-5'>";
        $select_alcaldias  = create_select(
            $alcaldias,
            "delegacion",
            "ubicacion_delegacion",
            'delegacion',
            "delegacion",
            'id_delegacion',
            0,
            1,
            '0',
            'Selecciona una alcaldía'
        );
        $texto_alcaldia = "Selecciona tu alcaldía para saber el costo de tu entrega ";


        $z[] =   d(h($texto_alcaldia, 4, "strong  mt-5 "));;
        $z[] =  d($select_alcaldias, "mt-5 mb-5");
        if ($data["es_administrador"]) {
            $z[] = d("También puedes cambiar el costo de entrega por alcaldía", "costo_alcaldia cursor_pointer underline");
        }
        $z[] = hiddens(["class" => "es_administrador", "value" => $es_amministrador]);
        $z[] = place('place_colonia');

        $z[] = form_close();
        return d($z, 12);
    }
    function costo_entrega($data)
    {

        $costos  = $data["costo_entrega"];
        $response = [];
        foreach ($costos as $row) {

            $cp = $row["cp"];
            $asentamiento = $row["asentamiento"];
            $municipio = $row["municipio"];
            $estado = $row["estado"];
            $costo_entrega = $row["costo_entrega"];

            $linea  = [];
            $texto_costo  =  ($costo_entrega <  1) ? 'La entrega es gratis! y te las podemos llevar hoy mismo!' : money($costo_entrega);
            $linea[] = d(d($texto_costo, 'h4 blue_enid3 white  shadow p-3'), 12);
            $linea[] = d(_text_($asentamiento, $cp, $municipio, $estado), 12);

            $response[] = d($linea, 'row mt-5');
        }
        return d($response, 12);
    }
    function form_costo_entrega()
    {

        $form[] = d(_titulo('¿Cual es el costo de entrega?'), 'text-center text-md-left');

        $form[] = d("", "texto_colonia f12 strong mt-5");
        $form[] = d("", "texto_costo   mt-3");


        $formulario[] = form_open("", ["class" => "form_costo_entrega", "id" => "form_costo_entrega"]);



        $formulario[] = d(
            input_frm(
                '',
                'Nuevo costo(MXN)',
                [
                    'class' => 'costo_entrega',
                    'name' => 'costo_entrega',
                    'id' => 'costo_entrega',
                    'required' => true
                ]
            ),
            'mt-5'
        );
        $formulario[] = hiddens(["name" => "id_codigo_postal", "class" => "id_codigo_postal", "value" => 0]);
        $formulario[] = btn('Registrar', ['class' => 'mt-5']);
        $formulario[] = form_close();

        $form[] = d($formulario);
        $modal = append($form);
        return gb_modal($modal, "modal_costo_entrega");
    }
    function form_costo_entrega_alcaldia($alcaldias)
    {

        $form[] = d(_titulo('¿Cual es el costo de entrega para esta alcaldía?'), 'text-center text-md-left');
        $form[] = d("", "texto_alcaldia f12 strong mt-5");

        $formulario[] = form_open(
            "",
            [
                "class" => "form_costo_entrega_alcaldia",
                "id" => "form_costo_entrega_alcaldia"
            ]
        );

        $select_alcaldias  = create_select(
            $alcaldias,
            "delegacion",
            "alcaldia",
            'delegacion',
            "delegacion",
            'id_delegacion',
            0,
            1,
            '0',
            'Selecciona una alcaldía'
        );
        $texto_alcaldia = "Selecciona la alcaldía";
        $formulario[] =   d($texto_alcaldia, "strong");
        $formulario[] =  d($select_alcaldias, "mt-2 mb-5");

        $formulario[] = d(
            input_frm(
                '',
                'Nuevo costo(MXN)',
                [
                    'class' => 'costo_entrega',
                    'name' => 'costo_entrega',
                    'id' => 'costo_entrega',
                    'required' => true
                ]
            ),
            'mt-5'
        );



        $formulario[] = hiddens(["name" => "id_alcaldia", "class" => "id_alcaldia", "value" => 0]);
        $formulario[] = btn('Registrar', ['class' => 'mt-5']);
        $formulario[] = form_close();

        $form[] = d($formulario);
        $modal = append($form);
        return gb_modal($modal, "modal_costo_entrega_alcaldia");
    }
    function botones_ver_mas()
    {

        $link_productos =  format_link("Ver más promociones", [
            "href" => path_enid("search", _text("/?q2=0&q=&order=", rand(0, 8), '&page=', rand(0, 5))),
            "class" => "border",
            "onclick" => "log_operaciones_externas(32)"
        ]);

        $link_facebook =  format_link("Facebook", [
            "href" => path_enid("facebook", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_',
            "onclick" => "log_operaciones_externas(33)"
        ], 0);

        $link_instagram =  format_link("Instagram", [
            "href" => path_enid("fotos_clientes_instagram", 0, 1),
            "class" => "border mt-4",
            'target' => 'blank_',
            "onclick" => "log_operaciones_externas(34)"
        ], 0);


        $response[] = d($link_productos, 4,1);
        $response[] = d($link_facebook, 4,1);
        $response[] = d($link_instagram, 4,1);

        return append($response);
    }
}
