<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function get_format_afiliados()
    {

        $r[] = h("Afiliados Enid Service", 3);
        $link_miembros = tab(
            text_icon('fa fa-trophy', "Miembros Afiliados"),
            "#tab_afiliados_activos",
            [
                "id" => 1
            ]
        );
        $r[] = ul(li($link_miembros), "nav nav-tabs");
        $r[] = place("usuarios_enid_service_afiliados");
        return append($r);

    }


    function get_format_view_usuario($departamentos)
    {

        $opt_turnos[] =
            [
                "opcion" => "Matutino",
                "val" => "Matutino"
            ];
        $opt_turnos[] =
            [
                "opcion" => "Vespertino",
                "val" => "Vespertino"
            ];
        $opt_turnos[] =
            [
                "opcion" => "Tiempo completo",
                "val" => "Tiempo completo"
            ];
        $options[] =
            [
                "opcion" => "Activo",
                "val" => 1
            ];
        $options[] =
            [
                "opcion" => "Baja",
                "val" => 0
            ];
        $options[] =
            [
                "opcion" => "Suspendido",
                "val" => 2
            ];
        $opt[] =
            [
                "opcion" => "2PM",
                "val" => "2PM"
            ];
        $opt[] =
            [
                "opcion" => "3PM",
                "val" => "3PM"
            ];

        $opt[] =
            [
                "opcion" => "6PM",
                "val" => "6PM"
            ];
        $opt[] =
            [
                "opcion" => "7PM",
                "val" => "7PM"
            ];
        $opt_sexo[] =
            [
                "opcion" => "Masculino",
                "val" => 1
            ];
        $opt_sexo[] =
            [
                "opcion" => "Femenino",
                "val" => 0
            ];
        $r[] = _titulo("+ Nuevo miembro");

        $r[] = form_open("",
            [
                "class" => "form-miembro-enid-service",
                "id" => 'form-miembro-enid-service'
            ]
        );
        $select_estado_usuario = create_select(
            $options,
            "status",
            "form-control input-sm estado_usuario",
            "estado_usuario",
            "opcion",
            "val"
        );

        $r[] = btw(
            d("Estatus"),
            $select_estado_usuario,
            4
        );


        $y[] = btw(
            d("Nombre"),
            input(
                [
                    "name" => "nombre",
                    "placeholder" => "Nombre",
                    "class" => "nombre",
                    "type" => "text",
                    "required" => "true"
                ]
            )
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

        $r[] = d($y, 13);
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


        $r[] = d($x, 4);
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

        $r[] = d($l, 13);


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

        $r[] = d($t, 13);
        $r[] = btn("Registrar");
        $r[] = place("place_config_usuario");
        $r[] = form_close();
        return append($r);


    }

    function form_recurso()
    {

        $response[] = _titulo('Recursos');
        $response[] = form_open('', ['class' => 'frm_recurso']);
        $response[] = input_frm('mt-5', 'Nombre',
            [
                'id' => 'nombre_recurso',
                'class' => 'nombre_recurso',
                'name' => 'nombre'
            ]
        );
        $response[] = input_frm('mt-5', 'Link de acceso',
            [
                'id' => 'link_recurso',
                'class' => 'link_recurso',
                'name' => 'urlpaginaweb'
            ]
        );
        $response[] = hiddens(['id' => 'id_recurso', 'name' => 'id']);
        $response[] = btn('modificar', ['class' => 'mt-5']);
        $response[] = form_close();
        return d($response, 6, 1);


    }

    function get_format_info_usuario()
    {


        $link_miembros = tab(
            text_icon("fa fa-trophy", "Miembros activos"),
            "#tab_usuarios_activos",
            [
                "class" => "equipo_enid_service",
                "id" => '1'
            ]
        );

        $link_bajas = tab(
            text_icon("fa fa-chevron-circle-down", "Bajas"),
            "#tab_usuarios_baja",
            [
                "class" => "btn_solo_llamar_despues equipo_enid_service",
                "id" => '0'
            ]
        );

        $l = [
            li(
                $link_miembros,
                [
                    "class" => "active",
                    "id" => "1"
                ]
            ),
            li(
                $link_bajas
            )
        ];


        $response[] = _titulo("Equipo Enid Service");
        $response[] = ul($l, "nav nav-tabs mb-5 mt-5");

        $contenido[] = tab(
            btn("Agregar", ['class' => 'col-sm-3'], 1),
            "#tab_mas_info_usuario",
            [
                "class" => "btn_nuevo_usuario "
            ]
        );

        $contenido[] = place("usuarios_enid_service");
        $response[] = tab_seccion($contenido, 'tab_usuarios_activos', 1);

        return d($response, 12);

    }


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

        $r[] = d(d($x, 6, 1), 13);
        $r[] = place("place_tallas");
        return append($r);

    }


    function get_format_categorias()
    {

        return dd(
            frm_categorias(),
            _titulo("CATEGORÍAS EN PRODUCTOS Y SERVICIOS")
            , 5
        );
    }


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


    function get_form_agregar_recurso()
    {

        $r[] = h("Agregar Recurso", 3);
        $r[] = frm_recurso();
        return append($r);

    }


    function frm_recurso()
    {

        $r[] = form_open("", ["class" => "form_recurso", "id" => 'form_recurso']);
        $r[] = input_frm(6, "Nombre",
            [
                "type" => "text",
                "name" => "nombre",
                "class" => "form-control",
                "id" => "nombre_recurso",
                "required" => "true"
            ]
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


    function get_menu($in_session)
    {


        $link_equipo = tab(
            text_icon("fa fa-space-shuttle", 'EQUIPO  ENID  SERVICE')
            ,
            "#tab1"
            ,
            [
                "id" => 'tab_equipo_enid_service',
                "class" => 'tab_equipo_enid_service',
            ]
        );

        $link_afiliados = tab(
            text_icon("fa fa-handshake-o", "AFILIADOS"),
            "#tab_productividad_ventas",
            [
                "id" => 'tab_afiliados',
                "class" => 'tab_afiliados btn_ventas_mes_usuario',

            ]

        );

        $link_perfiles_permisos = tab(

            text_icon("fa fa-unlock-alt", "PERFILES / PERMISOS "),
            "#tab_perfiles_permisos",
            [
                "id" => 'tab_perfiles',
                "class" => 'perfiles_permisos',
            ]

        );


        $link_categorias = tab(
            text_icon("fa fa-circle", "CATEGORÍAS / SERVICIOS"),
            "#tab_agregar_categorias",
            [
                "id" => 'agregar_categorias',
                "class" => 'tab_agregar_categorias',
            ]
        );


        $link_tallas = tab(

            text_icon("fa fa-percent", "TALLAS"),
            "#agregar_tallas",
            [
                "id" => 'agregar_tallas_menu',
                "class" => 'agregar_tallas',
            ]
        );


        $list = [
            $link_equipo,
            $link_afiliados,
            $link_perfiles_permisos,
            $link_categorias,
            $link_tallas
        ];
        return ul($list, ["class" => "nav tabs"]);

    }

}
