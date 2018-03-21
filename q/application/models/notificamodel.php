<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class notificamodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    
    /**/
    function get_email_enviados_usuario_dia($param){

        $_num =  get_random();      
        $id_usuario = $param["id_usuario"];
        $this->create_tmp_email(0 , $_num , $param);
        
          $query_get = "SELECT
                           COUNT(0)num_email_enviados
                        FROM 
                          tmp_prospecto_$_num 
                        WHERE                        
                        id_usuario_ultimo_toque ='".$id_usuario."' ";

          $result =  $this->db->query($query_get);    

        $num_email_enviados=  $result->result_array()[0]["num_email_enviados"];
        $this->create_tmp_email(1 , $_num , $param);
        return $num_email_enviados;
    }
    /**/
    function create_tmp_email($flag , $_num  , $param){
          
      $query_drop = "DROP TABLE IF exists tmp_prospecto_$_num";
      $result =  $this->db->query($query_drop);
      

      if ($flag ==  0){
          $query_create ="CREATE TABLE tmp_prospecto_$_num AS 
                          SELECT 
                            id_usuario , 
                            id_usuario_ultimo_toque
                          FROM 
                            prospecto
                          WHERE                          
                            date(fecha_actualizacion) = date(current_date())";
                        $result =  $this->db->query($query_create);
      }
      return $result;
    }
    /**/
    function get_accesos_creados_por_usuario($param){

      $_num =  get_random();      
      $this->create_tmp_accesos(0 , $_num , $param); 

        $query_get ="SELECT 
                    COUNT(0)num_accesos_creados 
                  FROM
                  tmp_accesos_web_usuario_$_num";

        $result =  $this->db->query($query_get);              
        $arreglo_accesos =  $result->result_array();



        $this->create_tmp_accesos(1 , $_num  , $param); 

        return $arreglo_accesos[0]["num_accesos_creados"];
    }
    /**/
    function create_tmp_accesos($flag , $_num  , $param){
      
      $id_usuario = $param["id_usuario"];  
      $query_drop = "DROP TABLE IF exists tmp_accesos_web_usuario_$_num";
      $result =  $this->db->query($query_drop);
      

      if ($flag ==  0){
          $query_create ="CREATE TABLE tmp_accesos_web_usuario_$_num AS 
                          SELECT tipo 
                          FROM pagina_web 
                          WHERE 
                          id_usuario = '".$id_usuario."' AND 
                          DATE(fecha_registro )= DATE(CURRENT_DATE())";
                        $result =  $this->db->query($query_create);
      }
      return $result;
    }

}