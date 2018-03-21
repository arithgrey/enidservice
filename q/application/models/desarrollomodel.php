<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class desarrollomodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function create_tmp_fechas($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_accesos_$_num";
        $this->db->query($query_drop);

          if ($flag ==  0){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];
                          
            $query_create =  "CREATE TABLE tmp_accesos_$_num AS 
                              SELECT 
                                    DATE(fecha_registro)fecha 
                                FROM 
                                pagina_web 
                                WHERE                                    
                                DATE(fecha_registro)                             
                                BETWEEN    
                                '".$fecha_inicio."' 
                                    AND 
                                '".$fecha_termino."'";
            $this->db->query($query_create);
            
      }
    }
    /**/
    function get_comparativa_desarrollo_calidad($param){

        $_num =  get_random();
        $this->create_tmp_tareas_solicitadas(0 ,$_num , $param);
            $this->create_tmp_tareas_realizadas(0 ,$_num , $param);
               $this->create_tmp_fechas(0 , $_num , $param);

               $query_get ="SELECT * FROM  tmp_tareas_solicitadas_$_num"; 
               $result = $this->db->query($query_get);
               $data_complete["solicitudes"]=$result->result_array();


               $query_get ="SELECT * FROM  tmp_tareas_realizadas_$_num"; 
               $result = $this->db->query($query_get);
               $data_complete["terminos"]=$result->result_array();


               $query_get ="SELECT * FROM  tmp_accesos_$_num GROUP BY fecha"; 
               $result = $this->db->query($query_get);
               $data_complete["lista_fechas"]=$result->result_array();

               


               $this->create_tmp_fechas(1 , $_num , $param);
            $this->create_tmp_tareas_realizadas(1 ,$_num , $param);           
        $this->create_tmp_tareas_solicitadas(1 ,$_num , $param);        
        return $data_complete;
    }    
    /**/
    function create_tmp_tareas_solicitadas($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_tareas_solicitadas_$_num";
        $this->db->query($query_drop);

          if ($flag ==  0){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];
                          
            $query_create =  "CREATE TABLE tmp_tareas_solicitadas_$_num AS 
                              SELECT 
                                COUNT(0)tareas_solicitadas ,       
                                DATE(fecha_registro)fecha_registro                               
                                FROM tarea  
                                WHERE                           
                                DATE(fecha_registro) 
                                BETWEEN                              
                                '".$fecha_inicio."' 
                                    AND 
                                '".$fecha_termino."' 
                                GROUP BY DATE(fecha_registro)";
            $this->db->query($query_create);
            
      }
    } 
    /*REalizadas*/
    function create_tmp_tareas_realizadas($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_tareas_realizadas_$_num";
        $this->db->query($query_drop);

          if ($flag ==  0){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];
                          
            $query_create =  "CREATE TABLE tmp_tareas_realizadas_$_num AS 
                              SELECT 
                                COUNT(0)tareas_realizadas ,       
                                DATE(fecha_termino)fecha_termino                                
                                FROM tarea  
                                WHERE                           
                                DATE(fecha_termino) 
                                BETWEEN                              
                                '".$fecha_inicio."' 
                                    AND 
                                '".$fecha_termino."' 
                                GROUP BY DATE(fecha_termino)";
            $this->db->query($query_create);
            
      }
    } 
    /**/
    function create_tmp_table_comparativas($flag ,$_num , $param){



        $nombre_table ="";
                               
            switch ($param["tiempo"]) {
                case 1:
                    
                    $tiempo ="DATE(fecha_termino) = DATE(CURRENT_DATE())";           
                    $nombre_table ="tmp_tareas_comparativas_hoy_$_num";

                    $query_drop = "DROP TABLE IF exists ".$nombre_table;
                    $this->db->query($query_drop);
         
                    break;
                
                case 2:
                    $tiempo ="DATE(fecha_termino) = DATE(CURRENT_DATE()) -1";              
                    $nombre_table ="tmp_tareas_comparativas_ayer_$_num";
                    $query_drop = "DROP TABLE IF exists ".$nombre_table;
                    $this->db->query($query_drop);
         
                    break;
                
                case 3:
                    $tiempo ="DATE(fecha_termino) = DATE(CURRENT_DATE()) -7";      
                    $nombre_table ="tmp_tareas_comparativas_menos7_$_num";
                    $query_drop = "DROP TABLE IF exists ".$nombre_table;
                    $this->db->query($query_drop);
         
                    break;
                
                default:
            
                    break;
            }
                
            if ($flag ==  0){        

                $query_create = "CREATE TABLE $nombre_table AS 
                                  SELECT 
                                    id_tarea ,    
                                    COUNT(0)num_tareas,   
                                    DATE(fecha_termino)fecha,
                                    HOUR(fecha_termino)hora                                
                                  FROM 
                                    tarea  
                                  WHERE                           
                                    $tiempo
                                    GROUP BY 
                                    HOUR(fecha_termino)";
                $this->db->query($query_create);
            } 
          
    }   
    /**/
    /**/
    function get_comparativa_desarrollo($param){

        $_num =  get_random();

        $param["tiempo"]= 1;
        $this->create_tmp_table_comparativas(0 ,$_num , $param);
        
        $param["tiempo"]= 2;
        $this->create_tmp_table_comparativas(0 ,$_num , $param);
        
        $param["tiempo"]= 3;
        $this->create_tmp_table_comparativas(0 ,$_num , $param);

                
            $query_get ="SELECT * FROM tmp_tareas_comparativas_hoy_$_num";
            $result =  $this->db->query($query_get);
            $data_complete["hoy"]= $result->result_array();

            $query_get ="SELECT * FROM tmp_tareas_comparativas_ayer_$_num";
            $result =  $this->db->query($query_get);
            $data_complete["ayer"]= $result->result_array();

            $query_get ="SELECT * FROM tmp_tareas_comparativas_menos7_$_num";
            $result =  $this->db->query($query_get);
            $data_complete["menos_7"]= $result->result_array();

        $param["tiempo"]= 1;
        $this->create_tmp_table_comparativas(1 ,$_num , $param);
        
        $param["tiempo"]= 2;
        $this->create_tmp_table_comparativas(1 ,$_num , $param);
        
        $param["tiempo"]= 3;
        $this->create_tmp_table_comparativas(1 ,$_num , $param);

        return $data_complete;

    }
    /**/
    /**/
    function get_resumen_desarrollo($param){

        $_num =  get_random();

        $this->create_tmp_tareas(0 ,$_num , $param);
            $this->create_tmp_tareas_horario(0 , $_num , $param);

            $query_get ="SELECT * FROM tmp_tareas_horario_$_num ORDER BY fecha ASC";
            $result = $this->db->query($query_get);
            $data_complete = $result->result_array();

            $this->create_tmp_tareas_horario(1 , $_num , $param);
        $this->create_tmp_tareas(1 ,$_num , $param);        
        return $data_complete;
    }
    /**/
    function create_tmp_tareas($flag , $_num , $param){

    $query_drop = "DROP TABLE IF exists tmp_tareas_$_num";
    $this->db->query($query_drop);

      if ($flag ==  0){

        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];
                      
        $query_create =  "CREATE TABLE tmp_tareas_$_num AS 
                          SELECT 
                            id_tarea ,       
                            fecha_termino                                
                          FROM tarea  
                          WHERE                           
                            DATE(fecha_termino) 
                            BETWEEN                              
                            '".$fecha_inicio."' 
                                AND 
                            '".$fecha_termino."' ";
        $this->db->query($query_create);
        
      }
    }  
    /**/
    function create_tmp_tareas_horario($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_tareas_horario_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){            

            $query_create ="CREATE TABLE tmp_tareas_horario_$_num AS 
                            SELECT  
                            COUNT(0) total,                        
                            HOUR(t.fecha_termino)hora ,
                            DATE(t.fecha_termino)fecha  
                            FROM 
                            tmp_tareas_$_num t 
                            GROUP BY                         
                            HOUR(t.fecha_termino), 
                            DATE(t.fecha_termino)  ";

                        $this->db->query($query_create);
        }
    }
    /**/
    function get_tareas_pendientes_usuario($param){

      $id_usuario = $param["id_usuario"];
      $id_departamento =  $param["id_departamento"];

        $query_get ="SELECT 
                        count(0)num_tareas_pendientes 
                    FROM tarea t 
                    INNER JOIN 
                    ticket ti
                    ON t.id_ticket =  
                    ti.id_ticket
                    WHERE 
                    t.status = 0
                    and 
                    ti.id_departamento = '".$id_departamento."' ";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_tareas_pendientes"];

    }

    
}