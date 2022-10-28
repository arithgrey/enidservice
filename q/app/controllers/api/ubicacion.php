<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class ubicacion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("ubicacion_model");
        $this->load->library('table');
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

                $this->app->api("recibo/ubicacion", ["id_recibo" => $id_recibo], "JSON", "PUT");

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

        return $this->app->api(
            "proyecto_persona_forma_pago_punto_encuentro/index",
            $q,
            "json",
            "DELETE"
        );
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, 'id_orden_compra,ubicacion,fecha_entrega,horario_entrega')) {

            $id_orden_compra = $param['id_orden_compra'];

            $productos_ordenes_compra = $this->app->productos_ordenes_compra($id_orden_compra);
            $reparto = false;
            foreach ($productos_ordenes_compra as $row) {

                $id_recibo = $row["id"];
                $params =
                    [
                        'ubicacion' => $param['ubicacion'],
                        'id_recibo' => $id_recibo,
                        'id_usuario' => $row['id_usuario'],
                        'cp' => prm_def($param, 'cp'),
                        'id_alcaldia' => prm_def($param, 'delegacion'),
                        'delegacion' =>  prm_def($param, 'text_delegacion'),
                    ];

                $this->ubicacion_model->insert($params, 1);
            }

            $reparto = $this->app->asigna_reparto($id_orden_compra, 1);
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
            //$response = $this->ubicacion_model->get([], $in, 1, 'id_ubicacion');
            $response = $this->ubicacion_model->recibo_codigo_postal($id_recibo);
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
    function ventas_mes_GET()
    {


        $this->response($this->ubicacion_model->ventas_mes());
    }

    function penetracion_tiempo_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, 'fecha_inicio,fecha_termino')) {

            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $ventas_efectivas_fecha_ubicacion = $this->ventas_efectivas_fecha($fecha_inicio, $fecha_termino);
            $response = [];

            $penetracion  = $this->ubicacion_model->penetracion_tiempo($fecha_inicio, $fecha_termino);
            
            $heading = [
                "Alcaldía",
                "Leads",
                "Ventas Efectivas"
            ];

            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);
            $total = 0;
            $total_ventas = 0;

            foreach ($penetracion as $row) {

                $id_alcaldia = $row["id_alcaldia"];
                $ventas_efectivas = $this->busqueda_total_ventas_efectivas_alcaldia($id_alcaldia, $ventas_efectivas_fecha_ubicacion);
                $cantidad = $row["total"];

                $linea = [
                    $row["delegacion"],
                    $cantidad,
                    $ventas_efectivas
                ];
                $this->table->add_row($linea);
                $total = $total + $cantidad;
                $total_ventas  = $total_ventas + $ventas_efectivas;
            }
            $this->table->add_row([d("Total",'strong'), d($total,"strong" ), d($total_ventas,"strong")]);
            
            $response[] = $this->table->generate();
            $response[] = hiddens(["class" =>"penetracion_leads","value" => $total]);
            $response[] = hiddens(["class" =>"penetracion_leads_ventas","value" => $total_ventas]);
        }
        $this->response(append($response));
    }
    private function busqueda_total_ventas_efectivas_alcaldia($id_alcaldia, $data_alcaldias){

        $total = 0;
        foreach($data_alcaldias as $key => $value){

            if($id_alcaldia ==  $key){

                $total =  $value;
                break;
            }
        }
        return $total;
    }
    private function ventas_efectivas_fecha($fecha_inicio, $fecha_termino)
    {
        
        $response = [];
        
        $q = [
            "cliente" => "",
            "v" => 0,
            "recibo" => "",
            "tipo_entrega" => 0,
            "status_venta" => 0,
            "tipo_orden" => 2,
            "fecha_inicio" => $fecha_inicio,
            "fecha_termino" => $fecha_termino,
            "perfil" => 3,
            "id_usuario" => 1,
            "usuarios" => 0,
            "ids" => 0,
            "es_busqueda_reparto" => 1,
            "id_usuario_referencia" => 0,
            "consulta" => 1
        ];

        $recibos = $this->app->api("recibo/pedidos", $q);

        if(es_data($recibos)){
            
            $ids  = array_column($recibos, "recibo");            
            $ids_recibos  = implode(  ",", $ids);
            $ubicaciones = $this->ubicacion_model->in_recibo($ids_recibos);
            $ids_alcaldias = array_column($ubicaciones, "id_alcaldia");
            $response = array_count_values($ids_alcaldias);
    
        }
        return $response;
        
    }

}
