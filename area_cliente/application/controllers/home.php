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
            $this->estado_compra($id_ticket);

            $data += [
                "action" => $param["action"],
                "valoraciones" =>
                    prm_def(
                        $this->resumen_valoraciones($data["id_usuario"]),
                        "info_valoraciones", []),
                "alcance" => crea_alcance($this->get_alcance($data["id_usuario"])),
                "ticket" => $id_ticket,
            ];

            $data = $this->app->cssJs($data, "area_cliente");
            $this->app->pagina($data, render_user($data), 1);

        }
    }

    private function estado_compra($id_recibo)
    {

        if ($id_recibo > 0) {
            $recibo = $this->recibo($id_recibo);
            if (es_data($recibo) && pr($recibo, 'id_ciclo_facturacion') != 9) {
                $this->gestiona_tipo_entrega($recibo, $id_recibo);
            }
        }
    }

    private function recibo($id)
    {

        return $this->app->api("recibo/id/format/json/", ["id" => $id]);
    }

    private function gestiona_tipo_entrega($recibo, $id_recibo)
    {

        $tipo_entrega = pr($recibo, 'tipo_entrega');
        /*Cuando es por mensajería*/
        if ($tipo_entrega == 2) {
            /*Verifico que tenga saldo pendiente*/
            $direcciones_registradas = $this->recibo_pago_direccion($id_recibo);
            if ($direcciones_registradas < 1) {


                $link_registro_domicilio =
                    _text(
                        "../", path_enid("pedido_seguimiento", $id_recibo),
                        "&domicilio=1");
                redirect($link_registro_domicilio);

            } else {


                if (pr($recibo, 'saldo_cubierto') > 0) {

                    $link_registro_domicilio =
                        _text("../", path_enid("pedido_seguimiento", $id_recibo));
                    redirect($link_registro_domicilio);
                }

            }

        }

    }

    private function recibo_pago_direccion($id_recibo)
    {

        return $this->app->api("proyecto_persona_forma_pago_direccion/recibo/format/json/",
            [
                "id_recibo" => $id_recibo,
                "total" => 1,
            ]
        );

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
