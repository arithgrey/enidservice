<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Respuesta_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function update($data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("respuesta", $data);    
    }
    function insert( $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function get( $params=[], $params_where =[] , $limit =1){
      $params = implode(",", $params);
      $this->db->limit($limit);
      $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
      return $this->db->get("respuesta")->result_array();
    }
    function get_num_respuestas($param){

      /*
      $id_tarea  = $param["tarea"];
      $query_get ="SELECT  COUNT(0)num_respuestas FROM  respuesta WHERE id_tarea = '".$id_tarea."' ";

      $result =  $this->db->query($query_get);             
      return $result->result_array()[0]["num_respuestas"];
      */
      return $this->get(["COUNT(0)num"] , ["id_tarea" => $param["tarea"]])[0]["num"];
    
    }
    /*
  	function actualiza_estado_pregunta($param){

      $id_pregunta =  $param["pregunta"];    
      $type =  ($param["modalidad"]== 1) ? 1:0;
      return $this->update("pregunta", ["leido_vendedor" => $type ]  , ["id_pregunta" =>  $id_pregunta]);
    }
    */
    function get_respuestas($param){
    
      $id_tarea  = $param["tarea"];
      $query_get ="SELECT 
                     r.*, 
                     u.nombre , 
                     u.apellido_paterno ,
                     u.apellido_materno ,
                     up.idperfil
                   FROM 
                    respuesta  r
                   INNER JOIN
                    usuario u                    
                   ON 
                    r.id_usuario =  u.idusuario                  
                   INNER JOIN usuario_perfil up 
                    ON u.idusuario = up.idusuario                    
                   WHERE 
                    r.id_tarea = '".$id_tarea."' 

                   ORDER BY 
                   r.fecha_registro DESC 
                   ";
      $result =  $this->db->query($query_get);             
      return $result->result_array();
    }    
    /*
    function registra_respuesta($param){

    $id_tarea     =   $param["tarea"];
    $id_usuario   =   $param["id_usuario"];
    $respuesta    =   $param["mensaje"];
    $params       =   [
        "respuesta"     =>  $respuesta,
        "id_tarea"      =>  $id_tarea,
        "id_usuario"    =>  $id_usuario
    ];
    
    return $this->insert("respuesta" , $params);

    }
    */
  
}
