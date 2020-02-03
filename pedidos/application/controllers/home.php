<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
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
        $this->app->acceso();

        if (prm_def($param, "seguimiento") > 0 && ctype_digit($param["seguimiento"])) {

            $this->vista_seguimiento($param, $data);

        } else {


            $fn = (prm_def($param,
                    "costos_operacion") > 0 && ctype_digit($param["costos_operacion"])) ?
                $this->carga_vista_costos_operacion($param, $data) :
                $this->seguimiento_pedido($param, $data);

        }
    }

    private function vista_seguimiento($param, $data)
    {


        $data = $this->app->cssJs($data, "pedidos_seguimiento");
        $id_recibo = $this->input->get("seguimiento");
        $recibo = $this->get_recibo($id_recibo, 1);

        $data +=
            [
                "servicio" => $this->app->servicio(pr($recibo, "id_servicio")),
            ];


        $drecibo = $recibo[0];
        $id_usuario_compra = $drecibo["id_usuario"];
        $id_usuario_venta = $drecibo["id_usuario_venta"];
        $es_domicilio = prm_def($param, "domicilio");

        $acceso = ($id_usuario_compra == $data["id_usuario"] ||
            $id_usuario_venta == $data["id_usuario"]);

        if (es_data($recibo) && $data["in_session"] > 0 && $data["id_usuario"] > 0 && $acceso) {


            $data["es_vendedor"] = ($id_usuario_venta == $data["id_usuario"]) ? 1 : 0;

            $data += [
                "domicilio" => $this->get_domicilio_entrega($id_recibo, $recibo),
                "recibo" => $recibo,

            ];


            $fn = ($es_domicilio) ? $this->domicilios($param,
                $data) : $this->load_view_seguimiento($data,
                $param, $recibo, $id_recibo);


        } else {

            redirect("../../area_cliente");
        }

    }

    private function get_recibo($id_recibo, $add_img = 0)
    {

        $q["id"] = $id_recibo;

        $response = $this->app->api("recibo/id/format/json/", $q);

        if (es_data($response) && $add_img > 0) {

            $response[0]["url_img_servicio"] = $this->app->imgs_productos($response[0]["id_servicio"],
                1, 1, 1);

        }

        return $response;
    }

    private function get_domicilio_entrega($id_recibo, $recibo)
    {

        $response = [];

        if (es_data($recibo)) {

            $recibo = $recibo[0];
            $tipo_entrega = $recibo["tipo_entrega"];
            $response["tipo_entrega"] = $tipo_entrega;

            switch ($tipo_entrega) {

                case 1: //Puntos encuentro
                    $domicilio = $this->get_punto_encuentro($id_recibo);
                    break;

                case 2: //Mensajería
                    $domicilio = $this->get_domicilio_recibo($id_recibo);
                    break;
                default:
                    $domicilio = [];

            }
            $response["domicilio"] = $domicilio;

        }

        return $response;

    }

    private function get_punto_encuentro($id_recibo)
    {

        return $this->app->api("proyecto_persona_forma_pago_punto_encuentro/complete/format/json/",
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

    private function domicilios($param, $data)
    {


        $id_recibo = pr($data['recibo'], 'id_proyecto_persona_forma_pago');
        $domicilio_entrega = $this->get_domicilio_recibo($id_recibo);
        $punto_entrega = $this->get_punto_encuentro($id_recibo);

        $asignacion = prm_def($param, 'asignacion');
        $tiene_domicilio = es_data($domicilio_entrega);
//        $tiene_punto_entrega = es_data($punto_entrega);

        if (!$tiene_domicilio || $asignacion) {
//
//            if(!$tiene_domicilio &&  $tiene_punto_entrega){
//
//                redirect(path_enid('area_cliente_compras', $id_recibo, 0, 1));
//            }

            $id_usuario = $data["id_usuario"];
            $domicilios = $this->get_direcciones_usuario($id_usuario);

            $data += [
                "lista_direcciones" => $domicilios,
                "puntos_encuentro" => $this->get_puntos_encuentro($id_usuario),
                "num_domicilios" => count($domicilios),
                "domicilio_entrega" => $domicilio_entrega,
                "punto_entrega" => $punto_entrega,

            ];

            $this->breadcrumbs->push('Orden de compra', path_enid('area_cliente_compras', $id_recibo));
            $this->breadcrumbs->push('Domicilio de entrega', '/');
            $data['breadcrumbs'] = $this->breadcrumbs->show();

            $this->app->pagina(
                $this->app->cssJs($data, "pedidos_domicilios_pedidos"),
                render_domicilio($data), 1
            );
        } else {

            redirect(path_enid('area_cliente_compras', $id_recibo, 0, 1));
        }

    }

    private function get_direcciones_usuario($id_usuario)
    {

        return $this->app->api("usuario_direccion/all/format/json/",
            ["id_usuario" => $id_usuario]);
    }

    private function get_puntos_encuentro($id_usuario)
    {

        return $this->app->api("usuario_punto_encuentro/usuario/format/json/",
            ["id_usuario" => $id_usuario]);
    }

    private function load_view_seguimiento($data, $param, $recibo, $id_recibo)
    {

        $notificacion_pago = (prm_def($param, "notificar") > 0) ? 1 : 0;

        $data += [
            "notificacion_pago" => ($recibo[0]["notificacion_pago"] > 0) ? 0 : $notificacion_pago,
            "orden" => $id_recibo,
            "status_ventas" => $this->get_estatus_enid_service(),
            "evaluacion" => 1,
            "tipificaciones" => $this->get_tipificaciones($id_recibo),
            "id_servicio" => pr($recibo, "id_servicio"),
        ];

        if ($recibo[0]["saldo_cubierto"] > 0 && $recibo[0]["se_cancela"] == 0 && $data["es_vendedor"] < 1) {

            $data["evaluacion"] = $this->verifica_evaluacion($recibo[0]["id_usuario"],
                $recibo[0]["id_servicio"]);

        }

        $this->breadcrumbs->push('Orden de compra', path_enid('area_cliente_compras', $id_recibo));
        $this->breadcrumbs->push('Seguimiento', '/');
        $data['breadcrumbs'] = $this->breadcrumbs->show();

        $this->app->pagina($data, render_seguimiento($data), 1);
    }

    private function get_estatus_enid_service($q = [])
    {

        return $this->app->api("status_enid_service/index/format/json/", $q);
    }

    private function get_tipificaciones($id_recibo)
    {


        return $this->app->api("tipificacion_recibo/recibo/format/json/",
            ["recibo" => $id_recibo]);
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

        $id_recibo = $param['costos_operacion'];
        $recibo = $this->get_recibo($id_recibo);
        $id_usuario_venta = pr($recibo, 'id_usuario_venta');
        propietario($this->id_usuario, $id_usuario_venta, path_enid('_area_cliente'));

        $data = $this->app->cssJs($data, "pedidos");
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
            $tb,
            $totales,
            $this->get_tipo_costo_operacion(),
            $param["costos_operacion"],
            $path,
            $costos_operacion,
            $recibo
        );
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


        $data = $this->app->cssJs($data, "pedidos");

        $data += [
            "tipos_entregas" => $this->get_tipos_entregas([]),
            "status_ventas" => $this->get_estatus_enid_service(),
        ];


        $fn = (prm_def($param, "recibo") < 1) ?
            $this->app->pagina($data, get_form_busqueda_pedidos($data, $param), 1) :
            $this->load_detalle_pedido($param, $data);

    }

    private function get_tipos_entregas($q)
    {

        return $this->app->api("tipo_entrega/index/format/json/", $q);
    }

    private function load_detalle_pedido($param, $data)
    {

        $fn = (array_key_exists("recibo",
                $param) && ctype_digit($param["recibo"])) ? $this->carga_detalle_pedido($param,
            $data) : redirect("../../?q=");

    }

    private function carga_detalle_pedido($param, $data)
    {

        $id_perfil = $data['id_perfil'];
        $id_recibo = $param["recibo"];
        $recibo = $this->get_recibo($id_recibo, 1);
        $id_usuario_venta = pr($recibo, 'id_usuario_venta');
        propietario(
            $this->id_usuario, $id_usuario_venta, path_enid('_area_cliente'));

        if (es_data($recibo) > 0) {

            $data += [

                "orden" => $id_recibo,
                "recibo" => $recibo,

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

                $this->pedido($data, $recibo, $id_perfil);
            }


        } else {

            $this->app->pagina($data, get_error_message(), 1);
        }

    }

    private function pedido($data, $recibo, $id_perfil)
    {
        $id_recibo = pr($recibo, 'id_proyecto_persona_forma_pago');
        $id_usuario = pr($recibo, "id_usuario");
        $tipo_tag_arqquetipo = ($id_perfil == 3) ? $this->get_tipo_tag_arqquetipo() : [];
        $tag_arquetipo = ($id_perfil == 3) ? $this->tag_arquetipo($id_usuario) : [];
        $servicio = $this->app->servicio(pr($recibo, "id_servicio"));
        $num_compras = $this->get_num_compras($id_usuario);
        $cupon = $this->cupon($id_recibo, $servicio, $num_compras);


        $data += [
            "domicilio" => $this->get_domicilio_entrega($id_recibo, $recibo),
            "usuario" => $this->get_usuario($id_usuario),
            "status_ventas" => $this->get_estatus_enid_service(),
            "tipificaciones" => $this->get_tipificaciones($id_recibo),
            "comentarios" => $this->get_recibo_comentarios($id_recibo),
            "recordatorios" => $this->get_recordatorios($id_recibo),
            "id_recibo" => $id_recibo,
            "tipo_recortario" => $this->get_tipo_recordatorio(),
            "num_compras" => $num_compras,
            "servicio" => $servicio,
            "cupon" => $cupon,
            "tipo_tag_arquetipo" => $tipo_tag_arqquetipo,
            "tag_arquetipo" => $tag_arquetipo,
            "negocios" => $this->tipos_negocio(),
            "usuario_tipo_negocio" => $this->usuario_tipo_negocio($id_usuario)

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
            ["id_usuario" => $id_usuario]);

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

    /*solo se genera cupon en primer compra*/

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
}
