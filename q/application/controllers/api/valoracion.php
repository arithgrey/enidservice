<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Valoracion extends REST_Controller{
    private $id_usuario;     
    function __construct(){
      parent::__construct();                   
      $this->load->helper("valoracion");                          
      $this->load->model("valoracion_model");
      $this->load->library(lib_def());  
      $this->id_usuario = $this->principal->get_session("idusuario");
    }  
  /**/
  function lectura_put(){
    $param  =  $this->put();
    return  $this->valoracion_model->lectura_usuario($param);
  }
  function gamificacion_negativa_PUT(){
      $param =  $this->put();
      $this->valoracion_model->set_gamificacion($param , 0 , 1);
  }
  /*
  function gamificacion_deseo_PUT(){    

    $param    =   $this->put();        
    $valor    =   (array_key_exists("valor", $param) ) ? $param["valor"] :  1;    
    $response =   $this->serviciosmodel->set_gamificacion_deseo($param , 1 , $valor);  
    $this->response($response);
  }
  */
      function pregunta_consumudor_form_GET(){
        
        /**/     
        $param =  $this->get();              
        $data["id_servicio"] =  $param["id_servicio"];
        $servicio =  $this->principal->get_base_servicio($param["id_servicio"]);                
        $data["servicio"]= $servicio;
        $data["in_session"]=  $param["in_session"];
        $data["id_usuario"] = $param["id_usuario"];
        $data["vendedor"] ="";
        if( $data["in_session"] == 1 ){
            
            $data["vendedor"] = 
            $this->principal->get_info_usuario($servicio[0]["id_usuario"]);        
        }
        $data["propietario"] =  ($servicio[0]["id_usuario"]!=$data["id_usuario"])?0:1;
        $this->load->view("valoraciones/pregunta_consumudor" , $data);
    }
     private function q_get($params=[], $id){
        return $this->get("servicio", $params, ["id_servicio" => $id ] );
    }
    function q_up($q , $q2 , $id_usuario){
        return $this->update("servicio" , [$q => $q2 ] , ["idusuario" => $id_usuario ]);
    }

    function insert($tabla ='imagen', $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }

  

  /*
  function registra_respuesta($param){

    $id_usuario =  $param["id_usuario"];    
    $id_pregunta =  $param["pregunta"];    
    $respuesta =  $param["respuesta"];
    $params = ["respuesta" => $respuesta,"id_pregunta" => $id_pregunta, "id_usuario" => $id_usuario];
    $this->insert("response", $params);
    return $this->actualiza_estado_pregunta($param);
  }
  
  
  */

    
    
    /**/
    function servicios_pregunta_sin_contestar_GET(){

        $param      = $this->get();
        $response   = 
        $this->valoracion_model->get_servicios_pregunta_sin_contestar($param);
        $this->response($response);
    }
    /**/
    function gamificacion_pregunta_PUT(){
        
        $param      = $this->put();
        $response   = $this->valoracion_model->update_gamificacion_pregunta($param);
        $this->response($response);
    }
    /**/
    function resumen_valoraciones_vendedor_GET(){
        
        $param =  $this->get();
        $comentarios =  $this->valoracion_model->get_desglose_valoraciones_vendedor($param);
        $data_comentarios  =  crea_resumen_valoracion_comentarios($comentarios["data"] , "");
        if(count($comentarios["data"])> 0 ){
            
            $data_comentarios = "<hr><div class='text_resumen'> RESEÑAS HECHAS POR OTROS CLIENTES </div><hr>".$data_comentarios;          
        }
        $this->response($data_comentarios);        
    }
    /**/
    function resumen_valoraciones_periodo_GET(){

        $param =  $this->get();
        $comentarios =  $this->valoracion_model->get_desglose_valoraciones_periodo($param);
        $data_comentarios  =  crea_resumen_valoracion_comentarios($comentarios["data"] , "");
        if(count($comentarios["data"])> 0 ){
            
            $data_comentarios = "<div class='col-lg-6 col-lg-offset-3'><hr><div class='text_resumen'> RESEÑAS HECHAS POR OTROS CLIENTES </div><hr>".$data_comentarios."</div>";          
        }
        $this->response($data_comentarios);        
    }
    /**/
    function resumen_valoraciones_periodo_servicios_GET(){

        $param =  $this->get();
        $response =  $this->valoracion_model->get_productos_distinctos_valorados($param);
        
        $data_complete = array();
        $a =0;
        foreach ($response as $row) {

            $prm["id_servicio"] = $row["id_servicio"];
            $data_complete[$a] = $this->get_producto_por_id($prm)[0];
            $a ++;
        }        
        
        $data["servicios"] =  $data_complete;
        $this->load->view("servicio/lista" ,$data);
        
    }
    /**/
    function usuario_GET(){

        $param =  $this->get();
        $valoraciones = $this->valoracion_model->get_valoraciones_usuario($param);    
        if(count($valoraciones) > 0){
            $info_valoraciones =  crea_resumen_valoracion($valoraciones , 1);

            $data["info_valoraciones"] =  $info_valoraciones;
            $data["data"] = $valoraciones;

            $this->response($data);
        }else{
            $this->response("");    
        }
        
    }

    private function get_usuario_por_servicio($q){  
                
        $api  =  "servicio/usuario_por_servicio/format/json/";
        return $this->principal->api("q" ,  $api , $q );
    }
    /**/
    private function get_producto_por_id($q){
        
        $api  =  "producto/producto_por_id/format/json/";
        return $this->principal->api("tag" ,  $api , $q );        
    }
    /**/
    function articulo_GET(){
            
        $param              =   $this->get();
        $valoraciones       =   $this->valoracion_model->get_valoraciones_articulo($param);    
        $data["servicio"]   =   $param["id_servicio"];        
        $usuario            =   $this->get_usuario_por_servicio($param);                

        
        $id_usuario         =   $usuario[0]["id_usuario"];            
        $data["id_usuario"] =   $id_usuario;
        if($valoraciones[0]["num_valoraciones"] > 0){
            
            $data["comentarios"]          =  $this->valoracion_model->get_valoraciones($param);    
            $data["numero_valoraciones"]  =  $valoraciones;
            $data["respuesta_valorada"]   =  $param["respuesta_valorada"];            
            $this->load->view("valoraciones/articulo", $data);        
            
        }else{
            $this->load->view("valoraciones/se_el_primero", $data);        
        } 
        

    }
    /**/
    function valoracion_form_GET(){

        $param                  =  $this->get();              
        $data["id_servicio"]    =  $param["id_servicio"];
        $data["servicio"]       =  $this->principal->get_base_servicio($param);
        $data["extra"]          =  $param;
        $this->load->view("valoraciones/form_servicio" , $data);        
    }
    /**/    
    function nueva_POST(){
                
        $param                              = $this->post();        
        $response                           =  $this->valoracion_model->registrar($param);             
        $data_complete["id_servicio"]       =  $param["id_servicio"];                
        $prm["key"]                         =  "email";
        $prm["value"]                       =  $param["email"];                
        $data_complete["existencia_usuario"] =  $this->valida_existencia_usuario($prm);        
        $this->response($data_complete);        
    }
    /**/
    function valida_existencia_usuario($q){                
        $api =  "usuario/usuario_existencia/format/json/"; 
        return $this->principal->api("q" , $api , $q );      
    }
    /**/
    function utilidad_PUT(){
        
        $param = $this->put();
        $response = $this->valoracion_model->utilidad($param);
        $this->response($response);
    }
    /**/
    
    /**/
    function registro_pregunta($q){ 
        $api = "pregunta/registro";
        return $this->principal->api("q" , $api , $q);
    }
    /**/
    function pregunta_POST(){

        $param      =  $this->post();
        $response   =  $this->registro_pregunta($param);        
        $respuesta_notificacion = "";
        if($response == true ){                                
            $respuesta_notificacion = $this->envia_pregunta_a_vendedor($param);
        }        
        $this->response($respuesta_notificacion);

    }
    private function envia_pregunta_a_vendedor($q){
        $api =  "pregunta/pregunta_vendedor/format/json/"; 
        return $this->principal->api("msj" , $api , $q );
    }
    /**/
    
    /**/
    /**/
    
    /**/
    function set_visto_pregunta($q){

        $api = "pregunta/visto_pregunta";
        return $this->principal->api("q" , $api , $q  , "json" , "PUT");

    }

    /**/
    
    /**/  

}
?>