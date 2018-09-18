<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_clasificacion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
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
    
    
    function get_interes_usuario($param)
    {   
        $id_usuario =  $param["id_usuario"];
        $id_clasificacion =  $param["id_clasificacion"];

         $query_get ="
            SELECT 
                COUNT(0)num
            FROM                 
            usuario_clasificacion  uc             
            WHERE 
                uc.tipo =2
            AND  
                uc.id_usuario =$id_usuario
            AND 
                uc.id_clasificacion = $id_clasificacion
            ";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }
    
    function delete_interes_usuario($param)
    {   
        $id_usuario         =  $param["id_usuario"];
        $id_clasificacion   =  $param["id_clasificacion"];

         $query_delete ="DELETE  FROM                 
            usuario_clasificacion  
            WHERE 
                tipo =2
            AND  
                id_usuario =$id_usuario
            AND 
                id_clasificacion = $id_clasificacion";
        return $this->db->query($query_delete);
        
    }      
    function insert_interes_usuario($param)
    {


        $params = [
            "id_usuario"       => $param["id_usuario"],
            "id_clasificacion" => $param["id_clasificacion"],
            "tipo"             => 2
        ];
        return $this->insert("usuario_clasificacion", $params);
    }

    function insert($tabla ='imagen', $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert($tabla, $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }    
    function get_num_usuario_clasificacion($id_usuario  , $id_clasificacion){

        $params_where =  ["id_usuario" => $id_usuario ,  "id_clasificacion" => $id_clasificacion];
        return $this->get("usuario_clasificacion" , ["COUNT(0)num"] ,  $params_where)[0]["num"];
    }    
    function get($table='imagen' , $params=[], $params_where =[] , $limit =1){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get($table)->result_array();
    }
}