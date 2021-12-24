<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('busqueda');
        $this->load->library(lib_def());
    }

    function index()
    {
        $data = $this->app->session(9);
        $data = $this->app->cssJs($data, "busqueda");        
        $session = $this->app->session();
        $meta_semanal_comisionista = pr($session['info_empresa'], 'meta_semanal_comisionista');
        $ventas_semana = $this->ventas_semana();



        $data["meta_semanal_comisionista"] = $meta_semanal_comisionista;
        $data["ventas_semana"] = $ventas_semana;
        $comisiones_usuario = $this->comisiones_por_cobrar($data["id_usuario"]);        
        $recompensas = $this->app->recompensas_recibos($comisiones_usuario);        
        $data["comisiones_por_cobrar"] = $comisiones_usuario;
        $data["recompensas"] = $recompensas;

        $this->app->pagina($data, render($data), 1);


    }
    
    private function comisiones_por_cobrar($id_usuario)
    {

        $q = 
        [
            "id" =>  $id_usuario
        ];
        return $this->app->api("recibo/comisiones_por_cobrar/format/json/", $q);
    }    

    private function ventas_semana()
    {

        $fecha = new DateTime(now_enid());
        $dias = $fecha->format("w");
        $hoy = now_enid();
        $fecha_inicio = add_date($hoy, -$dias);
        $id_usuario = $this->app->get_session("idusuario");

        if ($id_usuario > 0) {

            $q['usuarios'] = 0;
            $q['ids'] = 0;
            $q['es_busqueda_reparto'] = 0;
            $q['perfil'] = 3;
            $q['cliente'] = "";
            $q['v'] = 2;
            $q['recibo'] = "";
            $q['tipo_entrega'] = 0;
            $q['status_venta'] = 14;
            $q['tipo_orden'] = 5;
            $q['id_usuario_referencia'] = $id_usuario;
            $q['id_usuario'] = $id_usuario;
            $q['fecha_inicio'] = $fecha_inicio;
            $q['fecha_termino'] = $hoy;
            $q['consulta'] = 1;
            $q['recibo'] = '';

            return $this->app->api("recibo/pedidos/format/json/", $q);

        }

    }

}