<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_deseo_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert('usuario_deseo', $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
    function update($data =[] , $params_where =[] , $limit =1 ){    
        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        $this->db->limit($limit);
        return $this->db->update("usuario_deseo", $data);    
    }
    function get($params=[], $params_where =[] , $limit =1 ,  $order = '', $type_order='DESC'){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }      
        return $this->db->get('usuario_deseo')->result_array();
    }
    function get_num_deseo_servicio_usuario($param){
        $q      = ["id_usuario" => $param["id_usuario"] , "id_servicio" =>  $param["id_servicio"]];
        return  $this->get(["COUNT(0)num"], $q)[0]["num"]; 
    }
    function aumenta_deseo($param){
        
        $id_usuario     =  $param["id_usuario"];
        $id_servicio    =  $param["id_servicio"];        
        $query_update   =  
        "UPDATE usuario_deseo SET num_deseo = num_deseo + 1 WHERE id_usuario = $id_usuario AND  id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }   
    /*
    function add_usuario_deseo($param){
        $params = [
            "id_usuario"    => $param["id_usuario"],
            "id_servicio"   => $param["id_servicio"]
        ];
        return $this->insert($params);
    }
    */
    function agregan_lista_deseos_periodo($param){

        $query_get ="SELECT 
                        id_usuario 
                    FROM 
                        usuario_deseo 
                    WHERE
                        DATE(fecha_registro) 
                    BETWEEN 
                        '".$param["fecha_inicio"]."' 
                    AND  
                        '".$param["fecha_termino"]."'                    
                    GROUP 
                    BY 
                    id_usuario";
                    
        $result = $this->db->query($query_get);                
        return $result->result_array();

    }
    function get_productos_deseados_periodo($param){
        
        $query_get ="SELECT 
                        id_servicio ,
                        num_deseo
                     FROM 
                        usuario_deseo 
                     WHERE 
                        DATE(fecha_registro) 
                    BETWEEN 
                        '".$param["fecha_inicio"]."'
                        AND 
                        '".$param["fecha_termino"]."'
                    ORDER BY num_deseo DESC";
        
        return  $this->db->query($query_get)->result_array();        
    }   
    function get_por_usuario($param){        
        return $this->get([] , ["id_usuario" => $param["id_usuario"] ] , 30 , 'num_deseo' );
    }
}