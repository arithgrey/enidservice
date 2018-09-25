<?php defined('BASEPATH') OR exit('No direct script access allowed');
class clasificacion_model extends CI_Model{
  
  function __construct(){
      parent::__construct();        
      $this->load->database();
  }   
  function q_get($params=[], $id){
        return $this->get($params, ["id_clasificacion" => $id ] );
  }
  function q_up($q , $q2 , $id){
        return $this->update([$q => $q2 ] , ["id_clasificacion" => $id ]);
  }
  function insert( $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
  private function update($data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("clasificacion", $data);
    
  }
  function get_intereses_usuario($param){
    
    $query_get ="
      SELECT 
      c.id_clasificacion,
      c.nombre_clasificacion,
      uc.id_usuario 
      FROM 
      clasificacion c
      LEFT OUTER JOIN 
      usuario_clasificacion uc 
      ON 
      c.id_clasificacion = uc.id_clasificacion
      AND  
      uc.tipo =2
      AND  
      uc.id_usuario = '".$param["id_usuario"]."'
      WHERE 
      c.nivel =1 
      AND 
      c.flag_servicio =0";
      return  $this->db->query($query_get)->result_array();
        
  }   
  function get($params=[], $params_where =[] , $limit =1){
    $params = implode(",", $params);
    $this->db->limit($limit);
    $this->db->select($params);
    foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
    } 
    return $this->db->get("clasificacion")->result_array();
  }
  function get_clasificacion_por_palabra_clave($param){
  
      $query_get  =  "SELECT * FROM clasificacion WHERE nombre_clasificacion LIKE '%".$param["clasificacion"]."%' LIMIT 20";
      return $this->db->query($query_get)->result_array();
    
  }
    function get_clasificacion_por_id($param){
      $id         = $param["id"];
      return $this->q_get($param["fields"] , $id );
    } 
    function get_servicio_nivel($param){
        return $this->get([] , ["flag_servicio" => $param["es_servicio"], "nivel" => $param["nivel"] , "padre" => $param["padre"]] , 100 );
    }
    function num_servicio_nombre($param){
      $params_where =  ["flag_servicio" =>  $servicio, "nombre_clasificacion" =>  $nombre];
      return  $this->get(["COUNT(0)num"] , $params_where, 10000 )[0]["num"];
    }
    function get_clasificaciones_por_padre($padre){
        return $this->get(["id_clasificacion","nombre_clasificacion" ],  ["padre"  => $padre] , 100);        
    }    
    function get_nombre_clasificacion_por_id_clasificacion($param){        
        $response =  $this->q_get(["nombre_clasificacion"], $param["id_clasificacion"]);
        return $response[0]["nombre_clasificacion"];

    }    
    function get_clasificaciones_por_nivel($param){ 
        $params       = ["id_clasificacion","nombre_clasificacion", "flag_servicio"  ];
        $params_where = ["nivel" => $param["nivel"]];
        return $this->get($params ,$params_where , 100 );
    }
    function get_clasificaciones_segundo($array_padre){
        
        $nueva_data =[];
        $a =0;
        foreach ($array_padre as $row) {
            
            $nueva_data[$a] = $row;
            $padre =  $row["id_clasificacion"];
            $nueva_data[$a]["hijos"] = $this->get_clasificaciones_por_padre($padre);
            $a ++;
        }
        return $nueva_data;
    }
    
    function get_clasificaciones_por_id_clasificacion($param){

        $fields = ["id_clasificacion", "nombre_clasificacion"];
        return  $this->q_get($fields, $param["id_clasificacion"]);
    }
    function get_coincidencia($param){

        $query_get ="SELECT 
                        id_clasificacion , 
                        padre  ,
                        nivel                        
                        FROM  
                          clasificacion 
                        WHERE  
                          nombre_clasificacion 
                        LIKE  
                          '%".$param["clasificacion"]."%' 
                        AND 
                          flag_servicio =  '".$param["id_servicio"]."'
                        LIMIT 1";

        return  $this->db->query($query_get)->result_array();
        
    }
    
}