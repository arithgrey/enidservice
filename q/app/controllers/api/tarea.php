<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tarea extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("tareasmodel");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function estado_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "nuevo_valor,id_tarea")) {
            $response = $this->tareasmodel->update_estado_tarea($param);
        }
        $this->response($response);
    }

    function descripcion_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "descripcion,id_tarea")) {
            $response = $this->tareasmodel->q_up(
                "descripcion", $param["descripcion"], $param["id_tarea"]);
        }
        $this->response($response);
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "tarea,id_ticket")) {
            $param["id_usuario"] = $this->app->get_session("id_usuario");

            if ($param["id_usuario"] > 0) {
                $params = [
                    "descripcion" => $param["tarea"],
                    "id_ticket" => $param["id_ticket"],
                    "usuario_registro" => $param["id_usuario"]
                ];

                $response = $this->tareasmodel->insert($params);

                if ($response == true) {
                    $this->set_stado_ticket($this->valida_tareas_pendientes($param));
                }
            }
        }
        $this->response($response);
    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id_tarea")) {

            $response = $this->tareasmodel->q_delete($param["id_tarea"]);

        }
        $this->response($response);
    }

    private function set_stado_ticket($q)
    {


        return $this->app->api("tickets/estado", $q, "json", "PUT");

    }

    private function valida_tareas_pendientes($param)
    {

        $pendientes = $this->tareasmodel->get_tareas_ticket_num($param);
        $num_pendientes = pr($pendientes, "pendientes");

        $q = [
            "status" => ($num_pendientes > 0) ? 0 : 1,
            "id_ticket" => $param["id_ticket"],
            "num_tareas" => $num_pendientes
        ];
        return $q;
    }

    function buzon_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "tarea,id_ticket,id_usuario")) {
            $params = [
                "descripcion" => $param["tarea"],
                "id_ticket" => $param["id_ticket"],
                "usuario_registro" => $param["id_usuario"]
            ];
            $response = $this->tareasmodel->insert($params);
        }
        $this->response($response);
    }

    function ticket_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "id_ticket")) {

            $response = $this->tareasmodel->get_tareas_ticket($param);
        }
        $this->response($response);
    }

    function tareas_ticket_num_GET()
    {

        $this->response($this->tareasmodel->get_tareas_ticket_num($this->get()));
    }

    function tareas_enid_service_GET()
    {

        $this->response($this->tareasmodel->tareas_enid_service($this->get()));
    }
}