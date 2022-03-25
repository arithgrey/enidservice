<?php defined('BASEPATH') or exit('No direct script access allowed');
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
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function pendientes_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $response = $this->tickets_model->get(
                [
                    "id_ticket", "asunto"
                ],
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


        return $this->app->api("tarea/ticket", $q);

    }

    private function get_tareas_ticket_num($q)
    {

        return $this->app->api("tarea/tareas_ticket_num", $q);

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "prioridad,departamento,asunto,tiempo_estimado")) {
            $id_usuario = prm_def($param, "id_usuario", $this->id_usuario);

            $param["id_usuario"] = $id_usuario;

            $params =
                [
                    "asunto" => $param["asunto"],
                    "prioridad" => $param["prioridad"],
                    "id_usuario" => $param["id_usuario"],
                    "id_departamento" => $param["departamento"],
                    "tiempo_estimado" => $param["tiempo_estimado"],
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

        return $this->app->api("usuario_perfil/es_cliente",
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

        return $this->app->api("cron/ticket_soporte", $q, "html", "GET");

    }

    private function enviar($q)
    {

        return $this->app->api("areacliente/enviar/", $q, "json", "POST");
    }

    function form_GET()
    {

        $this->response(frm_ticket($this->get_departamentos($this->get())));
    }

    private function get_departamentos($q)
    {

        return $this->app->api("departamento/index", $q);

    }

    function cancelar_form_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        $response = false;
        if (fx($param, "id_orden_compra,modalidad")) {
            $modalidad = $param["modalidad"];
            $id_orden_compra = $param["id_orden_compra"];
            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);

            $recibos = [];
            foreach ($productos_orden_compra as $row) {

                $id_recibo = $row["id_proyecto_persona_forma_pago"];
                $param["id_recibo"] = $id_recibo;

                $recibos[] = ($modalidad == 1) ?
                    $this->get_recibo_por_enviar($param) :
                    $this->get_recibo_por_pagar($id_recibo, $this->id_usuario);

            }

            $response = form_cancelar_compra($id_orden_compra, $recibos, $modalidad);

        }
        $this->response($response);

    }

    private function get_recibo_por_enviar($q)
    {

        return $this->app->api("recibo/recibo_por_enviar_usuario", $q);
    }

    private function get_recibo_por_pagar($id_recibo, $id_usuario)
    {

        $q = [
            "id_recibo" => $id_recibo,
            "id_usuario" => $id_usuario
        ];

        return $this->app->api("recibo/recibo_por_pagar_usuario", $q);

    }

    function cancelar_PUT()
    {

        $param = $this->put();
        $param["id_usuario"] = $this->id_usuario;

        $data_complete["registro"] = 0;

        if ($param["modalidad"] == 0) {

            $productos_orden_compra = $this->app->productos_ordenes_compra($param["id_orden_compra"]);

            foreach ($productos_orden_compra as $row) {

                $id_recibo = $row["id_proyecto_persona_forma_pago"];
                $param["id_recibo"] = $id_recibo;
                $data["recibo"] = $this->get_recibo_por_pagar($id_recibo, $this->id_usuario);
                $data_complete['id_servicio'] = $data["recibo"];
                $recibo = $data["recibo"];
                $es_cuenta_correcta = $recibo["cuenta_correcta"];
                if (intval($es_cuenta_correcta) > 0) {


                    $param["cancela_cliente"] = ($recibo["id_usuario"] == $param["id_usuario"]);
                    $param["id_servicio"] = $row["id_servicio"];
                    $data_complete["registro"] = $this->cancelar_orden_compra($param);

                }
            }


        } else {

            $data["recibo"] = $this->get_recibo_por_enviar($param);
            if ($data["recibo"]["cuenta_correcta"] == 1) {
                $param["cancela_cliente"] =
                    ($data["recibo"]["id_usuario_venta"] == $param["id_usuario"]) ? 0 : 1;

                /*Si la cuenta pertenece hay que
                realizar la cancelación del la órden de pago*/
                $data_complete["registro"] =
                    $this->cancelar_orden_compra($param);
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
        $id_recibo = $param["id_recibo"];
        $id_servicio = $param["id_servicio"];
        $this->cancela_orden_compra($id_recibo, $id_servicio);
        $gamificacion = $this->gamificacion_negativa($id_servicio, $param["id_usuario"]);

        return [
            "id_servicio" => $id_servicio,
            "gamificacion" => $gamificacion,
        ];

    }

    private function cancela_orden_compra($id_recibo)
    {

        $q = [
            "id_recibo" => $id_recibo
        ];
        return $this->app->api("recibo/cancelar", $q, "json", "PUT");
    }

    private function get_servicio_ppfp($id_recibo)
    {

        return $this->app->api("recibo/servicio_ppfp", ["id_recibo" => $id_recibo]);
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

        return $this->app->api("cobranza/cancelacion_venta", $q);

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

                    $param['id_usuario'] = $this->id_usuario;
                    $tickets = $this->tickets_model->get_tickets($param);
                    $comparativa = $this->comparativa();
                    $response = format_tablero($tickets, $comparativa);

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
            $status = $param["status"];
            $id = $param["id_ticket"];
            if ($status == 2) {

                $response = $this->tickets_model->liberacion($id);

            } else {

                $response = $this->tickets_model->q_up("status", $status, $id);
            }

        }
        $this->response($response);
    }


    function tiempo_estimado_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "tiempo_estimado,id_ticket")) {
            $tiempo_estimado = $param["tiempo_estimado"];
            $id = $param["id_ticket"];
            $response = $this->tickets_model->q_up("tiempo_estimado", $tiempo_estimado, $id);
        }
        $this->response($response);
    }

    function comparativa_GET()
    {

        $this->response($this->comparativa());
    }

    function comparativa()
    {
        return $this->tickets_model->resumen_liberacion();
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

    function liberacion_PUT()
    {

        $this->response($this->tickets_model->liberar());
    }


}
