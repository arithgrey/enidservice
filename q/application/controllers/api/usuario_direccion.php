<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_direccion extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("usuario_direccion");
        $this->load->model("usuario_direccion_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index_PUT()
    {

        $param = $this->put();
        $response = [];

        if (fx($param, "id_usuario,id_direccion,principal")) {

            $id_usuario = $param["id_usuario"];

            if ($param["principal"] == 1) {

                $set = ["principal" => 0];
                $in = ["id_usuario" => $id_usuario];
                $this->usuario_direccion_model->update($set, $in, 10);
            }
            $response = $this->usuario_direccion_model->insert($param, 1);
        }

        $this->response($response);

    }

    function quitar_PUT()
    {

        $param = $this->put();
        $response = [];

        if (fx($param, "id_direccion,id_usuario")) {

            $in = [
                "id_direccion" => $param['id_direccion'],
                "id_usuario" => $param['id_usuario'],
            ];
            $set = ["status" => 0];
            $response = $this->usuario_direccion_model->update($set, $in, 10);
        }
        $this->response($response);

    }

    function principal_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_usuario,id_direccion")) {
            if ($param["id_usuario"] > 0 && $param["id_direccion"] > 0) {

                $params_where = [
                    "id_usuario" => $param["id_usuario"],
                ];

                $response =
                    $this->usuario_direccion_model->delete($params_where, 10);

            }
        }
        $this->response($response);

    }

    function id_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_direccion_model->get_usuario_direccion($param["id_usuario"]);
        }
        $this->response($response);
    }

    function num_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_direccion_model->get_num($param);
        }
        $this->response($response);
    }

    function valida_cita_domicilio($param, $id_usuario)
    {
        $session = $param['session'];
        $es_administrador_o_vendedor = es_administrador_o_vendedor($session);
        if ($es_administrador_o_vendedor) {

            $id_recibo = $param['id_recibo'];
            $qrecibo = [
                'recibo' => $id_recibo
            ];
            $recibo = $this->app->api("recibo/index/format/json/", $qrecibo);
            $id_usuario = pr($recibo, 'id_usuario');
        }
        return $id_usuario;


    }

    function direccion_envio_pedido_GET()
    {

        $param = $this->get();
        $id_usuario = $this->valida_cita_domicilio($param, $this->get_id_usuario($param));

        $response = [];
        $data["id_usuario"] = $id_usuario;
        $param["id_usuario"] = $id_usuario;
        $usuario = [];
        $registro_direccion = 0;
        if ($id_usuario > 0) {

            $domicilio = $this->get_direccion_pedido($param);

            if (es_data($domicilio)) {

                $domicilio = $this->get_domicilio_cliente($param);
                $registro_direccion = es_data($domicilio);
            }

            if (es_data($domicilio)) {

                $domicilio = $this->get_data_direccion(pr($domicilio, "id_direccion"));

            }

            $data["data_saldo_pendiente"] = $this->get_recibo_saldo_pendiente($param);
            $data["info_envio_direccion"] = $domicilio;
            $data["param"] = $param;

            if ($registro_direccion < 1) {

                $usuario = $this->app->usuario($id_usuario);
            }

            $data["info_usuario"] = $usuario;
            $data['registro_direccion'] = $registro_direccion;


            $data = $this->agrega_fecha_disponible_servicio($param, $data);

            $form[] = format_direccion_envio($data);
            $form[] = form_ubicacion_escrita($param);
            $response = append($form);


        }

        $this->response($response);

    }

    private function agrega_fecha_disponible_servicio($param, $data)
    {


        if (fx($param, "id_recibo")) {


            $id_servicio = $this->servicio_por_recibo($param['id_recibo']);
            $data['servicio'] = $this->app->servicio($id_servicio);

        }
        return $data;

    }

    private function servicio_por_recibo($id_recibo)
    {

        $q = ["id_recibo" => $id_recibo];
        return $this->app->api("recibo/servicio_ppfp/format/json/", $q);

    }

    private function get_id_usuario($param)
    {

        return ($this->app->is_logged_in() > 0) ? $this->id_usuario : (prm_def($param,
            "id_usuario"));
    }

    private function get_direccion_pedido($q)
    {

        return $this->app->api("proyecto_persona_forma_pago_direccion/recibo/format/json/",
            $q);

    }

    private function get_domicilio_cliente($param)
    {

        $direccion = $this->usuario_direccion_model->get_usuario_direccion($param["id_usuario"]);
        if (es_data($direccion)) {

            return $this->get_data_direccion(pr($direccion, "id_direccion"));
        }

        return $direccion;
    }

    private function get_data_direccion($id_direccion)
    {


        return $this->app->api(
            "direccion/data_direccion/format/json/",
            [
                "id_direccion" => $id_direccion,
            ]
        );
    }

    private function get_recibo_saldo_pendiente($q)
    {

        return $this->app->api("recibo/saldo_pendiente_recibo/format/json/", $q);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario,id_direccion")) {
            $params = [
                "id_usuario" => $param["id_usuario"],
                'id_direccion' => $param["id_direccion"],
            ];
            $response = $this->usuario_direccion_model->insert($params);
        }
        $this->response($response);
    }

    function activos_con_direcciones_GET()
    {

        $param = $this->get();
        $response = false;

        if (fx($param, 'fecha_inicio,fecha_termino')) {
            $response = $this->usuario_direccion_model->activos_con_direcciones($param);

        }
        $this->response($response);
    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;
        $param["id_usuario"] = $this->id_usuario;
        if ($param["id_usuario"] > 0) {

            $domicilio = $this->get_domicilio_cliente($param);
            $data["info_envio_direccion"] = $domicilio;
            $data["param"] = $param;


            switch ($param["v"]) {

                case 0:
                    $response = $data;
                    break;

                case 1:

                    $response = (es_data($domicilio)) ? format_domicilio_resumen($data) : format_direccion($data);

                    break;
                case 2:

                    $response = format_direccion($data);

                    break;

                default:
                    $response = format_direccion($data);
                    break;
            }
        }
        $this->response($response);

    }

    function all_GET()
    {

        $param = $this->get();
        $response = [];

        if (fx($param, "id_usuario")) {

            $params_where = [
                "id_usuario" => $param["id_usuario"],
                "status" => 1,
            ];

            $direcciones = $this->usuario_direccion_model->get(
                [],
                $params_where,
                10,
                'fecha_registro');

            foreach ($direcciones as $row) {

                $direccion = $this->get_data_direccion($row["id_direccion"]);
                if (es_data($direccion)) {

                    $response[] = $direccion[0];
                }

            }
        }
        $this->response($response);

    }
}