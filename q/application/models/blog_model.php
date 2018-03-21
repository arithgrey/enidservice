<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class blog_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function get_url_blog_fecha($param){

      $fecha =  $param["fecha"];      
      $query_get ="SELECT 
                    id_faq,        
                    titulo ,
                    id_categoria  ,
                    fecha_registro
                   FROM faq WHERE DATE(fecha_registro) = '".$fecha."' ";
      $result  =  $this->db->query($query_get);
      return  $result->result_array();
    }
}