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

            $leads_franja_horaria = $this->recibo_model->lead_franja_horaria(
                $this->id_usuario,
                $param["fecha_inicio"],
                $param["fecha_termino"]
            );


            $leads_franja_horaria_menos_uno = $this->recibo_model->lead_franja_horaria_menos_uno($this->id_usuario);

            
            $response = $this->table_franja_horaria($leads_franja_horaria, $leads_franja_horaria_menos_uno);

        }
        $this->response($response);
    }
    private function table_franja_horaria($leads_franja_horaria,  $leads_franja_horaria_menos_uno)
    {


        $total_leads = 0;
        $total_catalogo = 0;
        $total_promocion = 0;
        $total_cancelaciones = 0;
        $total_venta_efectiva = 0;
        $total_venta_efectiva_ayer = 0;
        $total_leads_ayer = 0;

        $heading = [
            "Franja horaria",
            "Leads registrados ayer",
            "Leads registrados hoy",
            "Reciben el catalogo",
            "Reciben promoción",
            "Cancelaciones",
            "Ventas ayer",
            "Ventas hoy"
            
        ];

        

            $this->table->set_template(template_table_enid());
            $this->table->set_heading($heading);

            for($a = 23; $a > -1 ; $a --){
            

                $total = $this->busqueda_franja($a , "total" ,$leads_franja_horaria);
                $total_ayer = $this->busqueda_franja($a , "total" ,$leads_franja_horaria_menos_uno);

                $lead_catalogo = $this->busqueda_franja($a , "lead_catalogo" ,$leads_franja_horaria);
                $lead_promo_regalo = $this->busqueda_franja($a , "lead_promo_regalo" ,$leads_franja_horaria);
                $es_cancelada = $this->busqueda_franja($a , "es_cancelada" ,$leads_franja_horaria);
                $venta_efectiva = $this->busqueda_franja($a , "venta_efectiva" ,$leads_franja_horaria);
                
                $venta_efectiva_ayer = $this->busqueda_franja($a , "venta_efectiva" ,$leads_franja_horaria_menos_uno);

                $total_leads =  $total_leads + $total;  
                $total_leads_ayer = $total_leads_ayer + $total_ayer;


                $total_catalogo = $total_catalogo +  $lead_catalogo;
                $total_promocion = $total_promocion +  $lead_promo_regalo;
                $total_cancelaciones =  $total_cancelaciones +  $es_cancelada;
                $total_venta_efectiva = $total_venta_efectiva  +  $venta_efectiva;
                $total_venta_efectiva_ayer = $total_venta_efectiva_ayer  +  $venta_efectiva_ayer;



                $extra = ($venta_efectiva > 0) ? 'blue_enid strong f12 border border-secondary'  : 'f12 red_enid border border-secondary';
                $extra_ayer = ($venta_efectiva_ayer > 0) ? 'blue_enid strong f12 border border-secondary'  : 'f12 red_enid border border-secondary';
                
                $clase_menos = ($total_ayer < $total) ? 'blue_enid' : 'red_enid';
                
                $linea = [
                    _text_($a, 'hrs'),
                    d($total_ayer, 'border-secondary border'),
                    d($total, _text_($clase_menos, 'border-secondary border strong' )),
                    $lead_catalogo,
                    $lead_promo_regalo,
                    $es_cancelada,
                    d($venta_efectiva_ayer, $extra_ayer),
                    d($venta_efectiva, $extra),
                    
                ];

                
                $this->table->add_row($linea);

            }
        
        $extra = ($total_leads_ayer > $total_leads) ? 'red_enid strong' : 'blue_enid strong';
        $extra_venta = ($total_venta_efectiva_ayer > $total_venta_efectiva) ? 'red_enid strong' : 'blue_enid strong';

        $footer = [
            "Totales",
            $total_leads_ayer,
            d($total_leads, $extra),            
            $total_catalogo,
            $total_promocion,
            $total_cancelaciones,
            $total_venta_efectiva_ayer,
            d($total_venta_efectiva, $extra_venta)
        ];

        $this->table->add_row($footer);

        return $this->table->generate();
    }
    function busqueda_franja($hora , $busqueda ,$leads_franja_horaria){


        $valor_busqueda =  0;
        foreach ($leads_franja_horaria as $row) {

            $hora_lead = $row["hora"];
            if($hora_lead == $hora ){
                $valor_busqueda = $row[$busqueda];
                break;
            }            
        }
        return $valor_busqueda;
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
    function ventas_proceso_clientes_GET(){
        
        $data = $this->app->session();                
        $response  = $this->pendientes_ventas_clientes();        
        $response  = pedidos_en_proceso($data, $response ,0,0);
        $this->response($response);
    }
    private function pendientes_ventas_clientes()
    {
        $usuarios = $this->app->api("recibo/pendientes_sin_cierre_clientes");                
        $usuarios = $this->usuarios_en_lista_negra($usuarios);                        
        return $this->app->imgs_productos(0, 1, 1, 1, $usuarios);
        

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
