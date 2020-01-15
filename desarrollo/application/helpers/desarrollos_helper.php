<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    function render_ticket_empresa($data)
    {

        $activa = $data["activa"];
        $z[] = form_ticket_dep(
            $data["departamentos"],
            $data["num_departamento"]
        );
        $z[] = d('', 'place_proyectos mt-5');
        $z[] = place('place_tickets');

        $r[] = tab_seccion(
            $z,
            'tab_abrir_ticket',
            tab_activa(1, $activa)
        );

        $r[] = tab_seccion(
            place("place_form_tickets"),
            'tab_nuevo_ticket',
            tab_activa(3, $activa)
        );

        $tab_content = tab_content($r);

        $response[] = dd(
            menu($activa),
            $tab_content, 2

        );

        $response[] = hiddens(
            [
                "class" => "ticket",
                "value" => $data["ticket"],
            ]
        );
        $response[] = hiddens(
            [
                "class" => 'id_usuario',
                "value" => $data["id_usuario"]
            ]
        );

        return append($response);


    }

    function form_ticket_dep($departamentos, $total)
    {

        $r[] = input_frm("", "Busqueda",
            [
                "name" => "q",
                "class" => "q",
                "type" => "text",
                "id" => "q_busqueda"
            ]
        );

        $r[] = create_select(
            $departamentos,
            "depto",
            "d-none depto",
            "depto",
            "nombre",
            "id_departamento"
        );
        $r[] = hiddens(
            [
                "name" => "departamento",
                "value" => $total,
                "id" => 'num_departamento',
                "class" => 'num_departamento'
            ]
        );
        return contaiter(d($r, 6, 1));

    }

    function menu($activa)
    {

        $class_ticket = _text(
            'black a_enid_blue abrir_ticket ',
            tab_activa(3, $activa)
        );

        $class_pendientes = _text(
            'black strong base_tab_clientes ' .
            tab_activa(1, $activa)

        );

        $list = [
            tab(
                "ABRIR TICKET",
                '#tab_nuevo_ticket'
                ,
                [
                    'id' => 'abrir_ticket',
                    'class' => $class_ticket
                ]
            )
            ,
            tab(
                text_icon('fa fa-check-circle', "PENDIENTES"),
                '#tab_abrir_ticket',
                [
                    "id" => 'base_tab_clientes',
                    'class' => $class_pendientes
                ]
            )
        ];

        return append($list);
    }
}

