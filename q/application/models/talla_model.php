<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class talla_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
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
        return $this->db->get("talla")->result_array();
    }
    function insert( $params , $return_id=0){        
        $insert   = $this->db->insert("talla", $params);
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function q_get($params=[], $id){
        return $this->get($params, ["id_talla" => $id ] );
    }
    function get_tallas_countries($param){

        $id_tipo_talla  =   $param["id_tipo_talla"];
        $campos         =   array("t.id_talla" , "t.talla" , "c.prefijo");
        $fields         =   add_fields($campos);
        $query_get      =   "SELECT ".$fields." FROM 
                            talla t  
                            INNER JOIN countries c 
                            ON 
                            c.idCountry =  t.id_country
                            WHERE 
                            id_tipo_talla = $id_tipo_talla 
                            LIMIT 20";
        return          $this->db->query($query_get)->result_array();
    }
    
}