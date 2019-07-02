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

        if (if_ext($param, "id_usuario,id_direccion,principal")) {

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

    function principal_PUT()
    {

        $param = $this->put();
        $response = false;
        if (if_ext($param, "id_usuario,id_direccion")) {
            if ($param["id_usuario"] > 0 && $param["id_direccion"] > 0) {

                $params_where = ["id_usuario" => $param["id_usuario"]];
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
        if (if_ext($param, "id_usuario")) {
            $response = $this->usuario_direccion_model->get_usuario_direccion($param["id_usuario"]);
        }
        $this->response($response);
    }

    function num_GET()
    {

        $param = $this->get();
        $response = false;
        if (if_ext($param, "id_usuario")) {
            $response = $this->usuario_direccion_model->get_num($param);
        }
        $this->response($response);
    }

    function direccion_envio_pedido_GET()
    {

        $param = $this->get();
        $id_usuario = $this->get_id_usuario($param);

        $response = "";
        if ($id_usuario > 0) {


            $data["id_usuario"] = $id_usuario;
            $param["id_usuario"] = $data["id_usuario"];
            $domicilio = $this->get_direccion_pedido($param);
            $data["registro_direccion"] = 0;

            if (es_data($domicilio)) {

                $domicilio = $this->get_domicilio_cliente($param);
                $data["registro_direccion"] = (es_data($domicilio)) ? 1 : 0;


            }

            if (es_data($domicilio)) {

                $domicilio = $this->get_data_direccion($domicilio[0]["id_direccion"]);

            }

            $data["data_saldo_pendiente"] = $this->get_recibo_saldo_pendiente($param);
            $data["info_envio_direccion"] = $domicilio;
            $data["param"] = $param;
            if ($data["registro_direccion"] == 0) {
                $data["info_usuario"] = $this->app->usuario($id_usuario);
            }

            $this->load->view("proyecto/domicilio_envio", $data);
        }else{

            $this->response($response);

        }

    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (if_ext($param, "id_usuario,id_direccion")) {
            $params = ["id_usuario" => $param["id_usuario"], 'id_direccion' => $param["id_direccion"]];
            $response = $this->usuario_direccion_model->insert($params);
        }
        $this->response($response);
    }

    function activos_con_direcciones_GET()
    {

        $param = $this->get();
        $response = false;

        if (if_ext($param, 'fecha_inicio,fecha_termino')) {
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

                    if (es_data($domicilio)) {
                        return $this->load->view("proyecto/domicilio_resumen", $data);
                    } else {

                        return $this->load->view("proyecto/domicilio", $data);
                    }
                    break;
                case 2:
                    return $this->load->view("proyecto/domicilio", $data);
                    break;
                default:
                    return $this->load->view("proyecto/domicilio", $data);
                    break;
            }
        }
        $this->response($response);

    }

    function all_GET()
    {

        $param = $this->get();
        $response = [];

        if (if_ext($param, "id_usuario")) {

            $id_usuario = $param["id_usuario"];
            $params_where = ["id_usuario" => $id_usuario, "status" => 1];
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

    private function get_domicilio_cliente($param)
    {

        $direccion = $this->usuario_direccion_model->get_usuario_direccion($param["id_usuario"]);
        if (count($direccion) > 0) {
            return $this->get_data_direccion($direccion[0]["id_direccion"]);
        }
        return $direccion;
    }

    private function get_data_direccion($id_direccion)
    {

        $q["id_direccion"] = $id_direccion;
        $api = "direccion/data_direccion/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_direccion_pedido($q)
    {

        $api = "proyecto_persona_forma_pago_direccion/recibo/format/json/";
        return $this->app->api($api, $q);

    }

    private function get_recibo_saldo_pendiente($q)
    {

        $api = "recibo/saldo_pendiente_recibo/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_id_usuario($param)
    {

        return ($this->app->is_logged_in() > 0) ? $this->id_usuario : (get_param_def($param, "id_usuario"));
    }
}