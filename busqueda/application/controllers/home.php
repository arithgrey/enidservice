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
        $param = $this->input->get();
        $data = $this->app->session();
        $data["css"] = ["search_sin_encontrar.css"];

        $session = $this->app->session();
        $meta_semanal_comisionista = pr($session['info_empresa'], 'meta_semanal_comisionista');

        $ventas_semana = $this->ventas_semana();


        $param["meta_semanal_comisionista"] = $meta_semanal_comisionista;
        $param["ventas_semana"] = $ventas_semana;

        $this->app->pagina($data, form($param), 1);


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

