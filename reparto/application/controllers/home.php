<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("reparto");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index()
    {

        $param = $this->input->post();
        $data = $this->app->session();
        $this->seguimiento_pedido($param, $data);

    }

    function seguimiento_pedido($param, $data)
    {


        $data = $this->app->cssJs($data, 'reparto' , 1);
        $data += [
            "tipos_entregas" => $this->get_tipos_entregas([]),
            "repartidores" => $this->repartidores(),
        ];

        $this->busqueda_pedidos($param, $data);

    }


    private function busqueda_pedidos($param, $data)
    {
        
        $data['recibos'] = $this->cuentas_sin_recoleccion($param);
        $form = busqueda_reparto($data,$param);
        $this->app->pagina($data, $form, 1);

    }

    private function get_tipos_entregas($q)
    {

        return $this->app->api("tipo_entrega/index/format/json/", $q);
    }


    private function cuentas_sin_recoleccion($q)
    {

        $q['v'] = 1;
        return $this->app->api("recibo/reparto_recoleccion/format/json/", $q);

    }

    private function repartidores()
    {

        $q['id_perfil'] = 21;
        return $this->app->api("usuario/perfiles/format/json/", $q);

    }


}
