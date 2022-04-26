<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class ubicacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("ubicacion_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function frecuentes_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, 'id_ubicacion,id_recibo')) {

            $id_recibo = $param['id_recibo'];
            $id_ubicacion = $param['id_ubicacion'];
            $ubicacion = $this->ubicacion_model->q_get(['ubicacion'], $id_ubicacion);
            $recibo = $this->app->api("recibo/id", ["id" => $id_recibo]);
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

        if (fx($param, 'id_orden_compra,ubicacion,fecha_entrega,horario_entrega')) {

            $id_orden_compra = $param['id_orden_compra'];
            $fecha_entrega = $param['fecha_entrega'];
            $horario_entrega = $param['horario_entrega'];

            $productos_ordenes_compra = $this->app->productos_ordenes_compra($id_orden_compra);
            $reparto = false;
            foreach ($productos_ordenes_compra as $row) {

                $id_recibo = $row["id"];
                $params =
                    [
                        'ubicacion' => $param['ubicacion'],
                        'id_recibo' => $id_recibo,
                        'id_usuario' => $row['id_usuario']
                    ];

                $this->ubicacion_model->insert($params, 1);

            }

            $reparto = $this->app->asigna_reparto($id_orden_compra);
            $this->cambio_fecha_entrega($id_orden_compra, $fecha_entrega, $horario_entrega);
            $es_cliente = es_cliente($this->app->session());

            $area_cliente = path_enid('area_cliente_compras', _text($id_orden_compra, "&primercompra=1"));
            $seguimiento = path_enid('pedidos_recibo', $id_orden_compra);
            $siguiente = ($es_cliente) ? $area_cliente : $seguimiento;

            $response = [
                'es_cliente' => $es_cliente,
                'siguiente' => $siguiente,
                'asignacion_repatidor' => $reparto,
                'orden_compra' => $id_orden_compra

            ];
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

    private function cambio_fecha_entrega($id_orden_compra, $fecha_entrega, $horario_engrega)
    {
        $q = [
            'fecha_entrega' => $fecha_entrega,
            'horario_entrega' => $horario_engrega,
            'orden_compra' => $id_orden_compra,
            'contra_entrega_domicilio' => 1,
            'tipo_entrega' => 2,
            'ubicacion' => 1,
        ];
        return $this->app->api("recibo/fecha_entrega", $q, "json", "PUT");
    }

    private function get_recibo($id_recibo)
    {
        $in = [
            'id_recibo' => $id_recibo,
        ];
        return $this->ubicacion_model->get([], $in, 1, 'id_ubicacion');

    }

    function ids_recibo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "ids")) {

            $response = $this->ubicacion_model->in_recibo($param['ids']);

        }
        $this->response($response);
    }


}