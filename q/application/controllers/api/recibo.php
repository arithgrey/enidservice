<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class recibo extends REST_Controller{    
    private $id_usuario;     
    function __construct(){
        parent::__construct();          
        $this->load->model("recibo_model");        
        $this->load->helper("recibo");
        $this->load->library('table');       
        $this->load->library(lib_def());                    
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
    function saldo_POST(){

        $param     = $this->post();
        $response  = false;
        if(if_ext($param , "id_usuario")){
            $response =  $this->recibo_model->get_saldo_usuario($param);
        }
        $this->response($response);
    }
    /*
    function en_proceso_GET(){
        $param =  $this->get();
        $response =  $this->recibo_model->carga_actividad_pendiente($param);        
        $this->response($response);
    } 
    function verifica_anteriores_GET(){        
        $param =  $this->get();        
        $response = $this->tickets_model->num_compras_efectivas_usuario($param);        
        $this->response($response);        
    }    
    */
    function cancelar_envio_recordatorio_PUT(){

        $param      =   $this->put();
        $response   =   false;
        if (if_ext($param, "id")){
            $id         = $param["id"];
            $response = $this->recibo_model->q_up("cancela_email" , 1, $id);
        }
        $this->response($response);
    }
    function servicio_ppfp_GET(){
        
        $param          =   $this->get();
        $response       =   false;
        if (if_ext($param , "id_recibo")){

            $response    =   $this->recibo_model->q_get(["id_servicio"], $param["id_recibo"])[0]["id_servicio"];
        }
        $this->response($response);
    }

    function saldo_pendiente_recibo_GET(){

        $param          =   $this->get();
        $response       =   false;
        if(if_ext($param , "id_recibo")){
            $response   =   $this->get_saldo_pendiente_recibo($param);
        }
        $this->response($response);
    }    
    function get_saldo_pendiente_recibo($param){

        $response       =   
        $this->recibo_model->q_get(
            [
                "monto_a_pagar",
                "num_ciclos_contratados", 
                "flag_envio_gratis"
            ], 
            $param["id_recibo"]);        
        $monto_a_pagar              =   $response[0]["monto_a_pagar"]; 
        $num_ciclos_contratados     =   $response[0]["num_ciclos_contratados"]; 

        $costo_envio    =   get_costo_envio($response[0]);
        $total          =   
        ($monto_a_pagar * $num_ciclos_contratados) + 
        $costo_envio["costo_envio_cliente"];
        return $total;
    }
    function orden_de_compra_POST(){

        $param      =   $this->post();
        $response   =   false;
        if (if_ext($param, "id_usuario,id_ciclo_facturacion,talla") ){
            $response   =  $this->recibo_model->crea_orden_de_compra($param);
        }
        $this->response($response);
    }
    function precio_servicio_GET(){

        $param      =   $this->get();
        $response   =   false;
        if(if_ext($param, "id_servicio")){
            $response   =  $this->recibo_model->get_precio_servicio($param);
        }
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
        return  $this->principal->api( $api , $q);        
    }
    function get_estatus_enid_service($q){

        $api =  "status_enid_service/index/format/json/";
        return  $this->principal->api( $api , $q);        
    }        
    function proyecto_persona_info_GET(){        
                
        $param                              =   $this->get();
        $response                           =   false;
        if (if_ext($param , "modalidad")){
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
            $data["numero_articulos_en_venta"]  = 0;
            if($param["modalidad"] == 1){
                $data["numero_articulos_en_venta"] = $this->carga_productos_en_venta($param);
            }
            $data["status"]      =   $param["status"];
            $data["anteriores"]  =   $this->recibo_model->num_compras_efectivas_usuario($param);

            $this->load->view("proyecto/lista_version_cliente" , $data);
        }else{
            $this->response($response);
        }

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
    /*
    function verifica_anteriores($q){

        $api        =  "tickets/verifica_anteriores/format/json/";
        return       $this->principal->api($api, $q);
    }
    */
    private function en_proceso($q){            
        return $this->recibo_model->carga_actividad_pendiente($q);            
    }    
    private function carga_productos_en_venta($q){
        $api        =  "servicio/num_venta_usuario/format/json/";
        return       $this->principal->api( $api, $q);     
    }
    function resumen_desglose_pago_GET(){
        
        $param      =  $this->get();
        $response   = false;
        if (if_ext($param , "id_recibo")){
            $recibo     =  $this->recibo_model->q_get([],  $param["id_recibo"] );
            if(count($recibo) >0 ){

                $monto_a_pagar                  =   $recibo[0]["monto_a_pagar"];
                $saldo_cubierto                 =   $recibo[0]["saldo_cubierto"];
                $data_complete["url_request"]   =   get_url_request("");
                $data_complete["recibo"]        =   $recibo;
                $id_servicio                    =   $recibo[0]["id_servicio"];

                /*Validamos que exista un monto por pagar*/
                $data_complete["servicio"]      = $this->principal->get_base_servicio($id_servicio);

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
            }
        }else{
            $this->response($response);
        }
    }      

    function ticket_pendiente_pago($param , $recibo , $data_complete){

        $id_usuario =  $recibo[0]["id_usuario"];               
        $data_complete["costo_envio_sistema"]  =  get_costo_envio($recibo[0]);                
        if ($recibo[0]["tipo_entrega"] ==  1) {

           $this->ticket_pendiente_pago_contra_entrega($param , $recibo , $data_complete );

        }else{

            if (get_info_usuario_valor_variable($param , "cobranza") ==  1){


                $data_complete  = $this->get_data_saldo($param, $recibo , $data_complete );
                $this->load->view("cobranza/pago_al_momento" , $data_complete);    

            }else{            
                
                $data_complete["usuario"]             =     $this->principal->get_info_usuario($id_usuario);
                $data_complete["costo_envio_sistema"] =     get_costo_envio($recibo[0]);
                $this->load->view("cobranza/resumen_no_aplica" , $data_complete);    
            }

        }
                       
    }
    private function get_data_saldo($param, $recibo , $data_complete ){

        /*Cargamos el saldo que tiene la persona*/
        $data_complete["id_recibo"]                 =   $param["id_recibo"];
        $id_usuario_venta                           =   $recibo[0]["id_usuario_venta"];
        $data_complete["id_usuario_venta"]          =   $id_usuario_venta;
        $direccion                                  =   $this->get_direccion_pedido($param["id_recibo"]);
        $data_complete["informacion_envio"]         =   [];
        if (count($direccion) > 0 ) {
            $id_direccion                           =   $direccion[0]["id_direccion"];
            $data_complete["informacion_envio"]     =   $this->get_direccion_por_id($id_direccion);
        }
        return $data_complete;
    }
    function ticket_pendiente_pago_contra_entrega($param , $recibo , $data_complete){

        $id_recibo =  $param["id_recibo"];


        /*Cuando se puede pagar al momento*/
        if (get_info_usuario_valor_variable($param , "cobranza") ==  1){
            
            /*Cuando no se ha entregado y no está cancelado*/
            if ($recibo[0]["entregado"] == 0 && $recibo[0]["se_cancela"] == 0) {
                /*Muestro la fecha de entrega acordada más el recordatorio y las forma de pago*/           
                
                $id_punto_encuentro                     =  $this->get_punto_encuentro_recibo($id_recibo);
                $data_complete["punto_encuentro"]       =  $this->get_punto_encuentro($id_punto_encuentro);
                $this->load->view("cobranza/pago_al_momento" , $data_complete);
            }
        }else{
            
            $id_usuario                           = $recibo[0]["id_usuario"]; 
            $data_complete["usuario"]             = $this->principal->get_info_usuario($id_usuario);
            //$data_complete["costo_envio_sistema"] =  get_costo_envio($recibo[0]);
            $this->load->view("cobranza/resumen_no_aplica" , $data_complete);    
        }
    }
    function pedidos_GET(){

        $param      = $this->get();
        $response   = [];
        if (if_ext($param , "fecha_inicio,fecha_termino,tipo_entrega,recibo,v")) {

            $params   =  [
                "p.id_proyecto_persona_forma_pago recibo" ,
                "p.saldo_cubierto" ,
                "p.fecha_registro" ,
                "p.monto_a_pagar" ,
                "p.num_ciclos_contratados",
                "p.cancela_cliente",
                "p.se_cancela",
                "p.status",
                "p.fecha_contra_entrega",
                "p.tipo_entrega",
                "p.fecha_entrega",
                "p.costo_envio_cliente",
                "p.id_servicio",
                "p.fecha_cancelacion",
                "p.fecha_pago"
            ];
            if ($param["recibo"] > 0) {
                /*Busqueda por número recibo*/
                $params   =  [
                    "id_proyecto_persona_forma_pago recibo" ,
                    "saldo_cubierto" ,
                    "fecha_registro" ,
                    "monto_a_pagar" ,
                    "num_ciclos_contratados",
                    "cancela_cliente",
                    "se_cancela",
                    "status",
                    "fecha_contra_entrega",
                    "tipo_entrega",
                    "fecha_entrega",
                    "costo_envio_cliente",
                    "id_servicio",
                    "fecha_cancelacion",
                    "fecha_pago"
                ];
                $response =  $this->recibo_model->q_get($params, $param["recibo"]);

            }else{


                $response =  $this->recibo_model->get_q($params , $param);
            }
            if ($param["v"] ==  1) {
                /*cargo vista*/
                $response =  create_resumen_pedidos($response , $this->get_estatus_enid_service($param) , $param);

            }

        }
        $this->response($response);

    }
    function fecha_entrega_PUT(){

        $param      = $this->put();
        $response   = false;
        if(if_ext($param, "fecha_entrega,horario_entrega,recibo")){

            $fecha_contra_entrega   =   $param["fecha_entrega"]." ".$param["horario_entrega"].":00";
            $id_recibo              =   $param["recibo"];
            $response               =   $this->recibo_model->q_up("fecha_contra_entrega" , $fecha_contra_entrega , $id_recibo);
        }
        $this->response($response);

    }
    function compras_efectivas_GET(){        
        
        $param                  =   $this->get();
        $param["id_usuario"]    =   $this->id_usuario;
        $data_complete["total"] =   $this->recibo_model->total_compras_ventas_efectivas_usuario($param);
        if($data_complete["total"] > 0 ){
            $data_complete["compras"] = $this->recibo_model->compras_ventas_efectivas_usuario($param);
        }
        $this->response($data_complete);  
    }
    function recibo_por_pagar_usuario_GET(){

        $param          =   $this->get();
        $respose        =   false;
        if (if_ext($param, "id_recibo")){
            $respose        =   $this->recibo_model->valida_recibo_por_pagar_usuario($param);
            $respose        =   crea_data_deuda_pendiente($respose);
        }
        $this->response($respose);
    }

    function cancelar_PUT(){

        $param      =  $this->put();
        $response   = false;
        if (if_ext($param, "id_recibo")){
            $respose =  $this->recibo_model->cancela_orden_compra($param);
        }
        $this->response($respose);
        
    }
    function deuda_cliente_GET(){

        $param      = $this->get();
        $response   = false;
        if (if_ext($param , "id_usuario")){
            $response   = $this->recibo_model->get_adeudo_cliente($param);
        }
        $this->response($response);
    }
    private function get_direccion_pedido($id_recibo){
            
        $q["id_recibo"]     = $id_recibo;
        $api                = "proyecto_persona_forma_pago_direccion/recibo/format/json/";
        return $this->principal->api( $api ,  $q);    
    }
    private function get_direccion_por_id($id_direccion){
            
        $q["id_direccion"] = $id_direccion;
        $api               = "direccion/data_direccion/format/json/";
        return $this->principal->api( $api ,  $q);    
    }
    private function get_punto_encuentro_recibo($id_recibo){

        $q["id_recibo"]     = $id_recibo;
        $api                = 
        "proyecto_persona_forma_pago_punto_encuentro/punto_encuentro_recibo/format/json/";
        return $this->principal->api( $api ,  $q)[0]["id_punto_encuentro"];       
    }
    private function get_punto_encuentro($id_punto_encuentro){
        
        $q["id"]            = $id_punto_encuentro;
        $api                = "punto_encuentro/id/format/json/";
        return $this->principal->api( $api ,  $q);          
    }
    function dia_GET(){
        
        $param      = $this->get();
        $response   = [];
        if(if_ext($param , 'fecha')){
            if ($param["fecha"] ==  1) {            
                $param["fecha"] =  date("Y-m-d");                
            }
            $response   = $this->recibo_model->get_dia($param);        
            
        }
        $this->response($response);                
    }
    function id_GET(){

        $param      =  $this->get();     
        $response   =  [];
        if (if_ext($param , "id")) {
            
            $id_recibo = $param["id"];    
            $response  = $this->recibo_model->q_get([] , $id_recibo);
        }
        $this->response($response);
    }
    function saldo_cubierto_PUT(){

        $param      = $this->put();
        $response   = [];
        if (if_ext($param , "saldo_cubierto,recibo")) {
            $response = $this->set_saldo_cubierto($param);
        }
        $this->response($response);
    }
    private function set_saldo_cubierto($param){

        $param["id_recibo"] =   $param["recibo"];
        $pago_pendiente     =   $this->get_saldo_pendiente_recibo($param);
        $response           =   "INGRESA UN MONTO CORRECTO SALDO POR LIQUIDAR ".$pago_pendiente."MXN";
        if ($param["saldo_cubierto"] > 0 && $param["saldo_cubierto"] >= $pago_pendiente || ( $pago_pendiente - $param["saldo_cubierto"] ) < 101){

            $response =  $this->recibo_model->set_status_orden( $param["saldo_cubierto"] , 1 , $param["recibo"] , 'fecha_pago');

        }
        return $response;
    }
    function status_PUT(){

        $param      = $this->put();
        if (array_key_exists("cancelacion", $param)) {
            $this->response($this->set_cancelacion($param));
        }
        if (array_key_exists("es_proceso_compra", $param) && $param["es_proceso_compra"] ==  1) {
            $this->response($this->set_default_orden($param));
        }
        $response   = false;
        if (if_ext($param , "saldo_cubierto,recibo,status")) {
            $this->response($this->set_status($param) );
        }else{
            $this->response($response);
        }

    }
    private function set_status($param){
        $param["id_recibo"] =   $param["recibo"];
        $pago_pendiente     =   $this->get_saldo_pendiente_recibo($param);
        $response           =   "INGRESA UN MONTO CORRECTO SALDO POR LIQUIDAR ".$pago_pendiente."MXN";

        if ($param["saldo_cubierto"] > 0 && $param["saldo_cubierto"] >= $pago_pendiente || ( $pago_pendiente - $param["saldo_cubierto"] ) < 101){

            $response =  $this->recibo_model->set_status_orden($param["saldo_cubierto"] , $param["status"] , $param["recibo"] , 'fecha_entrega');
        }
        return $response;
    }
    function set_cancelacion($param){
        
        $response   =  [];
        
        if (if_ext($param , "status,tipificacion,recibo")) {

            $response =  $this->recibo_model->set_status_orden( 0 , $param["status"] , $param["recibo"] , 'fecha_cancelacion');
            if ($response ==  true) {
                $response   =  $this->add_tipificacion($param);
            }
        }
        return $response;    
    }
    function tipo_entrega_PUT(){

        $param      =   $this->put();
        $response   =   [];
        if(if_ext($param , "recibo,tipo_entrega")){

            $tipo_entrega   =   $param["tipo_entrega"];
            $id_recibo      =   $param["recibo"];
            $response       =   $this->recibo_model->q_up("tipo_entrega" , $tipo_entrega , $id_recibo);

            if ($response == true) {
                $param["tipificacion"] =  31;
                $this->add_tipificacion($param);
            }
        }
        $this->response($response);

    }
    function set_default_orden($param){
        $response   =  [];
        
        if (if_ext($param , "status,recibo")) {

            $params     =  [                            
                "status"            => $param["status"], 
                "saldo_cubierto"    => 0
            ];
                    
            $in =  ["id_proyecto_persona_forma_pago" => $param["recibo"]];
            $response =  $this->recibo_model->update($params , $in );       
            if ($response ==  true) {

                $param["tipificacion"] =  32;
                $response   =  $this->add_tipificacion($param);
            }
        }
        return $response;       
    }
    private  function add_tipificacion($q){
        $api =  "tipificacion_recibo/index";        
        return  $this->principal->api( $api , $q, "json" ,"POST");             
    }
    function notificacion_pago_PUT(){
        
        $param      =  $this->put();
        $response   =  false;
        if (if_ext($param , "recibo")) {
            $response =  $this->recibo_model->q_up("notificacion_pago" , 1 , $param["recibo"]);
        }
        $this->response($response);
    }
    function compras_GET(){

        $param    =      $this->get();
        $response =      false;
        if(if_ext($param , "fecha_inicio,fecha_termino,tipo")){
            $response                       =  $this->recibo_model->get_compras_tipo_periodo($param);
            $data["compras"]                =  $response;
            $data["tipo"]                   =  $param["tipo"];
            $data["status_enid_service"]    =  $this->get_status_enid_service();

            $v     =  $param["v"];
            if ($v == 1 ) {
                return  $this->load->view("ventas/compras" , $data);
            }
        }
        $this->response($response);



    }
    private function get_status_enid_service($q=[]){
        $api    =  "status_enid_service/index/format/json/";
        return $this->principal->api( $api , $q );
    }
    function solicitudes_periodo_servicio_GET(){
        $param      = $this->get();
        $response   = false;
        if(if_ext($param , "id_servicio")){

            $response =  $this->recibo_model->get_solicitudes_periodo_servicio($param["id_servicio"]);
        }
        $this->response($response);
    }

}