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
        $costo["text_envio"]["cliente"] = d(text_icon('fas fa-bus', $texto), 'texto_envio');
        return $costo;

    }

    function get_pago($q)
    {

        return $this->app->api("recibo/resumen_desglose_pago", $q, "html");
    }

    function valida_estado_pago_GET()
    {

        $param = $this->get();
        $this->response(span($param["id_proyecto_persona_forma_pago"], "blue_enid white"));
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
        $precio = $this->get_precio_id_servicio($id_servicio);
        $data_orden = [];
        if (es_data($precio)) {


            $data_reporte_compra["articulo_valido"] = 1;
            $prm = [
                "id_servicio" => $id_servicio,
                "articulos_solicitados" => $param["num_ciclos"]
            ];

            $data_orden["existencia"] = $info_existencia = $this->consulta_disponibilidad_servicio($prm);

            if ($info_existencia["en_existencia"] > 0) {

                $new_precio = $precio[0];
                $data_orden["id_ciclo_facturacion"] = $new_precio["id_ciclo_facturacion"];
                $data_orden["precio"] = $new_precio["precio"];
                $data_orden["existencia"] = $info_existencia;
                $data_orden["servicio"] = $info_existencia["info_servicio"][0];


                if (key_exists_bi($data_orden, "servicio", "flag_servicio", 0) < 1) {
                    if (prm_def($param, "tipo_entrega") == 1) {

                        $prm_envio["flag_envio_gratis"] = 0;
                        $data_orden["costo_envio"] = $this->get_costo_envio_punto_encuentro($param);


                    } else {

                        $prm_envio["flag_envio_gratis"] = key_exists_bi($data_orden, "servicio", "flag_envio_gratis", 0);
                        $data_orden["costo_envio"] = $this->get_costo_envio($prm_envio);

                    }

                    $this->quita_carro_compras($param);

                }

                $data_orden["es_usuario_nuevo"] = 1;
                $es_nuevo = prm_def($param, "usuario_nuevo");
                $data_orden = $this->tipo_usuario($data_orden , $es_nuevo, $param);
                $data_orden["data_por_usuario"] = $param;
                $data_orden["talla"] = prm_def($param, "talla");


                $id_recibo = $this->genera_orden_compra($data_orden, $param);
                $data_orden["id_recibo"] = $id_recibo;

                $q["id_servicio"] = $id_servicio;
                $q["valor"] = 2;
                $this->gamificacion_deseo($q);
                $pos["id_recibo"] = $id_recibo;
                $pos["id_usuario_venta"] = key_exists_bi($data_orden, "servicio", "id_usuario_venta", 0);
                $pos["id_servicio"] = $id_servicio;

                if ($es_nuevo < 1 ) {

                    $pos["id_usuario"] = $data_orden["id_usuario"];
                    $pos["email"] = $this->app->get_session("email");

                } else {

                    $pos["id_usuario"] = $param["id_usuario"];
                    $pos["telefono"] = $param["telefono"];
                    $pos["nombre"] = $param["nombre"];
                    $pos["email"] = $param["email"];

                }

                $pos["es_usuario_nuevo"] = $es_nuevo;
                $this->acciones_posterior_orden_pago($pos);
                if ($param["tipo_entrega"] != 2) {

                    $this->posterior_pe($param ,  $id_recibo, $pos["id_usuario"]);

                }

            }

        }
        $this->response($data_orden);
    }

    private function posterior_pe($param ,  $id_recibo, $id_usuario){

        $param["id_recibo"] = $id_recibo;
        $data_orden["id_recibo"] = $id_recibo;
        $this->create_orden_punto_entrega($param);
        $param["id_usuario"] = $id_usuario;
        $this->agrega_punto_encuentro_usuario($param);
    }
    private function tipo_usuario($data, $es_nuevo, $param){


        $data["id_usuario"] =  ($es_nuevo == 0 ) ? $this->id_usuario : $param["id_usuario"];
        $data["es_usuario_nuevo"] =  ($es_nuevo == 0 ) ? 0 : 1;

        if($es_nuevo < 1){

            $obj_session =  $this->app->session_enid();
            $session =  $obj_session->all_userdata();

            if ( prm_def($session, "agenda_pedido") >  0 ){

                $data["id_usuario"] =  prm_def($session, "agenda_pedido");
                $obj_session->unset_userdata("agenda_pedido");
            }
        }
        return $data;

    }
    function get_precio_id_servicio($id_servicio)
    {

        return $this->app->api("recibo/precio_servicio/format/json/", ["id_servicio" => $id_servicio] );
    }

    function consulta_disponibilidad_servicio($q)
    {

        return $this->app->api("servicio/info_disponibilidad_servicio/format/json/", $q);
    }

    private function get_costo_envio_punto_encuentro($q)
    {

        $response = $this->app->api("punto_encuentro/costo_entrega/format/json/", $q);
        return (es_data($response)) ? $response[0]["costo_envio"] : 50;

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

    private function genera_orden_compra($q, $param)
    {

        $id_recibo = $this->app->api("recibo/orden_de_compra", $q, "json", "POST");

        if ($id_recibo > 0 && prm_def($param, "comentarios") !== 0 && strlen(trim($param["comentarios"])) > 5) {
            $param["id_recibo"] = $id_recibo;
            $this->agrega_notas_pedido($param);
        }
        return $id_recibo;
    }

    private function agrega_notas_pedido($q)
    {

        return $this->app->api("recibo_comentario/index", $q, "json", "POST");
    }

    private function gamificacion_deseo($q)
    {

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

    /*aquí creamos en base de datos*/
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

    function carga_ficha_direccion_envio($q)
    {

        $q += [
            "text_direccion" => "Dirección de Envio",
            "externo" => 1

        ];

        return $this->app->api("usuario_direccion/direccion_envio_pedido", $q, "html");

    }

    private function create_orden_punto_entrega($q)
    {

        return $this->app->api("proyecto_persona_forma_pago_punto_encuentro/index", $q, "json", "POST");
    }

    private function agrega_punto_encuentro_usuario($q)
    {

        return $this->app->api("usuario_punto_encuentro/index", $q, "json", "POST");
    }

    function solicitud_cambio_punto_entrega_POST()
    {

        $param = $this->post();
        $response = [];
        if (fx($param, "fecha_entrega,horario_entrega,recibo")) {

            /*modifico hora de entrega*/
            $param["id_recibo"] = $param["recibo"];
            /*Lo modifico en la orden*/
            $response = $this->create_orden_punto_entrega($param);
            /*Lo agrego en el diccionario para el usuario*/
            $param["id_usuario"] = $this->id_usuario;
            $response = $this->agrega_punto_encuentro_usuario($param);
        }
        $this->response($response);
    }

    function primer_orden_POST()
    {

        $param = $this->post();
        $prevent = 0;
        $es_pe =  prm_def($param , "punto_encuentro");
        foreach (["num_ciclos" , "ciclo_facturacion", "id_servicio"] as $row ){
            if(prm_def($param , $row) ===  0){
                $prevent ++;
            };
        }

        if ($prevent <  1 || $es_pe) {

            $usuario = $this->crea_usuario($param);
            if ($usuario["usuario_registrado"] > 0 && $usuario["id_usuario"] > 0) {

                $param +=  [
                    "es_usuario_nuevo" => 1,
                    "usuario_nuevo" => 1,
                    "usuario_referencia" => $usuario["id_usuario"],
                    "id_usuario" => $usuario["id_usuario"],
                    "usuario_existe" => 0
                ];


                if ($es_pe){

                    $response = $this->crea_orden_punto_entrega($param);

                } else {


                    /*Para ordenes por entrega DHL, FEDEX ETC*/
                    $response = $this->crea_orden($param);

                }

                $session = $this->create_session($param);
                $this->app->set_userdata($session);
                $this->response($response);

            }

            $this->response($usuario);

        } else {
            $this->response(-1);
        }
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


        if (valida_fecha_entrega($param["fecha_entrega"]) && valida_horario_entrega($param["horario_entrega"])) {


            $param["fecha_entrega"] = $param["fecha_entrega"] . " " . $param["horario_entrega"] . ":00";
            $param["tipo_entrega"] = 1;
            $param["id_ciclo_facturacion"] = 5;
            return $this->crea_orden($param);

        }
        return false;

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
        $fn = (prm_def($param, "usuario_nuevo") > 0) ? $this->notifica_registro_usuario($param) : "";

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

    function comision_GET()
    {

        $this->response(7);
    }

}