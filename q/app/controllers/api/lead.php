<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class lead extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("recibo_model");
        $this->load->helper("lead");
        $this->load->library('table');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    public function franja_horaria_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "fecha_inicio,fecha_termino")) {

            $leads = $this->recibo_model->lead_franja_horaria(
                $this->id_usuario,
                $param["fecha_inicio"],
                $param["fecha_termino"]
            );

            $response = $this->table_franja_horaria($leads);
        }
        $this->response($response);
    }
    private function table_franja_horaria($leads)
    {

        $total_leads = 0;
        $total_catalogo = 0;
        $total_promocion = 0;
        $total_cancelaciones = 0;
        $total_venta_efectiva = 0;
        $heading = [
            "Franja horaria",
            "Leads registrados",
            "Reciben el catalogo",
            "Reciben promoción",
            "Cancelaciones",
            "Ventas efectivas"
        ];

        if (es_data($leads)) {

            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            foreach ($leads as $row) {

                $hora = $row["hora"];
                $total = $row["total"];
                $lead_catalogo =  $row["lead_catalogo"];
                $lead_promo_regalo =  $row["lead_promo_regalo"];
                $es_cancelada = $row["es_cancelada"];
                $venta_efectiva =  $row["venta_efectiva"];



                $total_leads =  $total_leads + $total;
                $total_catalogo = $total_catalogo +  $lead_catalogo;
                $total_promocion = $total_promocion +  $lead_promo_regalo;
                $total_cancelaciones =  $total_cancelaciones +  $es_cancelada;
                $total_venta_efectiva = $total_venta_efectiva  +  $venta_efectiva;

                $extra = ($venta_efectiva > 0) ? 'blue_enid strong'  : '';
                $linea = [
                    _text_($hora, 'hrs'),
                    $total,
                    $lead_catalogo,
                    $lead_promo_regalo,
                    $es_cancelada,
                    d($venta_efectiva, $extra)
                ];

                $this->table->add_row($linea);
            }
        }

        $footer = [
            "Totales",
            $total_leads,
            $total_catalogo,
            $total_promocion,
            $total_cancelaciones,
            $total_venta_efectiva
        ];

        $this->table->add_row($footer);

        return $this->table->generate();
    }
    function envio_reparto_PUT()
    {
        $param = $this->put();

        $response = false;
        if (fx($param, "orden_compra")) {

            $id_orden_compra = $param["orden_compra"];
            $productos_orden_compra = $this->app->productos_ordenes_compra($id_orden_compra);
            
            foreach ($productos_orden_compra as $row) {
                
                $response = $this->recibo_model->notificacion_envio_reparto($row["id"]);
               
            }
        }


        $this->response($response);
    }
}
