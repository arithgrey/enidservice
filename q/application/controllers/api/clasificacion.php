<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Clasificacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("clasificaciones");
        $this->load->model("clasificacion_model");
        $this->load->library(lib_def());
    }

    function categorias_servicios_GET()
    {

        $param = $this->get();
        $response = [];

        if (if_ext($param, 'padre,modalidad,nivel')) {

            $in =
                [
                    "padre" => $param["padre"],
                    "flag_servicio" => $param["modalidad"],
                    "nivel" => $param["nivel"]
                ];

            $response = $this->clasificacion_model->get([], $in, 100);
        }
        $this->response($response);
    }

    function clasificaciones_por_servicio_GET()
    {

        $this->response($this->clasificacion_model->get_clasificaciones_por_id($this->get()));
    }

    function primer_nivel_GET()
    {

        $param = $this->get();
        $param["nivel"] = 1;
        $clasificacion = $this->clasificacion_model->get_clasificaciones_segundo($this->clasificacion_model->get_clasificaciones_por_nivel($param));


        $select = create_select(
            $clasificacion,
            "q2",
            "form-control input-sm input_select_busqueda",
            "id_clasificacion",
            "nombre_clasificacion",
            "id_clasificacion",
            0,
            1,
            0,
            "Todos los departamentos"
        );

        $this->response($select);
    }

    function interes_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_usuario")) {

            $response = $this->clasificacion_model->get_intereses_usuario($param);

        }

        $this->response($response);
    }

    function nombre_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_clasificacion")) {
            $response = $this->clasificacion_model->get_nombre_clasificacion_por_id_clasificacion($param);
        }
        $this->response($response);

    }

    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_clasificacion")) {
            $response = $this->clasificacion_model->get_clasificaciones_por_id_clasificacion($param);
        }
        $this->response($response);
    }
    function in_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "clasificaciones")) {

            $response = $this->clasificacion_model->in($param["clasificaciones"]);

        }
        $this->response($response);
    }


    function categorias_destacadas_GET()
    {

        $param = $this->get();
        $param["nivel"] = 1;
        $response = [
            "clasificaciones" => $this->get_clasificaciones_destacadas($param),
            "nombres_primer_nivel" => $this->clasificacion_model->get_clasificaciones_por_nivel($param)
        ];

        $this->response($response);
    }

    private function get_clasificaciones_destacadas($q)
    {

        return $this->app->api("servicio/clasificaciones_destacadas/format/json/", $q);
    }

    function clasificaciones_nivel_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "nivel")) {
            $response = $this->clasificacion_model->get_clasificaciones_por_nivel($param);
        }
        $this->response($response);
    }

    function clasificacion_padre_nivel_GET()
    {

        $param = $this->get();
        $response = [];
        if (if_ext($param, 'padre', 0)) {
            $f = ["id_clasificacion", "padre", "nivel"];
            $response = $this->clasificacion_model->get($f, $param["padre"]);

        }
        $this->response($response);
    }

    function tipo_talla_clasificacion_GET()
    {

        $param = $this->get();
        $v = $param["v"];
        $response = $this->clasificacion_model->get_clasificacion_por_palabra_clave($param);
        if ($v == 1) {
            $response = create_tag($response, 'tag-add tag ', "id_clasificacion", "nombre_clasificacion");
        }
        $this->response($response);
    }

    function tipo_talla_clasificacion_POST()
    {

        $param = $this->post();
        $response = false;
        if (if_ext($param, "id_clasificacion")) {
            $tipo_talla = $this->get_tipo_talla($param);
            $response = [];
            if (es_data($tipo_talla)) {

                $clasificacion = $tipo_talla[0]["clasificacion"];
                $arr_clasificaciones = get_array_json($clasificacion);
                $arr_clasificaciones = push_element_json($arr_clasificaciones, $param["id_clasificacion"]);
                $param["clasificaciones"] = get_json_array($arr_clasificaciones);

                $response = [
                    "status" => $this->set_clasificacion_talla($param),
                    "clasificaciones" => $arr_clasificaciones,
                ];

            }
        }
        $this->response($response);
    }

    private function get_tipo_talla()
    {

        $q["info"] = 1;
        return $this->app->api("tipo_talla/index/format/json/", $q);
    }

    private function set_clasificacion_talla($q)
    {

        return $this->app->api("tipo_talla/clasificacion", $q, "json", "PUT");
    }

    function tipo_talla_GET()
    {

        $param = $this->get();
        $response = $this->get_tipo_talla($param);

        if ($param["v"] > 0) {

            $data["talla"] = $response;
            if (es_data($response)) {

                $data = $this->get_data_clasificaciones($response, $data);

            }

            return $this->load->view("tallas/principal", $data);


        }
        $this->response($response);

    }

    private function get_data_clasificaciones($response, $data)
    {


        if (es_data($response)) {

            $clasificaciones_existentes = $this->get_clasificaciones_por_id(get_array_json( primer_elemento($response, "clasificacion")));

            $tags = create_tag(
                $clasificaciones_existentes,
                'a_enid_black_sm input-sm',
                "id_clasificacion",
                "nombre_clasificacion");

            $data += [
                "clasificaciones_existentes" => $tags,
                "num_clasificaciones" => count($clasificaciones_existentes),
            ];

        }
        return $data;

    }

    private function get_clasificaciones_por_id($array)
    {

        $response = [];
        for ($a = 0; $a < count($array); $a++) {

            $param = [

                "fields" => [
                    "id_clasificacion",
                    "nombre_clasificacion"
                ],
                "id" => $array[$a]

            ];

            $clasificacion = $this->clasificacion_model->get_clasificacion_por_id($param);
            $response[$a] = (es_data($clasificacion)) ? $clasificacion[0] : [];
        }
        return $response;
    }

    function existencia_GET()
    {
        $param = $this->get();
        $response = false;
        if (if_ext($param, "servicio,clasificacion")) {

            $response["existencia"] = $this->clasificacion_model->num_servicio_nombre($param);
        }

        $this->response($response);

    }

    function nivel_POST()
    {

        $param = $this->post();
        $response = false;
        if (if_ext($param, "clasificacion,tipo,padre,nivel")) {
            $params = [
                "nombre_clasificacion" => $param["clasificacion"],
                "flag_servicio" => $param["tipo"],
                "padre" => $param["padre"],
                "nivel" => $param["nivel"]
            ];
            $response = $this->clasificacion_model->insert($params);
        }
        $this->response($response);
    }

    function nivel_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "es_servicio,nivel,padre")) {
            $response = $this->clasificacion_model->get_servicio_nivel($param);

            if (array_key_exists('v', $param) && $param["v"] == 1) {

                $this->response($response);

            } else {

                $response =
                    select_vertical(
                        $response,
                        "id_clasificacion",
                        "nombre_clasificacion",
                        [
                            'size' => 20,
                            'class' => 'sugerencia_clasificacion'
                        ]

                    );

                if ($param["nivel"] !== "1") {

                    $response .= formatAgregar($param);

                }
            }
        }

        $this->response($response);
    }

    function tallas_servicio_GET()
    {


        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_servicio")) {


            $tallas_servicio = $this->get_tallas_servicio($param);
            $tallas_servicio_json =  primer_elemento($tallas_servicio,"talla","");
            $tallas_servicio = $this->quita_cero_clasificacacion($tallas_servicio);

            $v = (get_param_def($param, "v") > 0) ? $param["v"] : 0;
            $data_complete = [];
            $tipo_tallas = $this->get_tipo_talla();

            foreach ($tipo_tallas as $row) {
                $id = $row["id"];
                $array_clasificaciones = get_array_json($row["clasificacion"]);
                for ($a = 0; $a < count($array_clasificaciones); $a++) {
                    $clasificacion = $array_clasificaciones[$a];
                    for ($z = 0; $z < count($tallas_servicio); $z++) {
                        if ($tallas_servicio[$z] == $clasificacion) {
                            $id_tipo_talla = $id;
                            $data_complete["id_tipo_talla"] = $id_tipo_talla;
                            $param["id_tipo_talla"] = $id_tipo_talla;
                            break;
                        }
                    }
                }
            }


            if (get_param_def($data_complete, "id_tipo_talla") > 0) {

                $tallas_disponibles_categoria = $this->get_tallas_countries($param);
                $data_complete["tallas_servicio"] = $this->get_tallas_en_servicio($tallas_disponibles_categoria, $tallas_servicio_json);

                if ($v == 1 && get_param_def($data_complete, "tallas_servicio") !== 0) {
                    $response = $this->create_easy_buttons_tallas($data_complete);
                }
            }

        }
        $this->response($response);
    }

    function get_tallas_servicio($q)
    {

        return $this->app->api("servicio/tallas/format/json/", $q);
    }

    private function quita_cero_clasificacacion($clasificaciones)
    {

        $response = [];
        foreach ($clasificaciones as $row) {

            $x = ($row["primer_nivel"] == 0) ? "" : array_push($response, $row["primer_nivel"]);
            $x = ($row["segundo_nivel"] == 0) ? "" : array_push($response, $row["segundo_nivel"]);
            $x = ($row["tercer_nivel"] == 0) ? "" : array_push($response, $row["tercer_nivel"]);
            $x = ($row["cuarto_nivel"] == 0) ? "" : array_push($response, $row["cuarto_nivel"]);
            $x = ($row["quinto_nivel"] == 0) ? "" : array_push($response, $row["quinto_nivel"]);

        }
        return $response;
    }

    function get_tallas_countries($q)
    {

        return $this->app->api("talla/tallas_countries/format/json/", $q);

    }

    private function get_tallas_en_servicio($tallas_disponibles, $tallas_en_servicio_json)
    {

        $array_tallas_en_servicio = get_array_json($tallas_en_servicio_json);
        sort($array_tallas_en_servicio);
        $response = [];
        $a = 0;
        foreach ($tallas_disponibles as $row) {


            $response[$a] = $row;
            $response[$a]["en_servicio"] = (in_array($row["id_talla"], $array_tallas_en_servicio)) ? 1 : 0;

            $a++;
        }
        return $response;
    }

    private function create_easy_buttons_tallas($response)
    {
        if (es_data($response) && array_key_exists("tallas_servicio", $config)) {


            $config =
                [
                    'class_selected' => 'talla_seleccionada talla_servicio',
                    'class_disponible' => 'talla_disponible talla_servicio',
                    'text_button' => 'talla',
                    'campo_comparacion' => 'en_servicio',
                    'valor_esperado' => 1,
                    'valor_id' => 'id_talla'
                ];


            $easy_butons = create_button_easy_select($response["tallas_servicio"], $config);
            $easy_butons = div($easy_butons,   'contenedor_tallas_disponibles');
            $titulo = div("TALLAS QUE TIENES DISPONIBLES",  'titulo_talla');

            $response["options"] = div($titulo . $easy_butons,  'contenedor_tallas');;
        }
        return $response;
    }

    function coincidencia_servicio_GET()
    {
        $param = $this->get();
        $response = false;
        if (if_ext($param, "clasificacion")) {

            $response = $this->clasificacion_model->get_coincidencia($param);
        }

        $this->response($response);
    }

}