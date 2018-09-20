<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Codigo_postal_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
     function get($params=[], $params_where =[] , $limit =1){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("codigo_postal")->result_array();
    }
    function q_get($params=[], $id){
        return $this->get($params, ["id_servicio" => $id ] );
    }  
    function get_id_codigo_postal_por_patron($param){
      return $this->get(["id_codigo_postal"] , ["cp" => $param["cp"] ])[0]["id_codigo_postal"];
    }
    function get_colonia_delegacion($param){    
    
      /*hay que realizar correccion a la base de datos*/
      $cp        =  $param["cp"];    
      $query_get =  "SELECT * FROM codigo_postal WHERE cp like '".$cp."%' LIMIT 20";
      $cps       = $this->db->query($query_get)->result_array();
      if (count($cps) ==  0) {
        $cp =  substr($cp, 1 , strlen($cp));
        $query_get =  "SELECT * FROM codigo_postal WHERE cp like '".$cp."%' LIMIT 20";
        $cps = $this->db->query($query_get)->result_array();
      }
      return $cps;

    }  
      
    
}