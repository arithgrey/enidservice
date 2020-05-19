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
            $id_ticket = prm_def($param, "ticket");
            $this->estado_compra($id_ticket, $data);

            $resumen = $this->resumen_valoraciones($data["id_usuario"]);

            $data += [
                "action" => prm_def($param, "action", ""),
                "valoraciones" => prm_def($resumen, "info_valoraciones", []),
                "alcance" => crea_alcance($this->get_alcance($data["id_usuario"])),
                "ticket" => $id_ticket,
            ];

            $data = $this->app->cssJs($data, "area_cliente");
            $this->app->pagina($data, render_user($data), 1);

        }
    }

    private function estado_compra($id_recibo, $data)
    {

        if ($id_recibo > 0) {
            $recibo = $this->recibo($id_recibo);
            if (es_data($recibo) && pr($recibo, 'id_ciclo_facturacion') != 9) {
                $this->gestiona_tipo_entrega($recibo, $id_recibo, $data);
            }
        }
    }

    private function recibo($id)
    {

        return $this->app->api("recibo/id/format/json/", ["id" => $id]);
    }

    private function gestiona_tipo_entrega($recibo, $id_recibo, $data)
    {

        $es_administrador_vendedor = es_administrador_o_vendedor($data);
        $tipo_entrega = pr($recibo, 'tipo_entrega');
        $contra_entrega_domicilio = pr($recibo, 'contra_entrega_domicilio');


        /*Cuando es por mensajería*/
        if ($tipo_entrega == 2) {
            /*Verifico que tenga saldo pendiente*/
            $direcciones_registradas = $this->recibo_pago_direccion($id_recibo, $contra_entrega_domicilio);
            if ($direcciones_registradas < 1) {

                $extra = ($es_administrador_vendedor) ? '&asignacion_horario_entrega=1' : '';
                $link_registro_domicilio =
                    _text(
                        "../",
                        path_enid("pedido_seguimiento", $id_recibo),
                        _text("&domicilio=1", $extra)
                    );
                redirect($link_registro_domicilio);

            } else {


                if (pr($recibo, 'saldo_cubierto') > 0) {

                    $link_registro_domicilio =
                        _text(
                            "../",
                            path_enid("pedido_seguimiento", $id_recibo)
                        );
                    redirect($link_registro_domicilio);
                }
            }
        }
    }

    private function recibo_pago_direccion($id_recibo, $contra_entrega_domicilio)
    {

        $response = false;
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
