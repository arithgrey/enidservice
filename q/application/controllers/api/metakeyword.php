<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'../../librerias/REST_Controller.php';
class Metakeyword extends REST_Controller{
  private $id_usuario;
  function __construct(){
      parent::__construct();                           
      $this->load->helper("metakeyword");
      $this->load->model("metakeyword_model");                                    
      $this->load->library(lib_def());               
      $this->id_usuario = $this->principal->get_session("idusuario");
  } 
  function gamificacion_search_POST(){

    $param    =  $this->post();
    $response =  false;
    if (if_ext($param , "q,id_usuario")){
        $q            =   $param["q"];
        $id_usuario   =   $param["id_usuario"];
        $params       =   [ "keyword"     => $q, "id_usuario"  => $id_usuario];
        $response     =   $this->metakeyword_model->insert($params);

    }
    $this->response($response);
  }
  function usuario_PUT(){  
    $param      =   $this->put();
    $response   =   false;
    if (if_ext($param, "metakeyword_usuario,id_usuario")){
        $response = $this->metakeyword_model->set_metakeyword_usuario($param);
    }
    $this->response($response);    
  }  
  function registro_POST()
  {
    
    $param      =   $this->post();
    $response   =   false;
    if (if_ext($param, "q,id_usuario")){

        $params = [
            "keyword"     => $param["q"] ,
            "id_usuario"  => $param["id_usuario"]
        ];
        $response       = $this->metakeyword_model->insert($params);

    }
    $this->response($response);

  }
  function add_POST(){
    
    $param       =  $this->post();
    $metakeyword =  $this->metakeyword_model->get_metakeyword_catalogo_usuario($param);        

    if (count($metakeyword)> 0) {
        $json_meta  =  $metakeyword[0]["metakeyword"];  
        $arr_meta   =  json_decode($json_meta , true);      
        /*Buscamos si es que existe el meta  keyword*/
        if ($this->existe_meta($arr_meta, $param["metakeyword_usuario"]) == 0) {
            if (if_ext($param,"metakeyword_usuario,metakeyword,id_usuario")){
                $this->response($this->add_metakeyword($param , $arr_meta));
            }else{
                $this->response(false);
            }
        }
      }else{
          $this->response($this->create($param));
      }
  }
  function existe_meta($param, $val){
        $existe =0;
        for ($a=0; $a <count($param) ; $a++) {                 
                if ($param[$a] ==  $val) {
                    $existe =1;
                    break;
            }
        }
        return $existe;
  }
  function add_metakeyword($param , $arr_meta){
      array_push($arr_meta, strtoupper($param["metakeyword_usuario"]));
      $meta                   =  json_encode($arr_meta);
      $param["metakeyword"]   =  json_encode($arr_meta);
      return $this->metakeyword_model->update(["metakeyword" => $param["metakeyword"] ] , ["id_usuario" => $param["id_usuario"]]);
  }
  public function metakeyword_catalogo_GET(){

      $param                =   $this->get();
      $param["id_usuario"]  =   $this->id_usuario;
      $response             =   $this->metakeyword_model->get_metakeyword_catalogo_usuario($param);
      if ($param["v"] == 1) {
        
        $data["catalogo"] =  create_arr_tags($response);
        $this->load->view("servicio/catalogo_metakeyword" , $data);  
      }else{
        $this->response($response);
      }
  }
  private function create($param)
  {
        $response = false;
        if (if_ext($param , "metakeyword_usuario,id_usuario")){
            $arr                =   array();
            array_push($arr, strtoupper($param["metakeyword_usuario"]));
            $id_usuario         =   $param["id_usuario"];
            $meta               =   json_encode($arr);
            $params             =   [ "metakeyword"   =>  $meta,"id_usuario"    =>  $id_usuario];
            $response           =   $this->metakeyword_model->insert($params);
        }
        return $response;
  }
}