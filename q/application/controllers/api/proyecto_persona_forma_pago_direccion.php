<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class proyecto_persona_forma_pago_direccion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("proyecto_persona_forma_pago_direccion_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id_recibo")) {
            $response = $this->proyecto_persona_forma_pago_direccion_model->delete_por_id_recibo($param["id_recibo"]);
        }
        $this->response($response);
    }

    function recibo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, 'id_recibo')) {

            $id_recibo = $param["id_recibo"];
            if (array_key_exists('total', $param)) {

                $response = $this->proyecto_persona_forma_pago_direccion_model->count(
                    $id_recibo);

            } else {

                $response =
                    $this->proyecto_persona_forma_pago_direccion_model->get(
                        [],
                        [
                            "id_proyecto_persona_forma_pago" => $id_recibo,
                        ]
                    );
            }


        }
        $this->response($response);
    }

    function recibos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, 'ids_recibos,v')) {

            $response = $this->proyecto_persona_forma_pago_direccion_model->in($param['ids_recibos']);

        }
        $this->response($response);
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        if (fx($param, 'id_recibo,id_direccion')) {
            $params = [
                "id_proyecto_persona_forma_pago" => $param["id_recibo"],
                "id_direccion" => $param["id_direccion"],
            ];

            if (prm_def($param, "asignacion") > 0) {
                /*elimino la dirección previa*/
                $this->proyecto_persona_forma_pago_direccion_model->delete_por_id_recibo($param["id_recibo"]);
                $this->delete_direccion_punto_encuentro($param["id_recibo"]);
                $this->set_tipo_entrega($param["id_recibo"]);

            }

            $response = $this->proyecto_persona_forma_pago_direccion_model->insert($params);
        }
        $this->response($response);
    }

    private function delete_direccion_punto_encuentro($id_recibo)
    {
        $q["id_recibo"] = $id_recibo;

        return $this->app->api("proyecto_persona_forma_pago_punto_encuentro/index", $q,
            "json", "DELETE");
    }

    private function set_tipo_entrega($id_recibo)
    {

        $q = [
            "recibo" => $id_recibo,
            "tipo_entrega" => 2,

        ];

        return $this->app->api("recibo/tipo_entrega", $q, "json", "PUT");

    }

    function quitar_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, 'id_recibo,id_direccion,tipo')) {

            if ($param['tipo'] == 2) {

                $response = $this->quitar_domicilio_entrega($param);

            } else {
                $response = $this->quitar_punto_entrega($param);
            }

        }
        $this->response($response);
    }

    private function quitar_domicilio_entrega($param)
    {
        $id_recibo = $param["id_recibo"];
        $id_direccion = $param["id_direccion"];
        $response =
            $this->proyecto_persona_forma_pago_direccion_model->delete_por_id_recibo_direccion(
                $id_recibo, $id_direccion);

        $this->quita_direccion_usuario($id_direccion);

        return $response;
    }

    private function quita_direccion_usuario($id_direccion)
    {

        $q = [
            "id_direccion" => $id_direccion,
            "id_usuario" => $this->id_usuario,
        ];

        return $this->app->api("usuario_direccion/quitar", $q, "json", "PUT");

    }

    private function quitar_punto_entrega($param)
    {
        $id_recibo = $param["id_recibo"];
        $id_direccion = $param["id_direccion"];
        $response =
            $this->delete_direccion_punto_encuentro($id_recibo);

        $this->quita_punto_entrega($id_direccion);

        return $response;
    }

    private function quita_punto_entrega($id_direccion)
    {

        $q = [
            "id_punto_encuentro" => $id_direccion,
            "id_usuario" => $this->id_usuario,
        ];

        return $this->app->api("usuario_punto_encuentro/quitar", $q, "json", "PUT");

    }


}