<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Estado_republica_model extends CI_Model{
	function __construct(){
	      parent::__construct();        
	      $this->load->database();
	} 
    function q_get($params=[], $id){
        return $this->get($params, ["id_estado_republica" => $id ] );
    }  
  	function get($params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("estado_republica")->result_array();
    }    
}
