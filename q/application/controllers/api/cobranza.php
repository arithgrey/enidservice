<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Cobranza extends REST_Controller
{
    public $option;
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("cobranza");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function calcula_costo_envio_GET()
    {

        $this->response($this->get_costo_envio($this->get()));
    }

    function get_costo_envio($param)
    {

        $costo = get_costo_envio($param);
        $texto = key_exists_bi($costo, "text_envio", "cliente");
        $costo["text_envio"]["cliente"] = d($texto, 'texto_envio');

        return $costo;

    }

    function get_pago($q)
    {

        return $this->app->api("recibo/resumen_desglose_pago", $q, "html");
    }

    function valida_estado_pago_GET()
    {

        $param = $this->get();
        $this->response(span($param["id_proyecto_persona_forma_pago"],
            "blue_enid white"));
    }

    function form_comentario_notificacion_pago_GET()
    {
        $this->load->view("pagos_notificados/comentarios_pago");
    }

    function get_notificacion_pago($q)
    {

        return $this->app->api("notificacion_pago/pago_resumen/format/json/", $q);
    }

    function verifica_pago_notificado($q)
    {

        return $this->app->api("notificacion_pago/es_notificado/format/json/", $q);

    }

    function carga_servicio_por_recibo($q)
    {

        return $this->app->api("tickets/servicio_recibo/format/json/", $q);
    }

    function solicitud_proceso_pago_POST()
    {

        $param = $this->post();
        $id_servicio = $param["id_servicio"];
        $num_ciclos = $param['num_ciclos'];
        $precio = $this->get_precio_id_servicio($id_servicio);
        $es_nuevo = prm_def($param, "usuario_nuevo");
        $data_orden['orden_creada'] = 0;
        if (es_data($precio)) {

            $info_existencia = $this->disponibilidad_servicio($id_servicio, $num_ciclos);
            if ($info_existencia["en_existencia"] > 0) {

                $servicio = $info_existencia["info_servicio"][0];
                $recibo = $this->orden(
                    $servicio, $param, $precio, $es_nuevo, $info_existencia);

                $id_recibo = $recibo['id_recibo'];

                if ($id_recibo > 0) {

                    $data_orden = $recibo['data_orden'];
                    $data_orden['orden_creada'] = 1;
                    $data_orden["id_recibo"] = $id_recibo;
                    $this->posterior_compra(
                        $data_orden, $id_recibo, $id_servicio, $param, $es_nuevo);
                }
            }
        }
        $this->response($data_orden);
    }

    function get_precio_id_servicio($id_servicio)
    {

        return $this->app->api("recibo/precio_servicio/format/json/",
            ["id_servicio" => $id_servicio]);
    }

    function disponibilidad_servicio($id_servicio, $num_ciclos)
    {
        $q = [
            "id_servicio" => $id_servicio,
            "articulos_solicitados" => $num_ciclos,
        ];

        return $this->app->api("servicio/info_disponibilidad_servicio/format/json/", $q);
    }

    private function orden($servicio, $param, $precio, $es_nuevo, $info_existencia)
    {
        $data['es_usuario_nuevo'] = 1;
        $data["existencia"] = $info_existencia;
        $data["id_ciclo_facturacion"] = pr($precio, "id_ciclo_facturacion");
        $data["precio"] = pr($precio, "precio");
        $data["servicio"] = $servicio;
        $data["costo_envio"] = $this->costo_envio_tipo_orden($data, $param);
        $data = $this->tipo_usuario($data, $es_nuevo, $param);
        $data["data_por_usuario"] = $param;
        $data["talla"] = prm_def($param, "talla");

        $id_recibo = $this->genera_orden_compra($data, $param);

        return
            [
                'data_orden' => $data,
                'id_recibo' => $id_recibo,
            ];
    }

    function costo_envio_tipo_orden($data_orden, $param)
    {

        $response = 0;
        if (key_exists_bi($data_orden, "servicio", "flag_servicio", 0) < 1) {
            if (prm_def($param, "tipo_entrega") == 1) {

                $response = $this->get_costo_envio_punto_encuentro($param);


            } else {

                $param["flag_envio_gratis"] = key_exists_bi(
                    $data_orden, "servicio", "flag_envio_gratis", 0);
                $response = $this->get_costo_envio($param);

            }

            $this->quita_carro_compras($param);

        }

        return $response;

    }

    private function get_costo_envio_punto_encuentro($q)
    {

        $response = $this->app->api("punto_encuentro/costo_entrega/format/json/", $q);

        return (es_data($response)) ? $response[0]["costo_envio"] : 100;

    }

    private function quita_carro_compras($param)
    {

        if (array_key_exists("carro_compras", $param)
            &&
            $param["carro_compras"] > 0
            &&
            array_key_exists("id_carro_compras", $param)
            &&
            $param["id_carro_compras"] > 0
        ) {

            $q = [
                "status" => 1,
                "id" => $param["id_carro_compras"],

            ];

            return $this->app->api("usuario_deseo/status", $q, "json", "PUT");


        }
    }

    private function tipo_usuario($data, $es_nuevo, $param)
    {


        $data["id_usuario"] = ($es_nuevo < 1) ? $this->id_usuario : $param["id_usuario"];
        $data["es_usuario_nuevo"] = ($es_nuevo == 0) ? 0 : 1;

        if ($es_nuevo < 1) {

            $obj_session = $this->app->session_enid();
            $session = $obj_session->all_userdata();

            if (prm_def($session, "agenda_pedido") > 0) {

                $data["id_usuario"] = prm_def($session, "agenda_pedido");
                $obj_session->unset_userdata("agenda_pedido");
            }
        }

        return $data;

    }

    private function genera_orden_compra($q, $param)
    {

        $id_recibo = $this->app->api("recibo/orden_de_compra", $q, "json", "POST");

        if ($id_recibo > 0 && prm_def($param,
                "comentarios") !== 0 && strlen(trim($param["comentarios"])) > 5) {
            $param["id_recibo"] = $id_recibo;
            $this->agrega_notas_pedido($param);
        }

        return $id_recibo;
    }

    private function agrega_notas_pedido($q)
    {

        return $this->app->api("recibo_comentario/index", $q, "json", "POST");
    }

    function posterior_compra($data_orden, $id_recibo, $id_servicio, $param, $es_nuevo)
    {

        $gamificacion = $this->gamificacion_deseo($id_servicio, 2);
        $id_usuario_venta = key_exists_bi($data_orden, "servicio", "id_usuario_venta", 0);

        $pos =
            [
                "id_recibo" => $id_recibo,
                "id_usuario_venta" => $id_usuario_venta,
                "id_servicio" => $id_servicio,
                "es_usuario_nuevo" => $es_nuevo,
            ];


        if ($es_nuevo < 1) {

            $pos +=
                [
                    "id_usuario" => $data_orden["id_usuario"],
                    "email" => $this->app->get_session("email"),
                ];


        } else {

            $pos +=
                [

                    "id_usuario" => $param["id_usuario"],
                    "telefono" => $param["telefono"],
                    "nombre" => $param["nombre"],
                    "email" => $param["email"],
                ];


        }


        $this->acciones_posterior_orden_pago($pos);
        if ($param["tipo_entrega"] != 2) {

            $this->posterior_pe($param, $id_recibo, $pos["id_usuario"]);

        }
    }

    private function gamificacion_deseo($id_servicio, $valor)
    {
        $q = [

            "id_servicio" => $id_servicio,
            "valor" => $valor,
        ];

        return $this->app->api("servicio/gamificacion_deseo", $q, "json", "PUT");
    }

    function acciones_posterior_orden_pago($param)
    {

        $this->notifica_deuda_cliente($param);
        $this->crea_comentario_pedido($param);
    }

    function notifica_deuda_cliente($q)
    {


        return $this->app->api("areacliente/pago_pendiente_web/format/json/", $q);
    }

    private function crea_comentario_pedido($param)
    {

        $id_recibo = $param["id_recibo"];
        $email = $param["email"];

        $text = "TENEMOS UNA ORDEN DE COMPRA EN PROCESO DEL CLIENTE " . $email . " RECIBO NÚMERO " . $id_recibo;
        if (prm_def($param, "es_usuario_nuevo") > 0) {

            $text = "TENEMOS UNA ORDEN DE COMPRA EN PROCESO DEL CLIENTE " . $param["nombre"] . " - " . $param["email"] . " - " . $param["telefono"] . " RECIBO NÚMERO " . $id_recibo;
        }
        $asunto = "NUEVA ORDEN DE COMPRA EN PROCESO, RECIBO #" . $id_recibo;
        $cuerpo = img_enid([], 1, 1) . add_element($text, 'h3');
        $q = get_request_email("enidservice@gmail.com", $asunto, $cuerpo);
        $this->app->send_email($q);

    }

    private function posterior_pe($param, $id_recibo, $id_usuario)
    {

        $param["id_recibo"] = $id_recibo;
        $param["id_usuario"] = $id_usuario;
        $this->create_orden_punto_entrega($param);

        return $this->agrega_punto_encuentro_usuario($param);
    }


    private function create_orden_punto_entrega($q)
    {

        return $this->app->api("proyecto_persona_forma_pago_punto_encuentro/index", $q,
            "json", "POST");
    }

    private function agrega_punto_encuentro_usuario($q)
    {

        return $this->app->api("usuario_punto_encuentro/index", $q, "json", "POST");
    }

//    function carga_ficha_direccion_envio($q)
//    {
//
//        $q += [
//            "text_direccion" => "Dirección de Envio",
//            "externo" => 1,
//
//        ];
//
//        return $this->app->api("usuario_direccion/direccion_envio_pedido", $q, "html");
//
//    }

    function solicitud_cambio_punto_entrega_POST()
    {

        $param = $this->post();
        $response = [];
        if (fx($param, "punto_encuentro,fecha_entrega,horario_entrega,recibo")) {

            /*modifico hora de entrega*/
            $id_recibo = $param["recibo"];
            /*Lo modifico en la orden*/
            $param['id_recibo'] = $id_recibo;
            $response = $this->create_orden_punto_entrega($param);
            /*Lo agrego en el diccionario para el usuario*/
            $param["id_usuario"] = $this->id_usuario;
            $nuevo = $this->agrega_punto_encuentro_usuario($param);
            $response = $this->quita_domicilio_entrega_por_recibo($id_recibo);

            if ($response) {
                $this->fecha_entrega($param['fecha_entrega'], $param['horario_entrega'], $id_recibo);
            }
            $data =
                [
                    'restricciones' => $this->config->item('restricciones'),
                    'id_perfil' => $this->app->getperfiles()
                ];

            $path_seguimiento = path_enid('pedidos_recibo', $id_recibo);
            $response = [
                'punto_nuevo' => $nuevo,
                'id_recibo' => $id_recibo,
                'es_administrador' => es_administrador_o_vendedor($data),
                'path_seguimiento' => $path_seguimiento
            ];

        }
        $this->response($response);
    }

    function quita_domicilio_entrega_por_recibo($id_recibo)
    {


        $q = ["id_recibo" => $id_recibo];

        return $this->app->api(
            "proyecto_persona_forma_pago_direccion/index", $q, "json",
            "DELETE");

    }

    function usuario_referencia($param)
    {
        $usuario_referencia = 0;
        if (array_key_exists('es_cliente', $param) && $param['es_cliente'] < 1) {

            $usuario_referencia = $this->id_usuario;
        }
        return $usuario_referencia;
    }

    function primer_orden_POST()
    {

        $param = $this->post();
        $prevent = 0;
        $es_pe = prm_def($param, "punto_encuentro");
        foreach (["num_ciclos", "ciclo_facturacion", "id_servicio"] as $row) {
            if (prm_def($param, $row) === 0) {
                $prevent++;
            };
        }
        $usuario_referencia = $this->usuario_referencia($param);
        if ($usuario_referencia > 0) {

            $param['usuario_referencia'] = $usuario_referencia;
        }
        if ($prevent < 1 || $es_pe) {

            $usuario = $this->crea_usuario($param);
            if ($usuario["usuario_registrado"] > 0 && $usuario["id_usuario"] > 0) {
                $usuario_referencia = ($usuario_referencia > 0) ? $usuario_referencia : $usuario["id_usuario"];
                $param += [
                    "es_usuario_nuevo" => 1,
                    "usuario_nuevo" => 1,
                    "usuario_referencia" => $usuario_referencia,
                    "id_usuario" => $usuario["id_usuario"],
                    "usuario_existe" => 0,
                ];


                if ($es_pe > 0) {

                    $response = $this->crea_orden_punto_entrega($param);

                } else {

                    /*Para ordenes por entrega DHL, FEDEX ETC*/
                    $response = $this->crea_orden($param);

                }

                if (is_array($response) && $response != false) {

                    $response = $this->has_login($response, $param);
                }

                $this->response($response);
            }
            $this->response($usuario);
        } else {
            $this->response(-1);
        }
    }

    private function has_login($response, $param)
    {

        $response["session_creada"] = 0;
        if ($response['orden_creada'] > 0 && $param['es_cliente'] > 0) {
            $session = $this->create_session($param);
            if (es_data($session)) {
                $response["session_creada"] = 1;
                $this->app->set_userdata($session);
            }
        } else {
            $response["session_creada"] = 1;
        }
        return $response;
    }

    function crea_usuario($q)
    {

        return $this->app->api("usuario/prospecto", $q, "json", "POST");
    }

    private function crea_orden_punto_entrega($param)
    {


        if (!ctype_digit($param["id_servicio"])
            ||
            !ctype_digit($param["num_ciclos"])
            ||
            !ctype_digit($param["punto_encuentro"])) {

            return false;

        }


        $response = false;
        if (valida_fecha_entrega($param["fecha_entrega"]) && valida_horario_entrega($param["horario_entrega"])) {

            $param["fecha_entrega"] = $param["fecha_entrega"] . " " . $param["horario_entrega"] . ":00";
            $param["tipo_entrega"] = 1;
            $param["id_ciclo_facturacion"] = 5;

            $response = $this->crea_orden($param);

        }

        return $response;
    }

    function crea_orden($q)
    {

        return $this->app->api("cobranza/solicitud_proceso_pago", $q, "json", "POST");
    }

    function create_session($q)
    {


        $q += [
            "t" => $this->config->item('barer'),
            "secret" => $q["password"],
        ];

        return $this->app->api("sess/start", $q, "json", "POST", 0, 1, "login");
    }


    function valida_envio_notificacion_nuevo_usuario($param)
    {
        $fn = (prm_def($param,
                "usuario_nuevo") > 0) ? $this->notifica_registro_usuario($param) : "";

    }

    function notifica_registro_usuario($q)
    {

        return $this->app->api("emp/solicitud_usuario", $q);
    }

    function agrega_data_cliente($data)
    {

        $response = [];
        $x = 0;
        foreach ($data as $row) {

            $response[$x] = $row;
            $response[$x]["cliente"] = $this->app->usuario($row["id_usuario"]);
            $x++;
        }

        return $response;
    }

    function agrega_estatus_enid_service($saldos)
    {

        $response = [];
        $a = 0;
        foreach ($saldos as $row) {
            $response[$a] = $row;
            $prm["id_estatus"] = $row["status"];
            $response[$a]["estatus_enid_service"] = $this->get_estatus_enid_service($prm);
            $a++;

        }

        return $response;
    }

    function get_estatus_enid_service($q)
    {

        return $this->app->api("servicio/nombre_estado_enid/format/json/", $q);
    }

    function fecha_entrega($fecha_entrega, $horario_entrega, $recibo)
    {

        $q = [
            "fecha_entrega" => $fecha_entrega,
            "horario_entrega" => $horario_entrega,
            "recibo" => $recibo,
            "tipo_entrega" => 1
        ];
        return $this->app->api("recibo/fecha_entrega/format/json/", $q, "json", "PUT");

    }

    function comision_GET()
    {

        $this->response(7);
    }

}