<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class codigo_postal extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("codigo_postal_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function direccion_usuario_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "cp")) {

            $param["id_codigo_postal"] = $this->codigo_postal_model->get_id_codigo_postal_por_patron($param);
            $id_direccion = $this->crea_direccion($param);
            if ($id_direccion > 0 && $this->id_usuario > 0) {

                $response = $this->registra_direccion_usuario($this->id_usuario, $id_direccion);

            }
        }
        $this->response($response);

    }

    function direccion_envio_pedido_POST()
    {

        $param = $this->post();
        $response = false;


        if (fx($param, "cp")) {
            $id_direccion = $this->registra_direccion_envio($param);
            if ($id_direccion == 0) {

                $this->response(false);
            }

            $response["id_direccion"] = $param["id_direccion"] = $id_direccion;


            $es_direccion_principal = (prm_def($param, "direccion_principal", false) != false);
            if ($id_direccion > 0 && $es_direccion_principal) {

                $direccion_principal = $param["direccion_principal"];
                $id_usuario = $this->get_id_usuario($param);
                $response["registro_direccion_usuario"] =
                    $this->set_direcciones_usuario(
                        $param,
                        $id_usuario,
                        $id_direccion,
                        $direccion_principal
                    );
            }

            $response["externo"] = prm_def($param, "externo");
        }

        $this->response($response);
    }

    function registra_direccion_envio($param)
    {


        $param["id_codigo_postal"] = $this->codigo_postal_model->get_id_codigo_postal_por_patron($param);
        $response = 0;
        if ($param["id_codigo_postal"] > 0) {

            $param["id_direccion"] = $this->crea_direccion($param);
            $this->elimina_direccion_previa_envio($param);
            $this->agrega_direccion_a_compra($param);
            $response = $param["id_direccion"];
        }
        return $response;
    }

    function id_por_patron_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "cp")) {
            $response = $this->codigo_postal_model->get_id_codigo_postal_por_patron($param);
        }
        $this->response($response);
    }

    function colonia_delegacion_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "cp")) {
            $response = $this->codigo_postal_model->get_colonia_delegacion($param);
        }
        $this->response($response);
    }

    function cp_GET()
    {

        $param = $this->get();
        $codigos_postales = $this->get_colonia_delegacion($param);
        $data_complete["resultados"] = $num_resultados = (is_array($codigos_postales)) ? count($codigos_postales) : 0;


        if ($num_resultados > 0) {


            if (count($codigos_postales) > 1) {


                $data_complete["colonias"] = create_select(
                    $codigos_postales,
                    "asentamiento",
                    "asentamiento",
                    "asentamiento",
                    "asentamiento",
                    "asentamiento");

            } else {


                $data_complete["colonias"] = create_select(
                    $codigos_postales,
                    "asentamiento",
                    "asentamiento",
                    "asentamiento",
                    "asentamiento",
                    "asentamiento");
            }


            $municipios = unique_multidim_array($codigos_postales, "municipio");
            if (count($municipios) > 1) {
                $select_delegacion = create_select(
                    $municipios,
                    "municipio",
                    "municipio",
                    "municipio",
                    "municipio",
                    "municipio");

            } else {

                $select_delegacion = create_select(
                    $municipios,
                    "municipio",
                    "municipio",
                    "municipio",
                    "municipio",
                    "municipio");

            }

            $data_complete["delegaciones"] = $select_delegacion;


            $estados = unique_multidim_array($codigos_postales, "estado");
            if (count($estados) > 1) {
                $select_estado = create_select(
                    $estados,
                    "estado",
                    "estado",
                    "estado",
                    "estado",
                    "id_estado_republica");
            } else {

                $select_estado = create_select(
                    $estados,
                    "estado",
                    "estado",
                    "estado",
                    "estado",
                    "id_estado_republica");
            }
            $data_complete["estados"] = $select_estado;

            $pais = unique_multidim_array($codigos_postales, "pais");

            if (count($pais) > 1) {

                $select_pais = create_select(
                    $pais,
                    "pais",
                    "pais",
                    "pais",
                    "pais",
                    "id_pais");
            } else {
                $select_pais = create_select(
                    $pais,
                    "pais",
                    "pais",
                    "pais",
                    "pais",
                    "id_pais");
            }
            $data_complete["pais"] = $select_pais;


        }
        $this->response($data_complete);
    }

    private function get_colonia_delegacion($q)
    {

        return $this->app->api("codigo_postal/colonia_delegacion/format/json/", $q);
    }

    private function get_id_usuario($param)
    {

        return ($this->app->is_logged_in() == 1) ? $this->id_usuario : $param["id_usuario"];

    }

    private function set_direcciones_usuario($param, $id_usuario, $id_direccion, $direccion_principal)
    {


        $es_asignacion_horario = (prm_def($param, 'asignacion_horario') > 0);

        if ($es_asignacion_horario) {

            $id_recibo = $param['id_recibo'];
            $qrecibo = [
                'recibo' => $id_recibo
            ];
            $recibo = $this->app->api("recibo/index/format/json/", $qrecibo);
            $id_usuario = pr($recibo, 'id_usuario');

            $this->fecha_entrega($param, $id_recibo);
        }

        $q = [
            "id_usuario" => $id_usuario,
            "id_direccion" => $id_direccion,
            "principal" => $direccion_principal,

        ];

        return $this->app->api("usuario_direccion/index", $q, "json", "PUT");
    }

    function fecha_entrega($param, $id_recibo)
    {

        if (fx($param, "fecha_entrega,horario_entrega")) {

            $fecha_entrega = $param['fecha_entrega'];
            $horario_entrega = $param['horario_entrega'];

            $q = [
                "fecha_entrega" => $fecha_entrega,
                "horario_entrega" => $horario_entrega,
                "recibo" => $id_recibo,
                "contra_entrega_domicilio" => 1,
                "tipo_entrega" => 2
            ];
            return $this->app->api("recibo/fecha_entrega/format/json/", $q, "json", "PUT");
        }


    }

    private function registra_direccion_usuario($id_usuario, $id_direccion)
    {

        $q = [
            "id_usuario" => $id_usuario,
            "id_direccion" => $id_direccion
        ];

        return $this->app->api("usuario_direccion/index", $q, "json", "POST");
    }

    private function elimina_direccion_previa_envio($q)
    {


        return $this->app->api("proyecto_persona_forma_pago_direccion/index", $q, "json", "DELETE");
    }

    private function agrega_direccion_a_compra($q)
    {

        return $this->app->api("proyecto_persona_forma_pago_direccion/index", $q, "json", "POST");
    }

    private function crea_direccion($q)
    {

        return $this->app->api("direccion/index", $q, "json", "POST");
    }
}