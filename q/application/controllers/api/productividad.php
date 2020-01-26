<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class productividad extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("q");
        $this->load->model("productividad_usuario_model");
        $this->load->library(lib_def());
    }

    function notificaciones_GET()
    {

        $param = $this->get();
        $id_usuario = $this->app->get_session('idusuario');
        $id_perfil = $param["id_perfil"] = $this->app->getperfiles();
        $param["id_usuario"] = $id_usuario;


        $response = [
            "objetivos_perfil" => $this->get_objetivos_perfil($param),
            "productos_anunciados" => $this->valida_producto_anunciado($param),
            "flag_direccion" => $this->verifica_direccion_registrada_usuario($param),
            "info_notificaciones" => $this->get_notificaciones_usuario_perfil($param),
            "id_perfil" => $param["id_perfil"],
        ];


        $prm["modalidad"] = 1;
        $prm["id_usuario"] = $id_usuario;
        $response["info_notificaciones"]["numero_telefonico"] = $this->verifica_registro_telefono($prm);
        $response += [
            "id_usuario" => $id_usuario,
            "preguntas" => $this->get_preguntas($id_usuario),
            "respuestas" => $this->get_respuestas($id_usuario),
            "compras_sin_cierre" => $this->pendientes_ventas_usuario($id_usuario),
            "recibos_sin_costos_operacion" => $this->get_scostos($id_usuario),
            "clientes_sin_tags_arquetipos" => $this->get_stag(),
            "tareas" => $this->get_tareas($id_usuario),
        ];


        switch ($id_perfil) {

            case 3:

                $response += [
                    "recordatorios" => $this->get_recordatorios($id_usuario),
                    "ventas_enid_service" => $this->get_ventas_enid_service(),
                    "ventas_semana" => $this->ventas_semana()
                ];

                $response = get_tareas_pendienetes_usuario($response);

                break;

            case 20:
                $response = pendientes_cliente($response);
                break;
            default:
                break;
        }

        $this->response($response);

    }

    private function get_respuestas($id_usuario)
    {
        $q = [
            "id_usuario" => $id_usuario,
            "se_lee" => 0,
            "se_ve_cliente" => 0,
        ];

        return $this->app->api("pregunta/cliente/format/json/", $q);
    }

    private function get_preguntas($id_vendedor)
    {

        $q = [
            "id_vendedor" => $id_vendedor,
            "se_responde" => 0,
        ];

        return $this->app->api("pregunta/vendedor/format/json/", $q);

    }

    private function get_objetivos_perfil($q)
    {

        return $this->app->api("objetivos/perfil/format/json/", $q);
    }

    private function valida_producto_anunciado($q)
    {

        return $this->app->api("servicio/num_anuncios/format/json/", $q);
    }

    private function verifica_direccion_registrada_usuario($q)
    {

        return $this->app->api("usuario_direccion/num/format/json/", $q);
    }

    function get_notificaciones_usuario_perfil($param)
    {

        $id_perfil = $param["id_perfil"];
        $response["perfil"] = $id_perfil;
        $param["id_perfil"] = $id_perfil;

        $response += [
            "id_usuario" => $param["id_usuario"],
            "adeudos_cliente" => $this->get_adeudo_cliente($param),
            "valoraciones_sin_leer" => $this->get_num_lectura_valoraciones($param),
            "id_perfil" => $id_perfil
        ];

        switch ($id_perfil) {
            case 3:

                $response += [

                    "email_enviados_enid_service" => $this->email_enviados_enid_service(),
                    "accesos_enid_service" => $this->accesos_enid_service(),
                    "tareas_enid_service" => $this->tareas_enid_service()[0]["num_pendientes_desarrollo"],
                    "num_pendientes_direccion" => $this->tareas_enid_service()[0]["num_pendientes_direccion"]
                ];

                break;

            case 4:

                $response += [
                    "email_enviados_enid_service" => $this->email_enviados_enid_service(),
                    "accesos_enid_service" => $this->accesos_enid_service(),
                    "tareas_enid_service" => pr($this->tareas_enid_service(), "num_pendientes_desarrollo", 0),
                ];

                break;

            default:

                break;
        }
        return $response;
    }

    private function get_adeudo_cliente($q)
    {
        return $this->app->api("recibo/deuda_cliente/format/json/", $q);
    }

    private function get_num_lectura_valoraciones($q)
    {

        return $this->app->api("servicio/num_lectura_valoraciones/format/json/", $q);
    }

    private function email_enviados_enid_service()
    {

        $q["info"] = 1;
        return $this->app->api("prospecto/dia/format/json/", $q);

    }

    private function accesos_enid_service()
    {

        $q["info"] = 1;
        return $this->app->api("pagina_web/dia/format/json/", $q);
    }

    private function tareas_enid_service()
    {

        $q["info"] = 1;
        return $this->app->api("tarea/tareas_enid_service/format/json/", $q);
    }

    private function verifica_registro_telefono($q)
    {

        return $this->app->api("usuario/verifica_registro_telefono/format/json/", $q);
    }

    function get_recordatorios($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->app->api("recordatorio/usuario/format/json/", $q);

    }

    private function pendientes_ventas_usuario($id_usuario)
    {
        $response = $this->app->api("recibo/pendientes_sin_cierre/format/json/", ["id_usuario" => $id_usuario]);
        $response = $this->app->imgs_productos(0, 1, 1, 1, $response);
        return $response;
    }

    private function get_ventas_enid_service()
    {
        return $this->app->api("recibo/dia/format/json/", ["fecha" => 1]);
    }

    private function get_scostos($id_usuario)
    {
        return $this->app->api("costo_operacion/scostos/format/json/", ["id_usuario" => $id_usuario]);
    }

    private function get_stag()
    {
        return $this->app->api("recibo/stags_arquetipos/format/json/");
    }

    function get_tareas($id_usuario)
    {
        return $this->app->api("tickets/pendientes/format/json/", ["id_usuario" => $id_usuario]);
    }

    function ventas_semana()
    {
        $fecha = new DateTime(now_enid());
        $dias = $fecha->format("w");
        $q = [
            "cliente" => "",
            "v" => 0,
            "recibo" => "",
            "tipo_entrega" => 0,
            "status_venta" => 14,
            "tipo_orden" => 1,
            "fecha_inicio" => add_date(now_enid(), -$dias),
            "fecha_termino" => now_enid()
        ];

        $response = $this->app->api("recibo/pedidos/format/json/", $q);
        return count($response);

    }
}