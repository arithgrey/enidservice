<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    public $options;
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("search");
        $this->load->library(lib_def());
        $this->id_usuario = $this->principal->get_session("idusuario");
    }

    function index()
    {

        $param = $this->input->get();
        $param += [

            "id_clasificacion" => get_param_def($param, "q2"),
            "vendedor" => get_param_def($param, "q3"),
            "num_hist" => 9990890

        ];

        evita_basura(get_param_def($param, "q", "", 1));

        $this->load_data($param);
    }

    private function load_data($param)
    {


        $data = $this->principal->val_session(
            "",
            "Comprar y vender tus artículos y servicios",
            "",
            create_url_preview("promo.png")
        );

        $q = (array_key_exists("q", $param)) ? $param["q"] : "";
        $per_page = 20;

        $data_send = [

            "q" => $q,
            "vendedor" => $param["vendedor"],
            "id_clasificacion" => $param["id_clasificacion"],
            "extra" => $param,
            "order" => get_param_def($param, "order", 11, 1),
            "resultados_por_pagina" => $per_page,
            "agrega_clasificaciones" => ($this->agent->is_mobile()) ? 0 : 1,
            "in_session" => 0
        ];


        $data["servicios"] = $servicios = $this->busqueda_producto_por_palabra_clave($data_send);

        $fn = (array_key_exists("num_servicios", $servicios) && $servicios["num_servicios"] > 0) ?
            $this->muetra_servicios($data, $param, $q, $data_send, $servicios, $per_page) :
            $this->muestra_sin_resultados($param, $data);


    }

    private function muestra_sin_resultados($param, $data)
    {

        $data["css"] = ["search_sin_encontrar.css"];
        $response = (get_param_def($param, "tienda") < 1) ? get_format_sin_resultados() : get_format_sin_resultados_tienda();
        $this->principal->show_data_page($data, $response, 1);

    }

    private function muetra_servicios($data, $param, $q, $data_send, $servicios, $per_page)
    {

        $data["url_request"] = get_url_request("");
        $totales_elementos = (array_key_exists("servicios", $data_send) && array_key_exists("num_servicios", $data["servicios"])) ? $data["servicios"]["num_servicios"] : 0;

        $data += [

            "busqueda" => $q,
            "num_servicios" => $totales_elementos,
            "bloque_busqueda" => "",
            "es_movil" => 1,
        ];


        if ($this->agent->is_mobile() == FALSE) {

            $this->crea_menu_lateral($data["servicios"]["clasificaciones_niveles"]);
            $data["bloque_busqueda"] = $this->get_option("bloque_busqueda");
            $data["es_movil"] = 0;
        }

        $npage = get_param_def($param, "page");
        $data["paginacion"] = $this->create_pagination($totales_elementos,
            $per_page,
            $q,
            $param["id_clasificacion"],
            $param["vendedor"],
            $data_send["order"],
            $npage
        );

        $this->set_option("in_session", 0);

        $data["lista_productos"] = array_map(array('home', 'agrega_vista_servicios'), $servicios["servicios"]);

        $data["q"] = $q;
        $data["categorias_destacadas"] = $this->carga_categorias_destacadas();

        $data = $this->principal->getCssJs($data, "search");
        $data["filtros"] = $this->get_orden();
        $data["order"] = $data_send["order"];
        $this->create_keyword($param);
        $this->principal->show_data_page($data, 'home');
    }

    private function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    private function get_option($key)
    {
        return $this->options[$key];
    }

    private function get_vista_servicio($servicio)
    {

        $servicio["in_session"] = 0;
        $servicio["id_usuario_actual"] = 0;
        return $this->principal->api("servicio/crea_vista_producto/format/json/", $servicio);
    }

    private function create_pagination($totales_elementos, $per_page, $q, $id_clasificacion, $vendedor, $order, $page)
    {


        $config = [

            "totales_elementos" => $totales_elementos,
            "per_page" => $per_page,
            "q" => $q,
            "q2" => $id_clasificacion,
            "q3" => $vendedor,
            "order" => $order,
            "page" => $page

        ];

        return $this->principal->create_pagination($config);
    }

    private function crea_menu_lateral($n)
    {

        $this->set_option("bloque_busqueda"
            ,
            [


                "primer_nivel" => array_map(["home", "get_bloque"], (array_key_exists("primer_nivel", $n)) ? $n["primer_nivel"] : []),
                "segundo_nivel" => array_map(["home", "get_bloque"], (array_key_exists("segundo_nivel", $n)) ? $n["segundo_nivel"] : []),
                "tercer_nivel" => array_map(["home", "get_bloque"], (array_key_exists("tercer_nivel", $n)) ? $n["tercer_nivel"] : []),
                "cuarto_nivel" => array_map(["home", "get_bloque"], (array_key_exists("cuarto_nivel", $n)) ? $n["cuarto_nivel"] : []),
                "quinto_nivel" => array_map(["home", "get_bloque"], (array_key_exists("quinto_nivel", $n)) ? $n["quinto_nivel"] : []),

            ]
        );

    }

    private function get_bloque($data)
    {

        $id = get_param_def($data, "id_clasificacion");
        return   ($id > 0) ?  $this->get_info_clasificacion($id) : [];

    }

    private function busqueda_producto_por_palabra_clave($q)
    {

        return $this->principal->api("servicio/q/format/json/", $q);
    }

    private function get_info_clasificacion($id)
    {

        $q["id_clasificacion"] = $id;
        return $this->principal->api("clasificacion/id/format/json/", $q);

    }

    private function carga_categorias_destacadas()
    {

        return $this->principal->api("clasificacion/categorias_destacadas/format/json/");
    }

    private function get_orden()
    {
        return [
            "ORDENAR POR",
            "LAS NOVEDADES PRIMERO",
            "LO MÁS VENDIDO",
            "LOS MÁS VOTADOS",
            "LOS MÁS POPULARES ",
            "PRECIO  [de mayor a menor]",
            "PRECIO  [de menor a mayor]",
            "NOMBRE DEL PRODUCTO [A-Z]",
            "NOMBRE DEL PRODUCTO [Z-A]",
            "SÓLO  SERVICIO",
            "SÓLO PRODUCTOS"
        ];

    }

    private function agrega_vista_servicios($n)
    {
        $v = $this->get_vista_servicio($n);
        return (!is_null($v)) ? $v : "";
    }

    private function create_keyword($q)
    {

        if (array_key_exists("q", $q)) {

            if ($this->id_usuario > 0) {
                $q["id_usuario"] = $this->id_usuario;
            }

            return $this->principal->api("keyword/index", $q, "json", "POST");
        }

    }

}