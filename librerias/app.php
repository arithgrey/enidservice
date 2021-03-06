<?php if (!defined('BASEPATH')) {
    exit('No permitir el acceso directo al script');
}

class app extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library("session");
    }

    function imgs_productos(
        $id_servicio,
        $completo = 0,
        $limit = 1,
        $path = 0,
        $data = []
    )
    {

        if (es_data($data)) {

            $response = $this->path_imagenes($data);

        } else {

            $response = $this->get_img($id_servicio, $completo, $limit, $path);

        }

        return $response;


    }

    private function path_imagenes($data)
    {
        $response = [];
        $a = 0;
        $servicios = [];
        $servicios_path = [];
        foreach ($data as $row) {
            $id = $data[$a]["id_servicio"];
            if (!in_array($id, $servicios)) {

                $servicios[] = $id;
                $path = $this->get_img($id, 1, 1, 1);
                $servicios_path[] = [
                    'id' => $id,
                    'path' => $path
                ];
            } else {
                $path = search_bi_array($servicios_path, 'id', $id, 'path');
            }

            $row["url_img_servicio"] = $path;
            $response[] = $row;
            $a++;
        }
        return $response;
    }

    function productos_ordenes_compra($id_orden_compra)
    {

        $q = ['id' => $id_orden_compra];
        $productos_ordenes_compra = $this->api("producto_orden_compra/orden_compra/format/json/", $q);
        return $this->add_imgs_servicio($productos_ordenes_compra);

    }

    private function get_img($id_servicio, $completo = 0, $limit = 1, $path = 0)
    {

        $q["id_servicio"] = $id_servicio;
        $q["c"] = $completo;
        $q["l"] = $limit;
        $api = "imagen_servicio/servicio/format/json/";
        $response = $this->api($api, $q);
        if ($path > 0) {
            $response = get_img_serv($response);
        }

        return $response;
    }

    function api(
        $api,
        $q = [],
        $format = 'json',
        $type = 'GET',
        $debug = 0,
        $externo = 0,
        $b = ""
    )
    {

        $e = 1;

        foreach ($q as $clave => $row) {

            if (is_null($q[$clave])) {
                $q[$clave] = "";
            }
        }

        if (count($q) < 1) {
            $q["x"] = 1;
        }


        if ($externo == 0) {
            $url = "q/index.php/api/";
        } else {
            $url = $b . "/index.php/api/";
        }

        $url_request = get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', $format);
        $result = "";
        switch ($type) {
            case 'GET':
                $result = $this->restclient->get($api, $q);
                break;
            case 'PUT':
                $result = $this->restclient->put($api, $q);
                break;
            case 'POST':
                $result = $this->restclient->post($api, $q);
                break;
            case 'DELETE':
                $result = $this->restclient->delete($api, $q);
                break;
            default:
                break;
        }


        if ($debug == 1 && es_local() > 0) {

            print_r($result->response);
            debug($result->response, 1);
        }
        if ($format == "json") {

            return $this->json_decode_nice($result->response, true);

        }

        return $result->response;
    }

    public static function Utf8_ansi($valor = '')
    {

        $utf8_ansi2 = array(
            "\u00c0" => "À",
            "\u00c1" => "Á",
            "\u00c2" => "Â",
            "\u00c3" => "Ã",
            "\u00c4" => "Ä",
            "\u00c5" => "Å",
            "\u00c6" => "Æ",
            "\u00c7" => "Ç",
            "\u00c8" => "È",
            "\u00c9" => "É",
            "\u00ca" => "Ê",
            "\u00cb" => "Ë",
            "\u00cc" => "Ì",
            "\u00cd" => "Í",
            "\u00ce" => "Î",
            "\u00cf" => "Ï",
            "\u00d1" => "Ñ",
            "\u00d2" => "Ò",
            "\u00d3" => "Ó",
            "\u00d4" => "Ô",
            "\u00d5" => "Õ",
            "\u00d6" => "Ö",
            "\u00d8" => "Ø",
            "\u00d9" => "Ù",
            "\u00da" => "Ú",
            "\u00db" => "Û",
            "\u00dc" => "Ü",
            "\u00dd" => "Ý",
            "\u00df" => "ß",
            "\u00e0" => "à",
            "\u00e1" => "á",
            "\u00e2" => "â",
            "\u00e3" => "ã",
            "\u00e4" => "ä",
            "\u00e5" => "å",
            "\u00e6" => "æ",
            "\u00e7" => "ç",
            "\u00e8" => "è",
            "\u00e9" => "é",
            "\u00ea" => "ê",
            "\u00eb" => "ë",
            "\u00ec" => "ì",
            "\u00ed" => "í",
            "\u00ee" => "î",
            "\u00ef" => "ï",
            "\u00f0" => "ð",
            "\u00f1" => "ñ",
            "\u00f2" => "ò",
            "\u00f3" => "ó",
            "\u00f4" => "ô",
            "\u00f5" => "õ",
            "\u00f6" => "ö",
            "\u00f8" => "ø",
            "\u00f9" => "ù",
            "\u00fa" => "ú",
            "\u00fb" => "û",
            "\u00fc" => "ü",
            "\u00fd" => "ý",
            "\u00ff" => "ÿ");

        return strtr($valor, $utf8_ansi2);

    }


    function json_decode_nice($json, $assoc = false)
    {

        $json = $this->Utf8_ansi($json);
        $json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $json);
        $json = str_replace(array("\n", "\r"), "", $json);

        $json = preg_replace('/(,)\s*}$/', '}', $json);
        $json = preg_replace('/,\s*([\]}])/m', '$1', $json);

        return json_decode($json, $assoc);

    }


    function calcula_costo_envio($q)
    {

        return $this->api("cobranza/calcula_costo_envio/format/json/", $q);
    }

    function send_email($q, $test = 0)
    {

        $api = "sender/index";
        $q["test"] = $test;

        return $this->api($api, $q, 'json', "POST", 0, 1, "msj");
    }

    function usuario($id_usuario, $completo = 0)

    {

        $q = [
            "id_usuario" => $id_usuario,
            "c" => $completo,
        ];

        return $this->api("usuario/q/format/json/", $q);
    }

    function servicio($id_servicio, $completo = 0)
    {

        $q = [
            "id_servicio" => $id_servicio,
            "c" => $completo,
        ];

        return $this->api("servicio/base/format/json/", $q);
    }

    function empresa($id_empresa)
    {
        $q = ["id_empresa" => $id_empresa];
        return $this->api("empresa/id/format/json/", $q);
    }

    function paginacion($q)
    {

        return $this->api("paginacion/create/format/json/", $q);
    }

    function acceso()
    {

        if (!$this->is_logged_in()) {
            $this->out();
        }
    }

    function is_logged_in()
    {

        $is_logged_in = $this->session->userdata('logged_in');

        return (!isset($is_logged_in) || $is_logged_in != true) ? 0 : 1;


    }

    function out()
    {
        $this->session->unset_userdata($this->session);
        $this->session->sess_destroy();
        redirect(path_enid("_login"));
    }

    function pagina($data, $center_page, $pagina_base = 0)
    {

        $base = '../../../';
        $this->load->view(_text($base, "view_tema/header_template"), $data);
        if ($pagina_base > 0) {

            $data["page"] = $center_page;
            $this->load->view(_text($base, "view_tema/base"), $data);

        } else {

            $this->load->view($center_page, $data);
        }

        $this->load->view(_text($base, "view_tema/footer_template"), $data);

    }

    function getperfiles()
    {
        return $this->session->userdata('perfiles')[0]["idperfil"];
    }

    function session($titulo = "", $meta_keywords = "", $desc = "", $url_img_post = "")
    {

        $data["is_mobile"] = (dispositivo() === 1) ? 1 : 0;
        $data["proceso_compra"] = 0;
        $data["clasificaciones_departamentos"] = $this->get_departamentos();
        $data["footer_visible"] = true;
        if ($this->is_logged_in() > 0) {

            $session = $this->get_session();
            $nombre = $session["nombre"];
            $data['titulo'] = $titulo;
            $data["menu"] = create_contenido_menu($session);
            $data["nombre"] = $nombre;
            $data["email"] = $session["email"];
            $data["perfilactual"] = pr($session["perfildata"], "nombreperfil", "");
            $data["id_perfil"] = pr($session['perfiles'], "idperfil", "");
            $data["in_session"] = 1;
            $data["no_publics"] = 1;
            $data["meta_keywords"] = $meta_keywords;
            $data["url_img_post"] = "";
            $data["id_usuario"] = $session["idusuario"];
            $data["id_empresa"] = $session["idempresa"];
            $data["info_empresa"] = $session["info_empresa"];
            $data["desc_web"] = $desc;
            $data["data_status_enid"] = $session["data_status_enid"];

        } else {

            $data['titulo'] = $titulo;
            $data["in_session"] = 0;
            $data["id_usuario"] = "";
            $data["nombre"] = "";
            $data["email"] = "";
            $data["telefono"] = "";
            $data["id_perfil"] = 0;
            $data["meta_keywords"] = $meta_keywords;
            $data["desc_web"] = $desc;
            $data["url_img_post"] = (strlen($url_img_post) > 3) ? $url_img_post : create_url_preview("");
            $data["menu"] = "";
            $data["data_status_enid"] = "";
            $data['key_desarrollo'] = $this->config->item('key_desarrollo');


        }

        $data['restricciones'] = $this->config->item('restricciones');
        return $data;
    }

    function get_departamentos($format_html = 1)
    {

        if ($format_html == 1) {
            $api = "clasificacion/primer_nivel/format/json/";

            return $this->api($api, [], "json");
        } else {
            $api = "clasificacion/primer_nivel/format/json/";

            return $this->api($api, [], "json");
        }

    }

    function get_session($key = [])
    {

        return (is_string($key)) ? $this->session->userdata($key) : $this->session->all_userdata();

    }

    function cSSJs($data, $key = '')
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


        ];


        if (array_key_exists($key, $response)) {

            foreach ($response[$key] as $clave => $valor) {

                $data[$clave] = $valor;

            }

        } else {

            echo "NO EXISTE -> " . $key;

        }


        return $data;

    }

    function add_imgs_servicio($ordenes, $key = "id_servicio")
    {

        $a = 0;
        $response = [];
        $path_servicio = [];
        $servicios = [];
        foreach ($ordenes as $row) {

            $orden = $row;
            $id_servicio = $ordenes[$a][$key];
            if (!in_array($id_servicio, $servicios)) {
                $servicios[] = $id_servicio;
                $path = $this->imgs_productos($id_servicio, 1, 1, 1);
                $path_servicio[] = [
                    'id_servicio' => $id_servicio,
                    'path' => $path
                ];
                $orden["url_img_servicio"] = $path;

            } else {

                $path = search_bi_array($path_servicio, 'id_servicio', $id_servicio, 'path');
                $orden["url_img_servicio"] = $path;
            }

            $a++;
            $response[] = $orden;
        }

        return $response;
    }

    function session_enid()
    {

        return $this->session;

    }

    function set_userdata($newdata = array(), $newval = '')
    {

        $this->session->set_userdata($newdata, $newval);

    }

    function set_flashdata($newdata = array(), $newval = '')
    {

        $this->session->set_flashdata($newdata, $newval);
    }

    function saldos_pendientes_orden_compra($id_orden_compra)
    {

        $saldos = [];
        $productos_orden_compra = $this->productos_ordenes_compra($id_orden_compra);

        foreach ($productos_orden_compra as $row) {

            $saldos[] = $this->get_recibo_saldo_pendiente($row["id_proyecto_persona_forma_pago"]);

        }
        return $saldos;
    }

    private function get_recibo_saldo_pendiente($id_recibo)
    {

        return $this->api("recibo/saldo_pendiente_recibo/format/json/", ["id_recibo" => $id_recibo]);
    }

    function direccion($id)
    {

        return $this->api("direccion/data_direccion/format/json/", ["id_direccion" => $id]);
    }

    function get_direccion_pedido($id_recibo)
    {

        $request =
            [
                "id_recibo" => $id_recibo
            ];
        return $this->api(
            "proyecto_persona_forma_pago_direccion/recibo/format/json/", $request);

    }

    /*Recibe los productos ordenes de compra o el id de la orden de compra*/
    function domicilios_orden_compra($productos_orden_compra)
    {

        $es_data = !is_array($productos_orden_compra);
        $es_num = ($productos_orden_compra > 0);
        if ($es_data && $es_num) {
            $productos_orden_compra =
                $this->productos_ordenes_compra($productos_orden_compra);
        }
        $response = [];
        foreach ($productos_orden_compra as $row) {
            $recibo[0] = $row;
            $domicilio = $this->get_domicilio_entrega($recibo);
            if (es_data($domicilio)) {
                if (es_data($domicilio)) {

                    $response[] = $domicilio[0];

                }
            }
        }
        return $response;
    }

    function get_domicilio_entrega($producto_orden_compra)
    {

        $response = [];
        foreach ($producto_orden_compra as $row) {

            $tipo_entrega = $row["tipo_entrega"];
            $ubicacion = $row["ubicacion"];
            $id_recibo = $row["id_proyecto_persona_forma_pago"];


            switch ($tipo_entrega) {

                case 1: //Puntos encuentro
                    $response = $this->get_punto_encuentro($id_recibo);
                    break;

                case 2: //Mensajería
                    if ($ubicacion > 0) {
                        $response = $this->get_ubicacion_recibo($id_recibo);

                    } else {
                        $response = $this->get_domicilio_recibo($id_recibo);
                    }
                    break;
                default:
            }

            if (es_data($response)){


                $response[0]["tipo_entrega"] = $tipo_entrega;
                $response[0]["es_ubicacion"] = $ubicacion;

            }

        }


        return $response;

    }

    private function get_punto_encuentro($id_recibo)
    {

        $api = "proyecto_persona_forma_pago_punto_encuentro/complete/format/json/";
        return $this->api($api, ["id_recibo" => $id_recibo]);
    }

    private function get_domicilio_recibo($id_recibo)
    {

        $direccion = $this->get_direccion_pedido($id_recibo);
        $domicilio = [];

        $id_direccion = pr($direccion, "id_direccion");
        if ($id_direccion > 0) {

            $domicilio = $this->direccion($id_direccion);

        }

        return $domicilio;
    }

    private function get_ubicacion_recibo($id_recibo)
    {
        return $this->api("ubicacion/index/format/json/",
            ["id_recibo" => $id_recibo]);
    }

}
