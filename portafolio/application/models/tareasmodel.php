<?php defined('BASEPATH') OR exit('No direct script access allowed');
class tareasmodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  function get_num_respuestas($param){

    $id_tarea  = $param["tarea"];
      $query_get ="SELECT 
                    COUNT(0)num_respuestas
                   FROM 
                    respuesta 
                   WHERE id_tarea = '".$id_tarea."' ";

      $result =  $this->db->query($query_get);             
      return $result->result_array()[0]["num_respuestas"];
    
  }
  /**/
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
  /**/
  function registra_respuesta($param){

    $id_tarea  = $param["tarea"];
    $id_usuario  =  $param["id_usuario"];
    $respuesta =  $param["mensaje"];
    $query_insert ="INSERT INTO respuesta(
                     respuesta,      
                     id_tarea  ,    
                     id_usuario 
                    )
                    VALUES(
                      '".$respuesta."' ,  
                      '".$id_tarea."' , 
                      '".$id_usuario."'  
                    )";
    return $this->db->query($query_insert);

  }

  /**/
  function update_estado_tarea($param){

    $query_update =  "UPDATE tarea 
    SET
      status  = '".$param["nuevo_valor"]."' , 
      fecha_termino = CURRENT_TIMESTAMP()
    WHERE 
    id_tarea =  '".$param["id_tarea"]."' 

    LIMIT 1 ";
    $db_response =  $this->db->query($query_update);
    return $this->valida_tareas_pendientes($param);
    

  }
  /***/
  function valida_tareas_pendientes($param){

    $id_ticket =  $param["id_ticket"];
    $query_get = "select count(*)num_tareas_pendientes
                  from 
                  tarea 
                  where 
                  status =0 
                  and id_ticket ='".$id_ticket."' ";

    $result =  $this->db->query($query_get);              
    $num_pendientes =  $result->result_array()[0]["num_tareas_pendientes"];


    $nuevo_estado_ticket ="";
    if ($num_pendientes == 0 ) {
      

        $query_update = "UPDATE ticket SET 
                          status = 1 
                          WHERE id_ticket = '".$id_ticket."' LIMIT 1"; 
        $this->db->query($query_update);

        $nuevo_estado_ticket ="cerrado";
    }else{


        $query_update = "UPDATE ticket 
                          SET status = 0
                          WHERE 
                          id_ticket = '".$id_ticket."' 
                          LIMIT 1"; 
        $this->db->query($query_update);
        $nuevo_estado_ticket ="abierto";
    }

    

    return $nuevo_estado_ticket;

  }
  /**/
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
                    t.id_ticket 
                    = '".$id_ticket ."'

                  GROUP BY t.id_tarea
                  ORDER BY 
                  t.fecha_registro 
                  DESC";

    $result = $this->db->query($query_get);
    return $result->result_array();
  }  
  /**/
  function insert_tarea($param){

    $descripcion =  $param["tarea"];
    $id_ticket =  $param["id_ticket"];
    $id_usuario =  $param["id_usuario"];

      $query_insert = "INSERT INTO 
                        tarea( 
                        descripcion , 
                        id_ticket, 
                        usuario_registro)
                      VALUES(
                      '".$descripcion ."' , 
                      '".$id_ticket ."' , 
                      '".$id_usuario."')";

      $this->db->query($query_insert);
      

     
      return  $this->valida_tareas_pendientes($param);
    
  }
/**/  
}