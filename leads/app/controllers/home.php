<?php 
use Enid\BusquedaRecibo\Form as FormBusquedaOrdenesCompra;
class Home extends CI_Controller
{
    private $form_busqueda_ordenes_compra;
    function __construct()
    {
        parent::__construct();            

        $this->load->helper("busqueda");
        $this->load->library(lib_def());  
        $this->app->acceso();           
        $this->form_busqueda_ordenes_compra = new FormBusquedaOrdenesCompra();      
            
    }

    function index()
    {
        $param = $this->input->get();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "leads");    
                
        $data["leads"] = $this->recibos_sin_ficha_seguimiento();    
        $data["status_ventas"] = $this->app->api("status_enid_service/index");    
        $data["tipos_entregas"]= $this->app->api("tipo_entrega/index/");
        
        $data["formulario_busqueda_ordenes_compra"] = 
        $this->form_busqueda_ordenes_compra->busqueda($param, $data,1);
        $this->app->pagina($data, render($data), 1);

    }
    function recibos_sin_ficha_seguimiento()
    {
    
        return $this->app->api("clientes/recibos_sin_ficha_seguimiento");

    }

        
}