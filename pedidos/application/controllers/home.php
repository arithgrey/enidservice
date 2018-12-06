<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
    function __construct(){        
        parent::__construct();                            
        $this->load->helper("pedidos");
        $this->load->library(lib_def());     
    }           
    /**/
    function index(){
        
        $param                                  =   $this->input->get();
        $data                                   =   $this->principal->val_session("");
        $this->principal->acceso();
        $data["meta_keywords"]                  =   "";
        $data["desc_web"]                       =   "";
        $data["url_img_post"]                   =   create_url_preview("");                
        $data["clasificaciones_departamentos"]  =   
        $this->principal->get_departamentos();
        
        if (is_array($param) 
            &&
               array_key_exists("seguimiento", $param) 
            && ctype_digit(trim($this->input->get("seguimiento"))) 
            && $param["seguimiento"] > 0) {

            $this->carga_vista_seguimiento($param , $data);
        }else{

            $num_perfil     =  $this->principal->getperfiles();  

            if ($num_perfil != 3) {
                $module =  "location:../area_cliente";
                header( $module );
                
            }

            $data["css"] = [
                "../js_tema/js/bootstrap-datepicker/css/datepicker-custom.css",
                "../js_tema/js/bootstrap-timepicker/css/timepicker.css",
                "pedidos.css",
                "confirm-alert.css"

            
            ];
            
            $data["js"]         =  ["../js_tema/js/bootstrap-datepicker/js/bootstrap-datepicker.js",
                                        "../js_tema/js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js",
                                        "../js_tema/js/bootstrap-daterangepicker/moment.min.js",
                                        "../js_tema/js/bootstrap-daterangepicker/daterangepicker.js",
                                        "../js_tema/js/bootstrap-colorpicker/js/bootstrap-colorpicker.js",
                                        "../js_tema/js/bootstrap-timepicker/js/bootstrap-timepicker.js",
                                        "../js_tema/js/pickers-init.js",
                                        "../js_tema/pedidos/principal.js",
                                        "../js_tema/alerts/jquery-confirm.js"
                                        
            ];
        
            $es_recibo                        =  
            get_info_variable( $this->input->get() , "recibo" ); 
            $data["tipos_entregas"]           =  $this->get_tipos_entregas(array());
            $data["status_ventas"]  = $this->get_estatus_enid_service();
            if ($es_recibo == 0 ) {
                
                $this->principal->show_data_page($data, 'home');      
            }else{

                if (ctype_digit(trim($this->input->get("recibo"))) ) {
                 
                    $id_recibo =  $this->input->get("recibo");            
                    $this->carga_detalle_pedido($id_recibo , $data);

                }else{
                    redirect("../../?q=");
                }
                
            }
        }


                     
    }
    function carga_detalle_pedido($id_recibo , $data){

        $recibo     =  $this->get_recibo($id_recibo);
        if ( count($recibo)>0 ) {

            $data["orden"]      =   $id_recibo;
            $data["recibo"]     =   $recibo;
            $data["domicilio"]  =   
            $this->get_domicilio_entrega($id_recibo , $recibo);
            $data["usuario"]        =   $this->get_usuario($recibo[0]["id_usuario"]);
            $data["status_ventas"]  =   $this->get_estatus_enid_service();
            $data["tipificaciones"] =   $this->get_tipificaciones($id_recibo);

            $this->principal->show_data_page($data, 'detalle');          

        }else{
            $this->principal->show_data_page($data, 'error');          
        }
        
    }    
    function get_domicilio_entrega($id_recibo , $recibo){

        $recibo                        =    $recibo[0];         
        $tipo_entrega                  =    $recibo["tipo_entrega"]; 
        $data_complete["tipo_entrega"] =    $tipo_entrega; 
        $domicilio                     =    [];

        if ($tipo_entrega == 1) {
            /*Pido el punto de encuentro*/
            $domicilio                 =  $this->get_punto_encuentro($id_recibo);            
        }else{
            /*Pido el domicilio del cliente*/
            $domicilio                 = $this->get_domicilio_recibo($id_recibo);
        }
        $data_complete["domicilio"]    = $domicilio;
        return $data_complete;
    }
    function carga_vista_seguimiento($param , $data){

        
        $data["css"]    =   ["seguimiento_pedido.css" , "confirm-alert.css"];
        $data["js"]     =   ["../js_tema/alerts/jquery-confirm.js" , "../js_tema/pedidos/seguimiento.js"];


        $id_recibo          =  $this->input->get("seguimiento");            
        $recibo             =  $this->get_recibo($id_recibo);
        $id_usuario_compra  =  $recibo[0]["id_usuario"];    
        


        if ( count($recibo)>0  && $data["in_session"] ==  1 &&  $data["id_usuario"] > 0 && 
            $id_usuario_compra ==  $data["id_usuario"]) {


            $data["domicilio"]          =   $this->get_domicilio_entrega($id_recibo , $recibo);
            $data["recibo"]             =   $recibo;              

            if (get_param_def($param , "domicilio" ) > 0 ) {
                
                $this->load_view_domicilios_pedidos($data);                        
                
            }else{
                
                $this->load_view_seguimiento($data , $param , $recibo ,$id_recibo);
            }

            


        }else{
            redirect("../../area_cliente");
        }
        
    }
    private function load_view_seguimiento($data , $param , $recibo , $id_recibo){

        $notificacion_pago          =   (get_param_def($param , "notificar" ) > 0 ) ? 1 : 0; 
        $notificacion_pago          =   
        ($recibo[0]["notificacion_pago"] > 0) ? 0 : $notificacion_pago;
        $data["notificacion_pago"]  =   $notificacion_pago;
        $data["orden"]              =   $id_recibo;                
        $data["status_ventas"]      =   $this->get_estatus_enid_service();
        $data["tipificaciones"]     =   $this->get_tipificaciones($id_recibo);                
        $this->principal->show_data_page($data, 'seguimiento');              
    }
    private function load_view_domicilios_pedidos($data){

        $data["css"]               = [
            "bootstrap_1.min.css" , 
            "pedido_domicilio.css", 
            "confirm-alert.css"
        ];
        $data["js"]                 =   
        [
            "../js_tema/domicilio/domicilio_entrega.js",
            "../js_tema/alerts/jquery-confirm.js"
        ];
        $data["lista_direcciones"]  =   
        $this->get_direcciones_usuario($data["id_usuario"]);

        $data["puntos_encuentro"] = $this->get_puntos_encuentro($data["id_usuario"]);
        $this->principal->show_data_page($data, 'domicilio');              
    }
    private function get_domicilio_recibo($id_recibo){
        $q["id_recibo"] =   $id_recibo;
        $api            =   "proyecto_persona_forma_pago_direccion/recibo/format/json/"; 
        $direccion      =   $this->principal->api( $api , $q );
        $domicilio      =   [];
        if (count($direccion) > 0 && $direccion[0]["id_direccion"] > 0) {
            $id_direccion =  $direccion[0]["id_direccion"];
            $domicilio   =  $this->get_direccion($id_direccion);
        }
        return $domicilio;
    }
    private function get_direccion($id){
        $q["id_direccion"]  =  $id;
        $api                = "direccion/data_direccion/format/json/"; 
        return $this->principal->api( $api , $q );
    }
    private function get_punto_encuentro($id_recibo){
        $q["id_recibo"] =  $id_recibo;
        $api            = "proyecto_persona_forma_pago_punto_encuentro/complete/format/json/"; 
        return $this->principal->api( $api , $q );
    }
    private function get_recibo($id_recibo){

        $q["id"]    = $id_recibo;
        $api        = "recibo/id/format/json/"; 
        return      $this->principal->api( $api , $q );
    }
    private function get_tipos_entregas($q){        
        $api    = "tipo_entrega/index/format/json/"; 
        return $this->principal->api( $api , $q );
    }
    private function get_usuario($id_usuario){
        return $this->principal->get_info_usuario($id_usuario);
    }
    private function get_estatus_enid_service($q =[]){        
        $api = "status_enid_service/index/format/json/";
        return $this->principal->api( $api ,  $q);
    } 
    private function get_tipificaciones($id_recibo){

        $q["recibo"]    =   $id_recibo;
        $api            =   "tipificacion_recibo/recibo/format/json/";
        return $this->principal->api( $api ,  $q);  
    }
    private function get_direcciones_usuario($id_usuario){

        $q["id_usuario"]    =   $id_usuario;
        $api                =   "usuario_direccion/all/format/json/";
        return $this->principal->api( $api ,  $q);          
    }
    private function get_puntos_encuentro($id_usuario){
        
        $q["id_usuario"]    =   $id_usuario;
        $api                =   "usuario_punto_encuentro/usuario/format/json/";
        return $this->principal->api( $api ,  $q);             
    }
    
}?>