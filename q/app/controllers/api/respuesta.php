<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Respuesta extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("respuesta");
        $this->load->model("respuesta_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function respuesta_pregunta_POST()
    {

        $param = $this->post();
        $response = false;
        $id_usuario = $this->id_usuario;
        if ($id_usuario > 0) {

            $param["id_usuario"] = $id_usuario;
            $this->respuesta_model->insert($param);
            $this->set_visto_pregunta($param);
            $response = ($param["modalidad"] == 1) ? $this->notifica_respuesta_email($param) : $response;

        }
        $this->response($response);
    }

    function respuestas_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "tarea")) {
            $response = $this->respuesta_model->get_respuestas($param);
            $response["info_respuestas"] = $response;
            //return $this->load->view("tickets/respuestas", $response);
            $response = listado($response);
        }
        $this->response($response);


    }

    function num_respuestas_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "tarea")) {
            $num = $this->respuesta_model->get_num_respuestas($param);
            $response = "Comentarios (" . $num . ")";
        }
        $this->response($response);
    }

    function num_respuestas_sin_leer_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_pregunta")) {
            $response = $this->respuesta_model->get_num_respuestas_sin_leer($param);
        }
        $this->response($response);
    }

    function respuesta_pregunta_GET()
    {

        $param = $this->get();
        $response["data_send"] = $param;
        $this->set_visto_pregunta($param);
        $response += [
            "respuestas" => $this->get_respuestas_pregunta($param),
            "info_usuario" => 0,
        ];
        if ($param["modalidad"] == 1) {
            $response["info_usuario"] = $this->app->usuario($param["usuario_pregunta"]);
        }
        $this->response(render_form_respuestas($response));

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "mensaje,tarea") && $this->id_usuario > 0) {
            $params = [
                "respuesta" => $param["mensaje"],
                "id_tarea" => $param["tarea"],
                "id_usuario" => $this->id_usuario
            ];
            $response = $this->respuesta_model->insert($params, 1);

        }
        $this->response($response);
    }

    private function notifica_respuesta_email($q)
    {

        return $this->app->api("pregunta/respuesta_vendedor", $q);

    }

    private function get_respuestas_pregunta($q)
    {

        return $this->app->api("respon/respuestas_pregunta", $q);
    }

    private function set_visto_pregunta($q)
    {
        return $this->app->api("pregunta/visto_pregunta", $q, "json", "PUT");
    }

}