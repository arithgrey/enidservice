<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Usuario_direccion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    
    function update($data =[] , $params_where =[] , $limit =1 ){    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("usuario_direccion", $data);    
    }
    function delete($params_where =[] , $limit =1){              
        $this->db->limit($limit);        
        foreach ($params_where as $key => $value) {
          $this->db->where($key , $value);
        }        
        return  $this->db->delete("usuario_direccion", $params_where);
    }
    function get( $params=[], $params_where =[] , $limit =1){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("usuario_direccion")->result_array();
    }
    function get_num($param){
        return $this->get(["COUNT(0)num"] , ["id_usuario" => $param["id_usuario"] ] )[0]["num"];
    }
    function get_usuario_direccion($id_usuario){
      return $this->get([] , ["id_usuario" => $id_usuario , "status" => 1  ] );
    }
    function insert($params , $return_id=0 , $debug=0){               
        $insert   = $this->db->insert("usuario_direccion", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }            
    function activos_con_direcciones($param){


      /*
        $fecha_inicio   = ;  
        $fecha_termino  = ;

        $query_get ="SELECT  COUNT(0)num 
                    FROM 
                        usuario_direccion 
                    WHERE 
                        status =1
                    AND
                        DATE(fecha_registro) 
                    BETWEEN 
                        '".$fecha_inicio."' 
                    AND  
                        '".$fecha_termino."'  ";
                        

        $result = $this->db->query($query_get);                
        return $result->result_array()[0]["num"];
        */

        $q =[
          "status"                => 1 ,
          'DATE(fecha_registro) ' =>  
          "BETWEEN  '".$param["fecha_inicio"]."'  AND  '".$param["fecha_termino"]."' "
        ];
        return $this->get(["COUNT(0)num "] , $q)[0]["num"];
    }      
    
}