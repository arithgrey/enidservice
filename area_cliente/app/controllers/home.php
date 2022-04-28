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
            
            $id_orden_compra = prm_def($param, "ticket");
            $this->estado_compra($id_orden_compra, $data);
            $resumen = $this->resumen_valoraciones($data["id_usuario"]);

            
            
            $data += [
                "action" => prm_def($param, "action", ""),
                "valoraciones" => prm_def($resumen, "info_valoraciones", []),
                "alcance" => crea_alcance($this->get_alcance($data["id_usuario"])),
                "ticket" => $id_orden_compra,
            ];

            
            $data = $this->app->cssJs($data, "area_cliente", 1);
            $this->app->pagina($data, render_user($data), 1);

        }
    }

    private function productos($producto_orden_compra)
    {

        $response = [];
        if (es_data($producto_orden_compra)) {

            $ids = array_column($producto_orden_compra, "id_proyecto_persona_forma_pago");
            $response = $this->app->api("recibo/ids", ["ids" => $ids]);
        }
        return $response;

    }


    private function estado_compra($id_orden_compra, $data)
    {

        if ($id_orden_compra > 0) {
            $productos_ordenes_compra = $this->app->productos_ordenes_compra($id_orden_compra);            
            if (es_data($productos_ordenes_compra)) {
                $a = 0;
                foreach ($productos_ordenes_compra as $row) {

                    if ($a < 1) {

                        $id_ciclo_facturacion = $row["id_ciclo_facturacion"];                        
                        if ($id_ciclo_facturacion != 9) {
                            $this->gestiona_tipo_entrega($row, $data, $id_orden_compra);
                        }
                    }
                    $a++;
                }
            }
        }
    }


    /*
    private function recibo($id)
    {

        return $this->app->api("recibo/id/", ["id" => $id]);
    }
    */
    private function gestiona_tipo_entrega($recibo, $data, $id_orden_compra)
    {

        $es_administrador_vendedor = es_administrador_o_vendedor($data);
        
        $tipo_entrega = $recibo['tipo_entrega'];
        $contra_entrega_domicilio = $recibo['contra_entrega_domicilio'];
        $id_recibo = $recibo["id"];
        /*Cuando es por mensajería*/
        if ($tipo_entrega == 2) {
            /*Verifico que tenga saldo pendiente*/
            $direcciones_registradas = $this->recibo_pago_direccion($id_recibo, $contra_entrega_domicilio);
                        
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
                

                if ($recibo['saldo_cubierto'] > 0) {

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
                "proyecto_persona_forma_pago_punto_encuentro/punto_encuentro_recibo",
                [
                    "id_recibo" => $id_recibo
                ]
            );

        } else {

            $response = $this->app->api(
                "proyecto_persona_forma_pago_direccion/recibo/",
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
        return $this->app->api("valoracion/usuario",
            ["id_usuario" => $id_usuario]);
    }

    private function get_alcance($id_usuario)
    {

        return $this->app->api("servicio/alcance_usuario",
            ["id_usuario" => $id_usuario]);
    }
}
