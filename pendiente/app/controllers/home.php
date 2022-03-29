<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{   
    private $comision; 
    function __construct()
    {
        parent::__construct();
        $this->load->helper('busqueda');
        $this->load->library(lib_def());
        $this->comision = new Enid\Comision\Comision();


    }

    function index()
    {
        $data = $this->app->session(9);
        $data = $this->app->cssJs($data, "saldo_pendiente", 1);                
        $id_usuario = $data["id_usuario"];

        $comisiones_por_cobrar = $this->comisiones_por_cobrar($id_usuario);                       
        $recompensas = $this->app->recompensas_recibos($comisiones_por_cobrar);                

        
        $data["comisiones_por_cobrar"] = $comisiones_por_cobrar;
        $data["saldo_por_cobrar"] = 
        $this->comision->saldo_disponible($comisiones_por_cobrar, $recompensas);  

        $data["bancos"] = $this->bancos();
        $data["cuenta_pago"] = $this->cuenta_pago($id_usuario);        
        $data["solicitud_retiro"] = $this->solicitud_retiro($id_usuario);
    
        $this->app->pagina($data, render($data), 1);

    }
    private function comisiones_por_cobrar($id_usuario)
    {

        return $this->app->api("recibo/comisiones_por_cobrar/", ["id" =>  $id_usuario]);
    }   
    private function bancos()
    {
        
        return $this->app->api("banco/index/");
    }   

    private function cuenta_pago($id_usuario)
    {
        
        return $this->app->api("cuenta_banco/id/",["id_usuario" => $id_usuario]);

    }   
    private function solicitud_retiro($id_usuario)
    {
        
        return $this->app->api("solicitud_retiro/id/",["id_usuario" => $id_usuario]);
        
    }   

}