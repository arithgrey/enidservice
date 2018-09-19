<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Funcionalidad_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function get_all($param){
        return $this->get([], [] , 100);        
    }
    private function get( $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get('funcionalidad')->result_array();
    }

    
}