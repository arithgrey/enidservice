<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Cuenta_pago_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("cuenta_pago", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }  
    function regitra_cuenta_bancaria($param){

      $id_usuario =  $param["id_usuario"];
      $clabe =  $param["clabe"];
      $banco = $param["banco"];       
      
      $data_complete["registro_cuenta"] = 0;    
      $data_complete["banco_es_numerico"] = 0;    
      $data_complete["clabe_es_corta"] = 1;    

      if(is_numeric($banco)){          
          $data_complete["banco_es_numerico"] = 1;              
          if(strlen(trim($clabe)) ==  18){
            $data_complete["clabe_es_corta"] = 0;    

            $params = [
              "id_usuario"  =>   $id_usuario ,
              "clabe"       =>   $clabe ,
              "id_banco"    =>   $banco,
              "tipo"        =>   0
            ];
                        
            $data_complete["registro_cuenta"]= $this->insert($params);
          }
      }
      return $data_complete;
      
    }
    function get_cuentas_usuario($param){
      
      $id_usuario =  $param["id_usuario"];
      $tipo = $param["tipo"];
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
                        c.id_usuario = $id_usuario
                      AND 
                        tipo =  $tipo                        
                      AND 
                        c.status =1
                        AND 
                        b.status =1";    
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    function insert($params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("cuenta_pago", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
    
}