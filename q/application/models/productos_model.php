<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class productos_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_productos_solicitados($param){
        
        $_num =  get_random();
        $this->create_tmp_productos_solicitados(0 , $_num,  $param);
        
        $query_get = "SELECT * FROM tmp_productos_$_num ORDER BY num_keywords DESC";
        $result =  $this->db->query($query_get);
        $data_complete["info_productos"] = $result->result_array();
        
        $this->create_tmp_productos_solicitados(1 , $_num,  $param);
        return $data_complete;
        
    }
    /**/
    function create_tmp_productos_solicitados($flag , $_num,  $param){

      $query_drop = "DROP TABLE IF exists tmp_productos_$_num";
      $this->db->query($query_drop);

      if($flag ==  0){

        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];

        $query_get=  "CREATE TABLE tmp_productos_$_num AS 
                      SELECT 
                        keyword, 
                        COUNT(0)num_keywords 
                      FROM 
                        keyword 
                      WHERE 
                        DATE(fecha_registro) 
                      BETWEEN 
                        '".$fecha_inicio."'  
                      AND 
                        '".$fecha_termino."'
                      GROUP BY keyword";

                      $this->db->query($query_get);
                      

      }


    }
    /**/
    function get_alcance_productos_usuario($param){
      /**/
      $id_usuario = $param["id_usuario"];
      $query_get ="SELECT MAX(vista)maximo, AVG(vista)promedio , MIN(vista)minimo 
                    FROM servicio 
                  WHERE id_usuario = $id_usuario
                    AND status =1 AND
                  existencia>0";
      $result = $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_producto_alcance($param){

      $id_usuario = $param["id_usuario"];
      $vista =  $param["tipo"];

      $query_get ="SELECT id_servicio 
                    FROM  
                    servicio 
                    WHERE 
                    id_usuario = $id_usuario
                    AND 
                    vista = '".$vista."'
                    AND 
                    status =1 
                    AND
                    existencia>0
                    LIMIT 1";
      $result = $this->db->query($query_get);
      return $result->result_array()[0]["id_servicio"];      
    }
    /**/

}