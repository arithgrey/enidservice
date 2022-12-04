<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());
        $this->app->acceso();
    }

    function index()
    {
        $data = $this->app->session();
        $param = $this->input->get();
        $id_orden_compra = prm_def($param, "ticket");
        $deuda = $this->deuda_orden_compra($id_orden_compra);

        
        $this->estado_compra($id_orden_compra, $data, $param, $deuda);

        $data += [
            "ticket" => $id_orden_compra,
            "cobro_compra" => $this->carga_pago_pendiente_por_recibo($id_orden_compra),
            "orden_compra" => $id_orden_compra,
            "deuda" => $deuda
        ];

        $data = $this->app->cssJs($data, "area_cliente", 1);
        $this->app->pagina($data, 'pay/pay');
    }
    private function deuda_orden_compra($id_orden_compra)
    {

        $q["id_orden_compra"] = $id_orden_compra;
        return $this->app->api("recibo/deuda_orden_compra/", $q);                
        
    }    
    function carga_pago_pendiente_por_recibo($id_orden_compra)
    {

        $q["id_orden_compra"] = $id_orden_compra;
        $q["cobranza"] = 1;

        return $this->app->api("recibo/resumen_desglose_pago/", $q);
    }
    private function estado_compra($id_orden_compra, $data, $param, $deuda)
    {

        $this->anotaciones_pago($param, $id_orden_compra, $deuda);
        

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
    private function anotaciones_pago($param, $id_orden_compra, $deuda){

        if(prm_def($param,"redirect_status") === "succeeded"){
            $saldo_pendiente_pago_contra_entrega = $deuda["saldo_pendiente_pago_contra_entrega"];
            $q = [
                "orden_compra" => $id_orden_compra,
                "status" => 11,
                "saldo_cubierto" => $saldo_pendiente_pago_contra_entrega,
                "es_proceso_compra" => "",
                "tipo_entrega" => 2,
                "anotacion" => 1
                
            ];
            $this->app->api("recibo/status", $q, "json", "PUT");


            $path =  path_enid("pedido_seguimiento", $id_orden_compra,0,1);
            redirect($path);
        }
    }
    private function gestiona_tipo_entrega($recibo, $data, $id_orden_compra)
    {

        $tipo_entrega = $recibo['tipo_entrega'];
        $contra_entrega_domicilio = $recibo['contra_entrega_domicilio'];
        $id_recibo = $recibo["id"];

        /*Cuando es por mensajería*/
        if ($tipo_entrega == 2) {
            /*Verifico que tenga saldo pendiente*/
            $direcciones_registradas = $this->recibo_pago_direccion($id_recibo, $contra_entrega_domicilio);

            if ($direcciones_registradas < 1) {


                $this->gestion_sin_domicilio($data, $recibo, $id_orden_compra);
            } else {


                $this->link_compra_efectiva($recibo, $id_orden_compra);
            }
        }
    }
    private function gestion_sin_domicilio($data, $recibo, $id_orden_compra)
    {

        if ($recibo["numero_boleto"] > 0) {

            $this->link_compra_rapida_sorteo($id_orden_compra, $data, $recibo);
        } else {
            $this->link_compra_regular($id_orden_compra, $data);
        }
    }
    private function link_compra_regular($id_orden_compra, $data)
    {

        $es_administrador_vendedor = es_administrador_o_vendedor($data);
        $extra = ($es_administrador_vendedor) ? '&asignacion_horario_entrega=1' : '';

        $link_registro_domicilio =
            _text(
                "../",
                path_enid("pedido_seguimiento", $id_orden_compra),
                _text("&domicilio=1", $extra)
            );


        redirect($link_registro_domicilio);
    }
    private function link_compra_rapida_sorteo($id_orden_compra, $data, $recibo)
    {
        $link_resumen_compra_sorteo = '';
        if (es_administrador_o_vendedor($data)) {
            $link_resumen_compra_sorteo = _text(
                "../",
                path_enid("pedido_seguimiento", $id_orden_compra),
                "&sorteo=9998"
            );
            redirect($link_resumen_compra_sorteo);
        }
    }
    private function link_compra_efectiva($recibo, $id_orden_compra)
    {

        if ($recibo['saldo_cubierto'] > 0) {

            $link_registro_domicilio =
                _text(
                    "../",
                    path_enid("pedido_seguimiento", $id_orden_compra)
                );
            redirect($link_registro_domicilio);
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
                "proyecto_persona_forma_pago_direccion/recibo",
                [
                    "id_recibo" => $id_recibo,
                    "total" => 2,
                ]
            );
        }
        return $response;
    }

    
}
