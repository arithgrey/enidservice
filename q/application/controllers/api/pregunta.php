<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';

class pregunta extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("pregunta");
        $this->load->model("pregunta_model");
        $this->load->library(lib_def());
    }

    function noficacion_respuesta_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_pregunta,es_vendedor", 1)) {

            $id_pregunta = $param["id_pregunta"];
            if ($param["es_vendedor"] > 0) {


                $filter = [
                        "se_lee" => 0,
                        "se_responde" => 1,
                        "se_ve_vendedor" => 1,
                        "se_ve_cliente" => 0,
                ];

                $response = $this->pregunta_model->update($filter,
                        ["id_pregunta" => $id_pregunta]);
                $fn = ($response == true) ? $this->envia_respuesta_cliente($id_pregunta) : "";

            } else {


                $filter = [
                        "se_lee" => 1,
                        "se_responde" => 0,
                        "se_ve_vendedor" => 0,
                        "se_ve_cliente" => 1,
                ];

                $response = $this->pregunta_model->update($filter,
                        ["id_pregunta" => $id_pregunta]);
                $fn = ($response == true) ? $this->envia_respuesta_vendedor($id_pregunta) : "";


            }


        }
        $this->response($response);

    }

    private function envia_respuesta_cliente($id_pregunta)
    {


        $pregunta = $this->pregunta_model->q_get(["id_usuario", "id_servicio"],
                $id_pregunta);
        $response = "";
        if (es_data($pregunta)) {
            $pregunta = $pregunta[0];
            $id_usuario = $pregunta["id_usuario"];
            if ($id_usuario > 0) {
                $usuario = $this->app->usuario($id_usuario);
                if (es_data($usuario) > 0) {

                    $cliente = $usuario[0];
                    $nombre = strtoupper($cliente["nombre"]." ".$cliente["apellido_paterno"]);
                    $sender = get_format_respuesta_cliente($cliente["email"], $nombre,
                            $pregunta["id_servicio"]);
                    $response = $this->app->send_email($sender, 1);
                }
            }
        }

        return $response;


    }

    private function envia_respuesta_vendedor($id_pregunta)
    {
        $pregunta = $this->pregunta_model->q_get(["id_vendedor", "id_servicio"],
                $id_pregunta);
        $response = "";
        if (es_data($pregunta)) {
            $pregunta = $pregunta[0];
            $id_usuario = $pregunta["id_vendedor"];
            if ($id_usuario > 0) {
                $usuario = $this->app->usuario($id_usuario);
                if (es_data($usuario) > 0) {

                    $cliente = $usuario[0];
                    $nombre = strtoupper($cliente["nombre"]." ".$cliente["apellido_paterno"]);
                    $sender = frm_respuesta_vendedor($cliente["email"], $nombre,
                            $pregunta["id_servicio"]);
                    $response = $this->app->send_email($sender, 1);
                }
            }
        }

        return $response;
    }

    function visto_pregunta_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_pregunta,modalidad")) {

            $response = $this->pregunta_model->set_visto_pregunta($param);
        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response["in_session"] = 0;
        if ($this->app->is_logged_in()) {
            $response = false;
            $param["usuario"] = $this->app->get_session("idusuario");
            if (fx($param, 'pregunta,usuario,servicio')) {

                $id_servicio = $param["servicio"];
                $usuario = $this->get_usuario_servicio($id_servicio);

                $q =
                        [
                                "pregunta" => $param["pregunta"],
                                "id_usuario" => $param["usuario"],
                                "id_servicio" => $id_servicio,
                                "id_vendedor" => prm_def($usuario,
                                        0) ? $usuario[0]["id_usuario"] : 0,
                                "se_responde" => 0,
                                "se_lee" => 1,
                                "se_ve_cliente" => 1,
                                "se_ve_vendedor" => 0,
                        ];

                $response = $id_pregunta = $this->pregunta_model->insert($q, 1);
                $fn = ($id_pregunta > 0) ? $this->notifica_vendedor($usuario) : "";
            }
        }
        $this->response($response);
    }

    private function get_usuario_servicio($id_servicio)
    {
        $q["id_servicio"] = $id_servicio;

        return $this->app->api("usuario/usuario_servicio/format/json/", $q);
    }

    private function notifica_vendedor($usuario)
    {

        $this->app->send_email(get_notificalista_respuestascion_pregunta($usuario));
    }

    function periodo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {
            $response = $this->pregunta_model->num_periodo($param);
        }
        $this->response($response);
    }

    /*FIXME Table 'enidserv_web.pregunta_servicio' doesn't exist*/
    function buzon_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->app->get_session("idusuario");
        $data_complete["modalidad"] = $param["modalidad"];
        if ($param["modalidad"] > 0) {

            $preguntas = $this->pregunta_model->get_preguntas_realizadas_a_vendedor($param);


        } else {

            $preguntas = $this->pregunta_model->get_preguntas_realizadas($param);

        }

        $data_complete["preguntas"] = $this->add_num_respuestas_preguntas($preguntas);
        $this->response(lista_respuestas($data_complete));


    }

    function add_num_respuestas_preguntas($data)
    {

        $response = [];
        $a = 0;
        foreach ($data as $row) {
            $response[$a] = $row;
            $response[$a]["respuestas"] = $this->get_num_respuestas_sin_leer($row["id_pregunta"]);
            $a++;
        }

        return $response;
    }

    private function get_num_respuestas_sin_leer($id_pregunta)
    {

        $q["id_pregunta"] = $id_pregunta;

        return $this->app->api("respuesta/num_respuestas_sin_leer/format/json/", $q);
    }

    function preguntas_sin_leer_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->app->get_session("idusuario");

        $response = "";
        if ($param["modalidad"] == 1) {

            if (prm_def($param, "id_usuario") > 0) {
                $param["id_usuario"] = $this->app->get_session("idusuario");
            }

            $response = [
                    "modo_vendedor" => (key_exists_bi($this->pregunta_model->get_preguntas_sin_leer_vendedor($param),
                            0, "num", 0)),
                    "modo_cliente" => $this->pregunta_model->get_respuestas_sin_leer($param),
            ];

        }
        $this->response($response);
    }

    function usuario_por_pregunta_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_pregunta")) {

            $usuario = $this->pregunta_model->get_usuario_por_id_pregunta($param);
            $response = pr($usuario, "id_usuario");

        }
        $this->response($response);
    }

    function vendedor_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_vendedor")) {

            $id_vendedor = $param["id_vendedor"];

            $in = [
                    "id_vendedor" => $id_vendedor,
                    "status" => 0,
            ];
            if (array_key_exists("recepcion", $param)) {
                $in = ["id_vendedor" => $id_vendedor];

            }
            if (prm_def($param, "id_pregunta") > 0) {

                $in["id_pregunta"] = $param["id_pregunta"];

            }
            if (array_key_exists("se_responde", $param)) {

                $in["se_responde"] = $param["se_responde"];
            }


            $limit = (array_key_exists("recepcion", $param)) ? 30 : 5;


            if (array_key_exists("num_respuesta", $param)) {

                $response = $this->pregunta_model->get_num($limit,
                        $this->add_filter($in));

            } else {

                $response = $this->pregunta_model->get([], $in, $limit, 'fecha_registro',
                        'DESC');
            }

        }
        $this->response($response);

    }

    private function add_filter($in)
    {

        $extra = " ";

        if (count($in) > 0) {

            foreach ($in as $clave => $valor) {
                $extra .= "p.{$clave} = {$valor} AND ";

            }
            $extra .= " 1 = 1 ";

        }

        return $extra;

    }

    function cliente_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $id_usuario = $param["id_usuario"];


            $in = [
                    "id_usuario" => $id_usuario,
                    "status" => 0,
            ];

            if (array_key_exists("recepcion", $param)) {

                $in = ["id_usuario" => $id_usuario];

            }

            $id_pregunta = prm_def($param, "id_pregunta");
            if ($id_pregunta > 0) {

                $in["id_pregunta"] = $id_pregunta;

            }

            if (array_key_exists("se_lee", $param)) {

                $in["se_lee"] = $param["se_lee"];

            }
            if (array_key_exists("se_ve_cliente", $param)) {

                $in["se_ve_cliente"] = $param["se_ve_cliente"];
            }

            $limit = (array_key_exists("recepcion", $param)) ? 30 : 5;


            if (array_key_exists("num_respuesta", $param)) {

                $response = $this->pregunta_model->get_num($limit,
                        $this->add_filter($in));

            } else {

                $response = $this->pregunta_model->get([], $in, $limit, 'fecha_registro',
                        'DESC');
            }


        }
        $this->response($response);


    }

    function notifica_lectura_cliente_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_pregunta,id_usuario")) {

            $response = $this->pregunta_model->update(["se_ve_cliente" => 1],
                    ["id_pregunta" => $param["id_pregunta"]]);

        }
        $this->response($response);

    }

}