<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class tickets_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    function get_status_enid_service($param){
        $query_get ="select id_estatus_enid_service , nombre  from status_enid_service";
        $result=  $this->db->query($query_get);
        return $result->result_array();

    }        
    /**/
    function get_compras_tipo_periodo($param){

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];
      $tipo =  $param["tipo"];

      $query_get = "SELECT 
                      * 
                    FROM 
                      proyecto_persona_forma_pago 
                    WHERE 
                      status =  $tipo 
                    AND 
                      DATE(fecha_registro) 
                    BETWEEN 
                      '".$fecha_inicio."' 
                    AND  
                      '".$fecha_termino."'
                      ORDER BY fecha_registro DESC ";
                    
                    $result =  $this->db->query($query_get);
                    return $result->result_array();

    }
    /**/
    function carga_actividad_pendiente($param){

        $campo_usuario = "id_usuario";        
        $id_usuario =  $param["id_usuario"];

        if($param["modalidad"] ==  1){
            $campo_usuario ="id_usuario_venta";            
        }
        
        $query_get = "SELECT 
                        COUNT(0)num
                      FROM 
                      proyecto_persona_forma_pago 
                      WHERE  
                        status = 7
                      AND 
                        $campo_usuario =  $id_usuario";
                        
        $result = $this->db->query($query_get);   
        $num = $result->result_array()[0]["num"];
        $data_complete["num_pedidos"] = $num;        
        return $data_complete;
    }
    /**/
    function num_compras_efectivas_usuario($param){

      $id_usuario =  $param["id_usuario"];
      $campo_usuario = "id_usuario";

      if($param["modalidad"] == 1){
          $campo_usuario ="id_usuario_venta";  
      }      
      /*Ventas*/                  
      $query_get ="SELECT   
                        COUNT(0)num 
                      FROM 
                        proyecto_persona_forma_pago 
                      WHERE 
                        $campo_usuario = $id_usuario
                      AND status =  9";      
                      /*9 =  Compra ya realizada y sin problemas*/
                      
      $result =  $this->db->query($query_get);  
      return $result->result_array()[0]["num"];      
    } 
    /**/
    private function get_limit($param){
        /**/
        $page = (isset($param['page'])&& !empty($param['page']))?
        $param['page']:1;
        $per_page = $param["resultados_por_pagina"]; 
        //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
        
        return " LIMIT $offset , $per_page ";
    }
    /**/    
    function total_compras_ventas_efectivas_usuario($param){

      $id_usuario =  $param["id_usuario"];
      $campo_usuario = "id_usuario";
      if($param["modalidad"] == 1){
          $campo_usuario ="id_usuario_venta";  
      }      
      /*Ventas*/                  
      $query_get ="SELECT   
                        count(0)num
                      FROM 
                        proyecto_persona_forma_pago 
                      WHERE 
                        $campo_usuario = $id_usuario
                      AND status =  9";      
                      /*9 =  Compra ya realizada y sin problemas*/                      
      $result =  $this->db->query($query_get);  
      return $result->result_array()[0]["num"];      
    }
    /**/
    function compras_ventas_efectivas_usuario($param){
      
      $id_usuario =  $param["id_usuario"];
      $campo_usuario = "id_usuario";
      if($param["modalidad"] == 1){
          $campo_usuario ="id_usuario_venta";  
      }      
      /*Ventas*/                  
      $query_get ="SELECT   
                        *
                      FROM 
                        proyecto_persona_forma_pago 
                      WHERE 
                        $campo_usuario = $id_usuario
                      AND status =  9".$this->get_limit($param);      
                      /*9 =  Compra ya realizada y sin problemas*/                      
      $result =  $this->db->query($query_get);  
      return $result->result_array();      
    }  
    /**/
    function get_servicio_por_recibo($param){
        
        $id_recibo = $param["id_recibo"]; 
      
        $query_get ="SELECT 
                      s.id_servicio, 
                      s.nombre_servicio
                      FROM 
                      proyecto_persona_forma_pago p 
                      INNER JOIN servicio s 
                      ON 
                      p.id_servicio =  s.id_servicio
                      WHERE 
                      p.id_proyecto_persona_forma_pago=$id_recibo LIMIT 1";
        
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    /**/
    function get_flag_envio_gratis_por_id_recibo($param){
      
      $id_recibo =  $param["id_recibo"];
      /**/
      $query_get ="SELECT flag_envio_gratis 
                   FROM proyecto_persona_forma_pago
                   WHERE id_proyecto_persona_forma_pago = $id_recibo LIMIT 1";
                   $result =  $this->db->query($query_get);
      return $result->result_array()[0]["flag_envio_gratis"];

    }
    /**/
    
    function get_id_proyecto_por_id_proyecto_persona($id_proyecto_persona){
      
          $query_get ="SELECT 
            id_proyecto
          FROM 
            proyecto_persona
          WHERE id_proyecto_persona = $id_proyecto_persona
          LIMIT 1";

          $result =  $this->db->query($query_get);
          return  $result->result_array();
    }
    /**/
    function get_id_servicio_por_id_proyecto($id_proyecto){
      
      $query_get ="SELECT 
                    id_servicio
                  FROM 
                    proyecto
                  WHERE id_proyecto = $id_proyecto
                  LIMIT 1";

          $result =  $this->db->query($query_get);
          return  $result->result_array();
    }
    /**/
    function get_servicio_por_id_servicio($id_servicio){
      
      $query_get ="SELECT 
                    id_servicio, 
                    nombre_servicio
                  FROM 
                    servicio
                  WHERE 
                  id_servicio = $id_servicio
                  LIMIT 1";

          $result =  $this->db->query($query_get);
          return  $result->result_array();
    }
    /*Se cancela la órden de compra*/
    function cancela_orden_compra($param){
        
        $id_recibo =  $param["id_recibo"];
        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET status = 10,
                          fecha_cancelacion = current_date()
                          WHERE 
                            id_proyecto_persona_forma_pago = $id_recibo 
                          LIMIT 1";
        
        return   $this->db->query($query_update);
        
    }

}