<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("area");
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $param = $this->input->get();
        if (prm_def($param, "transfer") < 1) {


            $this->app->acceso();
            $id_orden_compra = prm_def($param, "ticket");

            $this->estado_compra($id_orden_compra, $data);

            $resumen = $this->resumen_valoraciones($data["id_usuario"]);

            $data += [
                "action" => prm_def($param, "action", ""),
                "valoraciones" => prm_def($resumen, "info_valoraciones", []),
                "alcance" => crea_alcance($this->get_alcance($data["id_usuario"])),
                "ticket" => $id_orden_compra,
            ];

            $data = $this->app->cssJs($data, "area_cliente");
            $this->app->pagina($data, render_user($data), 1);

        }
    }

    private function productos($producto_orden_compra)
    {

        $response = [];
        if (es_data($producto_orden_compra)) {

            $ids = array_column($producto_orden_compra, "id_proyecto_persona_forma_pago");
            $response = $this->app->api("recibo/ids/format/json/", ["ids" => $ids]);
        }
        return $response;

    }


    private function estado_compra($id_orden_compra, $data)
    {

        if ($id_orden_compra > 0) {
            $productos_ordenes_compra = $this->app->productos_ordenes_compra($id_orden_compra);
            if (es_data($productos_ordenes_compra)) {

                foreach ($productos_ordenes_compra as $row) {

                    $id_recibo_producto = $row["id_proyecto_persona_forma_pago"];
                    $recibo = $this->recibo($id_recibo_producto);
                    if (es_data($recibo) && pr($recibo, 'id_ciclo_facturacion') != 9) {
                        $this->gestiona_tipo_entrega($recibo,  $data, $id_orden_compra);
                    }
                }
            }
        }
    }


    private function recibo($id)
    {

        return $this->app->api("recibo/id/format/json/", ["id" => $id]);
    }

    private function gestiona_tipo_entrega($recibo,  $data, $id_orden_compra)
    {

        $es_administrador_vendedor = es_administrador_o_vendedor($data);
        $tipo_entrega = pr($recibo, 'tipo_entrega');
        $contra_entrega_domicilio = pr($recibo, 'contra_entrega_domicilio');

        /*Cuando es por mensajería*/
        if ($tipo_entrega == 2) {
            /*Verifico que tenga saldo pendiente*/
            $direcciones_registradas = $this->recibo_pago_direccion($id_orden_compra, $contra_entrega_domicilio);
            if ($direcciones_registradas < 1) {

                $extra = ($es_administrador_vendedor) ? '&asignacion_horario_entrega=1' : '';
                $link_registro_domicilio =
                    _text(
                        "../",
                        path_enid("pedido_seguimiento", $id_orden_compra),
                        _text("&domicilio=1", $extra)
                    );

                redirect($link_registro_domicilio);


            } else {


                if (pr($recibo, 'saldo_cubierto') > 0) {

                    $link_registro_domicilio =
                        _text(
                            "../",
                            path_enid("pedido_seguimiento", $id_orden_compra)
                        );
                    redirect($link_registro_domicilio);
                }
            }
        }
    }

    private function recibo_pago_direccion($id_recibo, $contra_entrega_domicilio)
    {

        if ($contra_entrega_domicilio > 0) {

            $response = $this->app->api(
                "proyecto_persona_forma_pago_punto_encuentro/punto_encuentro_recibo/format/json/",
                [
                    "id_recibo" => $id_recibo
                ]
            );

        } else {

            $response = $this->app->api(
                "proyecto_persona_forma_pago_direccion/recibo/format/json/",
                [
                    "id_recibo" => $id_recibo,
                    "total" => 1,
                ]
            );
        }
        return $response;


    }

    private function resumen_valoraciones($id_usuario)
    {
        return $this->app->api("valoracion/usuario/format/json/",
            ["id_usuario" => $id_usuario]);
    }

    private function get_alcance($id_usuario)
    {

        return $this->app->api("servicio/alcance_usuario/format/json/",
            ["id_usuario" => $id_usuario]);
    }
}
