<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class escenariosmodel extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_img_artistas_evento($param){

        $id_evento = $param["id_evento"];
        $_num =  get_random();
        $this->create_tmp_artistas_evento($_num ,  0  , $param);

        /**/
        $query_get = "SELECT i.id_imagen FROM tmp_artistas_evento_$_num a 
                      INNER JOIN imagen_artista i 
                      ON a.id_artista = i.id_artista";
                      $result  =  $this->db->query($query_get);
                      $data_complete["info_img_artista"] =  $result->result_array();

        $this->create_tmp_artistas_evento($_num ,  1  , $param);
        return  $data_complete;

    }
    /**/
    function create_tmp_artistas_evento($_num ,  $flag ,  $param ){
        $id_evento = $param["id_evento"];   
        $flag_action = "";  
        $query_drop =  "DROP TABLE IF exists tmp_artistas_evento_$_num";
        $flag_action =   $this->db->query($query_drop); 

          if ($flag == 0 ){
              $query_procedure ="CREATE TABLE   tmp_artistas_evento_$_num AS 
                                SELECT 
                                id_artista, 
                                artista  
                                FROM evento_artista
                                WHERE  
                                id_evento =  $id_evento LIMIT 30"; 
            
              $flag_action =  $this->db->query($query_procedure);
          }
      }
      /**/
}?>