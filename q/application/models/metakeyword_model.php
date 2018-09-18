<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class metakeyword_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function update($table='imagen' , $data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update($table, $data);    
    }
    function q_up($q , $q2 , $id_metakeyword){
        return $this->update("metakeyword" , [$q => $q2 ] , ["id_metakeyword" => $id_metakeyword ]);
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

    function insert($tabla ='imagen', $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function gamificacion_search($param){

        $q            =  $param["q"];            
        $id_usuario   =  $param["id_usuario"];        
        $params       = [
          "keyword"     => $param["q"],
          "id_usuario"  => $id_usuario
        ];
        return $this->insert("keyword" , $params );        
    }
    function registra_keyword($param){
        
        $q =  $param["q"];            
        $id_usuario =  $param["id_usuario"];        
        $query_insert ="INSERT INTO 
                        keyword(keyword , id_usuario) 
                        VALUES('".$param["q"]."' ,  '".$id_usuario."')";    
        return $this->db->query($query_insert);    
    }
    function crea_registro_metakeyword($param){        
        $arr                = array();        
        array_push($arr, strtoupper($param["metakeyword_usuario"]));        
        $id_usuario         =  $param["id_usuario"];
        $meta               =  json_encode($arr);

        $params = [ "metakeyword"   =>  $meta,"id_usuario"    =>  $id_usuario];
        return $this->insert("metakeyword", $params);
    }    
    function set_metakeyword($param){        
        return $this->update(
                    'metakeyword' , 
                    ["metakeyword" => $param["metakeyword"] ] , 
                    ["id_usuario" => $param["id_usuario"]]);        
    }     
    function get_metakeyword_catalogo_usuario($param){
        return $this->get('metakeyword' , ["metakeyword"], ["id_usuario" =>  $param["id_usuario"] ]);        
    } 
}