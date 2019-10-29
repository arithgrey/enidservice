<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tickets extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("tickets");
        $this->load->model("tickets_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function pendientes_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->tickets_model->get(
                ["id_ticket", "asunto"],
                [
                    "id_usuario" => $param["id_usuario"],
                    "status" => 1,
                ],
                10
            );

        }
        $this->response($response);

    }

    function num_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_ticket")) {
            $response = $this->tickets_model->get_num($param);
        }
        $this->response($response);
    }

    function detalle_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_ticket")) {

            $data = [
                "info_ticket" => $this->tickets_model->get_info_ticket($param),
                "info_tareas" => $this->get_tareas_ticket($param),
                "info_num_tareas" => $this->get_tareas_ticket_num($param),
            ];

            $this->response(format_tareas($data));

        }

        $this->response($response);
    }

    private function get_tareas_ticket($q)
    {


        return $this->app->api("tarea/ticket/format/json/", $q);

    }

    private function get_tareas_ticket_num($q)
    {

        return $this->app->api("tarea/tareas_ticket_num/format/json/", $q);

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "prioridad,departamento,asunto")) {
            $id_usuario = prm_def($param, "id_usuario", $this->id_usuario);

            $param["id_usuario"] = $id_usuario;

            $params =
                [
                    "asunto" => $param["asunto"],
                    "prioridad" => $param["prioridad"],
                    "id_usuario" => $param["id_usuario"],
                    "id_departamento" => $param["departamento"],
                ];

            $param["ticket"] = $this->tickets_model->insert($params, 1);
            $es_cliente = $this->get_es_cliente($id_usuario);

            if ($es_cliente == 1) {
                $this->notificacion_ticket_soporte($param);
            }
            $response = $param["ticket"];
        }
        $this->response($response);

    }

    private function get_es_cliente($id_usuario)
    {

        return $this->app->api("usuario_perfil/es_cliente/format/json/",
            ["id_usuario" => $id_usuario]);
    }

    private function notificacion_ticket_soporte($param)
    {


        $id_usuario = $param["id_usuario"];
        $usuario = $this->app->usuario($id_usuario);
        $id_ticket = $param["ticket"];
        $ticket = $this->tickets_model->get_resumen_id($id_ticket);
        $q["usuario"] = $usuario;
        $q["extra"] = $param;
        $q["ticket"] = $ticket;
        $q["mensaje"] = $param["mensaje"];
        $soporte = ["soporte@eniservice.com"];
        $direccion = ["soporte@eniservice.com", "aritgrey@gmail.com"];

        $q["lista_correo_dirigido_a"] = ($param["departamento"] == 4) ? $soporte : $direccion;
        $q["mensaje"] = $this->get_mensaje_notificacion($q);
        $q["asunto"] = $param["asunto"];

        return $this->enviar($q);

    }

    /*Se cancela la órden de compra*/

    private function get_mensaje_notificacion($q)
    {

        return $this->app->api("cron/ticket_soporte/", $q, "html", "GET");

    }

    private function enviar($q)
    {

        return $this->app->api("areacliente/enviar/", $q, "json", "POST");
    }

    function form_GET()
    {

        $this->response(get_format_tickets($this->get_departamentos($this->get())));
    }

    private function get_departamentos($q)
    {

        return $this->app->api("departamento/index/format/json/", $q);

    }

    function cancelar_form_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        $response = false;
        if (fx($param, "id_recibo,modalidad")) {
            $modalidad = $param["modalidad"];

            $recibo = ($modalidad == 1) ?
                $this->get_recibo_por_enviar($param) :
                $this->get_recibo_por_pagar($param);


            $response = form_cancelar_compra($recibo, $modalidad);
        }
        $this->response($response);

    }

    private function get_recibo_por_enviar($q)
    {

        return $this->app->api("recibo/recibo_por_enviar_usuario/format/json/", $q);
    }

    private function get_recibo_por_pagar($q)
    {

        return $this->app->api("recibo/recibo_por_pagar_usuario/format/json/", $q);
    }

    function cancelar_PUT()
    {

        $param = $this->put();
        $param["id_usuario"] = $this->id_usuario;

        $data_complete["registro"] = 0;

        if ($param["modalidad"] == 0) {

            $data["recibo"] = $this->get_recibo_por_pagar($param);
            $data_complete['id_servicio'] = $data["recibo"];
            if ($data["recibo"]["cuenta_correcta"] > 0) {

                $param["cancela_cliente"] = ($data["recibo"]["id_usuario"] == $param["id_usuario"]);
                $data_complete["registro"] = $this->cancelar_orden_compra($param);


            }

        } else {

            $data["recibo"] = $this->get_recibo_por_enviar($param);
            if ($data["recibo"]["cuenta_correcta"] == 1) {
                $param["cancela_cliente"] =
                    ($data["recibo"]["id_usuario_venta"] == $param["id_usuario"]) ? 0 : 1;

                /*Si la cuenta pertenece hay que realizar la cancelación del la órden de pago*/
                $data_complete["registro"] = $this->cancelar_orden_compra($param);
                $prm["id_recibo"] = $param["id_recibo"];
                $prm["usuario_notificado"] =
                $data_complete["info_cliente"] = $this->app->usuario($data["recibo"]["id_usuario"]);
                $data_complete["info_email"] = $this->notifica_venta_cancelada_a_cliente($prm);


            }
        }
        $this->response($data_complete);
    }

    private function cancelar_orden_compra($param)
    {

        $this->cancela_orden_compra($param);
        $id_servicio = $this->get_servicio_ppfp($param["id_recibo"]);

        return [
            "id_servicio" => $id_servicio,
            "gamificacion" => $this->gamificacion_negativa($id_servicio,
                $param["id_usuario"]),
        ];

    }

    private function cancela_orden_compra($q)
    {

        return $this->app->api("recibo/cancelar", $q, "json", "PUT");
    }

    private function get_servicio_ppfp($id_recibo)
    {

        return $this->app->api("recibo/servicio_ppfp/format/json/",
            ["id_recibo" => $id_recibo]);
    }

    private function gamificacion_negativa($id_servicio, $id_usuario)
    {
        $q = [
            "id_servicio" => $id_servicio,
            "type" => 2,
            "id" => $id_servicio,
            "id_usuario" => $id_usuario,

        ];

        return $this->app->api("servicio/add_gamification_servicio", $q, "json", "PUT");
    }

    private function notifica_venta_cancelada_a_cliente($q)
    {

        return $this->app->api("cobranza/cancelacion_venta/format/json/", $q);

    }

    function movimientos_usuario_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        $response["solicitud_saldo"] = $this->tickets_model->get_solicitudes_saldo($param);
        $this->response(solicitudes_saldo($response));

    }

    function ticket_desarrollo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "modulo")) {

            $data = [];
            $modulo = $param["modulo"];

            switch ($modulo) {
                case 1:
                    /*Cargamos data tickets desde la versión del vendedor y por producto*/
                    $data = $this->tickets_por_servicio($param);

                    return $this->load->view("tickets/principal_desarollo", $data);

                    break;

                case 2:
                    /*Cargamos data tickets desde la versión direccion*/
                    $tickets = $this->tickets_model->get_tickets_desarrollo($param);
                    if (count($tickets) == 0) {
                        $tickets = $this->tickets_model->get_tickets_desarrollo($param,
                            1);
                    }
                    $data["info_tickets"] = $tickets;
                    $data["status_solicitado"] = $param["status"];
                    $data["info_get"] = $param;

                    return $this->load->view("tickets/principal_desarollo", $data);

                    break;
                case 3:

                    $tickets = $this->tickets_model->get_tickets($param);
                    $response = format_tablero($tickets);

                    break;


                default:

                    break;
            }


        }
        $this->response($response);

    }

    function formulario_respuesta_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "tarea")) {

            $response = get_form_respuesta($param["tarea"]);
        }
        $this->response($response);

    }

    function estado_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "status,id_ticket")) {
            $response = $this->tickets_model->q_up("status", $param["status"],
                $param["id_ticket"]);
        }
        $this->response($response);
    }

    function nota_monetaria_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "nota_monetaria,id_ticket")) {
            $response = $this->tickets_model->q_up("nota_monetaria",
                $param["nota_monetaria"], $param["id_ticket"]);
        }
        $this->response($response);
    }

    function efecto_monetario_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "efecto_monetario,id_ticket")) {
            $response = $this->tickets_model->q_up("efecto_monetario",
                $param["efecto_monetario"], $param["id_ticket"]);
        }
        $this->response($response);
    }

    function efectivo_resultante_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "efectivo_resultante,id_ticket")) {
            $response = $this->tickets_model->q_up("efectivo_resultante",
                $param["efectivo_resultante"], $param["id_ticket"]);
        }
        $this->response($response);
    }

    function clientes_ab_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "clientes_ab,id_ticket")) {
            $response = $this->tickets_model->q_up("clientes_ab",
                $param["clientes_ab"], $param["id_ticket"]);
        }
        $this->response($response);
    }

    function asunto_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_ticket,asunto")) {
            $response = $this->tickets_model->q_up("asunto", $param["asunto"],
                $param["id_ticket"]);
        }
        $this->response($response);
    }


}
