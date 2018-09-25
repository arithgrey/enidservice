<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Pagina_web_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function accesos_enid_service(){   
        
        $query_get ="SELECT
                        COUNT(0)num_accesos 
                    FROM 
                        pagina_web 
                    WHERE  
                    date(fecha_registro) =  date(current_date())";

        return $this->db->query($query_get)->result_array()[0]["num_accesos"];
    }

}