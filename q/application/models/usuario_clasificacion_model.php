<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_clasificacion_model extends CI_Model {
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
        return $this->db->get("usuario_clasificacion")->result_array();
    }
    function delete( $params_where =[] , $limit =1){              
        $this->db->limit($limit);        
        foreach ($params_where as $key => $value) {
          $this->db->where($key , $value);
        }        
        return  $this->db->delete("usuario_clasificacion", $params_where);
    }  
    function agregan_clasificaciones_periodo($param){

        $fecha_inicio   = $param["fecha_inicio"];  
        $fecha_termino  = $param["fecha_termino"];

        $query_get ="SELECT 
                        id_usuario 
                    FROM 
                        usuario_clasificacion 
                    WHERE 
                        DATE(fecha_registro) 
                    BETWEEN 
                        '".$fecha_inicio."' 
                    AND  
                        '".$fecha_termino."'                    
                    GROUP 
                    BY 
                    id_usuario";

        $result = $this->db->query($query_get);                
        return $result->result_array();

    }

    
    /*   
    function create($param)
    {
        $params = [
            "id_usuario"       => $param["id_usuario"],
            "id_clasificacion" => $param["id_clasificacion"],
            "tipo"             => 2
        ];
        return $this->insert($params);
    }
    */
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("usuario_clasificacion", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }    
    function get_num_usuario_clasificacion($id_usuario  , $id_clasificacion){

        $params_where = ["id_usuario" => $id_usuario ,  "id_clasificacion" => $id_clasificacion];
        return $this->get(["COUNT(0)num"] ,  $params_where)[0]["num"];
    }    
    
}