<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class afiliacion_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function get_usuarios_productivos($param){

      return 1;
    }
    /**/
    function repo_afiliaciones($param){

      $_num =  get_random();

      $this->create_tmp_fechas(0 , $_num , $param);      
        $this->create_tmp_afiliados(0 , $_num , $param);

         $query_get ="SELECT * FROM 
                      tmp_accesos_fechas_$_num a
                      LEFT OUTER JOIN 
                        tmp_table_afiliados_$_num  af
                      ON 
                      a.fecha =  af.fecha_registro
                      ORDER BY a.fecha ASC"; 
                      $result  =  $this->db->query($query_get);
                      $data_complete = $result->result_array();
                      
        $this->create_tmp_afiliados(1 , $_num , $param);      
      $this->create_tmp_fechas(1 , $_num , $param);
      return $data_complete;

    }    
   /**/
   function create_tmp_afiliados($flag , $_num , $param){

      $query_drop = "DROP TABLE IF exists tmp_table_afiliados_$_num";
      $db_response = $this->db->query($query_drop);
        

      if($flag == 0 ) {
  
        $fecha_inicio =  $param["fecha_inicio"];        
        $fecha_termino =  $param["fecha_termino"];        

        $query_create = "CREATE TABLE tmp_table_afiliados_$_num 
        AS      
        SELECT 
          DATE(fecha_registro)fecha_registro,
          COUNT(0)num_afiliados
        FROM 
          usuario_perfil   
        WHERE 
          idperfil = 19 
        AND
        DATE(fecha_registro)BETWEEN 
        '".$fecha_inicio."' 
        AND 
        '".$fecha_termino."' 
        GROUP BY
        DATE(fecha_registro)";

        $this->db->query($query_create);
      }
      return $db_response;

    }
    /**/
    function create_tmp_fechas($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_accesos_$_num";
        $this->db->query($query_drop);

        $query_drop = "DROP TABLE IF exists tmp_accesos_fechas_$_num";
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


            /**/
            $query_create =  "CREATE TABLE tmp_accesos_fechas_$_num AS 
                              SELECT 
                                fecha 
                              FROM 
                              tmp_accesos_$_num 

                              GROUP BY fecha";

            $this->db->query($query_create);
            
      }
    }
 
 
}