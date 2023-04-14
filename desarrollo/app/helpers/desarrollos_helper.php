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

        $tab_content = d(tab_content($r),_mbt5);

        $response[] = dd(
            menu($activa, $data),
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
    function navegacion_frecuente($data)
    {
        $response = [];
        if (es_administrador($data)) {            

            $response[] = d(format_link(
                text_icon(_text_(_money_icon,'white'), "Dasboards"),
                [

                    "href" => path_enid("reporte_enid"),
                    "class" => "text-uppercase black mt-2",
                ]
            ), 12);


            $response[] = d(format_link(
                text_icon(_text_(_money_icon), "Noticias"),
                [
    
                    "href" => path_enid("busqueda"),
                    "class" => "text-uppercase black mt-2",
                ]
            ,0),12);
    
            $response[] = d(format_link(
                text_icon(_money_icon, "pedidos"),
                [
                    "id" => "btn_servicios",
                    "href" => path_enid("pedidos"),
                    "class" => "text-uppercase black  mt-2 dispositivos",
                ],
                0
            ),12);

        }
        return d($response,13);
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
        return d_row(d($r, 6, 1));

    }

    function menu($activa, $data)
    {

        $class_ticket = _text_(
            'mt-5 abrir_ticket ',
            tab_activa(3, $activa)
        );

        $class_pendientes = _text_(
            _strong,'mt-4    base_tab_clientes ', tab_activa(1, $activa)
        );
        $navegacion = navegacion_frecuente($data);
        $list = [
            $navegacion, 
            tab(
                btn("ABRIR TICKET"),
                '#tab_nuevo_ticket'
                ,
                [
                    'id' => 'abrir_ticket',
                    'class' => $class_ticket
                ]
            )
            ,
            tab(
                text_icon('fa fa-check-circle', "pendientes"),
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

