<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Emp extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("correos");
        $this->load->library("mensajeria");
        $this->load->library(lib_def());
    }


    function contacto_POST()
    {

        $param = $this->post();
        $this->insert_contacto($param);
        $param["url_registro"] = $_SERVER['HTTP_REFERER'];
        $ticket = $this->abre_ticket($param);
        $this->response($ticket);
        $param["id_ticket"] = $ticket;
        $response = $this->agrega_tarea_ticket($param);

        if ($param["tipo"] == 2) {
            $email = "enidservice@gmail.com";
            $this->mensajeria->notifica_nuevo_contacto($param, $email);
            $this->mensajeria->notifica_agradecimiento_contacto($param);
        }
        $this->response($response);
    }

    function notifica_pago_POST()
    {

        $param = $this->post();
        $response = $this->get_notificacion_pago($param);
        $this->mensajeria_lead->notifica_registro_de_pago_efectuado($response);
        $response = $this->mensajeria_lead->notifica_registro_de_pago_efectuado_cliente($response);
        $this->response($response);
    }


    function salir_GET()
    {

        $param = $this->get();
        $response = false;
        switch ($param["type"]) {
            /*Correos de promoción*/
            case 1:

                $response = $this->salir_list_email($param);
                break;

            case 2:
                $response = $this->cancela_recordatorio($param);
                break;

            case 3:
                /*Se cancelan los recordatorios de publicacion servicio*/
                $response = $this->cancelar_recordatorio_servicio($param);
                break;

            default:

                break;
        }
        $this->response($response);
    }

    private function aplica_gamification_servicio($param)
    {


        return $this->put_service_enid($param, "base", "servicio/add_gamification_servicio/format/json/");
    }

    private function get_notificacion_pago($q)
    {

        $api = "notificacion_pago/resumen/format/json/";
        return $this->app->api($api, $q);
    }

    function mensaje_inicial_afiliado_GET()
    {

        $param["info_persona"] = $this->get();
        $this->load->view("registro/mensaje_inicial_afiliado", $param);
    }


    private function agrega_tarea_ticket($param)
    {


        $nombre = $param["nombre"];
        $email = $param["email"];
        $tel = $param["tel"];
        $mensaje = $param["mensaje"];

        $nuevo_mensaje =
            "Hola soy Nombre:" .
            $nombre . "Correo electrónico: " .
            $email . " Teléfono: "
            . $tel .
            "----- Solicitud hecha desde la página de contacto -------" . $mensaje;

        $data_send["tarea"] = $nuevo_mensaje;
        $data_send["id_ticket"] = $this->abre_ticket($param);
        $data_send["id_usuario"] = 180;

        return $param["id_ticket"];
        $this->app->api("tarea/buzon", $data_send, "json", "POST");

    }

    /*Se califica al cliente con base en su respuesta al cliente*/
    private function cancelar_recordatorio_servicio($param)
    {

        $param["url_request"] = get_url_request("");
        $param["in_session"] = 0;
        $param["v"] = rand();
        $this->aplica_gamification_servicio($param);
        $this->app->api("equipo/cancelar_envio_recordatorio", $param, "json", "PUT");
        $this->response(evaluacion($param));
    }

    private function cancela_recordatorio($param)
    {

        $param["url_request"] = get_url_request("");
        $param["in_session"] = 0;
        $param["v"] = rand();
        $this->app->api("cobranza/cancelar_envio_recordatorio", $param, "json", "PUT");
        $this->aplica_gamification_servicio($param);
        $this->response(evaluacion($param));
    }

    private function salir_list_email($q)
    {
        return $this->app->api("prospecto/salir_list_email", $q, "json", "PUT");
    }

}