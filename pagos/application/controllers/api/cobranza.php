<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
require 'Request.php';
class Cobranza extends REST_Controller{      
    public $option; 
    function __construct(){
        parent::__construct();                          
        $this->load->helper("proyectos");            
        $this->load->model("cobranzamodel");     
        $this->load->library("restclient");                                    
        $this->load->library("sessionclass");            
    } 
    /**/
    function resumen_compras_usuario_GET(){        
        
        $param = $this->get(); 
        $data_complete = [];

        if($param["modalidad"] ==  1){
            $data_complete =  $this->cobranzamodel->get_ventas_usuario($param);
        }else{
            $data_complete =  $this->cobranzamodel->get_compras_usuario($param);                  
        }        
        $data_complete["status_enid_service"] = 
        $this->cobranzamodel->get_estatus_servicio_enid_service();        
        $this->response($data_complete);
    }
    /**/
    function calcula_costo_envio_GET(){
        /**/        
        $param =  $this->get();        
        $this->response($this->get_costo_envio($param));
    }
    /**/
    function get_costo_envio($param){
     
        $costo = get_costo_envio($param);
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

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");        
        $result = $this->restclient->get("cobranza/resumen_desglose_pago" , $q);        
        $response =  $result->response;        
        return $response;        
    }        
    /*Carga cuentas por */
    function cuentas_por_cobrar_GET(){

        $recibos =  $this->cobranzamodel->get_usuarios_deuda_pendiente();
                
        $nueva_data = [];
        $x = 0;
        foreach($recibos as $row){            
            
            $id_usuario =  $row["id_usuario"];
            $usuario =  $this->get_usuario($id_usuario);            
            $nueva_data[$x]["usuario"] = $usuario;
            $nueva_data[$x]["cuenta_por_cobrar"] = $row;
            
            $prm["id_recibo"] = $row["id_proyecto_persona_forma_pago"];
            $nueva_data[$x]["recibo"] =  $this->get_pago($prm);
            $x ++;
            
        }
        $this->response($nueva_data);
        /**/
    }

