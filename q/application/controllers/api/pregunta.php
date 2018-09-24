<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class pregunta extends REST_Controller{      
    private $id_usuario;
    function __construct(){
        parent::__construct();                                      
        $this->load->helper("pregunta");
       	$this->load->model("pregunta_model");
        $this->load->library(lib_def());     
        $this->id_usuario = $this->principal->get_session("idusuario");
    }
	function visto_pregunta_PUT(){

        $param      = $this->put();
        $response   = $this->pregunta_model->set_visto_pregunta($param); 
        $this->response($response);
    }
    function index_POST(){        
        $param          = $this->post();        
        $id_pregunta    = $this->pregunta_model->create($param); 
        $response       = [];

        if ($id_pregunta >0 ) {
            $param["id_pregunta"] = $id_pregunta;
            $response             =  $this->agrega_pregunta_servicio($param);    
        }
        $this->response($response);        
    }
    /*
    private function envia_pregunta_a_vendedor($q){
        $api =  "pregunta/pregunta_vendedor/format/json/"; 
        return $this->principal->api( $api , $q );
    }
    */
    /*
    function pregunta_POST(){

        $param      =  $this->post();
        $response   =  $this->registro_pregunta($param);                        
        $respuesta_notificacion = "";
        if($response){                                            
            $respuesta_notificacion = $this->envia_pregunta_a_vendedor($param);
        }        
        $this->response($respuesta_notificacion);

    }
    */
    function agrega_pregunta_servicio($q){

        $api = "pregunta_servicio/index";
        return $this->principal->api( $api , $q , "json", "POST");
    }
    function periodo_GET(){

        $param      =   $this->get();
        $response   =   $this->pregunta_model->num_periodo($param);
        $this->response($response);        
    }
    function buzon_GET(){

        $param               =  $this->get();        
        $param["id_usuario"] =  $this->id_usuario;
        //$nombre_usuario_actual =  $this->principal->get_session("nombre");
        $data_complete["modalidad"] = $param["modalidad"];
        /*Consulta preguntas hechas con proposito de compras*/
        if($param["modalidad"] ==  1){                                                    
            $preguntas                  = 
            $this->pregunta_model->get_preguntas_realizadas_a_vendedor($param);            
            $data_complete["preguntas"] =  $this->add_num_respuestas_preguntas($preguntas);

        }else{              

            $preguntas =  $this->pregunta_model->get_preguntas_realizadas($param);
            $data_complete["preguntas"] =  $this->add_num_respuestas_preguntas($preguntas);
                                    
        }   
        $this->load->view("valoraciones/preguntas" ,  $data_complete);                 
    }
    function preguntas_sin_leer_GET(){        

        $param =  $this->get();
        $param["id_usuario"]   = $this->id_usuario;

        if ($param["modalidad"] ==  1) {          

            if( !isset($param["id_usuario"]) ){
                $param["id_usuario"] = $this->id_usuario;
            }  
            /*Modo vendedor*/
            $data_complete["modo_vendedor"]=
            $this->pregunta_model->get_preguntas_sin_leer_vendedor($param)[0]["num"];            
            /*Modo cliente*/
            $data_complete["modo_cliente"] = 
            $this->pregunta_model->get_respuestas_sin_leer($param);

            $this->response($data_complete);          
        }
        $this->response("");
    }
    function add_num_respuestas_preguntas($data){

      $data_complete = [];
      $a =0;
      foreach($data as $row){          
        $data_complete[$a] =  $row;
        $data_complete[$a]["respuestas"] = 
        $this->get_num_respuestas_sin_leer($row["id_pregunta"]);
        $a ++;
      }
      return $data_complete;
    }
    function get_num_respuestas_sin_leer($id_pregunta){

        
        $q["id_pregunta"] =  $id_pregunta;
        $api              =  "respuesta/num_respuestas_sin_leer/format/json/";
        return $this->principal->api( $api , $q);
    }
    function usuario_por_pregunta_GET(){

        $param      =   $this->get();                        
        $usuario    =   $this->pregunta_model->get_usuario_por_id_pregunta($param);
        $id_usuario =   $usuario[0]["id_usuario"];     
        $this->response($id_usuario);
    }
    
        
}?>
