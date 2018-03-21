<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class posiblesclientesmodel extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function create_temporal_comentarios_llamadas($_num , $flag , $param){
      
      $query_drop ="DROP TABLE IF EXISTS tmp_comentarios_$_num"; 
      $this->db->query($query_drop);
      $id_persona = $param["id_persona"]; 

        if ($flag ==  0){
          
          $query_create = "CREATE TABLE tmp_comentarios_$_num AS 
                            SELECT  
                              idusuario,                               
                              comentario ,  
                              7 'id_tipificacion'

                            FROM llamada  l 
                            WHERE l.id_persona = '".$id_persona."'
                            UNION ALL
                            SELECT
                              idusuario ,                              
                              comentario ,
                              id_tipificacion  'id_tipificacion'
                            FROM 
                            comentario c 
                            WHERE 
                            c.id_persona = '".$id_persona."' ";     
            $this->db->query($query_create);
        }
    }
    /**/
    function get_comentarios_persona($param){

      /*****/
      $id_persona = $param["id_persona"];
      $_num =  get_random();
      $this->create_temporal_comentarios_llamadas($_num , 0 , $param);
        $this->create_tmp_persona($_num , 0 , $param);
            /**/            
            $query_get ="SELECT 
                            c.* , 
                              t.nombre_tipificacion,
                              t.icono ,
                              u.* 
                              FROM tmp_comentarios_$_num c
                              INNER JOIN 
                                tipificacion t 
                              ON c.id_tipificacion = t.id_tipificacion                        
                              INNER JOIN 
                              tmp_usuario_$_num u 
                              ON 
                              c.idusuario =  u.idusuario
                              LIMIT 100";
          
          $result = $this->db->query($query_get);
          $data =   $result->result_array();
        $this->create_tmp_persona($_num , 1 , $param);    
      $this->create_temporal_comentarios_llamadas($_num , 1 , $param);
      return $data;
    }
    /**/
    function create_tmp_persona($_num , $flag , $param){
          
        $query_drop ="DROP TABLE IF EXISTS tmp_usuario_$_num";
        $this->db->query($query_drop);
        if($flag ==  0 ){
            
            $query_create="CREATE TABLE tmp_usuario_$_num AS 
                          SELECT 
                          idusuario , 
                          nombre ,  
                          apellido_paterno ,  
                          apellido_materno , 
                          email 
                          FROM usuario";
            $this->db->query($query_create);  
        }
    }
    /**/
    function get_info_persona($param){

      $id_persona = $param["id_persona"];

      $query_get ="SELECT 
                      p.* ,                    
                      f.nombre nombre_fuente
                    FROM 
                      persona 
                    p 
                    INNER JOIN fuente f 
                    ON 
                      p.id_fuente  =  f.id_fuente
                    WHERE 
                      p.id_persona = '".$id_persona."'  LIMIT 1";
                        
      $result=  $this->db->query($query_get); 
      return $result->result_array();
    }
    function get_usuario_ventas(){
    
      $query_insert = "SELECT idusuario FROM usuario WHERE email ='ventas@enidservice.com' LIMIT 1"; 
      $result = $this->db->query($query_insert);
      return $result->result_array()[0]["idusuario"];
    } 
    /**/
    function get_posibles_clientes($param){
        
        $_num =  get_random();        
          $this->create_tmp_personas($_num , 0  ,$param);

            $tipo = $param["tipo"];            
            $query_get ="SELECT 
                          p.* ,
                          t.nombre tipo_negocio,                            
                          u.nombre nombre_usuario_venta,
                          u.apellido_paterno apaterno_usuario_venta,
                          u.apellido_materno amaterno_usuario_venta 
                         FROM 
                          tmp_personas_$_num p 
                        INNER JOIN tipo_negocio_persona tp 
                          ON p.id_persona =  tp.id_persona
                        INNER JOIN tipo_negocio t 
                          ON tp.idtipo_negocio =  t.idtipo_negocio
                        INNER JOIN  usuario  u 
                          ON 
                          p.id_usuario = u.idusuario
                        WHERE 
                          p.tipo IN('".$tipo."' , 11)                          
                        ORDER 
                        BY 
                        p.fecha_registro DESC";

            $result =  $this->db->query($query_get);
            $data["info"] = $result->result_array();

          $this->create_tmp_personas($_num , 1  ,$param);
        
        return $data;

    }
    /**/    
    function create_tmp_personas($_num , $flag , $param ){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];
      $usuario_validacion = $param["usuario_validacion"];

      $extra_sql = " AND p.id_usuario = '".$id_usuario."'";
      if ($usuario_validacion ==  1){
          $extra_sql = "";
      }
      if ($flag == 0){

            $query_create ="CREATE TABLE tmp_personas_$_num 
                        AS 
                        SELECT        
                          p.id_usuario , 
                          p.fecha_registro ,                
                          p.id_persona ,
                          p.nombre     ,
                          p.a_paterno  ,
                          p.a_materno  ,
                          p.tel        ,
                          p.tel_2      ,
                          p.sitio_web  ,
                          p.tipo , 
                          p.correo     ,                          
                          f.nombre nombre_fuente ,
                          s.nombre_servicio, 
                          p.id_usuario_enid_service                          

                        FROM                          
                        persona p                                                 
                        INNER JOIN fuente f 
                          ON p.id_fuente  =  f.id_fuente
                        INNER JOIN servicio s 
                          ON p.id_servicio = s.id_servicio
                        WHERE 
                          p.status = 1 
                       ".$extra_sql ;
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    /******************************************/
    function get_posibles_clientes_usuario_campo($param){
        
        $_num =  get_random();
        
          $this->create_tmp_personas_posibles_clientes_campo($_num , 0  ,$param);
            
            $query_get ="SELECT 
                          p.* ,
                          t.nombre 
                          tipo_negocio
                        FROM 
                          tmp_personas_$_num p 
                        INNER JOIN tipo_negocio_persona tp 
                          ON 
                          p.id_persona =  tp.id_persona
                        INNER JOIN tipo_negocio t 
                          ON 
                          tp.idtipo_negocio =  t.idtipo_negocio
                        ORDER BY 
                          fecha_registro DESC";

            $result =  $this->db->query($query_get);
            $data["info"] = $result->result_array();

          $this->create_tmp_personas_posibles_clientes_campo($_num , 1  ,$param);
        
        return $data;

    }
    /**/
    function create_tmp_personas_posibles_clientes_campo($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
    
      $id_usuario =  $param["id_usuario"];      
      $nombre_persona  =  $param["nombre"];
      $telefono =  $param["telefono"];            
      /**/
      $sql_extra_telefono = "";                        
      if( strlen(trim($telefono)) > 0 ){
        $sql_extra_telefono = "AND p.tel like '%".$telefono."%' ";
      }
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
                          p.tipo  ,
                          p.correo     ,
                          f.nombre nombre_fuente ,
                          s.nombre_servicio                           
                        FROM                          
                          persona p                                                 
                        INNER JOIN fuente f 
                          ON p.id_fuente  =  f.id_fuente
                        INNER JOIN servicio s 
                          ON p.id_servicio = s.id_servicio
                        WHERE (

                            p.nombre like '%".$nombre_persona."%' 
                            OR 
                            p.a_paterno like '%".$nombre_persona."%' 
                            OR 
                          p.a_materno like '%".$nombre_persona."%' 
                          )                        
                          AND 
                          p.tipo =  '1'
                           ".$sql_extra_telefono."
                        ";
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    
    /**/

    function get_posibles_clientes_tipificacion($param){
        
        $_num =  get_random();
        
          $sql =  $this->create_tmp_personas_tipificacion($_num , 0  ,$param);
            
            $query_get ="SELECT 
                          p.* ,
                          t.nombre tipo_negocio                        
                        FROM 
                          tmp_personas_$_num p 
                        INNER JOIN tipo_negocio_persona tp 
                          ON 
                          p.id_persona =  tp.id_persona
                        INNER JOIN tipo_negocio t 
                          ON 
                          tp.idtipo_negocio =  t.idtipo_negocio
                        ORDER BY 
                          fecha_registro DESC";

            $result =  $this->db->query($query_get);
            $data_complete["info"] = $result->result_array();
            $data_complete["info_sql"] = $sql;


          $this->create_tmp_personas_tipificacion($_num , 1  ,$param);
        
        return $data_complete;

    }
    /**/
    function create_tmp_personas_tipificacion($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
    
      $id_usuario =  $param["id_usuario"];                                 
      $tipificacion =  $param["tipificacion"]; 
      $fecha_registro =  $param["fecha_registro"];

      $query_create_2  = "";

      $sql_extra =" p.tipo = '".$tipificacion."'                           
                    AND  
                      p.id_usuario = '".$id_usuario."' 
                    AND 
                    (
                      DATE(p.fecha_registro) = '".$fecha_registro."' 
                      OR
                      DATE(p.fecha_cambio_tipo ) = '".$fecha_registro."' 
                    )";
      /**/
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
                          p.tipo  ,
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
                          ".$sql_extra;
            
             $query_create_2 =  $query_create;              
            $this->db->query($query_create);
      }
      /**/      
      return $query_create_2;
    }
    /**/
    
}