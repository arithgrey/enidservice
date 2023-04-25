<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

use Enid\RespuestasFrecuentes\Form as FormRespuestaFrecuente;

class Home extends CI_Controller
{
    private $id_usuario;
    private $formRespuestaFrecuente;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("usuario");
        $this->load->library(lib_def());
        $this->app->acceso();
        $this->formRespuestaFrecuente =  new FormRespuestaFrecuente();
    }


    function index()
    {

        $data = $this->app->session();
        $param = $this->input->get();
        $q = prm_def($param, 'q');

        $data = $this->app->cssJs($data, "usuario_contacto");

        if ($q !== 0) {

            $this->busqueda($data, $param);
        } else {

            $this->encuesta($param, $data);
        }
    }

    private function encuesta($param, $data)
    {

        $id_usuario = prm_def($param, 'id_usuario');
        

        $data["es_lista_negra"] = $this->app->api("lista_negra/index", ['id_usuario' => $id_usuario]);
        $prm = $this->input->get();

        $usuario = $this->app->usuario($id_usuario);
        $usuario_busqueda = $this->app->add_imgs_usuario($usuario, "id_usuario");
        $data['usuario_busqueda'] = $usuario_busqueda;
        $perfil_busqueda = $this->get_perfil_data($id_usuario);
        $data['perfil_busqueda'] = $perfil_busqueda;
        $data['usuario_calificacion'] = $this->usuario_calificacion($id_usuario);
        $data["tipificaciones"] = $this->tipo_tipificciones($data['in_session'], $data);
        $data['encuesta'] = prm_def($prm, 'encuesta');
        $data['id_servicio'] = prm_def($prm, 'servicio');

        $session = $this->app->session();
        $ventas_semana = $this->ventas_semana($id_usuario);
        $meta_semanal_comisionista = pr($session['info_empresa'], 'meta_semanal_comisionista');

        if (!es_cliente($perfil_busqueda)) {
            $data["meta_semanal_comisionista"] = $meta_semanal_comisionista;
            $data["ventas_semana"] = $ventas_semana;
            $data["total_seguidores"] = $this->app->totales_seguidores($id_usuario);
        }

        $data["recibos_pago"] = [];
        $data["recibos_sin_pago"] = [];
        $data["otros_productos_interes"] = [];

        if (es_cliente($usuario_busqueda)) {


            $data["otros_productos_interes"] = $this->articulo_busqueda($id_usuario);
        }

        $data["formulario_busqueda_frecuente"] = $this->formRespuestaFrecuente->busqueda(1);        
        $data["acciones_seguimiento"] = $this->app->api("accion_seguimiento/index");
        $data["id_recibo"] = prm_def($param, 'recibo');
        $this->app->pagina($data, render($data), 1);
    }

    private function articulo_busqueda($id_usuario)
    {
        return $this->app->api("tag_arquetipo/index", ["usuario" => $id_usuario]);
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

            return $this->app->api("recibo/pedidos", $q);
        }
    }

    private function busqueda($data, $param)
    {

        $this->app->pagina($data, render_busqueda($data, $param), 1);
    }

    private function tipo_tipificciones($in_session, $data)
    {
        $perfil_busqueda = $data['perfil_busqueda'];
        $id_perfil = pr($perfil_busqueda, "idperfil");

        $tipo = ($id_perfil > 1) ? $id_perfil : $in_session;
        $tipo_busqueda = ($in_session) ? $tipo : 0;

        return $this->app->api(
            "tipo_puntuacion/tipo/",
            [
                "tipo" => $tipo_busqueda
            ]
        );
    }

    private function get_perfil_data($id_usuario)
    {


        return $this->app->api("perfiles/data_usuario", ["id_usuario" => $id_usuario]);
    }

    private function usuario_calificacion($id_usuario)
    {

        return $this->app->api("puntuacion/general", ["id_usuario" => $id_usuario]);
    }
}
