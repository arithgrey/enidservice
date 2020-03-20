<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Servicio extends REST_Controller
{
    public $options;
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("servicios");
        $this->load->helper("base");
        $this->load->model("serviciosmodel");
        $this->load->library('table');
        $this->load->library(lib_def());
        $loggin = $this->app->is_logged_in();
        $param = $this->get();
        $this->id_usuario = (!$loggin) ? prm_def($param, "id_usuario") : $this->app->get_session("idusuario");
    }

    function envio_gratis_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->serviciosmodel->q_get(["flag_envio_gratis"], $param["id"]);
        }
        $this->response($response);

    }

    function clasificaciones_destacadas_GET()
    {

        $this->response($this->serviciosmodel->get_clasificaciones_destacadas());
    }

    function stock_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio")) {

            $response = $this->serviciosmodel->q_get(["stock"], $param["id_servicio"])[0]["stock"];

        }
        $this->response($response);
    }

    function stock_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id_servicio,stock")) {

            $id_servicio = $param["id_servicio"];
            $stock = $param["stock"];
            if (prm_def($param, "compra") > 0) {

                $response = $this->descuento_inventario($stock, $id_servicio, $param);

            } else {

                if (prm_def($param, "anexo") > 0) {

                    $response = $this->anexo_stock($stock, $id_servicio);

                } else {

                    $response = $this->serviciosmodel->q_up("stock", $stock, $id_servicio);
                }

            }

        }
        $this->response($response);
    }

    private function anexo_stock($stock, $id_servicio)
    {
        return $this->serviciosmodel->anexo_stock($stock, $id_servicio);
    }

    function comision_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id,comision")) {

            $id_servicio = $param["id"];
            $response = $this->serviciosmodel->q_up("comision", $param["comision"], $id_servicio);

        }
        $this->response($response);
    }

    function contra_entrega_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "servicio,opcion")) {

            $response = $this->serviciosmodel->q_up("contra_entrega", $param["opcion"], $param["servicio"]);

        }
        $this->response($response);
    }

    function nombre_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {
            $response = $this->serviciosmodel->q_get(["nombre_servicio"], $param["id"]);
        }
        $this->response($response);
    }

    function color_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_servicio")) {
            $response = $this->serviciosmodel->agrega_color_servicio($param);
        }
        $this->response($response);
    }

    function color_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id_servicio")) {
            $response = $this->serviciosmodel->elimina_color_servicio($param);
        }
        $this->response($response);
    }

    function clasificaciones_por_id_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $response = $this->serviciosmodel->get_clasificaciones_por_id_servicio($param["id_servicio"]);
        }
        $this->response($response);
    }

    function metakeyword_usuario_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "tag,id_servicio")) {
            $response = $this->delete_tag_servicio($param);
            $response = $this->set_metakeyword_usuario($response);
        }
        $this->response($response);

    }

    function delete_tag_servicio($param)
    {

        $tag = $param["tag"];
        $id_servicio = $param["id_servicio"];
        $palabras_clave = $this->serviciosmodel->q_get(["metakeyword"], $id_servicio)[0]["metakeyword"];
        $tag_arreglo = explode(",", $palabras_clave);
        $posicion = $this->busqueda_meta_key_word($tag_arreglo, $tag);
        unset($tag_arreglo[$posicion]);
        $param["metakeyword_usuario"] = implode(",", $tag_arreglo);
        return $param;
    }

    function busqueda_meta_key_word($arreglo_tags, $tag)
    {
        return array_search($tag, $arreglo_tags);
    }

    private function set_metakeyword_usuario($q)
    {

        return $this->app->api("metakeyword/usuario", $q, "json", "PUT");
    }

    function lista_categorias_servicios_GET()
    {

        $param = $this->get();
        $data["info_categorias"] = $this->get_categorias_servicios($param);
        $data["nivel"] = $param["nivel"];

        $response =
            (es_data($data["info_categorias"])) ?
                get_config_categorias($data, $param)

                :
                get_add_categorias($data, $param);

        $this->response($response);
    }

    function get_categorias_servicios($q)
    {

        return $this->app->api("clasificacion/categorias_servicios/format/json/", $q);
    }

    function verifica_existencia_clasificacion_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "clasificacion,id_servicio")) {

            $response = $this->get_coincidencias_busqueda($param);
        }
        $this->response($response);
    }

    private function get_coincidencias_busqueda($param)
    {

        $coincidencia = $this->get_coincidencia_servicio($param);
        $res = [];
        $z = 0;
        if (count($coincidencia) > 0) {
            $coincidencia = $coincidencia[0];
            $a = $coincidencia["nivel"];
            $res[$a] = $coincidencia;
            $z = 0;
            $nueva_coincidencia = $coincidencia;
            while ($a > 0) {

                if ($z == 0) {

                    $res[$a] = $coincidencia;

                } else {

                    $n = $this->get_clasificacion_padre_nivel($nueva_coincidencia);
                    if (es_data($n)) {
                        $res[$a] = $n[0];
                        $nueva_coincidencia = $n[0];
                    }
                }
                $z++;
                $a--;
            }
        }

        $response["total"] = count($res);
        $response["categorias"] = $res;
        return $response;
    }

    private function get_coincidencia_servicio($q)
    {

        return $this->app->api("clasificacion/coincidencia_servicio/format/json/", $q);

    }

    private function get_clasificacion_padre_nivel($q)
    {

        return $this->app->api("clasificacion/clasificacion_padre_nivel/format/json/", $q);

    }

    function status_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "status,id_servicio")) {

            $status = ($param["status"] == 1) ? 0 : 1;
            $id_servicio = $param["id_servicio"];
            $response = $this->serviciosmodel->q_up("status", $status, $id_servicio);
        }

        $this->response($response);

    }

    function espublico_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "es_publico,id_servicio")) {


            $id_servicio = $param["id_servicio"];
            $response = $this->serviciosmodel->q_up("es_publico", $param["es_publico"], $id_servicio);
        }

        $this->response($response);

    }


    function tallas_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $params =
                [
                    "primer_nivel",
                    "segundo_nivel",
                    "tercer_nivel",
                    "cuarto_nivel",
                    "quinto_nivel",
                    "id_servicio",
                    "talla"
                ];
            $response = $this->serviciosmodel->q_get($params, $param["id_servicio"]);

        }
        $this->response($response);
    }

    function index_POST()
    {

        $response = false;
        if ($this->input->is_ajax_request()) {
            $param = $this->post();
            if (fx($param, "precio,flag_servicio")) {
                $precio = $param["precio"];
                $es_float = $this->es_float($precio);
                $es_cantidad = ($param["precio"] >= 0);

                $response["registro"] = 0;
                if ($es_float && $es_cantidad) {

                    $response["registro"] = $this->registra_data_servicio($param);
                }
            }
        }
        $this->response($response);

    }


    private function es_float($cantidad)
    {

        if (!is_scalar($cantidad)) {
            return false;
        }
        if (gettype($cantidad) === "float") {

            $response = true;

        } else {

            $response = preg_match("/^\\d+\\.\\d+$/", $cantidad) === 1;
        }

        if (!$response) {

            $response = (ctype_digit($cantidad));
        }
        return $response;
    }

    private function registra_data_servicio($param)
    {

        $next = ($param["flag_servicio"] == 0 && $param["precio"] == 0) ? 0 : 1;
        $data_complete["mensaje"] = ($next == 1) ? "" : "TU PRODUCTO DEBE TENER ALGÚN PRECIO";
        if ($next) {

            $tags = $this->create_tags($param);
            $text_tags = implode($tags, ",");
            $param["metakeyword"] = $text_tags;
            $id_usuario = $this->id_usuario;
            $param["id_usuario"] = $id_usuario;
            $terminos_usuario = $this->get_terminos_privacidad_productos($id_usuario);
            $terminos = $terminos_usuario[0];
            $param["entregas_en_casa"] = ($terminos["entregas_en_casa"] > 0) ? 1 : 0;
            $param["telefonos_visibles"] = ($terminos["telefonos_visibles"] > 0) ? 1 : 0;

            $data_complete["servicio"] = $this->create_servicio($param);

        }

        return $data_complete;
    }

    function create_tags($param)
    {

        $primer_nivel =
            (array_key_exists("primer_nivel", $param)) ? $param["primer_nivel"] : 0;

        $segundo_nivel =
            (array_key_exists("segundo_nivel", $param)) ? $param["segundo_nivel"] : 0;

        $tercer_nivel =
            (array_key_exists("tercer_nivel", $param)) ? $param["tercer_nivel"] : 0;

        $cuarto_nivel =
            (array_key_exists("cuarto_nivel", $param)) ? $param["cuarto_nivel"] : 0;

        $quinto_nivel =
            (array_key_exists("quinto_nivel", $param)) ? $param["quinto_nivel"] : 0;

        $nombre_servicio = strip_tags($param["nombre_servicio"]);
        $valor_precio = prm_def($param, "precio");

        $lista_clasificaciones = [$primer_nivel, $segundo_nivel, $tercer_nivel, $cuarto_nivel, $quinto_nivel];

        $lista_nombres = [];

        for ($a = 0; $a < count($lista_clasificaciones); $a++) {
            if ($lista_clasificaciones[$a] > 0) {
                $id_clasificacion = $lista_clasificaciones[$a];
                $nombre_clasificacion = $this->get_tag_categorias($id_clasificacion);
                array_push($lista_nombres, $nombre_clasificacion);
            }
        }
        array_push($lista_nombres, $nombre_servicio);
        if ($valor_precio > 0) {
            array_push($lista_nombres, $valor_precio);
        }
        return $lista_nombres;

    }

    private function get_tag_categorias($id_clasificacion)
    {

        $q["id_clasificacion"] = $id_clasificacion;
        return $this->app->api("clasificacion/nombre/format/json/", $q);
    }

    private function get_terminos_privacidad_productos($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->app->api("privacidad_usuario/servicio/format/json/", $q);
    }

    function create_servicio($param)
    {

        $nombre_servicio = strip_tags($param["nombre_servicio"]);
        $es_servicio = $param["flag_servicio"];

        $primer_nivel =
            (array_key_exists("primer_nivel", $param)) ? $param["primer_nivel"] : 0;

        $segundo_nivel =
            (array_key_exists("segundo_nivel", $param)) ? $param["segundo_nivel"] : 0;

        $tercer_nivel =
            (array_key_exists("tercer_nivel", $param)) ? $param["tercer_nivel"] : 0;

        $cuarto_nivel =
            (array_key_exists("cuarto_nivel", $param)) ? $param["cuarto_nivel"] : 0;

        $quinto_nivel =
            (array_key_exists("quinto_nivel", $param)) ? $param["quinto_nivel"] : 0;

        $descripcion = "";
        $metakeyword = $param["metakeyword"];
        $id_usuario = $param["id_usuario"];
        $entregas_en_casa = $param["entregas_en_casa"];
        $telefonos_visibles = $param["telefonos_visibles"];

        $precio = $param["precio"];
        $id_ciclo_facturacion = 5;
        if ($es_servicio == 1) {
            $id_ciclo_facturacion = $param["ciclo_facturacion"];
        }


        $params = [
            "nombre_servicio" => $nombre_servicio,
            "flag_servicio" => $es_servicio,
            "primer_nivel" => $primer_nivel,
            "segundo_nivel" => $segundo_nivel,
            "tercer_nivel" => $tercer_nivel,
            "cuarto_nivel" => $cuarto_nivel,
            "quinto_nivel" => $quinto_nivel,
            "descripcion" => $descripcion,
            "metakeyword" => $metakeyword,
            "id_usuario" => $id_usuario,
            "precio" => $precio,
            "id_ciclo_facturacion" => $id_ciclo_facturacion,
            "entregas_en_casa" => $entregas_en_casa,
            "telefono_visible" => $telefonos_visibles];


        if ($this->app->getperfiles() == 3) {
            $params["tiempo_promedio_entrega"] = 1;
        }


        $id_servicio = $this->serviciosmodel->insert($params, 1);
        $this->set_ultima_publicacion($id_usuario);
        return $id_servicio;
    }

    private function set_ultima_publicacion($id_usuario)
    {
        $q["id_usuario"] = $id_usuario;
        return $this->app->api("usuario/ultima_publicacion", $q, "json", "PUT");
    }

    function top_semanal_vendedor_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->serviciosmodel->get_top_semanal_vendedor($param);
            $data_complete = [];
            $a = 0;
            foreach ($response as $row) {

                $id_servicio = $row["id_servicio"];
                $nombre = $this->serviciosmodel->q_get(["nombre_servicio"], $id_servicio)[0]["nombre_servicio"];
                $data_complete[$a] = $row;
                $data_complete[$a]["nombre_servicio"] = $nombre;
                $a++;
            }
            $this->response($data_complete);
        }
        $this->response($response);
    }

    function especificacion_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio")) {

            $this->set_option("id_servicio", $param["id_servicio"]);
            $id_servicio = $this->get_option("id_servicio");
            $servicio = $this->serviciosmodel->get([], ["id_servicio" => $param["id_servicio"]]);
            $data = $this->app->session();
            $data["servicio"] = $servicio;
            $this->set_option("servicio", $servicio);
            $data["costo_envio"] = 0;
            if (pr($servicio, "flag_servicio") == 0) {
                $this->crea_data_costo_envio();
                $data["costo_envio"] = $this->app->calcula_costo_envio($this->crea_data_costo_envio());
            }


            $data["ciclos"] = $this->get_not_ciclo_facturacion($param);
            $data["id_usuario"] = $this->id_usuario;
            $imagenes = $this->app->imgs_productos($id_servicio, 1, 10);
            $data["url_request"] = get_url_request("");
            $prm["id_servicio"] = $id_servicio;
            $data["num"] = $param["num"];
            $prm["id_servicio"] = $id_servicio;
            $data["porcentaje_comision"] = $this->get_porcentaje_comision($prm);
            $data["is_mobile"] = ($this->agent->is_mobile() === FALSE) ? 0 : 1;
            $data["has_phone"] = $this->usuario_tiene_numero($data["id_usuario"]);
            $data["num_imagenes"] = count($imagenes);
            $data["images"] = $this->create_table_images($imagenes, $data["is_mobile"]);
            $data["id_perfil"] = $this->app->getperfiles();
            $this->response(render_configurador($data));

        } else {
            $this->response($response);
        }


    }

    function set_option($key, $value)
    {
        $this->options[$key] = $value;
    }

    function get_option($key)
    {
        return $this->options[$key];
    }

    private function crea_data_costo_envio()
    {
        $param["flag_envio_gratis"] = $this->get_option("servicio")[0]["flag_envio_gratis"];
        return $param;
    }

    private function carga_clasificaciones($servicio)
    {

        $clasificaciones = [
            "primer_nivel",
            "segundo_nivel",
            "tercer_nivel",
            "cuarto_nivel",
            "quinto_nivel"
        ];

        $lista = [];
        for ($a = 0; $a < count($clasificaciones); $a++) {
            $id_clasificacion = $servicio[0][$clasificaciones[$a]];
            if ($id_clasificacion > 0) {
                $data_clasificacion = $this->get_clasificacion_por_id($id_clasificacion);
                if (count($data_clasificacion) > 0) {
                    array_push($lista, $data_clasificacion[0]);
                }
            }
        }
        return $lista;
    }

    private function get_clasificacion_por_id($id_clasificacion)
    {

        $q["id_clasificacion"] = $id_clasificacion;
        $response = $this->app->api("clasificacion/id/format/json/", $q);
        $response = is_array($response) ? $response : [];
        return $response;
    }

    function get_not_ciclo_facturacion($q)
    {

        return $this->app->api("ciclo_facturacion/not_ciclo_facturacion/format/json/", $q);

    }

    private function carga_imagenes_servicio($id_servicio)
    {

        $q["id_servicio"] = $id_servicio;
        return $this->app->api("imagen_servicio/servicio/format/json/", $q);
    }

    private function get_porcentaje_comision($q)
    {

        return $this->app->api("cobranza/comision/format/json/", $q);
    }

    private function usuario_tiene_numero($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->app->api("usuario/has_phone/format/json/", $q);
    }

    /*Se modifica la calificción del servicio*/
    private function create_table_images($imagenes, $is_mobile)
    {


        $num_imgs = 0;
        $images_complete = [];
        foreach ($imagenes as $row) {

            $images_complete[] = $this->create_imgs_tb($row, $is_mobile);

            $num_imgs++;
        }
        if ($num_imgs < 7) {

            $url_imagen = get_url_request("img_tema/tienda_en_linea/agregar_imagen.png");
            $extra_imagen = ($is_mobile == 0) ? "position: relative;width:160px!important;height:160px;" : "position: relative;width:160px!important;";
            $img = img(
                [
                    "class" => "img-responsive agregar_img_servicio_img mx-auto",
                    "src" => $url_imagen,
                    "style" => $extra_imagen
                ]
            );

            for ($num_imgs = $num_imgs; $num_imgs < 6; $num_imgs++) {

                $icon = icon("fa fa-camera agregar_img_servicio");
                $interior = d($icon,
                    [
                        "class" => "agregar_img_servicio",
                        "style" =>
                            "border-style: solid;position:absolute;z-index:2000;
                            margin-left: 10px;padding: 3px;margin-top: 3px;"
                    ]
                );

                $img_preview = d([$interior, $img], 'col mx-auto nav tabs mt-2');
                $images_complete[$num_imgs] = $img_preview;

            }
        }

        return d($images_complete, 'd-md-flex mt-5 mb-5');
    }

    private function create_imgs_tb($row)
    {
        $id_imagen = $row["id_imagen"];
        $extra_img = is_mobile() ? ' w-75 ' : '';
        $img = img(
            [
                'src' => get_url_servicio($row["nombre_imagen"], 1),
                'class' => _text('mx-auto ', $extra_img)
            ]
        );

        $dropdown = dropdown_button($id_imagen, $row["principal"]);
        $extra = ($row["principal"] < 1) ? '' : 'selector_principal';
        return d([$dropdown, $img], _text('col mx-auto row mt-2', $extra));

    }

    function empresa_GET()
    {

        $param = $this->get();
        $response = false;
        $param["q"] = prm_def($param, 'q', '');
        if (fx($param, 'q,page,order')) {

            $param["id_usuario"] = $this->id_usuario;
            $param["id_clasificacion"] = prm_def($param, "q2");
            $param["extra"] = $param;
            $param["resultados_por_pagina"] = 12;
            $param["agrega_clasificaciones"] = 0;
            $param["vendedor"] = 0;

            $servicios = $this->get_servicios_empresa($param);

            if (es_data($servicios) && array_key_exists('num_servicios', $servicios)) {

                $response = $this->get_view_empresa($servicios, $param);

            } else {

                $response = $servicios;
//
//            $data_complete["num_servicios"] = 0;
//            $data_complete["info_servicios"] = btw(
//                icon("fa fa-search")
//                ,
//                _text_("Tu búsqueda de ", $param["q"], " (0 Productos) "),
//                ""
//            );
//            $this->response($data_complete);
            }


        }
        $this->response($response);


    }

    private function get_servicios_empresa($q)
    {

        $q["es_empresa"] = 1;
        return $this->app->api("servicio/q/format/json/", $q);
    }

    private function get_view_empresa($servicios, $param)
    {

        $config["totales_elementos"] = $servicios["num_servicios"];
        $config["per_page"] = 12;
        $config["q"] = $param["q"];
        $config["q2"] = 0;
        $config["page"] = prm_def($this->input->get(), "page");
        $busqueda = $param["q"];
        $num_servicios = $servicios["num_servicios"];
        $this->set_option("in_session", 1);
        $this->set_option("id_usuario", $this->id_usuario);
        $this->set_option("id_perfil", 0);
        if ($this->app->is_logged_in()) {

            $this->set_option("id_perfil", $this->app->getperfiles());
        }


        $lista_productos = $this->agrega_vista_servicios($servicios["servicios"]);

        return get_base_empresa($this->app->paginacion($config), $busqueda, $num_servicios, $lista_productos);


    }

    private function agrega_vista_servicios($data)
    {
        $response = [];
        $in_session = $this->get_option("in_session");
        $id_usuario = $this->get_option("id_usuario");
        $id_perfil = $this->get_option("id_perfil");

        foreach ($data as $row) {
            $row["in_session"] = $in_session;
            $row["id_perfil"] = $id_perfil;
            $row["id_usuario_actual"] = $id_usuario;
            $id_servicio = $row["id_servicio"];
            $row["url_img_servicio"] = $this->app->imgs_productos($id_servicio, 1, 1, 1);
            $response[] = create_vista($row);
        }
        return $response;
    }

    function talla_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $id_servicio = $param["id_servicio"];
            $servicio = $this->serviciosmodel->q_get(["talla"], $id_servicio);
            $servicio_tallas = $this->add_tallas($servicio);
            if ($param["v"] == 1) {

                $response = (count($servicio_tallas) > 0) ? $this->create_button_easy_select_tienda($servicio_tallas) : "";
            } else {
                $response = $servicio_tallas;
            }
        }
        $this->response($response);

    }

    function add_tallas($talla_servicio)
    {

        $response = [];
        $tallas_en_servicio = get_array_json($talla_servicio[0]["talla"]);
        $b = 0;
        for ($a = 0; $a < count($tallas_en_servicio); $a++) {

            $id_talla = $tallas_en_servicio[$a];
            $talla = $this->get_talla_id($id_talla);
            if (count($talla) > 0) {
                $response[$b] = $talla[0];
                $b++;
            }
        }
        return $response;

    }

    private function get_talla_id($id_talla)
    {

        $param["id"] = $id_talla;
        return $this->app->api("talla/id/format/json/", $param);
    }

    private function create_button_easy_select_tienda($servicio_tallas)
    {

        $config = ['text_button' => 'talla',
            'campo_id' => 'id_talla',
            'extra' => ['class' => 'easy_selec facil_selec talla ']
        ];

        $easy_butons = create_button_easy_select($servicio_tallas, $config, 2);

        $config = ['class' => 'dropdown-toggle strong',
            'id' => "dropdownMenuButton",
            'data-toggle' => "dropdown"
        ];

        $icon = icon('fa fa-angle-right ');
        $boton_seleccion = d($icon, $config);
        $contenedor = d($easy_butons, ["class" => "dropdown-menu "]);
        $menu = d($boton_seleccion . $contenedor, ['class' => 'dropdown boton-tallas-disponibles']);

        return $menu;
    }

    function url_ml_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_servicio,url")) {

            $response = $this->serviciosmodel->q_up("url_ml", $param["url"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function dropshiping_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "servicio,link_dropshipping")) {

            $response = $this->serviciosmodel->q_up("link_dropshipping", $param["link_dropshipping"], $param["servicio"]);
        }
        $this->response($response);

    }

    function gamificacion_deseo_PUT()
    {

        $param = $this->put();
        $valor = (array_key_exists("valor", $param)) ? $param["valor"] : 1;
        $response = $this->serviciosmodel->set_gamificacion_deseo($param, 1, $valor);
        $this->response($response);
    }

    function gamificacion_usuario_servicios_PUT()
    {

        $param = $this->put();
        $response = $this->serviciosmodel->gamificacion_usuario_servicios($param);
        $this->response($response);

    }

    function ciclo_facturacion_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_ciclo_facturacion,id_servicio")) {
            $id_ciclo_facturacion = $param["id_ciclo_facturacion"];
            $id_servicio = $param["id_servicio"];
            $response = $this->serviciosmodel->q_up("id_ciclo_facturacion", $id_ciclo_facturacion, $id_servicio);
        }
        $this->response($response);
    }

    function status_imagen_PUT()
    {

        $param = $this->put();
        $response = false;

        if (fx($param, "existencia,id_servicio")) {
            $response = $this->serviciosmodel->q_up("flag_imagen", $param["existencia"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function visitas_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "id_servicio")) {
            $response = $this->serviciosmodel->set_vista($param);
        }
        $this->response($response);
    }

    function entregas_en_casa_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "entregas_en_casa,id_servicio")) {
            $response = $this->serviciosmodel->q_up("entregas_en_casa", $param["entregas_en_casa"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function q_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "q,q2,id_servicio")) {


            if ($param["q"] === "url_vide_youtube") {

                $param["q2"] = get_base_youtube($param["q2"]);
            }
            $response = $this->serviciosmodel->set_q_servicio($param);

        }
        $this->response($response);

    }

    function telefono_visible_PUT()
    {
        $param = $this->put();
        $response = false;

        if (fx($param, "id_servicio,telefono_visible")) {

            $response = $this->serviciosmodel->q_up("telefono_visible", $param["telefono_visible"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function ventas_mayoreo_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_servicio,venta_mayoreo")) {

            $response = $this->serviciosmodel->q_up("venta_mayoreo", $param["venta_mayoreo"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function servicio_categoria_PUT()
    {

        $param = $this->put();
        $response = $this->serviciosmodel->asocia_termino_servicio($param);
        $this->response($response);
    }

    function talla_PUT()
    {

        $param = $this->put();
        $id_servicio = $param["id_servicio"];
        $servicio = $this->serviciosmodel->q_get(['talla'], $id_servicio);
        $talla = $param["id_talla"];
        $tallas_json = ($servicio[0]["talla"] != null) ? $servicio[0]["talla"] : get_json_array(array());
        $array_tallas = get_array_json($tallas_json);


        $array_tallas = ($param["existencia"] == 0) ?
            push_element_json($array_tallas, $talla) : unset_element_array($array_tallas, $talla);

        /*ahora solo actualizo**/
        $param["tallas"] = get_json_array($array_tallas);
        $response = $this->serviciosmodel->q_up("talla", $param["tallas"], $id_servicio);
        $this->response($response);
    }

    function costo_PUT()
    {
        $param = $this->put();
        $response = $this->serviciosmodel->q_up("precio", $param["precio"], $param["id_servicio"]);
        $this->response($response);
    }

    function add_gamification_servicio_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "type")) {
            $response = [];
            switch ($param["type"]) {

                /*USUARIO CANCELA COMPRA*/
                case 2:
                    $response = $this->gamificaCancelacion($param);
                    break;

                /*YA NO QUIERE RECORDATORIOS SOBRE QUE DEBE PUBLICAR PRODUCTOS*/
                case 3:

                    $response = $this->gamificaRecordatorio($param);
                    break;

                /*EL USUARIO NO CONTESTA A LAS PREGUNTAS DENTRO DEL PERIMÉTRO QUE EXIGE EL CLIENTE*/
                case 4:
                    $response = $this->gamificaSinRespuesta($param);

                    break;

                default:
                    $this->response("ok llega");
                    break;
            }
            $this->response($response);
        }
        $this->response($response);

    }

    private function gamificaCancelacion($param)
    {

        $response["tipo"] = "USUARIO CANCELA COMPRA";
        /*Se notifica que el usuario cancela su compra*/
        $api = "usuario/cancelacion_compra/format/json/";
        $cancelacion_compra = $this->app->api($api, $param, "json", "PUT");
        $response["gamificacion_cancelacion_compra"] = $cancelacion_compra;

        /*ahora se baja califición interes compra - Servicio*/
        $response["gamificacion_servicio"] = $this->add_gamificacion_usuario_servicio($param, -1);
        return $response;

    }

    private function add_gamificacion_usuario_servicio($param, $valoracion)
    {
        $param["valoracion"] = $valoracion;
        return $this->app->api("servicio/gamificacion_usuario_servicios/format/json/", $param, "json", "PUT");
    }

    private function gamificaRecordatorio($param)
    {
        $response["tipo"] =
            "YA NO QUIERE RECORDATORIOS SOBRE QUE DEBE PUBLICAR PRODUCTOS";
        /*ahora se baja califición interes compra - Servicio*/
        $response["gamificacion_servicio"] = $this->add_gamificacion_usuario_servicio($param, -3);
        return $response;

    }

    private function gamificaSinRespuesta($param)
    {
        $response["tipo"] = "EL USUARIO NO CONTESTA A LAS PREGUNTAS DENTRO DEL PERIMÉTRO QUE EXIGE EL CLIENTE";
        /*ahora se baja califición interes compra - Servicio*/
        $response["gamificacion_servicio"] = $this->add_gamificacion_usuario_servicio($param, -3);
        /*ahora actualizo la gamificación*/
        return $response;
    }

    function num_venta_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->serviciosmodel->get_num_en_venta_usuario($param);
        }
        $this->response($response);
    }

    function q_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        $servicios = false;

        if (fx($param, 'q,id_usuario,vendedor,agrega_clasificaciones,id_clasificacion,vendedor')) {
            $es_empresa = array_key_exists("es_empresa", $param);
            $servicios = $this->serviciosmodel->busqueda($param);
            $total_busqueda = prm_def($servicios, 'total_busqueda');
            $servicios += [
                "url_request" => get_url_request(""),
                "num_servicios" => $total_busqueda,
            ];
            if ($es_empresa) {
                $this->add_gamificacion_search($param);
            }
        }

        $this->response($servicios);


    }

    private function add_gamificacion_search($q)
    {
        if (prm_def($q, 'q', FALSE) != FALSE && strlen($q['q']) > 1) {

            $this->app->api("metakeyword/gamificacion_search/format/json/", $q, "json", "POST");
        }
    }


    function info_disponibilidad_servicio_GET()
    {


        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $id_servicio = $param["id_servicio"];
            $params = [
                "id_servicio",
                "nombre_servicio",
                "status",
                "existencia",
                "flag_envio_gratis",
                "flag_servicio",
                "flag_nuevo",
                "id_usuario id_usuario_venta",
                "precio",
                "id_ciclo_facturacion",
                "existencia",
                "comision"
            ];

            $servicio = $this->serviciosmodel->q_get($params, $id_servicio);
            $num_servicios = count($servicio);
            $response["en_existencia"] = 0;
            $response["info_servicio"] = $servicio;

            if ($num_servicios > 0) {
                $response["en_existencia"] = 1;
            }
        }
        $this->response($response);

    }

    function existencia_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {

            $response = $this->serviciosmodel->q_get(["existencia"], $param["id_servicio"])[0]["existencia"];

        }
        $this->response($response);
    }

    function basic_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $params = ["nombre_servicio", "telefono_visible", "id_usuario"];
            $id_servicio = $param["id_servicio"];
            $response = $this->serviciosmodel->q_get($params, $id_servicio);
        }
        $this->response($response);
    }

    function por_clasificacion_GET()
    {

        $param = $this->get();
        $response = false;
        $campos =
            "id_servicio,primer_nivel,segundo_nivel,tercer_nivel,cuarto_nivel,quinto_nivel";
        if (fx($param, $campos)) {

            $response = $this->serviciosmodel->get_producto_por_clasificacion($param);

        }
        $this->response($response);
    }

    private function agrega_costo_envio($servicios)
    {

        $nueva_data = [];
        $a = 0;
        foreach ($servicios as $row) {

            $nueva_data[$a] = $row;
            $es_servicio = $row["flag_servicio"];

            if ($es_servicio == 0) {
                $prm["flag_envio_gratis"] = $row["flag_envio_gratis"];
                $nueva_data[$a]["costo_envio"] = $this->app->calcula_costo_envio($prm);
            }
            $a++;
        }
        return $nueva_data;

    }

    function qmetakeyword_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "limit")) {

            $q = (array_key_exists("q", $param)) ? $param["q"] : "";
            $param["q2"] = 0;
            $param["q"] = $q;
            $param["order"] = 1;
            $param["id_clasificacion"] = prm_def($param, "id_clasificacion");
            $param["id_usuario"] = 0;
            $param["vendedor"] = 0;
            $param["resultados_por_pagina"] = $param["limit"];
            $param["agrega_clasificaciones"] = 0;
            $servicios = $this->serviciosmodel->busqueda_producto($param);

            $response = prm_def($servicios, "servicio", []);

        }
        $this->response($response);
    }

    function base_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio,c")) {

            $id_servicio = $param["id_servicio"];
            $params = [
                "id_servicio",
                "nombre_servicio",
                "descripcion",
                "status",
                "id_clasificacion",
                "flag_servicio",
                "flag_envio_gratis",
                "flag_precio_definido",
                "flag_nuevo",
                "url_vide_youtube",
                "metakeyword",
                "metakeyword_usuario",
                "existencia",
                "color",
                "id_usuario",
                "precio",
                "id_ciclo_facturacion",
                "entregas_en_casa",
                "telefono_visible",
                "venta_mayoreo",
                "tiempo_promedio_entrega",
                "talla",
                "url_ml",
                "contra_entrega",
                "deseado",
                "cupon_primer_compra"
            ];

            if ($param["c"] < 0) {

                $response = $this->serviciosmodel->get($params, ["id_servicio" => $id_servicio]);

            } else {

                $response = $this->serviciosmodel->get([], ["id_servicio" => $id_servicio]);

            }

        }
        $this->response($response);
    }

    function periodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio", "fecha_termino")) {
            $response = $this->serviciosmodel->periodo($param);
            $v = (array_key_exists("v", $param) && $param["v"] > 0) ? $param["v"] : 0;
            switch ($v) {
                case 1:
                    $data["servicios"] = $response;
                    $data["css"] = ["productos_periodo.css"];
                    $response = format_simple($data);


                    break;

                default:

                    break;
            }
        }
        $this->response($response);

    }

    function es_servicio_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,id_servicio")) {
            $params_where = [
                "id_usuario" => $param["id_usuario"],
                "id_servicio" => $param["id_servicio"]
            ];
            $response = $this->serviciosmodel->get(["COUNT(0)num"], $params_where)[0]["num"];
        }
        $this->response($response);
    }

    function resumen_GET()
    {

        $param = $this->get();
        if (fx($param, "id_servicio")) {
            $response = $this->serviciosmodel->get_resumen($param);
        }
        $this->response($response);
    }

    function metakeyword_usuario_POST()
    {

        if ($this->input->is_ajax_request()) {
            $param = $this->post();
            if (fx($param, "metakeyword_usuario,id_servicio")) {

                $param["id_usuario"] = $this->id_usuario;
                $param["metakeyword_usuario"] = remove_comma($param["metakeyword_usuario"]);
                $meta = $this->serviciosmodel->get_palabras_clave($param["id_servicio"]);
                $metakeyword_usuario = $param["metakeyword_usuario"];
                $metakeyword_usuario = $meta . "," . $metakeyword_usuario;

                $response["add"] = $this->serviciosmodel->q_up("metakeyword_usuario", $metakeyword_usuario, $param["id_servicio"]);
                $response["add_catalogo"] = $this->agrega_metakeyword_catalogo($param);

                $this->response($response);
            }
        }
    }

    function agrega_metakeyword_catalogo($q)
    {
        $api = "metakeyword/add";
        return $this->app->api($api, $q, "json", "POST");
    }

    function num_periodo_GET($param)
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->serviciosmodel->num_periodo($param);
        }
        $this->response($response);

    }

    function num_anuncios_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->serviciosmodel->get_num_anuncios($param);
        }
        $this->response($response);
    }

    function alcance_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->serviciosmodel->get_alcance_productos_usuario($param);
        }
        $this->response($response);
    }

    function crea_vista_producto_GET()
    {

        $servicio = $this->get();
        $servicio["url_img_servicio"] = $this->app->imgs_productos($servicio["id_servicio"], 1, 1, 1);
        $this->response(create_vista($servicio));

    }


    function metricas_productos_solicitados_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $articulos = $this->serviciosmodel->get_productos_solicitados($param);

            $this->table->set_heading(
                "ARTÍCULO",
                'SOLICITES'
            );

            foreach ($articulos as $row) {

                $this->table->add_row($row["keyword"], $row["num_keywords"]);

            }
            $this->table->set_template(template_table_enid());
            $response = $this->table->generate();

        }
        $this->response($response);
    }

    function num_lectura_valoraciones_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->serviciosmodel->get_num_lectura_valoraciones($param);
        }
        $this->response($response);
    }

    function tiempo_entrega_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "tiempo_entrega,id_servicio")) {
            $response = $this->serviciosmodel->q_up("tiempo_promedio_entrega", $param["tiempo_entrega"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function tipo_entrega_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "tipo,id_servicio")) {


            $tipo = "";
            switch ($param["tipo"]) {
                case 1:
                    $tipo = "tipo_entrega_envio";
                    break;
                case 2:
                    $tipo = "tipo_entrega_visita";
                    break;
                case 3:
                    $tipo = "tipo_entrega_punto_medio";
                    break;

                default:

                    break;
            }
            $response = $this->serviciosmodel->set_preferencia_entrega($tipo, $param["id_servicio"]);
        }
        $this->response($response);

    }

    function tipos_entregas_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "fecha_inicio,fecha_termino")) {
            if ($param["v"] == 1) {

                $servicios = $this->serviciosmodel->get_tipos_entregas($param);
                $tipos_entregas_servicios = $this->get_tipos_intentos_entregas($param);
                $servicios = une_data($servicios, $tipos_entregas_servicios);


                $this->table->set_heading(
                    "Servicio",
                    'Vistas',
                    'Entregas por envío',
                    'Entregas en negocio',
                    'Entregas en punto medio',
                    'deseado',
                    'valorado',
                    'intentos'
                );


                foreach ($servicios as $row) {


                    $vista = $row["vista"];
                    $tipo_entrega_envio = $row["mensajeria"];
                    $tipo_entrega_visita = $row["visita_negocio"];
                    $tipo_entrega_punto_medio = $row["punto_encuentro"];
                    $deseado = $row["deseado"];
                    $valoracion = $row["valoracion"];
                    $id_servicio = $row["id_servicio"];

                    $id_error = "imagen_" . $id_servicio;
                    $url_img = link_imagen_servicio($id_servicio);
                    $img = img(
                        [
                            "src" => $url_img,
                            "id" => $id_error,
                            "style" => "width:50px!important;height:50px!important;",
                            'onerror' => "reloload_img( '" . $id_error . "','" . $url_img . "');"
                        ]);


                    $array =
                        [a_enid($img,
                            [
                                "href" => "../producto/?producto=" . $id_servicio,
                                "target" => "_black"
                            ]
                        ),
                            $vista,
                            $tipo_entrega_envio,
                            $tipo_entrega_visita,
                            $tipo_entrega_punto_medio,
                            $deseado,
                            $valoracion
                        ];

                    $this->table->add_row($array);

                }


                $this->table->set_template(template_table_enid());
                $tb_general = $this->table->generate();
                $tb_headers = $this->get_headers_tipo_entrega($servicios);
                $total = $tb_headers . hr() . $tb_general;
                $response = $total;


            }

        }
        $this->response($response);
    }

    private function get_tipos_intentos_entregas($q)
    {

        return $this->app->api("intento_tipo_entrega/periodo/format/json/", $q);
    }

    private function get_headers_tipo_entrega($array)
    {

        $this->table->set_heading(

            'Vistas',
            'Entregas por envíos',
            'Entregas en negocio',
            'Entregas en puntos medios',
            'deseados',
            'valoraciones'
        );

        $this->table->add_row(
            sumatoria_array($array, "vista"),
            sumatoria_array($array, "mensajeria"),
            sumatoria_array($array, "visita_negocio"),
            sumatoria_array($array, "punto_encuentro"),
            sumatoria_array($array, "deseado"),
            sumatoria_array($array, "valoracion")

        );

        return $this->table->generate();
    }

    function usuario_por_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $response = $this->serviciosmodel->q_get(["id_usuario"], $param["id_servicio"]);
        }
        $this->response($response);
    }

    function sugerencia_GET()
    {
        $param = $this->get();
        $response = false;

        if (fx($param, "id_servicio")) {

            $clasificaciones = $this->serviciosmodel->get_clasificaciones_por_id_servicio($param["id_servicio"]);
            $response = (es_data($clasificaciones)) ? $response = $this->get_servicios_por_clasificaciones($clasificaciones[0]) : [];
            $servicios = $this->completa_servicios_sugeridos($response, $param);
            $servicios = $this->extra_sugerencias($servicios);

            if (es_data($servicios)) {


                $response = get_view_sugerencias(
                    $this->add_imgs_sugerencias($servicios)
                );

            } else {
                $data_response["sugerencias"] = 0;
                $this->response($data_response);
            }
        }
        $this->response($response);
    }

    private function add_imgs_sugerencias($servicios)
    {

        $response = [];
        $a = 0;
        foreach ($servicios as $row) {
            $servicio = $row;
            $id_servicio = $row["id_servicio"];
            $servicio["url_img_servicio"] = $this->app->imgs_productos($id_servicio, 1, 1, 1);
            $a++;
            $response[] = $servicio;
        }
        return $response;

    }

    private function get_servicios_por_clasificaciones($q)
    {

        return $this->app->api("servicio/por_clasificacion/format/json/", $q);
    }

    function completa_servicios_sugeridos($servicios, $param)
    {

        $in_session = $this->app->is_logged_in();
        $existentes = count($servicios);
        $sugerencia = ($existentes > 0) ? $servicios : [];

        if ($existentes < 8) {

            $param["limit"] = (8 - $existentes);

            if ($in_session) {

                $param["id_usuario"] = $this->app->get_session("idusuario");
                $nuevo = $this->get_servicios_lista_deseos($param);

            } else {

                $nuevo = $this->busqueda_producto_por_palabra_clave($param);
            }

            foreach ($nuevo as $row) {
                $sugerencia[] = $row;
            }


            $sugerencia =
                array_intersect_key($sugerencia, array_unique(array_column($sugerencia, 'id_servicio')));

        }
        return $sugerencia;
    }

    function extra_sugerencias($servicios)
    {

        if (es_data($servicios) && count($servicios) < 8) {

            $existentes = count($servicios);
            if ($existentes < 8) {

                $param["limit"] = (8 - $existentes);
                foreach ($this->busqueda_producto_por_palabra_clave($param) as $row) {
                    $servicios[] = $row;
                }
            }

        }

        return $servicios;
    }

    function get_servicios_lista_deseos($q)
    {

        return $this->app->api("usuario/lista_deseos_sugerencias/format/json/", $q);

    }

    private function busqueda_producto_por_palabra_clave($q)
    {

        return $this->app->api("servicio/qmetakeyword/format/json/", $q);
    }

    function colores_GET()
    {


        $this->response(get_tabla_colores());

    }

    function get_info_ciclo_facturacion_servicio($q)
    {

        return $this->app->api("cobranza/calcula_costo_envio/format/json/", $q);
    }

    function get_costo_envio($q)
    {

        return $this->app->api("cobranza/calcula_costo_envio/format/json/", $q);
    }

    function restablecer_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->serviciosmodel->restablecer($param["id"]);

        }
        $this->response($response);

    }

    function descuento_inventario($stock, $id_servicio, $param)
    {

        $this->serviciosmodel->set_compra_stock($stock, $id_servicio);
        $response = $this->gestion_stock($id_servicio, $stock);
        $this->anexa_costos_operativos($response, $param);
        $this->response($response);

    }

    function anexa_costos_operativos($data_stock, $param)
    {
        $costo_unidad = prm_def($data_stock, 'costo_unidad');
        $id_recibo = prm_def($param, 'recibo');
        if ($costo_unidad > 0 && $id_recibo > 0) {

            $q = [
                "recibo" => $id_recibo,
                "costo" => $costo_unidad,
                "tipo" => 8
            ];
            return $this->app->api("costo_operacion/index", $q, "json", "POST");
        }
    }

    function gestion_stock($id_servicio, $cantidad)
    {

        $q = [
            'descuento' => 1,
            'cantidad' => $cantidad,
            'id_servicio' => $id_servicio
        ];
        return $this->app->api("stock/disponibilidad/format/json/", $q);
    }


}