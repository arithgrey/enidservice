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
        evita_basura($this->input->get("producto"));
        $request_method = $_SERVER['REQUEST_METHOD'];
        if (ctype_digit(trim($this->input->get("producto")))) {

            if (array_key_exists("pre", $param)) {

                $fn = ($request_method == "POST") ? $this->load_pre($param) : redirect("../../producto/?producto=" . $this->input->get("producto"));


            } else {

                $this->load_servicio($param);

            }

        } else {

            $fn = ($request_method == "POST" && ctype_digit(trim($this->input->get("recibo")))) ? $this->view_recibo_registrado() : redirect("https://www.google.com/", "refresh", 302);


        }
    }

    function load_pre()
    {

        $data = $this->app->cssJs($this->app->session(), "producto_pre");
        $data["id_servicio"] = $this->input->get("producto");
        $data["proceso_compra"] = 1;
        $param = $this->input->post();


        $data += [
            "plan" => $param["plan"],
            "extension_dominio" => $param["extension_dominio"],
            "ciclo_facturacion" => $param["ciclo_facturacion"],
            "is_servicio" => $param["is_servicio"],
            "q2" => $param["q2"],
            "num_ciclos" => $param["num_ciclos"],
            "orden_pedido" => 1,
            "carro_compras" => prm_def($data , "carro_compras"),
            "id_carro_compras" => prm_def($data , "id_carro_compras"),
            "url_imagen_servicio" => get_img_serv($this->app->imgs_productos($param["plan"], 1, 1))

        ];

        $this->app->pagina($data, 'pre');

    }

    private function load_servicio($param)
    {


        $id_servicio = prm_def($param, "producto", 0, 1);
        $this->set_option("id_servicio", $id_servicio);
        $data = $this->app->session();
        $data["proceso_compra"] = ($data["in_session"] == 1) ? 1 : prm_def($param, "proceso");

        if ($id_servicio < 1) {

            $this->app->pagina($data, $this->get_vista_no_encontrado());

        } else {

            $data["desde_valoracion"] = prm_def($param, "valoracion");
            $this->vista($param, $data);
        }
    }

    private function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    private function get_vista_no_encontrado()
    {
        return "../../../view_tema/producto_no_encontrado";
    }

    private function vista($param, $data)
    {

        $id_servicio = $this->get_option("id_servicio");
        $data["q2"] = prm_def($param, "q2");
        $servicio = $this->app->servicio($id_servicio);
        $data["tallas"] = $this->get_tallas($id_servicio);
        $usuario =  (es_data($servicio)) ? $this->app->usuario(pr($servicio, "id_usuario")) : redirect(path_enid("go_home"));
        $fn  =   (!es_data($usuario)) ? redirect(path_enid("go_home")) : "";

        $data["usuario"] = $usuario;
        $data["id_publicador"] = key_exists_bi($servicio,0,"id_usuario",0);


        $this->set_option("servicio", $servicio);
        $data["info_servicio"]["servicio"] = $servicio;
        $data["costo_envio"] = "";
        $data["tiempo_entrega"] = "";
        $data["ciclos"] = "";

        if (pr($servicio,"flag_servicio") == 0) {

            $data["costo_envio"] = $this->calcula_costo_envio($this->crea_data_costo_envio());
            $tiempo_promedio_entrega = $servicio[0]["tiempo_promedio_entrega"];
            $data["tiempo_entrega"] = $this->valida_tiempo_entrega($tiempo_promedio_entrega);

        }

        $this->set_option("flag_precio_definido", 0);
        $data["imgs"] = $this->app->imgs_productos($id_servicio, 1, 10);
        $this->set_option("meta_keywords", costruye_meta_keyword($this->get_option("servicio")[0]));


        $data["meta_keywords"] = $this->get_option("meta_keywords");
        $this->costruye_descripcion_producto();
        $this->crea_historico_vista_servicio($id_servicio);
        $data["url_actual"] = get_url_request("");
        $data["meta_keywords"] = $this->get_option("meta_keywords");

        $data["url_img_post"] = "";
        if (es_data($data["imgs"]) > 0) {

            $data["url_img_post"] = get_url_imagen_post($data["imgs"][0]["nombre_imagen"]);
        }


        $data["desc_web"] = $this->get_option("desc_web");
        $data["id_servicio"] = $id_servicio;
        $data["existencia"] = $this->get_existencia($id_servicio);


        $data = $this->app->cssJs($data, "producto");
        $this->app->pagina($data , render_producto($data) , 1);

    }


    private function get_tallas($id_servicio)
    {
        $api = "servicio/talla/format/json/";
        $q = [
            "id" => $id_servicio,
            "v" => "1",
            "id_servicio" => $id_servicio

        ];
        return $this->app->api($api, $q);
    }

    private function calcula_costo_envio($q)
    {
        return $this->app->api("cobranza/calcula_costo_envio/format/json/", $q);
    }

    function crea_data_costo_envio()
    {

        $servicio = $this->get_option("servicio");
        $param["flag_envio_gratis"] = (es_data($servicio)) ? pr($servicio, "flag_envio_gratis") : 0;
        return $param;
    }

    function get_option($key)
    {
        return $this->options[$key];
    }

    private function valida_tiempo_entrega($tiempo)
    {
        $trans = new GoogleTranslate();
        $source = 'en';
        $target = 'es';
        $fecha = date("Y-m-d e");
        $fechaT = date("Y-m-d e");
        $fecha = new DateTime($fecha);
        $fechaTest = new DateTime($fechaT);
        $fechaTest->add(new DateInterval('P' . $tiempo . 'D'));

        if ($fechaTest->format("D") == "Sat") {
            $fecha->add(new DateInterval('P2D'));
        } else if ($fechaTest->format("D") == "Sun") {
            $fecha->add(new DateInterval('P1D'));
        } else {
            $fecha->add(new DateInterval('P' . $tiempo . 'D'));
        }

        $fecha_entrega_promedio = $fecha->format('l, d M Y');
        $fecha_entrega_promedio = $trans->translate($source, $target, strtoupper($fecha_entrega_promedio));
        $text_tiempo = span($fecha_entrega_promedio, ["class" => 'tiempo_promedio']);
        $tiempo_entrega = "REALIZA HOY TU PEDIDO Y TENLO EL" . $text_tiempo;
        return d($tiempo_entrega, "tiempo_entrega_promedio text-justify");
    }

    private function costruye_descripcion_producto()
    {

        $servicio =  $this->get_option("servicio");
        if(es_data($servicio)){

            $servicio  =  $servicio[0];
            $nombre_servicio = $servicio["nombre_servicio"];
            $descripcion = $servicio["descripcion"];
            $precio_unidad = ($this->get_option("flag_precio_definido") > 0) ? $this->get_option("precio_unidad") . " MXN " :  "";
            $text = strip_tags($nombre_servicio) . " " . strip_tags($precio_unidad) . " " . strip_tags($descripcion);
            $this->set_option("desc_web", $text);
        }
    }

    private function crea_historico_vista_servicio($id_servicio)
    {

        $q["id_servicio"] = $id_servicio;
        $this->app->api("servicio/visitas", $q, 'json', 'PUT');
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
        $data += [
            "meta_keywords" => "",
            "desc_web" => "",
            "url_img_post" => "",
            "id_servicio" => $param["servicio"],
            "recibo" => $param["recibo"],
            "proceso_compra" => 1,
            "orden_pedido" => 0,

        ];

        $this->app->pagina($this->app->cssJs($data, "producto_recibo_registrado"), 'pre');

    }
}
