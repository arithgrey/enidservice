<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class productividad extends REST_Controller{      
    function __construct(){
        parent::__construct();    
        $this->load->helper("q");                                          
        $this->load->model("productividad_usuario_model");          
        $this->load->library(lib_def());     
    }   
    /*
    function accesos_afiliados_GET(){        

        $param =  $this->get();
        $id_usuario =  $this->principal->get_session('idusuario');
        $enlace_afiliado = 'http://'.$_SERVER['HTTP_HOST']."/inicio/nosotros/?q=".$id_usuario;
        $param["url"] =  $enlace_afiliado;
        $param["id_usuario"] =  $id_usuario;

        
        $num_accesos_por_afiliado=  $this->productividad_model->get_accesos_afiliado($param);  
        $data["num_accesos"] =  $num_accesos_por_afiliado;

        
        $num_contactos_por_afiliado= 
        $this->productividad_model->get_contactos_por_usuario($param);  
        $data["num_contactos"] =  $num_contactos_por_afiliado;
        
        $num_ventas_por_recomendacion = 
        $this->productividad_model->get_ventas_por_usuario($param);  
        $data["num_ventas_por_recomendacion"] =  $num_ventas_por_recomendacion;    
        
        
        $num_efectivo = $this->productividad_model->get_comisiones_por_usuario($param);  
        $data["num_efectivo"] =  $num_efectivo;        
        $this->response($data);
        
    }
    */
    /*
    function faq_GET(){
        
        $param = $this->get();
        $data["info_preguntas"] = $this->productividad_model->get_faqs($param);
        $this->load->view("productividad/preguntas_frecuentes" , $data);
        
    }
    */
	/*
    function usuario_GET(){        

        $param = $this->get();
        $param["id_usuario"] =  $this->principal->get_session('idusuario');
        $data["productividad_usuario"] =  $this->productividad_model->get_productividad_usuario($param);
        $this->load->view("productividad/usuario" , $data);
    }
    */
    /*
    function usuarios_GET(){                
        
        $param = $this->get();        
        $param["id_usuario"] =  $this->principal->get_session('idusuario');        
        $data["productividad_usuario"] =  $this->productividad_model->get_productividad_usuarios($param);
        $this->load->view("productividad/productividad_por_usuario" , $data);
        
    }
    */ 
    function verifica_registro_telefono($q){

        $api = "usuario/verifica_registro_telefono/format/json";
        return  $this->principal->api( $api , $q);
    }
    /**/
    function notificaciones_GET(){

        
        $param                              =  $this->get();  
        $id_usuario                         =  $this->principal->get_session('idusuario');
        $param["id_perfil"]                 =  $this->principal->getperfiles();        
        $param["id_usuario"]                =  $id_usuario;        
        
        $response["objetivos_perfil"]           =  $this->get_objetivos_perfil($param);
        $response["productos_anunciados"]       =  $this->valida_producto_anunciado($param);
        $response["flag_direccion"]             =  $this->verifica_direccion_registrada_usuario($param);



        $param["id_perfil"]                 =   $this->principal->getperfiles();        
        $response["info_notificaciones"]    = 
        $this->productividad_usuario_model->get_notificaciones_usuario_perfil($param);
        $response["ventas_enid_service"]    =   $this->get_ventas_enid_service();

        if ($response["id_perfil"] ==  3 || $response["info_notificaciones"] == 4 ) {
            $data_complete["envios_a_validar_enid_service"] = $this->envios_a_validar_enid_service();
        }
                        



        $id_perfil                          =   $param["id_perfil"]; 
        $prm["modalidad"]                   =   1;
        $prm["id_usuario"]                  =   $id_usuario;                            
        
        $response["info_notificaciones"]["mensajes"] = $this->carga_mensajes_sin_leer($prm);

        $response["id_usuario"] = $id_usuario;

        $response["info_notificaciones"]["numero_telefonico"] = $this->verifica_registro_telefono($prm);
        
        
        switch ($id_perfil){
            
            case 3:                
                $this->response(get_tareas_pendienetes_usuario($response));        
                break;                        
            case 20:                               
                $this->response(get_tareas_pendienetes_usuario_cliente($response));
                break;    
            default:                
                break;
        }       
        
    }

    function valida_producto_anunciado($q){
        $api =  "servicio/num_anuncios/format/json/"; 
        return $this->principal->api( $api , $q );                        
    }
    //$data_complete["productos_anunciados"]  = $this->valida_producto_anunciado($param);


    /*
    function num_clientes_GET(){

        $param =  $this->get();
        $data["clientes"] = $this->productividad_model->get_num_clientes($param);
        $this->load->view("resumen/principal" , $data);
    }
    */
    /*
    function num_clientes_sistema_GET(){

        $param =  $this->get();
        $data["clientes"] = $this->productividad_model->get_num_clientes_sistema($param);
        $this->load->view("resumen/principal" , $data);   
        
    }
    function num_afiliados_GET(){

        $param =  $this->get();
        $data["afiliados"] = $this->productividad_model->get_historia_afiliados($param);
        $this->load->view("resumen/afiliados" , $data);   
    }
    
    
    function contactos_lead_GET(){
    
        $param =  $this->get();
        $data["cotizaciones"]=  $this->productividad_model->get_contactos_lead($param);
        $this->load->view("cotizador/contactos_dia", $data);
    }
    
    function social_media_GET(){

        $param =  $this->get();
        $id_usuario =  $this->principal->get_session('idusuario');
        $param["id_usuario"] =  $id_usuario;
        $data["info"]=  $this->productividad_model->get_productividad_social_media($param);
        $this->load->view("cotizador/social_media", $data);
    }
    */
    /*
    function get_perfil_usuario($param){
            
        $id_usuario = $param["id_usuario"];    
        
        $query_get = "SELECT idperfil from usuario_perfil 
                      WHERE 
                      idusuario = '".$id_usuario."'
                      LIMIT 1";    
        $result = $this->db->query($query_get);
        return $result->result_array()[0]["idperfil"];
    }
    */

    private function carga_mensajes_sin_leer($q){
        $api =  "pregunta/preguntas_sin_leer/format/json/"; 
        return $this->principal->api( $api , $q );                
    }
    private function get_objetivos_perfil($q){

        $api =  "objetivos/perfil/format/json/"; 
        return   $this->principal->api( $api , $q );                        
    }
    private function verifica_direccion_registrada_usuario($q){
        $api =  "usuario_direccion/num/format/json/"; 
        return   $this->principal->api( $api , $q );                        
    }   
    private function get_ventas_enid_service(){
        
    } 
    private function envios_a_validar_enid_service(){
        
    }
    /**/
}?>
