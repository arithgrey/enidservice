<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class ubicacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("ubicacion_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function frecuentes_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, 'id_ubicacion,id_recibo')) {

            $id_recibo = $param['id_recibo'];
            $id_ubicacion = $param['id_ubicacion'];
            $ubicacion = $this->ubicacion_model->q_get(['ubicacion'], $id_ubicacion);
            $recibo = $this->app->api("recibo/id/format/json/", ["id" => $id_recibo]);
            if (es_data($ubicacion) && es_data($recibo)) {

                $this->elimina_direccion_previa_envio($id_recibo);
                $status = $this->elimina_direccion_punto_encuentro($id_recibo);

                $this->app->api("recibo/ubicacion/", ["id_recibo" => $id_recibo], "JSON", "PUT");

                $ubicacion = pr($ubicacion, 'ubicacion');
                $id_usuario = pr($recibo, 'id_usuario');

                $params =
                    [
                        'ubicacion' => $ubicacion,
                        'id_recibo' => $id_recibo,
                        'id_usuario' => $id_usuario
                    ];

                $asignacion = $this->ubicacion_model->insert($params);

                $link_pago = path_enid('area_cliente_compras', $id_recibo);
                $link_seguimiento = path_enid('pedido_seguimiento', $id_recibo);
                $session = $this->app->session();
                $siguiente = es_cliente($session) ? $link_pago : $link_seguimiento;
                $response = [
                    'asignacion' => $asignacion,
                    'siguiente' => $siguiente
                ];

            }
        }

        $this->response($response);
    }

    private function elimina_direccion_previa_envio($id_recibo)
    {

        $q = ['id_recibo' => $id_recibo];
        return $this->app->api("proyecto_persona_forma_pago_direccion/index", $q, "json", "DELETE");
    }

    private function elimina_direccion_punto_encuentro($id_recibo)
    {
        $q["id_recibo"] = $id_recibo;

        return $this->app->api("proyecto_persona_forma_pago_punto_encuentro/index", $q,
            "json", "DELETE");
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, 'id_recibo,ubicacion,fecha_entrega,horario_entrega')) {

            $id_recibo = $param['id_recibo'];
            $fecha_entrega = $param['fecha_entrega'];
            $horario_entrega = $param['horario_entrega'];
            $recibo = $this->app->api("recibo/id/format/json/", ["id" => $id_recibo]);

            if (es_data($recibo)) {
                $params =
                    [
                        'ubicacion' => $param['ubicacion'],
                        'id_recibo' => $id_recibo,
                        'id_usuario' => pr($recibo, 'id_usuario')
                    ];

                $id_ubicacion = $this->ubicacion_model->insert($params, 1);

                if ($id_ubicacion > 0) {

                    $id = $this->cambio_fecha_entrega($id_recibo, $fecha_entrega, $horario_entrega);
                }

                $es_cliente = es_cliente($this->app->session());
                $area_cliente = path_enid('area_cliente_compras', _text($id_recibo, "&primercompra=1"));
                $seguimiento = path_enid('pedidos_recibo', $id_recibo);
                $siguiente = ($es_cliente) ? $area_cliente : $seguimiento;

                $response = [
                    'id_ubicacion' => $id_ubicacion,
                    'es_cliente' => $es_cliente,
                    'id_recibo' => $id_recibo,
                    'siguiente' => $siguiente
                ];
            }


        }
        $this->response($response);
    }

    function index_GET()
    {

        $param = $this->GET();
        $response = false;

        if (fx($param, 'id_recibo')) {

            $id_recibo = $param['id_recibo'];
            $in = [
                'id_recibo' => $id_recibo,
            ];
            $response = $this->ubicacion_model->get([], $in, 1, 'id_ubicacion');

        }
        $this->response($response);
    }

    function usuario_GET()
    {

        $param = $this->GET();
        $response = false;
        if (fx($param, 'id_usuario')) {

            $id_usuario = $param['id_usuario'];
            $in = [
                'id_usuario' => $id_usuario,
            ];
            $response = $this->ubicacion_model->get([], $in, 10, 'id_ubicacion');
        }
        $this->response($response);


    }

    private function cambio_fecha_entrega($id_recibo, $fecha_entrega, $horario_engrega)
    {
        $q = [
            'fecha_entrega' => $fecha_entrega,
            'horario_entrega' => $horario_engrega,
            'recibo' => $id_recibo,
            'contra_entrega_domicilio' => 1,
            'tipo_entrega' => 2,
            'ubicacion' => 1,
        ];
        $this->app->api("recibo/fecha_entrega", $q, "json", "PUT");
    }

    private function get_recibo($id_recibo)
    {
        $in = [
            'id_recibo' => $id_recibo,
        ];
        return $this->ubicacion_model->get([], $in, 1, 'id_ubicacion');

    }

}