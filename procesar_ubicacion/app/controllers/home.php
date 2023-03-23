<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Home extends CI_Controller
{
    public $option;
    private $id_usuario;
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
    }

    function index()
    {

        $param = $this->input->get();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "procesar_ubicacion");

        $param += [

            "id_orden_compra" => $param["orden_compra"],
            "id_usuario" => $this->id_usuario,
        ];

        $response = $this->app->api("usuario_direccion/direccion_envio_pedido", $param);

        $this->app->pagina($data, $response, 1);
    }

    
}
