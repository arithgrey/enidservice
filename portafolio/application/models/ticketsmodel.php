<?php defined('BASEPATH') OR exit('No direct script access allowed');
class ticketsmodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
      $id_proyecto_persona_forma_pago = 0; 
  }   
  /**/
  /**/
  function get_ticket_id($id_ticket){
    
    $query_get ="SELECT
                 t.* ,
                 d.nombre nombre_departamento
                FROM 
                  ticket t

                INNER JOIN departamento d 
                ON 
                 t.id_departamento = d.id_departamento 
                WHERE  t.id_ticket = $id_ticket
                limit 1";
    $result =  $this->db->query($query_get);
    return $result->result_array();    
  }
  /**/
  function get_nombre_usuario($id_usuario){

    $query_get ="SELECT 
                nombre,
                apellido_paterno, 
                apellido_materno ,   
                email
                FROM usuario 
                WHERE idusuario = '".$id_usuario."' LIMIT 1 ";
    
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function es_cliente($id_usuario){
      
      /**/
      $query_get ="SELECT count(0)num_cliente FROM usuario_perfil 
                    WHERE idusuario =$id_usuario 
                  AND 
                  idperfil =20 LIMIT 1";
      $result =  $this->db->query($query_get);
      $es_cliente =  $result->result_array()[0]["num_cliente"];
      return $es_cliente;
  }

  /**/
  function get_id_proyecto_persona_forma_pago(){
    return $this->id_proyecto_persona_forma_pago;
  }
  /**/
  function set_id_proyecto_persona_forma_pago($n_id_proyecto_persona_forma_pago){
    $this->id_proyecto_persona_forma_pago =  $n_id_proyecto_persona_forma_pago;
  }
  /**/
  function update_departamento($param){

    $query_update ="UPDATE 
                    ticket
                    SET 
                      id_departamento = '".$param["depto"]."' 
                    WHERE
                      id_ticket = '".$param["id_ticket"]."'
                      LIMIT  1";
    
    return $this->db->query($query_update);
  }
  /**/
  function update_asunto($param)
  {
    
    $asunto =  $param["asunto"];
    $id_ticket =  $param["id_ticket"];
    $query_update = "UPDATE ticket 
                      SET asunto = '".$asunto."' 
                      WHERE 
                      id_ticket = '".$id_ticket."'
                      LIMIT 1 ";
    
    return $this->db->query($query_update);    
  }
  /**/
  function get_servicios_cliente($id_usuario){
      
      $query_get = "SELECT 
                      p.* 
                    FROM  
                    proyecto p  
                    INNER JOIN  
                    proyecto_persona pp 
                    ON 
                    p.id_proyecto =  pp.id_proyecto 
                    WHERE 
                    pp.id_usuario = $id_usuario 
                    LIMIT 30";

      $result  = $this->db->query($query_get);
      return $result->result_array();
  }
  /**/
  function get_clientes_actuales(){    

    $query_get = "SELECT  
                  id_persona , 
                  tipo ,  
                  CONCAT(ifnull(nombre , ' ' ) ,  ' '  , ifnull(a_paterno, ' ') , ' '  , ifnull(a_materno, ' ' )    )nombre 
                  FROM 
                  persona 
                  WHERE tipo IN (2,  11)";


      $result  = $this->db->query($query_get);
      return $result->result_array();
  }
  /**/
  function get_info_cliente($param){
  
      $query_get = "SELECT  
                    idusuario id_usuario , 
                    CONCAT(nombre , apellido_paterno , apellido_materno)nombre 
                  FROM 
                    usuario 
                  WHERE 
                    idusuario ='".$param["id_usuario"]."' LIMIT 1";

      $result  = $this->db->query($query_get);
      return $result->result_array(); 
  }
  /**/
  function get_proyectos_disponibles(){

    $query_get  ="SELECT * FROM proyecto";
    $result  = $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_formas_de_pago(){
    $query_get  ="SELECT * FROM forma_pago";
    $result  = $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_num_personas_validacion(){
    

    $query_get = "SELECT COUNT(*)num_personas FROM persona WHERE tipo IN(4, 11)";
    $result =  $this->db->query($query_get);
    return $result->result_array()[0]["num_personas"];

  }
  /**/
  function libera_proyecto_validacion($param){

    $nombre_proyecto =  $param["nombre_proyecto"];
    $url =  $param["url"];
    $id_servicio =  $param["id_servicio"];

    $query_insert ="INSERT INTO proyecto(
                                      proyecto, 
                                      idtipo_proyecto , 
                                      url , 
                                      status, 
                                      id_servicio 
                                )VALUES(                    
                                  '".$nombre_proyecto."' ,
                                  1 , 
                                  '".$url."' , 
                                  0 , 
                                  '".$id_servicio ."'
                              )";

    $this->db->query($query_insert);
    $id_proyecto =  $this->db->insert_id();
    
    /**/    
    
    $this->registro_proyecto_persona($id_proyecto , $param);
    $this->abre_ticket_registro($id_proyecto , $param);
    return $this->get_id_proyecto_persona_forma_pago();
  }
  /**/
  /**/
  function abre_ticket_registro($id_proyecto , $param){

    $usuario_validacion =  $param["usuario_validacion"];

    
    $query_insert ="INSERT INTO 
       ticket(              
         asunto,                                                   
         prioridad,              
         id_proyecto,            
         id_usuario ,           
         id_departamento)
    VALUES(
        'Inicio de proyecto - página web' ,
        1 , 
        $id_proyecto , 
        $usuario_validacion , 
        1 )";
        $this->db->query($query_insert);    
        $id_ticket = $this->db->insert_id();

        /**/

        $query_insert ="INSERT INTO 
                        tarea(
                          descripcion,
                          id_ticket
                        )VALUES(
                            'Como nuevo usuario quiero poder tener 
                            los accesos a mis cuentas de Google Analytics 
                            con la finalidad de iniciar bien mi proyecto.' 
                            ,
                            $id_ticket
                        )";      


        return $this->db->query($query_insert);   
        
    
  }
  /**/
  function registro_proyecto_persona($id_proyecto , $param ){
    
    $id_persona = $param["id_persona"];
    $precio =  $param["precio_num"];
    
    $IVA  =  (int)$precio * .16;
    $total =  (int)$precio +  (int)$IVA;

    $ciclo_facturacion =  $param["ciclo_facturacion"];
    $fecha_vencimiento  =  $param["fecha_vencimiento"];
    $detalles_servicio =  $param["detalles_servicio"];

      $query_insert = " INSERT INTO proyecto_persona(
                             id_proyecto           
                            ,id_persona                  
                            ,precio                
                            ,ciclo_facturacion     
                            ,siguiente_vencimiento                 
                            ,detalles              
                            ,IVA                   
                            ,total                          
                            , estado 
                        )VALUES(
                          
                          '". $id_proyecto ."' ,
                          '". $id_persona ."' ,
                          '". $precio."' ,
                          '". $ciclo_facturacion."' , 
                          '". $fecha_vencimiento ."' ,
                          '". $detalles_servicio  ."' ,
                          '". $IVA ."' ,
                          '". $total ."' ,                            
                          '1'
                          )";

    $this->db->query($query_insert);
    $id_proyecto_persona =  $this->db->insert_id();

    
    return $this->registra_forma_pago_proyecto($param, $id_proyecto_persona);

  }
  /**/
  function registra_forma_pago_proyecto($param, $id_proyecto_persona){

    $param["id_proyecto_persona"] = $id_proyecto_persona;
    $id_forma_pago=  $param["forma_pago"];
    $saldo_cubierto =  $param["saldo_cubierto"];
    $saldo_cubierto_texto =  $param["saldo_cubierto_texto"];
    $RFC =  $param["RFC"];
    $domicilio_fiscal =  $param["domicilio_fiscal"];
    $usuario_validacion =  $param["usuario_validacion"];
    $total =  $param["total"];    
    $fecha_vencimiento = $param["fecha_vencimiento"];
    $renovacion = $param["renovacion"];
    
    $fecha_vencimiento_anticipo= $this->get_fecha_vencimiento_anticipo(
    $param ,
    $renovacion , 
    $fecha_vencimiento);

    

    $query_insert = "INSERT INTO proyecto_persona_forma_pago(      
                               id_proyecto_persona  
                              ,id_forma_pago        
                              ,saldo_cubierto       
                              ,saldo_cubierto_texto     
                              ,RFC                  
                              ,domicilio_fiscal
                              ,fecha_vencimiento  
                              ,id_usuario_validacion
                              ,monto_a_pagar
                              ,fecha_vencimiento_anticipo 
                          
                          )VALUES(                            
                            '". $id_proyecto_persona ."' ,  
                            '". $id_forma_pago ."' , 
                            '". $saldo_cubierto ."' , 
                            '". $saldo_cubierto_texto ."' ,  
                            '". $RFC ."' ,  
                            '". $domicilio_fiscal ."' , 
                            '". $fecha_vencimiento."' , 
                            '". $usuario_validacion ."'  , 
                            '".$total."',
                            $fecha_vencimiento_anticipo

                            )";


      $this->db->query($query_insert);
      $id_proyecto_persona_forma_pago =  $this->db->insert_id();
      $this->set_id_proyecto_persona_forma_pago($id_proyecto_persona_forma_pago);
      return $this->registra_anticipo($param , $id_proyecto_persona_forma_pago);
      
  }
  function registra_anticipo($param , $id_proyecto_persona_forma_pago ){

    $saldo_cubierto =  $param["saldo_cubierto"]; 
    $fecha_vencimiento =  $this->get_fecha_vencimiento_anticipo($param);
    $id_usuario = $param["usuario_validacion"];


    $query_insert ="INSERT INTO anticipo(
                                anticipo                          
                              , id_proyecto_persona_forma_pago
                              , fecha_vencimiento
                              , id_usuario)

                        VALUES(
                          '".$saldo_cubierto."', 
                          '".$id_proyecto_persona_forma_pago."', 
                          $fecha_vencimiento,
                          $id_usuario
                        );";                    
    
    $db_response = $this->db->query($query_insert);

    return $this->actualiza_proyecto_ultima_fecha_vencimiento($param);
    
  }
  /**/
  function actualiza_proyecto_ultima_fecha_vencimiento($param){

    $fecha_vencimiento = $param["fecha_vencimiento"];
    
    
    $query_update ="UPDATE 
                    proyecto_persona 
                    SET 
                    siguiente_vencimiento = '$fecha_vencimiento' 
                    WHERE 
                      id_proyecto_persona = '".$param["id_proyecto_persona"]."' 
                    LIMIT 1";


    return $this->db->query($query_update);                


  }
  /**/
  function get_fecha_vencimiento_anticipo($param , $renovacion = 0 , $fecha_nuevo_vencimiento = 0){


    $saldo_cubierto =  $param["saldo_cubierto"]; 
    $precio =  $param["precio_num"];    
    $IVA  =  (int)$precio * .16;
    $total =  (int)$precio +  (int)$IVA;
    $fecha_vencimiento =  "";

    $id_servicio =  $param["id_servicio"];
    $ciclo_facturacion =  $param["ciclo_facturacion"];
    
    $sql_fecha =  " date(CURRENT_DATE()) ";  
    
    if($renovacion == 1){
            $sql_fecha =  $fecha_nuevo_vencimiento;  
    }

    switch ($ciclo_facturacion) {
      case 1:
          
          if($saldo_cubierto >=  $total){
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 1 YEAR) ";
          }else{
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 7 DAY) ";
          }
        break;
      


      case 6:
          
          if($saldo_cubierto >=  $total){
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 1 YEAR) ";
          }else{
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 7 DAY) ";
          }
        break;
      
      case 7:
          
          if($saldo_cubierto >=  $total){
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 1 YEAR) ";
          }else{
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 7 DAY) ";
          }
        break;
          
      case 8:
          
          if($saldo_cubierto >=  $total){
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 1 YEAR) ";
          }else{
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 7 DAY) ";
          }
        break;
      
        
      case 2:

          if($saldo_cubierto >=  $total){
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 1 MONTH) ";
          }else{
              $fecha_vencimiento =  " DATE_ADD( $sql_fecha , INTERVAL 3 DAY) ";
          }

        break;
      
      default:
        
        break;
    }
    return $fecha_vencimiento;
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
  function get_precios_servicio($param){

    $id_servicio =  $param["servicio"];
    
    $query_get = "SELECT 
                  p.* , 
                  DATE_ADD(CURRENT_DATE() , INTERVAL 1 WEEK)fecha_actual_mas_1_semana , 
                  DATE_ADD(CURRENT_DATE() , INTERVAL 1 MONTH)fecha_actual_mas_1_mes , 
                  DATE_ADD(CURRENT_DATE() , INTERVAL 1 YEAR)fecha_actual_mas_1_year
                  FROM 
                  precio p
                  WHERE 
                  id_servicio =$id_servicio";

    $result = $this->db->query($query_get);
    return $result->result_array();

  }
  /**/
  function get_precios_servicio_servicio_registrado($param,  $fecha_vencimiento){

    $id_servicio =  $param["servicio"];
    
    $query_get = "SELECT 
                  p.* , 
                  DATE_ADD('".$fecha_vencimiento."' , INTERVAL 1 WEEK)fecha_actual_mas_1_semana , 
                  DATE_ADD('".$fecha_vencimiento."' , INTERVAL 1 MONTH)fecha_actual_mas_1_mes , 
                  DATE_ADD('".$fecha_vencimiento."' , INTERVAL 1 YEAR)fecha_actual_mas_1_year
                  FROM 
                  precio p
                  WHERE 
                  id_servicio =$id_servicio";

    $result = $this->db->query($query_get);
    return $result->result_array();

  }
  /**/
  function get_info_ticket($param){

    $id_ticket =  $param["id_ticket"];    
    $query_get = "SELECT 
                    t.* ,
                    d.nombre nombre_departamento
                  FROM 
                    ticket t
                  INNER JOIN 
                    departamento d
                  ON t.id_departamento =  d.id_departamento
                    WHERE  
                  t.id_ticket = '".$id_ticket."' 
                  LIMIT 1";

    $result =  $this->db->query($query_get);
    return  $result->result_array();      
  }
  /**/
  function get_departamentos($param){
    
    $extra_sql ="";
    
    $query_get ="SELECT 
                  * 
                FROM 
                departamento
                ";
    $result = $this->db->query($query_get);
    return $result->result_array();

  }
  /**/
  function get_tickets($param){


    //id_proyecto = '". $param["id_proyecto"]."' 
     $status =  $param["status"];

    $_num =  get_random();
    $this->create_tmp_tareas_tickets(0 , $_num , $param); 

    $query_get =  "SELECT t.* , 
                    d.nombre nombre_departamento  ,                    
                    t.fecha_registro, 
                    datediff(current_timestamp(),  t.fecha_registro )fecha_ultima_solicitud,
                    tp.num_tareas_pendientes
                    FROM ticket t 
                    INNER JOIN departamento d 
                    ON t.id_departamento = d.id_departamento                    
                    LEFT OUTER JOIN
                    tmp_tareas_ticket_$_num tp
                    ON 
                    t.id_ticket =  tp.id_ticket
                    WHERE                      
                    t.status =  '". $status ."'                    
                    ORDER BY                                                         
                    t.fecha_registro 
                    ASC";
    $result = $this->db->query($query_get);
    $data =  $result->result_array();
    $this->create_tmp_tareas_tickets(1 , $_num , $param); 
    return $data;
     
  }

    function get_tickets_persona($param){
    
    $status =  $param["status"];
    $id_usuario = $param["id_usuario"];
    $_num =  get_random();
    $this->create_tmp_tareas_tickets(0 , $_num , $param); 

    $query_get =  "SELECT t.* , 
                    d.nombre nombre_departamento  ,
                    p.proyecto, 
                    t.fecha_ultima_solicitud fecha_ultima_solicitud_text, 
                    datediff(current_timestamp(),  t.fecha_ultima_solicitud )fecha_ultima_solicitud,
                    tp.num_tareas_pendientes
                    FROM ticket t 
                    INNER JOIN departamento d 
                    ON t.id_departamento = d.id_departamento
                      INNER JOIN 
                    proyecto p 
                    ON                     
                    p.id_proyecto =  t.id_proyecto                     
                      INNER JOIN proyecto_persona pper                     
                    ON                     
                    p.id_proyecto = pper.id_proyecto
                    LEFT OUTER JOIN
                    tmp_tareas_ticket_$_num tp
                    ON 
                    t.id_ticket =  tp.id_ticket
                    WHERE                    
                    t.status =  '". $status ."'     
                    AND pper.id_usuario ='".$id_usuario."'               
                    ORDER BY                                                         
                    t.fecha_ultima_solicitud,
                    p.proyecto
                    ASC
                    LIMIT 100";
    $result = $this->db->query($query_get);
    $data =  $result->result_array();
    $this->create_tmp_tareas_tickets(1 , $_num , $param); 
    return $data;
  }

  /**/
  function get_tickets_desarrollo($param){
  
    $status =  $param["status"];
    $keyword =$param["keyword"];
    $_num =  get_random();
    $this->create_tmp_tareas_tickets(0 , $_num , $param); 

    $query_get =  "SELECT                       
                      t.id_ticket,
                      t.asunto,
                      t.mensaje,
                      t.status,
                      t.id_usuario,
                      t.fecha_registro,           
                      d.nombre nombre_departamento ,                      
                      tp.num_tareas_pendientes
                      FROM 
                        ticket t 
                      INNER JOIN departamento d 
                        ON t.id_departamento = d.id_departamento                      
                      LEFT OUTER JOIN
                        tmp_tareas_ticket_$_num tp
                      ON 
                        t.id_ticket =  tp.id_ticket
                    WHERE                    
                      t.status =  '". $status ."'
                      AND 
                      d.id_departamento = '".$param["id_departamento"]."'
                      AND 
                      t.asunto like '%".$keyword."%'                        
                      
                      ORDER BY                                                         
                      t.fecha_registro";
    $result = $this->db->query($query_get);
    $data =  $result->result_array();
    $this->create_tmp_tareas_tickets(1 , $_num , $param); 
    return $data;
  }
  /**/
  function create_tmp_tareas_tickets($flag , $_num , $param ){

    $query_drop ="DROP TABLE IF exists tmp_tareas_ticket_$_num";
    $result = $this->db->query($query_drop);

    if ($flag == 0 ){

      $query_create ="CREATE TABLE tmp_tareas_ticket_$_num AS 
                      SELECT 
                      id_ticket, 
                      count(0)num_tareas_pendientes 
                      FROM  
                      tarea 
                      WHERE 
                      status =0 
                      GROUP BY
                      id_ticket"; 

        $result =  $this->db->query($query_create);    
    }
    
  }
  /**/
  function insert_ticket($param){

      /***/      
      $prioridad =  $param["prioridad"];
      $id_proyecto = $param["id_proyecto"];      
      $departamento =  $param["departamento"];     
      $asunto = $param["asunto"];      
      $id_usuario = $param["id_usuario"];      

      $query_insert = "INSERT INTO ticket(
                                    asunto,
                                    prioridad ,        
                                    id_proyecto  ,
                                    id_usuario , 
                                    id_departamento 
                      )VALUES(
                        '". $asunto ."' ,
                        '". $prioridad ."', 
                        '". $id_proyecto  ."', 
                        '". $id_usuario  ."' ,
                        '". $departamento ."'
                      )";    

      $this->db->query($query_insert);
      return $this->db->insert_id();
      
  }
  /*Termina modelo */
  function update_status($param){
      
      $query_update ="UPDATE ticket 
                      SET 
                      status = '".$param["status"]."'
                      WHERE id_ticket = '".$param["id_ticket"]."'
                      LIMIT 1";
                      
      return $this->db->query($query_update);                      
  }
  /**/
  
}


