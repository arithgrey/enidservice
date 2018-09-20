<?php defined('BASEPATH') OR exit('No direct script access allowed');
class tareasmodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  function q_get($params=[], $id){
    return $this->get($params, ["id_servicio" => $id ] );
  }
  function q_up($q , $q2 , $id_usuario){
    return $this->update([$q => $q2 ] , ["idusuario" => $id_usuario ]);
  }
  function update($data =[] , $params_where =[] , $limit =1 ){
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("tarea", $data);
    
  }
  function insert( $params , $return_id=0){        
      $insert   = $this->db->insert("tarea", $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
  }
  
  function get( $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get("tarea")->result_array();
  }  
  function create($param){
    $params = [
        "descripcion"       =>  $param["tarea"] ,
        "id_ticket"         =>  $param["id_ticket"] ,
        "usuario_registro"  =>  $param["id_usuario"]
    ];
    return $this->insert($params);
    
  }  
  function update_estado_tarea($param){
      
    $params =[
      "status"        => $param["nuevo_valor"] , 
      "fecha_termino" => CURRENT_TIMESTAMP()
    ];
    $params_where = ["id_tarea" =>  $param["id_tarea"] ];
    $this->update($params, $params_where);
    return $this->valida_tareas_pendientes($param);
  }    
  function get_tareas_ticket_num($param){

    $id_ticket =  $param["id_ticket"];    
    $query_get = "SELECT 
                  count(0) tareas ,  
                  sum(case when status = 0 then 1 else 0 end )pendientes
                  FROM tarea 
                  WHERE 
                  id_ticket = '".$id_ticket."' ";
    $result = $this->db->query($query_get);
    return $result->result_array();
  }
  /**/  
  function get_tareas_ticket($param){

    $id_ticket =  $param["id_ticket"];    
    $query_get = "SELECT 
                  t.*,
                    u.idusuario  , 
                    u.nombre ,                   
                    u.apellido_paterno,
                    u.apellido_materno ,
                    COUNT(r.id_respuesta) num_comentarios                  
                  FROM 
                    tarea t
                  LEFT OUTER JOIN 
                    usuario u 
                  ON t.usuario_registro = u.idusuario 
                  LEFT OUTER JOIN 
                    respuesta r 
                    ON 
                    t.id_tarea =  r.id_tarea

                  WHERE 
                    t.id_ticket = '".$id_ticket ."'
                  GROUP BY t.id_tarea
                  ORDER BY 
                  t.fecha_registro 
                  ASC";


    $result = $this->db->query($query_get);
    return $result->result_array();
  }
 

}