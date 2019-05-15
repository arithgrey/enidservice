<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_afiliados')) {
        function get_format_afiliados()
        {

            $r[] = heading_enid("Afiliados Enid Service", 3);
            $r[] = addNRow(ul(li(anchor_enid("Miembros Afiliados" . icon('fa fa-trophy'),
                [
                    "href" => "#tab_afiliados_activos",
                    "data-toggle" => "tab",
                    "id" => '1'
                ])),
                ["class" => "nav nav-tabs"]
            ));
            $r[] = place("usuarios_enid_service_afiliados");
            return append_data($r);


        }
    }

    if (!function_exists('get_format_view_usuario')) {
        function get_format_view_usuario($departamentos)
        {

            $opt_turnos[] = array(
                "opcion" => "Matutino",
                "val" => "Matutino"
            );

            $opt_turnos[] = array(
                "opcion" => "Vespertino",
                "val" => "Vespertino"
            );
            $opt_turnos[] = array(
                "opcion" => "Tiempo completo",
                "val" => "Tiempo completo"
            );

            $options[] = array(
                "opcion" => "Activo",
                "val" => 1
            );

            $options[] = array(
                "opcion" => "Baja",
                "val" => 0
            );

            $options[] = array(
                "opcion" => "Suspendido",
                "val" => 2
            );


            $opt[] = array(
                "opcion" => "2PM",
                "val" => "2PM"
            );
            $opt[] = array(
                "opcion" => "3PM",
                "val" => "3PM"
            );

            $opt[] = array(
                "opcion" => "6PM",
                "val" => "6PM"
            );
            $opt[] = array(
                "opcion" => "7PM",
                "val" => "7PM"
            );


            $opt_sexo[] = array(
                "opcion" => "Masculino",
                "val" => 1
            );
            $opt_sexo[] = array(
                "opcion" => "Femenino",
                "val" => 0
            );


            $r[] = heading_enid("+ Nuevo miembro", 3);
            $r[] = form_open("", ["class" => "form-miembro-enid-service", "id" => 'form-miembro-enid-service']);
            $r[] = div(get_btw(
                div("Estatus"),
                create_select($options, "status", "form-control input-sm estado_usuario", "estado_usuario", "opcion", "val"),
                4

            ),
                13);


            $y[] = get_btw(
                div("Nombre"),
                input([
                    "name" => "nombre",
                    "placeholder" => "Nombre",
                    "class" => "nombre",
                    "type" => "text",
                    "required" => "true"
                ])
                ,
                4

            );

            $y[] = get_btw(
                div("A.paterno"),
                input([
                    "name" => "apellido_paterno",
                    "placeholder" => "placeholder",
                    "class" => "apellido_paterno",
                    "type" => "text",
                    "required" => true
                ])
                ,
                4
            );

            $y[] = get_btw(
                div("A.Materno"),
                input(
                    ["name" => "apellido_materno",
                        "placeholder" => "placeholder",
                        "class" => "form-control input-sm apellido_materno",
                        "type" => "text",
                        "required" => "true"])
                ,
                4
            );

            $r[] = div(append_data($y), 13);

            $x[] = div("Email");
            $x[] = input([
                "name" => "email",
                "placeholder" => "email",
                "class" => "form-control input-sm email",
                "type" => "email",
                "required" => true,
                "readonly" => true
            ]);
            $x[] = place("place_correo_incorrecto");


            $r[] = div(append_data($x), 4);


            $r[] = get_btw(
                div("Departamento"),
                create_select(
                    $departamentos,
                    "departamento",
                    "form-control input-sm depto",
                    "departamento",
                    "nombre",
                    "id_departamento",
                    1
                ),
                4
            );

            $r[] = get_btw(

                div("Puesto"),
                place("place_puestos"),
                4
            );


            $l[] = get_btw(
                div("Inicio de labores")
                ,
                create_select($opt, "inicio_labor", "form-control inicio_labor", "inicio_labor", "opcion", "val")
                , 4
            );

            $l[] = get_btw(
                div("Fin de labores"),
                div(create_select($opt, "fin_labor", "form-control fin_labor", "fin_labor", "opcion", "val"))
                , 4
            );


            $l[] = get_btw(
                div("Turno"),
                create_select($opt_sexo, "turno", "form-control input-sm turno", "turno", "opcion", "val")
                , 4


            );

            $r[] = div(append_data($l), 13);


            $t[] = get_btw(
                div("Sexo"),
                create_select($opt_sexo, "sexo", "form-control input-sm sexo", "sexo", "opcion", "val"),
                4
            );

            $t[] = get_btw(
                div("Teléfono"),
                input([
                    "type" => "text",
                    "name" => "tel_contacto"
                ]),
                4
            );

            $r[] = div(append_data($t), 13);
            $r[] = guardar("Registrar");
            $r[] = place("place_config_usuario");
            $r[] = form_close();
            return append_data($r);


        }
    }
    if (!function_exists('get_format_info_usuario')) {
        function get_format_info_usuario()
        {
            $l = [
                li(anchor_enid("Miembros activos" . icon("fa fa-trophy"),
                    [
                        "href" => "#tab_usuarios_activos",
                        "data-toggle" => "tab",
                        "class" => "equipo_enid_service",
                        "id" => '1'
                    ]), ["class" => "active", "id" => "1"]),

                li(anchor_enid(
                    "Bajas" . icon("fa fa-chevron-circle-down"),
                    [
                        "href" => "#tab_usuarios_baja",
                        "data-toggle" => "tab",
                        "class" =>
                            "btn_solo_llamar_despues equipo_enid_service",
                        "id" => '0'
                    ])),
                li(place("place_num_agendados_llamar_despues"))
            ];


            $r[] = heading_enid("Equipo Enid Service", 3);
            $r[] = div(ul($l, ["class" => "nav nav-tabs"]), ["class" => "panel-heading"]);
            $r[] = div(append_data([
                guardar("Agregar nuevo",
                    [
                        "class" => "btn input-sm btn_nuevo_usuario",
                        "data-toggle" => "tab",
                        "href" => "#tab_mas_info_usuario"
                    ]),
                place("usuarios_enid_service")
            ]),
                ["class" => "tab-pane active", "id" => "tab_usuarios_activos"]);

            return append_data($r);


        }
    }
    if (!function_exists('get_format_tipo_clasificacion')) {
        function get_format_tipo_clasificacion()
        {
            $x[] = div("TIPO CLASIFICACIÓN", 3);

            $x[] = div(append_data(
                [
                    form_open("", ["class" => "form-tipo-talla"]),
                    input(["type" => "text", "name" => "tipo_talla", "required" => true]),
                    form_close()
                ]
            ), 9 );

            $r[] = div(div(append_data($x), 6, 1), 13);
            $r[] = place("place_tallas");
            return append_data($r);

        }
    }

    if (!function_exists('get_format_categorias')) {
        function get_format_categorias()
        {

            $r[] = div(get_form_categorias(), 7);
            $r[] = div(heading("CATEGORÍAS    EN PRODUCTOS Y SERVICIOS", 3), 5);
            $response = append_data($r);
            return $response;


        }
    }
    if (!function_exists('get_form_categorias')) {
        function get_form_categorias()
        {


            $options[] = array(
                "opcion" => "NO",
                "val" => 0
            );

            $options[] = array(
                "opcion" => "SI",
                "val" => 1
            );

            $r[] = form_open("", ["class" => "form-horizontal form_categoria", "id" => "form_categoria"]);
            $r[] = div("¿ES SERVICIO?", 4);
            $r[] = div(create_select($options, "form-control servicio", "servicio", "servicio", "opcion", "val"), 8);
            $r[] = div("CATEGORÍA", 4);
            $r[] = div(input([
                "id" => "textinput",
                "name" => "clasificacion",
                "placeholder" => "CATEGORÍA",
                "class" => "form-control input-md clasificacion",
                "required" => "true",
                "type" => "text"
            ]), 8);

            $r[] = get_btw(
                guardar("SIGUIENTE", ["class" => "a_enid_blue add_categoria"]),
                place("msj_existencia"),
                "form-group"
            );


            $r[] = form_close();
            $r[] = "
<table>";
            $r[] = get_td(place('primer_nivel'));
            $r[] = get_td(place('segundo_nivel'));
            $r[] = get_td(place('tercer_nivel'));
            $r[] = get_td(place('cuarto_nivel'));
            $r[] = get_td(place('quinto_nivel'));
            $r[] = "
</table>";

            $response = append_data($r);


        }

    }


    if (!function_exists('get_form_agregar_recurso')) {
        function get_form_agregar_recurso()
        {


            $r[] = heading_enid("Agregar Recurso", 3);
            $r[] = get_form_recurso();

            return append_data($r);

        }

    }


    if (!function_exists('get_form_recurso')) {
        function get_form_recurso()
        {

            $r[] = form_open("", ["class" => "form_recurso", "id" => 'form_recurso']);
            $r[] = get_btw(

                div("Nombre"),
                input([
                    "type" => "text",
                    "name" => "nombre",
                    "class" => "form-control",
                    "required" => "true"
                ])
                ,
                6
            );

            $r[] = get_btw(

                div("../Url recurso"),
                input([
                    "type" => "text",
                    "name" => "urlpaginaweb",
                    "class" => "form-control",
                    "required" => "true"
                ])
                ,
                6
            );
            $r[] = guardar("Registrar");
            $r[] = place("place_recurso");
            $r[] = form_close();

            return append_data($r);

        }

    }
    if (!function_exists('get_menu')) {
        function get_menu($in_session)
        {

            $config["id"] = 'tab_equipo_enid_service';
            $config["data-toggle"] = 'tab';
            $config["class"] = 'black strong tab_equipo_enid_service';
            $config["href"] = "#tab1";

            $l1 = li(anchor_enid(icon("fa fa-space-shuttle") . 'EQUIPO  ENID  SERVICE', $config));

            $config["id"] = 'tab_afiliados';
            $config["class"] = 'black strong tab_afiliados btn_ventas_mes_usuario';
            $config["href"] = "#tab_productividad_ventas";

            $l2 = li(anchor_enid(icon("fa fa-handshake-o") . "AFILIADOS" . place("place_num_productividad"), $config));


            $config["id"] = 'tab_perfiles';
            $config["class"] = 'black strong perfiles_permisos';
            $config["href"] = "#tab_perfiles_permisos";

            $l3 = li(anchor_enid(icon("fa fa-unlock-alt") . "PERFILES / PERMISOS ", $config));


            $config3["id"] = 'agregar_categorias';
            $config3["class"] = 'black strong tab_agregar_categorias';
            $config3["data-toggle"] = 'tab';
            $config3["href"] = "#tab_agregar_categorias";

            $l4 = li(anchor_enid(icon("fa fa-circle") . "CATEGORÍAS / SERVICIOS", $config3));


            $config4["id"] = 'agregar_tallas_menu';
            $config4["class"] = 'black strong agregar_tallas';
            $config4["data-toggle"] = 'tab';
            $config4["href"] = "#agregar_tallas";


            $l5 = li(anchor_enid(icon("fa fa-percent") . "TALLAS", $config4));
            $list = [$l1, $l2, $l3 . $l4, $l5];
            return ul($list, ["class" => "nav tabs"]);


        }
    }


}