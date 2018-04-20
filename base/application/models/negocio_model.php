<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class negocio_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function update_entregas_en_casa($param){

        $id_usuario = $param["id_usuario"];
        $entregas_en_casa = $param["entregas_en_casa"];
        $query_update = "UPDATE usuario 
                            SET 
                                entregas_en_casa =  $entregas_en_casa 
                            WHERE 
                                idusuario =  $id_usuario 
                            LIMIT 1";
                            return  $this->db->query($query_update);
    }
    
   
}