<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('../librerias/google-translate/vendor/autoload.php');

use Statickidz\GoogleTranslate;

class Home extends CI_Controller
{
    public $options;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("producto");
        $this->load->library(lib_def());
    }

    function index()
    {
        $param = $this->input->get();
        $id_producto = $this->input->get("producto");
        evita_basura($id_producto);
        $method = $_SERVER['REQUEST_METHOD'];
        if (ctype_digit($id_producto)) {

            $link = _text('../', path_enid('producto', $id_producto));
            $this->producto($param, $method, $link);

        } else {

            $id_recibo = $this->input->get("recibo");
            $this->recibo($id_recibo, $method);

        }
    }

    function recibo($id_recibo, $method)
    {

        if ($method == "POST" && ctype_digit($id_recibo)) {

            $this->view_recibo_registrado();

        } else {

            redirect(
                "https://www.google.com/", "refresh", 302);
        }

    }

    function producto($param, $method, $link)
    {
        if (array_key_exists("pre", $param)) {

            if ($method == "POST") {

                $this->load_pre($param);

            } else {

                redirect($link);
            }

        } else {

            $this->load_servicio($param);

        }
    }

    function load_pre()
    {

        $session = $this->app->session();
        $data = $this->app->cssJs($session, "producto_pre");
        $data["id_servicio"] = $this->input->get("producto");
        $data["proceso_compra"] = 1;
        $param = $this->input->post();
        $path_servicio = get_img_serv(
            $this->app->imgs_productos($param["id_servicio"], 1, 1));
        $data += [
            "id_servicio" => $param["id_servicio"],
            "extension_dominio" => $param["extension_dominio"],
            "ciclo_facturacion" => $param["ciclo_facturacion"],
            "is_servicio" => $param["is_servicio"],
            "q2" => $param["q2"],
            "num_ciclos" => $param["num_ciclos"],
            "orden_pedido" => 1,
            "carro_compras" => prm_def($data, "carro_compras"),
            "id_carro_compras" => prm_def($data, "id_carro_compras"),
            "url_imagen_servicio" => $path_servicio

        ];

        $data['footer_visible'] = false;
        $this->app->pagina($data, render_tipo_entrega($data), 1);

    }

    private function load_servicio($param)
    {
        $id_servicio = prm_def($param, "producto", 0, 1);
        $this->set_option("id_servicio", $id_servicio);
        $data = $this->app->session();

        $data["proceso_compra"] = (!$data["in_session"]) ? prm_def($param, "proceso") : 1;

        if ($id_servicio < 1) {

            $this->app->pagina($data, no_encontrado());

        } else {

            $data["desde_valoracion"] = prm_def($param, "valoracion");
            $this->vista($param, $data);
        }
    }

    private function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    private function vista($param, $data)
    {


        $id_servicio = $this->get_option("id_servicio");
        $data["q2"] = prm_def($param, "q2");
        $servicio = $this->app->servicio($id_servicio);

        $data["tallas"] = $this->get_tallas($id_servicio);
        $path = path_enid("go_home");
        $id_usuario = pr($servicio, "id_usuario");

        $usuario = (es_data($servicio)) ? $this->app->usuario($id_usuario) : redirect($path);
        $redirect = (!es_data($usuario)) ? redirect($path) : "";
        $data["usuario"] = $usuario;
        $data["id_publicador"] = key_exists_bi($servicio, 0, "id_usuario", 0);

        $this->set_option("servicio", $servicio);

        $data["info_servicio"]["servicio"] = $servicio;
        $data["costo_envio"] = "";
        $data["tiempo_entrega"] = "";
        $data["ciclos"] = "";

        if (pr($servicio, "flag_servicio") == 0) {

            $data["costo_envio"] = $this->calcula_costo_envio($this->crea_data_costo_envio($servicio));
            $tiempo_promedio_entrega = $servicio[0]["tiempo_promedio_entrega"];
            $data["tiempo_entrega"] = $this->valida_tiempo_entrega($servicio, $tiempo_promedio_entrega);
        }

        $this->set_option("flag_precio_definido", 0);
        $data["imgs"] = $this->app->imgs_productos($id_servicio, 1, 10);
        $this->set_option(
            "meta_keywords", costruye_meta_keyword($servicio)
        );

        $data["meta_keywords"] = $this->get_option("meta_keywords");
        $this->descripcion($servicio);
        $this->crea_historico_vista_servicio($id_servicio);
        $data["url_actual"] = get_url_request("");
        $data["meta_keywords"] = $this->get_option("meta_keywords");

        if (es_data($data["imgs"])) {
            $nombre_imagen = pr($data["imgs"], "nombre_imagen");
            $data["url_img_post"] = url_post($nombre_imagen);
        }

        $data["desc_web"] = $this->get_option("desc_web");
        $data["id_servicio"] = $id_servicio;
        $data["existencia"] = $this->get_existencia($id_servicio);

        $data = $this->app->cssJs($data, "producto");
        $this->app->pagina($data, render_producto($data), 1);

    }

    function get_option($key)
    {
        return $this->options[$key];
    }

    private function get_tallas($id_servicio)
    {

        $q =
            [
                "id" => $id_servicio,
                "v" => "1",
                "id_servicio" => $id_servicio

            ];
        return $this->app->api("servicio/talla/format/json/", $q);
    }

    private function calcula_costo_envio($q)
    {
        return $this->app->api("cobranza/calcula_costo_envio/format/json/", $q);
    }

    function crea_data_costo_envio($servicio)
    {

        $param["flag_envio_gratis"] = (
        es_data($servicio)) ? pr($servicio, "flag_envio_gratis") : 0;
        return $param;
    }

    private function valida_tiempo_entrega($servicio, $tiempo)
    {


        $muestra_fecha_disponible = pr($servicio, 'muestra_fecha_disponible');
        $fecha_disponible = pr($servicio, 'fecha_disponible');
        $fecha_disponible_stock = new DateTime($fecha_disponible);
        $es_posible_punto_encuentro = pr($servicio, 'es_posible_punto_encuentro');


        $fecha = horario_enid();

        $hoy = $fecha->format('H:i:s');


        $es_proxima_fecha = ($fecha_disponible_stock > $fecha);

        $text = "Realiza tu pedido antes de las 6 PM y tenlo hoy mismo!";
        $mas_un_dia = "Realiza tu pedido y tenlo mañana mismo!";
        $str = ($hoy < 18) ? $text : $mas_un_dia;

        $text_proxima_fecha = d(_text_(
            "Ups! lo tendremos disponible el",
            format_fecha($fecha_disponible),
            'Pero ... no te preocupes puedes agendar ya mismo tu entrega'
        ), 'bg-warning strong p-1');
        $str = ($muestra_fecha_disponible > 0 && $es_proxima_fecha) ? $text_proxima_fecha : $str;


        $response[] = d($str, "text-uppercase mt-5 ");
        $opciones_compra =  ($es_posible_punto_encuentro > 0) ? 'Tienes una de dos' : '';
        $response[] = d(_titulo($opciones_compra, 4), 'mt-5 text-center');
        return append($response);
    }

    private function descripcion($servicio)
    {

        if (es_data($servicio)) {

            $servicio = $servicio[0];
            $nombre_servicio = $servicio["nombre_servicio"];
            $descripcion = $servicio["descripcion"];
            $precio_unidad = ($this->get_option("flag_precio_definido") > 0) ? $this->get_option("precio_unidad") . " MXN " : "";

            $text = _text(
                $nombre_servicio,
                " ",
                $precio_unidad,
                " ",
                $descripcion
            );
            $this->set_option("desc_web", strip_tags($text));
        }
    }

    private function crea_historico_vista_servicio($id_servicio)
    {

        $this->app->api("servicio/visitas",
            [
                "id_servicio" => $id_servicio
            ],
            'json',
            'PUT'
        );
    }

    private function get_existencia($id_servicio)
    {
        $q["id_servicio"] = $id_servicio;
        $api = "servicio/existencia/format/json/";
        return $this->app->api($api, $q);
    }

    function view_recibo_registrado()
    {

        $data = $this->app->session();
        $param = $this->input->get();
        $data +=
            [
                "meta_keywords" => "",
                "desc_web" => "",
                "url_img_post" => "",
                "id_servicio" => $param["servicio"],
                "recibo" => $param["recibo"],
                "proceso_compra" => 1,
                "orden_pedido" => 0,

            ];

        $this->app->pagina($this->app->cssJs($data, "producto_recibo_registrado"), render_tipo_entrega($data));

    }
}
