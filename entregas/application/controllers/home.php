<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->helper("entregas");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index()
    {


        $data = $this->app->session();
        $this->app->acceso();
        $data = $this->app->cssJs($data, "entregas");
        $id_usuario = $data['id_usuario'];
        $id_perfil = $data['id_perfil'];
        $data['proximas_entregas'] = $this->proximas_reparto($id_perfil, $id_usuario);
        $this->app->pagina($data, calendario($data), 1);


    }

    function proximas_reparto($id_perfil, $id_usuario)
    {

        return $this->app->api(
            "recibo/proximas_reparto/format/json/",
            [
                "id_perfil" => $id_perfil,
                "id_usuario" => $id_usuario
            ]
        );
    }


}
