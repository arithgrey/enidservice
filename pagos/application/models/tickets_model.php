<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class tickets_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }   
    /**/
    function registra_solicitud_pago_amigo($param){

        $monto =  $param["monto"];
        $email_amigo =  $param["email_amigo"];        
        $query_insert  = "INSERT INTO 
                          solicitud_pago(email_solicitado ,  monto_solicitado) 
                          VALUES('".$email_amigo."' ,  '".$monto."')";        
        $this->db->query($query_insert);
        $param["id_solicitud"] = $this->db->insert_id();                
        return $this->agrega_solicitud_usuario_amigo($param);
    } 
    /**/
    function agrega_solicitud_usuario_amigo($param){

        $id_usuario =  $param["id_usuario"]; 
        $id_solicitud =  $param["id_solicitud"]; 
        
        $query_insert ="INSERT INTO solicitud_pago_usuario(id_solicitud , id_usuario ) 
              VALUES('".$id_solicitud ."' ,  '".$id_usuario."')";
        return $this->db->query($query_insert);
    }
    /**/
    function get_status_enid_service($param){
        $query_get ="select id_estatus_enid_service , nombre  from status_enid_service";
        $result=  $this->db->query($query_get);
        return $result->result_array();

    }        
    /**/
    function get_compras_tipo_periodo($param){

      $where =  $this->get_where_tiempo($param);
      $tipo =  $param["tipo"];
      $query_get = "SELECT 
                      * 
                    FROM 
                      proyecto_persona_forma_pago 
                    WHERE 
                      status =  $tipo 
                    AND 
                       ".$where;
                    
                    $result =  $this->db->query($query_get);
                    return $result->result_array();
    }
    /**/
    function get_where_tiempo($param){

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];
      $tipo =  $param["tipo"];
      switch ($tipo){
        case 6:          
          /**/
          return " DATE(fecha_registro)
                   BETWEEN 
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;
        case 2:
          /**/
          return " (fecha_termino)
                   BETWEEN 
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;
        
        case 3:
          /**/
          return " (fecha_actualizacion)
                   BETWEEN 
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;

        case 10:
          /**/
          return " (fecha_cancelacion)
                   BETWEEN 
                   '".$fecha_inicio."' AND  '".$fecha_termino."' ";
          break;

        default:
          
          break;
      }
      
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
        $cancela_cliente = $param["cancela_cliente"];
        
        $extra_cancelacion = " cancela_cliente =0 ";
        if($cancela_cliente ==  1){
          $extra_cancelacion = " cancela_cliente =1 ";  
        }
        /**/
        $query_update = "UPDATE 
                            proyecto_persona_forma_pago 
                          SET 
                            status = 10,
                            fecha_cancelacion = CURRENT_DATE(), 
                            $extra_cancelacion,
                            se_cancela =1
                          WHERE 
                            id_proyecto_persona_forma_pago = $id_recibo 
                          LIMIT 1";
        
        $data_complete["sql"]=$query_update;
        $this->db->query($query_update);        
        $data_complete["id_servicio"]
        =  $this->actualiza_valoracion_negativa_orden_compra($id_recibo);
        return $data_complete;
    }   
    /**/
    private function actualiza_valoracion_negativa_orden_compra($id_recibo){
        
        $query_get =  "SELECT id_servicio 
                      FROM 
                        proyecto_persona_forma_pago 
                      WHERE 
                        id_proyecto_persona_forma_pago = $id_recibo 
                        LIMIT 1";
        
        $id_servicio =$this->db->query($query_get)->result_array()[0]["id_servicio"];

        $query_update ="UPDATE servicio SET valoracion =  valoracion -1 
                WHERE id_servicio = $id_servicio LIMIT 1";

        $this->db->query($query_update);
        return $id_servicio;
    } 
    /**/
    function get_solicitudes_saldo($param){
               
        $_num =  get_random();
        $this->create_tmp_solicitud_pago_usuario(0, $_num, $param);
            
            $query_get ="SELECT * FROM tmp_solicitud_pago_usuario_$_num s 
                        INNER JOIN solicitud_pago sp
                        ON s.id_solicitud = sp.id_solicitud";            
            $data_complete =  $this->db->query($query_get)->result_array();
        $this->create_tmp_solicitud_pago_usuario(1, $_num, $param);
        return $data_complete;        
    }    
    private function create_tmp_solicitud_pago_usuario($flag , $_num , $param){
        
        $query_drop = "DROP TABLE IF exists tmp_solicitud_pago_usuario_$_num";
        $this->db->query($query_drop);
        if ($flag ==  0){
            $id_usuario =  $param["id_usuario"];
            $query_create ="CREATE TABLE tmp_solicitud_pago_usuario_$_num
                            AS
                            SELECT id_solicitud FROM solicitud_pago_usuario 
                            WHERE id_usuario =$id_usuario
                            AND status =0 ";            
            $this->db->query($query_create);
        }        
    }
    

}