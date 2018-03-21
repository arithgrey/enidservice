<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class accesos_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_accesos_periodo_afiliado($param){
      
      $_num =  get_random(); 
      $this->create_usuarios_afiliados(0 , $_num , $param);       
        $this->create_tmp_accesos_a_productos(0 , $_num , $param);        
          $this->create_tmp_accesos(0 , $_num , $param);
            
            $query_get ="SELECT 
                          COUNT(0)num_accesos , fecha  
                          FROM tmp_accesos_$_num GROUP BY fecha ORDER BY fecha ASC ";        
            $result =  $this->db->query($query_get);
            $data_complete =  $result->result_array();

          $this->create_tmp_accesos(1 , $_num , $param);
        $this->create_tmp_accesos_a_productos(1 , $_num , $param);
      $this->create_usuarios_afiliados(1 , $_num , $param);
      return  $data_complete;
      
    }
    /**/
    function create_tmp_accesos($flag , $_num , $param){

      $query_drop = "DROP TABLE IF exists tmp_accesos_$_num";
      $this->db->query($query_drop);

        if ($flag ==  0){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];

            /**/
            $query_create ="CREATE TABLE tmp_accesos_$_num 
                            AS 
                            SELECT
                              a.id_usuario , a.fecha_registro fecha                              
                            FROM 
                              tmp_usuarios_afiliados_$_num u 
                            INNER JOIN  
                              tmp_accesos_a_productos_$_num a 
                              ON u.idusuario =  a.id_usuario";

                        $this->db->query($query_create);
                          

        } 
    }
    /**/
    function create_tmp_accesos_a_productos($flag , $_num , $param){

      $query_drop = "DROP TABLE IF exists tmp_accesos_a_productos_$_num";
      $this->db->query($query_drop);

        if ($flag ==  0){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];

            /**/
            $query_create ="CREATE TABLE tmp_accesos_a_productos_$_num 
                            AS 
                            SELECT 
                              id_usuario,                             
                              DATE(fecha_registro)fecha_registro
                            FROM 
                              pagina_web 
                            WHERE 
                              tipo = 9990890
                            AND
                              DATE(fecha_registro )
                            BETWEEN 
                              '". $fecha_inicio ."' 
                            AND 
                              '". $fecha_termino ."' ";

                        $this->db->query($query_create);
                          

        } 
    }
    /**/
    function create_usuarios_afiliados($flag , $_num , $param){

      $query_drop = "DROP TABLE IF exists tmp_usuarios_afiliados_$_num";
      $this->db->query($query_drop);

        if ($flag ==  0){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];

            $query_create ="CREATE TABLE tmp_usuarios_afiliados_$_num 
                            AS 
                            SELECT 
                              idusuario
                            FROM 
                              usuario_perfil 
                            WHERE 
                              idperfil = 19
                            AND
                            DATE(fecha_registro )
                            BETWEEN 
                            '". $fecha_inicio ."' 
                            AND 
                            '". $fecha_termino ."' ";


                        $this->db->query($query_create);
                          

        } 
    }
    /**/
   
}