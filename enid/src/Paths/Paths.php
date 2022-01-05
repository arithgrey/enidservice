<?php

namespace Enid\Paths;

class Paths 
{

    public static function getcSSJs()
    {
            
     $response = [
            "puntuacion" => [
                "css" => [
                    "puntuacion.css",

                ],
                "js" => [
                    "principal.js"
                ]
            ],
            "sobre_ventas" => [
                "css" => [
                    "sobre_vender.css"
                ],
                "js" => [
                    "sobre_ventas/principal.js"
                ]

            ],
            "usuario_contacto" => [
                "css" => [
                    "usuario_contacto.css"
                ],
                "js" => [
                    "usuario_contacto/principal.js"
                ]
            ],
            "competencias" => [
                "css" => [
                    "competencias.css"
                ]
            ],
            "stock" => [
                'js' => [
                    "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                    "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                    "js/bootstrap-daterangepicker/moment.min.js",
                    "js/bootstrap-daterangepicker/daterangepicker.js",
                    "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                    "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                    "js/pickers-init.js",
                    'stock/principal.js'
                ],
                'css' => [

                ],
            ],
            "administracion_cuenta" =>
                [

                    "js" => [
                        'administracion_cuenta/principal.js',
                        'administracion_cuenta/privacidad_seguridad.js',
                        'administracion_cuenta/img.js',
                        'js/direccion.js',
                        'administracion_cuenta/sha1.js',
                    ],
                    "css" => [
                        "administracion_cuenta_principal.css",
                        "administracion_cuenta_info_usuario.css",
                    ],


                ]
            ,
            "area_cliente" =>
                [
                    "js" =>
                        [
                            'area_cliente/principal.js',
                            "alerts/jquery-confirm.js",

                        ],

                    "css" =>
                        [
                            "css_tienda_cliente.css",
                            "valoracion.css",
                            "area_cliente.css",
                            "confirm-alert.css",
                        ],
                    "meta_keywords" => "",
                    "desc_web" => "",
                    "url_img_post" => "",


                ]
            ,
            "saldo_pendiente" =>
                [

                    "css" =>
                        [
                            "solicitud_saldo.css",                        
                        ],
                    "js" =>
                        [
                        
                            "pendientes/cuenta.js"
                        ],
                    
                ]
            ,
            "compras" =>
                [

                    "css" =>
                        [
                            "confirm-alert.css",
                            "compras.css",

                        ],
                    "js" =>
                        [
                            "compras/principal.js",

                        ],
                    "url_img_post" => create_url_preview(""),
                    "meta_keywords" => "",
                    "desc_web" => "",

                ]
            ,
            "contacto" => [

                "css" =>
                    [
                        "contact.css",
                    ],
                "url_img_post" => create_url_preview("images_1.jpg"),
                "meta_keywords" => "Solicita una llamada aquí",
                "desc_web" => "Solicita una llamada aquí",


            ]
            ,
            "contacto_proceso_compra" =>
                [

                    "css" =>
                        [

                        ],
                    "js" =>
                        [
                            "contact/proceso_compra_direccion.js",

                        ],
                ]
            ,
            "contacto_ubicacion" =>
                [


                    "css" =>
                        [

                        ],
                    "js" =>
                        [

                            "login/sha1.js",
                            "contact/principal.js",

                        ],
                ]
            ,
            "desarrollo" =>
                [

                    "css" =>
                        [
                            "desarrollo_principal.css",
                            "confirm-alert.css",

                        ],
                    "js" =>
                        [

                            "ui/jquery-ui.js",
                            "desarrollo/principal.js",
                            "alerts/jquery-confirm.js",
                            "js/summernote.js",

                        ],

                ]
            ,
            "faq" => [

                "css" =>
                    [

                        "faqs.css",
                        "faqs_second.css",

                    ],
                "js" =>
                    [

                        "js/summernote.js",
                        "faq/principal.js",

                    ],

            ]
            ,
            "forma_pago" =>
                [

                    "css" =>
                        [
                            "formas_pago.css",

                        ],
                    "meta_keywords" => "",
                    "desc_web" => "Formas de pago Enid Service",
                    "url_img_post" => create_url_preview("formas_pago_enid.png"),
                    "clasificaciones_departamentos" => "",


                ],
            "lista_deseos_preferencias" =>
                [
                    "css" =>
                        [
                            "preferencias.css",

                        ],
                    "js" =>
                        [
                            "lista_deseos/preferencias.js",

                        ],

                ]
                ,
            "recompensa" =>
                [
                    "css" => 
                        [                            
                            "recompensa.css",
                        ],
                    "js" =>
                        [
                            
                            "recompensa/principal.js",

                        ],

                ]
                ,
            "lista_deseos_productos_deseados" => [
                "css" =>
                    [
                        "lista_deseos.css",

                    ],
                "js" =>
                    [
                        "lista_deseos/carro_compras.js",

                    ],

            ],
            "login" =>
                [
                    "css" =>
                        [
                            "login.css",

                        ],
                    "js" =>
                        [
                            "login/sha1.js",
                            "login/ini.js",

                        ]
                    ,
                    "url_img_post" => "promo.png"
                    ,
                    "desc_web" => "COMPRA Y VENDE EN ENID SERVICE"
                    ,
                    "meta_keywords" => "COMPRA Y VENDE ARTÍCULOS Y SERVICIOS  EN ENID SERVICE "
                    ,
                    "clasificaciones_departamentos" => "",

                ],
            "pago_oxxo" =>
                [
                    "css" =>
                        [

                            "pago_oxxo.css",
                        ],
                    "js" =>
                        [


                        ]
                    ,
                    "clasificaciones_departamentos" => "",


                ]
            ,
            "pedidos_busqueda" =>
                [

                    "css" =>
                        [
                            "pedidos.css",
                        ],
                    "js" =>
                        [

                            "alerts/jquery-confirm.js",
                            "pedidos/busqueda.js",

                        ]
                    ,
                ]
            ,

            "pedidos" =>
                [

                    "css" =>
                        [
                            "pedidos.css",
                            "confirm-alert.css",
                        ],
                    "js" =>
                        [

                            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                            "js/bootstrap-daterangepicker/moment.min.js",
                            "js/bootstrap-daterangepicker/daterangepicker.js",
                            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                            "js/pickers-init.js",
                            "alerts/jquery-confirm.js",
                            "pedidos/principal.js",


                        ]
                    ,


                ]
            ,
            "reparto" =>
                [
                    "css" => [
                        "reparto.css",
                        "confirm-alert.css",

                    ],
                    "js" => [
                        'reparto/principal.js',
                        "alerts/jquery-confirm.js",
                    ]
                ]
            ,
            'entregas' =>
                [
                    "css" => [
                        "entregas.css",
                        "confirm-alert.css",

                    ],
                    "js" => [
                        'entregas/principal.js',
                        "alerts/jquery-confirm.js",
                    ]
                ]
            ,
            "pedidos_costos_operacion" =>
                [

                    "css" =>
                        [
                            "confirm-alert.css",
                        ],
                    "js" =>
                        [

                            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                            "js/bootstrap-daterangepicker/moment.min.js",
                            "js/bootstrap-daterangepicker/daterangepicker.js",
                            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                            "js/pickers-init.js",
                            "alerts/jquery-confirm.js",
                            "pedidos/costos_operacion.js",

                        ]
                    ,
                ]
            ,

            "pedidos_domicilios_pedidos" =>
                [
                    "css" =>
                        [
                            "pedido_domicilio.css",
                            "confirm-alert.css",
                        ],
                    "js" =>
                        [
                            "domicilio/domicilio_entrega.js",
                            "alerts/jquery-confirm.js",
                        ]
                    ,

                ]
            ,
            "pedidos_seguimiento" =>
                [
                    "css" =>
                        [

                            "seguimiento_pedido.css",
                            "confirm-alert.css",

                        ],
                    "js" =>
                        [
                            "alerts/jquery-confirm.js",
                            "pedidos/seguimiento.js",
                        ]
                    ,


                ],
            "planes_servicios" =>
                [
                    "css" =>
                        [

                            "css_tienda.css",
                            "vender.css",
                            "planes_servicios.css",
                            "producto.css",
                            "confirm-alert.css",


                        ],
                    "js" =>
                        [
                            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                            "js/bootstrap-daterangepicker/moment.min.js",
                            "js/bootstrap-daterangepicker/daterangepicker.js",
                            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                            "js/pickers-init.js",
                            'planes_servicios/principal.js',
                            'planes_servicios/img.js',
                            "alerts/jquery-confirm.js",
                            "planes_servicios/compras.js",
                            'js/summernote.js',


                        ]
                    ,


                ]
            ,
            "pregunta" =>
                [
                    "css" =>
                        [
                            "producto.css",
                            "sugerencias.css",
                            "valoracion.css",
                        ],
                    "js" =>
                        [
                            "pregunta/principal.js",

                        ]
                    ,
                    "meta_keywords" => '',
                    "desc_web" => "",
                    "url_img_post" => create_url_preview("formas_pago_enid.png"),


                ],
            "pregunta_hechas" =>
                [
                    "css" =>
                        [

                            "pregunta_listado.css",
                            "summernote.css",


                        ],
                    "js" =>
                        [
                            "js/summernote.js",
                            "pregunta/listado.js",


                        ]
                    ,


                ]
            ,
            "pregunta_recibida" =>
                [
                    "css" =>
                        [

                            "pregunta_listado.css",
                            "summernote.css",

                        ],
                    "js" =>
                        [
                            "js/summernote.js",
                            "pregunta/listado.js",

                        ]
                    ,


                ]
            ,
            "procesar" =>
                [
                    "css" =>
                        [
                            "procesar_pago.css",
                        ],
                    "js" =>
                        [
                            "js/direccion.js",
                            'procesar/principal.js',
                            'procesar/sha1.js',
                        ]
                    ,
                ]
            ,
            "procesar_crear" =>
                [
                    "css" =>
                        [
                            'procesar_contacto.css',
                        ],
                    "js" =>
                        [
                            "js/direccion.js",
                            'procesar/principal.js',
                            'procesar/sha1.js',

                        ]
                    ,
                    "clasificaciones_departamentos" => "",

                ],
            "procesar_domicilio" =>
                [
                    "css" =>
                        [
                            "procesar_pago.css",

                        ],
                    "js" =>
                        [
                            "domicilio/direccion_pedido_registrado.js",
                            "js/direccion.js",


                        ],
                    "clasificaciones_departamentos" => "",
                ]
            ,
            "producto" =>
                [
                    "css" =>
                        [
                            "css_tienda.css",

                        ],
                    "js" =>
                        [
                            'producto/principal.js',

                        ],
                ]
            ,
            "producto_recibo_registrado" =>
                [
                    "css" =>
                        [
                            "pre.css",


                        ],
                    "js" =>
                        [
                            "servicio/pre.js",

                        ],
                ]
            ,
            "producto_pre" =>
                [
                    "css" =>
                        [
                            "pre.css",

                        ],
                    "js" =>
                        [
                            "servicio/pre.js",

                        ],
                ]
            ,
            "puntos_medios" =>
                [
                    "css" =>
                        [
                            "puntos_encuentro.css",

                        ],
                    "js" =>
                        [
                            "login/sha1.js",
                            "puntos_medios/principal.js",


                        ],
                ]
            ,
            "recomendacion_vista" =>
                [
                    "css" =>
                        [

                            "recomendacion_principal.css",
                        ],
                    "js" =>
                        [

                            "recomendaciones/principal.js",
                        ],
                ]

            ,
            "reporte_enid" =>
                [
                    "css" =>
                        [
                            "metricas.css",
                            "lista_deseos.css",
                            "productos_solicitados.css",
                        ],
                    "js" =>
                        [

                            "repo_enid/principal.js",
                            "repo_enid/map.js",
                        ],
                    "clasificaciones_departamentos" => "",
                ]

            ,
            "search" =>
                [
                    "css" =>
                        [

                            "search_main.css",
                            "css_tienda.css",
                        ],
                    "js" =>
                        [

                            "search/principal.js",
                        ],
                    "url_img_post" => create_url_preview("dispensador-rojo.jpg"),

                ]

            ,
            "sobre_enid" =>
                [
                    "js" =>
                        [

                            'sobre_enid_service/principal.js',
                        ]
                    ,
                    "css" =>
                        [
                            "sobre_enid.css",
                        ],
                ]
            ,
            "tareas_complejas" =>
                [
                    "js" =>
                        [

                            base_url('application/js/principal.js'),
                            "tareas_complejas/principal.css",

                        ],
                    "css" => [

                        "tareas_complejas.css",
                    ],
                ]


            ,
            "tiempo_venta" =>
                [
                    "js" =>
                        [
                            'tiempo_entrega/principal.js',
                        ],
                ]
            ,
            "clientes" =>
                [
                    "js" =>
                        [
                            "clientes/principal.js"
                        ],
                    "css" =>
                        [

                            "clientes.css"
                        ]
                ]


            ,
            "usuarios_enid_service" =>
                [
                    "js" =>
                        [
                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
                            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                            "js/bootstrap-daterangepicker/moment.min.js",
                            "js/bootstrap-daterangepicker/daterangepicker.js",
                            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                            "js/pickers-init.js",
                            'usuarios_enid/principal.js',
                            'usuarios_enid/notificaciones.js',
                            'usuarios_enid/categorias.js',
                            "js/clasificaciones.js",
                            "alerts/jquery-confirm.js",
                        ],
                    "css" => [
                        "confirm-alert.css",
                        "usuarios_enid_service_principal.css",
                        "template_card.css",


                    ],
                ]
            ,
            "valoracion" =>
                [
                    "js" =>
                        [
                            "valoracion/principal.js",
                        ],
                    "css" => [

                        "valoracion_servicio.css",

                    ],
                ]
            ,
            "movimientos" =>
                [

                    "css" =>
                        [
                            "movimientos_info.css",

                        ],

                ]
            ,
            "movimientos_general" =>
                [
                    "js" =>
                        [

                            'movimientos/principal.js',
                            'movimientos/movimientos.js',
                        ],

                ]
            ,
            "movimientos_saldo_amigo" =>
                [
                    "js" =>
                        [
                            'movimientos/solicitud_saldo_amigo.js',

                        ],
                    "css" => [
                        "movimientos.css",

                    ],

                ]
            ,
            "utilidades" =>
                [

                    "js" =>
                        [
                            "js/librerias/clipboard.js",
                            "utilidades/principal.js",


                        ],

                ]
            ,
            "ventas_encuentro" =>
                [
                    "js" =>
                        [

                            "ventas_encuentro/principal.js",


                        ],
                    "css" =>
                        [
                            "timeline.css",
                        ],

                ],
            "cross_selling" =>
                [
                    "js" =>
                        [
                            "cross_selling/principal.js"
                        ],
                    "css" =>
                        [],

                ],
            "top_clientes" =>
                [
                    "js" =>
                        [
                            "cross_selling/principal.js"
                        ],
                    "css" =>
                        [],

                ],
            "metricas_recursos" =>
                [
                    "js" =>
                        [

                        ],
                    "css" =>
                        [

                            "metricas_recursos.css"
                        ],
                ],
            "metricas_registros" =>
                [
                    "js" =>
                        [

                        ],
                    "css" =>
                        [


                        ],
                ],
            "reventa" =>
                [
                    "js" =>
                        [

                        ],
                    "css" =>
                        [],

                ],
            "preguntas_frecuentes" =>
                [
                    "js" =>
                        [
                            "preguntas_frecuentes/principal.js",
                            "alerts/jquery-confirm.js",
                            'js/summernote.js',
                        ],
                    "css" =>
                        [
                            "preguntas_frecuentes.css",
                            "confirm-alert.css",
                            "summernote.css",
                        ],

                ],
            "vinculo" =>
                [
                    "js" =>
                        [

                        ],
                    "css" =>
                        [
                        ],

                ],
            "busqueda" =>
                [
                    "js" =>
                        [
                            "busqueda/principal.js",
                        ],
                    "css" =>
                        [
                            "search_sin_encontrar.css",
                        ],

                ],

            "conexiones" =>
                [
                    "js" =>
                        [
                            "conexiones/principal.js",
                        ],
                    "css" =>
                        [
                            "search_sin_encontrar.css",
                        ],


                ],
            "seguidores" =>
                [
                    "js" =>
                        [
                            "seguidores/principal.js",
                            "alerts/jquery-confirm.js",
                        ],
                    "css" =>
                        [
                            "search_sin_encontrar.css",
                            "confirm-alert.css"
                        ],


                ],


        ];

        return $response;
    }

    
}