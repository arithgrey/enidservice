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
        $this->id_usuario = $this->app->get_session("idusuario");
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


        $data = $this->app->session(
            "",
            "Comprar y vender tus artículos y servicios",
            "",
            create_url_preview("promo.png")
        );

        $q = (array_key_exists("q", $param)) ? $param["q"] : "";
        $per_page = 16;

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

        $fn = (get_param_def($servicios, "total_busqueda") > 0) ?
            $this->muetra_servicios($data, $param, $q, $data_send, $servicios, $per_page) :
            $this->muestra_sin_resultados($param, $data);


    }

    private function muestra_sin_resultados($param, $data)
    {

        $data["css"] = ["search_sin_encontrar.css"];
        $response = (get_param_def($param, "tienda") < 1) ? sin_resultados() : sin_resultados_tienda();
        $this->app->pagina($data, $response, 1);

    }

    private function muetra_servicios($data, $param, $q, $data_send, $servicios, $per_page)
    {

        $data["url_request"] = get_url_request("");
        $total = key_exists_bi($data, "servicios", "num_servicios", 0);
        $data += [
            "busqueda" => $q,
            "num_servicios" => $total,
            "bloque_busqueda" => "",
        ];

        if ($data["is_mobile"] < 1) {
            $data["bloque_busqueda"] = $this->crea_menu_lateral($data);

        }


        $data["paginacion"] =
            $this->paginacion(
                $total,
                $per_page,
                $q,
                $param["id_clasificacion"],
                $param["vendedor"],
                $data_send["order"],
                get_param_def($param, "page")
            );

        $this->set_option("in_session", 0);


        $callback = function ($n) {

            if (!is_null($n)) {
                $v = $this->get_vista_servicio($n);
                return (!is_null($v)) ? $v : "";
            }

        };

        $data["lista_productos"] = array_map($callback, $servicios["servicios"]);
        $data["q"] = $q;
        $data["categorias_destacadas"] = $this->carga_categorias_destacadas();
        $data = $this->app->cssJs($data, "search");
        $data["filtros"] = $this->get_orden();
        $data["order"] = $data_send["order"];
        $this->create_keyword($param);
        $this->app->pagina($data, render_search($data),1);
    }

    private function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    private function get_vista_servicio($servicio)
    {

        $servicio +=  [
            "in_session" => 0,
            "id_usuario_actual" => 0,
        ];
        return $this->app->api("servicio/crea_vista_producto/format/json/", $servicio);
    }


    private function paginacion($totales_elementos, $per_page, $q, $id_clasificacion, $vendedor, $order, $page)
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

        return $this->app->paginacion($config);
    }


    private function crea_menu_lateral($data)
    {

        $n = key_exists_bi($data, "servicios", "clasificaciones_niveles", []);
        $primer = array_map(["home", "get_bloque"], (array_key_exists("primer_nivel", $n)) ? $n["primer_nivel"] : []);
        $segundo_nivel = array_map(["home", "get_bloque"], (array_key_exists("segundo_nivel", $n)) ? $n["segundo_nivel"] : []);
        $tercer_nivel = array_map(["home", "get_bloque"], (array_key_exists("tercer_nivel", $n)) ? $n["tercer_nivel"] : []);
        $cuarto_nivel = array_map(["home", "get_bloque"], (array_key_exists("cuarto_nivel", $n)) ? $n["cuarto_nivel"] : []);
        $quinto_nivel = array_map(["home", "get_bloque"], (array_key_exists("quinto_nivel", $n)) ? $n["quinto_nivel"] : []);


        $clasificaciones = array_merge(
            $primer,
            $segundo_nivel,
            $tercer_nivel,
            $cuarto_nivel,
            $quinto_nivel
        );


        $data = $this->get_clasificaciones(array_unique($clasificaciones));

        $response =  [
            "primer_nivel" => $this->filter_nivel($primer, $data),
            "segundo_nivel" => $this->filter_nivel($segundo_nivel, $data),
            "tercer_nivel" => $this->filter_nivel($tercer_nivel, $data),
            "cuarto_nivel" => $this->filter_nivel($cuarto_nivel, $data),
            "quinto_nivel" => $this->filter_nivel($quinto_nivel, $data)
        ];
        return $response;
    }

    private function filter_nivel($nivel, $data)
    {

        $response = [];
        if (es_data($nivel) && es_data($data)) {

            foreach ($nivel as $row) {

                $i = search_bi_array($data, "id_clasificacion", $row);
                if ($i !== false ) {

                    $response[] = $data[$i];
                }
            }
        }

        return $response;

    }

    private function get_bloque($data)
    {

        return get_param_def($data, "id_clasificacion");
    }

    private function busqueda_producto_por_palabra_clave($q)
    {

        return $this->app->api("servicio/q/format/json/", $q);
    }

    private function get_clasificaciones($clasificaciones)
    {
        $response =  [];
        if (es_data($clasificaciones)){
            $q["clasificaciones"] =  implode("," , $clasificaciones);
            $response =  $this->app->api("clasificacion/in/format/json/", $q);

        }
        return $response;
    }

    private function carga_categorias_destacadas()
    {

        return $this->app->api("clasificacion/categorias_destacadas/format/json/");
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


    private function create_keyword($q)
    {

        if (array_key_exists("q", $q)) {

            if ($this->id_usuario > 0) {
                $q["id_usuario"] = $this->id_usuario;
            }

            return $this->app->api("keyword/index", $q, "json", "POST");
        }

    }

}