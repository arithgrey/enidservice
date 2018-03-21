<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class agendadosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_num_tareas_pendientes_area($param){

      $query_get = "SELECT 
                    COUNT(0)num_tareas_pendientes 
                    FROM ticket ti 
                    INNER JOIN tarea t  
                    ON ti.id_ticket =  t.id_ticket  
                    WHERE 
                    ti.status =0 
                    AND 
                    ti.id_departamento =2
                    AND t.status =0";
      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_tareas_pendientes"];
    }
    /**/
    function get_data_tickets_pendientes($param){

      $query_get ="select id_ticket from ticket where id_departamento =2 AND status =0";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_num_clientes_restantes($param){

      $id_usuario =  $param["id_usuario"];
      
      $query_get = "SELECT 
                      count(*)num_avance_dia
                    FROM 
                    persona 
                      WHERE 
                    tipo 
                      IN(2 , 4) 
                    AND                        
                      id_usuario ='".$id_usuario."'
                    AND 

                      ( DATE(fecha_cambio_tipo) =  DATE(CURRENT_DATE())
                        OR 
                        DATE(fecha_registro) =  DATE(CURRENT_DATE())
                      )";


      $result = $this->db->query($query_get);              
      return $result->result_array()[0]["num_avance_dia"];

    }
    /**/
    function get_llamar_despues($param){

       $query_get =  "SELECT
                          b.* , 
                          f.nombre nombre_fuente 
                      FROM  
                      base_telefonica  b
                      INNER JOIN 
                        fuente f 
                      ON 
                      b.id_fuente =  f.id_fuente                       
                      WHERE 
                        tipificacion  = 2
                      AND
                        id_usuario =  '".$param["id_usuario"]."'
                      AND
                        fecha_agenda <= date(CURRENT_DATE())";
  
      $result  =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function limpia_registro_llamada_posterior_a_comentario($param){

      $id_persona =$param["id_persona"];
      $id_usuario =  $param["id_usuario"];
      
      $query_update =  "UPDATE llamada 
                        SET 
                        status = 1 
                        WHERE 
                        id_persona =  '".$id_persona ."'
                          AND 
                        idusuario =  '".$id_usuario."'
                        AND
                          fecha_agenda <= DATE(CURRENT_DATE())
                        AND
                          hora_agenda <= CURRENT_TIME
                        LIMIT 10";
      return $this->db->query($query_update); 
      
    }
    /**/

    function get_usuario_ventas(){
      
      $query_get  = "SELECT idusuario FROM usuario WHERE email ='ventas@enidservice.com' LIMIT 1";
      $result = $this->db->query($query_get);
      return $result->result_array()[0]["idusuario"];
      
    }

    /**/
    function get_num_nuevos_usuarios_subscritos($param){
      /**/
      $id_usuario =  $this->get_usuario_ventas();
      
      $query_get  = "SELECT
                        count(0)num_usuarios_subscritos
                      FROM  
                        persona 
                      WHERE  
                        id_usuario ='".$id_usuario."' 
                      AND 
                      DATE(fecha_registro) =  DATE(CURRENT_DATE())";

      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_usuarios_subscritos"];
      
    }
    /**/
    function get_num_agendados_validacion($param){

      $id_usuario =  $param["id_usuario"];
      $query_get  = "select 
                      count(0)num_agendados 
                      from 
                      persona 
                      where 
                      id_usuario ='".$id_usuario."' and tipo =4";

      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_agendados"];

    }
    /**/
    function get_num_clientes_notificacion_pago($param){

      $query_get  = "select 
                        count(0)num_pagos
                      from 
                      notificacion_pago
                      where 
                      status =0";
      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_pagos"];
    }
    /**/
    /***/
    function get_num_agendados_llamar_despues($param){
      
      $id_usuario =  $param["id_usuario"];

      $query_get  = "SELECT
                    count(0)num_agenda
                    FROM  
                    base_telefonica  b
                    INNER JOIN 
                    fuente f 
                    ON 
                    b.id_fuente =  f.id_fuente                       
                    WHERE 
                    tipificacion  = 2
                    AND
                    id_usuario =  '".$param["id_usuario"]."'
                    AND
                    fecha_agenda <= date(CURRENT_DATE())";

      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_agenda"];

    }
    /**/
    function get_num_agendados_email($param){

      $id_usuario_ventas =  $this->get_usuario_ventas();
      $query_get ="SELECT 
                  count(0)num_agendados_email 
                  FROM 
                  persona 
                  WHERE                   
                  enviar_referencia_email = 1  
                  AND 
                  id_usuario IN ('".$param["id_usuario"]."'  , '".$id_usuario_ventas."')";
      
      $result = $this->db->query($query_get);
      $num_enviar_referencia =  $result->result_array()[0]["num_agendados_email"];


      /**/
      $query_get ="SELECT
                    COUNT(0)num_enviar_correo
                    FROM 
                    usuario_persona_correo
                    WHERE 
                    status = 0 
                    AND 
                    id_usuario IN ('".$param["id_usuario"]."'  , '".$id_usuario_ventas."')
                    AND  
                    fecha_agenda <=  date(current_date())";
      
      $result = $this->db->query($query_get);
      $num_enviar_correo =  $result->result_array()[0]["num_enviar_correo"];


      $total = $num_enviar_referencia + $num_enviar_correo;
      return $total;

    }
    /**/
    function get_num_agendados($param){

      /**/      
      $id_usuario_ventas =  $this->get_usuario_ventas();

      $query_get  = "SELECT 
                      COUNT(0)num_agendados 
                      FROM 
                        llamada l                      
                      INNER JOIN   
                        persona p 
                      ON 
                        l.id_persona = p.id_persona
                      INNER JOIN 
                        tipo_persona   tp                      
                      ON                       
                      p.tipo = tp.idtipo_persona
                      
                      WHERE 
                        l.status = 0                                                              
                        AND l.idusuario IN ('".$param["id_usuario"]."'  ,  '".$id_usuario_ventas ."')
                      AND  
                        date(l.fecha_agenda) <= DATE(CURRENT_DATE())
                      AND
                      tp.relacion_externa = 0 ";


      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_agendados"];
    }
    /**/
    function get_num_agendados_contactos($param){

      $id_usuario_ventas =  $this->get_usuario_ventas();

      $query_get  = "SELECT 
                      COUNT(0)num_agendados 
                      FROM 
                        llamada l
                      
                      INNER JOIN   
                        persona p 
                      ON 
                        l.id_persona = p.id_persona
                      INNER JOIN tipo_persona   tp                      
                      ON                       
                      p.tipo = tp.idtipo_persona
                      
                      WHERE 
                        l.status = 0                         
                      
                        AND l.idusuario IN ('".$param["id_usuario"]."'  ,  '".$id_usuario_ventas ."')
                      AND  
                        date(l.fecha_agenda) <= DATE(CURRENT_DATE())
                      AND
                      tp.relacion_externa = 1";

      $result = $this->db->query($query_get);
      return $result->result_array()[0]["num_agendados"];
    }
    /**/
    function actualiza_llamada($param){
      
      $query_update =  "UPDATE llamada SET status = 1 WHERE id_llamada = '".$param["id_llamada"]."' LIMIT 1";
      return $this->db->query($query_update);
    }
    /**/
    function actualiza_correo_envio($param){    

      /*Aquí se actualiza en tabla de persona***/
      $query_update =  "UPDATE persona 
                          SET enviar_referencia_email = 2 
                        WHERE 
                          id_persona = '".$param["id_persona"]."' 
                        LIMIT 1";
      $this->db->query($query_update);
      
      /*Aquí se actualiza en tabla de usuario_persona_correo */
      $id_usuario =  $param["id_usuario"];
      $id_persona = $param["id_persona"];  

      $query_update =  "UPDATE 
                        usuario_persona_correo
                          SET status =  1
                        WHERE 
                          id_persona = '".$id_persona ."' 
                        AND   
                          status =  0                        
                        LIMIT 1";

      $this->db->query($query_update);

      /*Aquí se agrega comentario indicando que ya envió el correo a su historial*/
      return $this->agrega_comentario(" Se envió correo agendado " , $id_persona , $id_usuario , 10 );

    }
    /**/
    function agrega_comentario($comentario , $id_persona, $idusuario , $id_tipificacion ){


      $query_insert ="INSERT INTO comentario(
                      comentario , 
                      id_persona , 
                      idusuario ,  
                      id_tipificacion )
                      VALUES(
                          '".$comentario ."' ,
                          '".$id_persona ."' ,
                          '".$idusuario ."' ,
                          '".$id_tipificacion ."')";
      
      return $this->db->query($query_insert);

  }
  /**/
  function create_tmp_usuarios_correos_agendados($_num , $flag , $param ){

        $query_drop ="DROP TABLE IF EXISTS tmp_usuarios_correos_$_num";
        $status =  $this->db->query($query_drop);
        /**/
        $id_usuario_ventas = $this->get_usuario_ventas();

        if ($flag == 0){
            
            $query_create = "CREATE TABLE tmp_usuarios_correos_$_num AS
                      SELECT
                        id_persona
                      from  
                        usuario_persona_correo
                      WHERE 
                        status = 0 
                      AND 
                        id_usuario = '".$param["id_usuario"]."'
                      OR 
                        id_usuario = '".$id_usuario_ventas."'";

            $this->db->query($query_create);          
        }

    }
    /**/
    function get_correos_agendados($param){

        $_num =  get_random();
        $this->create_tmp_usuarios_correos_agendados($_num , 0 , $param );      
        
        $query_get = "SELECT 
                        
                          p.id_persona ,
                          p.nombre     ,
                          p.a_paterno  ,
                          p.a_materno  ,  
                          p.id_usuario_enid_service ,
                          p.correo
                      FROM 
                      persona p                      
                      INNER JOIN 
                      tmp_usuarios_correos_$_num  c
                      ON p.id_persona =  c.id_persona ";        
        $result =  $this->db->query($query_get);
        $data_complete = $result->result_array();

        $this->create_tmp_usuarios_correos_agendados($_num , 1 , $param );      
        
        return $data_complete;        

    }
    /**/
    function get_agendados($param){
        

        $_num =  get_random();
        $this->get_tmp_llamadas($_num , 0  ,$param);              
          $this->create_tmp_agendados($_num , 0  ,$param);

            $query_get ="SELECT 
                        p.* 
                        FROM 
                        tmp_agendados_$_num p                         
                        ORDER BY fecha_agenda , hora_agenda ASC";

            $result =  $this->db->query($query_get);
            $data["info_agendados"] = $result->result_array();

          $this->create_tmp_agendados($_num , 1  ,$param);
        $this->get_tmp_llamadas($_num , 1  ,$param);    
        return $data;
    }
    /**/
    function get_tmp_llamadas($_num , $flag  ,$param){

        $id_usuario =  $param["id_usuario"];
        $id_usuario_ventas =  $this->get_usuario_ventas();
        /***/
        

        $query_drop ="DROP TABLE IF EXISTS tmp_llamadas_$_num";
        $status =  $this->db->query($query_drop);
        
        if ($flag == 0){
            
            $query_create = "CREATE TABLE tmp_llamadas_$_num  AS
                      SELECT                         
                        l.* 
                      FROM llamada l 
                      WHERE 
                      idusuario 
                        IN('".$id_usuario ."'  , '".$id_usuario_ventas."') 
                          AND
                      status = 0  
                        AND 
                      idtipo_llamada = 1
                        AND
                      DATE(fecha_agenda) <= DATE(CURRENT_DATE())
                      LIMIT 100 ";

            $status  =  $this->db->query($query_create);
        }
        return $status;
    }
    /**/
    function create_tmp_agendados($_num , $flag  ,$param){
      /**/
      
      $tipo_relacion =  $param["tipo_relacion"];
      $query_drop ="DROP TABLE IF EXISTS tmp_agendados_$_num";
      $status =  $this->db->query($query_drop);

      if ($flag == 0){

          $id_usuario=  $param["id_usuario"];
            $query_create ="CREATE TABLE tmp_agendados_$_num 
                        AS 
                        SELECT                       
                          p.id_persona ,
                          p.nombre     ,
                          p.a_paterno  ,
                          p.a_materno  ,  
                          p.id_usuario_enid_service ,                                       
                          p.tel,
                          l.fecha_agenda ,
                          l.hora_agenda ,                          
                          l.id_llamada
                        FROM 
                        tmp_llamadas_$_num l 
                        INNER JOIN persona p 
                        ON  
                        l.id_persona =  p.id_persona
                        WHERE 
                        l.status =0 
                        AND 
                        l.idusuario = '".$id_usuario."' ";

            $status =  $this->db->query($query_create);
      }

      return $status;

    }
    /**/


    
}