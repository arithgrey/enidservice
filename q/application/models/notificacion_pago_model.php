<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class Notificacion_pago_model extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert($tabla ='imagen', $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
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

      $num_recibo = $param["recibo"];

      $query_get ="SELECT 
                    count(0)num_recibo
                   FROM  
                    notificacion_pago 
                   WHERE   
                    num_recibo = '".$num_recibo."' 
                    AND status = 0 
                    LIMIT 1";
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["num_recibo"];                  
    }
    function get_notificacion_pago_resumen($param){

        $id_notificacion_pago =  $param["id_notificacion_pago"];
        
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
                        id_notificacion_pago = '".$id_notificacion_pago."'  LIMIT 1";

        $result =  $this->db->query($query_get);
        return $result->result_array();

    }
    function registra_pago_usuario($param){
        
        $num_recibo           =  $param["num_recibo"];
        $nombre               =  $param["nombre"];
        $correo               =  $param["correo"];
        $dominio              =  $param["dominio"];
        $servicio             =  $param["servicio"];    
        $fecha_pago           =  $param["fecha"];
        $cantidad             =  $param["cantidad"];
        $forma_pago           =  $param["forma_pago"];
        $referencia           =  $param["referencia"];
        $comentarios          =  $param["comentarios"];
        
        $params =  [
        "nombre_persona"      => $nombre,
        "correo"              => $correo,
        "dominio"             => $dominio,
        "id_servicio"         => $servicio,
        "fecha_pago"          => $fecha_pago,
        "cantidad"            => $cantidad,
        "id_forma_pago"       => $forma_pago,
        "referencia"          => $referencia,
        "comentario"          => $comentarios,
        "num_recibo"          => $num_recibo
      ];
      return $this->insert("notificacion_pago" , $params , 1);
    
    }
    function actualiza_pago_notificado($param){

        $id_notificacion_pago =  $param["id_notificacion_pago"];
        $estado =  $param["estado"];
        $query_update ="UPDATE notificacion_pago 
                        SET 
                        status =  '".$estado."'
                        WHERE
                        id_notificacion_pago = '".$id_notificacion_pago."'
                        LIMIT 1";
        return $this->db->query($query_update);

    }
    
    
}
