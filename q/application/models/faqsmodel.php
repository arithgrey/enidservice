<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class faqsmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    private function update($table='imagen' , $data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update($table, $data);
    }
    function q_up($q , $q2 , $id_usuario){
        return $this->update("servicio" , [$q => $q2 ] , ["idusuario" => $id_usuario ]);
    }
    private function q_get($params=[], $id){
        return $this->get("servicio", $params, ["id_servicio" => $id ] );
    }
    
    private function get($table='imagen' , $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get($table)->result_array();
    }
    function search($param){

        $q          =  $param["q"];
        $extra      = "AND status = 1";
        $query_get  = "SELECT * FROM faq 
                        WHERE 
                        titulo 
                        like '%".$q."%' 
                        ".$extra ."
                        LIMIT 25";            
        $result =  $this->db->query($query_get);                            
        return $result->result_array();
    }
    /**/
    function insert($tabla ='imagen', $params , $return_id=0){        
        $insert   = $this->db->insert($tabla, $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    
    /*
    function q($param){        
        return $this->get("categoria");
    }     

    */
    
    
    /*    
    function get_respuesta($param){

        $id_faq =  $param["id_faq"];
        $query_get = "SELECT * FROM faq 
                      WHERE id_faq = $id_faq                      
                      LIMIT 1";

        
        $result =  $this->db->query($query_get);
        return $result->result_array();
        
    }
    
    */   
    
}