<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Cobranza extends REST_Controller{      
    public $option; 
    private $id_usuario;
    function __construct(){
        parent::__construct();                          
        $this->load->helper("cobranza");                        
        $this->load->library(lib_def());            
        $this->id_usuario = $this->principal->get_session("idusuario");
    } 
    
    /*Se cancela recordatorio de pago pendiente por email*/
    function cancelar_envio_recordatorio_PUT(){
        
        $param  =  $this->put();
        $response =  $this->cobranzamodel->cancelar_cobranza_email($param);
        $this->response($response);        
    }
    /**/
    function resumen_compras_usuario_GET(){        
        
        $param          = $this->get(); 
        $data_complete  = [];

        if($param["modalidad"] ==  1){
            $data_complete =  $this->cobranzamodel->get_ventas_usuario($param);
        }else{
            $data_complete =  $this->cobranzamodel->get_compras_usuario($param);                  
        }        
        $data_complete["status_enid_service"] = $this->cobranzamodel->get_estatus_servicio_enid_service();        
        $this->response($data_complete);
    }
    /**/
    function calcula_costo_envio_GET(){        
        $param =  $this->get();                
        $this->response($this->get_costo_envio($param));
    }
    /**/
    function get_costo_envio($param){
     
        $costo          = get_costo_envio($param);
        $icon           = icon('fas fa-bus');
        $texto          = $costo["text_envio"]["cliente"];         
        $texto_cliente  = 
        add_element($icon." ".$texto , "div" , array('class' => 'texto_envio' ));    
        $costo["text_envio"]["cliente"] = $texto_cliente;
        return $costo;
    }        
    /**/
    function notifica_recordatorio_cobranza_PUT(){

        $param = $this->put();
        $info =  $this->cobranzamodel->notifica_email_enviado_recordatorio($param);
        $this->response($info);
    }
    /**/
    function get_pago($q){
        $api = "recibo/resumen_desglose_pago"; 
        return $this->principal->api( $api , $q , "html" );
    }        
    /*Carga cuentas por */
    function cuentas_por_cobrar_GET(){

        $recibos =  $this->cobranzamodel->get_usuarios_deuda_pendiente();        
        $nueva_data = [];
        $x = 0;
        foreach($recibos as $row){            
            
            $id_usuario                             =   $row["id_usuario"];
            $usuario                                =   
            $this->principal->get_info_usuario($id_usuario);
            $nueva_data[$x]["usuario"]              =   $usuario;
            $nueva_data[$x]["cuenta_por_cobrar"]    =   $row;
            $prm["id_recibo"]                       =   
            $row["id_proyecto_persona_forma_pago"];
            $nueva_data[$x]["recibo"]               =   $this->get_pago($prm);
            $x ++;
            
        }
        $this->response($nueva_data);
        /**/
    }
    /**/
    function resumen_proyecto_persona_GET(){
        /**/
        $param =  $this->get();  
        $id_proyecto_persona = $param["id_proyecto_persona"]; 
        $data["info_proyecto"] =  $this->cobranzamodel->get_resumen_proyecto_persona($param);    
        $data["info_persona"] =  
        $this->cobranzamodel->get_info_persona($data["info_proyecto"][0]);        
        $data["historial_pagos"] =  $this->cobranzamodel->get_historial_pagos($param);         
        $data["info_request"] =  $param;
        $this->load->view("cobranza/renovaciones" , $data);        

    }
    /**/
    /**/
    function valida_estado_pago_GET(){

        $param =  $this->get();
        $id_proyecto_persona_forma_pago= $param["id_proyecto_persona_forma_pago"];  
        $this->response("<span class='blue_enid white'>" .$id_proyecto_persona_forma_pago ."</span>");
    }
    /**/
    function comentario_notificacion_pago_POST(){
        
        $param =  $this->post();    
        $param["id_usuario"] =  $this->id_usuario;        
        $response =  $this->cobranzamodel->registra_comentario_pago_notificado($param);
        $this->response($response);        
    }
    /**/
    function form_comentario_notificacion_pago_GET(){
        $this->load->view("pagos_notificados/comentarios_pago");
    }
    /**/
    function get_notificacion_pago($q){

        $api =  "notificacion_pago/pago_resumen/format/json/";
        return $this->principal->api( $api , $q);
    }
    /**/
    function notificacion_pago_GET(){

        $param            =  $this->get();        
        $info_notificados =  $this->get_notificacion_pago($param); 

        $comentarios =  
        $this->cobranzamodel->get_comentarios_por_pago_notificado($param);

        $data_complete["ficha"] =  get_ficha_pago($info_notificados , $comentarios);        
        
        $data_complete["info_pago_notificado"] = $info_notificados;        
        /**/
        $id_proyecto_persona_forma_pago =  $info_notificados[0]["num_recibo"];
        /**/
        $id_servicio = $this->cobranzamodel->get_id_servicio_por_ppfp($id_proyecto_persona_forma_pago);
        $data_complete["id_servicio"] = $id_servicio;
        /*Carga info pago pendiente*/
        $id_proyecto_persona=  
        $this->cobranzamodel->get_id_proyecto_servicio_por_ppfp($id_proyecto_persona_forma_pago);
        $data_complete["id_proyecto_persona"] = $id_proyecto_persona;

        $this->response($data_complete);        
    }
    function verifica_pago_notificado($q){
        
        $api =  "notificacion_pago/es_notificado/format/json/";
        return  $this->principal->api( $api ,$q);
    }
    /**/
    function info_saldo_pendiente_GET(){

        $param =  $this->get();      
        $info_saldo_pendiente = 
        $this->cobranzamodel->get_monto_pendiente_proyecto_persona_forma_pago($param);

        $data_complete["info_pago_pendiente"] =  $info_saldo_pendiente;
        $data_complete["resultados"] =  count($info_saldo_pendiente);

        $data_complete["resultado_notificado"] = $this->verifica_pago_notificado($param);

        if (count($info_saldo_pendiente) > 0 ) {
            
            $id_proyecto_persona_forma_pago = $param["recibo"];
            /**/
            $data_complete["id_servicio"] 
            = 
            $this->cobranzamodel->get_id_servicio_por_ppfp($id_proyecto_persona_forma_pago);            
            /**/
            $param["id_recibo"] = $id_proyecto_persona_forma_pago;
            $data_complete["data_servicio"] = $this->carga_servicio_por_recibo($param);
        }        
        $this->response($data_complete);
        
    }
    /**/
    function carga_servicio_por_recibo($q){
        $api = "tickets/servicio_recibo/format/json/"; 
        return $this->principal->api( $api , $q);
    }
    /**/
    function get_precio_id_servicio($id_servicio){

        $q["id_servicio"] = $id_servicio;
        $api              = "recibo/precio_servicio/format/json/"; 
        return $this->principal->api( $api , $q);   
    }
    /**/
    function solicitud_proceso_pago_POST(){

        $param          =  $this->post();               
        //debug($param , 1); 
        $id_servicio    =  $param["plan"]; 
        $precio         =  $this->get_precio_id_servicio($id_servicio);

    
        $data_complete  = [];
        $data_orden     = [];
        $data_reporte_compra = [];
        $data_reporte_compra["articulo_valido"] = 0;
        /*Si el plan existe y es disponible continuamos*/
        if(count($precio) > 0){  


            $data_reporte_compra["articulo_valido"] = 1;      
            /*ahora consultamos que el servicio se encuentre disponible para compra*/
            $prm["id_servicio"]             =  $id_servicio;      
            $prm["articulos_solicitados"]   =  $param["num_ciclos"];
            $info_existencia                =  $this->consulta_disponibilidad_servicio($prm);


            $data_orden["existencia"]       =  $info_existencia;            
            $data_reporte_compra["articulo_disponible"] = 0;
            $data_reporte_compra["existencia"] = $info_existencia;
            /*Si se encuentra en existencia, continuamos*/                

            if($info_existencia["en_existencia"] == 1){     
                


                $new_precio =  $precio[0];
                $data_reporte_compra["articulo_disponible"] = 1;
                $data_orden["id_ciclo_facturacion"]         = $new_precio["id_ciclo_facturacion"];
                $data_orden["precio"]                       = $new_precio["precio"];
                $data_orden["existencia"]                   = $info_existencia;
                /**/
                
                $data_orden["servicio"] = $info_existencia["info_servicio"][0];                
                /*Consultamos el precio de envio del producto*/                
                
                if($data_orden["servicio"]["flag_servicio"]== 0){
                    $prm_envio["flag_envio_gratis"] = $data_orden["servicio"]["flag_envio_gratis"];
                    $data_orden["costo_envio"] = $this->get_costo_envio($prm_envio);        
                }
                
                
                $data_orden["es_usuario_nuevo"] = 1;
                $es_usuario_nuevo               =  get_info_usuario_valor_variable($param , "usuario_nuevo" ); 

            
                if($es_usuario_nuevo == 0){            
                    $data_orden["id_usuario"]       = $this->id_usuario;
                    $data_orden["es_usuario_nuevo"] =  0;

                }else{
                    $data_orden["id_usuario"]       = $param["id_usuario"];                    
                }
                
                $data_orden["data_por_usuario"]     =  $param;
                $data_orden["talla"]                =  
                (array_key_exists("talla", $param)&& $param["talla"]>0) ? $param["talla"]: 0;
                
                
                $id_recibo        = $this->genera_orden_compra($data_orden);                
                
                $q["id_servicio"] = $id_servicio;
                $q["valor"]       = 2;
                $this->gamificacion_deseo($q);            
                $data_acciones_posteriores["id_recibo"] =  $id_recibo;


                $data_acciones_posteriores["id_usuario_venta"] = $data_orden["servicio"]["id_usuario_venta"];
                $data_acciones_posteriores["id_servicio"] = $param["plan"];
                
                if($es_usuario_nuevo == 0){
                      $data_acciones_posteriores["id_usuario"] = $data_orden["id_usuario"];
                  }else{

                      $data_acciones_posteriores["id_usuario"]  =   $param["id_usuario"];  
                      $data_acciones_posteriores["telefono"]    =   $param["telefono"];  
                      $data_acciones_posteriores["nombre"]      =   $param["nombre"];  
                      $data_acciones_posteriores["email"]       =   $param["email"];

                }
                
                $data_acciones_posteriores["es_usuario_nuevo"] =  $es_usuario_nuevo;
                $this->acciones_posterior_orden_pago($data_acciones_posteriores);
                $data_orden["ficha"]                           = 
                $this->carga_ficha_direccion_envio($data_acciones_posteriores);        
            }

        }        
        

        $this->response($data_orden);    
    }
    function primer_orden_POST(){
        
        $param  =  $this->post();

        if( array_key_exists("num_ciclos", $param) && ctype_digit($param["num_ciclos"]) 
            && $param["num_ciclos"] >0 && array_key_exists("ciclo_facturacion", $param)
            && $param["num_ciclos"] >0 && $param["num_ciclos"] < 10 && 
            ctype_digit($param["plan"]) 
            && $param["plan"] >0 
        ){

                   
            $usuario = $this->crea_usuario($param);
            
            if ($usuario["usuario_registrado"] ==  1 && $usuario["id_usuario"]>0 ) {
                
                
                $param["es_usuario_nuevo"]    = 1;
                $param["usuario_nuevo"]       = 1;        
                $param["usuario_referencia"]  = $usuario["id_usuario"];
                $param["id_usuario"]          = $usuario["id_usuario"];                                       
                $orden_compra                 = $this->crea_orden($param); 
                $orden_compra["usuario_existe"]   = 0;
                $this->response($orden_compra);
            }            
            $this->response($usuario);
            
        }else{
            $this->response(-1);
        }
    }    
    function crea_orden($q){

        $api =  "cobranza/solicitud_proceso_pago";
        return $this->principal->api( $api , $q, "json", "POST");        
    }
    /**/
    function crea_usuario($q){

        $api =  "usuario/prospecto";
        return $this->principal->api( $api , $q, "json", "POST");
    }
    private function gamificacion_deseo($q){

        $api = "servicio/gamificacion_deseo"; 
        return $this->principal->api( $api , $q , "json" , "PUT");
    }
    /*aquí creamos en base de datos*/
    private function genera_orden_compra($q){            
        $api    =  "recibo/orden_de_compra";    
        return  $this->principal->api( $api, $q , "json" , "POST");
    }
    /**/
    function consulta_disponibilidad_servicio($q){     
        $api = "servicio/info_disponibilidad_servicio/format/json/"; 
        return $this->principal->api( $api , $q);
    }
    /**/
    function acciones_posterior_orden_pago($param){        
        $this->notifica_deuda_cliente($param);                   
        $this->crea_comentario_pedido($param);                    
    }
    /**/
    function valida_envio_notificacion_nuevo_usuario($param){
        if(get_info_usuario_valor_variable($param , "usuario_nuevo" )>0){
            $this->notifica_registro_usuario($param);      
        }
    }
    /**/
    function notifica_registro_usuario($param){       
        $api = "emp/solicitud_usuario"; 
        return $this->principal->api($api , $q);  
    }    
    /**/
    function carga_ficha_direccion_envio($q){

        $q["text_direccion"]    =  "Dirección de Envio";
        $q["externo"]           =  1;        
        $api                    = "usuario_direccion/direccion_envio_pedido"; 
        return $this->principal->api( $api , $q , "html");  

    }
    /**/
    function crea_comentario_pedido($param){

        $data_send["id_usuario"] =  $param["id_usuario"];            
        $data_send["id_usuario_venta"] =  $param["id_usuario_venta"];
        $data_send["id_servicio"] =  $param["id_servicio"];

        if(get_info_usuario_valor_variable($param , "es_usuario_nuevo" )>0){                     
                        
            $comentario = $param["nombre"]." - ".$param["email"]." - ".$param["telefono"]." 
                                    está interesado en comprar, 
                                    cuando haya realizado su compra 
                                    serás notificado(a)";
                
            $data_send["comentario"]= $comentario;

        }else{
            $text ="Está interesado(a) en comprar, 
                cuando haya realizado su compra seras notificado(a)";
            $data_send["comentario"]= $text;

        }
            

        $api = "comentario/comentario_pedido"; 
        return $this->principal->api( $api ,$data_send);  
        
    }
    /**/
    function notifica_deuda_cliente($q){

        $api = "areacliente/pago_pendiente_web/format/json/"; 
        return $this->principal->api( $api ,$q);  
    }   
    /**/
    function agrega_data_cliente($data){

        $nueva_data = [];
        $x =0;
        foreach($data as $row){
            
            $nueva_data[$x] =  $row;
            $nueva_data[$x]["cliente"] = 
            $this->principal->get_info_usuario($row["id_usuario"]);  
            $x ++;
        }
        return $nueva_data;
    }    
    /**/    
    function resumen_pendientes_persona_GET(){
        
        $param =  $this->get(); 
        $param["id_usuario"] = $this->id_usuario;
        
        $data["saldos_pendientes"] = 
        $this->cobranzamodel->get_saldos_pendientes_usuario($param);        
        $this->load->view("cobranza/principal_persona", $data);
        
    }
    /**/
    function resumen_realizados_persona_GET(){        
        
        $param =  $this->get();                    
        $param["id_usuario"] = $this->id_usuario;
        $saldos =  $this->cobranzamodel->get_saldos_realizados_usuario($param);        
        $saldos =  $this->agrega_estatus_enid_service($saldos);        
        $data["saldos_pendientes"] = $saldos;
        $this->load->view("cobranza/principal_persona_realizados", $data);        
    }   
    function agrega_estatus_enid_service($saldos){
        
        $nueva_data = [];
        $a =0;
        foreach($saldos as $row){
            $nueva_data[$a] =  $row;
            $prm["id_estatus"] = $row["status"];
            $nueva_data[$a]["estatus_enid_service"]= 
            $this->get_estatus_enid_service($prm);
            $a++;

        }
        return $nueva_data;
    }
    /**/
    function get_estatus_enid_service($q){        
        $api = "servicio/nombre_estado_enid/format/json/";
        return $this->principal->api( $api ,  $q);
    } 
    /**/
    function resumen_num_pendientes_GET(){

        $param =  $this->get();  
        /**/
        $param["id_usuario"] =  $this->id_usuario;
        $num_pendientes  = 
        $this->cobranzamodel->get_num_saldos_pendientes($param);        
        $this->response($num_pendientes);
    }
    /**/
     function resumen_num_pendientes_persona_GET(){
        $param              =  $this->get();                        
        $num_pendientes     = 
        $this->cobranzamodel->get_num_saldos_pendientes_persona($param);        
        $new_response       = "";        
        if ($num_pendientes >0){

            $new_response = "<span class='alerta_llamadas_agendadas'>
                                ".$num_pendientes.icon('fa fa-usd')."                                
                                
                            </span>";
        }
        
        $this->response($new_response);
    }
    /**/
    
    /**/
    function simulamos_datos_creacion_proyecto_maps($param){

        $param["proyecto"]  ="Registro o renovación de Negocio en Google MAPS";      
        $param["url"] = "";
        $param["id_servicio"]=  $param["servicio"];        
        return  $param;
    }    
    /**/
    private function set_option($key, $value){
        $this->option[$key] = $value;
    }
    /**/
    private function get_option($key){
        return $this->option[$key];
    }    
    function comision_GET(){
        $param =  $this->get();     
        $this->response(7);
    }
    /**/
    function recibo_por_pagar_GET(){

        $param = $this->get();
        $data_respose =  $this->cobranzamodel->valida_recibo_por_pagar($param);
        $this->response(crea_data_deuda_pendiente($data_respose) );
    }
    function recibo_por_enviar_usuario_GET()
    {
        $param = $this->get();
        $data_respose =  $this->cobranzamodel->valida_recibo_por_enviar_usuario($param);
        $this->response(crea_data_deuda_pendiente($data_respose) );   
    }
    /*
    function ticket_pendiente_pago($param , $recibo , $data_complete){

        $id_usuario =  $recibo[0]["id_usuario"];               
        
        if (get_info_usuario_valor_variable($param , "cobranza") ==  1){

            $data_complete["costo_envio_sistema"]   =  $this->get_costo_envio($recibo[0]);




            $data_complete["id_recibo"]             =   $param["id_recibo"];
            $id_usuario_venta                       =   $recibo[0]["id_usuario_venta"];
            $data_complete["id_usuario_venta"]      =   $id_usuario_venta; 
            $informacion_envio                      =   $this->get_direccion_pedido($param["id_recibo"]);
            $data_complete["informacion_envio"]     =   $informacion_envio;
            $this->load->view("cobranza/pago_al_momento" , $data_complete);    


        }else{            
            
            $data_complete["usuario"]             =  
            $this->principal->get_info_usuario($id_usuario);
            $data_complete["costo_envio_sistema"] =  $this->get_costo_envio($recibo[0]);  
            
            $this->load->view("cobranza/resumen_no_aplica" , $data_complete);    
        }
               
    }
    */
    /**/
    function ganancias_fecha_GET(){
        
        $param =  $this->get();
        $num_ventas =  $this->cobranzamodel->get_ventas_dia($param);
        $this->response($num_ventas);
    }
    /*
    function solicitudes_fecha_GET(){
        
        $param      =  $this->get();
        $num_ventas =  $this->cobranzamodel->get_solicitudes_venta_dia($param);
        $this->response($num_ventas);
    } 
    */   
    /**/
    private function get_direccion_pedido($id_recibo){
            
        $q["id_recibo"]     = $id_recibo;
        $api                = "portafolio/direccion_pedido/format/json/";
        return $this->principal->api( $api ,  $q);    
    }
    

}?>