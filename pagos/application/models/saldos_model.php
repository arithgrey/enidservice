<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class saldos_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    /**/
    function get_saldo_usuario($param){
        
        /**/
        $id_usuario =  $param["id_usuario"];        
        $query_get ="SELECT 
                        saldo_cubierto,
                        monto_a_pagar,
                        flag_envio_gratis, 
                        costo_envio_cliente,
                        num_ciclos_contratados,
                        costo_envio_vendedor,
                        saldo_cubierto_envio
                    FROM 
                        proyecto_persona_forma_pago
                    WHERE 
                        id_usuario_venta = $id_usuario
                    AND 
                        entregado = 0
                    AND 
                        saldo_cubierto>0";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/  
}