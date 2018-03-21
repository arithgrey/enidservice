<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class clientemodel extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }    
    /**/
    function create_tmp_clientes($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);  
      $nombre_persona  =  $param["nombre"];
      $telefono =  $param["telefono"];

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
                          p.id_usuario_enid_service,
                          f.nombre nombre_fuente 
                        FROM                          
                          persona p                                                 
                        INNER JOIN fuente f 
                          ON p.id_fuente  =  f.id_fuente                        
                        WHERE                                            
                          p.tipo =  '2'
                          AND  
                          p.nombre like '%".$nombre_persona."%'  
                          AND
                          p.tel  like '%".$telefono."%'";
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    /**/
    function get_clientes_enid_service($param){

        $_num =  get_random();        
        $this->create_tmp_clientes($_num , 0  ,$param);
            
            $query_get ="SELECT 
                          p.* 
                        FROM 
                          tmp_personas_$_num p                         
                        ORDER BY 
                          fecha_registro DESC";

            $result =  $this->db->query($query_get);
            $data["info"] = $result->result_array();
          $this->create_tmp_clientes($_num , 1  ,$param);
        
        return $data;
    }
    /**/
    function get_tipificacion(){
      
      $query_get = "SELECT * FROM tipificacion";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_fuente(){
      
      $query_get = "SELECT * FROM fuente";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_servicios(){
      
      $query_get = "SELECT * FROM servicio";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    
    /**/
    function get_tipo_negocio(){
      
      $query_get = "SELECT * FROM tipo_negocio";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function convertir($param){

      $tipo =  $param["tipo"];
      $extra = ''; 
      if ($tipo ==  4 ){
          $extra = " fecha_envio_validacion = CURRENT_TIMESTAMP() , "; 
      }

      $query_update ="UPDATE 
                        persona 
                        SET 
                          tipo = '".$tipo."' ,
                          ".$extra."
                          fecha_cambio_tipo = current_date()
                        WHERE 
                          id_persona = '".$param["id_persona"]."' 
                        LIMIT 1";
      return $this->db->query($query_update);

    }
    /**/
    function get_comentarios_persona($param){

      $id_persona = $param["id_persona"];
      $query_get =" SELECT 
                      c.* , 
                      t.nombre_tipificacion
                    FROM comentario c
                    INNER JOIN 
                      tipificacion t 
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
                    ON 
                      p.id_persona =  tp.id_persona
                    INNER JOIN tipo_negocio t 
                    ON 
                      tp.idtipo_negocio =  t.idtipo_negocio
                    INNER JOIN servicio s 
                    ON 
                      p.id_servicio =  s.id_servicio
                    INNER JOIN fuente f 
                    ON 
                      p.id_fuente  =  f.id_fuente
                    WHERE 
                    p.id_persona = '".$id_persona."'  LIMIT 1";
                        
                        
      $result=  $this->db->query($query_get); 
      return $result->result_array();
    }
    /**/
    function get_clientes($param){
        
        $_num =  get_random();
        
          $this->create_tmp_personas($_num , 0  ,$param);
            
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

          $this->create_tmp_personas($_num , 1  ,$param);
        
        return $data;

    }
    /**/
    
    /**/
    function get_usuario_ventas(){
    
      $query_insert = "SELECT idusuario FROM usuario WHERE email ='ventas@enidservice.com' LIMIT 1"; 
      $result = $this->db->query($query_insert);
      return $result->result_array()[0]["idusuario"];
    } 
    /**/    
    function create_tmp_personas($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];      
      $nombre_persona  =  $param["nombre"];
      $telefono =  $param["telefono"];
      
      $tipo = $param["tipo"];
      $usuario_validacion =  $param["usuario_validacion"];      
      $mensual = $param["mensual"];

      $sql_extra_telefono = "";
      $extra_tiempo =  "";

      $id_usuario_ventas =  $this->get_usuario_ventas(); 
      $sql_extra =" AND  
                    p.id_usuario in ('".$id_usuario."'  , '".$id_usuario_ventas ."')";

     
      
      if($usuario_validacion ==  1){
        $sql_extra ="";
      }if( strlen(trim($telefono)) > 0 ){
        $sql_extra_telefono = "AND p.tel like '%".$telefono."%' ";
      }if ($mensual ==  1) {        
        $extra_tiempo =  " AND 
                            YEAR(p.fecha_cambio_tipo) =  YEAR(current_date()) 
                          AND
                              MONTH(p.fecha_cambio_tipo) =  MONTH(current_date())";
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
                        WHERE                        
                        (
                          p.nombre like '%".$nombre_persona."%' 
                          OR 
                          p.a_paterno like '%".$nombre_persona."%' 
                          OR 
                          p.a_materno like '%".$nombre_persona."%' 
                          )                        
                          AND 
                          p.tipo =  '".$tipo ."'
                           ".$sql_extra_telefono."
                        ".$sql_extra
                        
                        .$extra_tiempo;
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    /**/

    /**********************************************************+*/




















    function create_tmp_personas_q($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);      
      $tipo = $param["tipo"];
      
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
                          p.tipo  ,
                          p.id_usuario ,                                                     
                          p.fecha_envio_validacion , 
                          s.nombre_servicio                           
                        FROM                          
                          persona p                                                                         
                        INNER JOIN servicio s 
                          ON 
                          p.id_servicio 
                          = 
                          s.id_servicio
                        WHERE                                                
                          p.tipo =  '".$tipo."' ";

                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    /**/


    function get_clientesq($param){
        
        $_num =  get_random();
        
          $this->create_tmp_personas_q($_num , 0  ,$param);
            
            $query_get ="SELECT 
                          p.* ,
                          t.nombre tipo_negocio ,
                          u.nombre nombre_transf ,
                          u.apellido_paterno apaterno_transf,
                          u.apellido_materno  amaterno_transf
                        FROM 
                          tmp_personas_$_num p 
                        INNER JOIN tipo_negocio_persona tp 
                          ON p.id_persona =  tp.id_persona
                        INNER JOIN tipo_negocio t 
                          ON tp.idtipo_negocio =  t.idtipo_negocio                        
                        INNER JOIN usuario  u
                          ON 
                          p.id_usuario =  u.idusuario
                        ORDER BY 
                          fecha_registro 
                        DESC";

            $result =  $this->db->query($query_get);
            $data["info"] = $result->result_array();

          $this->create_tmp_personas_q($_num , 1  ,$param);
        
        return $data;

    }
    /**/
    function get_clientes_por_tipificacion($param){
        
        $_num =  get_random();
        
        $this->create_tmp_personas_por_tipificacion($_num , 0  ,$param);
            
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

          $this->create_tmp_personas_por_tipificacion($_num , 1  ,$param);
        
        return $data;

    }
    /**/




    function create_tmp_personas_por_tipificacion($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];      
      $nombre_persona  =  $param["nombre"];
      $telefono =  $param["telefono"];
      
      $tipo = $param["tipo"];
      $usuario_validacion =  $param["usuario_validacion"];      
      $mensual = $param["mensual"];

      
      $extra_tiempo =  "AND date(p.fecha_registro) = '".$param["fecha_registro"]."'";
      $sql_extra =" AND  
                    p.id_usuario = '".$id_usuario."' ";

     
    

      

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
                          f.nombre nombre_fuente 
                        FROM                          
                          persona p                                                 
                        INNER JOIN fuente f 
                          ON p.id_fuente  =  f.id_fuente                        
                        WHERE                                            
                          p.tipo =  '1'

                        ".$sql_extra                        
                        .$extra_tiempo;
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    


    /*USUARIO CAMPO*/
    function get_clientes_usuario_campo($param){
        
        $_num =  get_random();        
          $this->create_tmp_personas_clientes_clientes_campo($_num , 0  ,$param);
            
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

          $this->create_tmp_personas_clientes_clientes_campo($_num , 1  ,$param);
        
        return $data;

    }
    /**/
    function create_tmp_personas_clientes_clientes_campo($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);
    
      $id_usuario =  $param["id_usuario"];      
      $nombre_persona  =  $param["nombre"];
      $telefono =  $param["telefono"];      
     
      $sql_extra_telefono = "";            
      $sql_extra =" AND  p.id_usuario = '".$id_usuario."' ";
      
      /**/
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
                          p.tipo =  '2'
                           ".$sql_extra_telefono."
                        ".$sql_extra;
                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    


















   
}