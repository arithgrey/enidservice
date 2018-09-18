<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_deseo_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    private function update($table='imagen' , $data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update($table, $data);    
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
    function get_num_deseo_servicio_usuario($param){
        $params_where = ["id_usuario" => $param["id_usuario"] , "id_servicio" =>  $param["id_servicio"]];
        return   $this->get('usuario_deseo' , ["COUNT(0)num"], $params_where)[0]["num"]; 
    }
    function aumenta_deseo($param){
        $id_usuario     =  $param["id_usuario"];
        $id_servicio    =  $param["id_servicio"];        
        $query_update =  "UPDATE usuario_deseo SET num_deseo = num_deseo + 1 WHERE 
                            id_usuario = $id_usuario AND  id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }   
    function add_usuario_deseo($param){
        $params = [
            "id_usuario"    => $param["id_usuario"],
            "id_servicio"   => $param["id_servicio"]
        ];
        return $this->insert("usuario_deseo", $params);
    }
    function agregan_lista_deseos_periodo($param){

        $fecha_inicio   = $param["fecha_inicio"];  
        $fecha_termino  = $param["fecha_termino"];

        $query_get ="SELECT 
                        id_usuario 
                    FROM 
                        usuario_deseo 
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
    function get_productos_deseados_periodo($param){
            
        $fecha_inicio   = $param["fecha_inicio"];
        $fecha_termino  = $param["fecha_termino"];

        $query_get ="SELECT 
                        id_servicio ,
                        num_deseo
                     FROM 
                        usuario_deseo 
                     WHERE 
                        DATE(fecha_registro) 
                    BETWEEN 
                        '".$fecha_inicio."'
                        AND 
                        '".$fecha_termino."'
                    ORDER BY num_deseo DESC";
        
        $result=  $this->db->query($query_get);
        return  $result->result_array();        
    }
    function insert($tabla ='imagen', $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert($tabla, $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
    function get_por_usuario($param){
            
        $id_usuario =  $param["id_usuario"];        
        $query_get ="SELECT id_servicio FROM usuario_deseo WHERE 
        id_usuario = '".$id_usuario."' ORDER BY num_deseo DESC LIMIT 30";        
        $result=  $this->db->query($query_get);
        return  $result->result_array();
    }
}