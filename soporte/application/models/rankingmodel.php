<?php defined('BASEPATH') OR exit('No direct script access allowed');
class rankingmodel extends CI_Model{

    function __construct(){        
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_comentarios_calificacion($param){
        
        /**/
        $_num =  get_random();
        $this->create_tmp_user_empresa($_num ,  0 ,  $param);
        $this->create_tmp_inicidencias($_num ,  0 ,  $param);

        
        $sql_condicion =  " num_calificacion = '".$param["calificacion"]."' "; 
        if ($param["calificacion"] ==  0 ){
            $sql_condicion =  "1= 1  AND num_calificacion > 0 ";
        }

            $query_get =  "
            SELECT  
                * 
            FROM tmp_calificaciones_$_num 
            WHERE  $sql_condicion  
            ORDER BY fecha_registro DESC ";         
            
            $result =  $this->db->query($query_get);
            $data_complete["info_general"] =  $result->result_array();


        $this->create_tmp_inicidencias($_num ,  1 ,  $param);
        $this->create_tmp_user_empresa($_num ,  1 ,  $param);
        return $data_complete;

    }

    /**/
    function get_info_general($param){

        $_num =  get_random();
        $this->create_tmp_user_empresa($_num ,  0 ,  $param);
        $this->create_tmp_inicidencias($_num ,  0 ,  $param);

            $query_get =  "
            SELECT  
                SUM(CASE WHEN  num_calificacion =  1  then 1 else 0 end )1_estrella,
                SUM(CASE WHEN  num_calificacion =  2  then 1 else 0 end )2_estrella,
                SUM(CASE WHEN  num_calificacion =  3  then 1 else 0 end )3_estrella,
                SUM(CASE WHEN  num_calificacion =  4  then 1 else 0 end )4_estrella,
                SUM(CASE WHEN  num_calificacion =  5  then 1 else 0 end )5_estrella
            FROM tmp_calificaciones_$_num";         
            
            $result =  $this->db->query($query_get);
            $data_complete["info_general"] =  $result->result_array();


        $this->create_tmp_inicidencias($_num ,  1 ,  $param);
        $this->create_tmp_user_empresa($_num ,  1 ,  $param);
        return $data_complete;

    }

    function create_tmp_user_empresa($_num ,  $flag ,  $param){

        $id_empresa =  $param["id_empresa"];
    
        $query_drop ="DROP TABLE IF exists tmp_user_empresa_$_num";
        $db_response = $this->db->query($query_drop);

        if ($flag == 0){
            $query_create ="CREATE TABLE tmp_user_empresa_$_num  AS 
                            SELECT idusuario ,  nombre , email from usuario where idempresa = $id_empresa LIMIT 100";                             
            $db_response =   $this->db->query($query_create);                   
                        
        }
        return $db_response;

    }

    /**/
    function create_tmp_inicidencias($_num ,  $flag ,  $param){

        $query_drop ="DROP TABLE IF exists tmp_calificaciones_$_num";
        $db_response = $this->db->query($query_drop);

        if ($flag == 0){
            $query_create ="CREATE TABLE tmp_calificaciones_$_num  AS 
            select  i.* , u.* 
             from incidencia i   inner join tmp_user_empresa_$_num u   on i.id_user =  u.idusuario "; 
            $db_response =   $this->db->query($query_create);                   
                        
        }
        return $db_response;


    }
    
    
/*Termina modelo */
}