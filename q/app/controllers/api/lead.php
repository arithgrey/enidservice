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
    function ventas_proceso_GET(){
        
        $param = $this->get();
        $id_usuario = $this->app->get_session('id_usuario');
        $data = $this->app->session();                
        $id_empresa = $data['id_empresa'];
        $id_perfil = $param["id_perfil"] = $this->app->getperfiles();
        


        $response  = $this->pendientes_ventas_usuario($id_usuario, $id_perfil, $id_empresa);
        $response  = pedidos_en_proceso($data, $response);
        $this->response($response);
    }
    private function pendientes_ventas_usuario($id_usuario, $id_perfil, $id_empresa)
    {
        $usuarios = $this->app->api("recibo/pendientes_sin_cierre",
            [
                "id_usuario" => $id_usuario,
                "id_perfil" => $id_perfil,
                "id_empresa" => $id_empresa,
                "domicilios" => 1
            ]
        );        
        
        
        $usuarios = $this->usuarios_en_lista_negra($usuarios);                        
        return $this->app->imgs_productos(0, 1, 1, 1, $usuarios);
        

    }

    private function usuarios_en_lista_negra(array $usuarios)
    {
        $lista = [];
        $lista_completa = [];
        
        foreach ($usuarios as $row) {

            $lista[] = $row['id_usuario'];
        }

        $q['usuarios'] = get_keys($lista);
        $usuarios_lista_negra = $this->app->api("lista_negra/q", $q);
        
        foreach ($usuarios as $row) {

            $es_lista_negra = search_bi_array($usuarios_lista_negra, 'id_usuario', $row['id_usuario']);
            if (!$es_lista_negra) {

                $lista_completa[] = $row;
            }
        }
        return $lista_completa;
    }
}
