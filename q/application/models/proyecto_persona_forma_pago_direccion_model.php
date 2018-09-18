<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Proyecto_persona_forma_pago_direccion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function delete_por_id_recibo($id_recibo){
        $query_delete = "DELETE 
                      IGNORE 
                      FROM 
                      proyecto_persona_forma_pago_direccion 
                      WHERE 
                      id_proyecto_persona_forma_pago = $id_recibo";
                      debug($query_delete);
        return  $this->db->query($query_delete);
    }
    function get_by_recibo($param){
      
      
      $query_get = "SELECT * FROM proyecto_persona_forma_pago_direccion 
                    WHERE 
                    id_proyecto_persona_forma_pago = ".$param["id_recibo"];      
      
      return  $this->db->query($query_get)->result_array();                
    }
    function agrega_direccion_a_compra($param){
            
      $params = [
        "id_proyecto_persona_forma_pago"  => $param["id_recibo"],
        "id_direccion"                    => $param["id_direccion"]
      ];
      return $this->insert("proyecto_persona_forma_pago_direccion" , $params);
    }
    function insert($tabla ='imagen', $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
}
