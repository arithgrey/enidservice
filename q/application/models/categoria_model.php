<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Categoria_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
 	function get_categorias_por_tipo($id_tipo_categoria){
        
        $params = ["c.id_categoria", "c.nombre_categoria", "count(f.id_faq)faqs"];
        $keys = get_keys($params);
            $query_get = "SELECT 
                           ".$keys."
                        FROM 
                        categoria  c  
                        LEFT OUTER JOIN faq f  
                        ON  c.id_categoria =  f.id_categoria 
                        WHERE                         
                            c.idtipo_categoria = '".$id_tipo_categoria."' 
                        GROUP BY 
                        c.id_categoria";
            $result =  $this->db->query($query_get);                            
            return $result->result_array();

    }
    function get( $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("categoria")->result_array();
    }
    /**/
    function insert( $params , $return_id=0){        
        $insert   = $this->db->insert("categoria", $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    
    function q_get($params=[], $id){
        return $this->get($params, ["id_categoria" => $id ] );
    }   
    
}