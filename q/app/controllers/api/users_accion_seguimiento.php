<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

use Enid\AccionesSeguimiento\Clientes;


class users_accion_seguimiento extends REST_Controller
{
    private $acciones_seguimiento_clientes;
    function __construct()
    {
        parent::__construct();
        $this->load->model("users_accion_seguimiento_model");
        $this->load->library(lib_def());
        $this->acciones_seguimiento_clientes = new Clientes();
    }

    function index_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, "comentario,id_usuario,id_accion_seguimiento")) {

            $params = [
                "comentario" => $param["comentario"],
                "id_accion_seguimiento" => $param["id_accion_seguimiento"],
                "id_usuario " => $param["id_usuario"]
            ];

            if (str_len(prm_def($param, "fecha_evento"), 5)) {
                $params["fecha_evento"] = $param["fecha_evento"];
                $params["evento_pendiente"] = 1;
            }

            $response = $this->users_accion_seguimiento_model->insert($params, 1);
        }
        $this->response($response);
    }

    function usuario_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $acciones_seguimiento = $this->users_accion_seguimiento_model->usuario($param["id"]);
            
            $response = $this->acciones_seguimiento_clientes->formatoListado($acciones_seguimiento);
        }
        $this->response($response);
    }
    function eventos_pendientes_GET()
    {

        $acciones_seguimiento = $this->users_accion_seguimiento_model->eventos_pendientes();
        $acciones_seguimiento_imagen_usuario = $this->app->add_imgs_usuario($acciones_seguimiento,"id_usuario");
        
        $response = $this->acciones_seguimiento_clientes->formato_eventos(
            $acciones_seguimiento_imagen_usuario);
            
        $this->response($response);
    }

    function comentario_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id,comentario")) {

            $comentario = $param["comentario"];
            $id = $param["id"];
            $response = $this->users_accion_seguimiento_model->q_up("comentario", $comentario, $id);
        }
        $this->response($response);
    }

    function evento_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {
            
            $id = $param["id"];
            $response = $this->users_accion_seguimiento_model->q_up("evento_pendiente", 0, $id);
        }
        $this->response($response);
    }

    function notificacion_accion_seguimiento_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $id_usuario = $param["id_usuario"];
            $recibos = $this->app->recibos_usuario($id_usuario, 1);
        }
        $this->response($response);
    }


    
}
