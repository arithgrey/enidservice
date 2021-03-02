<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class recibo extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("recibo_model");
        $this->load->helper("recibo");
        $this->load->library('table');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");

    }

    function index_GET()
    {
        $param = $this->get();
        if (fx($param, "recibo")) {
            $id = $param['recibo'];
            $q = prm_def($param, 'q');
            $busqueda = (es_data($q)) ? $q : [];
            $response = $this->recibo_model->q_get($busqueda, $id);
        }
        $this->response($response);
    }

    function clientes_frecuentes_GET()
    {

        $response = $this->recibo_model->clientes_frecuentes();
        $this->response($response);
    }

    function compras_usuario_GET()
    {

        $param = $this->get();
        $response = [];
        $this->response($response);

    }

    function pendientes_sin_cierre_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,id_perfil,id_empresa")) {


            $data = $this->app->session();
            $id_empresa = $param['id_empresa'];
            $id_usuario = $param["id_usuario"];
            $id_perfil = $param['id_perfil'];
            $usuarios_empresa = $this->usuarios_empresa_perfil($id_empresa, 1, $data);

            $idusuarios_empresa = array_column($usuarios_empresa, 'idusuario');
            $idusuarios_empresa = array_unique($idusuarios_empresa);

            $response = $this->recibo_model->pendientes_sin_cierre($id_usuario, $id_perfil, $id_empresa, $idusuarios_empresa);
            $recibos = $this->horarios_contra_entrega_pedidos($response);
            $response = $this->usuarios_ventas_notificaciones($recibos['recibos']);
            if (prm_def($param, 'domicilios') > 0) {

                $recibos['recibos'] = $response;
                $es_cliente =
                    es_cliente($param);
                if (!$es_cliente) {

                    $ordenes = $this->append_usuarios_reparto($recibos['recibos']);
                    $ordenes = $this->append_usuario_cliente($ordenes);

                    $recibos['recibos'] = $ordenes;
                }

                $response = $this->domicilios_puntos_encuentro_ubicaciones($recibos);
            }

        }
        $this->response($response);

    }

    function usuario_relacion_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,es_pago")) {

            $response = [];
            $recibo = $this->recibo_model->q_usuario($param["id_usuario"], 100);
            if (es_data($recibo)) {

                $id_usuario = prm_def($param, 'id_usuario');
                $usuario = $this->app->usuario($id_usuario);
                $email = pr($usuario, "email");
                $tel_contacto = pr($usuario, "tel_contacto");
                $q = ["id_usuario" => $id_usuario, "email" => $email, "tel_contacto" => $tel_contacto];
                $usuarios = $this->usuarios_similares($q);
                $ids_usuarios = array_column($usuarios, 'idusuario');

                if (es_data($ids_usuarios)) {

                    $params = $this->parametros_busqueda(0);
                    $response = $this->recibo_model->ids_usuarios($params, get_keys($ids_usuarios), $param["es_pago"]);
                }

            }

        }

        $this->response($response);

    }

    function domicilios_puntos_encuentro_ubicaciones($domicilios)
    {

        $a = 0;

        if (es_data($domicilios)) {

            $recibos_puntos_encuentro = prm_def($domicilios, 'recibos_puntos_encuentro');
            $recibos_domicilio = prm_def($domicilios, 'recibos_domicilio');
            $ids_ubicaciones = prm_def($domicilios, 'recibos_ubicaciones');

            $ids_punto_encuentro = es_data($recibos_puntos_encuentro) ? array_column($recibos_puntos_encuentro, 'id_punto_encuentro') : [];
            $ids_direccion = es_data($recibos_domicilio) ? array_column($recibos_domicilio, 'id_direccion') : [];


            $data_puntos_encuentro = $this->get_puntos_encuentro_ids($ids_punto_encuentro);
            $data_direcciones = $this->get_direcciones_ids($ids_direccion);
            $data_ubicaciones = $this->get_ubicaciones_ids($ids_ubicaciones);


            $recibos = $domicilios['recibos'];
            $data_recibos = [];

            foreach ($recibos as $row) {

                $tipo_entrega = $row['tipo_entrega'];

                $es_contra_entrega = $row['es_contra_entrega'];
                $id_recibo = $row['id_recibo'];
                $id_punto_encuentro = $row['id_punto_encuentro'];
                $ubicacion = $row['ubicacion'];


                $domicilio = [];
                $punto_encuentro = [];
                $localizacion = [];
                switch ($tipo_entrega) {
                    case 1:
                        /*Punto de encuentro*/

                        if ($id_punto_encuentro > 0) {
                            $pos = search_bi_array($data_puntos_encuentro, 'id', $id_punto_encuentro);
                            $punto_encuentro = $data_puntos_encuentro[$pos];
                        }


                        break;

                    case 2:
                        /*A domicilio*/
                        $id_domicilio = $row['id_domicilio'];
                        if ($id_domicilio > 0) {

                            $pos = search_bi_array($data_direcciones, 'id_direccion', $id_domicilio);
                            $domicilio = $data_direcciones[$pos];
                        }


                        $localizacion = $this->get_data_ubicacion($data_ubicaciones, $id_recibo);


                        break;
                    default:
                        break;
                }

                $data_recibos[$a] = $row;
                $data_recibos[$a]['data_punto_encuentro'] = $punto_encuentro;
                $data_recibos[$a]['data_domicilio'] = $domicilio;
                $data_recibos[$a]['data_ubicacion'] = $localizacion;
                $a++;

            }
        }

        return $data_recibos;
    }

    function get_data_ubicacion($data_ubicaciones, $id_recibo)
    {

        $response = [];
        foreach ($data_ubicaciones as $row) {

            $id_recibo_ubicacion = $row['id_recibo'];
            if ($id_recibo == $id_recibo_ubicacion) {
                $response = $row;
                break;
            }
        }
        return $response;
    }

    function horarios_contra_entrega_pedidos($ordenes_compra)
    {
        $ids_contra_entrega_domicilio = [];
        $ids_puntos_encuentro = [];
        $ids_ubicaciones = [];

        foreach ($ordenes_compra as $row) {

            $tipo_entrega = $row['tipo_entrega'];
            $id_recibo = $row['id_recibo'];
            $ubicacion = $row['ubicacion'];
            switch ($tipo_entrega) {
                case 1:

                    $ids_puntos_encuentro[] = $id_recibo;
                    break;

                case 2:

                    $ids_contra_entrega_domicilio[] = $id_recibo;
                    if ($ubicacion > 0) {
                        $ids_ubicaciones[] = $id_recibo;
                    }

                    break;
                default:
            }
        }

        $recibos_domicilio = $this->get_recibos_domicilio($ids_contra_entrega_domicilio);
        $recibos_puntos_encuentro = $this->get_recibos_puntos_encuentro($ids_puntos_encuentro);


        $recibos_domicilio_contra_entrega_sin_domicilio =
            $this->recibos_domicilio_contra_entrega_sin_domicilio(
                $ids_contra_entrega_domicilio, $recibos_domicilio);


        $recibos = $this->domicilios_contra_entrega_pedidos(
            $ordenes_compra,
            $ids_contra_entrega_domicilio,
            $recibos_domicilio_contra_entrega_sin_domicilio,
            $recibos_domicilio,
            $recibos_puntos_encuentro
        );

        return [
            'recibos' => $recibos,
            'recibos_domicilio' => $recibos_domicilio,
            'recibos_puntos_encuentro' => $recibos_puntos_encuentro,
            'recibos_ubicaciones' => $ids_ubicaciones
        ];


    }

    function usuarios_ventas_notificaciones($recibos)
    {

        $ids_usuarios = array_unique(array_column($recibos, 'id_usuario_referencia'));
        $data_complete = [];
        $a = 0;

        $usuarios = $this->usuarios_q($ids_usuarios);
        foreach ($recibos as $row) {

            $data_complete[$a] = $row;
            $id_usuario_referencia = $row['id_usuario_referencia'];

            $nombre = '';
            foreach ($usuarios as $row2) {

                if ($id_usuario_referencia == $row2['id_usuario']) {

                    $nombre = format_nombre($row2);

                    break;
                }
            }

            $data_complete[$a]['nombre_vendedor'] = $nombre;
            $a++;
        }

        return $data_complete;

    }

    function usuarios_q($ids_usuarios)
    {

        $q["ids"] = $ids_usuarios;
        return $this->app->api("usuario/ids/format/json/", $q);
    }

    function domicilios_contra_entrega_pedidos($ordenes_compra, $ids_contra_entrega_domicilio,
                                               $sin_direccion_contra_entrega,
                                               $recibos_domicilio,
                                               $recibos_puntos_encuentro)
    {

        $recibos = [];
        $a = 0;
        foreach ($ordenes_compra as $row) {

            $recibos[$a] = $row;
            $id_recibo = $row['id_recibo'];
            $es_contra_entrega_domicilio = in_array($id_recibo, $ids_contra_entrega_domicilio);
            if ($es_contra_entrega_domicilio) {

                $es_contra_entrega_domicilio_sin_direccion = (in_array($id_recibo, $sin_direccion_contra_entrega));
                $id_domicilio = search_bi_array($recibos_domicilio, 'id_proyecto_persona_forma_pago', $id_recibo, 'id_direccion', 0);
                $recibos[$a]['es_contra_entrega_domicilio_sin_direccion'] = $es_contra_entrega_domicilio_sin_direccion;
                $recibos[$a]['id_domicilio'] = $id_domicilio;

            }

            $id_punto_encuentro = search_bi_array($recibos_puntos_encuentro, 'id_proyecto_persona_forma_pago', $id_recibo, 'id_punto_encuentro', 0);

            $recibos[$a]['id_punto_encuentro'] = $id_punto_encuentro;
            $recibos[$a]['es_contra_entrega'] = $es_contra_entrega_domicilio;

            $a++;
        }
        return $recibos;
    }

    function recibos_domicilio_contra_entrega_sin_domicilio($ids_contra_entrega_domicilio, $recibos_domicilio)
    {


        $response = [];
        foreach ($ids_contra_entrega_domicilio as $row) {

            $id_recibo = (int)$row;
            $tiene_direccion = search_bi_array($recibos_domicilio, 'id_proyecto_persona_forma_pago', $id_recibo, FALSE, FALSE);
            if ($tiene_direccion === false) {

                $response[] = $id_recibo;
            }
        }
        return $response;

    }

    function get_recibos_domicilio($ids_contra_entrega_domicilio)
    {
        $response = [];
        if (es_data($ids_contra_entrega_domicilio)) {

            $response = $this->recibos_domicilios($ids_contra_entrega_domicilio);
        }
        return $response;
    }

    function get_recibos_puntos_encuentro($ids_recibos)
    {
        $response = [];
        if (es_data($ids_recibos)) {

            $response = $this->recibos_puntos_encuentro($ids_recibos);
        }
        return $response;
    }

    function get_puntos_encuentro_ids($ids)
    {
        $response = [];
        if (es_data($ids)) {

            $q = [
                'v' => 1,
                'ids' => get_keys($ids)
            ];

            $response = $this->app->api("punto_encuentro/ids/format/json/", $q);
        }
        return $response;
    }

    function get_direcciones_ids($ids)
    {
        $response = [];
        if (es_data($ids)) {

            $q = [
                'v' => 1,
                'ids' => get_keys($ids)
            ];

            $response = $this->app->api("direccion/ids/format/json/", $q);
        }
        return $response;
    }

    function get_ubicaciones_ids($ids)
    {
        $response = [];
        if (es_data($ids)) {

            $q = [
                'v' => 1,
                'ids' => get_keys($ids)
            ];

            $response = $this->app->api("ubicacion/ids_recibo/format/json/", $q);
        }
        return $response;
    }


    function tiempo_venta_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        $response = false;

        if (fx($param, "id_usuario,q,fecha_inicio,fecha_termino")) {
            $response = $this->recibo_model->get_tiempo_venta($param);
            if (es_data($response)) {

                $total = $this->recibo_model->get_tiempo_venta($param, 1);
                $response = $this->app->imgs_productos(0, 1, 1, 1, $response);
                $response = $this->get_costos_operativos($response,
                    $param["fecha_inicio"], $param["fecha_termino"]);
                $response = get_format_tiempo_entrega($response, $total, $param);

            } else {
                $response = sin_resultados_busqueda();
            }

        }
        $this->response($response);

    }

    private function get_costos_operativos($data, $fecha_inicio, $fecha_termino)
    {


        $response = [];
        $a = 0;
        foreach ($data as $row) {

            $response[$a] = $row;
            if ($fecha_inicio === $fecha_termino) {
                $fecha_termino = $fecha_inicio = "";

            }

            $ids_recibo = $this->recibo_model->get_recibo_ventas_pagas_servicio($row["id_servicio"],
                $fecha_inicio, $fecha_termino);
            $costos = (es_data($ids_recibo)) ? $this->get_text_in($ids_recibo) : [];
            $response[$a]["total_costos_operativos"] = $costos;
            $a++;

        }

        return $response;

    }

    private function get_text_in($data)
    {

        $response = [];
        $total = 0;
        foreach ($data as $row) {

            $response[] = $row["recibo"];
            $total = ($total + $row["saldo_cubierto"]);
        }

        $response = add_fields($response);

        return [
            "total_costos" => intval($this->get_sumatoria_costos_operativos($response)),
            "total_pagos" => $total,
        ];
    }

    private function get_sumatoria_costos_operativos($in)
    {

        $q["in"] = $in;

        return $this->app->api("costo_operacion/qsum/format/json/", $q);

    }

    function saldo_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->recibo_model->get_saldo_usuario($param);
        }
        $this->response($response);
    }

    function pago_comision_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,monto")) {
            /*los pagos y fecha registro se mantienen en los costos operativos*/
            $response = $this->recibo_model->q_up("flag_pago_comision", 1, $param['id']);

        }
        $this->response($response);
    }

    function cantidad_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,cantidad")) {

            $id = $param["id"];
            $cantidad = $param['cantidad'];

            $response = $this->recibo_model->q_up(
                "num_ciclos_contratados",
                $cantidad,
                $id
            );

        }
        $this->response($response);
    }

    function lista_negra_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_recibo")) {

            $id_recibo = $param['id_recibo'];
            $response = $this->recibo_model->update(
                [
                    'status' => 19,
                    'se_cancela' => 1,
                ],
                ["id_proyecto_persona_forma_pago" => $id_recibo]
            );


            $response = $this->boletina_compras($param);


        }
        $this->response($response);
    }

    function boletina_compras($param)
    {
        $telefono = prm_def($param, 'telefono');
        $response = '';
        if ($telefono > 0) {

            $response = $this->recibo_model->ordenes_por_telefono($telefono);
            $ordenes = [];
            foreach ($response as $row) {
                $ordenes[] = $row['id_proyecto_persona_forma_pago'];
            }

            if (es_data($ordenes)) {

                $response = $this->recibo_model->boletina_ordenes($ordenes);
            }
        }
        return $response;
    }

    function registro_articulo_interes_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->recibo_model->q_up("registro_articulo_interes", 1, $param['id']);

        }
        $this->response($response);
    }

    function repartidor_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "recibo,usuario")) {

            $response = $this->recibo_model->q_up("id_usuario_entrega", $param['usuario'], $param['recibo']);

        }
        $this->response($response);
    }

    function cancelar_envio_recordatorio_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id")) {

            $response = $this->recibo_model->q_up("cancela_email", 1, $param["id"]);
        }
        $this->response($response);
    }

    function reparto_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "orden_compra")) {

            $id_orden_compra = $param['orden_compra'];
            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);

            foreach ($productos_orden_compra as $row) {

                $id_recibo = $row["id_proyecto_persona_forma_pago"];
                $id_servicio = $this->servicio_recibo($id_recibo);
                $params = [
                    "status" => 16,
                    "saldo_cubierto" => 0,
                    'se_cancela' => 0,
                    'cancela_cliente' => 0
                ];

                $in = ["id_proyecto_persona_forma_pago" => $id_recibo];
                $repartidores = $this->repartidores($id_servicio);
                $repartidores_en_entrega = $this->recibo_model->espacios($id_recibo);
                $id_usuario = repartidor_disponible($repartidores_en_entrega, $repartidores);
                $params['id_usuario_entrega'] = $id_usuario;
                $response = $this->recibo_model->update($params, $in);
            }

        }
        $this->response($response);
    }


    function servicio_ppfp_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo")) {

            $response = $this->servicio_recibo($param["id_recibo"]);

        }
        $this->response($response);
    }

    function saldo_pendiente_recibo_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo")) {
            $response = $this->get_saldo_pendiente_recibo($param);
        }
        $this->response($response);
    }

    function get_saldo_pendiente_recibo($param)
    {

        $response = 0;
        $recibo = $this->recibo_model->q_get(
            [
                "monto_a_pagar",
                "num_ciclos_contratados",
                "flag_envio_gratis",
                "tipo_entrega"
            ],
            $param["id_recibo"]
        );

        if (es_data($recibo)) {


            $monto_a_pagar = pr($recibo, "monto_a_pagar");
            $num_ciclos_contratados = pr($recibo, "num_ciclos_contratados");
            $costo_envio = get_costo_envio($recibo);
            $response = ($monto_a_pagar * $num_ciclos_contratados) + $costo_envio["costo_envio_cliente"];

        }

        return $response;
    }

    function orden_de_compra_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario,id_ciclo_facturacion,talla")) {

            $id = $this->recibo_model->crea_orden_de_compra($param);
            $response = $this->recibo($id);

        }
        $this->response($response);
    }

    private function recibo($id)
    {

        $q = ["id" => $id];
        return $this->app->api("orden_compra/index", $q, "json", "POST");
    }

    function precio_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio")) {
            $response = $this->recibo_model->get_precio_servicio($param);
        }
        $this->response($response);

    }

    function compras_efectivas_GET()
    {

        $param = $this->get();
        $param["id_usuario"] = $this->id_usuario;
        if (fx($param, "modalidad,id_usuario")) {


            $compras = $this->recibo_model->compras_ventas_efectivas_usuario($param);
            $compras = $this->app->imgs_productos(0, 1, 1, 1, $compras);

            $data = $this->app->session();
            $data += [
                "ordenes" => $compras,
                "modalidad" => $param["modalidad"],
                "id_perfil" => 0
            ];

            $lista_compras = create_listado_compra_venta($data);
            $response = d($lista_compras, 1);

        }

        $this->response($response);
    }

    function get_estatus_servicio_enid_service($q)
    {
        return $this->app->api("status_enid_service/servicio/format/json/", $q);
    }

    function recibos_GET()
    {

        $param = $this->get();
        $data = $this->app->session();
        $response = false;
        if (fx($param, "modalidad")) {

            $response["total"] = 0;
            $modalidad = $param["modalidad"];
            $param["id_usuario"] = $id_usuario = $this->id_usuario;
            $ordenes = $this->recibo_model->get_compras_usuario($param, $modalidad);
            $ordenes = $this->add_imgs_servicio($ordenes);

            if (es_data($ordenes)) {

                $data += [
                    "id_usuario" => $id_usuario,
                    "ordenes" => $ordenes,
                    "modalidad" => $modalidad,
                    "id_perfil" => $this->app->getperfiles(),
                    "total" => count($ordenes)
                ];

                $response = get_vista_cliente($data);

            }
        }
        $this->response($response);

    }

    private function add_imgs_servicio($ordenes)
    {

        $a = 0;
        $response = [];
        $path_servicio = [];
        $servicios = [];
        foreach ($ordenes as $row) {

            $orden = $row;
            $id_servicio = $ordenes[$a]["id_servicio"];
            if (!in_array($id_servicio, $servicios)) {
                $servicios[] = $id_servicio;
                $path = $this->app->imgs_productos($id_servicio, 1, 1, 1);
                $path_servicio[] = [
                    'id_servicio' => $id_servicio,
                    'path' => $path
                ];
                $orden["url_img_servicio"] = $path;

            } else {

                $path = search_bi_array($path_servicio, 'id_servicio', $id_servicio, 'path');
                $orden["url_img_servicio"] = $path;
            }

            $a++;
            $response[] = $orden;
        }

        return $response;
    }

    function add_comisionistas($ordenes, $param)
    {
        $id_perfil = $param['perfil'];
        $es_administrador = (!in_array($id_perfil, [20, 6]));

        if ($es_administrador) {

            return $this->append_usuarios($ordenes);

        } else {

            return $ordenes;
        }

    }

    function append_usuarios($ordenes)
    {
        $a = 0;
        $ids_usuarios = [];
        $usuarios = [];
        $response = [];

        foreach ($ordenes as $row) {

            $orden = $row;
            $id_usuario_referencia = $row['id_usuario_referencia'];
            $response[$a] = $orden;
            if (!in_array($id_usuario_referencia, $ids_usuarios)) {

                $ids_usuarios[] = $id_usuario_referencia;
                $usuario = $this->app->usuario($id_usuario_referencia);
                $busqueda_usuario =
                    [
                        'id_usuario' => $id_usuario_referencia,
                        'usuario' => $usuario
                    ];
                $response[$a]['usuario'] = $busqueda_usuario['usuario'];
                $usuarios[] = $busqueda_usuario;

            } else {
                $usuario = search_bi_array($usuarios, 'id_usuario', $id_usuario_referencia, 'usuario');
                $response[$a]['usuario'] = $usuario;
            }
            $a++;
        }

        return $response;
    }

    function append_usuarios_reparto($ordenes)
    {
        $a = 0;
        $ids_usuarios = [];
        $usuarios = [];
        $response = [];
        foreach ($ordenes as $row) {

            $orden = $row;
            $id_usuario_entrega = $row['id_usuario_entrega'];
            $response[$a] = $orden;
            if (!in_array($id_usuario_entrega, $ids_usuarios)) {

                $ids_usuarios[] = $id_usuario_entrega;
                $usuario = $this->app->usuario($id_usuario_entrega);
                $busqueda_usuario =
                    [
                        'id_usuario' => $id_usuario_entrega,
                        'usuario_entrega' => $usuario
                    ];
                $response[$a]['usuario_entrega'] = $busqueda_usuario['usuario_entrega'];
                $usuarios[] = $busqueda_usuario;

            } else {
                $usuario = search_bi_array($usuarios, 'id_usuario', $id_usuario_entrega, 'usuario_entrega');
                $response[$a]['usuario_entrega'] = $usuario;
            }
            $a++;
        }

        return $response;
    }

    function append_usuario_cliente(&$ordenes)
    {

        $ids_ordenes = array_column($ordenes, "id_usuario");
        $ids_usuarios = array_unique($ids_ordenes);
        $usuarios = $this->usuarios_q($ids_usuarios);
        $a = 0;

        $response = [];
        foreach ($ordenes as $row) {

            $id_usuario = (int)$row['id_usuario'];
            $response[$a] = $row;
            $index = search_bi_array($usuarios, "id_usuario", $id_usuario, FALSE, FALSE);

            if ($index !== FALSE) {

                $response[$a]['usuario_cliente'] = $usuarios[$index];

            } else {
                $response[$a]['usuario_cliente'] = [];
            }

            $a++;
        }

        return $response;
    }

    function agrega_estados_direcciones_a_pedidos($ordenes_compra)
    {

        $ordenes = [];
        $a = 0;
        foreach ($ordenes_compra as $row) {

            $ordenes[$a] = $row;
            $ordenes[$a]["direccion_registrada"] = ($row["status"] == 6) ? 0 : 1;
            $a++;
        }

        return $ordenes;
    }

    private function get_tipos_entregas()
    {

        return $this->app->api("tipo_entrega/index/format/json/");
    }


    function resumen_desglose_pago_GET()
    {

        $param = $this->get();
        $response = false;
        $id_orden_compra = $param["id_orden_compra"];
        if ($id_orden_compra > 0) {

            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);

            $dc = [
                "url_request" => get_url_request(""),
                "recibo" => $productos_orden_compra,
                "tipos_entregas" => $this->get_tipos_entregas(),
                "domicilios" => $this->app->domicilios_orden_compra($productos_orden_compra),
                "id_orden_compra" => $id_orden_compra,
                "productos_orden_compra" => $productos_orden_compra
            ];

            /*Este método debe ser para la orden de compra total no por un item*/
            $saldo_cubierto = pr($productos_orden_compra, "saldo_cubierto");
            $monto_a_pagar = pr($productos_orden_compra, "monto_a_pagar");
            $flag_servicio = pr($productos_orden_compra, "flag_servicio");
            $id_usuario_venta = pr($productos_orden_compra, "id_usuario_venta");
            if (($monto_a_pagar > $saldo_cubierto) || $flag_servicio > 0) {

                if ($flag_servicio > 0) {

                    $dc += [
                        "usuario_venta" => $this->app->usuario($id_usuario_venta),
                        "modalidad" => 1,
                        "id_usuario_venta" => $id_usuario_venta
                    ];

                    $response = notificacion_cotizacion($dc);

                } else {

                    $response = $this->ticket_pendiente_pago($param, $dc);

                }


            } else {


                $dc += [
                    "usuario_venta" => $this->app->usuario($id_usuario_venta),
                    "modalidad" => 1,
                ];

                $response = notificacion_pago_realizado($dc);

            }


        }

        $this->response($response);
    }

    private function get_ubicacion_recibo($id_recibo)
    {
        return $this->app->api("ubicacion/index/format/json/",
            ["id_recibo" => $id_recibo]);
    }

    private function get_domicilio_recibo($id_recibo)
    {


        $q["id_recibo"] = $id_recibo;
        $direccion = $this->app->api("proyecto_persona_forma_pago_direccion/recibo/format/json/",
            $q);
        $domicilio = [];

        if (count($direccion) > 0 && $direccion[0]["id_direccion"] > 0) {

            $id_direccion = $direccion[0]["id_direccion"];
            $domicilio = $this->get_direccion($id_direccion);
        }

        return $domicilio;
    }

    private function get_direccion($id)
    {

        return $this->app->api("direccion/data_direccion/format/json/",
            ["id_direccion" => $id]);
    }

    function ticket_pendiente_pago($param, $data)
    {

        $productos_orden_compra = $data["productos_orden_compra"];
        $data["costo_envio_sistema"] = get_costo_envio($productos_orden_compra);
        $tipo_entrega = pr($productos_orden_compra, "tipo_entrega");

        if ($tipo_entrega == 1) {

            return $this->ticket_pendiente_pago_contra_entrega($param, $productos_orden_compra, $data);

        } else {

            $es_cobranza = prm_def($param, "cobranza");
            if ($es_cobranza > 0) {

                $data = $this->get_data_saldo($param, $productos_orden_compra, $data);
                $data["es_punto_encuentro"] = 0;

                $response = $this->pagar($data);


            } else {

                $usuario = $this->app->usuario($productos_orden_compra["id_usuario"]);
                $response = $this->get_mensaje_no_aplica(
                    $productos_orden_compra, get_costo_envio($productos_orden_compra), $usuario, $data);
            }

        }

        return $response;

    }

    function puntos_encuentro_productos_orden_compra($productos_orden_compra)
    {

        $response = [];
        foreach ($productos_orden_compra as $row) {

            $id_proyecto_persona_forma_pago = $row["id_proyecto_persona_forma_pago"];
            $punto_encuentro = $this->get_punto_encuentro_recibo($id_proyecto_persona_forma_pago);
            if (es_data($punto_encuentro)) {

                $response[] = $punto_encuentro;
            }

        }
        return $response;

    }

    function ticket_pendiente_pago_contra_entrega($param, $productos_orden_compra, $dc)
    {


        $response = false;
        $dc["es_punto_encuentro"] = 0;

        if (es_data($productos_orden_compra)):

            $r = $productos_orden_compra[0];
            if (prm_def($param, "cobranza") == 1) :

                if ($r["entregado"] == 0 && $r["se_cancela"] == 0):


                    $puntos_cuento_producto =
                        $this->puntos_encuentro_productos_orden_compra($productos_orden_compra);

                    $ids_punto_encuentro =
                        es_data($puntos_cuento_producto) ?
                            array_column($puntos_cuento_producto, 'id_punto_encuentro') : [];

                    $puntos_encuentro = $this->puntos_encuentro_ids($ids_punto_encuentro);

                    $dc["puntos_encuentro"] = $puntos_encuentro;
                    $dc["es_punto_encuentro"] = 1;
                    $response = $this->pagar($dc);

                endif;

            else:

                $usuario = $this->app->usuario($r["id_usuario"]);
                $response = $this->get_mensaje_no_aplica($productos_orden_compra, get_costo_envio($r[0]),
                    $usuario, $dc);
            endif;

        endif;

        return $response;
    }

    private function puntos_encuentro_ids($ids)
    {

        $response = [];
        for ($a = 0; $a < count($ids); $a++) {

            $response[] = $this->app->api("punto_encuentro/id/format/json/", ["id" => $ids[$a]]);
        }

        return $response;

    }

    private function get_punto_encuentro_recibo($id_recibo)
    {

        $q["id_recibo"] = $id_recibo;
        $end_poinyt= "proyecto_persona_forma_pago_punto_encuentro/punto_encuentro_recibo/format/json/";
        $ppfppe = $this->app->api($end_poinyt,
            $q);

        return pr($ppfppe, "id_punto_encuentro", 0);

    }

    private function pagar($data)
    {

        $response = [];
        $productos_orden_compra = $data["productos_orden_compra"];


        $id_orden_compra = $data["id_orden_compra"];
        $tipos_entrega = $data["tipos_entregas"];
        $url_request = $data["url_request"];

        /*Reparar*/
        $monto_a_pagar = pr($productos_orden_compra, "monto_a_pagar");
        $id_usuario_venta = pr($productos_orden_compra, "id_usuario_venta");
        $resumen_pedido = pr($productos_orden_compra, "resumen_pedido");

        $checkout = format_concepto(
            $resumen_pedido,
            $monto_a_pagar,
            $productos_orden_compra,
            $tipos_entrega
        );

        $pedido[] = $checkout['checkout_resumen'];
        $data_checkout = $checkout['checkout'];
        $seccion_compra = getPayButtons($data, $url_request, $id_usuario_venta, $data_checkout);
        $pedido[] = rastreo_compra($data, $id_orden_compra, $seccion_compra);
        $seccion_compra = d($seccion_compra, 'd-none d-md-block');
        $response[] = dd($seccion_compra, $pedido, 5);


        return append($response);


    }

    private function get_mensaje_no_aplica(
        $recibo,
        $costo_envio_sistema,
        $usuario,
        $data_complete
    )
    {


        $response = false;
        if (es_data($recibo) && es_data($data_complete["servicio"])) {

            $r = $recibo[0];
            $u = $usuario[0];
            $envio_sistema = $costo_envio_sistema["costo_envio_cliente"];
            $saldo_cubierto = $r["saldo_cubierto"];
            $fecha_registro = $r["fecha_registro"];
            $fecha_vencimiento = $r["fecha_vencimiento"];
            $monto_a_pagar = $r["monto_a_pagar"];
            $id_proyecto_persona_forma_pago = $r["id_proyecto_persona_forma_pago"];
            $id_recibo = $id_proyecto_persona_forma_pago;
            $envio_cliente = $r["costo_envio_cliente"];
            $id_ciclo_facturacion = $r["id_ciclo_facturacion"];
            $num_ciclos_contratados = $r["num_ciclos_contratados"];
            $envio_vendedor = $r["costo_envio_vendedor"];
            $resumen_pedido = $r["resumen_pedido"];

            $id_usuario = $u["id_usuario"];
            $nombre = $u["nombre"];
            $a_paterno = ($u["apellido_paterno"] !== null) ? $u["apellido_paterno"] : "";
            $a_materno = ($u["apellido_materno"] !== null) ? $u["apellido_materno"] : "";

            $cliente = $nombre . " " . $a_paterno . " " . $a_materno;
            $envio_cliente = ($envio_sistema > $envio_vendedor) ? $envio_sistema : $envio_cliente;
            $saldo_pendiente = ($monto_a_pagar * $num_ciclos_contratados) - $saldo_cubierto;


            $servicio = $data_complete["servicio"][0];
            $es_servicio = $servicio["flag_servicio"];
            $text_envio_cliente_sistema = "";
            if ($es_servicio == 0) {
                $saldo_pendiente = $saldo_pendiente + $envio_cliente;
                $text_envio_cliente_sistema = key_exists_bi($costo_envio_sistema,
                    "text_envio", "cliente");
            }


            $url_request = _text("https://enidservices.com/", _web, "/");
            $url_pago_oxxo = _text(
                $url_request,
                "orden_pago_oxxo/?q=",
                $saldo_pendiente,
                "&q2=",
                $id_recibo,
                "&q3=",
                $id_usuario
            );

            $url_pago_paypal = "https://www.paypal.me/eniservice/" . $saldo_pendiente;
            $config_log = [
                'src' => _text_("https://enidservices.com/", _web, "/img_tema/enid_service_logo.jpg"),
                'width' => '100',
            ];
            $img_oxxo = _text("https://enidservices.com/", _web, "/img_tema/pago-oxxo.jpeg");
            $img_paypal = _text("https://enidservices.com/", _web, "/img_tema/explicacion-pago-en-linea.png");
            $url_seguimiento_pago = $url_request . "pedidos/?seguimiento=$id_recibo&notificar=1";


            $r[] = saludo($cliente, $config_log, $id_recibo);

            $r[] = text_saldo_pendiente(
                $resumen_pedido,
                $num_ciclos_contratados,
                $es_servicio,
                $id_ciclo_facturacion,
                $text_envio_cliente_sistema,
                $fecha_registro,
                $fecha_vencimiento,
                $monto_a_pagar,
                $saldo_pendiente
            );

            $r[] = text_forma_pago(
                $img_oxxo,
                $url_pago_oxxo,
                $url_pago_paypal,
                $img_paypal
            );

            $r[] = get_text_notificacion_pago($url_seguimiento_pago);

            $response = d($r, 'w-100');
        }

        return $response;

    }

    private function get_data_saldo($param, $productos_ordenes_compra, $response)
    {

        $response += [
            "id_recibo" => $param["id_orden_compra"],
            "id_usuario_venta" => pr($productos_ordenes_compra, "id_usuario_venta"),
            "informacion_envio" => [],

        ];


        return $response;
    }

    function parametros_busqueda($tipo)
    {

        $params = [
            "p.id_proyecto_persona_forma_pago recibo ",
            "p.saldo_cubierto",
            "p.fecha_registro",
            "p.monto_a_pagar",
            "p.num_ciclos_contratados",
            "p.cancela_cliente",
            "p.se_cancela",
            "p.status",
            "p.fecha_contra_entrega",
            "p.tipo_entrega",
            "p.fecha_entrega",
            "p.costo_envio_cliente",
            "p.id_servicio",
            "p.fecha_cancelacion",
            "p.fecha_pago",
            "p.flag_pago_comision",
            "p.comision_venta",
            "p.id_usuario_referencia",
            "p.id_usuario_entrega",
            "p.id_usuario",
            "p.intento_reventa",
            'p.intento_recuperacion'

        ];
        $params_busqueda_recibo = [
            "id_proyecto_persona_forma_pago recibo",
            "saldo_cubierto",
            "fecha_registro",
            "monto_a_pagar",
            "num_ciclos_contratados",
            "cancela_cliente",
            "se_cancela",
            "status",
            "fecha_contra_entrega",
            "tipo_entrega",
            "fecha_entrega",
            "costo_envio_cliente",
            "id_servicio",
            "fecha_cancelacion",
            "fecha_pago",
            "flag_pago_comision",
            "comision_venta",
            "id_usuario_referencia",
            "id_usuario_entrega",
            "id_usuario",
            "intento_reventa",
            'intento_recuperacion'
        ];

        $parametros = [$params, $params_busqueda_recibo];
        return $parametros[$tipo];
    }

    private function busqueda_pedidos($param)
    {
        $response = [];
        $ids = prm_def($param, 'ids');
        if ($param["recibo"] > 0) {
            /*Busqueda por número recibo*/
            $params = $this->parametros_busqueda(1);
            $response = $this->recibo_model->q_get($params, $param["recibo"]);

        } elseif ($ids != 0) {

            $params = $this->parametros_busqueda(0);
            $response = $this->recibo_model->ids_usuarios($params, $ids);

        } else {

            $params = $this->parametros_busqueda(0);
            $response = $this->recibo_model->get_q($params, $param);
        }
        return $response;
    }

    function pedidos_GET()
    {

        $param = $this->get();
        $response = false;
        $es_usuario = ($this->id_usuario > 0 || fx($param, 'id_usuario'));

        if ($this->id_usuario > 0) {
            $param['id_usuario'] = $this->id_usuario;
        }

        if (fx($param, "fecha_inicio,fecha_termino,tipo_entrega,recibo,v,perfil") && $es_usuario) {
            $param['perfil'] = $this->app->getperfiles();
            $param['es_administrador'] = prm_def($param, 'es_admistrador');

            $response = $this->busqueda_pedidos($param);

            switch ($param["v"]) {

                case 1:

                    $response = $this->add_imgs_servicio($response);
                    $response = $this->add_comisionistas($response, $param);
                    $response = $this->add_repartidores($response, $param);
                    $response = $this->add_clientes($response, $param);
                    $session = $this->app->session();

                    $response = render_resumen_pedidos($response,
                        $this->get_estatus_enid_service($param), $param, $session);
                    break;

                case 2: /*No me elimines regresa el json puro*/ break;

                default:

                    $response = $this->add_comisionistas($response, $param);
                    $response = $this->add_repartidores($response, $param);
                    break;

            }

        }
        $this->response($response);

    }

    function ventas_periodo_ids_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $ids = prm_def($param, 'ids');
            $params = $this->parametros_busqueda(0);
            $ids = get_keys($ids);
            $fecha_inicio = $param["fecha_inicio"];
            $fecha_termino = $param["fecha_termino"];
            $response = $this->recibo_model->ids_usuarios_periodo($params, $ids, $fecha_inicio, $fecha_termino);

        }
        $this->response($response);

    }

    function ids_GET()
    {

        $param = $this->get();
        $ids = prm_def($param, 'ids');
        $ids = get_keys($ids);
        $response = $this->recibo_model->ids($ids);
        $this->response($response);

    }

    function add_repartidores($ordenes, $param)
    {
        $id_perfil = $param['perfil'];
        $es_administrador = (!in_array($id_perfil, [20, 6]));

        if ($es_administrador) {

            $ordenes = $this->append_usuarios_reparto($ordenes);

        }
        return $ordenes;

    }

    function add_clientes($ordenes)
    {


        $a = 0;
        $ids_usuarios = [];
        $usuarios = [];
        $response = [];

        foreach ($ordenes as $row) {

            $orden = $row;
            $id_usuario_cliente = $row['id_usuario'];
            $response[$a] = $orden;
            if (!in_array($id_usuario_cliente, $ids_usuarios)) {

                $ids_usuarios[] = $id_usuario_cliente;
                $usuario = $this->app->usuario($id_usuario_cliente);
                $busqueda_usuario =
                    [
                        'id_usuario' => $id_usuario_cliente,
                        'usuario_cliente' => $usuario
                    ];
                $response[$a]['usuario_cliente'] = $busqueda_usuario['usuario_cliente'];
                $usuarios[] = $busqueda_usuario;

            } else {
                $usuario = search_bi_array($usuarios, 'id_usuario', $id_usuario_cliente, 'usuario_cliente');
                $response[$a]['usuario_cliente'] = $usuario;
            }
            $a++;
        }

        return $response;


    }


    function reparto_recoleccion_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "v")) {

            $response = $this->recibo_model->reparto_recoleccion($param);
            if ($param['v'] == 1) {

                $response = $this->add_imgs_servicio($response);
                $response = cuentas_por_cobrar_reparto($response);

            }

        }

        $this->response($response);
    }


    function get_estatus_enid_service($q)
    {

        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    function fecha_entrega_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "fecha_entrega,horario_entrega,orden_compra")) {

            $fecha_contra_entrega = $param["fecha_entrega"] . " " . $param["horario_entrega"] . ":00";
            $es_contra_entrega_domicilio = prm_def($param, 'contra_entrega_domicilio');
            $tipo_entrega = prm_def($param, 'tipo_entrega');
            $ubicacion = prm_def($param, 'ubicacion');
            $id_orden_compra = $param['orden_compra'];

            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);

            foreach ($productos_orden_compra as $row) {

                $id_producto_recibo = $row["id_proyecto_persona_forma_pago"];

                $costo_envio_cliente = 0;
                if ($ubicacion < 1) {

                    $id_servicio = $this->servicio_recibo($id_producto_recibo);
                    $servicio = $this->app->servicio($id_servicio);

                    $data_servicio = [
                        0 =>
                            [
                                'flag_envio_gratis' => pr($servicio, 'flag_envio_gratis'),
                                'tipo_entrega' => pr($servicio, 'tipo_entrega')
                            ]
                    ];
                    $costos = get_costo_envio($data_servicio);
                    $costo_envio_cliente = $costos['costo_envio_cliente'];
                }

                $response = $this->recibo_model->set_fecha_contra_entrega(
                    $id_producto_recibo,
                    $fecha_contra_entrega,
                    $es_contra_entrega_domicilio,
                    $tipo_entrega,
                    $ubicacion,
                    $costo_envio_cliente
                );
            }

        }

        $this->response($response);
    }

    function costo_envio_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "recibo,costo_envio")) {

            $id_recibo = $param['recibo'];
            $costo_envio = $param['costo_envio'];
            $response = $this->recibo_model->q_up('costo_envio_cliente', $costo_envio, $id_recibo);

        }
        $this->response($response);
    }

    function recibo_por_pagar_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo,id_usuario")) {

            $response = $this->recibo_model->valida_recibo_por_pagar_usuario($param);
            $response = crea_data_deuda_pendiente($response);

        }
        $this->response($response);
    }

    function cancelar_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_recibo")) {

            $response = $this->recibo_model->cancela_orden_compra($param["id_recibo"]);

        }
        $this->response($response);

    }

    function ubicacion_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id_recibo")) {
            $id_recibo = $param['id_recibo'];
            $set = ['ubicacion' => 1, 'contra_entrega_domicilio' => 1];
            $respose = $this->recibo_model->update($set, ["id_proyecto_persona_forma_pago" => $id_recibo]);
        }
        $this->response($respose);

    }

    function deuda_cliente_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->recibo_model->get_adeudo_cliente($param);
        }
        $this->response($response);
    }

    function dia_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, 'fecha')) {
            if ($param["fecha"] == 1) {
                $param["fecha"] = date("Y-m-d");
            }
            $response = $this->recibo_model->get_dia($param);

        }
        $this->response($response);
    }

    function id_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "id")) {

            $id_recibo = $param["id"];
            $response = $this->recibo_model->q_get([], $id_recibo);
        }
        $this->response($response);
    }

    function saldo_cubierto_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "saldo_cubierto,recibo")) {
            $response = $this->set_saldo_cubierto($param);
        }
        $this->response($response);
    }

    private function set_saldo_cubierto($param)
    {

        $param["id_recibo"] = $param["recibo"];
        $pago_pendiente = $this->get_saldo_pendiente_recibo($param);

        $response = _text_(_text_pago, money($pago_pendiente));
        if ($param["saldo_cubierto"] > 0 && $param["saldo_cubierto"] >= $pago_pendiente || ($pago_pendiente - $param["saldo_cubierto"]) < 101) {

            $response = $this->recibo_model->set_status_orden($param["saldo_cubierto"], 1,
                $param["recibo"], 'fecha_pago');

        }

        return $response;
    }

    function status_PUT()
    {

        $param = $this->put();
        if (array_key_exists("cancelacion", $param)) {
            $this->response($this->set_cancelacion($param));
        }
        if (array_key_exists("es_proceso_compra",
                $param) && $param["es_proceso_compra"] == 1) {
            $this->response($this->set_default_orden($param));
        }
        $response = false;
        if (fx($param, "saldo_cubierto,orden_compra,status")) {

            $this->response($this->set_status($param));

        } else {

            $this->response($response);

        }

    }

    function set_cancelacion($param)
    {

        $response = [];

        if (fx($param, "status,tipificacion,orden_compra")) {

            $id_orden_compra = $param["orden_compra"];
            $productos_ordenes_compra = $this->app->productos_ordenes_compra($id_orden_compra);
            foreach ($productos_ordenes_compra as $row) {


                $id = $row["id_proyecto_persona_forma_pago"];
                $response = $this->recibo_model->cancela_orden(0, $param["status"], $id, 'fecha_cancelacion');
                if ($response == true) {
                    $param["recibo"] = $id;
                    $response = $this->add_tipificacion($param);
                }

            }


        }

        return $response;
    }

    private function add_tipificacion($q)
    {

        return $this->app->api("tipificacion_recibo/index", $q, "json", "POST");
    }

    function set_default_orden($param)
    {
        $response = [];

        if (fx($param, "status,recibo")) {

            $params = [
                "status" => $param["status"],
                "saldo_cubierto" => 0,
                'se_cancela' => 0,
                'cancela_cliente' => 0
            ];

            $in = ["id_proyecto_persona_forma_pago" => $param["recibo"]];
            $response = $this->recibo_model->update($params, $in);
            if ($response == true) {

                $param["tipificacion"] = 32;
                $response = $this->add_tipificacion($param);
            }
        }

        return $response;
    }

    private function set_status($param)
    {
        $id_orden_compra = $param["orden_compra"];
        $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
        $response = false;
        foreach ($productos_orden_compra as $row) {

            $id_recibo = $row["id_proyecto_persona_forma_pago"];
            $param["id_recibo"] = $id_recibo;
            $pago_pendiente = $this->get_saldo_pendiente_recibo($param);
            $response = _text_(_text_pago, money($pago_pendiente));

            $saldo_cubierto = $param["saldo_cubierto"];
            $restante = ($pago_pendiente - $param["saldo_cubierto"]);

            if ($saldo_cubierto > 0 && $saldo_cubierto >= $pago_pendiente || $restante < 101) {

                $status = $param["status"];

                $response = $this->recibo_model->notifica_entrega(
                    $saldo_cubierto, $status, $id_recibo, 'fecha_entrega');

                $this->solicita_encuenta($param["id_recibo"]);

            }

        }


        return $response;
    }

    private
    function solicita_encuenta($id_recibo)
    {

        $recibo = $this->recibo_model->q_get([
            "notificacion_encuesta",
            "id_usuario",
            "id_servicio",
        ], $id_recibo);

        if (es_data($recibo)) {
            $r = $recibo[0];
            if ($r["notificacion_encuesta"] < 1) {
                $id_usuario = $r["id_usuario"];
                $usuario = $this->app->usuario($id_usuario);
                if (es_data($usuario)) {
                    if (es_email_valido($usuario[0]["email"]) > 0) {
                        $sender = notificacion_solicitud_valoracion($usuario,
                            $r["id_servicio"]);
                        $this->app->send_email($sender, 1);
                        $this->recibo_model->q_up("notificacion_encuesta", 1, $id_recibo);
                    }
                }
            }
        }
    }

    function tipo_entrega_PUT()
    {

        $param = $this->put();
        $response = [];
        if (fx($param, "recibo,tipo_entrega")) {
            $response = $this->recibo_model->q_up("tipo_entrega", $param["tipo_entrega"],
                $param["recibo"]);
            if ($response) {
                $param["tipificacion"] = 31;
                $this->add_tipificacion($param);
            }
        }
        $this->response($response);

    }

    function notificacion_pago_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "recibo")) {
            $response = $this->recibo_model->q_up("notificacion_pago", 1,
                $param["recibo"]);
        }
        $this->response($response);
    }

    function compras_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino,tipo")) {

            $compras = $this->recibo_model->get_compras_tipo_periodo($param);
            if ($param["v"] == 1) {
                $response = get_view_compras($this->status_enid(), $compras,
                    $param["tipo"]);
            }
        }
        $this->response($response);


    }

    private
    function status_enid($q = [])
    {
        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    function solicitudes_periodo_servicio_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_servicio,tipo")) {

            $interval = "";
            switch ($param["tipo"]) {
                case 1;

                    $interval = " - 1 MONTH ";

                    break;

                case 3:
                    $interval = " - 3 MONTH ";

                    break;

                case 6:
                    $interval = " - 6 MONTH ";

                    break;

                case 12;

                    $interval = " - 1 YEAR ";

                    break;
            }

            $id_servicio = $param["id_servicio"];
            $response = [
                "solicitudes" => $this->recibo_model->get_solicitudes_periodo_servicio($id_servicio,
                    $interval),
                "entregas" => $this->recibo_model->get_solicitudes_entregadas_periodo_servicio($id_servicio,
                    $interval),
            ];

        }
        $this->response($response);
    }

    function compras_por_enviar_GET()
    {

        $this->response($this->recibo_model->get_compras_por_enviar());
    }

    function num_compras_usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $id_usuario = $param["id_usuario"];
            $usuario = $this->app->usuario($id_usuario);
            $response = 0;
            if (es_data($usuario)) {

                $email = pr($usuario, "email");
                $tel_contacto = pr($usuario, "tel_contacto");
                $q = ["id_usuario" => $id_usuario, "email" => $email, "tel_contacto" => $tel_contacto];
                $usuarios = $this->usuarios_similares($q);
                $response = 0;
                if (es_data($usuarios)) {

                    $lista = [];
                    foreach ($usuarios as $row) {

                        $lista[] = $row['idusuario'];
                    }
                    $ids = implode(",", $lista);
                    $total = $this->recibo_model->get_total_compras_usuario($ids);
                    $response = [
                        'ids' => $ids,
                        'total' => $total
                    ];
                }
            }
        }
        $this->response($response);
    }

    function recibo_por_enviar_usuario_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_recibo,id_usuario")) {

            $recibos = $this->recibo_model->valida_recibo_por_enviar_usuario($param);
            $this->response(crea_data_deuda_pendiente($recibos));
        }

        $this->response($response);

    }

    function agenda_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id", 1)) {

            $this->app->set_userdata("agenda_pedido", $param["id"]);
            $response = true;

        }
        $this->response($response);
    }

    function stags_arquetipos_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_empresa")) {

            $id_empresa = $param['id_empresa'];
            $response = $this->recibo_model->sin_tags_arquetipo($id_empresa);
        }
        $this->response($response);

    }

    function reventa_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_vendedor", 1)) {

            $id_vendedor = $param['id_vendedor'];
            $response = $this->recibo_model->reventa($id_vendedor);
        }
        $this->response($response);

    }

    function recuperacion_GET()
    {
        $param = $this->get();
        $response = false;
        if (fx($param, "id_vendedor", 1)) {

            $response = $this->recibo_model->recuperacion($param['id_vendedor']);

        }
        $this->response($response);

    }


    function reventa_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "recibo", 1)) {

            $id_recibo = $param['recibo'];
            $response = $this->recibo_model->notificacion_intento_reventa($id_recibo);

        }
        $this->response($response);

    }

    function recuperacion_PUT()
    {
        $param = $this->put();
        $response = false;
        if (fx($param, "recibo", 1)) {

            $id_recibo = $param['recibo'];
            $response = $this->recibo_model->notificacion_intento_recuperacion($id_recibo);

        }
        $this->response($response);

    }

    function efectivo_en_casa_PUT()
    {
        $param = $this->put();
        $response = false;
        if (array_key_exists('recibos', $param)) {

            $recibos = $param['recibos'];
            if (es_data($recibos)) {

                $response = $this->recibo_model->recibos_efectivo_en_casa($recibos);
            }
        }
        $this->response($response);

    }

    function proximas_reparto_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario,id_perfil,id_empresa")) {

            $dia = prm_def($param, 'dia');
            $id_usuario = $param["id_usuario"];
            $id_perfil = $param["id_perfil"];
            $id_empresa = $param['id_empresa'];
            $response = $this->recibo_model->proximas($id_empresa, $id_usuario, $id_perfil, $dia);
            $recibos = $this->horarios_contra_entrega_pedidos($response);
            $response = $this->usuarios_ventas_notificaciones($recibos['recibos']);
        }
        $this->response($response);
    }

    function franja_horaria_GET()
    {

        $param = $this->get();
        $response = false;
        $data = $this->app->get_session();
        if (fx($param, "franja_horaria,v")) {

            $id_usuario = $data['idusuario'];
            $id_perfil = $this->app->getperfiles();
            $id_empresa = $data['idempresa'];

            $franja_horaria = $param['franja_horaria'];
            $ordenes = $this->recibo_model->franja_horaria($franja_horaria, $id_usuario, $id_perfil, $id_empresa);
            $response = $this->add_imgs_servicio($ordenes);
            if ($param['v'] > 0) {
                $response = tracker_franja_horaria($response);
            }
        }
        $this->response($response);
    }

    function repartidores($id_servicio)
    {
        $servicio = $this->app->servicio($id_servicio);

        $q = [
            'requiere_auto' => pr($servicio, 'requiere_auto'),
            'moto' => pr($servicio, 'moto'),
            'bicicleta' => pr($servicio, 'bicicleta'),
            'pie' => pr($servicio, 'pie'),
        ];

        return $this->app->api("usuario_perfil/repartidores/format/json/", $q);
    }

    function usuarios_similares($q)
    {

        return $this->app->api("usuario/busqueda/format/json/", $q);

    }


    function recibos_puntos_encuentro($ids_recibos)
    {


        $response = [];
        if (es_data($ids_recibos)) {

            $q = [
                'v' => 1,
                'ids_recibos' => get_keys($ids_recibos)
            ];
            $response = $this->app->api("proyecto_persona_forma_pago_punto_encuentro/recibos/format/json/", $q);
        }
        return $response;
    }

    function recibos_domicilios($recibos)
    {

        $response = [];
        if (es_data($recibos)) {

            $q = [
                'v' => 1,
                'ids_recibos' => get_keys($recibos)
            ];
            $response = $this->app->api("proyecto_persona_forma_pago_direccion/recibos/format/json/", $q);
        }
        return $response;

    }

    function pago_recibos_comisiones_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "usuario")) {

            $usuario = $param['usuario'];
            $response = $this->recibo_model->pago_recibos_comisiones($usuario);
        }
        return $this->response($response);
    }

    function pago_recibos_comisiones_ids_PUT()
    {

        $param = $this->put();
        $ids = $param['ids'];
        $response = $this->recibo_model->pago_recibos_comisiones_ids($ids);
        return $this->response($response);
    }

    function comisiones_por_pago_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_empresa")) {

            $id_empresa = $param['id_empresa'];

            $data = $this->app->session();
            $usuarios = $this->usuarios_empresa_perfil($id_empresa, 1, $data);
            $ids_usuarios = array_column($usuarios, 'idusuario');


            $response = $this->recibo_model->comisiones_por_pago($id_empresa, $ids_usuarios);
            $response = $this->agrega_usuario_compra($response);
        }

        $this->response($response);
    }

    private function usuarios_empresa_perfil($id_empresa, $grupo, $data)
    {
        $q = [
            'id_empresa' => $id_empresa,
            'grupo' => $grupo,
            'data' => $data
        ];

        return $this->app->api("usuario/empresa_perfil/format/json/", $q);

    }

    private function agrega_usuario_compra($ordenes)
    {

        $clientes = [];
        if (es_data($ordenes)) {

            $ids_usuarios = [];
            foreach ($ordenes as $row) {

                $ids_usuarios[] = $row['id_usuario'];
            }

            $clientes = $this->usuarios_q($ids_usuarios);

        }
        return [
            'ordenes' => $ordenes,
            'clientes' => $clientes
        ];

    }

    private function servicio_recibo($id_recibo)
    {

        $recibo = $this->recibo_model->q_get(["id_servicio"], $id_recibo);
        return pr($recibo, "id_servicio", 0);

    }

    function top_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino,v")) {


            $fecha_inicio = $param['fecha_inicio'];
            $fecha_termino = $param['fecha_termino'];

            $top = $this->recibo_model->top(
                $fecha_inicio,
                $fecha_termino
            );

            $top_cancelaciones = $this->recibo_model->top_cancelaciones(
                $fecha_inicio,
                $fecha_termino
            );


            $fechas = $this->recibo_model->top_fecha(
                $fecha_inicio,
                $fecha_termino
            );

            $fechas_cancelaciones = $this->recibo_model->top_fecha_cancelaciones(
                $fecha_inicio,
                $fecha_termino
            );

            $top_horas = $this->recibo_model->top_horas(
                $fecha_inicio,
                $fecha_termino
            );
            $ventas_hoy = $this->recibo_model->ventas_menos_tiempo();
            $ventas_menos_7 = $this->recibo_model->ventas_menos_tiempo('-7');


            if ($param["v"] == 1) {

                $top = $this->app->imgs_productos(0, 1, 1, 1, $top);
                $response = top($top, $top_horas, $top_cancelaciones, $fechas, $fechas_cancelaciones, $ventas_hoy, $ventas_menos_7);

            }
        }
        $this->response($response);

    }


}

