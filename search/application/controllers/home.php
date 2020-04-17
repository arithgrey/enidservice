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
        $param += ["num_hist" => 9990890];
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

        $data_send = [
            "q" => prm_def($param, "q", ""),
            "vendedor" => prm_def($param, "q3"),
            "id_clasificacion" => prm_def($param, "q2"),
            "extra" => $param,
            "order" => prm_def($param, "order", 11),
            "resultados_por_pagina" => 40,
            "agrega_clasificaciones" => ($this->agent->is_mobile()) ? 0 : 1,
            "in_session" => 0,
            "page" => prm_def($param, "page")

        ];


        $data["servicios"] = $this->busqueda_producto_por_palabra_clave($data_send);
        $son_servicio = prm_def($data["servicios"], "total_busqueda");
        $fn = ($son_servicio > 0) ?
            $this->servicios($data, $data_send) : $this->sin_resultados($param, $data);

    }

    private function sin_resultados($param, $data)
    {

        $data["css"] = ["search_sin_encontrar.css"];
        $this->app->pagina($data, sin_resultados($param), 1);

    }

    private function servicios($data, $data_send)
    {

        $data["url_request"] = get_url_request("");
        $total = key_exists_bi($data, "servicios", "num_servicios", 0);
        $q = $data_send['q'];
        $servicios = $data["servicios"];

        $data += [
            "busqueda" => $q,
            "num_servicios" => $total,
            "bloque_busqueda" => "",
        ];


        if (is_mobile() < 1) {

            $data["bloque_busqueda"] = $this->crea_menu_lateral($data);
        }


        $data["paginacion"] =
            $this->paginacion(
                $total,
                $data_send['resultados_por_pagina'],
                $q,
                $data_send["id_clasificacion"],
                $data_send["vendedor"],
                $data_send["order"],
                $data_send['page']
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
        $data["categorias_destacadas"] = $this->categorias_destacadas();
        $data = $this->app->cssJs($data, "search");
        $data["filtros"] = get_orden();
        $data["order"] = $data_send["order"];
        $this->create_keyword($data_send);
        $this->app->pagina($data, render_search($data), 1);
    }

    private function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    private function get_vista_servicio($servicio)
    {

        $servicio += [
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

        return [
            "primer_nivel" => $this->filter_nivel($primer, $data),
            "segundo_nivel" => $this->filter_nivel($segundo_nivel, $data),
            "tercer_nivel" => $this->filter_nivel($tercer_nivel, $data),
            "cuarto_nivel" => $this->filter_nivel($cuarto_nivel, $data),
            "quinto_nivel" => $this->filter_nivel($quinto_nivel, $data)
        ];

    }

    private function filter_nivel($nivel, $data)
    {

        $response = [];
        if (es_data($nivel) && es_data($data)) {

            foreach ($nivel as $row) {

                $i = search_bi_array($data, "id_clasificacion", $row);
                if ($i !== false) {

                    $response[] = $data[$i];
                }
            }
        }

        return $response;

    }

    private function get_bloque($data)
    {

        return prm_def($data, "id_clasificacion");
    }

    private function busqueda_producto_por_palabra_clave($q)
    {

        return $this->app->api("servicio/q/format/json/", $q);
    }

    private function get_clasificaciones($clasificaciones)
    {
        $response = [];
        if (es_data($clasificaciones)) {

            $response = $this->app->api("clasificacion/in/format/json/",
                [
                    "clasificaciones" => implode(",", $clasificaciones)
                ]
            );

        }
        return $response;
    }

    private function categorias_destacadas()
    {

        return $this->app->api("clasificacion/categorias_destacadas/format/json/");
    }

    private function create_keyword($q)
    {

        if (prm_def($q, 'q')) {

            if ($this->id_usuario > 0) {
                $q["id_usuario"] = $this->id_usuario;
            }

            return $this->app->api("keyword/index", $q, "json", "POST");
        }

    }

}