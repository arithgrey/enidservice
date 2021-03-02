<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class lista_negra extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("lista_negra_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function desbloqueo_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "id_usuario,recibo")) {

            $in = ['id_usuario' => $param['id_usuario']];
            $response = $this->lista_negra_model->delete($in);
            $response = $this->venta_en_curso($param['recibo']);
        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario,id_motivo")) {

            $id_usuario = $param['id_usuario'];
            $id_motivo = $param['id_motivo'];
            if ($id_motivo > 0) {

                $params = [
                    "id_usuario" => $id_usuario,
                    "id_motivo" => $id_motivo
                ];

            } else {

                $q = [
                    'motivo' => $param['motivo_lista_negra'],
                    'tipo' => $param['tipo']
                ];
                $id_motivo = $this->registro_motivo_lista_negra($q);
                $params = [
                    "id_usuario" => $id_usuario,
                    "id_motivo" => $id_motivo
                ];
            }
            $response = $this->lista_negra_model->insert($params, 1);
            if ($response > 0) {
                $this->usuario_lista_negra($id_usuario);
                $response = $this->envia_lista_negra($param);
            }

        }
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $in = ["id_usuario" => $param['id_usuario']];
            $response = $this->response($this->lista_negra_model->get([], $in, 100));
        }
        $this->response($response);

    }

    function q_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "usuarios")) {

            $response = $this->lista_negra_model->q($param['usuarios']);

        }

        $this->response($response);

    }

    function registro_motivo_lista_negra($q)
    {
        return $this->app->api("motivo_lista_negra/index/format/json/", $q, 'json', 'POST');
    }

    function usuario_lista_negra($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $q["status"] = 3;
        return $this->app->api("usuario/status", $q, "json", "PUT");
    }

    function envia_lista_negra($param)
    {

        $q["id_recibo"] = prm_def($param, 'id_recibo');
        $q["telefono"] = prm_def($param, 'telefono');
        return $this->app->api("recibo/lista_negra", $q, "json", "PUT");
    }

    function venta_en_curso($id_recibo)
    {

        $q = [
            'orden_compra' => $id_recibo,
            'es_proceso_compra' => 1,
            'status' => 6,
        ];
        return $this->app->api("recibo/status", $q, "json", "PUT");
    }


}