<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class traficomodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function trafico_web_usuario($param){
        
        /**/
        
        $_num =  get_random();
       	$this->create_tmo_accesos(0, $_num , $param);


       	$query_get ="SELECT * FROM tmp_accesos_$_num";
       		$result =  $this->db->query($query_get);
			$data_complete =  $result->result_array();
       	

       	$this->create_tmo_accesos(1, $_num , $param);
       	return $data_complete;
        
        

    }    
    /**/
    function create_tmo_accesos($flag, $_num , $param){

 		$query_drop = "DROP TABLE IF exists tmp_accesos_$_num";        
        $this->db->query($query_drop);       

        if ($flag == 0){
           		$query_create ="
           			CREATE TABLE tmp_accesos_$_num AS 
           			SELECT * FROM 
        			pagina_web 
        			WHERE 
        			DATE(fecha_registro) 
        			BETWEEN 
        				DATE_ADD(CURRENT_DATE()  , INTERVAL - 1 WEEK ) 
        			AND 
        			DATE(CURRENT_DATE()) ";
        			$this->db->query($query_create);
		}   
        
    }
    /**/
    

    
}