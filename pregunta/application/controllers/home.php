<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("validador");
        $this->load->library(lib_def());

    }

    function index()
    {


        $fn = (array_key_exists("tag", $this->input->get())) ? $this->get_form() : $this->get_listado();

    }

    private function get_form()
    {

        $data = $this->app->session();
        $servicio = $this->input->get("tag");

        if ($servicio > 0 && ctype_digit($servicio)) {

            $send["in_session"] = $data["in_session"];
            if ($send["in_session"] < 1) {

                $session_data = [
                    "servicio_pregunta" => $servicio
                ];

                $this->app->set_userdata($session_data);

                redirect("../../login");


            } else {


                $send["id_servicio"] = $servicio;
                $data["id_servicio"] = $servicio;
                $send["id_usuario"] = ($send["in_session"] == 1) ? $this->app->get_session("idusuario") : 0;

                $response = get_format_pregunta($this->carga_formulario_valoracion($send), $send["id_servicio"]);

                $this->app->pagina($this->app->cssJs($data, "pregunta"), $response, 1);
            }


        } else {

            header("location:../?q2=0&q=");

        }
    }

    private function carga_formulario_valoracion($q)
    {


        return $this->app->api("valoracion/pregunta_consumudor_form/format/json/", $q);
    }

    private function get_listado()
    {

        $param = $this->input->get();
        $data = $this->app->session();
        $id_usuario = $data["id_usuario"];

        if (array_key_exists("action", $param) && $data["in_session"] > 0) {

            $action = $param["action"];
            $id_pregunta = (array_key_exists("id", $param) && $param["id"] > 0) ? $param["id"] : 0;
            switch ($action) {

                case "hechas":

                    $this->get_hechas($id_usuario, $data, $id_pregunta);
                    break;
                case "recepcion":

                    $this->get_recibidas($id_usuario, $data, $id_pregunta);

                    break;
                case 2:

                    break;
            }


        } else {

            header("location:../?q2=0&q=");

        }
    }

    private function get_hechas($id_usuario, $data, $id_pregunta)
    {

        $preguntas = $this->get_preguntas_hechas_cliente($id_usuario, $id_pregunta);
        $data["preguntas_format"] = format_preguntas($preguntas, 0);
        $response = get_format_listado(format_preguntas($preguntas, 0));
        $this->app->pagina($this->app->cssJs($data, "pregunta_hechas"), $response, 1);


    }

    function get_preguntas_hechas_cliente($id_usuario, $id_pregunta)
    {

        $q = [

            "id_pregunta" => $id_pregunta,
            "id_usuario" => $id_usuario,
            "recepcion" => 1,
            "num_respuesta" => 1,

        ];

        return $this->app->api("pregunta/cliente/format/json/", $q);

    }

    private function get_recibidas($id_usuario, $data, $id_pregunta)
    {

        $preguntas = $this->get_preguntas_recibidas_vendedor($id_usuario, $id_pregunta);
        $response = get_format_listado(format_preguntas($preguntas, 1));
        $this->app->pagina($this->app->cssJs($data, "pregunta_recibida"), $response, 1);


    }

    private function get_preguntas_recibidas_vendedor($id_usuario, $id_pregunta)
    {

        $q = [

            "id_pregunta" => $id_pregunta,
            "id_vendedor" => $id_usuario,
            "recepcion" => 1,
            "num_respuesta" => 1

        ];

        return $this->app->api("pregunta/vendedor/format/json/", $q);

    }


}