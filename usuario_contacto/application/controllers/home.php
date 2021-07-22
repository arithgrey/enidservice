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

            $this->busqueda($data);

        } else {

            $this->encuesta($param, $data);

        }

    }

    private function encuesta($param, $data)
    {

        $id_usuario = prm_def($param, 'id_usuario');

        $prm = $this->input->get();
        $usuario = $this->app->usuario($id_usuario);
        $usuario_busqueda = $this->app->add_imgs_usuario($usuario, "id_usuario");
        $data['usuario_busqueda'] = $usuario_busqueda;
        $data['perfil_busqueda'] = $this->get_perfil_data($id_usuario);
        $data['usuario_calificacion'] = $this->usuario_calificacion($id_usuario);
        $data["tipificaciones"] = $this->tipo_tipificciones($data['in_session'], $data);
        $data['encuesta'] = prm_def($prm, 'encuesta');
        $data['id_servicio'] = prm_def($prm, 'servicio');

        $session = $this->app->session();
        $ventas_semana = $this->ventas_semana($id_usuario);
        $meta_semanal_comisionista = pr($session['info_empresa'], 'meta_semanal_comisionista');

        $data["meta_semanal_comisionista"] = $meta_semanal_comisionista;
        $data["ventas_semana"] = $ventas_semana;
        $data["total_seguidores"] = $this->app->totales_seguidores($id_usuario);

        $data["recibos_pago"] = [];
        $data["recibos_sin_pago"] = [];
        $data["otros_productos_interes"] = [];

        if (es_cliente($usuario_busqueda)) {

            $data["recibos_pago"] = $this->app->recibos_usuario($id_usuario, 1 );
            $data["recibos_sin_pago"] = $this->app->recibos_usuario($id_usuario, 0 );
            $data["otros_productos_interes"] = $this->articulo_busqueda($id_usuario);

        }

        $this->app->pagina($data, render($data), 1);

    }

    private function articulo_busqueda($id_usuario)
    {
        return $this->app->api("tag_arquetipo/index/format/json/",["usuario" => $id_usuario]);
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

    private function busqueda($data)
    {

        $this->app->pagina($data, render_busqueda($data), 1);

    }

    private function tipo_tipificciones($in_session, $data)
    {
        $perfil_busqueda = $data['perfil_busqueda'];
        $id_perfil = pr($perfil_busqueda, "idperfil");

        $tipo = ($id_perfil > 1) ? $id_perfil : $in_session;
        $tipo_busqueda = ($in_session) ? $tipo : 0;

        return $this->app->api("tipo_puntuacion/tipo/format/json/",
            [
                "tipo" => $tipo_busqueda
            ]
        );

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
