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
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function index()
    {

        $param = $this->input->get();        
        $data = $this->app->session();
        $orden = $this->orden($param, $data);
        
        $pagina = prm_def($param, "page");
        $is_mobile = $data["is_mobile"];

        $data_send = [
            "q" => prm_def($param, "q", ""),
            "vendedor" => prm_def($param, "q3"),
            "id_clasificacion" => prm_def($param, "q2"),
            "extra" => $param,
            "order" => $orden,
            "resultados_por_pagina" => 50,
            "agrega_clasificaciones" => (!$is_mobile),
            "in_session" => 0,
            "page" => $pagina,
            "es_sorteo" => prm_def($param, "sorteo"),
            "resultados" => prm_def($param, "resultados")

        ];

        $data["es_sorteo"] = prm_def($param, "sorteo");
        $data["servicios"] = $this->app->api("servicio/q", $data_send);
        
        
        
        $son_servicio = prm_def($data["servicios"], "total_busqueda");
        if ($son_servicio > 0) {
            $this->servicios($data, $data_send);
        } else {
            $this->sin_resultados($param);
        }
        
    }

    function orden($param, $data)
    {

        $orden = prm_def($param, "order");
        $es_session = $data["in_session"];

        if ($orden < 1) {

            if ($es_session) {

                $id_usuario = $data["id_usuario"];
                $usuario = $this->app->usuario($id_usuario);
                $orden = pr($usuario, "orden_producto");
            } else {

                $empresa = $this->app->empresa(1);
                $orden = pr($empresa, "orden_producto");
            }
        }
        return $orden;
    }

    private function sin_resultados($param)
    {

        $data = $this->app->session();
        
        $data = $this->app->cssJs($data, "sin_encontrar");

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
                            
        $data["lista_productos"] = $this->formato_servicio($servicios["servicios"]);        
        $data["q"] = $q;        
        $data = $this->app->cssJs($data, "search");        
        $data["order"] = $data_send["order"];
        $this->create_keyword($data_send);        
        $this->app->pagina($data, render_search($data), 1);    
        
    }
    private function formato_servicio($servicios){
        $imagenes = $this->imagenes_por_servicios($servicios);
        
        $lista_servicios = [];
        
        foreach($servicios as $servicio){
            
            $id_servicio = $servicio["id_servicio"];
            
            $servicio["url_img_servicio"] = search_bi_array($imagenes,"id_servicio", $id_servicio,"nombre_imagen");
            $servicio["in_session"]= 0;            
            $servicio["id_usuario_actual"] = 0;
            $lista_servicios[] = create_vista($servicio);
        }
        return $lista_servicios;
        

    }
    function imagenes_por_servicios($servicios){
        
        
        $ids = array_column($servicios ,"id_servicio");
        
        return $this->app->api("imagen_servicio/ids/", ["ids" => $ids]);

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
        return $this->app->api("servicio/crea_vista_producto", $servicio);
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



    private function get_clasificaciones($clasificaciones)
    {
        $response = [];
        if (es_data($clasificaciones)) {

            $response = $this->app->api(
                "clasificacion/in",
                [
                    "clasificaciones" => implode(",", $clasificaciones)
                ]
            );
        }
        return $response;
    }

    private function categorias_destacadas()
    {

        return $this->app->api("clasificacion/categorias_destacadas");
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
