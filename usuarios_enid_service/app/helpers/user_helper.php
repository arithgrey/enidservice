<?php

use App\View\Components\titulo;

if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
    function get_format_format_mas_vendidos($mas_vendidos, $tiendas_nicho)
    {

        $list[] = d(_titulo("Categorias públicas"), "col-sm-12 mb-5");
        $list[] =  d(
            format_link(
                "+ Nueva categoria",
                ["class" => "w-25 accion_format_mas_vendidos"]
            ),
            12
        );

        foreach ($mas_vendidos as $row) {

            $menu = $row["menu"];
            $id = $row["id"];
            $sub_menu = $row["sub_menu"];

            $flex = flex(
                _text_(span($menu, 'f11 black ml-5 strong')),
                $sub_menu,
                "flex-column",
                "",
                "ml-5 fp8"

            );
            $class = _text_(_editar_icon, "editar_mas_vendido");

            $flex_icon = flex(
                icon($class,["id" => $id])
                , $flex);
            $texto = d(
                $flex_icon,
                [
                    "class" => " border_black"
                ]
            );
            $list[] = li($texto, 'col-sm-12 mt-5');
        }
        $list[] = modal_mas_vendidos($tiendas_nicho);
        $list[] = modal_mas_vendidos_edicion();
        return append($list);
    }
    function modal_mas_vendidos($tiendas_nicho)
    {

        $response[] = d("+ Nueva categoría", "display-5  font-weight-bold col-xs-12 black");
        $tiendas =  flex("Tienda nicho", $tiendas_nicho,'flex-column mb-5','strong mb-3 mt-5');
        $response[] = d($tiendas,12);
        $response[] = d(input_frm(
            "",
            "Menu*",
            [
                "class" => "menu_categoria",
                "id" => "menu",
                "name" => "menu",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-6 mt-5");

        $response[] = d(input_frm(
            "",
            "Subtitulo",
            [
                "class" => "sub_menu",
                "id" => "sub_menu",
                "name" => "sub_menu",
                "type" => "text"
            ]
        ), "col-sm-6 mt-5");


        $response[] = d(input_frm(
            "",
            "Metakeyword",
            [
                "class" => "titulo_categoria",
                "id" => "path",
                "name" => "path",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-12 mt-5");


        $response[] = d(input_frm(
            "",
            "Titulo*",
            [
                "class" => "titulo_categoria",
                "id" => "titulo",
                "name" => "titulo",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-12 mt-5");


        $response[] = d(input_frm(
            "",
            "Sub titulo*",
            [
                "class" => "sub_titulo_categoria",
                "id" => "sub_titulo",
                "name" => "sub_titulo",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-12 mt-5");


        $response[] = d(input_frm(
            "",
            "Link video de youtube",
            [
                "class" => "link_video",
                "id" => "link_video",
                "name" => "link_video",
                "type" => "url"                
            ]
        ), "col-sm-12 mt-5");



        $response[] = d(btn("agregar"), 'col-sm-6 mt-5');

        $form[] = form_open(
            "",
            [
                "class" => "form_mas_vendido",
                "method" => "post"
            ]
        );
        $form[] = d($response, 13);
        $form[] = form_close();

        $contenido[] =  d($form, 13);

        return gb_modal($contenido, 'modal_mas_vendidos');
    }
    function modal_mas_vendidos_edicion()
    {

        $response[] = d(d("+ Nuevos datos",'border_black p-2 w-100'), "display-5 font-weight-bold col-xs-12 black mb-5");
        $response[] = d(input_frm(
            "",
            "Menu*",
            [
                "class" => "menu_categoria_edicion",
                "id" => "menu",
                "name" => "menu",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-6 mt-5");

        $response[] = d(input_frm(
            "",
            "Subtitulo",
            [
                "class" => "sub_menu_edicion",
                "id" => "sub_menu",
                "name" => "sub_menu",
                "type" => "text"
            ]
        ), "col-sm-6 mt-5");
    
        $response[] = hiddens(["name" => "id_mas_vendido", "class" => "id_mas_vendido"]);
        $response[] = d(input_frm(
            "",
            "metakeyword",
            [
                "class" => "metakeyword_edicion",
                "id" => "path",
                "name" => "path",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-12 mt-5");

        $response[] = d(input_frm(
            "",
            "Titulo*",
            [
                "class" => "titulo_categoria_edicion",
                "id" => "titulo",
                "name" => "titulo",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-12 mt-5");


        $response[] = d(input_frm(
            "",
            "Sub titulo*",
            [
                "class" => "sub_titulo_categoria",
                "id" => "sub_titulo",
                "name" => "sub_titulo",
                "type" => "text",
                "required" => true
            ]
        ), "col-sm-12 mt-5");


        $response[] = d(input_frm(
            "",
            "Link video de youtube",
            [
                "class" => "link_video_edicion",
                "id" => "link_video",
                "name" => "link_video",
                "type" => "url"                
            ]
        ), "col-sm-12 mt-5");



        $response[] = d(btn("agregar"), 'col-sm-6 mt-5');

        $form[] = form_open(
            "",
            [
                "class" => "form_mas_vendidos_edicion",
                "method" => "post"
            ]
        );
        $form[] = d($response, 13);
        $form[] = form_close();

        $contenido[] =  d($form, 13);
        $contenido[] =  d( p(_text_(
            "Tambíen puedes eliminar esta categoría",
            span("aquí",["class" => 'red_enid elimina_mas_vendido'])
    ),'ml-auto black'), "row mt-5");

        return gb_modal($contenido, 'modal_mas_vendidos_edicion');
    }

    function get_format_afiliados()
    {

        $r[] = _titulo("Miembros");
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


    function get_format_view_usuario($departamentos, $perfiles)
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
        $options[] =
            [
                "opcion" => "Lista negra",
                "val" => 3
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
        $r[] = _titulo("Agregar usuario");

        $r[] = form_open(
            "",
            [
                "class" => "form-miembro-enid-service row",
                "id" => 'form-miembro-enid-service'
            ]
        );
        $class_select = 'flex-column col-md-4 mb-3 mt-5';
        $r[] = flex(
            'Status',
            create_select(
                $options,
                "status",
                "form-control estado_usuario",
                "estado_usuario",
                "opcion",
                "val"
            ),
            $class_select,
            _strong
        );

        $menos = [3, 4, 5, 7, 8, 11, 9, 10, 12, 13, 14, 15, 16, 17, 18, 19];

        $select = create_select(
            $perfiles,
            "perfil",
            "form-control perfil",
            "perfil",
            "nombreperfil",
            "idperfil",
            0,
            0,
            0,
            "",
            $menos
        );

        $r[] = flex('perfil', $select, $class_select, _strong);

        $select_departamentos = create_select(
            $departamentos,
            "departamento",
            "form-control depto",
            "departamento",
            "nombre",
            "id_departamento"
        );

        $r[] = flex('departamento', $select_departamentos, $class_select, _strong);

        $class_select_horarios = 'flex-column col-md-3 mt-5';
        $r[] = flex(
            "Inicio de labores",
            create_select($opt, "inicio_labor", "form-control inicio_labor", "inicio_labor", "opcion", "val"),
            $class_select_horarios,
            _strong
        );

        $select_labores = create_select($opt, "fin_labor", "form-control fin_labor", "fin_labor", "opcion", "val");
        $r[] = flex(
            "Fin de labores",
            $select_labores,
            $class_select_horarios,
            _strong
        );

        $r[] = flex(
            "Turno",
            create_select(
                $opt,
                "turno",
                "form-control input-sm turno",
                "turno",
                "opcion",
                "val"
            ),
            $class_select_horarios,
            _strong
        );

        $r[] = flex(
            "Sexo",
            create_select($opt_sexo, "sexo", "form-control input-sm sexo", "sexo", "opcion", "val"),
            $class_select_horarios,
            _strong
        );

        $top = 'col-md-4 mt-5';
        $r[] = input_frm(
            'col-md-4 mt-5',
            'Nombre',
            [
                "name" => "nombre",
                "placeholder" => "Nombre",
                "class" => "nombre text-uppercase",
                "id" => "nombre",
                "type" => "text",
                "required" => true
            ],
            _text_nombre
        );

        $r[] = input_frm(
            'col-md-4 mt-5',
            'Apellido paterno',
            [
                "name" => "apellido_paterno",
                "placeholder" => "placeholder",
                "class" => "apellido_paterno text-uppercase",
                "id" => "apellido_paterno",
                "type" => "text",
                "required" => true
            ],
            _text_apellido
        );


        $r[] = input_frm(
            $top,
            "Apellido materno",
            [
                "name" => "apellido_materno",
                "placeholder" => "placeholder",
                "class" => "apellido_materno text-uppercase",
                "id" => "apellido_materno",
                "type" => "text",
                "required" => true
            ],
            _text_apellido
        );

        $r[] = input_frm(
            'col-md-6 mt-5',
            'Email',
            [
                "name" => "email",
                "placeholder" => "email",
                "class" => "email",
                "id" => "email",
                "type" => "email",
                "required" => true,
                "readonly" => true
            ],
            _text_correo
        );


        $r[] = input_frm(
            'col-md-6 mt-5',
            "Teléfono",

            [
                "type" => "tel",
                "name" => "tel_contacto",
                "class" => "tel_contacto",
                "id" => "tel_contacto"
            ],
            _text_telefono
        );


        $titulo = "¿EN QUÉ PUEDE REPARTIR?";

        $reparto_auto = a_enid(
            "AUTO",
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion auto'
                )

            ]
        );

        $confirmar = a_enid(
            "MOTO",
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion moto'
                )

            ]
        );

        $bicicleta_reparto = a_enid(
            'BICICLETA',
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion bicicleta'
                )
            ]
        );

        $pie = a_enid(
            'PIE',
            [
                "id" => 0,
                "class" => _text_(
                    'button_enid_eleccion pie'
                )
            ]
        );

        $r[] = eleccion_seleccion($titulo, $reparto_auto, $confirmar, $bicicleta_reparto, $pie);

        $r[] = hiddens(
            [
                "name" => "auto",
                "class" => "tiene_auto",
                "value" => 0
            ]
        );
        $r[] = hiddens(
            [
                "name" => "moto",
                "class" => "tiene_moto",
                "value" => 0
            ]
        );
        $r[] = hiddens(
            [
                "name" => "bicicleta",
                "class" => "tiene_bicicleta",
                "value" => 0
            ]
        );

        $r[] = hiddens(
            [
                "name" => "reparte_a_pie",
                "class" => "reparte_a_pie",
                "value" => 0
            ]
        );

        $r[] = d(btn("Registrar", ['class' => 'submit_enid borde_green']), 'col-md-12 mt-5');
        $r[] = form_close();
        $r[] = place("place_config_usuario");
        return append($r);
    }

    function get_format_view_orden($empresa)
    {

        $orden_producto = pr($empresa, "orden_producto");
        $id_empresa = pr($empresa, "id_empresa");
        $lista_orden = list_orden(get_orden(), $orden_producto);
        $texto = _titulo("Filtro principal", 5);
        $lista = flex($texto, $lista_orden, _between, "mr-3");
        $boton_cambio = btn("Modificar");
        $response[] = form_open(
            "",
            [
                "class" => "form_orden_productos",
                "method" => "post"
            ]
        );
        $response[] = hiddens(["name" => "id_empresa", "value" => $id_empresa]);
        $response[] = flex($lista, $boton_cambio, _between);
        $response[] = form_close();


        return d($response, 8, 1);
    }

    function eleccion_seleccion($titulo, $reparto_auto, $a, $b, $c, $ext = '')
    {

        $response[] = _titulo($titulo, 2);
        $contenido = [$reparto_auto, $a, $b, $c];
        $response[] = d($contenido, _text_('d-flex mt-5 justify-content-between ', $ext));
        return d($response, 'col-md-12 mt-4');
    }


    function form_recurso()
    {


        $response[] = _titulo('Recursos');
        $response[] = form_open('', ['class' => 'frm_recurso']);
        $response[] = input_frm(
            'mt-5',
            'Nombre',
            [
                'id' => 'nombre_recurso',
                'class' => 'nombre_recurso',
                'name' => 'nombre'
            ]
        );
        $response[] = input_frm(
            'mt-5',
            'Link de acceso',
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

    function get_format_info_usuario($departamentos)
    {

        $select_perfiles = create_select(
            $departamentos,
            "id_departamento",
            "id_departamento_busqueda",
            "id_departamento",
            "nombre",
            "id_departamento"
        );

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

        $agregar = tab(
            btn("Agregar"),
            "#tab_mas_info_usuario",
            [
                "class" => "btn_nuevo_usuario"
            ]
        );
        $l = [
            li(
                $link_miembros,
                [
                    "class" => "active col-md-4",
                    "id" => "1"
                ]
            ),
            li(
                $link_bajas,
                'col-md-4'
            ),
            li(
                $agregar,
                'col-md-3'
            )
        ];


        $response[] = _titulo("usuarios Enid Service");
        $response[] = ul($l, "nav nav-tabs mb-5 mt-5");
        $response[] = d(_titulo('Busqueda', 3), _mbt5);

        $input = input_frm(
            '',
            '¿a quién buscamos? Nombre, email, teléfono',
            [
                'name' => 'q',
                'id' => 'q',
                'class' => 'q nombre_usuario'
            ]
        );

        $seccion_busqueda = flex($select_perfiles, $input, "", "col-md-4", "col-md-8");
        $response[] = d($seccion_busqueda);
        $contenido[] = place("usuarios_enid_service mt-5");
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
            _titulo("CATEGORÍAS EN PRODUCTOS Y SERVICIOS"),
            5
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
        $r[] = input_frm(
            6,
            "Nombre",
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
            ]),
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
            text_icon("fa fa-space-shuttle", 'EQUIPO  ENID  SERVICE'),
            "#tab1",
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

        $link_orden = tab(
            text_icon("fa fa-circle", "ORDEN EN PÁGINA"),
            "#tab_orden",
            [
                "id" => 'orden_web',
                "class" => 'orden_web',
            ]
        );

        $link_mas_vendidos = tab(
            text_icon("fa fa-circle", "Más vendidos"),
            "#tab_mas_vendidos",
            [
                "id" => 'mas_vendidos',
                "class" => 'mas_vendidos',
            ]
        );

        $list = [
            $link_equipo,
            $link_afiliados,
            $link_perfiles_permisos,
            $link_categorias,
            $link_tallas,
            $link_orden,
            $link_mas_vendidos
        ];
        return ul($list, ["class" => "nav tabs"]);
    }
}
