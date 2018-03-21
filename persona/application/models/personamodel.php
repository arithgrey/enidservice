<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class personamodel extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_usuario_ventas(){
      
      $query_get ="SELECT idusuario FROM usuario WHERE email ='ventas@enidservice.com' LIMIT 1";
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["idusuario"];
    }
    /**/
    function update_persona_q($param){

      $id_persona = $param["id_persona"];
      $nuevo_valor = $param["nuevo_valor"];
      $name = $param["name"];

      if($name == "idtipo_negocio"){

        $query_update =  "update 
        tipo_negocio_persona 
        set 
        idtipo_negocio='".$nuevo_valor."' 
        WHERE id_persona = '".$id_persona."' limit 1";
        return $this->db->query($query_update);

      }else{      
        $query_update ="UPDATE persona 
                        SET  $name = '".$nuevo_valor."'
                        WHERE  id_persona = '".$id_persona."' LIMIT 1";
        
        return  $this->db->query($query_update);
      }
      
    }
    /**/
    /*
    function registra_persona_tipo_negocio($id_persona , $id_tipo_negocio){

        $query_insert ="INSERT INTO 
                        tipo_negocio_persona(id_persona ,idtipo_negocio )
                        VALUES('".$id_persona."' , '".$id_tipo_negocio."')";
        return $this->db->query($query_insert);
    }
    */
     
   
}