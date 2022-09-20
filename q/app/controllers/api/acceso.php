<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Acceso extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("acceso_model");
        $this->load->library("table");
        $this->load->helper("accesos");
        $this->load->library(lib_def());
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "in_session,is_mobile,pagina_id,http_referer")) {


            $param["id_servicio"] =  prm_def($param, "id_servicio");
            $response = $this->acceso_model->insert($param, 1);
        }
        $this->response($response);
    }
    function q_fecha_conteo_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "pagina_id,fecha_inicio,fecha_termino")) {

            $pagina_id = $param["pagina_id"];
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];

            $response =  $this->acceso_model->conteo_fecha($pagina_id, $fecha_inicio, $fecha_termino);
        }
        $this->response($response);
    }
    function dominio_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {


            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $accesos =  $this->acceso_model->dominio($fecha_inicio, $fecha_termino);
            $accesos = $this->app->add_imgs_servicio($accesos);



            $heading = [
                "Fecha",
                "Link de referencia",
                "Página",
                "Servicio"
            ];


            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            foreach ($accesos as $row) {

                $fecha_registro = $row["fecha_registro"];
                $http_referer = $row["http_referer"];
                $pagina = $row["pagina"];
                $id_servicio = $row["id_servicio"];

                $imagen = "-";
                if ($id_servicio > 0) {

                    $imagen =
                        img(
                            [
                                "src" => $row["url_img_servicio"],
                                "class" => "img_servicio mah_150",

                            ]
                        );

                    $imagen = a_enid(
                        $imagen,
                        [
                            "href" => path_enid("producto", $id_servicio),
                            "target" => "_black",
                        ]
                    );
                }


                if (
                    substr($http_referer, 0, 28) != "https://www.enidservices.com"
                    &&
                    substr($http_referer, 0, 24) != "https://enidservices.com"
                    &&
                    substr($http_referer, 0, 23) != "http://enidservices.com"

                ) {

                    $row = [
                        $fecha_registro,
                        $http_referer,
                        $pagina,
                        $imagen
                    ];

                    $this->table->add_row($row);
                }
            }

            $response = $this->table->generate();
        }
        $this->response($response);
    }
    function dominio_dia_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {


            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $accesos =  $this->acceso_model->dominio($fecha_inicio, $fecha_termino);
            $accesos = $this->app->add_imgs_servicio($accesos);


            $response[] = $this->dominios($accesos);
            $response[] = $this->paginas($accesos);
            $response[] = $this->productos($accesos);
        }
        $this->response(append($response));
    }

    function dominios($accesos)
    {

        $dominios = array_unique(array_column($accesos, "http_referer"));
        $response[] = d("Sitios que nos mandan tráfico", "f12 black underline mt-5 mb-2 strong");
        foreach ($dominios as $row) {

            if (
                substr($row, 0, 28) != "https://www.enidservices.com"
                &&
                substr($row, 0, 24) != "https://enidservices.com"
                &&
                substr($row, 0, 23) != "http://enidservices.com"

            ) {

                $row = [d($row, 'mt-2 border-bottom')];

                $this->table->add_row($row);
            }
        }

        $response[] = $this->table->generate();
        return append($response);
    }
    function paginas($accesos)
    {

        $pagina = array_unique(array_column($accesos, "pagina"));
        $response[] = d("Paginas a las que nos envían tráfico", "f11 black underline mt-5 mb-2");
        foreach ($pagina as $row) {

            if (
                substr($row, 0, 28) != "https://www.enidservices.com"
                &&
                substr($row, 0, 24) != "https://enidservices.com"
                &&
                substr($row, 0, 23) != "http://enidservices.com"

            ) {

                $row = [$row];

                $this->table->add_row($row);
            }
        }

        $response[] = $this->table->generate();
        return append($response);
    }
    function productos($accesos)
    {


        $response[] = d("Productos a los que nos envían tráfico", "f11 black underline mt-5 mb-2");
        $productos_listados = [];
        foreach ($accesos as $row) {

            $http_referer = $row["http_referer"];

            if (
                substr($http_referer, 0, 28) != "https://www.enidservices.com"
                &&
                substr($http_referer, 0, 24) != "https://enidservices.com"
                &&
                substr($http_referer, 0, 23) != "http://enidservices.com"

            ) {


                $id_servicio = $row["id_servicio"];
                $imagen = "";
                if ($id_servicio > 0 && !in_array($id_servicio, $productos_listados)) {

                    $productos_listados[] = $id_servicio;

                    $imagen =
                        img(
                            [
                                "src" => $row["url_img_servicio"],
                                "class" => "img_servicio mah_150",

                            ]
                        );

                    $imagen = a_enid(
                        $imagen,
                        [
                            "href" => path_enid("producto", $id_servicio),
                            "target" => "_black",
                        ]
                    );
                }

                $row = [$imagen];

                $this->table->add_row($row);
            }
        }

        $response[] = $this->table->generate();
        return append($response);
    }
    function franja_horaria_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {


            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $accesos =  $this->acceso_model->franja_horaria($fecha_inicio, $fecha_termino);


            $heading = [
                "Horario",
                "Accesos",
                "Mobile",
                "Desktop"
            ];


            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            foreach ($accesos as $row) {

                $hora = $row["horario"];
                $total = $row["total"];
                $mobile = $row["mobile"];
                $desktop = $row["desktop"];

                $fecha_hora = _text($hora, ':00 hrs');
                $row = [
                    $fecha_hora,
                    $total,
                    $mobile,
                    $desktop
                ];

                $this->table->add_row($row);
            }

            $response = $this->table->generate();
        }
        $this->response($response);
    }

    function busqueda_fecha_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $id_servicio = prm_def($param, "id_servicio");

            $accesos = $this->acceso_model->busqueda_fecha($fecha_inicio, $fecha_termino, $id_servicio);

            $heading = [
                "Pagina",
                "Accesos",
                "Accesos en teléfono",
                "Accesos en computadora",
                "Accesos con sessión",
                "Accesos sin sessión"

            ];
            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            $total_accesos = 0;
            $total_es_mobile = 0;
            $total_es_computadora = 0;
            $total_en_session = 0;
            $total_sin_session = 0;
            $totales_input  = [];

            foreach ($accesos as $row) {

                $id_pagina = $row["id"];
                $numero_accesos = $row["accesos"];
                $pagina = d($row["pagina"], 'text-uppercase');
                $es_mobile = $row["es_mobile"];
                $es_computadora = $row["es_computadora"];
                $en_session = $row["en_session"];
                $sin_session = $row["sin_session"];

                $total_accesos = $total_accesos + $numero_accesos;
                $total_es_mobile =  $total_es_mobile +  $es_mobile;
                $total_es_computadora =  $total_es_computadora +  $es_computadora;
                $total_en_session = $total_en_session + $en_session;
                $total_sin_session = $total_sin_session + $sin_session;

                $row = [
                    $pagina,
                    $numero_accesos,
                    $es_mobile,
                    $es_computadora,
                    $en_session,
                    $sin_session,
                ];

                $this->table->add_row($row);

                switch ($id_pagina) {
                    case 3:
                        $totales_input[] = hiddens(["class" => "detalle_accesos_input", "value" => $numero_accesos]);
                        break;
                    case 6:
                        $totales_input[] = hiddens(["class" => "lista_deseos_input", "value" => $numero_accesos]);
                        break;

                    case 7:
                        $totales_input[] = hiddens(["class" => "procesar_compra_input", "value" => $numero_accesos]);
                        break;
                    case 17:
                        $totales_input[] = hiddens(["class" => "click_whatsapp_input", "value" => $numero_accesos]);
                        break;
                    case 21:
                        $totales_input[] = hiddens(["class" => "promociones_input", "value" => $numero_accesos]);
                        break;

                    case 22:
                        $totales_input[] = hiddens(["class" => "click_producto_recompensa_input", "value" => $numero_accesos]);
                        break;

                    case 24:
                        $totales_input[] = hiddens(["class" => "click_en_ver_fotos_clientes_input", "value" => $numero_accesos]);
                        break;
                    case 25:
                        $totales_input[] = hiddens(["class" => "click_en_formas_pago_input", "value" => $numero_accesos]);
                        break;
                    case 26:
                        $totales_input[] = hiddens(["class" => "click_en_agregar_carrito_promocion_input", "value" => $numero_accesos]);
                        break;
                    case 27:
                        $totales_input[] = hiddens(["class" => "click_en_agregar_carrito_input", "value" => $numero_accesos]);
                        break;

                    default:

                        break;
                }
            }

            $totales  = [
                strong("TOTALES"),
                $total_accesos,
                $total_es_mobile,
                $total_es_computadora,
                $total_en_session,
                $total_sin_session
            ];

            $this->table->add_row($totales);
            $response[] = $this->table->generate();
        }
        $response[] = append($totales_input);
        $this->response($response);
    }
    function busqueda_fecha_producto_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];


            $accesos = $this->acceso_model->busqueda_fecha_productos($fecha_inicio, $fecha_termino);
            $ids = array_column($accesos, "id_servicio");
            $accesos_acciones = $this->acceso_model->busqueda_fecha_ids($fecha_inicio, $fecha_termino, implode(",", $ids));

            $textos_paginas = array_unique(array_column($accesos_acciones, "pagina"));
            $ids_paginas = array_unique(array_column($accesos_acciones, "id_pagina"));


            $accesos_imagenes = $this->app->add_imgs_servicio($accesos);

            $heading = [
                "",
                "Producto",
                "Accesos",
                "Accesos en teléfono",
                "Accesos en computadora",
                "Accesos con sessión",
                "Accesos sin sessión"
            ];

            $this->table->set_template(template_table_enid());
            $this->table->set_heading(array_merge($heading, $textos_paginas));

            $total_accesos = 0;
            $total_es_mobile = 0;
            $total_es_computadora = 0;
            $total_en_session = 0;
            $total_sin_session = 0;

            foreach ($accesos_imagenes as $row) {

                $numero_accesos = $row["accesos"];
                $pagina = d($row["nombre_servicio"], 'text-uppercase');
                $es_mobile = $row["es_mobile"];
                $es_computadora = $row["es_computadora"];
                $en_session = $row["en_session"];
                $sin_session = $row["sin_session"];
                $id_servicio = $row["id_servicio"];

                $total_accesos = $total_accesos + $numero_accesos;
                $total_es_mobile =  $total_es_mobile +  $es_mobile;
                $total_es_computadora =  $total_es_computadora +  $es_computadora;
                $total_en_session = $total_en_session + $en_session;
                $total_sin_session = $total_sin_session + $sin_session;
                $link = path_enid("producto", $id_servicio);
                $imagen  = d(a_enid(img($row["url_img_servicio"]), ["href" => $link, "target" => "_blank"]), "w_50");


                $busqueda = $this->busqueda_por_accion($ids_paginas, $accesos_acciones, $id_servicio);

                $row = [
                    $imagen,
                    $pagina,
                    $numero_accesos,
                    $es_mobile,
                    $es_computadora,
                    $en_session,
                    $sin_session,
                ];
                $linea = array_merge($row, $busqueda);

                $this->table->add_row($linea);
            }

            $totales  = [
                "",
                strong("TOTALES"),
                $total_accesos,
                $total_es_mobile,
                $total_es_computadora,
                $total_en_session,
                $total_sin_session
            ];

            $this->table->add_row($totales);
            $response = $this->table->generate();
        }
        $this->response($response);
    }
    function busqueda_por_accion($ids_paginas, $accesos_acciones,  $id_servicio)
    {

        $response  = [];
        foreach ($ids_paginas as $id) {

            /*Busco por nombre de acción de pagina*/
            $total = 0;
            foreach ($accesos_acciones as $row) {

                $id_pagina = $row["id_pagina"];
                $id_servicio_accesos = $row["id_servicio"];
                if ($id_servicio_accesos ==  $id_servicio && $id_pagina ==  $id) {
                    $total = $row["accesos_accion"];
                }
            }

            $response[] = $total;
        }
        return $response;
    }
    function timeline_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {


            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];

            $accesos = $this->acceso_model->accesos_time_line($fecha_inicio, $fecha_termino);
            $accesos_imagenes = $this->app->add_imgs_servicio($accesos);
            $response = render_time_line($accesos_imagenes);
        }
        $this->response($response);
    }
}
