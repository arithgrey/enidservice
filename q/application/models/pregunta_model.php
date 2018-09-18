<?php defined('BASEPATH') OR exit('No direct script access allowed');

  class Pregunta_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert($tabla ='imagen', $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function set_visto_pregunta($param){
      
      $campo ="leido_cliente";
      if($param["modalidad"] == 1) {        
          $campo ="leido_vendedor";    
      }
      $id_pregunta  =  $param["id_pregunta"];      
      return $this->update("pregunta" , [$campo =>  1 ] , ["id_pregunta" =>  $id_pregunta ] );
                
    }
    function get_servicios_pregunta_sin_contestar($param){

      $query_get =  "SELECT  
                        ps.id_servicio  , ps.id_pregunta
                      FROM   
                      pregunta p  
                      INNER JOIN pregunta_servicio ps  
                      ON  p.id_pregunta =  ps.id_pregunta  
                      WHERE  
                      leido_vendedor = 0 
                      AND gamificacion = 0
                      AND 
                      DATEDIFF(DATE(CURRENT_DATE()), DATE(p.fecha_registro) ) > 1";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    function get_respuestas_sin_leer($param){
    
      $id_usuario =  $param["id_usuario"];
      $query_get ="SELECT 
                      COUNT(0)num 
                    FROM 
                      pregunta 
                    WHERE 
                      id_usuario =  $id_usuario 
                    AND 
                      leido_cliente =0";
      $result =  $this->db->query($query_get); 
      return $result->result_array()[0]["num"];
  
    }  
    function registra_pregunta($param){

      $pregunta     =  $param["pregunta"]; 
      $id_servicio  =  $param["servicio"]; 
      $id_usuario   =  $param["usuario"];
      $params       = ["pregunta" => $pregunta , "id_usuario"  => $id_usuario];

      $id_pregunta =  $this->insert("pregunta" , $params , 1);    
      return $this->agrega_pregunta_servicio($id_pregunta , $id_servicio);
    }
    function preguntas($param){

        
        $fecha_inicio   = $param["fecha_inicio"];  
        $fecha_termino  = $param["fecha_termino"];
        $query_get      = 
                        "SELECT  
                            id_usuario  
                        FROM 
                        pregunta 
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '".$fecha_inicio."' 
                        AND  
                          '".$fecha_termino."'
                        group by 
                        id_usuario";

        $result = $this->db->query($query_get);                
        return $result->result_array();
    }    
    function get_preguntas_sin_leer_vendedor($param){
      
      $_num          =  get_random();
      $this->create_tmp_servicios_venta_usuario(0 , $_num , $param);      
        
          $query_get ="SELECT 
                        COUNT(0)num
                      FROM 
                        tmp_servicio_usuario_$_num s 
                      INNER JOIN 
                        pregunta_servicio ps 
                      ON 
                        s.id_servicio = ps.id_servicio
                      INNER JOIN pregunta p 
                      ON 
                        p.id_pregunta  = ps.id_pregunta
                      WHERE 
                        p.leido_vendedor =0";
          $result =  $this->db->query($query_get);          
          $data_complete = $result->result_array();
        
      $this->create_tmp_servicios_venta_usuario(1 , $_num , $param);
      return  $data_complete;
      
    }        
    function create_tmp_servicios_venta_usuario($flag , $_num, $param){

      
        $this->db->query(get_drop("tmp_servicio_usuario_$_num"));

        if($flag == 0){          
          $id_usuario =  $param["id_usuario"]; 
          $query_create = "CREATE TABLE tmp_servicio_usuario_$_num AS 
                            SELECT 
                              id_servicio ,
                              nombre_servicio
                            FROM servicio 
                            WHERE 
                              id_usuario = $id_usuario                            
                            AND 
                              status = 1";
          $this->db->query($query_create);
        }
    }
    function get_preguntas_realizadas_a_vendedor($param){
      
      $_num =  get_random();
      $this->create_tmp_servicios_venta_usuario(0 , $_num , $param);      
        $this->create_tmp_servicios_venta_usuario_pregunta(0 , $_num, $param);
          $query_get ="SELECT * FROM 
                      tmp_servicio_usuario_pregunta_$_num 
                      ORDER BY 
                      leido_vendedor,
                      fecha_registro  DESC ";
          $result =  $this->db->query($query_get);          
          $data_complete = $result->result_array();
          //$data_complete = $this->add_num_respuestas_preguntas($data);

        $this->create_tmp_servicios_venta_usuario_pregunta(1 , $_num, $param);
      $this->create_tmp_servicios_venta_usuario(1 , $_num , $param);
      return  $data_complete;
      
    }
    function create_tmp_servicios_venta_usuario_pregunta($flag , $_num, $param){

        $this->db->query(get_drop("tmp_servicio_usuario_pregunta_$_num"));
        if($flag == 0){          
          $id_usuario =  $param["id_usuario"]; 
          $query_create = "CREATE TABLE tmp_servicio_usuario_pregunta_$_num AS 
                    SELECT 
                    p.* , 
                    ps.id_servicio ,
                    us.nombre_servicio 
                    FROM  
                    pregunta 
                    p 
                    INNER JOIN 
                    pregunta_servicio ps 
                    ON p.id_pregunta =  ps.id_pregunta
                    INNER JOIN 
                    tmp_servicio_usuario_$_num us 
                    ON  
                    ps.id_servicio =  us.id_servicio";
          $this->db->query($query_create);
        }
    }
    function get_preguntas_realizadas($param){
        
      $_num =  get_random();
      $this->create_tmp_preguntas_realizadas(0 , $_num , $param);      
        $this->create_tmp_preguntas_servicios(0 , $_num, $param);

          $query_get ="SELECT * FROM  
                        tmp_preguntas_servicios_$_num ORDER BY fecha_registro DESC";
          $result =  $this->db->query($query_get);
          $data_complete = $result->result_array();
          //$data_complete = $this->add_num_respuestas_preguntas($data);

        $this->create_tmp_preguntas_servicios(1 , $_num, $param);
      $this->create_tmp_preguntas_realizadas(1 , $_num , $param);
      return $data_complete;
      
    }
    function create_tmp_preguntas_realizadas($flag , $_num , $param){
        
        $this->db->query(get_drop("tmp_preguntas_usuario_$_num"));        
        if($flag == 0){
          $id_usuario =  $param["id_usuario"];
          $query_create = "CREATE TABLE tmp_preguntas_usuario_$_num AS 
                  SELECT p.* , ps.id_servicio FROM  
                    pregunta p 
                    INNER JOIN 
                    pregunta_servicio ps 
                    ON p.id_pregunta =  ps.id_pregunta
                    WHERE p.id_usuario = $id_usuario";
          $this->db->query($query_create);
        }     
    }
    function create_tmp_preguntas_servicios($flag , $_num , $param){

        
        $this->db->query(get_drop("tmp_preguntas_servicios_$_num"));

        if($flag == 0){          
          $query_create = "CREATE TABLE tmp_preguntas_servicios_$_num AS 
                    SELECT 
                      p.* , 
                      s.nombre_servicio, 
                      s.id_usuario id_usuario_venta
                    FROM  
                      tmp_preguntas_usuario_$_num  p 
                    INNER JOIN 
                    servicio s 
                      ON p.id_servicio =  s.id_servicio";
          $this->db->query($query_create);
        }     
    }
    function get_usuario_por_id_pregunta($param){
        
      $id_pregunta =  $param["id_pregunta"];
      $query_get ="SELECT id_usuario FROM pregunta WHERE id_pregunta = $id_pregunta LIMIT 1";
      $result = $this->db->query($query_get);
      return $result->result_array();
    }

}
