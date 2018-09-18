<?php defined('BASEPATH') OR exit('No direct script access allowed');
class clasificacion_model extends CI_Model{
  
  function __construct(){
      parent::__construct();        
      $this->load->database();
  }   
  private function q_get($params=[], $id){
        return $this->get("clasificacion", $params, ["id_clasificacion" => $id ] );
    }
    function q_up($q , $q2 , $id_usuario){
        return $this->update("clasificacion" , [$q => $q2 ] , ["idusuario" => $id_usuario ]);
    }

  function insert($tabla ='imagen', $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
  private function update($table='imagen' , $data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update($table, $data);
    
  }
  function get_clasificacion_padre_nivel($param){                        
        return  $this->get("clasificacion", ["id_clasificacion" , "padre" , "nivel" ], [ "id_clasificacion" => $param["padre"] ] );
  }    
  function get_intereses_usuario($param){

        $id_usuario =  $param["id_usuario"];

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
                uc.id_usuario =$id_usuario
            WHERE 
                c.nivel =1 
            AND 
                c.flag_servicio =0";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }   
  private function get($table='imagen' , $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get($table)->result_array();
  }
  function get_clasificacion_por_palabra_clave($param){
    
    $clasificacion  =  $param["clasificacion"];
    $query_get      =  "SELECT * FROM clasificacion 
                        WHERE 
                          nombre_clasificacion 
                        LIKE '%".$clasificacion."%' 
                        LIMIT 20";


    $result         =   $this->db->query($query_get);
    return $result->result_array(); 
  }
  
  function get_clasificacion_por_id($param){
    $id         = $param["id"];
    return $this->q_get($param["fields"] , $id );
  } 
  
  
  function get_clasificacion_nivel($param){

      $es_servicio  =  $param["es_servicio"];
      $nivel        =  $param["nivel"];
      $padre        =  $param["padre"];
      return $this->get('clasificacion' , [] , ["flag_servicio" => $es_servicio, "nivel" => $nivel , "padre" => $padre] , 100 );
  }
  function count_clasificacion($param){

    $nombre   =    $param["clasificacion"];
    $servicio =  $param["servicio"];
    $query_get = "SELECT COUNT(0)num FROM clasificacion 
                  WHERE 
                  flag_servicio =  '".$servicio."'
                  AND 
                  nombre_clasificacion =  '".$nombre."' LIMIT 1 ";
    $result =  $this->db->query($query_get);
    $response["existencia"] =  $result->result_array()[0]["num"];
    return $response;
  }
  
  
  function add_clasificacion($param){

      $nivel          =  $param["nivel"];
      $clasificacion  =  $param["clasificacion"];
      $tipo           =  $param["tipo"];
      $padre          =  $param["padre"];
      
      $params = [

        "nombre_clasificacion"  =>  $clasificacion,
        "flag_servicio"         =>  $tipo,
        "padre"                 =>  $padre,
        "nivel"                 =>  $nivel
      ];
      return $this->insert("clasificacion", $params);
  }
    
    function get_clasificaciones_por_padre($padre){
        return $this->get("clasificacion" , ["id_clasificacion","nombre_clasificacion" ],  ["padre"  => $padre] , 100);        
    }    
    function get_nombre_clasificacion_por_id_clasificacion($param){        
        $response =  $this->q_get(["nombre_clasificacion"], $param["id_clasificacion"]);
        return $response[0]["nombre_clasificacion"];

    }    
    function get_clasificaciones_por_nivel($param){

        $nivel      =  $param["nivel"];        
        $params       = ["id_clasificacion","nombre_clasificacion"];
        $params_where = ["nivel" => $nivel];
        return $this->get("clasificacion" , $params ,$params_where , 100 );
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
    function get_clasificaciones_primer_nivel_nombres($param){
        
        $params         = ["nombre_clasificacion" ,"id_clasificacion" , "flag_servicio"  ];
        $params_where   = ["nivel"=> 1];
        return $this->get("clasificacion" , $params , $params_where , 50);
    }
    function get_clasificaciones_por_id_clasificacion($param){

        $fields = ["id_clasificacion", "nombre_clasificacion"];
        return  $this->q_get($fields, $param["id_clasificacion"]);
    }
    function get_coincidencia($param){

        $clasificacion  =  $param["clasificacion"];
        $servicio       =  $param["id_servicio"];
        $query_get ="SELECT 
                        id_clasificacion , 
                        padre  ,
                        nivel                        
                        FROM  
                    clasificacion 
                        WHERE  
                    nombre_clasificacion 
                        LIKE  
                        '%".$clasificacion."%' 
                        AND 
                        flag_servicio =  '".$servicio."'
                    LIMIT 1";

        $result =  $this->db->query($query_get);
        return $result->result_array();            
    }
    function get_categorias_servicios($param){
        
        $modalidad  =  $param["modalidad"];            
        $nivel      =  $param["nivel"];            
        $padre      = $param["padre"];
        $params_where = [   "padre"         => $padre,
                            "flag_servicio" => $modalidad,
                            "nivel"         => $nivel 
                        ];
        
        return $this->get("clasificacion" , [] , $params_where , 100);
    }
    
 
}