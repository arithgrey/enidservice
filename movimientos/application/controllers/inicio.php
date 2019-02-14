<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Inicio extends CI_Controller {
	function __construct(){        
        parent::__construct();            			
        $this->load->helper('transferencia');        
	    $this->load->library(lib_def());  
        $this->principal->acceso();
    }
    function index(){

		$data                                   =   $this->principal->val_session("Enid Service");
        $data["clasificaciones_departamentos"]  =   "";
        $data["css"]                            =   ["movimientos_info.css"];
        $param                                  =   $this->input->get();
        if($data["in_session"] == 1) {

            $action         =  get_info_variable($param , "action");   
            $id_usuario     =  $data["id_usuario"];    
            switch ($action){
                case 0:
                    $this->load_view_general($data , $param , $id_usuario);
                    break;

                case 1:

                    $this->load_view_cuentas_usuario($data , $param , $id_usuario);
                    break;
                case 2:

                    $this->load_metodos_transferencia($data , $param , $id_usuario);
                break;

                case 3:
                    $this->load_view_cuentas_asociadas($data, $param , $id_usuario);
                    break;

                case 4:
                    $this->crea_cuenta($data, $param , $id_usuario);
                    break;
                case 5:                    

                    break;    
                case 6:                     
                    $this->principal->show_data_page( $data , 'agregar_saldo');
                    break;
                case 7:

                    $this->agrega_saldo_oxxo($data, $param , $id_usuario);
                    break;

                case 8:                     

                    $this->saldo_oxxo($data, $param , $id_usuario);
                    break;
                case 9:
                    $this->saldo_amigo($data, $param , $id_usuario);
                    break;

                default:

                break;
            }

        }else{
            redirect("../");
        }
        
    }
    private function  saldo_amigo($data, $param , $id_usuario){

	    $data["css"]    = ["/movimientos.css"];
	    $data["js"]     = ['movimientos/solicitud_saldo_amigo.js'];
	    $this->principal->show_data_page($data , 'solicitar_a_un_amigo');

    }
    private function saldo_oxxo($data, $param , $id_usuario){


        $data["saldo_disponible"]   =   $this->get_saldo_usuario($id_usuario);
        $q["id_usuario"]            =   $id_usuario;
        $q["id_usuario_venta"]      =   $this->input->get("operacion");
        $q["id_recibo"]             =   $this->input->get("recibo");
        $data["recibo"]             =   $this->get_recibo_por_pagar($q);

        if ($data["recibo"]["cuenta_correcta"] == 1 ) {
            $this->principal->show_data_page( $data , 'pagar_con_saldo_enid');
        }else{
            redirect("../");
        }
    }
    private function agrega_saldo_oxxo($data, $param , $id_usuario){
        $data["js"] =  [base_url('application/js/solicitud_oxxo.js')];
        $this->principal->show_data_page( $data , 'agregar_saldo_desde_oxxo');
    }
    private function crea_cuenta($data, $param , $id_usuario){

        if($this->input->post()){

            $prm                =   $this->input->post();
            $prm["id_usuario"]  =   $id_usuario;
            $registro           =   $this->agregar_cuenta_bancaria($prm);
            $base_transfer      =   "../../movimientos/?q=transfer";
            if($registro["registro_cuenta"] ==  1){
                redirect($base_transfer."&action=3");
            }else{
                if($prm["tipo"] == 0) {
                    redirect($base_transfer."&action=1&error=1");
                }else{
                    redirect($base_transfer."&action=1&tarjeta=1&error=1");
                }
            }
        }else{
            redirect("../../movimientos");
        }

    }
    private function load_view_cuentas_asociadas($data, $param , $id_usuario){

        $data["cuentas_bancarias"]  =  $this->get_cuentas_usuario($id_usuario , 0);
        $data["tarjetas"]           =  $this->get_cuentas_usuario($id_usuario , 1);
        $data["css"]                = ["cuentas_asociadas.css"];
        $this->principal->show_data_page( $data , 'cuentas_asociadas');
    }
    private function load_metodos_transferencia($data , $param , $id_usuario){

        $saldos                     =   $this->get_saldo_usuario($id_usuario);
        $data["saldo_disponible"]   =   $saldos;
        $cuentas_bancarias          =   $this->get_cuentas_usuario($id_usuario , 0);
        $data["cuentas_gravadas"]   =   0;

        if(count($cuentas_bancarias)>0) {
            $data["cuentas_gravadas"]    = 1;
            $data["cuentas_bancarias"]   = $cuentas_bancarias;
        }
        $this->principal->show_data_page( $data , 'metodos_transferencia');

    }
    private function load_view_cuentas_usuario($data , $param , $id_usuario){

        $prm["id_usuario"]  =   $id_usuario;
        $data["bancos"]     =   $this->get_bancos_disponibles($prm);
        $data["usuario"]    =   $this->principal->get_info_usuario($id_usuario);
        $data["banca"]      =   get_info_variable($param , "tarjeta");
        $data["error"]      =   0;
        $prm                =   $this->input->get();

        if(get_param_def($prm ,  "error") > 0 ){
            $data["error"] =1;
        }
        $data["seleccion"]      = get_info_variable($param , "seleccion");
        $this->principal->show_data_page( $data , 'metodos_disponibles');

    }
    private function load_view_general($data , $param , $id_usuario){
        $saldos                     =  $this->get_saldo_usuario($id_usuario);
        $data["saldo_disponible"]   =   $saldos;
        $data["js"] =  [
            'movimientos/principal.js',
            'movimientos/notificaciones.js',
            'movimientos/movimientos.js'
        ];
        $this->principal->show_data_page( $data , 'empresas_enid');
    }
    private function get_saldo_usuario($id_usuario){
        $q["id_usuario"]    =  $id_usuario;
        $api                =  "recibo/saldo";
        return $this->principal->api( $api , $q , "json", "POST" );         
    }
    private function carga_metodos_pago_usuario($q){        
        $api  =  "cuentas/metodos_disponibles_pago/";         
        return $this->principal->api( $api , $q , "html" );         
    }
    private function get_cuentas_usuario($id_usuario ,$tipo){        
        
        $q["id_usuario"]            =   $id_usuario;
        $q["tipo"]                  =   $tipo;
        $q["metodos_disponibles"]   =   1;        
        $api  =  "cuentas/usuario";         
        return $this->principal->api( $api , $q  , "json", "POST");
    }
    private function get_bancos_disponibles($q){

        $api  =  "banco/index/format/json/";         
        return $this->principal->api( $api , $q );        
    }
    private function get_recibo_por_pagar($q){        
        $api  =  "cobranza/recibo_por_pagar/format/json/";         
        return $this->principal->api( $api , $q );        
    }
    private function agregar_cuenta_bancaria($q){

        $api  = "cuentas/bancaria";
        return $this->principal->api( $api , $q , "json" , "POST");
    }
}