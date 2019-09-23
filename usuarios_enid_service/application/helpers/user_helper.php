<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_format_afiliados')) {
        function get_format_afiliados()
        {

            $r[] = h("Afiliados Enid Service", 3);
            $r[] = addNRow(ul(li(
                    a_enid(
                        text_icon('fa fa-trophy', "Miembros Afiliados")
                        ,
                        [
                            "href" => "#tab_afiliados_activos",
                            "data-toggle" => "tab",
                            "id" => '1'
                        ]
                    )
                ),
                    "nav nav-tabs"
                )
            );
            $r[] = place("usuarios_enid_service_afiliados");
            return append($r);


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


            $r[] = h("+ Nuevo miembro", 3);
            $r[] = form_open("", ["class" => "form-miembro-enid-service", "id" => 'form-miembro-enid-service']);
            $r[] = d(btw(
                d("Estatus"),
                create_select($options, "status", "form-control input-sm estado_usuario", "estado_usuario", "opcion", "val"),
                4

            ),
                13);


            $y[] = btw(
                d("Nombre"),
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

            $y[] = btw(
                d("A.paterno"),
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

            $y[] = btw(
                d("A.Materno"),
                input(
                    ["name" => "apellido_materno",
                        "placeholder" => "placeholder",
                        "class" => "form-control input-sm apellido_materno",
                        "type" => "text",
                        "required" => "true"])
                ,
                4
            );

            $r[] = d(append($y), 13);
            $x[] = d("Email");
            $x[] = input([
                "name" => "email",
                "placeholder" => "email",
                "class" => "form-control input-sm email",
                "type" => "email",
                "required" => true,
                "readonly" => true
            ]);
            $x[] = place("place_correo_incorrecto");


            $r[] = d(append($x), 4);
            $r[] = btw(
                d("Departamento"),
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

            $r[] = btw(
                d("Puesto")
                ,
                place("place_puestos")
                ,
                4
            );


            $l[] = btw(
                d("Inicio de labores")
                ,
                create_select($opt, "inicio_labor", "form-control inicio_labor", "inicio_labor", "opcion", "val")
                , 4
            );

            $l[] = btw(
                d("Fin de labores"),
                d(create_select($opt, "fin_labor", "form-control fin_labor", "fin_labor", "opcion", "val"))
                , 4
            );


            $l[] = btw(
                d("Turno"),
                create_select($opt_sexo, "turno", "form-control input-sm turno", "turno", "opcion", "val")
                , 4


            );

            $r[] = d(append($l), 13);


            $t[] = btw(
                d("Sexo"),
                create_select($opt_sexo, "sexo", "form-control input-sm sexo", "sexo", "opcion", "val"),
                4
            );

            $t[] = btw(
                d("Teléfono"),
                input([
                    "type" => "text",
                    "name" => "tel_contacto"
                ]),
                4
            );

            $r[] = d(append($t), 13);
            $r[] = btn("Registrar");
            $r[] = place("place_config_usuario");
            $r[] = form_close();
            return append($r);


        }
    }
    if (!function_exists('get_format_info_usuario')) {
        function get_format_info_usuario()
        {
            $l = [
                li(a_enid(text_icon("fa fa-trophy",  "Miembros activos") ,
                    [
                        "href" => "#tab_usuarios_activos",
                        "data-toggle" => "tab",
                        "class" => "equipo_enid_service",
                        "id" => '1'
                    ]), ["class" => "active", "id" => "1"]),

                li(a_enid(
                    text_icon("fa fa-chevron-circle-down", "Bajas")
                    ,
                    [
                        "href" => "#tab_usuarios_baja",
                        "data-toggle" => "tab",
                        "class" =>
                            "btn_solo_llamar_despues equipo_enid_service",
                        "id" => '0'
                    ])),
                li(place("place_num_agendados_llamar_despues"))
            ];


            $r[] = h("Equipo Enid Service", 3);
            $r[] = d(ul($l, "nav nav-tabs"), "panel-heading");
            $r[] = d(append([
                btn("Agregar nuevo",
                    [
                        "class" => "btn input-sm btn_nuevo_usuario",
                        "data-toggle" => "tab",
                        "href" => "#tab_mas_info_usuario"
                    ]),
                place("usuarios_enid_service")
            ]),
                ["class" => "tab-pane active", "id" => "tab_usuarios_activos"]);

            return append($r);


        }
    }
    if (!function_exists('get_format_tipo_clasificacion')) {
        function get_format_tipo_clasificacion()
        {
            $x[] = d("TIPO CLASIFICACIÓN", 3);

            $x[] = d(append(
                [
                    form_open("", ["class" => "form-tipo-talla"]),
                    input(["type" => "text", "name" => "tipo_talla", "required" => true]),
                    form_close()
                ]
            ), 9);

            $r[] = d(d(append($x), 6, 1), 13);
            $r[] = place("place_tallas");
            return append($r);

        }
    }

    if (!function_exists('get_format_categorias')) {
        function get_format_categorias()
        {

            $r[] = d(frm_categorias(), 7);
            $r[] = d(heading("CATEGORÍAS    EN PRODUCTOS Y SERVICIOS", 3), 5);
            return append($r);


        }
    }
    if (!function_exists('frm_categorias')) {
        function frm_categorias()
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
            $r[] = d("¿ES SERVICIO?", 4);
            $r[] = d(create_select($options, "form-control servicio", "servicio", "servicio", "opcion", "val"), 8);
            $r[] = d("CATEGORÍA", 4);
            $r[] = d(input([
                "id" => "textinput",
                "name" => "clasificacion",
                "placeholder" => "CATEGORÍA",
                "class" => "form-control input-md clasificacion",
                "required" => "true",
                "type" => "text"
            ]), 8);

            $r[] = btw(
                btn("SIGUIENTE", ["class" => "a_enid_blue add_categoria"]),
                place("msj_existencia"),
                "form-group"
            );


            $r[] = form_close();
            $r[] = td(place('primer_nivel'));
            $r[] = td(place('segundo_nivel'));
            $r[] = td(place('tercer_nivel'));
            $r[] = td(place('cuarto_nivel'));
            $r[] = td(place('quinto_nivel'));

            return tb(append($r));

        }

    }


    if (!function_exists('get_form_agregar_recurso')) {
        function get_form_agregar_recurso()
        {

            $r[] = h("Agregar Recurso", 3);
            $r[] = frm_recurso();
            return append($r);

        }

    }


    if (!function_exists('frm_recurso')) {
        function frm_recurso()
        {

            $r[] = form_open("", ["class" => "form_recurso", "id" => 'form_recurso']);
            $r[] = btw(

                d("Nombre"),
                input([
                    "type" => "text",
                    "name" => "nombre",
                    "class" => "form-control",
                    "required" => "true"
                ])
                ,
                6
            );

            $r[] = btw(

                d("../Url recurso"),
                input([
                    "type" => "text",
                    "name" => "urlpaginaweb",
                    "class" => "form-control",
                    "required" => "true"
                ])
                ,
                6
            );
            $r[] = btn("Registrar");
            $r[] = place("place_recurso");
            $r[] = form_close();

            return append($r);

        }

    }
    if (!function_exists('get_menu')) {
        function get_menu($in_session)
        {

            $config["id"] = 'tab_equipo_enid_service';
            $config["data-toggle"] = 'tab';
            $config["class"] = 'black strong tab_equipo_enid_service';
            $config["href"] = "#tab1";

            $l1 = li(a_enid( text_icon("fa fa-space-shuttle",  'EQUIPO  ENID  SERVICE'), $config));

            $config["id"] = 'tab_afiliados';
            $config["class"] = 'black strong tab_afiliados btn_ventas_mes_usuario';
            $config["href"] = "#tab_productividad_ventas";

            $l2 = li(a_enid(text_icon("fa fa-handshake-o", "AFILIADOS") . place("place_num_productividad"), $config));

            $config["id"] = 'tab_perfiles';
            $config["class"] = 'black strong perfiles_permisos';
            $config["href"] = "#tab_perfiles_permisos";

            $l3 = li(a_enid(text_icon("fa fa-unlock-alt" ,  "PERFILES / PERMISOS "), $config));

            $config3["id"] = 'agregar_categorias';
            $config3["class"] = 'black strong tab_agregar_categorias';
            $config3["data-toggle"] = 'tab';
            $config3["href"] = "#tab_agregar_categorias";

            $l4 = li(a_enid(text_icon("fa fa-circle", "CATEGORÍAS / SERVICIOS"), $config3));

            $config4["id"] = 'agregar_tallas_menu';
            $config4["class"] = 'black strong agregar_tallas';
            $config4["data-toggle"] = 'tab';
            $config4["href"] = "#agregar_tallas";

            $l5 = li(a_enid(icon("fa fa-percent") . "TALLAS", $config4));
            $list = [$l1, $l2, $l3 . $l4, $l5];
            return ul($list, ["class" => "nav tabs"]);


        }
    }


}