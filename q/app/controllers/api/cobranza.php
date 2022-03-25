<?php defined('BASEPATH') or exit('No direct script access allowed');
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
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function calcula_costo_envio_GET()
    {

        $this->response($this->get_costo_envio($this->get()));
    }

    function get_costo_envio($servicio)
    {

        $costo = get_costo_envio($servicio);
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

        return $this->app->api("notificacion_pago/pago_resumen", $q);
    }

    function verifica_pago_notificado($q)
    {

        return $this->app->api("notificacion_pago/es_notificado", $q);

    }

    function carga_servicio_por_recibo($q)
    {

        return $this->app->api("tickets/servicio_recibo", $q);
    }

    private function productos_deseados_tipo_cliente($es_cliente, $param)
    {

        $producto_carro_compra = $param["producto_carro_compra"];
        if ($es_cliente) {

            if (prm_def($param, "es_usuario_nuevo") < 1) {

                $productos_deseados_carro_compra = 
                $this->productos_envio_pago_usuario($producto_carro_compra, 1);

            } else {

                $productos_deseados_carro_compra = $this->productos_envio_pago_nuevo_usuario($producto_carro_compra);
            }


        } else {

            $productos_deseados_carro_compra = $this->productos_envio_pago_usuario($producto_carro_compra);

        }
        return $productos_deseados_carro_compra;

    }

    private function posteriores_compra($id_orden_compra, $orden_compra)
    {

        $orden_compra['orden_creada'] = 0;
        if ($id_orden_compra > 0) {

            $orden_compra['orden_creada'] = 1;
            $orden_compra["id_orden_compra"] = $id_orden_compra;

        }

        return $orden_compra;
    }

    private function notifica_compra_nuevo_cliente(
        $productos_deseados_carro_compra, $es_cliente, $envia_cliente)
    {

        if ($es_cliente) {

            /**/
            if ($envia_cliente > 0) {
            
                $ids = array_column($productos_deseados_carro_compra, "id");
                $this->notifica_productos_envio_pago_vendedor($ids);

            }else{
                
                $ids = array_column(
                    $productos_deseados_carro_compra, "id_usuario_deseo_compra");
                $this->notifica_productos_envio_pago_nuevo_usuario($ids);
            }
            

        }else{

            /*Se notifica que el vendedor envió orden de compra en el carro de compras*/
            $ids = array_column(
                $productos_deseados_carro_compra, "id");
            $this->notifica_productos_envio_pago_vendedor($ids);
        }

    }

    function solicitud_proceso_pago_POST()
    {
        $param = $this->post();
        $a = 0;
        $es_cliente = $param["es_cliente"];
        $envia_cliente = prm_def($param, "envia_cliente");
        
        $productos_deseados_carro_compra = 
        $this->productos_deseados_tipo_cliente($es_cliente, $param);

        $id_orden_compra = 0;
        $response = [];

        foreach ($productos_deseados_carro_compra as $data_servicio) {

            if ($a < 1) {

                $orden_compra = $this->orden($param, $data_servicio);
                $id_orden_compra = $orden_compra["id_orden_compra"];

            } else {

                $orden_compra = $this->orden($param, $data_servicio, $id_orden_compra);
                $id_orden_compra = $orden_compra["id_orden_compra"];
            }

            $response[] = $this->posteriores_compra($id_orden_compra, $orden_compra);

            $a++;
        }

        /*Gamifica*/
        if ($id_orden_compra > 0) {

            /*notifica recompensa(compra de más de un artículo con descuento)*/
            $this->orden_compra_recompensa($id_orden_compra, $param);
            $this->gamifica_ventas_vendedor($param["usuario_referencia"]);            
            /*Notificamos al carro de compra que pasó a envio a pago*/      
            
            
        }
        
        $this->notifica_compra_nuevo_cliente(
                $productos_deseados_carro_compra, $es_cliente, $envia_cliente);
        
        
        $this->response($response);
    }


    private function orden_compra_recompensa($id_orden_compra, $param)
    {
        
        $recompensas = $param["recompensas"];
        $response = "";
        if (es_data($recompensas)) {
            
            $q = ["ids" => $recompensas, "id_orden_compra" => $id_orden_compra];
            $response = $this->app->api("recompensa_orden_compra/ids", $q, "json", "POST");
    

        }
        return $response;
            

    }

    private function gamifica_ventas_vendedor($id_usuario)
    {
        $q = ["id_usuario" => $id_usuario];
        return $this->app->api("usuario/gamifica_ventas", $q, "json", "PUT");

    }
    
    private function notifica_productos_envio_pago_vendedor($ids)
    {

        $response = false;
        if (es_data($ids)) {

            $response = $this->app->api(
                "usuario_deseo/envio_pago",
                ["ids" => $ids], "json", "PUT");
        }

        return $response;
    }
    private function notifica_productos_envio_pago_nuevo_usuario($ids)
    {

        $response = false;
        if (es_data($ids)) {

            $response = $this->app->api(
                "usuario_deseo_compra/envio_pago",
                ["ids" => $ids], "json", "PUT");
        }

        return $response;
    }

    private function productos_envio_pago_usuario($producto_carro_compra, $envia_cliente = 0)
    {

        $response = [];
        if (es_data($producto_carro_compra)) {

            $response = $this->app->api("usuario_deseo/envio_pago",
                [
                    "ids" => $producto_carro_compra,
                    "envia_cliente" => $envia_cliente
                ]
            );
        }

        return $response;

    }

    private function productos_envio_pago_nuevo_usuario($producto_carro_compra)
    {
        return $this->app->api("usuario_deseo_compra/envio_pago",
            [
                "ids" => $producto_carro_compra
            ]
        );

    }

    private function orden($param, $data_servicio, $orden_compra = 0)
    {

        $servicio[0] = $data_servicio;
        $es_nuevo = prm_def($param, "usuario_nuevo");
        $data_servicio['es_usuario_nuevo'] = 1;
        $data_servicio["costo_envio"] = $this->costo_envio_tipo_orden($servicio, $param);
        $data_servicio = $this->tipo_usuario($data_servicio, $es_nuevo, $param);
        $data_servicio["data_por_usuario"] = $param;
        $data_servicio["talla"] = prm_def($param, "talla");
        $data_servicio["orden_compra"] = $orden_compra;
        $data_servicio["cobro_secundario"] = prm_def($param, "cobro_secundario");

        $id_orden_compra = $this->genera_orden_compra($data_servicio);
        $data_servicio["id_orden_compra"] = $id_orden_compra;

        return $data_servicio;
    }

    function costo_envio_tipo_orden($servicio, $param)
    {

        $response = 0;
        $es_servicio = pr($servicio, "flag_servicio");
        if ($es_servicio < 1) {
            $tipo_entrega = prm_def($param, "tipo_entrega");
            $servicio[0]["tipo_entrega"] = $tipo_entrega;

            if ($tipo_entrega == 1) {

                $response = $this->get_costo_envio_punto_encuentro($param);

            } else {

                $response = $this->get_costo_envio($servicio);

            }

            $this->quita_carro_compras($param);

        }

        return $response;

    }

    private function get_costo_envio_punto_encuentro($q)
    {

        $response = $this->app->api("punto_encuentro/costo_entrega", $q);

        return (es_data($response)) ? $response[0]["costo_envio"] : 100;

    }

    private function quita_carro_compras($param)
    {

        $carro_compras = prm_def($param, "carro_compras");
        $id_carro_compras = prm_def($param, "id_carro_compras");
        if ($carro_compras > 0 && $id_carro_compras > 0) {

            $q = [
                "status" => 1,
                "id" => $param["id_carro_compras"],

            ];

            return $this->app->api("usuario_deseo/status", $q, "json", "PUT");


        }
    }

    private function tipo_usuario($data, $es_nuevo, $param)
    {


        $envia_cliente = prm_def($param, "envia_cliente");
        $data["id_usuario"] = ($envia_cliente < 1 && $es_nuevo < 1) ? $this->id_usuario : $param["id_usuario"];
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

    private function genera_orden_compra($q)
    {

        return $this->app->api("recibo/orden_de_compra", $q, "json", "POST");

    }

    function posterior_compra($data_orden, $id_orden_compra, $id_servicio, $param, $es_nuevo)
    {

        $this->gamificacion_deseo($id_servicio, 2);
        $id_usuario_venta = key_exists_bi($data_orden, "servicio", "id_usuario_venta", 0);

        $pos =
            [
                "id_orden_compra" => $id_orden_compra,
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

        $this->notifica_deuda_cliente($pos);
        if ($param["tipo_entrega"] != 2) {

            $this->posterior_pe($param, $id_orden_compra, $pos["id_usuario"]);

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


    function notifica_deuda_cliente($q)
    {
        return $this->app->api("areacliente/pago_pendiente_web", $q);

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

    private function posterior_pe($param, $id_orden_compra, $id_usuario)
    {

        $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
        $response = false;
        foreach ($productos_orden_compra as $row) {

            $q = [
                "id_recibo" => $row["id_proyecto_persona_forma_pago"],
                "id_usuario" => $id_usuario,
                "punto_encuentro" => $param["punto_encuentro"]
            ];
            $status = $this->create_orden_punto_entrega($q);
            $response = $this->agrega_punto_encuentro_usuario($q);
        }


        return $response;
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

    function solicitud_cambio_punto_entrega_POST()
    {

        $param = $this->post();
        $response = [];
        if (fx($param, "punto_encuentro,fecha_entrega,horario_entrega,orden_compra")) {

            $id_orden_compra = $param["orden_compra"];
            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);

            foreach ($productos_orden_compra as $row) {

                $id_recibo = $row["id_proyecto_persona_forma_pago"];
                /*Lo modifico en la orden*/
                $param['id_recibo'] = $id_recibo;
                $response = $this->create_orden_punto_entrega($param);
                /*Lo agrego en el diccionario para el usuario*/
                $param["id_usuario"] = $this->id_usuario;
                $nuevo = $this->agrega_punto_encuentro_usuario($param);
                $response_domicilio = $this->quita_domicilio_entrega_por_recibo($id_recibo);
                $response = $this->valida_costo_envio($id_recibo, $param['punto_encuentro']);

            }

            $this->fecha_entrega($param['fecha_entrega'], $param['horario_entrega'], $id_orden_compra);

            $data =
                [
                    'restricciones' => $this->config->item('restricciones'),
                    'id_perfil' => $this->app->getperfiles()
                ];

            $path_seguimiento = path_enid('pedidos_recibo', $id_orden_compra);

            $response = [
                'punto_nuevo' => $nuevo,
                'id_orden_compra' => $id_orden_compra,
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

    function usuario_referencia_es_premium($param)
    {
        $es_premium = 0;
        if (array_key_exists('es_cliente', $param) && $param['es_cliente'] < 1) {

            $usuario = $this->app->usuario($this->id_usuario);
            $data = $this->app->session();
            $es_premium = es_premium($data, $usuario);
        }

        return $es_premium;
    }


    function referencia_usuario($param, $usuario_referencia)
    {

        $param["es_premium"] = 0;
        if ($usuario_referencia > 0) {

            $param['usuario_referencia'] = $usuario_referencia;
            $param["es_premium"] = $this->usuario_referencia_es_premium($param);

        }
        return $param;
    }

    function primer_orden_POST()
    {

        $param = $this->post();
        $usuario_referencia = $this->usuario_referencia($param);
        $param = $this->referencia_usuario($param, $usuario_referencia);
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

            $response = $this->crea_orden($param);            
            $response = $this->has_login($response, $param);
            $response += $param;

            $this->response($response);
        }
        $this->response($usuario);

    }

    function siguiente_compra_POST()
    {

        $param = $this->post();
        $session = $this->app->get_session();
        $en_session = $session["logged_in"];
        $response = false;
        if ($en_session) {

            $param += [
                "es_usuario_nuevo" => 0,
                "usuario_nuevo" => 0,
                "usuario_existe" => 0,
                "es_cliente" => 1,
                "envia_cliente" => 1
            ];
            $response = $this->crea_orden($param);
            $response = $this->has_login($response, $param);

        }

        $this->response($response);


    }

    private function has_login($productos_orden_compra, $param)
    {


        if (es_data($productos_orden_compra)) {

            $ordenes_creadas = array_column($productos_orden_compra, 'orden_creada');
            $ids_ordenes_compra = array_column($productos_orden_compra, 'id_orden_compra');
            $id_orden_compra = array_unique($ids_ordenes_compra)[0];
            $es_orden_creada = (!in_array(0, $ordenes_creadas));
            $productos_orden_compra["session_creada"] = 0;


            $envia_cliente = prm_def($param, "envia_cliente");
            if ($es_orden_creada && $param['es_cliente'] > 0 && $envia_cliente < 1) {
                $session = $this->create_session($param);
                if (es_data($session)) {
                    $productos_orden_compra["session_creada"] = 1;
                    $productos_orden_compra["id_orden_compra"] = $id_orden_compra;
                    $this->app->set_userdata($session);

                }
            } else {

                $productos_orden_compra["session_creada"] = 1;
                $productos_orden_compra["id_orden_compra"] = $id_orden_compra;
            }
        }

        return $productos_orden_compra;
    }

    function crea_usuario($q)
    {

        return $this->app->api("usuario/prospecto", $q, "json", "POST");
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

        return $this->app->api("servicio/nombre_estado_enid", $q);
    }

    function fecha_entrega($fecha_entrega, $horario_entrega, $id_orden_compra)
    {

        $q = [
            "fecha_entrega" => $fecha_entrega,
            "horario_entrega" => $horario_entrega,
            "orden_compra" => $id_orden_compra,
            "tipo_entrega" => 1,

        ];
        return $this->app->api("recibo/fecha_entrega/", $q, "json", "PUT");

    }

    private function valida_costo_envio($id_recibo, $punto_encuentro)
    {
        $q = ['punto_encuentro' => $punto_encuentro];
        $costo_entrega = $this->get_costo_envio_punto_encuentro($q);

        $q = [
            "recibo" => $id_recibo,
            "costo_envio" => $costo_entrega
        ];
        return $this->app->api("recibo/costo_envio/", $q, "json", "PUT");

    }

    function comision_GET()
    {

        $this->response(7);
    }

}