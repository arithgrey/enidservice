<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("usuario");
        $this->load->library(lib_def());
    }


    function index()
    {

        $data = $this->app->session();
        $param = $this->input->get();
        $q = prm_def($param, 'q');

        $data = $this->app->cssJs($data, "usuario_contacto");

        if ($q !== 0) {

            $this->busqueda($param, $data, $q);

        } else {

            $this->encuesta($param, $data);

        }

    }

    private function encuesta($param, $data)
    {

        $id_usuario = prm_def($param, 'id_usuario');
        $prm = $this->input->get();
        $data['usuario_busqueda'] = $this->app->usuario($id_usuario);
        $data['perfil_busqueda'] = $this->get_perfil_data($id_usuario);
        $data['usuario_calificacion'] = $this->usuario_calificacion($id_usuario);
        $data["tipificaciones"] = $this->tipo_tipificciones($data['in_session']);
        $data['encuesta'] = prm_def($prm, 'encuesta');
        $data['id_servicio'] = prm_def($prm, 'servicio');

        $session = $this->app->session();
        $ventas_semana = $this->ventas_semana($id_usuario);
        $meta_semanal_comisionista = pr($session['info_empresa'], 'meta_semanal_comisionista');

        $data["meta_semanal_comisionista"] = $meta_semanal_comisionista;
        $data["ventas_semana"] = $ventas_semana;
        $data["total_seguidores"] = $this->app->totales_seguidores($id_usuario);

        $this->app->pagina($data, render($data), 1);

    }


    private function ventas_semana($id_usuario)
    {

        $fecha = new DateTime(now_enid());
        $dias = $fecha->format("w");
        $hoy = now_enid();
        $fecha_inicio = add_date($hoy, -$dias);


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

    private function busqueda($param, $data, $q)
    {

        $len = strlen($q);
        $this->app->pagina($data, render_busqueda($data), 1);

    }

    private function tipo_tipificciones($in_session)
    {

        $in_session = ($in_session) ? 1 : 0;
        return $this->app->api("tipo_puntuacion/tipo/format/json/", ["in_session" => $in_session]);

    }

    private function get_perfil_data($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        return $this->app->api("perfiles/data_usuario/format/json/", $q);
    }

    private function usuario_calificacion($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "puntuacion/general/format/json/";
        return $this->app->api($api, $q);
    }

}