    /*
    function get_email_por_persona($id_persona){

        $correo =  $this->cobranzamodel->get_email_por_persona($id_persona);
        return $correo;
    } 
    */   
    /*
    function get_id_persona_por_proyecto_persona($id_proyecto_persona){

        $id_persona=  
        $this->cobranzamodel->get_id_persona_por_proyecto_persona($id_proyecto_persona);
        return $id_persona;
    } 
    */   

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
    function saldo_pendiente_recibo_GET(){

        $param =  $this->get();
        $db_response =  $this->cobranzamodel->get_saldo_pendiente_recibo($param);        
        $monto_a_pagar =  $db_response[0]["monto_a_pagar"]; 
        $costo_envio  = get_costo_envio($db_response[0]);
        $total =  $monto_a_pagar + $costo_envio["costo_envio_cliente"];
        $this->response($total);        
    }    
    /**/
    function valida_estado_pago_GET(){

        $param =  $this->get();
        $id_proyecto_persona_forma_pago= $param["id_proyecto_persona_forma_pago"];  
        $this->response("<span class='blue_enid white'>" .$id_proyecto_persona_forma_pago ."</span>");
    }
    /**/
    function comentario_notificacion_pago_POST(){

        /**/
        $param =  $this->post();    
        $param["id_usuario"] =  $this->sessionclass->getidusuario();        
        $db_response =  $this->cobranzamodel->registra_comentario_pago_notificado($param);
        $this->response($db_response);
        
    }
    /**/
    function form_comentario_notificacion_pago_GET(){
        $this->load->view("pagos_notificados/comentarios_pago");
    }
    /**/
    function notificacion_pago_PUT(){
        
        $param = $this->put();                
        $db_response = $this->cobranzamodel->actualiza_pago_notificado($param);       
        $this->response($db_response);    
    }
    /**/
    function notificacion_pago_GET(){

        /**/    
        $param =  $this->get();        
        $info_notificados =  $this->cobranzamodel->get_notificacion_pago($param); 

        $comentarios =  $this->cobranzamodel->get_comentarios_por_pago_notificado($param);

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
    /**/
    function info_saldo_pendiente_GET(){

        $param =  $this->get();      
        $info_saldo_pendiente = 
        $this->cobranzamodel->get_monto_pendiente_proyecto_persona_forma_pago($param);

        $data_complete["info_pago_pendiente"] =  $info_saldo_pendiente;
        $data_complete["resultados"] =  count($info_saldo_pendiente);

        $data_complete["resultado_notificado"] = 
        $this->cobranzamodel->verifica_pago_notificado($param);

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
    function carga_servicio_por_recibo($param){

        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("tickets/servicio_recibo/format/json/" , $param);        
        $response =  $result->response;        
        return json_decode($response , true);
    }
    /**/

    /**/
    function solicitud_proceso_pago_POST(){

        $param =  $this->post();                

        $id_servicio=  $param["plan"]; 
        $precio =   $this->cobranzamodel->get_precio_id_servicio($id_servicio);

        $data_complete = [];
        $data_orden = [];
        $data_reporte_compra = [];
        $data_reporte_compra["articulo_valido"] = 0;
        /*Si el plan existe y es disponible continuamos*/
        if(count($precio) > 0){  

            $data_reporte_compra["articulo_valido"] = 1;      
            /*ahora consultamos que el servicio se encuentre disponible para compra*/
            $prm["id_servicio"] =  $id_servicio;      
            $prm["articulos_solicitados"] =  $param["num_ciclos"];
            $info_existencia =  $this->consulta_disponibilidad_servicio($prm);
            $data_orden["existencia"] =  $info_existencia;
            

            $data_reporte_compra["articulo_disponible"] = 0;
            $data_reporte_compra["existencia"] = $info_existencia;
            /*Si se encuentra en existencia, continuamos*/                
            if($info_existencia["en_existencia"] == 1){     
                
                $data_reporte_compra["articulo_disponible"] = 1;
                $data_orden["id_ciclo_facturacion"] =  $precio[0]["id_ciclo_facturacion"];
                
                $data_orden["precio"] = $precio[0]["precio"];                                 
                $data_orden["existencia"] = $info_existencia;
                /**/
                
                $data_orden["servicio"] = $info_existencia["info_servicio"][0];
                
                    
                /*Consultamos el precio de envio del producto*/                
                
                if($data_orden["servicio"]["flag_servicio"]== 0){
                    /**/
                    $prm_envio["flag_envio_gratis"] = $data_orden["servicio"]["flag_envio_gratis"];
                    $data_orden["costo_envio"] = $this->get_costo_envio($prm_envio);        
                }
                
                $data_orden["es_usuario_nuevo"] = 1;
                $es_usuario_nuevo =  
                get_info_usuario_valor_variable($param , "usuario_nuevo" ); 

                if($es_usuario_nuevo == 0){            
                    $data_orden["id_usuario"] = $this->sessionclass->getidusuario();
                    $data_orden["es_usuario_nuevo"] =  0;
                }
                $data_orden["data_por_usuario"] =  $param;
                
                
                
                $data_acciones_posteriores["id_recibo"]
                =  $this->genera_orden_compra($data_orden);    
                
                

                $data_acciones_posteriores["id_usuario_venta"] = $data_orden["servicio"]["id_usuario_venta"];
                $data_acciones_posteriores["id_servicio"] = $param["plan"];
                
                if($es_usuario_nuevo == 0){
                      $data_acciones_posteriores["id_usuario"] = $data_orden["id_usuario"];
                  }else{
                      $data_acciones_posteriores["id_usuario"]=  $param["id_usuario"];  
                      $data_acciones_posteriores["telefono"]=  $param["telefono"];  
                      $data_acciones_posteriores["nombre"]=  $param["nombre"];  
                      $data_acciones_posteriores["email"] = $param["email"];
                }
                $data_acciones_posteriores["es_usuario_nuevo"] =  $es_usuario_nuevo;
                
                $this->acciones_posterior_orden_pago($data_acciones_posteriores);
                $data_orden["ficha"] = 
                $this->carga_ficha_direccion_envio($data_acciones_posteriores);        
                

                
            }

        }        
        
        $this->response($data_orden);    
    }
    /*aquí creamos en base de datos*/
    private function genera_orden_compra($param){
        return $this->cobranzamodel->crea_orden_de_compra($param);
    }
    /**/
    function consulta_disponibilidad_servicio($param){
        /**/        
        $url = "tag/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");          
        $result = 
        $this->restclient->get("producto/info_disponibilidad_servicio/format/json/" , $param);
        $response =  $result->response;
        return json_decode($response , true); 
    }
    /**/
    function acciones_posterior_orden_pago($param){
        /**/
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
        /**/        
        $url = "msj/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");          
        $result = $this->restclient->post("emp/solicitud_usuario" , $param);        
        $response =  $result->response;
        return $response;            
    }    
    /**/
    function carga_ficha_direccion_envio($param){

        $param["text_direccion"] =  "Dirección de Envio";
        $param["externo"]=  1;        
        $url = "portafolio/index.php/api/";    

        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "html");          
        $result = $this->restclient->get("portafolio/direccion_envio_pedido" , $param);     
        $response =  $result->response;        
        return $response;
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
        
