<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
use Enid\ServicioImagen\Format as FormatImgServicio;
class Home extends CI_Controller
{
    private $id_usuario;
    private $servicio_imagen;
    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
        $this->load->helper("stock");
        $this->id_usuario = $this->app->get_session("id_usuario");
        $this->servicio_imagen = new FormatImgServicio();
    }

    function index()
    {

        $inventario = $this->app->api("stock/inventario");
        $inventario = $this->servicio_imagen->url_imagen_servicios($inventario);
        $almacenes = $this->app->api("almacen/index");
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "stock", 1);
        
        $data["inventario"] = $inventario;
        $data["almacenes"] = $almacenes;
        $this->app->pagina($data, render($data), 1);
    }


    
}
