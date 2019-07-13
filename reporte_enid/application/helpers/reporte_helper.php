<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('render_reporte')) {

        function render_reporte($data)
        {


            $categorias_destacadas = $data["categorias_destacadas"];
            $response[] = d(place("place_reporte"), ["class" => "tab-pane", "id" => 'reporte']);
            $i[] = n_row_12();
            $i[] = d("INDICADORES ENID SERVICE", "titulo_enid_sm", 1);
            $i[] = form_open("", ["class" => 'form_busqueda_global_enid']);
            $i[] = get_format_fecha_busqueda();
            $i[] = form_close();
            $i[] = end_row();
            $i[] = addNRow(place("place_usabilidad top_50"));
            $response[] = d(append($i), ["class" => "tab-pane active", "id" => 'tab_default_1']);

            $ds[] = n_row_12();
            $ds[] = d("DISPOSITIVOS ", "titulo_enid_sm", 1);
            $ds[] = form_open("", ["class" => 'f_dipositivos ']);
            $ds[] = get_format_fecha_busqueda();
            $ds[] = form_close();
            $ds[] = end_row();
            $ds[] = addNRow(place("top_50 repo_dispositivos"));
            $response[] = d(append($ds), ["class" => "tab-pane", "id" => 'tab_dispositivos']);

            $v[] = n_row_12();
            $v[] = d("VISITAS WEB ", "titulo_enid_sm", 1);
            $v[] = form_open("", ["class" => 'f_usabilidad']);
            $v[] = get_format_fecha_busqueda();
            $v[] = form_close();
            $v[] = end_row();
            $v[] = place("top_50 place_usabilidad_general");

            $response[] = d(append($v), ["class" => "tab-pane", "id" => 'tab_default_2']);


            $p[] = n_row_12();
            $p[] = d("TIPOS DE ENTREGAS ", "titulo_enid_sm", 1);
            $p[] = form_open("", ["class" => 'form_tipos_entregas']);
            $p[] = get_format_fecha_busqueda();
            $p[] = form_close();
            $p[] = end_row();
            $p[] = addNRow(place("place_tipos_entregas top_50"));
            $response[] = d(append($p), ["class" => "tab-pane", "id" => 'tab_tipos_entregas']);

            $ac[] = n_row_12();
            $ac[] = d("ACTIVIDAD ", "titulo_enid_sm", 1);
            $ac[] = form_open("", ["class" => 'f_actividad_productos_usuarios ']);
            $ac[] = get_format_fecha_busqueda();
            $ac[] = form_close();
            $ac[] = end_row();
            $ac[] = addNRow(place("top_50 repo_usabilidad"));

            $response[] = d(append($ac), ["class" => "tab-pane", "id" => 'tab_usuarios']);

            $t[] = d("TAREAS RESUELTAS", "titulo_enid_sm", 1);
            $t[] = render_atencion_cliente();
            $response[] = d(append($t), ["class" => "tab-pane", "id" => "tab_atencion_cliente"]);

            $response[] = d(d("PERSONAS QUE PROMOCIONAN LOS PRODUCTOS Y SERVICIOS", "titulo_enid_sm", 1), ["class" => "tab-pane", "id" => "tab_afiliaciones"]);

            $b[] = d("PRODUCTOS MÁS BUSCADOS POR CLIENTES", "titulo_enid_sm", 1);
            $b[] = get_form_busqueda_productos_solicitados();
            $response[] = d(append($b), ["class" => "tab-pane", "id" => "tab_busqueda_productos"]);



            $dest[] = d("CATEGORÍAS DESTACADAS ", "titulo_enid_sm", 1);
            $dest[] = crea_repo_categorias_destacadas(sub_categorias_destacadas($categorias_destacadas));
            $response[] = d(append($dest), ["class" => "tab-pane", "id" => "tab_productos_publicos"]);


            $res[] = d(get_menu(), 2);
            $res[] = d(d(append($response), "tab-content"), 10);
            return d(d(append($res), 'contenedor_principal_enid_service'), "contenedor_principal_enid");

        }
    }


    if (!function_exists('render_atencion_cliente')) {

        function render_atencion_cliente()
        {

            $r[] = d(
                ul(
                    [
                        li(anchor_enid("Atención al cliente", ["href" => "#tab_1_actividad", "data-toggle" => "tab"]), ["class" => "active"]),
                        li(anchor_enid("Comparativa", ["href" => "#tab_2_comparativa", "data-toggle" => "tab"]), ["class" => "comparativa"]),
                        li(anchor_enid("Calidad y servicio", ["href" => "#tab_3_comparativa", "data-toggle" => "tab"]), ["class" => "calidad_servicio"])

                    ],
                    "nav nav-tabs"
                ), "panel-heading"
            );
            $z[] = d(get_form_busqueda_desarrollo(), ["class" => "tab-pane fade in active", "id" => "tab_1_actividad"]);
            $z[] = d(addNRow(place("place_metricas_comparativa top_50")), ["class" => "tab-pane fade", "id" => "tab_2_comparativa"]);
            $z[] = d(get_form_busqueda_desarrollo_solicitudes(), ["class" => "tab-pane fade", "id" => "tab_3_comparativa"]);

            $r[] = d(append($z), "tab-content");
            return append($r);


        }
    }


    if (!function_exists('get_form_busqueda_productos_solicitados')) {

        function get_form_busqueda_productos_solicitados()
        {


            $r[] = form_open("", ["class" => 'form_busqueda_productos_solicitados']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close();
            $z[] = addNRow(append($r));
            $z[] = addNRow(place("place_keywords top_50"));
            return append($z);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo_solicitudes')) {
        function get_form_busqueda_desarrollo_solicitudes()
        {

            $f[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
            $f[] = get_format_fecha_busqueda();
            $f[] = form_close();
            $r[] = addNRow(append($f));
            $r[] = addNRow(place("place_metricas_servicio"));
            return append($r);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo')) {
        function get_form_busqueda_desarrollo()
        {


            $f[] = form_open("", ["class" => 'form_busqueda_desarrollo']);
            $f[] = get_format_fecha_busqueda();
            $f[] = form_close();
            $r[] = addNRow(append($f));
            $r[] = addNRow(place(" top_50 place_metricas_desarrollo"));
            return append($r);

        }

    }
    if (!function_exists('crea_repo_categorias_destacadas')) {
        function crea_repo_categorias_destacadas($param)
        {
            $z = 0;
            foreach ($param as $row) {


                $total = $row["total"];

                if ($z == 0) {
                    echo "<ul class='clasificaciones_sub_menu_ul'>";
                }
                $href = path_enid("search", "/?q=&q2=" . $row["primer_nivel"]);
                echo "<table>
                  <tr>
                    " . get_td($total) . "
                    " . get_td(anchor_enid($row["nombre_clasificacion"]),
                        [
                            "href" => $href,
                            "class" => 'text_categoria_sub_menu'
                        ]
                    ) . "
                  </tr>
                  </table>";
                $z++;
                if ($z == 5) {
                    $z = 0;
                    echo "</ul>";
                }

            }
        }
    }
    if (!function_exists('get_menu')) {
        function get_menu()
        {
            $list = [
                li(anchor_enid(text_icon("fa fa-money", "PEDIDOS"),
                        [
                            "id" => "btn_servicios",
                            "href" => path_enid("pedidos"),
                            "class" => "black   dispositivos"
                        ])
                ),

                li(anchor_enid(text_icon("fa-shopping-bag", "COMPRAS"),
                        [
                            "id" => "btn_servicios",
                            "href" => path_enid("compras"),
                            "class" => "black   dispositivos"
                        ])
                ),
                li(
                    anchor_enid(text_icon('fa fa-globe', "INDICADORES"),
                        [
                            "href" => "#tab_default_1",
                            "data-toggle" => "tab",
                            "class" => 'btn_menu_tab cotizaciones black  '
                        ]
                    )
                ),
                li(
                    anchor_enid(text_icon('fa fa-clock-o', "TIEMPO DE VENTA"),
                        [
                            "href" => path_enid("tiempo_venta"),
                            "class" => ' black  '
                        ]
                    )

                ),
                li(
                    anchor_enid(text_icon('fa fa-exchange', "VENTAS PUNTOS DE ENCUENTRO"),
                        [
                            "href" => path_enid("ventas_encuentro"),
                            "class" => ' black  '
                        ]
                    ),
                    "active"
                ),
                li(
                    anchor_enid(text_icon("fa fa-shopping-cart", "PRODUCTOS SOLICITADOS"),
                        [
                            "href" => "#tab_busqueda_productos",
                            "data-toggle" => "tab",
                            "class" => 'black   btn_repo_afiliacion',
                            "id" => 'btn_repo_afiliacion'
                        ]
                    )
                ),
                li(anchor_enid(text_icon("fa fa-fighter-jet", "TIPOS ENTREGAS"),
                        [
                            "href" => "#tab_tipos_entregas",
                            "data-toggle" => "tab",
                            "class" => 'black ',
                            "id" => 'btn_repo_afiliacion'
                        ]
                    )
                ),

                li(anchor_enid(text_icon("fa fa-user", "ACTIVIDAD USUARIOS"),
                        [
                            "id" => "btn_usuarios",
                            "href" => "#tab_usuarios",
                            "data-toggle" => "tab",
                            "class" => "black   btn_repo_afiliacion"
                        ])
                ),
                li(anchor_enid(text_icon("fa-check-circle", "CATEGORÍAS DESTACADAS"),
                        [
                            "id" => "btn_repo_afiliacion",
                            "href" => "#tab_productos_publicos",
                            "data-toggle" => "tab",
                            "class" => "black   btn_repo_afiliacion"
                        ]
                    )
                ),

                li(anchor_enid(text_icon("fa fa-handshake-o", "ATENCIÓ AL CLIENTE"),
                        [
                            "id" => "btn_repo_atencion_cliente",
                            "href" => "#tab_atencion_cliente",
                            "data-toggle" => "tab",
                            "class" => "black   btn_repo_atencion_cliente"
                        ])
                ),
                li(anchor_enid(text_icon("fa fa-flag", "ACTIVIDAD"),
                        [
                            "id" => "btn_servicios",
                            "href" => "#tab_default_2",
                            "data-toggle" => "tab",
                            "class" => "black   usabilidad_btn"
                        ])
                ),
                li(anchor_enid(text_icon("fa fa-mobile", "DISPOSITIVOS"),
                        [
                            "id" => "btn_servicios",
                            "href" => "#tab_dispositivos",
                            "data-toggle" => "tab",
                            "class" => "black   dispositivos"
                        ])
                )


            ];

            return ul($list, "nav tabs");
        }

    }

}