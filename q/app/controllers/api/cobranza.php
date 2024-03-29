<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Cobranza extends REST_Controller
{
    public $option;
    private $id_usuario;
    protected $session_enid;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("cobranza");
        $this->load->model("recompensa_orden_compra_model");
        $this->load->model("usuario_deseo_model");       
        $this->load->model("usuario_deseo_compra_model");           
        $this->load->library(lib_def());
        $this->session_enid = new Enid\SessionEnid\Format($this->app);
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
        $this->response(span(
            $param["id_proyecto_persona_forma_pago"],
            "blue_enid white"
        ));
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
        $productos_deseados_carro_compra,
        $es_cliente,
        $envia_cliente
    ) {

        if ($es_cliente) {

            /**/
            if ($envia_cliente > 0) {

                $ids = array_column($productos_deseados_carro_compra, "id");
                $this->notifica_productos_envio_pago_vendedor($ids);
            } else {

                $ids = array_column(
                    $productos_deseados_carro_compra,
                    "id_usuario_deseo_compra"
                );
                $this->notifica_productos_envio_pago_nuevo_usuario($ids);
            }
        } else {

            /*Se notifica que el vendedor envió orden de compra en el carro de compras*/
            $ids = array_column(
                $productos_deseados_carro_compra,
                "id"
            );
            $this->notifica_productos_envio_pago_vendedor($ids);
        }
    }

    function solicitud_proceso_pago_POST()
    {

        $this->response($this->crea_orden($this->post()));
    }


    private function orden_compra_recompensa($id_orden_compra, $param)
    {

        $recompensas = $param["recompensas"];
        $response = "";
        if (es_data($recompensas)) {

            foreach ($recompensas as $row) {
                if ($row > 0) {

                    $response = $this->recompensa_orden_compra_model->insert(
                        [
                            "id_recompensa" =>  $row,
                            "id_orden_compra" => $id_orden_compra
                        ]
                    );
                }
            }
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

            $ids = get_keys($ids);
            $response = $this->usuario_deseo_model->envio_pago($ids);            
        }

        return $response;
    }
    private function notifica_productos_envio_pago_nuevo_usuario($ids)
    {

        $response = false;
        if (es_data($ids)) {

            $ids = get_keys($ids);
            $response = $this->usuario_deseo_compra_model->envio_pago($ids);

        }

        return $response;
    }

    private function productos_envio_pago_usuario($producto_carro_compra, $envia_cliente = 0)
    {

        $response = [];
        if (es_data($producto_carro_compra)) {

            $response = $this->app->api(
                "usuario_deseo/envio_pago",
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
        return $this->app->api(
            "usuario_deseo_compra/envio_pago",
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
        $data_servicio["numero_boleto"] = prm_def($data_servicio, "numero_boleto");

        $id_orden_compra = $this->app->api("recibo/orden_de_compra", $data_servicio, "json", "POST");
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
            $response = $this->get_costo_envio($servicio);
            $this->quita_carro_compras($param);
        }

        return $response;
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
   
    function quita_domicilio_entrega_por_recibo($id_recibo)
    {


        $q = ["id_recibo" => $id_recibo];

        return $this->app->api(
            "proyecto_persona_forma_pago_direccion/index",
            $q,
            "json",
            "DELETE"
        );
    }

    function usuario_referencia($param)
    {
        $usuario_referencia = 0;
        if (intval(prm_def($param, "es_cliente")) < 1) {

            $usuario_referencia = $this->id_usuario;
        }

        return $usuario_referencia;
    }

    function usuario_referencia_es_premium($param)
    {
        $es_premium = 0;
        if (intval(prm_def($param, "es_cliente")) < 1) {

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

        if (es_data($usuario) && prm_def($usuario, "usuario_registrado") > 0 && prm_def($usuario, "id_usuario") > 0) {

            $usuario_referencia = ($usuario_referencia > 0) ? $usuario_referencia : $usuario["id_usuario"];
            $id_usuario = $usuario["id_usuario"];
            $param += [
                "es_usuario_nuevo" => 1,
                "usuario_nuevo" => 1,
                "usuario_referencia" => $usuario_referencia,
                "id_usuario" => $id_usuario,
                "usuario_existe" => 0,
            ];

            $response = $this->crea_orden($param);
            $response = $this->has_login($response, $param);
            /*Adicionales*/
            $this->adicionales($param, $response);            
            $response += $param;

            $this->response($response);
        }
        $this->response($usuario);
    }

    
    function adicionales($param, $response)
    {

        $comentario_compra = prm_def($param, "comentario_compra");
        if (str_len($comentario_compra, 5)) {

            return $this->app->api(
                "orden_comentario/index",
                [
                    "orden_compra" => $response["id_orden_compra"],
                    "comentarios" =>  $comentario_compra
                ],
                "json",
                "POST"
            );
        }
        return $response;
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
                                
                $session = $this->session_enid->session(
                    $param["email"],$param["password"],
                    1
                );
                
                if (es_data($session)) {
                    $productos_orden_compra["session_creada"] = 1;
                    $productos_orden_compra["id_orden_compra"] = $id_orden_compra;
                    
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
        $id_numero_cliente = prm_def($q, "numero_cliente");

        if (intval($id_numero_cliente) > 0) {

            $usuario = $this->app->usuario($id_numero_cliente);
            $usuario["id_usuario"] = $id_numero_cliente;
            $usuario["usuario_registrado"] = 1;

            return $usuario;
        } else {

            return $this->app->api("usuario/prospecto", $q, "json", "POST");
        }
    }

    private function crea_orden($param)
    {

        $a = 0;
        $es_cliente = prm_def($param, "es_cliente");
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
            $productos_deseados_carro_compra,
            $es_cliente,
            $envia_cliente
        );
        return $response;
    }



    function valida_envio_notificacion_nuevo_usuario($param)
    {
        $fn = (prm_def(
            $param,
            "usuario_nuevo"
        ) > 0) ? $this->notifica_registro_usuario($param) : "";
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
    
}
