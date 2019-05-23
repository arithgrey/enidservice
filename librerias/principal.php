<?php if (!defined('BASEPATH')) exit('No permitir el acceso directo al script');

class principal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library('../../librerias/sessionclass');
    }

    function api($api, $q = [], $format = 'json', $type = 'GET', $debug = 0, $externo = 0, $b = "")
    {

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


        if ($debug == 1) {
            debug($result->response, 1);
        }
        if ($format == "json") {
            $response = $result->response;
            return json_decode($response, true);
        }

        return $result->response;
    }

    function get_session($key)
    {
        return $this->sessionclass->get_session($key);
    }

    function logout()
    {
        $this->sessionclass->logout();
    }

    function get_imagenes_productos($id_servicio, $completo = 0, $limit = 1, $path = 0, $data = [])
    {
        $response = [];
        $a = 0;
        if (count($data) > 0) {

            foreach ($data as $row) {

                $servicio = $row;
                $id = $data[$a]["id_servicio"];
                $servicio["url_img_servicio"] = $this->get_img($id, 1, 1, 1);
                $a++;
                $response[] = $servicio;
            }

        } else {

            $response = $this->get_img($id_servicio, $completo, $limit, $path);

        }
        return $response;


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

    function calcula_costo_envio($q)
    {
        $api = "cobranza/calcula_costo_envio/format/json/";
        return $this->api($api, $q);
    }

    function send_email_enid($q, $test = 0)
    {

        $api = "sender/index";
        $q["test"] = $test;
        return $this->api($api, $q, 'json', "POST", 0, 1, "msj");
    }

    function get_info_usuario($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "usuario/q/format/json/";
        return $this->api($api, $q);
    }

    function get_base_servicio($id_servicio)
    {
        $q["id_servicio"] = $id_servicio;
        $api = "servicio/base/format/json/";
        return $this->api($api, $q);
    }

    function create_pagination($q)
    {

        $api = "paginacion/create/format/json/";
        $paginacion = $this->api($api, $q);
        return $paginacion;
    }

    function crea_historico($tipo, $id_evento = 0, $id_usuario = 0, $id_empresa = 0, $id_servicio = 0)
    {
        /*
        $pagina_url 	=  	base_url(uri_string());
        $ip 			= 	$this->input->ip_address();
        $dispositivo  	= 	$this->agent->agent_string();
        $browser 		= 	$this->agent->browser().' '.$this->agent->version();
        $robot 			= 	$this->agent->robot();
        $mobile 		= 	$this->agent->mobile();
        $platform 		=  	$this->agent->platform();
        $is_browser		=  	$this->agent->is_browser();
        $is_robot 		= 	$this->agent->is_robot();
        $is_mobile 		= 	$this->agent->is_mobile();

        $table 			=	"";
        $is_robot		=  	$this->get_valor_numerico_bool($is_robot);
        $is_mobile 		=  	$this->get_valor_numerico_bool($is_mobile);


        $url_referencia = "";
        if(isset( $_SERVER['HTTP_REFERER'] ) ){
            $url_referencia  = strtolower( $_SERVER['HTTP_REFERER'] );
        }
        $flag_enid 		= 1;
        $dominio 		=  get_dominio($pagina_url);

        if ($dominio != "enidservice.com"){
            $flag_enid 	=0;
        }


        $params["q"] =  [
            "url" 				=> $pagina_url,
            "ip"				=> $ip,
            "dispositivo"		=> $dispositivo,
            "tipo"				=> $tipo ,
            "id_evento"			=> $id_evento  ,
            "id_usuario"		=> $id_usuario,
            "id_empresa"		=> $id_empresa ,
            "url_referencia" 	=> $url_referencia,
            "dominio"			=> $dominio,
            "flag_enid"			=> $flag_enid,
            "browser"			=> $browser,
            "robot"				=> $robot,
            "mobile"			=> $mobile,
            "platform"			=> $platform,
            "is_browser"		=> $is_browser,
            "is_robot"			=> $is_robot,
            "is_mobile"			=> $is_mobile,
            "id_servicio"		=> $id_servicio
        ];

        $params["q2"]=  ($is_robot ==  1)? 1 : 0;
        $api 		=  "pagina_web/index";
        $this->api($api, $params, 'json', $type='POST');
        */

    }

    function validate_user_sesssion()
    {

        if ($this->sessionclass->is_logged_in() > 0) {
            redirect(url_home());
        }
    }

    function acceso()
    {

        if ($this->sessionclass->is_logged_in() != 1) {

            $this->logout();
        }
    }

    function is_logged_in()
    {

        return $this->sessionclass->is_logged_in();

    }

    function set_userdata($session_data)
    {

        $this->sessionclass->set_userdata($session_data);

    }

    function show_data_page($data, $center_page, $pagina_base = 0)
    {


        $this->load->view("../../../view_tema/header_template", $data);
        if ($pagina_base > 0) {

            $data["page"] = $center_page;
            $this->load->view("../../../view_tema/base", $data);

        } else {

            $this->load->view($center_page, $data);
        }

        $this->load->view("../../../view_tema/footer_template", $data);

    }

    function getperfiles()
    {
        return $this->sessionclass->getperfiles();
    }

    function val_session($titulo = "", $meta_keywords = "", $desc = "", $url_img_post = "")
    {

        $data["is_mobile"] = ($this->agent->is_mobile() == FALSE) ? 0 : 1;
        $data["proceso_compra"] = 0;
        if ($this->sessionclass->is_logged_in() > 0) {

            $menu = $this->sessionclass->create_contenido_menu();
            $nombre = $this->get_session("nombre");
            $data['titulo'] = $titulo;
            $data["menu"] = $menu;
            $data["nombre"] = $nombre;
            $data["email"] = $this->get_session("email");
            $data["perfilactual"] = $this->sessionclass->get_nombre_perfil();
            $data["id_perfil"] = $this->getperfiles();
            $data["in_session"] = 1;
            $data["no_publics"] = 1;
            $data["meta_keywords"] = $meta_keywords;
            $data["url_img_post"] = "";
            $data["id_usuario"] = $this->get_session("idusuario");
            $data["id_empresa"] = $this->get_session("idempresa");
            $data["info_empresa"] = $this->get_session("info_empresa");
            $data["desc_web"] = $desc;

            return $data;

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

            return $data;
        }
    }

    function getCSSJs($data, $key)
    {

        $response = [

            "administracion_cuenta" =>
                [

                    "js" => [
                        'administracion_cuenta/principal.js',
                        'administracion_cuenta/privacidad_seguridad.js',
                        'administracion_cuenta/img.js',
                        'js/direccion.js',
                        'administracion_cuenta/sha1.js'
                    ],
                    "css" => [
                        "administracion_cuenta_principal.css",
                        "administracion_cuenta_info_usuario.css"
                    ]


                ]
            ,
            "area_cliente" =>
                [
                    "js" =>
                        [
                            'area_cliente/principal.js',
                            'area_cliente/proyectos_persona.js',
                            'area_cliente/cobranza.js',
                            'js/direccion.js',
                            "alerts/jquery-confirm.js"

                        ],

                    "css" =>
                        [
                            "css_tienda_cliente.css",
                            "valoracion.css",
                            "area_cliente.css",
                            "confirm-alert.css"
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
                            "compras.css"

                        ],
                    "js" =>
                        [
                            "compras/principal.js"

                        ],
                    "url_img_post" => create_url_preview(""),
                    "meta_keywords" => "",
                    "desc_web" => ""


                ]
            ,
            "contacto" => [

                "css" =>
                    [
                        "contact.css"

                    ],
                "url_img_post" => create_url_preview("images_1.jpg"),
                "meta_keywords" => "Solicita una llamada aquí",
                "desc_web" => "Solicita una llamada aquí"


            ]
            ,
            "contacto_proceso_compra" =>
                [

                    "css" =>
                        [

                        ],
                    "js" =>
                        [
                            "contact/proceso_compra_direccion.js"

                        ]
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
                            "contact/principal.js"

                        ]
                ]
            ,
            "desarrollo" =>
                [


                    "css" =>
                        [
                            "desarrollo_principal.css",
                            "confirm-alert.css"

                        ],
                    "js" =>
                        [

                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js",
                            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                            "js/pickers-init.js",
                            "desarrollo/principal.js",
                            "alerts/jquery-confirm.js",
                            "js/summernote.js"

                        ]
                ]
            ,
            "faq" => [

                "css" =>
                    [

                        "faqs.css",
                        "faqs_second.css"

                    ],
                "js" =>
                    [

                        "js/summernote.js",
                        "faq/principal.js"

                    ]

            ]
            ,
            "forma_pago" =>
                [

                    "css" =>
                        [
                            "formas_pago.css"

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
                            "preferencias.css"

                        ],
                    "js" =>
                        [
                            "lista_deseos/preferencias.js"

                        ]


                ],
            "lista_deseos_productos_deseados" => [
                "css" =>
                    [
                        "lista_deseos.css"

                    ],
                "js" =>
                    [
                        "lista_deseos/carro_compras.js"

                    ]

            ],
            "login" =>
                [
                    "css" =>
                        [
                            "login.css"

                        ],
                    "js" =>
                        [
                            "login/sha1.js",
                            "login/ini.js"

                        ]
                    ,
                    "url_img_post" => "promo.png"
                    ,
                    "desc_web" => "COMPRA Y VENDE EN ENID SERVICE"
                    ,
                    "meta_keywords" => "COMPRA Y VENDE ARTÍCULOS Y SERVICIOS  EN ENID SERVICE "
                    ,
                    "clasificaciones_departamentos" => ""

                ],
            "pago_oxxo" =>
                [
                    "css" =>
                        [

                            "pago_oxxo.css"
                        ],
                    "js" =>
                        [


                        ]
                    ,
                    "clasificaciones_departamentos" => ""


                ]
            ,
            "pedidos" =>
                [

                    "css" =>
                        [

                            /**"js/bootstrap-datepicker/css/datepicker-custom.css",
                             * "js/bootstrap-timepicker/css/timepicker.css",**/
                            "pedidos.css",
                            "confirm-alert.css"

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
                            "pedidos/costos_operacion.js"

                        ]
                    ,


                ]
            ,
            "pedidos_domicilios_pedidos" =>
                [
                    "css" =>
                        [

                            "bootstrap_1.min.css",
                            "pedido_domicilio.css",
                            "confirm-alert.css"

                        ],
                    "js" =>
                        [
                            "domicilio/domicilio_entrega.js",
                            "alerts/jquery-confirm.js"
                        ]
                    ,


                ]
            ,
            "pedidos_seguimiento" =>
                [
                    "css" =>
                        [

                            "seguimiento_pedido.css",
                            "confirm-alert.css"

                        ],
                    "js" =>
                        [
                            "alerts/jquery-confirm.js",
                            "pedidos/seguimiento.js"
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
                            "confirm-alert.css"

                        ],
                    "js" =>
                        [
                            'planes_servicios/principal.js',
                            'planes_servicios/img.js',
                            'js/summernote.js',
                            'alerts/jquery-confirm.js'

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
                            "valoracion.css"


                        ],
                    "js" =>
                        [
                            "pregunta/principal.js"

                        ]
                    ,
                    "meta_keywords" => '',
                    "desc_web" => "",
                    "url_img_post" => create_url_preview("formas_pago_enid.png")


                ],
            "pregunta_hechas" =>
                [
                    "css" =>
                        [

                            "pregunta_listado.css",
                            "summernote.css"


                        ],
                    "js" =>
                        [
                            "js/summernote.js",
                            "pregunta/listado.js"


                        ]
                    ,


                ]
            ,
            "pregunta_recibida" =>
                [
                    "css" =>
                        [

                            "pregunta_listado.css",
                            "summernote.css"

                        ],
                    "js" =>
                        [
                            "js/summernote.js",
                            "pregunta/listado.js"

                        ]
                    ,


                ]
            ,
            "procesar" =>
                [
                    "css" =>
                        [

                            "procesar_pago.css"

                        ],
                    "js" =>
                        [
                            "js/direccion.js",
                            'procesar/principal.js',
                            'procesar/sha1.js'

                        ]
                    ,


                ]
            ,
            "procesar_crear" =>
                [
                    "css" =>
                        [

                            'procesar_contacto.css'

                        ],
                    "js" =>
                        [
                            "js/direccion.js",
                            'procesar/principal.js',
                            'procesar/sha1.js'

                        ]
                    ,
                    "clasificaciones_departamentos" => ""

                ],
            "procesar_domicilio" =>
                [
                    "css" =>
                        [
                            "procesar_pago.css"

                        ],
                    "js" =>
                        [
                            "domicilio/direccion_pedido_registrado.js",
                            "js/direccion.js"


                        ],
                    "clasificaciones_departamentos" => ""
                ]
            ,
            "producto" =>
                [
                    "css" =>
                        [
                            "css_tienda.css",
                            "producto_principal.css",
                            "sugerencias.css",
                            "producto.css"


                        ],
                    "js" =>
                        [
                            'producto/principal.js'

                        ]
                ]
            ,
            "producto_recibo_registrado" =>
                [
                    "css" =>
                        [
                            "pre.css"


                        ],
                    "js" =>
                        [
                            "servicio/pre.js"

                        ]
                ]
            ,
            "producto_pre" =>
                [
                    "css" =>
                        [
                            "pre.css"

                        ],
                    "js" =>
                        [
                            "servicio/pre.js"

                        ]
                ]
            ,
            "puntos_medios" =>
                [
                    "css" =>
                        [
                            "puntos_encuentro.css"

                        ],
                    "js" =>
                        [
                            "login/sha1.js",
                            "puntos_medios/principal.js",
                            "js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                            "js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                            "js/bootstrap-daterangepicker/moment.min.js",
                            "js/bootstrap-daterangepicker/daterangepicker.js",
                            "js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                            "js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                            "js/pickers-init.js",


                        ]
                ]
            ,
            "recomendacion_vista" =>
                [
                    "css" =>
                        [

                            "recomendacion_principal.css"
                        ],
                    "js" =>
                        [

                            "recomendaciones/principal.js"
                        ]
                ]

            ,
            "reporte_enid" =>
                [
                    "css" =>
                        [

                            "metricas.css",
                            "lista_deseos.css",
                            "productos_solicitados.css"
                        ],
                    "js" =>
                        [

                            "repo_enid/principal.js"
                        ],
                    "clasificaciones_departamentos" => ""
                ]

            ,
            "search" =>
                [
                    "css" =>
                        [

                            "search_main.css",
                            "css_tienda.css"
                        ],
                    "js" =>
                        [

                            "search/principal.js"
                        ]
                ]

            ,
            "sobre_enid" =>
                [
                    "js" =>
                        [

                            'sobre_enid_service/principal.js'
                        ]
                    ,
                    "css" =>
                        [
                            "sobre_enid.css"
                        ]
                ]
            ,
            "tareas_complejas" =>
                [
                    "js" =>
                        [

                            base_url('application/js/principal.js'),
                            "tareas_complejas/principal.css"

                        ],
                    "css" => [

                        "tareas_complejas.css"
                    ]
                ]


            ,
            "tiempo_venta" =>
                [
                    "js" =>
                        [
                            'tiempo_entrega/principal.js'
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
                            "js/clasificaciones.js"

                        ],
                    "css" => [

                        "usuarios_enid_service_principal.css",
                        "template_card.css",


                    ]
                ]
            ,
            "valoracion" =>
                [
                    "js" =>
                        [
                            "valoracion/principal.js"
                        ],
                    "css" => [

                        "valoracion_servicio.css"

                    ]
                ]
            ,
            "movimientos" =>
                [

                    "css" =>
                        [
                            "movimientos_info.css"

                        ]

                ]
            ,
            "movimientos_general" =>
                [
                    "js" =>
                        [

                            'movimientos/principal.js',
                            'movimientos/notificaciones.js',
                            'movimientos/movimientos.js'
                        ],

                ]
            ,
            "movimientos_saldo_amigo" =>
                [
                    "js" =>
                        [
                            'movimientos/solicitud_saldo_amigo.js'

                        ],
                    "css" => [
                        "movimientos.css"

                    ]

                ]
            ,
            "movimientos_saldo_oxxo" =>
                [
                    "js" =>
                        [
                            base_url('application/js/solicitud_oxxo.js')

                        ]

                ],

            "utilidades" =>
                [

                    "js" =>
                        [
                            "js/librerias/clipboard.js",
                            "utilidades/principal.js"


                        ]

                ]
            ,
            "ventas_encuentro" =>
                [
                    "js" =>
                        [

                            "ventas_encuentro/principal.js"


                        ],
                    "css" =>
                        [
                            "timeline.css"
                        ]

                ]


        ];


        foreach ($response[$key] as $clave => $valor) {

            $data[$clave] = $valor;

        }

        return $data;

    }

}