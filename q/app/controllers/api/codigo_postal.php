<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class codigo_postal extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("codigo_postal_model");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
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

            $id_orden_compra = $param["id_orden_compra"];
            $response["id_orden_compra"] = $id_orden_compra;
            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
            $id_direccion = $this->registra_direccion_envio($param, $productos_orden_compra);
            if ($id_direccion == 0) {

                $this->response(false);
            }

            $response["id_direccion"] = $id_direccion;
            $param["id_direccion"] = $id_direccion;

            $direccion_principal = prm_def(
                $param,
                "direccion_principal",
                false
            );

            $es_direccion_principal = ($direccion_principal != false);
            $response = $this->direccion_principal($response, $id_direccion, $es_direccion_principal, $param);
            $response["asigna_reparto"] = $this->app->asigna_reparto($id_orden_compra);
            $response["externo"] = prm_def($param, "externo");
            $response["asignacion_horario"] = 1;
        }

        $this->response($response);
    }

    private function direccion_principal($response, $id_direccion, $es_direccion_principal, $param)
    {

        if ($id_direccion > 0 && $es_direccion_principal) {

            $direccion_principal = $param["direccion_principal"];
            $id_usuario = $this->get_id_usuario($param);
            $registro_direccion_usuario = $this->set_direcciones_usuario(
                $id_usuario,
                $id_direccion,
                $direccion_principal
            );

            $response["registro_direccion_usuario"] = $registro_direccion_usuario;
        }
        return $response;
    }

    function registra_direccion_envio($param, $productos_orden_compra)
    {

        $param["id_codigo_postal"] = $this->codigo_postal_model->get_id_codigo_postal_por_patron($param);
        $response = 0;
        if ($param["id_codigo_postal"] > 0) {

            foreach ($productos_orden_compra as $row) {

                $id_recibo = $row["id"];
                $param["id_direccion"] = $this->crea_direccion($param);
                $id_direccion = $param["id_direccion"];

                $eliminacion = $this->elimina_direccion_previa_envio($id_recibo);
                $registro = $this->agrega_direccion_a_compra($id_recibo, $id_direccion);
                $identificacion = $this->identifica_direccion_entrega($id_recibo, 0, 2);
                $response = $id_direccion;

            }

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

    function costo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "q")) {
            $response = $this->codigo_postal_model->get_costo($param["q"]);
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

        return $this->app->api("codigo_postal/colonia_delegacion", $q);
    }

    private function get_id_usuario($param)
    {

        return ($this->app->is_logged_in() == 1) ? $this->id_usuario : $param["id_usuario"];

    }

    private function set_direcciones_usuario($id_usuario, $id_direccion, $direccion_principal)
    {

        $q =
            [
                "id_usuario" => $id_usuario,
                "id_direccion" => $id_direccion,
                "principal" => $direccion_principal,
            ];

        return $this->app->api("usuario_direccion/index", $q, "json", "PUT");
    }

    function fecha_entrega($param, $id_orden_compra)
    {

        if (fx($param, "fecha_entrega,horario_entrega")) {

            $fecha_entrega = $param['fecha_entrega'];
            $horario_entrega = $param['horario_entrega'];

            $q = [
                "fecha_entrega" => $fecha_entrega,
                "horario_entrega" => $horario_entrega,
                "orden_compra" => $id_orden_compra,
                "contra_entrega_domicilio" => 1,
                "tipo_entrega" => 2
            ];
            return $this->app->api("recibo/fecha_entrega/", $q, "json", "PUT");
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

    private function identifica_direccion_entrega($id_recibo, $ubicacion, $tipo_entrega)
    {
        $q = [
            "id_recibo" => $id_recibo,
            "ubicacion" => $ubicacion,
            "tipo_entrega" => $tipo_entrega

        ];

        return $this->app->api("recibo/tipo_entrega_orden", $q, "json", "PUT");
    }

    private function elimina_direccion_previa_envio($id_recibo)
    {

        $q = ["id_recibo" => $id_recibo];
        return $this->app->api("proyecto_persona_forma_pago_direccion/index", $q, "json", "DELETE");
    }

    private function agrega_direccion_a_compra($id_recibo, $id_direccion)
    {

        $q = [
            "id_recibo" => $id_recibo,
            "id_direccion" => $id_direccion
        ];
        return $this->app->api("proyecto_persona_forma_pago_direccion/index", $q, "json", "POST");
    }

    private function crea_direccion($q)
    {

        return $this->app->api("direccion/index", $q, "json", "POST");
    }
}