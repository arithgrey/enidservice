<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class mensajemodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert_comentario($param){

      /**/
      $comentario = $param["comentario"];
      $id_persona =  $param["id_persona"];
      $id_usuario =  $param["id_usuario"];
      $id_tipificacion = $param["tipificacion"];

      $query_insert =  "INSERT INTO 
                        comentario(
                          comentario,    
                          id_persona ,   
                          idusuario ,
                          id_tipificacion
                        )
                        VALUES(
                          '".$comentario."',
                          '".$id_persona."',                          
                          '".$id_usuario."' ,
                          '".$id_tipificacion."' 
                        )";
      
      return  $this->db->query($query_insert);      
                        

  }
    /**/
    function get_mensaje($param){

        $id_mensaje = $param["id_mensaje"];
        $query_get ="SELECT * FROM mensaje WHERE 
                    id_mensaje = '".$id_mensaje."' LIMIT 1 ";
        $result  =  $this->db->query($query_get);
        return  $result->result_array();   
        
    }

    /**/
    function get_servicio($param){

        $id_servicio =  $param["servicio"];  
        $query_get = "SELECT * FROM servicio 
                        WHERE 
                        id_servicio = '".$id_servicio."' LIMIT 1";
        $result  =  $this->db->query($query_get);
        return  $result->result_array();        
    }
    /**/
    function get_servicios($param){

        $query_get = "SELECT * FROM servicio ORDER BY fecha_registro ASC";
        $result  =  $this->db->query($query_get);
        return  $result->result_array();        
    }
    /**/
    function update_mensaje_red_social($param){


        $red_social =  $param["red_social"];
        $servicio = $param["servicio"];
        $id_mensaje =  $param["id_mensaje"];
        $tipo_negocio = $param["tipo_negocio"];


        $query_update ="INSERT INTO mensaje(
                        titular, 
                        enlace ,  
                        descripcion , 
                        status,                         
                        llamada_a_la_accion , 
                        red_social , 
                        servicio ,
                        idtipo_negocio
                        )
                        SELECT 
                        titular , 
                        enlace  ,  
                        descripcion , 
                        status ,             
                        llamada_a_la_accion ,
                        '".$red_social ."' , 
                        '".$servicio."' ,
                        '".$tipo_negocio."'
                        FROM mensaje WHERE id_mensaje='".$id_mensaje."'";

        return $this->db->query($query_update);
    }
    /**/
    /**/
    function insert_comando($param){

        $referencia = $param["referencia"];
        $comando = $param["comando"];        
        $query_insert ="INSERT INTO comando(comando , tipo) VALUES('".$comando."' , '".$referencia."'  )";
        return $this->db->query($query_insert);
        
    }
    /**/
    function get_comandos_ayuda($param){

        $query_get =  "SELECT * FROM comando";
        $result  =  $this->db->query($query_get);
        return  $result->result_array();
        
    }
    /**/
    function delete_mensaje_red_social($param){


        $id_mensaje =  $param["id_mensaje"];
        $query_delete =  "DELETE FROM mensaje WHERE id_mensaje = '".$id_mensaje."' LIMIT  1";
        return  $this->db->query($query_delete);
    }

    /**/
    function get_mensaje_red_social($param){
    
        $modalidad =  $param["modalidad"];        
        $contador =  $param["contador"];        
        $keyword = $param["keyword"];
        $sql_extra ="ORDER BY m.fecha_registro DESC LIMIT 1";

        if (intval($contador) < 0 ){
            $sql_extra ="ORDER BY m.fecha_registro ASC LIMIT ".abs(intval($contador));        
        }if (intval($contador) > 0 ){
            $sql_extra ="ORDER BY m.fecha_registro DESC LIMIT " .abs(intval($contador));
        }   
        $query_where_extra = " AND 
                                (
                                    m.descripcion  like '%".$keyword."%'
                                    OR 
                                    m.nombre_producto_promocion  like '%".$keyword."%'
                                    OR 
                                    m.servicio  like '%".$keyword."%'
                                ) ";


        $query_get ="SELECT 
                        m.* ,                        
                        u.nombre ,
                        u.email , 
                        u.apellido_paterno , 
                        u.apellido_materno, 
                        s.nombre_servicio,
                        s.url_web_servicio
                    FROM 
                        mensaje  m                    
                    INNER JOIN 
                        usuario u 
                    ON 
                        u.idusuario =  m.id_usuario
                    INNER JOIN servicio  s ON 
                        m.servicio = s.id_servicio 
                    WHERE 
                        m.flag_servicio = '".$param["modalidad"]."'                      
                        ".$query_where_extra.$sql_extra;
                    
        $result =  $this->db->query($query_get);
        $data["mensaje"]=  $result->result_array();
        $data["sql"] = $query_get;
        return $data;
    }
    /**/
   
    /**/
    function insert_mensaje_red_social($param){

     
        $modalidad =  $param["modalidad"];
        $nombre_producto = $param["nombre_producto"];            
        $red_social =  $param["red_social"]; 
        $descripcion =  $param["mensaje"]; 
        $id_usuario =  $param["id_usuario"];                                      
        $servicio =  $param["servicio"];        
        
        /**/        
        $query_insert =  "INSERT INTO mensaje(                                
                                descripcion  , 
                                red_social ,                             
                                id_usuario, 
                                servicio , 
                                flag_servicio,
                                nombre_producto_promocion
                            )VALUES(
                                '".$descripcion ."', 
                                '".$red_social."' ,                            
                                '".$id_usuario."', 
                                '".$servicio."',                                
                                '".$modalidad."',
                                '".$nombre_producto."'
                            )";
        
        
        return   $this->db->query($query_insert);
     
    }
    /**/    
    function update_mensaje($param){

        /*
        $modalidad =  $param["modalidad"];
        $nombre_producto = $param["nombre_producto"];            
        $red_social =  $param["red_social"]; 
        */
        $descripcion =  $param["mensaje"]; 
        
        /*$id_usuario =  $param["id_usuario"];                                      
        $servicio =  $param["servicio"];        
        */
        $id_mensaje =  $param["id_mensaje"];
        
        

        $query_update ="UPDATE mensaje 
                        SET                                                                    
                            descripcion = '".$descripcion ."'                        
                        WHERE 
                            id_mensaje = '".$id_mensaje."'
                        LIMIT 1";


        return $this->db->query($query_update);
        
    }
    
    
   
}