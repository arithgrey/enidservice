<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class recibo extends REST_Controller{    
    private $id_usuario;     
    function __construct(){
        parent::__construct();          
        $this->load->model("recibo_model");        
        $this->load->helper("recibo");
        $this->load->library(lib_def());                    
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
    function servicio_ppfp_GET(){
        
        $param          =   $this->get();                
        $id_servicio    =   $this->recibo_model->q_get(["id_servicio"], $param["id_recibo"])[0]["id_servicio"];
        $this->response($id_servicio);        
    }   
    /**/    
    function saldo_pendiente_recibo_GET(){

        $param          =   $this->get();
        $response       =   $this->recibo_model->q_get([ "monto_a_pagar" , "flag_envio_gratis"], $param["id_recibo"]);        
        $monto_a_pagar  =   $response[0]["monto_a_pagar"]; 
        $costo_envio    =   get_costo_envio($response[0]);
        $total          =   $monto_a_pagar + $costo_envio["costo_envio_cliente"];
        $this->response($total);        
    }    
    
    function orden_de_compra_POST(){

        $param      =  $this->post();
        $response   =  $this->recibo_model->crea_orden_de_compra($param);
        $this->response($response);
    }
    function precio_servicio_GET(){

        $param =  $this->get();
        $response  =  $this->recibo_model->get_precio_servicio($param);
        $this->response($response);

    }
   	function resumen_compras_usuario($param){        
        
        $response = [];
        if($param["modalidad"] ==  1){
            $response =  $this->recibo_model->get_ventas_usuario($param);
        }else{
            $response =  $this->recibo_model->get_compras_usuario($param);                  
        }        
        $response["status_enid_service"] = $this->get_estatus_servicio_enid_service($param);        
        return $response;
    } 
    function get_estatus_servicio_enid_service($q){
        $api =  "status_enid_service/servicio/format/json/";
        return  $this->principal->api("q" , $api , $q);
        
    }    
    function proyecto_persona_info_GET(){        
                
        $param                              =   $this->get();              
        $id_usuario                         =   $this->id_usuario;                
        $param["id_usuario"]                =   $id_usuario;
        $data                               =   $this->resumen_compras_usuario($param);    
        $data["id_usuario"]                 =   $id_usuario;
        $data["modalidad"]                  =   $param["modalidad"];
        $ordenes                            =   0;            
        $data["ordenes"]                    =   $ordenes;
        
        if(count($data["data"]) > 0 ){
            $recibos                        =   $data["data"]; 
            $compras_ordenes                =   $this->agrega_estados_direcciones_a_pedidos($recibos);
            $data["ordenes"]                =   $compras_ordenes;                            
            $ordenes ++;
        }                                     
        $prm["modalidad"]                   =  $param["modalidad"];
        $prm["id_usuario"]                  =  $id_usuario;
        $data["en_proceso"]                 =  $this->en_proceso($prm);            
        /*Actividades que están en proceso por ejemplo envios y pagos pedientes*/            
        if($param["modalidad"] == 1){
            $data["numero_articulos_en_venta"] = $this->carga_productos_en_venta($param);                    
        }   
        $data["status"]      =   $param["status"];
        $data["anteriores"]  =   $this->verifica_anteriores($prm);                 

        $this->load->view("proyecto/lista_version_cliente" , $data);
    }     
    function agrega_estados_direcciones_a_pedidos($ordenes_compra){

        $ordenes = [];
        $a =0;
        foreach($ordenes_compra as $row){
            /**/
            $ordenes[$a] =  $row;
            if ($row["status"] == 6) {
                /*Se verifica que ya esté registrada la dirección*/
                $ordenes[$a]["direccion_registrada"] = 0;
            }else{
                /*Se indica que ya está refitrada la direccion*/
                $ordenes[$a]["direccion_registrada"] =  1;
            }
            $a ++;
        }
        return $ordenes;
    }
    function en_proceso($q){    
        $api        =  "tickets/en_proceso/format/json/";
        return       $this->principal->api("pagos", $api, $q);     
    }    
    function carga_productos_en_venta($q){
        $api        =  "servicio/num_venta_usuario/format/json/";
        return       $this->principal->api("q", $api, $q);     
    }
    function verifica_anteriores($q){
      
        $api        =  "tickets/verifica_anteriores/format/json/";
        return       $this->principal->api("pagos", $api, $q);     
    }
    function resumen_desglose_pago_GET(){
        
        $param  =  $this->get();                                                
        $recibo =  $this->recibo_model->get_info_recibo_por_id($param);        

        if(count($recibo) >0 ){            

            $monto_a_pagar                  =   $recibo[0]["monto_a_pagar"];
            $saldo_cubierto                 =   $recibo[0]["saldo_cubierto"];            
            $data_complete["url_request"]   =   get_url_request("");                
            $data_complete["recibo"]        =   $recibo;             
            $id_servicio                    =   $recibo[0]["id_servicio"];  

            /*Validamos que exista un monto por pagar*/
            $data_complete["servicio"] = $this->principal->get_base_servicio($id_servicio);

            if($monto_a_pagar > $saldo_cubierto ){                        

               $this->ticket_pendiente_pago($param , $recibo , $data_complete); 

            }else{
                
                $data_complete["recibo"]        =   $recibo;         
                $data_complete["id_recibo"]     =   $param["id_recibo"];
                $data_complete["servicio"]      =   $this->principal->get_base_servicio($id_servicio); 
                $id_usuario_venta               =   $recibo[0]["id_usuario_venta"];
                $usuario                        =   $this->principal->get_info_usuario($id_usuario_venta);
                $data_complete["usuario_venta"] =   $usuario; 
                $data_complete["modalidad"] =1;
                $this->load->view("cobranza/notificacion_pago_realizado" , $data_complete);  
                
            }
            /**/
        }
    }   
    function ticket_pendiente_pago($param , $recibo , $data_complete){

        $id_usuario =  $recibo[0]["id_usuario"];               
        
        if (get_info_usuario_valor_variable($param , "cobranza") ==  1){

            $data_complete["costo_envio_sistema"]   =  get_costo_envio($recibo[0]);
            /*Cargamos el saldo que tiene la persona*/
            $data_complete["id_recibo"]             =   $param["id_recibo"];
            $id_usuario_venta                       =   $recibo[0]["id_usuario_venta"];
            $data_complete["id_usuario_venta"]      =   $id_usuario_venta; 
            $direccion                              =   $this->get_direccion_pedido($param["id_recibo"]);

            $data_complete["informacion_envio"]     =   [];
            if (count($direccion) > 0 ) {
                $id_direccion = $direccion[0]["id_direccion"];
                $data_complete["informacion_envio"]     =   $this->get_direccion_por_id($id_direccion);    
            }
            
            
            $this->load->view("cobranza/pago_al_momento" , $data_complete);    


        }else{            
            
            $data_complete["usuario"]             =  
            $this->principal->get_info_usuario($id_usuario);            
            $data_complete["costo_envio_sistema"] =  get_costo_envio($recibo[0]);              
            $this->load->view("cobranza/resumen_no_aplica" , $data_complete);    
        }
               
    }
    function compras_efectivas_GET(){        
        
        $param                  =  $this->get();           
        $param["id_usuario"]    =   $this->id_usuario;
        $data_complete["total"] = $this->recibo_model->total_compras_ventas_efectivas_usuario($param);
        if($data_complete["total"] > 0 ){
            $data_complete["compras"] = $this->recibo_model->compras_ventas_efectivas_usuario($param);
        }
        $this->response($data_complete);  
    }
    function recibo_por_pagar_usuario_GET(){

        $param          =   $this->get();
        $respose        =   $this->recibo_model->valida_recibo_por_pagar_usuario($param);
        $this->response(crea_data_deuda_pendiente($respose));
    }

    function cancelar_PUT(){

        $param   =  $this->put();
        $respose =  $this->recibo_model->cancela_orden_compra($param);        
        $this->response($respose);
        
    }    
    private function get_direccion_pedido($id_recibo){
            
        $q["id_recibo"]     = $id_recibo;
        $api                = "proyecto_persona_forma_pago_direccion/recibo/format/json/";
        return $this->principal->api("q" , $api ,  $q);    
    }
    private function get_direccion_por_id($id_direccion){
            
        $q["id_direccion"] = $id_direccion;
        $api               = "direccion/data_direccion/format/json/";
        return $this->principal->api("q" , $api ,  $q);    
    }


}?>