<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class cobranzamodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }       
    /**/
    function get_info_recibo_por_id($param){
      /**/
      $id_recibo =  $param["id_recibo"];
      $query_get ="SELECT 
                  * 
                  FROM 
                  proyecto_persona_forma_pago
                  WHERE 
                  id_proyecto_persona_forma_pago =  $id_recibo 
                  LIMIT 1";
                  $result =  $this->db->query($query_get);
                  return $result->result_array();
    }
    /**/
    function get_ventas_dia($param){

      $dia =  $param["fecha"];
      $query_get ="SELECT 
                    COUNT(0)num_ventas 
                  FROM 
                    proyecto_persona_forma_pago  
                  WHERE 
                    DATE(fecha_registro) ='".$dia."'
                    AND
                    monto_a_pagar <= saldo_cubierto";
                    
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["num_ventas"];

    }
    function get_solicitudes_venta_dia($param){

      $dia =  $param["fecha"];
      $query_get ="SELECT 
                    COUNT(0)num_solicitudes 
                  FROM 
                    proyecto_persona_forma_pago  
                  WHERE 
                    DATE(fecha_registro) ='".$dia."'";

      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["num_solicitudes"];

    }
    /**/
    function notifica_email_enviado_recordatorio($param){

      $id_recibo =  $param["id_recibo"];
      $query_update = "UPDATE 
                      proyecto_persona_forma_pago 
                      SET 
                      num_email_recordatorio =  num_email_recordatorio + 1
                      WHERE 
                      id_proyecto_persona_forma_pago =  $id_recibo LIMIT 1";

        return $this->db->query($query_update);                      
    }
    
    /**/
    function get_historial_pagos($param){

      $id_proyecto_persona= $param["id_proyecto_persona"];
      $query_get ="SELECT 
                    ppf.* , 
                    f.forma_pago ,
                    u.nombre nombre_usuario_validacion, 
                    u.apellido_paterno apellido_paterno_usuario_validacion  ,  
                    u.apellido_materno apellido_materno_usuario_validacion  ,               
                    
                    DATEDIFF(
                    ppf.fecha_vencimiento , 
                    date(current_date()))dias_restantes,
                    ppf.fecha_vencimiento_anticipo, 
                    
                    DATEDIFF(
                    ppf.fecha_vencimiento_anticipo ,
                    date(current_date()))dias_restantes_anticipo

                  FROM 
                    proyecto_persona_forma_pago ppf
                  INNER JOIN  
                    forma_pago f 
                  ON 
                    ppf.id_forma_pago =  f.id_forma_pago
                  LEFT OUTER JOIN
                    usuario u
                  ON ppf.id_usuario_validacion =  u.idusuario
                  WHERE 
                    id_proyecto_persona =  $id_proyecto_persona
                  ORDER BY 
                  fecha_registro DESC";

      $result =  $this->db->query($query_get);
      return $result->result_array();
  }
    /**/
    function get_info_persona($param){

      $query_get = "SELECT 
                      * 
                    FROM persona 
                    WHERE 
                    id_persona = '".$param["id_persona"]."' 
                    LIMIT 1  ";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_resumen_proyecto_persona($param){
     
      $id_proyecto_persona = $param["id_proyecto_persona"]; 
      $query_get ="SELECT 
                    pp.* ,
                    pp.fecha_registro fecha_inicio,
                    p.*,  
                    c.ciclo,
                    DATEDIFF(pp.siguiente_vencimiento ,date(current_date()) )dias_restantes_vencimiento
                  FROM 
                    proyecto_persona  pp
                  INNER JOIN proyecto p 
                    ON pp.id_proyecto  =  p.id_proyecto
                  INNER JOIN ciclo_facturacion c 
                    ON 
                  pp.ciclo_facturacion = c.id_ciclo_facturacion
                    WHERE 
                  id_proyecto_persona = $id_proyecto_persona 
                  LIMIT 1";  
                  
      $result = $this->db->query($query_get );
      return $result->result_array();
    }
    /**/
    function get_saldo_pendiente_recibo($param){

      $id_recibo =  $param["id_recibo"];
      $query_get = "SELECT 
                      monto_a_pagar , 
                      flag_envio_gratis
                    FROM 
                    proyecto_persona_forma_pago 
                    WHERE 
                    id_proyecto_persona_forma_pago = $id_recibo 
                    LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_nombre_persona($id_usuario){
    
        $query_get = "SELECT 
                        nombre   ,
                        apellido_paterno ,
                        apellido_materno
                      FROM  
                        usuario 
                      WHERE 
                      idusuario = $id_usuario LIMIT 1";
        
        $result=  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_comentarios_por_pago_notificado($param){
       
       $id_notificacion_pago =  $param["id_notificacion_pago"];
      
       $query_get = "SELECT 
                      * 
                    FROM 
                    comentario_pago 
                    WHERE 
                    id_notificacion_pago 
                    = 
                    '".$id_notificacion_pago."'  
                    LIMIT 10";

       $result =  $this->db->query($query_get);
       return $result->result_array();
       

    }    
    /**/
    function registra_comentario_pago_notificado($param){

      $comentario =  $param["comentario"];
      $id_notificacion_pago =  $param["id_notificacion_pago"];
      $id_usuario =  $param["id_usuario"];

      $query_insert ="INSERT INTO comentario_pago(    
                        comentario,              
                        id_notificacion_pago
                      )VALUES(
                        '".$comentario."' , 
                        ".$id_notificacion_pago."
                      )";

      return $this->db->query($query_insert);
             
    }
    /**/
    function get_id_proyecto_servicio_por_ppfp($id_proyecto_persona_forma_pago){

       $query_get ="SELECT 
                    pp.id_proyecto_persona
                    FROM 
                    proyecto_persona_forma_pago ppfp 
                    INNER JOIN                 
                    proyecto_persona pp 
                    ON  ppfp.id_proyecto_persona =  pp.id_proyecto_persona                  
                    WHERE 
                    id_proyecto_persona_forma_pago = $id_proyecto_persona_forma_pago LIMIT 1";
       
        $result =  $this->db->query($query_get);
        $data =   $result->result_array();
        return $data[0]["id_proyecto_persona"];


    }
    /**/
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
    /***/
    function get_id_servicio_por_ppfp($id_recibo){

     $query_get ="SELECT 
                  id_servicio
                  FROM 
                  proyecto_persona_forma_pago 
                  WHERE 
                  id_proyecto_persona_forma_pago = $id_recibo LIMIT 1";
        $result =  $this->db->query($query_get);
        $data =   $result->result_array();
        return $data[0]["id_servicio"];

    }
    /**/
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
    /**/
    function get_notificacion_pago($param){

        $id_notificacion_pago =  $param["id_notificacion_pago"];
        /**/
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
    
    /**/
    function get_monto_pendiente_proyecto_persona_forma_pago($param){

      $id_recibo = $param["recibo"];
      $query_get ="SELECT 
                    * 
                   FROM  
                    proyecto_persona_forma_pago 
                   WHERE   
                    id_proyecto_persona_forma_pago = '".$id_recibo."' LIMIT 1";
      $result =  $this->db->query($query_get);
      return $result->result_array();
                    
    }
   
    /**/
    function get_precio_id_servicio($id_servicio){

      $query_get = "SELECT  
                      s.precio ,                     
                      s.id_ciclo_facturacion ,                    
                      c.ciclo
                      FROM  
                      servicio s
                      INNER JOIN 
                      ciclo_facturacion c 
                      ON
                      s.id_ciclo_facturacion =  c.id_ciclo_facturacion
                      WHERE s.id_servicio =$id_servicio  LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_persona_por_usuario($param){

        $query_get ="SELECT 
                        id_persona 
                    FROM 
                        persona 
                    WHERE 
                    id_usuario_enid_service = '".$param["id_usuario"]."' 
                    LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["id_persona"];
    }
    /**/
    function crea_resumen_compra($servicio , $num_ciclos , $flag_envio_gratis){
        $nombre_servicio =  $servicio["nombre_servicio"];
        $resumen = $num_ciclos." ".$nombre_servicio;        
        if($flag_envio_gratis ==  1){
          $resumen .= " - Envío gratis";
        }
        return $resumen;        
    }
    /**/
    function crea_orden_de_compra($param){    
      
      $id_forma_pago =  6;
      $saldo_cubierto = 0;
      $status = 6;/*En proceso de compra*/      
      $fecha_vencimiento =" DATE_ADD(CURRENT_DATE(), INTERVAL 2 DAY) ";
      
      

      $data_usuario =  $param["data_por_usuario"];      
      
      if($param["es_usuario_nuevo"] == 1){
          $id_usuario =  $data_usuario["id_usuario"];  
      }else{
          $id_usuario =  $param["id_usuario"];  
      }

      if(get_info_usuario_valor_variable($data_usuario , "usuario_referencia" )
        ==0 ){
          $id_usuario_referencia =  $id_usuario;
      }else{
          $id_usuario_referencia =  $data_usuario["usuario_referencia"];
      }

      $num_ciclos =  $data_usuario["num_ciclos"];    
      $servicio =  $param["servicio"];
      $id_servicio =  $servicio["id_servicio"];

      $flag_envio_gratis =  $servicio["flag_envio_gratis"];
      $id_usuario_venta =  $servicio["id_usuario_venta"];
      $precio =  $servicio["precio"];
      /***/

      $resumen_compra =  
      $this->crea_resumen_compra($servicio , $num_ciclos , $flag_envio_gratis);
      
      $costo_envio_cliente =0;
      $costo_envio_vendedor =0;
      $flag_servicio =  $servicio["flag_servicio"];
      $monto_a_pagar =  $precio; 

      if($flag_servicio ==  0){
          
        $costo_envio  = $param["costo_envio"];
        $costo_envio_cliente =   $costo_envio["costo_envio_cliente"];        
        $costo_envio_vendedor =  $costo_envio["costo_envio_vendedor"];
  
      }
      
      $id_ciclo_facturacion =  $param["id_ciclo_facturacion"]; 
      
      /**/
      $query_insert ="INSERT INTO proyecto_persona_forma_pago(
                                  id_forma_pago                  
                                  ,saldo_cubierto                                           
                                  ,status                         
                                  ,fecha_vencimiento              
                                  ,monto_a_pagar  
                                  ,id_usuario_referencia          
                                  ,flag_envio_gratis 
                                  ,costo_envio_cliente
                                  ,costo_envio_vendedor 
                                  ,id_usuario_venta    
                                  ,id_ciclo_facturacion           
                                  ,num_ciclos_contratados         
                                  ,id_usuario                     
                                  ,precio  
                                  ,id_servicio
                                  ,resumen_pedido
                                  )VALUES(
                                    $id_forma_pago , 
                                    $saldo_cubierto , 
                                    $status , 
                                    $fecha_vencimiento,  
                                    $monto_a_pagar,                                  
                                    $id_usuario_referencia , 
                                    $flag_envio_gratis , 
                                    $costo_envio_cliente , 
                                    $costo_envio_vendedor ,
                                    $id_usuario_venta, 
                                    $id_ciclo_facturacion,
                                    $num_ciclos,
                                    $id_usuario , 
                                    $precio,
                                    $id_servicio,
                                    '".$resumen_compra."'
                                  )";                          

      $this->db->query($query_insert);

      $id =  $this->db->insert_id();      
      $this->mejora_calificacion_servicio($id_servicio);
      return $id;
    
    }      
    /**/
    private function mejora_calificacion_servicio($id_servicio){

      $query_update ="UPDATE servicio SET valoracion = valoracion+1 
                      WHERE id_servicio=$id_servicio LIMIT 1";
      return $this->db->query($query_update);
    } 
    /**/
    function get_fechas_por_ciclo_facturacion($id_ciclo_facturacion , $num_ciclos){

      
      $data_complete =[];
      switch ($id_ciclo_facturacion) {
        case 1:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , INTERVAL  ".$num_ciclos." YEAR) ";
          $nombre_periodo =" años contratados ";

          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;
          break;
        
        case 2:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , 
                                    INTERVAL  ".$num_ciclos." MONTH) ";  
        
          $nombre_periodo =" Meses contratados "; 


          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;

          break;


        case 5:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , 
                                    INTERVAL  1 DAY) ";
          $nombre_periodo =" ";

          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;
          break;

          
        

        default:
         
          break;
      }
      /**/
      return $data_complete;    
    }
    /**/    
  function get_id_usuario_ventas_servicio($id_servicio){

      $query_get ="SELECT id_usuario FROM servicio WHERE id_servicio =  $id_servicio LIMIT 1";
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["id_usuario"];
  }
    /**/
    function get_servicio_por_id_servicio($id_servicio){

        $query_get = "SELECT 
                        * 
                      FROM 
                      servicio 
                      WHERE 
                      id_servicio ='".$id_servicio."' ";

        $result =  $this->db->query($query_get);
        return $result->result_array();    
    }
    /**/
    function get_servicio($id_servicio){

        /***/
        $query_get = "SELECT 
                        * 
                      FROM 
                      servicio 
                      WHERE 
                      id_servicio ='".$id_servicio."' ";
        $result =  $this->db->query($query_get);
        return $result->result_array();    
    }
    /**/
    function get_proyecto_persona_por_id_proyecto_persona($param){

        $id_proyecto_persona_forma_pago =   $param["id_proyecto_persona_forma_pago"];


        $query_get ="SELECT 
                        id_proyecto_persona  
                    FROM 
                        proyecto_persona_forma_pago 
                    WHERE 
                        id_proyecto_persona_forma_pago 
                    =  
                    '".$id_proyecto_persona_forma_pago."'";


        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["id_proyecto_persona"];
        
    }   
    /**/
    function get_where_estado_venta($param){
      /*      
        Compra realizada                         |                       1 |
        En proceso de compra | pendiente de pago |                       6 |
        Pedido en camino                         |                       7 |
        Entregado                                |                       9 |
      */

      $id_usuario =  $param["id_usuario"];       
      $sql= "";
      $modalidad =  $param["modalidad"];  
      /*Si es venta*/
      if($modalidad == 1){        
        switch($param["status"]){
          case 1:            
            /*Se pagó pero no se ha enviado*/
            $sql= "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                      status = 1
                    AND 
                      saldo_cubierto>=monto_a_pagar";  
            break;
          case 6:            
            /*Solicitud compra*/
            $sql= "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                    status = 6";  
            break;            
          case 7:                      
            $sql= "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                    status = 7";                      
            break;                      
          /*Entregado sin problemas*/
          case 9:                    
            $sql= "WHERE 
                    id_usuario_venta = $id_usuario  
                    AND  
                    status = 9";  
            break;  
          
          default:
            
            break;
        }
      }else{
          /*Cobranza*/

          switch($param["status"]){          
            case 6:            
              /*Se pagó*/
              $sql= " WHERE 
                      id_usuario = $id_usuario  
                      AND  
                      status = 6
                      AND se_cancela =0";  
              break;
              
            default:
              
              break;
          }
      }
      return $sql;
    }
    /*Cargamos las ventas realizadas por el*/
    function get_ventas_usuario($param){      

      $where =  $this->get_where_estado_venta($param , 1);
      $query_get = "SELECT 
                        id_proyecto_persona_forma_pago ,
                        resumen_pedido,
                        id_servicio,
                        monto_a_pagar, 
                        costo_envio_cliente,
                        saldo_cubierto,
                        status,
                        fecha_registro,
                        num_ciclos_contratados,
                        estado_envio
                        FROM 
                          proyecto_persona_forma_pago
                        ".$where;
                        $data_complete["sql"]=  $query_get;
      $result =  $this->db->query($query_get);
      $data_complete["data"] =  $result->result_array();      
      $data_complete["sql"] =  $query_get;
      return $data_complete;
    }
    /**/
    function agrega_usuarios_a_saldos_pendientes($saldos_pendientes){

      $nueva_data =  [];
      $a =0;
      foreach($saldos_pendientes as $row){          
          
          $nueva_data[$a] =$row;
          
          $usr_proyecto=$this->get_id_usuario_por_id_proyecto_persona($row["id_proyecto_persona"]);
          $nueva_data[$a]["id_usuario"] =$usr_proyecto[0]["id_usuario"];
          $nueva_data[$a]["id_proyecto"] =$usr_proyecto[0]["id_proyecto"];
          /**/

          $a ++;  
      }
      return $nueva_data;
    }  
    /**/
    function get_id_usuario_por_id_proyecto_persona($id_proyecto_persona){
        /**/
        $query_get ="SELECT id_usuario , id_proyecto FROM proyecto_persona 
                    WHERE id_proyecto_persona=$id_proyecto_persona LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();      

    }
    /**/
    function agrega_servicios_a_saldos($saldos_pendientes){

      $nueva_data =  [];
      $a =0;
      foreach($saldos_pendientes as $row){                    
          $nueva_data[$a] =$row;
          $id_servicio=$this->get_id_servicio_por_proyecto($row["id_proyecto"]);
          $nueva_data[$a]["id_servicio"] =$id_servicio;          
          $a ++;  
      }
      return $nueva_data;
    } 
    /**/
    function get_id_servicio_por_proyecto($id_proyecto){
        /**/
        $query_get ="SELECT id_servicio FROM proyecto
                    WHERE id_proyecto=$id_proyecto LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["id_servicio"];      

    }
    /**/
    function create_tmp_data_cliente($flag , $_num , $param ){

      /**/
      $query_drop  = "DROP  TABLE IF exists tmp_data_cliente_$_num";
      $this->db->query($query_drop);
      
      if($flag == 0 ){
        
        $query_get = "CREATE TABLE  tmp_data_cliente_$_num AS 
                        SELECT 
                        u.idusuario ,
                        u.nombre  nombre_cliente       ,
                        u.apellido_paterno   apellido_cliente ,
                        u.apellido_materno  apellido2_cliente  
                      FROM 
                        usuario u 
                      INNER  JOIN 
                        tmp_ordenes_pendientes_$_num p 
                      ON 
                      u.idusuario =  p.id_usuario
                      GROUP BY u.idusuario";
                    $this->db->query($query_get);

      }
      /**/

    }
    /**/
    function create_tmp_data_usuarios_ventas($flag , $_num , $param ){

      /**/
      $query_drop  = "DROP  TABLE IF exists tmp_data_usuarios_ventas_$_num";
      $this->db->query($query_drop);
      
      if($flag == 0 ){
        
        $query_get = "CREATE TABLE  tmp_data_usuarios_ventas_$_num AS 
                        SELECT 
                        u.idusuario id_usuario_ventas,
                        u.nombre  nombre_vendedor       ,
                        u.apellido_paterno   apellido_vendedor ,
                        u.apellido_materno  apellido2_vendedor  
                      FROM 
                        usuario u 
                      INNER  JOIN 
                        tmp_ordenes_pendientes_$_num p 
                      ON 
                      u.idusuario =  p.id_usuario_referencia
                      GROUP BY u.idusuario";
                    $this->db->query($query_get);

      }
      /**/
    }
    /**/
    function get_num_saldos_pendientes($param){

        $where  = $this->get_where_tipo_cobranza_num($param);
        $query_get =  "SELECT 
                          count(0)num_pendientes
                        FROM 
                           proyecto_persona_forma_pago ppfp                        
                          ".$where;

        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num_pendientes"];                         
    }


    function get_num_saldos_pendientes_persona($param){

        $query_get = "SELECT 
                            count(0)num_pendientes
                        FROM 
                           proyecto_persona_forma_pago ppfp                        
                        INNER JOIN 
                            proyecto_persona pp 
                        ON  
                            ppfp.id_proyecto_persona =  pp.id_proyecto_persona  
                        INNER JOIN proyecto p 
                        ON
                            pp.id_proyecto =  p.id_proyecto                            
                        WHERE  
                            pp.id_persona = '".$param["id_persona"]."'                           
                        AND 
                            ppfp.saldo_cubierto < monto_a_pagar 
                        ";

        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num_pendientes"];
    }
    /**/
    /**/
    
    function get_where_tipo_cobranza_num($param){
        

        $tipo = $param["tipo"];
        $extra = "";  
        $where =""; 
        switch ($tipo){
            case 1:
        
              $where =" WHERE  
                          id_usuario_venta =  $id_usuario AND                           
                          ppfp.saldo_cubierto < monto_a_pagar
                            AND 
                          datediff( CURRENT_DATE() ,  ppfp.fecha_vencimiento_anticipo) < 2";

            break;

            case 2:

              $where =" WHERE                  
                          id_usuario_venta =  $id_usuario AND                           

                          ppfp.saldo_cubierto >= monto_a_pagar                            
                            AND 
                              datediff( CURRENT_DATE() , pp.siguiente_vencimiento) >= - 240
                              AND  
                              datediff( CURRENT_DATE() , pp.siguiente_vencimiento) < 0";

              
              break;

             case 3:
              $where =" WHERE   
                          id_usuario_venta =  
                          $id_usuario AND                                                    
                          ppfp.saldo_cubierto < monto_a_pagar
                            AND 
                          datediff( CURRENT_DATE() ,  ppfp.fecha_vencimiento_anticipo) > 1";
              break;
              


              case 4:
            
                   $where =" WHERE 
                          id_usuario_venta =  $id_usuario AND                                                                               
                          ppfp.saldo_cubierto >= monto_a_pagar";


              break;


            default:
            
            break;
        }

        return $where;            
    }
    /**/
    function get_where_tipo_cobranza($tipo , $param){

        $recibo =  $param["recibo"];
        $nombre = $param["nombre"];

        $extra = "";
        if($recibo  > 0) {
          $extra =  " AND ppfp.id_proyecto_persona_forma_pago = '".$recibo."' ";        
        }if (strlen($nombre ) >1 ){
          $extra =  " AND (prn.nombre like  '%".$nombre."%'  OR  
                          a_paterno like  '%".$nombre."%'  OR  
                          a_materno like  '%".$nombre."%'  
                          OR  
                          p.proyecto LIKE '%".$nombre."%' )";        
        }
        $where =""; 
        switch ($tipo) {
            case 1:
        
              $where =" WHERE                              
                          ppfp.saldo_cubierto < monto_a_pagar
                            AND 
                          datediff( CURRENT_DATE() ,  ppfp.fecha_vencimiento_anticipo) < 2
                          ".$extra."
                          GROUP BY ppfp.id_proyecto_persona_forma_pago                          
                          ";

            break;

            case 2:

              $where =" WHERE                                                    
                          ppfp.saldo_cubierto >= monto_a_pagar                            
                          GROUP BY ppfp.id_proyecto_persona_forma_pago
                          ORDER BY dias_para_vencimiento_servicio DESC";

              
              break;

             case 3:
              $where =" WHERE                              
                          ppfp.saldo_cubierto < monto_a_pagar                           
                          GROUP BY ppfp.id_proyecto_persona_forma_pago
                          ORDER BY dias_para_vencimiento DESC";
              break;
              


              case 4:
            
                   $where =" WHERE                                                    
                          ppfp.saldo_cubierto >= monto_a_pagar                            
                            
                          GROUP BY ppfp.id_proyecto_persona_forma_pago
                          ORDER BY 
                           prn.id_persona
                           DESC";


              break;


            default:
            
            break;
        }

        return $where;            
    }
    /**/
    function get_saldos_pendientes_usuario($param){
        
        $id_usuario = $param["id_usuario"];
           $query_get = "SELECT 
                            ppfp.* , 
                            datediff( CURRENT_DATE() , 
                            ppfp.fecha_vencimiento_anticipo) dias_para_vencimiento ,  
                            p.proyecto,                            
                            cf.ciclo, 
                            cf.flag_meses, 
                            cf.num_meses
                        FROM 
                           proyecto_persona_forma_pago ppfp                        
                        INNER JOIN 
                            proyecto_persona pp 
                        ON  
                            ppfp.id_proyecto_persona =  pp.id_proyecto_persona                        
                        INNER JOIN 
                            ciclo_facturacion cf 
                        ON     
                            pp.ciclo_facturacion =  cf.id_ciclo_facturacion

                        INNER JOIN proyecto p 
                        ON
                            pp.id_proyecto =  p.id_proyecto                            
                        WHERE     
                            pp.id_usuario = '".$id_usuario."'                        
                        AND  
                            ppfp.saldo_cubierto < monto_a_pagar";

        $result = $this->db->query($query_get);
        return $result->result_array();

    }
    /*
    function get_saldos_realizados_usuario($param){
        
          $id_usuario = $param["id_usuario"];
             $query_get = "SELECT 
                              ppfp.* , 
                              datediff( CURRENT_DATE() , 
                              ppfp.fecha_vencimiento_anticipo) dias_para_vencimiento ,  
                              p.proyecto,                            
                              cf.ciclo, 
                              cf.flag_meses, 
                              cf.num_meses
                          FROM 
                             proyecto_persona_forma_pago ppfp                        
                          INNER JOIN 
                              proyecto_persona pp 
                          ON  
                              ppfp.id_proyecto_persona =  pp.id_proyecto_persona                        
                          INNER JOIN 
                              ciclo_facturacion cf 
                          ON     
                              pp.ciclo_facturacion =  cf.id_ciclo_facturacion

                          INNER JOIN proyecto p 
                          ON
                              pp.id_proyecto =  p.id_proyecto                            
                          WHERE     
                              pp.id_usuario = '".$id_usuario."'                        
                          AND  
                              
                          ppfp.monto_a_pagar
                            <=  
                          ppfp.saldo_cubierto
                          ";

          $result = $this->db->query($query_get);
          return $result->result_array();
    }
    */
    /**/
    function registra_pago_usuario($param){
        
        $num_recibo =  $param["num_recibo"];
        $nombre =  $param["nombre"];
        $correo =  $param["correo"];
        $dominio =  $param["dominio"];
        $servicio =  $param["servicio"];    

        $fecha_pago = $param["fecha"];
        $cantidad =  $param["cantidad"];
        $forma_pago =  $param["forma_pago"];
        $referencia =  $param["referencia"];
        $comentarios =  $param["comentarios"];
        

        $query_insert = "INSERT INTO notificacion_pago( 
                            nombre_persona      ,
                            correo              ,
                            dominio             ,
                            id_servicio         ,
                            fecha_pago          ,
                            cantidad            ,
                            id_forma_pago       ,
                            referencia          ,
                            comentario          ,
                            num_recibo
         )VALUES(
            
            '". $nombre ."', 
            '". $correo ."' ,
            '". $dominio    ."' ,
            '". $servicio ."' ,
            '". $fecha_pago  ."', 
            '". $cantidad  ."',             
            '". $forma_pago ."',
            '". $referencia ."',
            '". $comentarios ."' ,
            '".$num_recibo."'
         )";

        $this->db->query($query_insert);         
        return $this->db->insert_id();        
    }
    /**/
    function crea_proyecto($param){

      $proyecto  =$param["proyecto"];      
      $url              =$param["url"];
      $idtipo_negocio   =$param["tipo_negocio"];
      $id_servicio   =$param["id_servicio"];

      $query_insert = "INSERT INTO proyecto(      
                            proyecto ,                                   
                            url,                            
                            id_servicio  
                        )VALUES(                        
                            '".$proyecto  ."',                             
                            '".$url              ."',                             
                            '".$id_servicio   ."'
                        )";

      $this->db->query($query_insert);
      return $this->db->insert_id();     

    }
    /**/
    function crea_proyecto_persona_forma_pago($param){

      $id_proyecto_persona = $param["id_proyecto_persona"];
      $id_forma_pago       = $param["id_forma_pago"];
      $saldo_cubierto     = 0;      
      
      $fecha_vencimiento          =$param["fecha_vencimiento"];
      $id_usuario_validacion = $param["id_usuario"];
      $monto_a_pagar  = $param["monto_a_pagar"];
      $razon_social               =$param["razon_social"];
      $fecha_vencimiento_anticipo =$param["fecha_vencimiento_anticipo"];


        $query_insert ="INSERT INTO proyecto_persona_forma_pago( 
                                  id_proyecto_persona ,           
                                  id_forma_pago,          
                                  saldo_cubierto,                                                                                         
                                  fecha_vencimiento,      
                                  id_usuario_validacion,     
                                  monto_a_pagar,                        
                                  razon_social,                
                                  fecha_vencimiento_anticipo     
                          )
                    VALUES(
                      '".  $id_proyecto_persona ."',
                      '".  $id_forma_pago ."',
                            $saldo_cubierto ,                                            
                            $fecha_vencimiento,                          
                      '".  $monto_a_pagar ."',
                      '".  $razon_social ."',
                      '".  $fecha_vencimiento_anticipo ."'
                    )";
      
        $this->db->query($query_insert);
        return $this->db->insert_id();     
    
    }
    /**/    
    function crea_anticipo($param){
      
      $anticipo                       = $param["anticipo"];
      $descripcion                    = $param["descripcion"];
      $id_proyecto_persona_forma_pago = $param["id_proyecto_persona_forma_pago"];
      $fecha_vencimiento              = $param["fecha_vencimiento"];
      $id_usuario                     = $param["id_usuario_validacion"];

      $query_insert ="INSERT INTO anticipo(
                        anticipo  ,                     
                        descripcion ,                    
                        id_proyecto_persona_forma_pago , 
                        fecha_vencimiento ,             
                        id_usuario 
                        )VALUES(

        '".$anticipo                       ."' ,
        '".$descripcion                    ."' ,
        '".$id_proyecto_persona_forma_pago ."' ,
        '".$fecha_vencimiento              ."' ,
        '".$id_usuario                     ."' 
      )";

        $this->db->query($query_insert);
        return $this->db->insert_id();     
    
    }

    /**/
    function get_usuarios_deuda_pendiente(){
      

        $query_get ="SELECT 
                      id_usuario ,
                      id_proyecto_persona_forma_pago
                    FROM 
                      proyecto_persona_forma_pago
                    WHERE 
                      saldo_cubierto < monto_a_pagar 
                    AND 
                      num_email_recordatorio < 3
                    AND  status = 6";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/

    /*
    function get_num_recibos_deuda_pendiente($param){

                  $query_get ="SELECT 
                    id_proyecto_persona_forma_pago , 
                    id_proyecto_persona 
                  FROM 
                    proyecto_persona_forma_pago
                  WHERE 
                    saldo_cubierto < monto_a_pagar 
                  AND 
                    num_email_recordatorio < 3";
                    
                    $result =  $this->db->query($query_get);
                    return $result->result_array();

    } 
    */   
    /**/
    function get_where_compras_usuario($param){

      /**/
      $where = "";
      if(get_info_usuario_valor_variable($param , "status") > 0){
        
        $status = $param["status"];
        $where = " AND status = ".$status;
      }
      $order =" ORDER BY fecha_registro DESC";
      $where =  $where . $order;
      return $order;
    }
    /*Retorna las compras por usuario (EN SU ÁREA DE CLIENTE)*/
    function get_compras_usuario($param){
    
      $where =  $this->get_where_estado_venta($param);
      $query_get ="SELECT 
                    id_proyecto_persona_forma_pago ,
                    resumen_pedido,
                    id_servicio,
                    monto_a_pagar, 
                    costo_envio_cliente,
                    saldo_cubierto,
                    status,
                    fecha_registro,
                    num_ciclos_contratados,
                    estado_envio
                  FROM 
                  proyecto_persona_forma_pago 
                  ".$where;

      $data_complete["sql"]= $query_get;
      $result = $this->db->query($query_get);
      $data_complete["data"]=  $result->result_array();      
      return $data_complete;
      
    }   
    /**/
    function get_estatus_servicio_enid_service(){
       $query_get = "SELECT 
                      id_estatus_enid_service
                      ,nombre                 
                      ,text_cliente           
                      ,text_vendedor          

                      FROM status_enid_service WHERE pago=1"; 
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function valida_recibo_por_pagar($param){

      $id_usuario =  $param["id_usuario"];
      $id_usuario_venta = $param["id_usuario_venta"];
      $id_recibo =  $param["id_recibo"];
      $query_get ="SELECT * FROM proyecto_persona_forma_pago 
                WHERE 
                  id_proyecto_persona_forma_pago =$id_recibo
                AND 
                  id_usuario =  $id_usuario
                AND
                  id_usuario_venta =  $id_usuario_venta
                AND 
                  monto_a_pagar >saldo_cubierto 
                LIMIT 1";

                $result =  $this->db->query($query_get);
                return $result->result_array();
    }
    /**/
    function valida_recibo_por_pagar_usuario($param){
      
      $id_usuario =  $param["id_usuario"];      
      $id_recibo =  $param["id_recibo"];
      $query_get ="SELECT 
                    *
                  FROM proyecto_persona_forma_pago 
                  WHERE 
                    id_proyecto_persona_forma_pago =$id_recibo
                  AND 
                    id_usuario =  $id_usuario
                  AND 
                    monto_a_pagar >saldo_cubierto 
                  LIMIT 1";
                  
                $result =  $this->db->query($query_get);
                return $result->result_array();
                
    }
    function valida_recibo_por_enviar_usuario($param){

      $id_usuario =  $param["id_usuario"];      
      $id_recibo =  $param["id_recibo"];
      $query_get ="SELECT * FROM 
                    proyecto_persona_forma_pago 
                  WHERE 
                    id_proyecto_persona_forma_pago =$id_recibo
                  AND 
                    id_usuario_venta =  $id_usuario
                  AND 
                    monto_a_pagar <= saldo_cubierto 
                  LIMIT 1";

                $result =  $this->db->query($query_get);
                return $result->result_array();

    }
    /**/

}