<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Countries_model extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    function get_pais($param){

      $id_pais = $param["id_pais"];
      $query_get = "SELECT  
                  *
                  FROM 
                    countries
                  WHERE 
                    idCountry = $id_pais";

                  $result =  $this->db->query($query_get);
                  return $result->result_array();

    }
  
          
}