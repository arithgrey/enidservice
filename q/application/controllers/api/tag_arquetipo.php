<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Tag_arquetipo extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("tag_arquetipo_model");
        $this->load->helper("arquetipo");
        $this->load->library(lib_def());
    }

    function index_GET()
    {


        $param = $this->get();
        $es_usuario = array_key_exists('usuario', $param);
        if ($es_usuario) {

            $response = $this->tag_arquetipo_model->get(
                [], ['id_usuario' => $param['usuario']], 100, 'id_tipo_tag_arquetipo', 'ASC');

        } else {

            $response = $this->tag_arquetipo_model->get();
        }
        $this->response($response);


    }

    function q_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, 'fecha_inicio,fecha_termino,tipo_tag_arquetipo')) {
            $fecha_inicio = $param['fecha_inicio'];
            $fecha_termino = $param['fecha_termino'];
            $tipo_tag_arquetipo = $param['tipo_tag_arquetipo'];
            $data = $this->tag_arquetipo_model->q($fecha_inicio, $fecha_termino, $tipo_tag_arquetipo);
            $response = render_historial($data);
        }
        $this->response($response);


    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "tag,tipo,usuario")) {

            $params = [
                'tag' => $param['tag'],
                'id_tipo_tag_arquetipo' => $param['tipo'],
                'id_usuario' => $param['usuario']
            ];

            if (prm_def($param, 'intento_reventa') > 0) {


                $this->reventa($param, $params);

            } else {

                $response = $this->tag_arquetipo_model->insert($params);

            }

        }

        $this->response($response);

    }

    function interes_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, "tag,tipo,usuario,recibo")) {

            $params = [
                'tag' => $param['tag'],
                'id_tipo_tag_arquetipo' => $param['tipo'],
                'id_usuario' => $param['usuario']
            ];

            $response = $this->tag_arquetipo_model->insert($params);
            if ($response) {

                $response = $this->notifica_registro_articulo_interes($param['recibo']);
            }

        }
        $this->response($response);

    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->tag_arquetipo_model->q_delete($param["id"]);

        }
        $this->response($response);

    }

    private function reventa($param, $data_arquetipo)
    {

        $response = false;
        $id_orden_compra = $param["orden_compra"];
        $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
        foreach ($productos_orden_compra as $row) {

            $id_recibo
                = $row["id_proyecto_persona_forma_pago"];

            $response = $this->app->api("recibo/reventa", ["recibo" => $id_recibo], 'json', 'PUT');

            if (fx($param, "accion_reventa")) {

                $data_comentarios = [
                    'id_recibo' => $id_recibo,
                    'comentarios' => $param['accion_reventa']
                ];
                $this->app->api("orden_comentario/index", $data_comentarios, 'json', 'POST');
            }
        }

        if (prm_def($param, 'interes')) {

            $response = $this->tag_arquetipo_model->insert($data_arquetipo);

        }
        return $response;

    }

    function articulos_interes_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "recibo,id_usuario")) {

            $response = form_articulos_interes($param);
        }
        $this->response($response);

    }

    function notifica_registro_articulo_interes($id_recibo)
    {

        return $this->app->api("recibo/registro_articulo_interes", ["id" => $id_recibo], "json", "PUT");
    }

}