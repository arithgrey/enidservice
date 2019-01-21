<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {

        if (!function_exists('get_menu')) {
            function get_menu($id_usuario)
            {


                $final      =
                    get_url_facebook(get_url_tienda($id_usuario), 1) .
                    get_url_twitter(get_url_tienda($id_usuario), "VISITA MI TIENDA EN LÍNEA!", 1) .
                    get_url_pinterest(get_url_tienda($id_usuario), 1) .
                    get_url_tumblr(get_url_tienda($id_usuario), 1).
                    div("COMPARTIR ");


                $list = [
                    li(
                        anchor_enid(icon("fa fa-address-book-o") . "Cuenta"
                            ,
                            [
                                "href" => "#tab_mis_datos",
                                "data-toggle" => "tab",
                                "id" => 'base_tab_agendados',
                                "class" => 'black  base_tab_agendados active'
                            ]
                        )
                    ),

                    li(anchor_enid(icon("fa  fa-fighter-jet") . "Dirección de envío",
                            [
                                "href" => "#tab_direccion",
                                "data-toggle" => "tab",
                                "id" => 'btn_direccion',
                                "class" => 'black  btn_direccion'

                            ]
                        )
                    ),


                    li(anchor_enid(icon("fa fa-unlock-alt") . "Contraseña", [
                            "href" => "#tab_privacidad",
                            "data-toggle" => "tab",
                            "id" => 'base_tab_privacidad',
                            "class" => 'black  base_tab_privacidad'
                        ])
                    ),


                    li(anchor_enid(
                            icon("fa fa-shield") . "Privacidad y seguridad",
                            [
                                "href" => "#tab_privacidad_seguridad",
                                "data-toggle" => "tab",
                                "class" => 'black  tab_privacidad_seguridad'
                            ])
                    ),


                    li(anchor_enid("INTERESES Y PREFERENCIAS",
                            [
                                "class" => "btn_intereses",
                                "href" => "../lista_deseos/?q=preferencias"
                            ])
                    ),


                    li(anchor_enid("TUS PRODUCTOS EN VENTA",
                            [
                                "class" => "btn_cuenta_personal",
                                "href" => "../search/?q3=" . $id_usuario . "&tienda=1"
                            ]
                        )
                    ),

                    li(div($final, ["class" => "contenedor_compartir_redes_sociales"]))

                ];

                return ul($list);
            }
        }
}

