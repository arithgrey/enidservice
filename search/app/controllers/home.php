<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use Enid\Paths\Paths  as Paths;

class Home extends CI_Controller
{
    public $options;
    private $id_usuario;
    private $servicio_imagen;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("search");
        $this->load->library(lib_def());
        $this->servicio_imagen = new Enid\ServicioImagen\Format();
        $this->id_usuario = $this->app->get_session("id_usuario");
        $this->paths = new Paths();
    }

    function index()
    {

        $param = $this->input->get();
        $data = $this->app->session();
        $orden = $this->orden($param, $data);

        $pagina = prm_def($param, "page");
        $is_mobile = $data["is_mobile"];

        $q = prm_def($param, "q", "");
        $data_send = [
            "q" => $q,
            "vendedor" => prm_def($param, "q3"),
            "id_clasificacion" => prm_def($param, "q2"),
            "extra" => $param,
            "order" => $orden,
            "resultados_por_pagina" => 50,
            "agrega_clasificaciones" => (!$is_mobile),
            "in_session" => 0,
            "page" => $pagina,
            "es_sorteo" => 0,
            "resultados" => prm_def($param, "resultados"),
            "id_nicho" => $this->app->get_nicho(),

        ];

        $data["es_sorteo"] = 0;
        $data["servicios"] = $this->app->api("servicio/q", $data_send);


        $son_servicio = prm_def($data["servicios"], "total_busqueda");

        

        if ($son_servicio > 0) {
            $data["busqueda_paginas"] = $this->paths->busqueda($data, $q);
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
        $q = prm_def($param, "q", "");
        $data["busqueda_paginas"] = $this->paths->busqueda($data, $q);

        $this->app->pagina($data, sin_resultados($data, $param), 1);
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


        $data["lista_productos"] = $this->servicio_imagen->formato_servicio($servicios["servicios"]);
        $data["q"] = $q;
        $data = $this->app->cssJs($data, "search");
        $data["order"] = $data_send["order"];
        $this->create_keyword($data_send);
        $this->app->pagina($data, render_search($data), 1);
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