        $url = "msj/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");          
        $result = $this->restclient->post("comentario/comentario_pedido" , $data_send);
        $response =  $result->response;
        return $response;
        
    }
    /**/
    function notifica_deuda_cliente($extra){
        
        $url = "msj/index.php/api/";    
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");          
        $result = $this->restclient->get("areacliente/pago_pendiente_web/format/json" , $extra);
        $response =  $result->response;
        return $response;          
    }   
    /**/
    function get_url_request_service(){
        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/"; 
        return  $url_request;
    }
    /**/   
    function get_usuario($id_usuario){

        $param["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/usuario_cobranza/format/json/" , $param);        
        $data =  $result->response;
        return json_decode($data , true);  
    } 
    /**/
    function resumen_desglose_pago_GET(){

        $param =  $this->get();                                                
        $recibo =  $this->cobranzamodel->get_info_recibo_por_id($param);        

        if(count($recibo) >0 ){            

            $monto_a_pagar =  $recibo[0]["monto_a_pagar"];
            $saldo_cubierto = $recibo[0]["saldo_cubierto"];
            /**/          
            $data_complete["url_request"] =  $this->get_url_request_service();                
            $data_complete["recibo"] =$recibo;             
            $id_servicio =  $recibo[0]["id_servicio"];  

            /*Validamos que exista un monto por pagar*/
            $data_complete["servicio"] = $this->get_servicio($id_servicio);

            if($monto_a_pagar > $saldo_cubierto ){                        
                /**/

                $id_usuario =  $recibo[0]["id_usuario"];               
                if (get_info_usuario_valor_variable($param , "cobranza") ==  1){                    
                    /*Aquí se da la opción de que la persona ya pague*/
                    $data_complete["costo_envio_sistema"] =  $this->get_costo_envio($recibo[0]);
                    /*Cargamos el saldo que tiene la persona*/
                    $data_complete["id_recibo"] = $param["id_recibo"];
                    $id_usuario_venta =  $recibo[0]["id_usuario_venta"];
                    $data_complete["id_usuario_venta"] =$id_usuario_venta; 
                    $data_complete["informacion_envio"] = 
                    $this->get_direccion_pedido($param["id_recibo"]);
                    $this->load->view("cobranza/pago_al_momento" , $data_complete);    

                }else{

                    $usuario  =  $this->get_usuario($id_usuario);
                    $data_complete["usuario"] =$usuario; 
                    $data_complete["costo_envio_sistema"] =  $this->get_costo_envio($recibo[0]);
                    /*Mostramos el resumen por correo*/
                    $this->load->view("cobranza/resumen_no_aplica" , $data_complete);    
                }
                

            }else{

                /**/
                $data_complete["recibo"] =$recibo;         
                $data_complete["id_recibo"]=  $param["id_recibo"];
                $data_complete["servicio"] = $this->get_servicio($id_servicio); 
                $id_usuario_venta =  $recibo[0]["id_usuario_venta"];
                $usuario  =  $this->get_usuario($id_usuario_venta);
                $data_complete["usuario_venta"] =$usuario; 
                $data_complete["modalidad"] =1;
                $this->load->view("cobranza/notificacion_pago_realizado" , $data_complete);  
                

            }
            /**/
        }


    }   
    /**/
    
    function agrega_data_cliente($data){

        $nueva_data = [];
        $x =0;
        foreach($data as $row){
            
            $nueva_data[$x] =  $row;
            $nueva_data[$x]["cliente"] = $this->get_info_usuario($row["id_usuario"]);  
            $x ++;


        }
        return $nueva_data;
    }
    /**/
    function get_info_usuario($id_usuario){

        $param["id_usuario"] =  $id_usuario;
        $url = "q/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("usuario/q/format/json/" , $param);        
        $data =  $result->response;
        return json_decode($data , true);  
    }
    /**/    
    function resumen_pendientes_persona_GET(){
        
        $param =  $this->get(); 
        $param["id_usuario"] = $this->sessionclass->getidusuario();
        
        $data["saldos_pendientes"] = 
            $this->cobranzamodel->get_saldos_pendientes_usuario($param);        
        $this->load->view("cobranza/principal_persona", $data);
        
    }
    /**/
    function resumen_realizados_persona_GET(){        
        
        $param =  $this->get();                    
        $param["id_usuario"] = $this->sessionclass->getidusuario();
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
            $nueva_data[$a]["estatus_enid_service"]= $this->get_estatus_enid_service($prm);
            $a++;

        }
        return $nueva_data;
    }
    /**/
    function get_estatus_enid_service($param){
        $url = "base/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("servicio/nombre_estado_enid/format/json/" , $param);        
        $data =  $result->response;
        return json_decode($data , true);  
    } 
    /**/
    function resumen_num_pendientes_GET(){

        $param =  $this->get();  
        /**/
        $param["id_usuario"] =  $this->sessionclass->getidusuario();
        $num_pendientes  = 
        $this->cobranzamodel->get_num_saldos_pendientes($param);        
        $this->response($num_pendientes);
    }
    /**/
     function resumen_num_pendientes_persona_GET(){
        $param =  $this->get();                
        /**/
        $num_pendientes  = 
        $this->cobranzamodel->get_num_saldos_pendientes_persona($param);
        /**/
        $new_response = "";        
        if ($num_pendientes >0){

            $new_response = "<span class='alerta_llamadas_agendadas'>
                                ".$num_pendientes."                                
                                <i class='fa fa-usd'>
                                </i>
                            </span>";
        }
        /**/   
        $this->response($new_response);
    }
    /**/
    function notifica_pago_usuario_POST(){
        $param =  $this->post();                
        $data["estado_registro"] =  $this->cobranzamodel->registra_pago_usuario($param);        
        //$this->load->view("cobranza/procesar_pago_recibo_usuario" , $data);    
        $this->response($data["estado_registro"]);
        /**/
    }  
    /**/
    function simulamos_datos_creacion_proyecto_maps($param){

        $param["proyecto"]  ="Registro o renovación de Negocio en Google MAPS";      
        $param["url"] = "";
        $param["id_servicio"]=  $param["servicio"];        
        return  $param;
    }
    /*
    function get_precio_venta($precio){

        $q["precio"] =  $precio;
        $url = "pagos/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("cobranza/calcula_precio_producto/format/json/" , $q);        
        $response =  $result->response;        
        return json_decode($response , true );        
    } 
    */  
    /**/
    private function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    /**/
    private function set_option($key, $value){
        $this->option[$key] = $value;
    }
    /**/
    private function get_option($key){
        return $this->option[$key];
    }
    private function get_servicio($id_servicio)
    {
       return  $this->cobranzamodel->get_servicio($id_servicio);
    }    
    /**/
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
    /**/
    function recibo_por_pagar_usuario_GET(){

        $param = $this->get();
        $data_respose =  $this->cobranzamodel->valida_recibo_por_pagar_usuario($param);
        $this->response(crea_data_deuda_pendiente($data_respose));
    }
    /**/
    function recibo_por_enviar_usuario_GET()
    {
        $param = $this->get();
        $data_respose =  $this->cobranzamodel->valida_recibo_por_enviar_usuario($param);
        $this->response(crea_data_deuda_pendiente($data_respose) );   
    }
    /**/
    private function get_direccion_pedido($id_recibo){
        $param["id_recibo"] = $id_recibo;
        $url = "portafolio/index.php/api/";         
        $url_request=  $this->get_url_request($url);
        $this->restclient->set_option('base_url', $url_request);
        $this->restclient->set_option('format', "json");        
        $result = $this->restclient->get("portafolio/direccion_pedido/format/json/" , $param);
        $response =  $result->response;        
        return json_decode($response , true);     
    }


}?>