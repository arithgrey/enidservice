<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("pedidos");
        $this->load->library("table");
        $this->load->library('breadcrumbs');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index()
    {

        $param = $this->input->get();
        $data = $this->app->session();

        $seguimiento = prm_def($param, "seguimiento");
        $es_seguimiento = ($seguimiento > 0);

        if ($es_seguimiento && ctype_digit($seguimiento)) {


            $this->vista_seguimiento($param, $data);

        } else {

            $this->valida_seguimiento($param, $data);

        }
    }

    private function valida_seguimiento($param, $data)
    {

        $this->app->acceso();
        $costos_operacion = prm_def($param, "costos_operacion");
        $es_costo_operacion = ($costos_operacion > 0);

        if ($es_costo_operacion && ctype_digit($costos_operacion)) {
            $this->carga_vista_costos_operacion($param, $data);
        } else {
            $this->seguimiento_pedido($param, $data);
        }

    }

    private function vista_seguimiento($param, $data)
    {
        $data = $this->app->cssJs($data, "pedidos_seguimiento");
        $id_orden_compra = $this->input->get("seguimiento");
        $data["id_orden_compra"] = $id_orden_compra;

        $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
        $id_usuario_referencia = pr($productos_orden_compra, 'id_usuario_referencia');
        $data += [
            "domicilios" => $this->app->domicilios_orden_compra($productos_orden_compra),
            "productos_orden_compra" => $productos_orden_compra,
            "id_usuario_referencia" => $id_usuario_referencia
        ];


        $data["es_vendedor"] = ($id_usuario_referencia == $data["id_usuario"]);

        $es_domicilio = prm_def($param, "domicilio");

        if ($es_domicilio) {

            $this->view_domicilios($data, $param);

        } else {

            $this->load_view_seguimiento($data, $param);
        }


    }

    private function view_domicilios($data, $param)
    {

        $productos_ordenes_compra = $data["productos_orden_compra"];
        $id_usuario_compra = pr($productos_ordenes_compra, "id_usuario");
        $id_usuario_venta = pr($productos_ordenes_compra, "id_usuario_venta");
        $es_session = ($data["in_session"] > 0);
        $id_usuario_referencia = pr($productos_ordenes_compra, 'id_usuario_referencia');
        $es_usuario_compra = ($this->id_usuario == $id_usuario_compra);

        if ($es_session && $data["id_usuario"] > 0) {

            $path = path_enid('_area_cliente');

            $es_propietario = propietario(
                $data,
                $this->id_usuario,
                $id_usuario_venta,
                $id_usuario_referencia,
                $path
            );

            $tiene_acceso = ($es_usuario_compra || $es_propietario);

            if ($tiene_acceso) {
                $this->domicilios($param, $data);
            }

        }
    }

    private function get_recibo($id_recibo, $add_img = 0)
    {

        $q["id"] = $id_recibo;
        $response = $this->app->api("recibo/id/format/json/", $q);

        if (es_data($response) && $add_img > 0) {

            $a = 0;
            foreach ($response as $row) {
                $response[$a]["url_img_servicio"] =
                    $this->app->imgs_productos(
                        $response[$a]["id_servicio"], 1, 1, 1);
                $a++;
            }
        }

        return $response;
    }

    private function imagenes_recibos($recibos)
    {

        $a = 0;
        foreach ($recibos as $row) {
            $recibos[$a]["url_img_servicio"] =
                $this->app->imgs_productos($recibos[$a]["id_servicio"], 1, 1, 1);
            $a++;
        }

        return $recibos;
    }

    private function domicilios($param, $data)
    {

        $id_orden_compra = $param["seguimiento"];
        $domicilio_entrega = $data["domicilios"];
        $asignacion = prm_def($param, 'asignacion');
        $tiene_domicilio = es_data($domicilio_entrega);
        $lista = prm_def($param, 'frecuentes');
        $asignacion_horario_entrega = prm_def($param, 'asignacion_horario_entrega');
        $productos_orden_compra = $data["productos_orden_compra"];


        if (!$tiene_domicilio || $asignacion || $lista || $asignacion_horario_entrega) {

            $id_usuario = $data["id_usuario"];
            $domicilios = $this->get_direcciones_usuario($id_usuario);
            $ubicaciones = $this->get_ubicaciones_usuario($id_usuario);
            $domicilios_orden_compra = $this->app->domicilios_orden_compra($productos_orden_compra);


            $data += [
                "domicilios_orden_compra" => $domicilios_orden_compra,
                "lista_direcciones" => $domicilios,
                "puntos_encuentro_usuario" => $this->get_puntos_encuentro_usuario($id_usuario),
                "ubicaciones" => $ubicaciones,
                "num_domicilios" => count($domicilios),
                "domicilio_entrega" => $domicilio_entrega,
                "asignacion_horario_entrega" => prm_def($param, 'asignacion_horario_entrega')

            ];

            $this->breadcrumbs->push('Orden de compra', path_enid('area_cliente_compras', $id_orden_compra));
            $this->breadcrumbs->push('Domicilio de entrega', '/');
            $data['breadcrumbs'] = $this->breadcrumbs->show();


            $contenido = render_domicilio($data);
            $this->app->pagina(
                $this->app->cssJs($data, "pedidos_domicilios_pedidos"),
                $contenido, 1
            );

        } else {

            redirect(path_enid('area_cliente_compras', $id_orden_compra, 0, 1));
        }

    }

    private function get_ubicaciones_usuario($id_usuario)
    {

        return $this->app->api("ubicacion/usuario/format/json/",
            ["id_usuario" => $id_usuario]);
    }

    private function get_direcciones_usuario($id_usuario)
    {

        return $this->app->api("usuario_direccion/all/format/json/",
            ["id_usuario" => $id_usuario]);
    }

    private function get_puntos_encuentro_usuario($id_usuario)
    {

        return $this->app->api(
            "usuario_punto_encuentro/usuario/format/json/",
            ["id_usuario" => $id_usuario]
        );
    }

    private function load_view_seguimiento($data, $param)
    {

        $id_orden_pago = $data["id_orden_compra"];
        $data['url_img_post'] = path_enid('rastreo_pedido', 0, 1);
        $notificacion_pago = (prm_def($param, "notificar") > 0) ? 1 : 0;

        $productos_orden_compra = $data["productos_orden_compra"];
        $es_administrador = es_administrador($data);

        $notificacion = pr($productos_orden_compra, "notificacion_pago");
        $id_servicio = pr($productos_orden_compra, "id_servicio");
        $id_usuario_compra = pr($productos_orden_compra, "id_usuario");


        $data += [
            "notificacion_pago" => ($notificacion > 0) ? 0 : $notificacion_pago,
            "orden" => $id_orden_pago,
            "status_ventas" => $this->get_estatus_enid_service(),
            "evaluacion" => 1,
            "tipificaciones" => $this->get_tipificaciones($productos_orden_compra),
            "id_servicio" => $id_servicio,
            "es_administrador" => $es_administrador
        ];

        $es_lista_negra = $this->es_lista_negra($id_usuario_compra);
        $usuario_compra = $this->get_usuario($id_usuario_compra);
        $usuario_lista_negra = $this->busqueda_lista_negra($usuario_compra);

        $data["es_lista_negra"] = $es_lista_negra;
        $data["usuario_lista_negra"] = $usuario_lista_negra;
        $data = $this->agrega_usuario_referencia_tracker($data, $es_administrador);
        $data = $this->agrega_usuario_entrega_tracker($data, $es_administrador);

        /*Se debe pasar al método */
        $es_orden_pagada = es_orden_pagada($data);
        $es_vendedor = $data["es_vendedor"];


        $data["evaluacion"] = $this->evalua_compra($productos_orden_compra, $es_orden_pagada, $es_vendedor);


        $breadcrumbs = [];
        if ($data['in_session']) {

            $path = path_enid('area_cliente_compras', $id_orden_pago);
            $this->breadcrumbs->push('Orden de compra', $path);
            $this->breadcrumbs->push('Seguimiento', '/');
            $breadcrumbs[] = $this->breadcrumbs->show();
        }
        $data['breadcrumbs'] = append($breadcrumbs);
        $data['usuario_cliente'] = $usuario_compra;


        $data = texto_pre_pedido($productos_orden_compra, $data);
        $params = $this->input->get();
        $this->app->pagina($data, render_seguimiento($data, $params), 1);


    }

    private function evalua_compra($productos_orden_compra, $es_orden_pagada, $es_vendedor)
    {

        $response = true;
        if ($es_orden_pagada && $es_vendedor < 1) {
            foreach ($productos_orden_compra as $row) {

                $id_usuario_compra = $row["id_usuario"];
                $id_servicio = $row["id_servicio"];

                $response = $this->verifica_evaluacion($id_usuario_compra, $id_servicio);
            }
        }

        return $response;
    }

    private function agrega_usuario_referencia_tracker($data, $es_administrador)
    {
        $productos_orden_compra = $data["productos_orden_compra"];

        if ($es_administrador && es_data($productos_orden_compra)) {


            $id_usuario_referencia = pr($productos_orden_compra, 'id_usuario_referencia');
            $data['vendedor'] = $this->app->usuario($id_usuario_referencia);
        }
        return $data;
    }

    private function agrega_usuario_entrega_tracker($data, $es_administrador)
    {
        $productos_orden_compra = $data["productos_orden_compra"];
        if ($es_administrador && es_data($productos_orden_compra)) {

            $id_usuario_entrega = pr($productos_orden_compra, 'id_usuario_entrega');
            $data['usuario_entrega'] = $this->app->usuario($id_usuario_entrega);
        }
        return $data;
    }


    private function get_estatus_enid_service($q = [])
    {

        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    private function get_tipificaciones($productos_orden_compra)
    {

        $response = [];
        foreach ($productos_orden_compra as $row) {

            $id_proyecto_persona_forma_pago = $row["id_proyecto_persona_forma_pago"];

            $response[] =
                $this->app->api("tipificacion_recibo/recibo/format/json/",
                    [
                        "recibo" => $id_proyecto_persona_forma_pago
                    ]
                );
        }
        return $response;


    }

    private function verifica_evaluacion($id_usuario, $id_servicio)
    {

        $q = [
            "id_usuario" => $id_usuario,
            "id_servicio" => $id_servicio,
        ];

        return $this->app->api("valoracion/num/format/json/", $q);

    }

    function carga_vista_costos_operacion($param, $data)
    {

        $id_orden_compra = $param['costos_operacion'];
        $productos_ordenes_compra = $this->app->productos_ordenes_compra($id_orden_compra);

        foreach ($productos_ordenes_compra as $row) {

            $id_recibo = $row["id_proyecto_persona_forma_pago"];
            $recibo = $this->get_recibo($id_recibo);
            $id_usuario_venta = pr($recibo, 'id_usuario_venta');
            $id_usuario_referencia = pr($recibo, 'id_usuario_referencia');
            propietario($data, $this->id_usuario, $id_usuario_venta, $id_usuario_referencia,
                path_enid('_area_cliente'));

            $data = $this->app->cssJs($data, "pedidos_costos_operacion");
            $costos_operacion = $this->get_costo_operacion($param["costos_operacion"]);
            $this->table->set_heading([
                _titulo('MONTO', 4),
                _titulo('CONCEPTO', 4),
                _titulo('REGISTO', 4),
                _titulo('')
            ]);
            $total = 0;
            foreach ($costos_operacion as $row) {

                $total = $total + $row["monto"];
                $id = $row["id"];
                $icon = icon("fa fa-times ",
                    ["onclick" => "confirma_eliminar_concepto('{$id}')"]);
                $this->table->add_row(array(
                    money($row["monto"]),
                    $row["tipo"],
                    format_fecha($row["fecha_registro"], 1),
                    $icon,
                ));
            }


            $id_usuario = pr($recibo, 'id_usuario');

            $id_usuario_referencia = pr($recibo, 'id_usuario_referencia');
            $usuario_comision = $this->get_usuario($id_usuario_referencia);
            $usuario_compra = $this->get_usuario($id_usuario);


            $tb = $this->table->generate();
            $utilidad = $param["saldado"] - $total;

            $seccion[] = d(flex("TOTAL EN GASTOS: ", money($total), _between));
            $seccion[] = d(flex("SALDADO: ", money($param["saldado"]), _between));
            $seccion[] = d(flex("utilidad:", money($utilidad), _between, _t2, _t2));
            $totales = d($seccion, 'd-flex flex-column');
            $recibo = $this->get_ppfp($param["costos_operacion"]);
            $id_servicio = (es_data($recibo)) ? pr($recibo, "id_servicio") : 0;
            $path = $this->app->imgs_productos($id_servicio, 1, 1, 1);

            $response = get_format_costo_operacion(
                $data,
                $tb,
                $totales,
                $this->get_tipo_costo_operacion(),
                $param["costos_operacion"],
                $path,
                $costos_operacion,
                $recibo, 1, $usuario_comision, $usuario_compra);

        }

        $this->app->pagina($data, $response, 1);

    }

    private function get_costo_operacion($id_recibo)
    {

        return $this->app->api("costo_operacion/recibo/format/json/",
            ["recibo" => $id_recibo]);

    }

    private function get_ppfp($id_recibo)
    {


        return $this->app->api("recibo/id/format/json/", ["id" => $id_recibo]);

    }

    private function get_tipo_costo_operacion()
    {

        return $this->app->api("tipo_costo/index/format/json/", ["x" => 1]);

    }

    function seguimiento_pedido($param, $data)
    {

        $id_orden_compra = prm_def($param, "recibo");
        $es_busqueda = ($id_orden_compra < 1);

        $css = ($es_busqueda) ? "pedidos_busqueda" : "pedidos";
        $data = $this->app->cssJs($data, $css);

        $data +=
            [
                "tipos_entregas" => $this->get_tipos_entregas([]),
                "status_ventas" => $this->get_estatus_enid_service(),
            ];


        if ($es_busqueda < 1) {
            $this->detalle_pedido($param, $data);
        } else {
            $this->busqueda_pedidos($param, $data);
        }

    }


    private function busqueda_pedidos($param, $data)
    {
        $es_administrador = in_array($data['id_perfil'], [3]);
        $comisionistas = [];

        if ($es_administrador) {
            $comisionistas = $this->usuarios_comisionistas();
        }
        $data['comisionistas'] = $comisionistas;
        $ordenes = $this->comisiones_por_pago($data);
        $data['comisiones_por_pago'] = $this->app->add_imgs_servicio($ordenes['ordenes']);
        $data['clientes_por_pago'] = $ordenes['clientes'];
        $this->app->pagina($data, get_form_busqueda_pedidos($data, $param), 1);

    }

    private function comisiones_por_pago($data)
    {

        $q = ['id_empresa' => $data['id_empresa']];
        return $this->app->api("recibo/comisiones_por_pago/format/json/", $q);
    }

    private function usuarios_comisionistas()
    {

        return $this->app->api("usuario_perfil/comisionistas/format/json/");
    }

    private function get_tipos_entregas($q)
    {

        return $this->app->api("tipo_entrega/index/format/json/", $q);
    }

    private function detalle_pedido($param, $data)
    {

        $id_recibo = prm_def($param, "recibo");
        $es_recibo = ($id_recibo > 0);
        if ($es_recibo) {

            $this->carga_detalle_pedido($param, $data);

        } else {

//            redirect("../../?q=");
        }


    }

//    private function productos($producto_orden_compra)
//    {
//
//        $response = [];
//        if (es_data($producto_orden_compra)) {
//
//            $ids = array_column($producto_orden_compra, "id_proyecto_persona_forma_pago");
//            $response = $this->app->api("recibo/ids/format/json/", ["ids" => $ids]);
//        }
//        return $response;
//
//    }


    private function carga_detalle_pedido($param, $data)
    {

        $id_perfil = $data['id_perfil'];
        $id_orden_compra = $param["recibo"];

        $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
        $productos_orden_compra = $this->imagenes_recibos($productos_orden_compra);

//        $id_usuario_venta = pr($recibo, 'id_usuario_venta');
//        $id_usuario_referencia = pr($recibo, 'id_usuario_referencia');

//        propietario($data,
//            $this->id_usuario, $id_usuario_venta, $id_usuario_referencia,
//            path_enid('_area_cliente'));

        if (es_data($productos_orden_compra) > 0) {

            $data += [
                "orden" => $id_orden_compra,
                "productos_orden_compra" => $productos_orden_compra,
            ];

            if (prm_def($param, "fecha_entrega") > 0) {


                $form = get_form_fecha_entrega($data);
                $this->app->pagina($data, $form, 1);


            } elseif (prm_def($param, "recordatorio") > 0) {


                $id_usuario = pr($data["recibo"], "id_usuario");
                if ($id_usuario > 0) {
                    $data["usuario"] = $this->app->usuario($id_usuario);
                }
                $form = form_fecha_recordatorio($data, $this->get_tipo_recordatorio());
                $this->app->pagina($data, $form, 1);

            } else {

                $this->pedido($data);
            }


        } else {

            $this->app->pagina($data, get_error_message(), 1);
        }

    }

    private function pedido($data)
    {

        $id_orden_compra = $data["orden"];
        $id_perfil = $data["id_perfil"];
        $productos_orden_compra = $data["productos_orden_compra"];
        $es_administrador = es_administrador($data);
        $id_usuario = pr($productos_orden_compra, "id_usuario");
        $tipo_tag_arqquetipo = ($es_administrador) ? $this->get_tipo_tag_arqquetipo() : [];
        $tag_arquetipo = ($es_administrador) ? $this->tag_arquetipo($id_usuario) : [];
        $id_servicio = pr($productos_orden_compra, "id_servicio");
        $servicio = $this->app->servicio($id_servicio);
        $compras_en_tiempo = $this->get_num_compras($id_usuario);
        $ids_compras = prm_def($compras_en_tiempo, 'ids');
        $resumen_compras = prm_def($compras_en_tiempo, 'total');
        $num_compras = prm_def($resumen_compras, 'compras');
        $solicitudes = prm_def($resumen_compras, 'solicitudes');

//        $cupon = ($data['id_perfil'] != 6 && $es_administrador) ? $this->cupon($id_recibo, $servicio, $num_compras) : [];
        $cupon = [];

        $id_usuario_referencia = pr($productos_orden_compra, 'id_usuario_referencia');
        $es_venta_comisionada = ($id_usuario != $id_usuario_referencia && $this->id_usuario != $id_usuario_referencia);
        $usuario_comision = ($es_venta_comisionada) ? $this->get_usuario($id_usuario_referencia) : [];
        $es_lista_negra = $this->es_lista_negra($id_usuario);

        $id_usuario_entrega = pr($productos_orden_compra, 'id_usuario_entrega');

        $id_repartidor = ($es_administrador && $id_usuario_entrega > 0) ? $id_usuario_entrega : $data['id_usuario'];
        $repartidor = $this->get_usuario($id_repartidor);
        $usuario_compra = $this->get_usuario($id_usuario);
        $usuario_lista_negra = $this->busqueda_lista_negra($usuario_compra);
        $data += [
            "domicilios" => $this->app->domicilios_orden_compra($productos_orden_compra),
            "usuario" => $usuario_compra,
            "status_ventas" => $this->get_estatus_enid_service(),
            "tipificaciones" => $this->get_tipificaciones($productos_orden_compra),
            "comentarios" => $this->get_recibo_comentarios($id_orden_compra),
            "recordatorios" => $this->get_recordatorios($id_orden_compra),
            "id_recibo" => $id_orden_compra,
            "tipo_recortario" => $this->get_tipo_recordatorio(),
            "num_compras" => $num_compras,
            "servicio" => $servicio,
            "cupon" => $cupon,
            "tipo_tag_arquetipo" => $tipo_tag_arqquetipo,
            "tag_arquetipo" => $tag_arquetipo,
            "negocios" => $this->tipos_negocio(),
            "usuario_tipo_negocio" => $this->usuario_tipo_negocio($id_usuario),
            "es_vendedor" => ($this->id_usuario == $id_usuario_referencia && $id_perfil == 6),
            "id_usuaario_actual" => $this->id_usuario,
            "es_venta_comisionada" => $es_venta_comisionada,
            "usuario_comision" => $usuario_comision,
            "es_lista_negra" => $es_lista_negra,
            "repartidor" => $repartidor,
            "usuario_lista_negra" => $usuario_lista_negra,
            "id_usuario_referencia" => $id_usuario_referencia,
            "solicitudes_pasadas_usuario" => $solicitudes,
            "ids_compras" => $ids_compras
        ];


        $this->app->pagina($data, render_pendidos($data), 1);
    }

    private function get_tipo_recordatorio()
    {

        return $this->app->api("tipo_recordatorio/index/format/json/");
    }

    private function get_num_compras($id_usuario)
    {

        return $this->app->api("recibo/num_compras_usuario/format/json/",
            [
                "id_usuario" => $id_usuario
            ]
        );

    }

    private function cupon($id_recibo, $servicio, $num_compras)
    {

        $response = [];
        $cupon_primer_compra = pr($servicio, 'cupon_primer_compra');
        if ($num_compras == 1 && $cupon_primer_compra > 0) {

            $q = [
                'id_recibo' => $id_recibo,
                'valor' => $cupon_primer_compra,
                'v' => 2,
            ];

            $response = $this->app->api("cupon/index/format/json/", $q, 'json', 'POST');

        }

        return $response;

    }

    private function get_usuario($id_usuario)
    {
        return $this->app->usuario($id_usuario);
    }

    private function get_recibo_comentarios($id_recibo)
    {

        return $this->app->api("recibo_comentario/index/format/json/",
            ["id_recibo" => $id_recibo]);

    }

    /*Solo se genera cupon en primer compra*/
    private function get_recordatorios($id_recibo)
    {

        return $this->app->api(
            "recordatorio/index/format/json/", ["id_recibo" => $id_recibo]);
    }

    private function get_tipo_tag_arqquetipo()
    {
        return $this->app->api("tipo_tag_arquetipo/index/format/json/");
    }

    private function tag_arquetipo($id_usuario)
    {
        $q = ['usuario' => $id_usuario];
        return $this->app->api("tag_arquetipo/index/format/json/", $q);
    }

    private function tipos_negocio()
    {

        return $this->app->api("tipo_negocio/index/format/json/");
    }

    private function usuario_tipo_negocio($id_usuario)
    {

        return $this->app->api("usuario_tipo_negocio/usuario/format/json/", ['id_usuario' => $id_usuario]);
    }

    private function es_lista_negra($id_usuario)
    {

        return $this->app->api("lista_negra/index/format/json/", ['id_usuario' => $id_usuario]);
    }

    private function cuentas_sin_recoleccion($q)
    {

        $q['v'] = 1;
        return $this->app->api("recibo/reparto_recoleccion/format/json/", $q);

    }

    private function busqueda_lista_negra($usuario_compra)
    {

        $response = [];
        if (es_data($usuario_compra)) {

            $q = [
                'idusuario' => pr($usuario_compra, 'idusuario'),
                'email' => pr($usuario_compra, 'email'),
                'tel_contacto' => pr($usuario_compra, 'tel_contacto'),
                'tel_contacto_alterno' => pr($usuario_compra, 'tel_contacto_alterno')
            ];
            $response = $this->app->api("usuario/lista_negra/format/json/", $q);
        }
        return $response;

    }


}
