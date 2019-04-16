<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('get_form_busqueda_productos_solicitados')) {

        function get_form_busqueda_productos_solicitados()
        {


            $r[] = form_open("", ["class" => 'form_busqueda_productos_solicitados']);
            $r[] = get_format_fecha_busqueda();
            $r[] = form_close();
            $z[] = addNRow(append_data($r));
            $z[] = addNRow(place("place_keywords top_50"));
            return append_data($z);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo_solicitudes')) {
        function get_form_busqueda_desarrollo_solicitudes()
        {

            $f[] = form_open("", ["class" => 'form_busqueda_desarrollo_solicitudes']);
            $f[] = get_format_fecha_busqueda();
            $f[] = form_close();
            $r[] = addNRow(append_data($f));
            $r[] = addNRow(place("place_metricas_servicio"));
            return append_data($r);

        }
    }
    if (!function_exists('get_form_busqueda_desarrollo')) {
        function get_form_busqueda_desarrollo()
        {


            $f[] = form_open("", ["class" => 'form_busqueda_desarrollo']);
            $f[] = get_format_fecha_busqueda();
            $f[] = form_close();
            $r[] = addNRow(append_data($f));
            $r[] = addNRow(place(" top_50 place_metricas_desarrollo"));
            return append_data($r);

        }

    }
    if (!function_exists('crea_repo_categorias_destacadas')) {
        function crea_repo_categorias_destacadas($param)
        {
            $z = 0;
            //$data_complete = [];
            foreach ($param as $row) {

                //$primer_nivel = $row["primer_nivel"];
                $total = $row["total"];
                $nombre_clasificacion = $row["nombre_clasificacion"];

                if ($z == 0) {
                    echo "<ul class='clasificaciones_sub_menu_ul'>";
                }
                $href = "../search?q=&q2=" . $row["primer_nivel"];
                echo "<table>
                  <tr>
                    " . get_td($total) . "
                    " . get_td(anchor_enid($nombre_clasificacion),
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
                li(anchor_enid(icon("fa fa-money") . "PEDIDOS",
                        [
                            "id" => "btn_servicios",
                            "href" => "../pedidos",
                            "class" => "black   dispositivos"
                        ])
                ),

                li(anchor_enid(icon("fa-shopping-bag") . "COMPRAS",
                        [
                            "id" => "btn_servicios",
                            "href" => "../compras",
                            "class" => "black   dispositivos"
                        ])
                ),
                li(
                    anchor_enid(icon('fa fa-globe') . "INDICADORES",
                        [
                            "href" => "#tab_default_1",
                            "data-toggle" => "tab",
                            "class" => 'btn_menu_tab cotizaciones black  '
                        ]
                    ),
                    ["class" => "active"]
                ),
                li(
                    anchor_enid(icon('fa fa-clock-o') . "TIEMPO DE VENTA",
                        [
                            "href" => "../tiempo_venta/",
                            "class" => ' black  '
                        ]
                    ),
                    ["class" => "active"]
                ),
                li(
                    anchor_enid(icon("fa fa-shopping-cart") . "PRODUCTOS SOLICITADOS",
                        [
                            "href" => "#tab_busqueda_productos",
                            "data-toggle" => "tab",
                            "class" => 'black   btn_repo_afiliacion',
                            "id" => 'btn_repo_afiliacion'
                        ]
                    )
                ),
                li(anchor_enid(icon("fa fa-fighter-jet") . "TIPOS ENTREGAS",
                        [
                            "href" => "#tab_tipos_entregas",
                            "data-toggle" => "tab",
                            "class" => 'black ',
                            "id" => 'btn_repo_afiliacion'
                        ]
                    )
                ),

                li(anchor_enid(icon("fa fa-user") . "ACTIVIDAD USUARIOS",
                        [
                            "id" => "btn_usuarios",
                            "href" => "#tab_usuarios",
                            "data-toggle" => "tab",
                            "class" => "black   btn_repo_afiliacion"
                        ])
                ),
                li(anchor_enid(icon("fa-check-circle") . "CATEGORÍAS DESTACADAS",
                        [
                            "id" => "btn_repo_afiliacion",
                            "href" => "#tab_productos_publicos",
                            "data-toggle" => "tab",
                            "class" => "black   btn_repo_afiliacion"
                        ]
                    )
                ),

                li(anchor_enid(icon("fa fa-handshake-o") . "ATENCIÓ AL CLIENTE",
                        [
                            "id" => "btn_repo_atencion_cliente",
                            "href" => "#tab_atencion_cliente",
                            "data-toggle" => "tab",
                            "class" => "black   btn_repo_atencion_cliente"
                        ])
                ),
                li(anchor_enid(icon("fa fa-flag") . "ACTIVIDAD",
                        [
                            "id" => "btn_servicios",
                            "href" => "#tab_default_2",
                            "data-toggle" => "tab",
                            "class" => "black   usabilidad_btn"
                        ])
                ),
                li(anchor_enid(icon("fa fa-mobile") . "DISPOSITIVOS",
                        [
                            "id" => "btn_servicios",
                            "href" => "#tab_dispositivos",
                            "data-toggle" => "tab",
                            "class" => "black   dispositivos"
                        ])
                )


            ];

            return ul($list, ["class" => "nav tabs"]);
        }

    }

}