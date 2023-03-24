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
   
   
}
