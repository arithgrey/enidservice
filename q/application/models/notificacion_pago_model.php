<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Notificacion_pago_model extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }  
    function q_up($q , $q2 , $id_notificacion_pago){
        return $this->update([$q => $q2 ] , ["id_notificacion_pago" => $id_notificacion_pago ]);
    }  
    function insert( $params , $return_id=0){        
        $insert   = $this->db->insert("notificacion_pago", $params);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    function get_notificacion_pago($param){    
        $id_notificacion_pago =  $param["id_notificacion_pago"];    
        $query_get ="
        SELECT 
              np.nombre_persona      ,
              np.correo              ,
              np.dominio              ,
              np.fecha_pago          ,
              np.fecha_registro      ,
              np.cantidad             ,
              np.referencia          ,
              np.comentario          ,
              np.id_notificacion_pago,
              np.num_recibo          ,
              fp.forma_pago ,
              s.nombre_servicio 
              FROM  
              notificacion_pago np 
              INNER JOIN servicio s 
              ON  
              np.id_servicio = s.id_servicio
              INNER JOIN forma_pago fp 
              ON  np.id_forma_pago  = fp.id_forma_pago 
              WHERE 
              np.id_notificacion_pago = '".$id_notificacion_pago."'
              ";

        $result =  $this->db->query($query_get);
        return $result->result_array();    
  }
  function verifica_pago_notificado($param){
    $params_where = ["num_recibo"  =>  $param["recibo"] , "status" => 0 ];
    return $this->get(["count(0)num"] , $params_where)[0]["num"];    
  }
  function get_notificacion_pago_resumen($param){
    
    $query_get = "SELECT  
                        np.* ,
                        nombre_servicio, 
                        fp.*
                      FROM 
                        notificacion_pago np 
                      INNER JOIN 
                        servicio s 
                        ON 
                        np.id_servicio =  s.id_servicio
                      INNER JOIN 
                        forma_pago fp 
                        ON 
                        fp.id_forma_pago =  np.id_forma_pago
                      WHERE 
                        id_notificacion_pago = '".$param["id_notificacion_pago"]."'  LIMIT 1";

      return $this->db->query($query_get)->result_array();

    }
    
}
