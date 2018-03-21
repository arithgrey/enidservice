<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class posiblesclientesmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_info_usuario($param){

        $query_get ="SELECT 
                    nombre ,   
                    apellido_paterno ,
                    apellido_materno,                      
                    email 
                   FROM 
                    usuario 
                   WHERE 
                    idusuario = '".$param["id_usuario"]."' 
                    LIMIT 1";
        $result = $this->db->query($query_get);
        return $result->result_array();

    }
    /**/
    function get_comentarios_persona($param){

      $id_persona = $param["id_persona"];
      $query_get =" SELECT 
                      c.* , 
                      t.nombre_tipificacion
                    FROM comentario c
                    INNER JOIN tipificacion t 
                    ON c.id_tipificacion = t.id_tipificacion
                    WHERE 
                    c.id_persona= '".$id_persona."'  
                    ORDER BY fecha_registro DESC 
                    LIMIT 100";
      $result = $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_info_persona($param){

      $id_persona = $param["id_persona"];

      $query_get ="SELECT 
                    p.* ,
                    t.nombre tipo_negocio,
                    s.nombre_servicio,
                    f.nombre nombre_fuente
                    FROM 
                    persona p 
                    INNER JOIN tipo_negocio_persona tp 
                    ON p.id_persona =  tp.id_persona
                    INNER JOIN tipo_negocio t 
                    ON 
                    tp.idtipo_negocio =  t.idtipo_negocio
                    INNER JOIN servicio s 
                    ON 
                    p.id_servicio =  s.id_servicio
                    INNER JOIN fuente f 
                    ON p.id_fuente  =  f.id_fuente
                    WHERE p.id_persona = '".$id_persona."'  LIMIT 1";
                        
                        
      $result=  $this->db->query($query_get); 
      return $result->result_array();
    }
    /**/
    function get_posibles_clientes($param){
        
        $_num =  get_random();
        
          $this->create_tmp_personas($_num , 0  ,$param);
            
            $query_get ="SELECT 
                          p.* ,
                          t.nombre tipo_negocio
                        FROM 
                          tmp_personas_$_num p 
                        INNER JOIN tipo_negocio_persona tp 
                          ON p.id_persona =  tp.id_persona
                        INNER JOIN tipo_negocio t 
                          ON tp.idtipo_negocio =  t.idtipo_negocio
                        ORDER BY 
                          fecha_registro DESC";

            $result =  $this->db->query($query_get);
            $data["info"] = $result->result_array();

          $this->create_tmp_personas($_num , 1  ,$param);
        
        return $data;

    }
    /**/    
    function create_tmp_personas($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];

      if ($flag == 0){

            $query_create ="CREATE TABLE tmp_personas_$_num 
                        AS 
                        SELECT        
                          p.fecha_registro ,                
                          p.id_persona ,
                          p.nombre     ,
                          p.a_paterno  ,
                          p.a_materno  ,
                          p.tel        ,
                          p.tel_2      ,
                          p.sitio_web  ,
                          p.correo     ,
                          f.nombre nombre_fuente ,
                          s.nombre_servicio                           
                        FROM                          
                        persona p                                                 
                        INNER JOIN fuente f 
                        ON p.id_fuente  =  f.id_fuente
                        INNER JOIN servicio s 
                        ON p.id_servicio = s.id_servicio
                        WHERE 
                          p.status = 1 
                        AND  
                          p.id_usuario = '".$id_usuario."' ";
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    /**/


    
}