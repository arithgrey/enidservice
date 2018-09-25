<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class email_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function create_tmp_envios($flag , $_num  , $param){

      $this->db->query(get_drop("tmp_envios_$_num"));
      if ($flag ==  0){

        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];
      
        $where_fecha = " WHERE 
                          n_tocado = 1 
                          AND 
                            DATE(fecha_actualizacion) 
                          BETWEEN  '".$fecha_inicio."' 
                            AND '".$fecha_termino."'  ";


        $query_create =  "CREATE TABLE tmp_envios_$_num AS 
                          SELECT 
                            DATE(fecha_actualizacion)fecha_actualizacion , 
                            COUNT(0)envios  
                          FROM prospecto                           
                          $where_fecha
                          GROUP BY DATE(fecha_actualizacion)";
        $this->db->query($query_create);
        
      }
    }
    function create_tmp_accesos($flag , $_num  , $param){

      
      $this->db->query(get_drop("tmp_accesos_$_num"));

      if ($flag ==  0){

        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];
      
        $where_fecha = " WHERE 
                          DATE(fecha_registro) 
                          BETWEEN  '".$fecha_inicio."' 
                          AND '".$fecha_termino."'  ";


        $query_create =  "CREATE TABLE tmp_accesos_$_num AS                           
                          SELECT 
                            DATE(fecha_registro)fecha_registro , 
                            COUNT(0)accesos                          
                          FROM pagina_web 
                           $where_fecha
                          GROUP BY DATE(fecha_registro)";
        $this->db->query($query_create);
        
      }
    }
    function get_correos_enviados_accesos($param){

      $_num =  get_random();
      $this->create_tmp_accesos(0 , $_num  , $param);      
      $this->create_tmp_envios(0 , $_num  , $param);
            
        $query_get = "SELECT 
                      a.*   , 
                      e.envios
                      FROM tmp_accesos_$_num a                      
                      LEFT  OUTER JOIN 
                      tmp_envios_$_num e 
                      ON a.fecha_registro =  e.fecha_actualizacion 
                      ORDER BY a.fecha_registro 
                      DESC";        
        
        $data_complete =  $this->db->query($query_get)->result_array();        
        
      $this->create_tmp_envios(1 , $_num  , $param);
      $this->create_tmp_accesos(1 , $_num  , $param);
      return  $data_complete;

    }        
    
    /*
    function servicios_disponibles($param){

      $query_get ="SELECT * FROM servicio WHERE status = 1";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }  
    */
      
}