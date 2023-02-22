<?php

namespace Enid\Paths;

class Paths
{

    public static function getcSSJs()
    {
        /*Debe extraerse desde base de datos en el futuro */
        $puntuacion = [
            "css" => [
                "puntuacion.css",

            ],
            "js" => [
                "principal.js"
            ]
        ];

        $sobre_ventas = [
            "css" => [
                "sobre_vender.css"
            ],
            "js" => [
                "sobre_ventas/principal.js"
            ],
            "meta_keywords" => "CONSIGUE 10% DE GANANCIA POR CADA PEDIDO QUE REFERENCIES",
            "desc_web" => "Inicia tu negocio, vendiendo artículos deportivos",
            "url_img_post" => create_url_preview("comisionistas.png"),
            "pagina" => 5,

        ];
        
        $cambios_devoluciones = [
            "css" => [

            ],
            "js" => [

            ],
            "meta_keywords" => "Cambios y devoluciones Enid Service",
            "desc_web" => "Cambios y devoluciones Enid Service",            
            "pagina" => 54,

        ];
        


        $promesa_venta = [
            "css" => [
                
            ],
            "js" => [
                "promesa_ventas/principal.js"
            ]
        ];

        $sorteo = [
            "css" => [
                "confirm-alert.css",  
            ],
            "js" => [
                "sorteo/principal.js",
                "alerts/jquery-confirm.js",
            ]
        ];
        $sorteo_venta = [
            "css" => [
                "confirm-alert.css",  
            ],
            "js" => [
                "sorteo/venta.js",
                "alerts/jquery-confirm.js",
            ]
        ];



        $response = [            
            "cambios_devoluciones" => $cambios_devoluciones,
            "promesa_ventas" => $promesa_venta,
            "puntuacion" => $puntuacion,
            "sobre_ventas" => $sobre_ventas,
            "sorteo" => $sorteo,
            "sorteo_venta" => $sorteo_venta,
            "usuario_contacto" => [
                "css" => [
                    "usuario_contacto.css",
                    "pedidos.css"
                ],
                "js" => [
                    "usuario_contacto/principal.js"
                ],
                "pagina" => 11,
            ],
            "competencias" => [
                "css" => [
                    "competencias.css"
                ],
                "pagina" => 12,
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
                'css' => [],
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


            ],  
            "area_cliente" =>
            [
                "js" =>
                [
                    
                    "area_cliente/checkout.js"

                ],
                "js_extra_web" => [
                    "https://js.stripe.com/v3/"
                ],
                "css" =>
                [
                    "checkout.css"
                ],
                "meta_keywords" => "",
                "desc_web" => "",
                "url_img_post" => "",
                "pagina" => 25,
            ],
            "garantias" => 
            [
                "js" =>
                [
                    'garantia/principal.js',
                    "alerts/jquery-confirm.js",

                ],

                "css" =>
                [                    
                    "confirm-alert.css",
                ],
                "meta_keywords" => "",
                "desc_web" => "",
                "url_img_post" => "",                

            ],
            "simulador" => 
            [
                "js" =>
                [
                    'simulador/principal.js',
                    "alerts/jquery-confirm.js",

                ],

                "css" =>
                [                    
                    "confirm-alert.css",
                ],
                "meta_keywords" => "",
                "desc_web" => "Calcula cuantos artículos debes vender para llegar a tus metas",
                "url_img_post" => "",                

            ],


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
                "pagina" => 9,
            ],
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

            ],
            "contacto" => [

                "css" =>
                [
                    "contact.css",
                ],
                "url_img_post" => create_url_preview("images_1.jpg"),
                "meta_keywords" => "Solicita una llamada aquí",
                "desc_web" => "Solicita una llamada aquí",


            ],
            "contacto_proceso_compra" =>
            [

                "css" =>
                [],
                "js" =>
                [
                    "contact/proceso_compra_direccion.js",

                ],
            ],
            "contacto_ubicacion" =>
            [


                "css" =>
                [],
                "js" =>
                [

                    "login/sha1.js",
                    "contact/principal.js",

                ],
            ],
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

            ],
            "propuestas" => [
                "css" =>
                [
                    "summernote.css",
                    "confirm-alert.css"
                ],
                "js" => [
                    'propuestas/principal.js',
                    "js/summernote.js",
                    "alerts/jquery-confirm.js",
                ],

            ],
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

            ],
            "cambios_devoluciones" => [
                "js" =>
                [
                  
                    "cambios/principal.js",
                ],
            ],
            "forma_pago" =>
            [
                "js" =>
                [
                  
                    "forma_pago/principal.js",
                ],
                "css" =>
                [
                    "formas_pago.css",                    

                ],
                "meta_keywords" => "",
                "desc_web" => "Formas de pago Enid Service",
                "url_img_post" => create_url_preview("formas_pago_enid.png"),
                "titulo" => 'Formas de pago Enid Service',
                "pagina" => 53
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
                "titulo" => 'Lista de deseos enid service',
                "url_img_post" => create_url_preview(""),
                "meta_keywords" => "",


            ],
            "recompensa" =>
            [
                "css" =>
                [
                    "recompensa.css",
                    "confirm-alert.css",
                ],
                "js" =>
                [

                    "recompensa/principal.js",
                    "alerts/jquery-confirm.js",

                ],
                "pagina" => 21

            ],

            "lista_deseos_productos_deseados" => [
                "css" =>
                [
                    "lista_deseos.css",

                ],
                "js" =>
                [
                    "lista_deseos/carro_compras.js",

                ],
                "titulo" => 'Lista de deseos enid service',
                "url_img_post" => create_url_preview(""),
                "meta_keywords" => "",
                "desc_web" => "",
                "pagina" =>  6


            ],
            "rastrea_paquete" => [
                "css" =>
                [
                  

                ],
                "js" =>
                [
                  

                ],
                "pagina" =>  52
            ]
            ,
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

                ],
                "url_img_post" => "promo.png",
                "desc_web" => "kits de pesas,seguros para mancueras y equipo deportivo pago contra entrega a domicilio en Ciudad de México",
                "meta_keywords" => "Pesas, pago contra entrega, cdmx, envios,barra, barra z, barra romana, bancos de posiciones",                
                "titulo" => "",
                "pagina" => 4

            ],
            "pago_oxxo" =>
            [
                "css" =>
                [

                    "pago_oxxo.css",
                ],
                "js" =>
                [],
                "clasificaciones_departamentos" => "",
                "pagina" => 26
            ],
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

                ],
            ],

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
                ],


            ],
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
            ],
            "costo_entrega" =>
            [
                "css" => [
                    "search_sin_encontrar.css"

                ],
                "js" => [
                    'costo_entrega/principal.js',                    
                ]
            ],
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
            ],
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

                ],
            ],

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
                ],

            ],
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
                ],
                "pagina" => 10,


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
                ],
            ],
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

                ],
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
                ],

            ],
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

                ],


            ],
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
                ],
                "pagina" => 7,
                "meta_keywords" => "",
                'desc_web' => 'Comprar tus articulos deportivos a domicilio y paga a tu entrega en CDMX',
                'titulo' => 'Comprar tus articulos deportivos a domicilio y paga a tu entrega en CDMX',
                'url_img_post' => ''

            ],
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

                ],
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
                "pagina" => 7,
            ],
            "producto" =>
            [
                "css" =>
                [
                    "css_tienda.css",
                    "confirm-alert.css",                    

                ],
                "js" =>
                [
                    'producto/principal.js',
                    "alerts/jquery-confirm.js",

                ]                
            ],
            "producto_metricas" =>
            [
                "css" =>
                [
                    "css_tienda.css",
                ],
                "js" =>
                [
                    "producto/metricas.js"
                ]
            ],

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
            ],
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
            ],
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
            ],
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
                "pagina" => 24,
            ],
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
                "pagina" => 8,
            ],
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
                "url_img_post" => create_url_preview("pesas.jpg"),
                "meta_keywords" => "",
                'desc_web' => 'Comprar tus articulos deportivos a domicilio y paga a tu entrega en CDMX',
                'titulo' => 'Comprar tus articulos deportivos a domicilio y paga a tu entrega en CDMX',
                'pagina' => 2
            ],
            "sobre_enid" =>
            [
                "js" =>
                [

                    'sobre_enid_service/principal.js',
                ],
                "css" =>
                [
                    "sobre_enid.css",
                ],
            ],
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
            ],
            "tiempo_venta" =>
            [
                "js" =>
                [
                    'tiempo_entrega/principal.js',
                ],
            ],
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
            ],
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
            ],
            "valoracion" =>
            [
                "js" =>
                [
                    "valoracion/principal.js",
                ],
                "css" => [

                    "valoracion_servicio.css",

                ],
                "pagina" => 23
            ],
            "movimientos" =>
            [

                "css" =>
                [
                    "movimientos_info.css",

                ],

            ],
            "movimientos_general" =>
            [
                "js" =>
                [

                    'movimientos/principal.js',
                    'movimientos/movimientos.js',
                ],

            ],
            "movimientos_saldo_amigo" =>
            [
                "js" =>
                [
                    'movimientos/solicitud_saldo_amigo.js',

                ],
                "css" => [
                    "movimientos.css",

                ],

            ],
            "utilidades" =>
            [

                "js" =>
                [
                    "js/librerias/clipboard.js",
                    "utilidades/principal.js",


                ],

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
                [],
                "css" =>
                [

                    "metricas_recursos.css"
                ],
            ],
            "metricas_registros" =>
            [
                "js" =>
                [],
                "css" =>
                [],
            ],
            "reventa" =>
            [
                "js" =>
                [],
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
                "js" => ["vinculo/principal.js"],
                [],
                "css" =>
                [],

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
                "pagina" => 9,

            ],
            "sin_encontrar" => [

                "js" =>
                [
                    "sin_encontrar/principal.js",
                ],
                "css" =>
                [
                    "search_sin_encontrar.css"
                ]

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
