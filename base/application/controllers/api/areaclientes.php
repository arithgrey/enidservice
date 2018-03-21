<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'/libraries/REST_Controller.php';
class Areaclientes extends REST_Controller{
  function __construct(){
        
        parent::__construct();  
        $this->load->model("areaclientesmodel");          
        $this->load->library('sessionclass');      
  }  
  /**/
  function asocia_usuario_POST(){

      if($this->input->is_ajax_request()){ 

        $param = $this->post();                  
        /**/
        $data_usuario_registro = $this->areaclientesmodel->crea_usuario_perfil_cliente($param);
        $param["id_usuario"] = $data_usuario_registro["id_usuario"];
        /*Asocial persona a usuario */
        $data_usuario_asociado = $this->areaclientesmodel->asocia_usuario_persona($param);
        /**/
        $this->response($data_usuario_registro);  
      
      }else{        
        $this->response("Error");
      }  
  }
  /**/

  /**/
  
   
}
?>