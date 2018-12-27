<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Cuenta_pago_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function get( $params=[], $params_where =[] , $limit =1 , $order = '', $type_order='DESC'){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }       
        return $this->db->get("cuentas")->result_array();
    }
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("cuenta_pago", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function get_cuentas_usuario($param){
    
      $query_get =   "SELECT 
                        c.id_cuenta_pago     
                        ,c.numero_tarjeta            
                        ,c.clabe                 
                        ,b.nombre                     
                      FROM  
                        cuenta_pago  c 
                      INNER JOIN banco b 
                        ON c.id_banco =  b.id_banco
                      WHERE 
                        c.id_usuario = '".$param["id_usuario"]."'
                      AND 
                        tipo =  '".$param["tipo"]."'                     
                      AND 
                        c.status =1
                      AND 
                        b.status =1";    
      return  $this->db->query($query_get)->result_array();
    }
        
    
}