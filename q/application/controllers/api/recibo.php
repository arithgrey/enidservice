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
    function compras_efectivas_GET(){

        $param                  =   $this->get();
        $param["id_usuario"]    =   $this->id_usuario;

        $response["total"]      =   $this->recibo_model->total_compras_ventas_efectivas_usuario($param);

        if($response["total"] > 0 ){
            $response["compras"] = $this->recibo_model->compras_ventas_efectivas_usuario($param);
        }
        $this->response($response);
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

            $modalidad                          =   $param["modalidad"];
            $id_usuario                         =   $this->id_usuario;
            $param["id_usuario"]                =   $id_usuario;
            $ordenes                            =   $this->recibo_model->get_compras_usuario($param , $modalidad);
            $response                           = "";
            if(count($ordenes) > 0 ){


                $data["id_usuario"]                 =   $id_usuario;
                $data["ordenes"]                    =   $this->agrega_estados_direcciones_a_pedidos($ordenes);
                $data["en_proceso"]                 =  $this->en_proceso($modalidad , $id_usuario);
                $data["numero_articulos_en_venta"]  = 0;
                if($param["modalidad"] == 1){
                    $data["numero_articulos_en_venta"] = $this->carga_productos_en_venta($param);
                }
                $data["status"]      =      $param["status"];
                $data["anteriores"]  =      $this->recibo_model->num_compras_efectivas_usuario($param);
                $data["modalidad"]   =      $modalidad;
                $data["status_enid_service"]    = $status_enid_service                =   $this->get_estatus_servicio_enid_service($param);
                $response                       = get_vista_cliente($data);

            }
        }
        $this->response($response);

    }
    function agrega_estados_direcciones_a_pedidos($ordenes_compra){

        $ordenes = [];
        $a =0;
        foreach($ordenes_compra as $row){

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
    private function en_proceso($modalidad , $id_usuario){

        $q["modalidad"]                   =  $modalidad;
        $q["id_usuario"]                  =  $id_usuario;
        return $this->recibo_model->carga_actividad_pendiente($q);            
    }    
    private function carga_productos_en_venta($q){
        $api        =  "servicio/num_venta_usuario/format/json/";
        return       $this->principal->api( $api, $q);     
    }
    function resumen_desglose_pago_GET(){
        
        $param      =   $this->get();
        $response   =   false;
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

                    $response =  $this->ticket_pendiente_pago($param , $recibo , $data_complete);

                }else{

                    $data_complete["recibo"]        =   $recibo;
                    $data_complete["id_recibo"]     =   $param["id_recibo"];
                    $data_complete["servicio"]      =   $this->principal->get_base_servicio($id_servicio);
                    $id_usuario_venta               =   $recibo[0]["id_usuario_venta"];
                    $usuario                        =   $this->principal->get_info_usuario($id_usuario_venta);
                    $data_complete["usuario_venta"] =   $usuario;
                    $data_complete["modalidad"]     =   1;
                    return $this->load->view("cobranza/notificacion_pago_realizado" , $data_complete);

                }
            }
        }
        $this->response($response);
    }      

    function ticket_pendiente_pago($param , $recibo , $data_complete){
        $response   = false;
        $id_usuario =  $recibo[0]["id_usuario"];               
        $data_complete["costo_envio_sistema"]  =  get_costo_envio($recibo[0]);                

        if ($recibo[0]["tipo_entrega"] ==  1) {

           return $this->ticket_pendiente_pago_contra_entrega($param , $recibo , $data_complete );

        }else{

            if (get_info_usuario_valor_variable($param , "cobranza") ==  1){


                $data_complete  = $this->get_data_saldo($param, $recibo , $data_complete );
                $data_complete["es_punto_encuentro"] = 0;
                $response = $this->get_mensaje_pago_al_memento($data_complete,$data_complete["costo_envio_sistema"]);

            }else{

                $usuario             =      $this->principal->get_info_usuario($id_usuario);
                $costo_envio_sistema =      get_costo_envio($recibo[0]);
                $response            =      $this->get_mensaje_no_aplica($recibo ,$costo_envio_sistema , $usuario , $data_complete);

            }
        }
        return $response;
                       
    }
    private function get_mensaje_pago_al_memento($data_complete , $costo_envio_sistema){


        $servicio               =   $data_complete["servicio"];
        $recibo                 =   $data_complete["recibo"];
        $url_request            =   $data_complete["url_request"];
        $recibo 				=  	$recibo[0];
        $saldo_cubierto  		=  	$recibo["saldo_cubierto"];
        $monto_a_pagar  		=  	$recibo["monto_a_pagar"];
        $id_recibo 				=  	$recibo["id_proyecto_persona_forma_pago"];
        $costo_envio_cliente 	=  	$recibo["costo_envio_cliente"];
        $id_usuario_venta  		=  	$recibo["id_usuario_venta"];
        $id_ciclo_facturacion	=  	$recibo["id_ciclo_facturacion"];
        $num_ciclos_contratados =  	$recibo["num_ciclos_contratados"];
        $id_servicio  			=  	$recibo["id_servicio"];
        $resumen_pedido  		=  	$recibo["resumen_pedido"];
        $servicio 				= 	$servicio[0];
        $flag_servicio 			=  	$servicio["flag_servicio"];
        $tipo_entrega      		= 	$recibo["tipo_entrega"];

        $deuda 					=   get_saldo_pendiente($monto_a_pagar, $num_ciclos_contratados, $saldo_cubierto, $costo_envio_cliente, $costo_envio_sistema, $tipo_entrega);
        $saldo_pendiente 		= 	$deuda["total_mas_envio"];
        $url_img_servicio 		=  	link_imagen_servicio($id_servicio);
        $data["recibo"] 		=	$recibo;
        $text_forma_compra 	    =   ($tipo_entrega) ?  "¿COMO  PAGAS TU ENTREGA?" : "Formas de pago";

        $text                   =   "";
        $pencuentro             =   ($tipo_entrega == 1 ) ? get_format_punto_encuentro($data_complete , $recibo ) : "";
        $text                  .=   $pencuentro;
        $text                   .=  heading_enid(icon("fa fa-credit-card") . $text_forma_compra , 3 , ["class" => 'top_20' ]);
        $text                   .=  getPayButtons($id_recibo , $url_request,$saldo_pendiente,$id_usuario_venta);




        if($data_complete["es_punto_encuentro"]  < 1 ){

            $informacion_envio =  $data_complete["informacion_envio"];
		    $text             .=    heading_enid("Dirección de envío" , 3);
		    $direccion         =    (count($informacion_envio) > 0 ) ?  format_direccion_envio($informacion_envio , $id_recibo , $recibo) : agregar_direccion_envio($id_recibo);
            $text             .=    $direccion;
        }

	    $text   .=  get_botones_seguimiento($id_recibo);
        $f      =   format_concepto($id_recibo, $resumen_pedido , $num_ciclos_contratados , $flag_servicio, $id_ciclo_facturacion , $saldo_pendiente , $url_img_servicio , $monto_a_pagar ,$deuda);
        $r      =   div($text,  ["class" => "col-lg-8"]);
        return div($r.$f , 1);

    }
    private function get_mensaje_no_aplica($recibo , $costo_envio_sistema , $usuario , $data_complete){



        $costo_envio_cliente_sistema    = $costo_envio_sistema["costo_envio_cliente"];
        $recibo                         = $recibo[0];
        $saldo_cubierto                 = $recibo["saldo_cubierto"];
        $fecha_registro                 = $recibo["fecha_registro"];

        $fecha_vencimiento              = $recibo["fecha_vencimiento"];
        $monto_a_pagar                  = $recibo["monto_a_pagar"];
        $id_proyecto_persona_forma_pago = $recibo["id_proyecto_persona_forma_pago"];
        $id_recibo                      = $id_proyecto_persona_forma_pago;
        $costo_envio_cliente            = $recibo["costo_envio_cliente"];
        $id_ciclo_facturacion           = $recibo["id_ciclo_facturacion"];
        $num_ciclos_contratados         = $recibo["num_ciclos_contratados"];
        $costo_envio_vendedor           = $recibo["costo_envio_vendedor"];
        $resumen_pedido                 = $recibo["resumen_pedido"];
        $usuario                        = $usuario[0];
        $id_usuario                     = $usuario["id_usuario"];
        $nombre                         = $usuario["nombre"];
        $apellido_paterno               = ($usuario["apellido_paterno"] !== null) ? $usuario["apellido_paterno"] : "";
        $apellido_materno               = ($usuario["apellido_materno"] !== null) ? $usuario["apellido_materno"] : "";

        $cliente                        = $nombre . " " . $apellido_paterno . " " . $apellido_materno;


        if ($costo_envio_cliente_sistema > $costo_envio_vendedor) {
            $costo_envio_cliente = $costo_envio_cliente_sistema;
        }
        $saldo_pendiente = ($monto_a_pagar * $num_ciclos_contratados) - $saldo_cubierto;


        $servicio                        = $data_complete["servicio"][0];
        $flag_servicio = $servicio["flag_servicio"];
        $text_envio_cliente_sistema = "";
        if ($flag_servicio == 0) {
            $saldo_pendiente                = $saldo_pendiente + $costo_envio_cliente;
            $text_envio_cliente_sistema     = $costo_envio_sistema["text_envio"]["cliente"];
        }


        $url_request                        =   "https://enidservice.com/inicio/";
        $url_pago_oxxo                      =   $url_request . "orden_pago_oxxo/?q=" . $saldo_pendiente . "&q2=" . $id_recibo . "&q3=" . $id_usuario;
        $data_oxxo["url_pago_oxxo"]         =   $url_pago_oxxo;
        $data_oxxo["id_usuario"]            =   $id_usuario;
        $data_notificacion["id_recibo"]     =   $id_recibo;


        $flag_servicio = $servicio["flag_servicio"];
        $saldo_cubierto = $saldo_cubierto;
        $monto_a_pagar = $monto_a_pagar;
        $primer_registro = $fecha_registro;
        $estado_text = ($saldo_cubierto < $monto_a_pagar) ? "Pendiente" : "";
        $data["saldo_pendiente"] = $saldo_pendiente;
        $url_pago_paypal = "https://www.paypal.me/eniservice/" . $saldo_pendiente;
        $data["url_pago_paypal"] = $url_pago_paypal;
        $data["recibo"] = $recibo;

        $data_extra["cliente"]  = $cliente;
        $url_logo               = "https://enidservice.com/inicio/img_tema/enid_service_logo.jpg";
        $config_log             = ['src' => $url_logo, 'width' => '100'];
        $url_cancelacion        = $url_request . "msj/index.php/api/emp/salir/format/json/?type=2&id=" . $id_proyecto_persona_forma_pago;
        $img_pago_oxxo          = "https://enidservice.com/inicio/img_tema/pago-oxxo.jpeg";
        $img_pago_paypal        = "https://enidservice.com/inicio/img_tema/explicacion-pago-en-linea.png";
        $url_seguimiento_pago   = $url_request . "pedidos/?seguimiento=$id_recibo&notificar=1";



        $text  =  "";
        $text .=  get_saludo($cliente , $config_log , $id_recibo);
        $text .=  get_text_saldo_pendiente($resumen_pedido , $num_ciclos_contratados, $flag_servicio, $id_ciclo_facturacion , $text_envio_cliente_sistema , $primer_registro , $fecha_vencimiento , $monto_a_pagar , $saldo_pendiente );
        $text .=  get_text_forma_pago($img_pago_oxxo , $url_pago_oxxo , $url_pago_paypal , $img_pago_paypal);
        $text .=  get_text_notificacion_pago($url_seguimiento_pago , $url_cancelacion );

        return  div($text, ["style"=>"width: 100%;"] );

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

        $id_recibo  =  $param["id_recibo"];
        $response   = false;
        $data_complete["es_punto_encuentro"] = 0;
        /*Cuando se puede pagar al momento*/
        if (get_info_usuario_valor_variable($param , "cobranza") ==  1){
            
            /*Cuando no se ha entregado y no está cancelado*/
            if ($recibo[0]["entregado"] == 0 && $recibo[0]["se_cancela"] == 0) {
                /*Muestro la fecha de entrega acordada más el recordatorio y las forma de pago*/           
                
                $id_punto_encuentro                     =  $this->get_punto_encuentro_recibo($id_recibo);
                $data_complete["punto_encuentro"]       =  $this->get_punto_encuentro($id_punto_encuentro);
                $data_complete["es_punto_encuentro"]    =   1;
                $response =   $this->get_mensaje_pago_al_memento($data_complete,$data_complete["costo_envio_sistema"]);
            }
        }else{
            

            $usuario                =   $this->principal->get_info_usuario($recibo[0]["id_usuario"]);
            $costo_envio_sistema    =   get_costo_envio($recibo[0]);
            $response = $this->get_mensaje_no_aplica($recibo , $costo_envio_sistema , $usuario , $data_complete);
        }
        return $response;
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
            $response               =   $this->recibo_model->set_fecha_contra_entrega($id_recibo , $fecha_contra_entrega);
        }
        $this->response($response);
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

        $param      =   $this->put();
        $response   =   false;
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


            $response =  $this->recibo_model->notifica_entrega($param["saldo_cubierto"] , $param["status"] , $param["recibo"] , 'fecha_entrega');
            $this->solicita_encuenta($param["id_recibo"]);



        }
        return $response;
    }
    function set_cancelacion($param){
        
        $response   =  [];
        
        if (if_ext($param , "status,tipificacion,recibo")) {

            $response =  $this->recibo_model->cancela_orden( 0 , $param["status"] , $param["recibo"] , 'fecha_cancelacion');
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
        if(if_ext($param , "id_servicio,tipo")){

            $interval =  "";
            switch ($param["tipo"]) {
                case 1;

                    $interval = " - 1 MONTH ";

                    break;
                case 1:

                    break;
                case 2:

                    break;

                case 3:
                    $interval = " - 3 MONTH ";

                    break;

                case 6:
                    $interval = " - 6 MONTH ";

                    break;

                case 12;

                    $interval = " - 1 YEAR ";

                    break;
            }

            $response["solicitudes"]    =  $this->recibo_model->get_solicitudes_periodo_servicio($param["id_servicio"] , $interval);
            $response["entregas"]       =  $this->recibo_model->get_solicitudes_entregadas_periodo_servicio($param["id_servicio"] , $interval);
        }
        $this->response($response);
    }
    function compras_por_enviar_GET(){

        $this->response($this->recibo_model->get_compras_por_enviar());
    }
    function num_compras_usuario_GET(){

        $param      = $this->get();
        $response   = false;
        if(if_ext($param , "id_usuario")){

            $id_usuario =  $param["id_usuario"];
            $response   =  $this->recibo_model->get_total_compras_usuario($id_usuario);
        }
        $this->response($response);
    }
    private function solicita_encuenta($id_recibo){

        $recibo          =  $this->recibo_model->q_get(["notificacion_encuesta" , "id_usuario" ,"id_servicio"], $id_recibo);
        if(count($recibo) > 0 ){
            $notificacion_encuesta  =   $recibo[0]["notificacion_encuesta"];
            $id_servicio            =   $recibo[0]["id_servicio"];

            if($notificacion_encuesta < 1 ){
                $id_usuario = $recibo[0]["id_usuario"];
                /*usuario que compra*/
                $usuario =  $this->principal->get_info_usuario($id_usuario);
                if( count( $usuario ) > 0){


                    $es_valido =  es_email_valido($usuario[0]["email"]);
                    if( $es_valido > 0 ){
                        $sender =  get_notificacion_solicitud_valoracion($usuario, $id_servicio);
                        $this->principal->send_email_enid($sender , 1);

                        $status = $this->recibo_model->q_up("notificacion_encuesta", 1, $id_recibo);

                    }
                }
            }
        }
    }
    /*
    private function set_stock_servicio($q){

        $api =  "servicio/stock";
        return  $this->principal->api( $api , $q , "json" , "PUT");
    }
    */
    /*
    function verifica_anteriores($q){

        $api        =  "tickets/verifica_anteriores/format/json/";
        return       $this->principal->api($api, $q);
    }
    */
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
    /*
           function resumen_compras_usuario($param){


            $ordenes                =   $this->recibo_model->get_compras_usuario($param , $param["modalidad"]);

            $status_enid_service    =   $this->get_estatus_servicio_enid_service($param);

            $response = [
                "ordenes"               => $ordenes ,
                "status_enid_service"   => $status_enid_service
            ];
            return $response;
        }
        */

}