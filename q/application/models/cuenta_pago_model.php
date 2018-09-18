<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Cuenta_pago_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
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
                        
            $data_complete["registro_cuenta"]= $this->insert("cuenta_pago");
          }
      }
      return $data_complete;
      
    }
    function regitra_tarjeta($param){


      $id_usuario     =   $param["id_usuario"];
      $numero_tarjeta =   $param["numero_tarjeta"];
      $banco          =   $param["banco"];       
      $tipo_tarjeta   =   $param["tipo_tarjeta"];

      $data_complete["registro_cuenta"]     = 0;    
      $data_complete["banco_es_numerico"]   = 0;    
      $data_complete["clabe_es_corta"]      = 1;    

      if(is_numeric($banco)){          
          $data_complete["banco_es_numerico"] = 1;              
          if(strlen(trim($numero_tarjeta)) ==  16){
            $data_complete["clabe_es_corta"] = 0;    


            $params = [
              "id_usuario"          =>   $id_usuario ,
              "numero_tarjeta"      =>   $numero_tarjeta ,
              "id_banco"            =>   $banco,
              "tipo"                =>   1,
              "tipo_tarjeta"        =>  $tipo_tarjeta
            ];
            $data_complete["registro_cuenta"] = $this->insert("cuenta_pago" , $params);
            
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
    
}