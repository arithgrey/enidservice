<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class prospecto_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function q_up($q , $q2 , $id_servicio){
      return $this->update([$q => $q2 ] , ["id_prospecto" => $id_servicio ]);
    }
    function q_get($params=[], $id){
      return $this->get( $params, ["id_servicio" => $id ] );
    }    
    function get( $params=[], $params_where =[] , $limit =1, $order = '', $type_order='DESC'){

        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }       
        return $this->db->get("prospecto")->result_array();
    }    
    function update( $data =[] , $params_where =[] , $limit =1 ){
      foreach ($params_where as $key => $value) {
        $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("prospecto", $data);    
    }    
    function salir_list_email($param){
        $query_update =  "UPDATE prospecto SET 
                      status = -1
                      WHERE 
                      email = '".$param["email"]."' LIMIT 1 ";
        return $this->db->query($query_update);
    } 
    function email_enviados_enid_service(){
        
      $query_get = 
      "SELECT  count(0)num_envios FROM prospecto WHERE DATE(fecha_actualizacion) = DATE(CURRENT_DATE())";      
      return $this->db->query($query_get)->result_array()[0]["num_envios"];    
    }    
    
 
}