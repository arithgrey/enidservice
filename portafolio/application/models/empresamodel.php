<?php defined('BASEPATH') OR exit('No direct script access allowed');
class empresamodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function get_status_enid_service($param){ 

    $key =  $param["key"];
    $query_get ="SELECT * FROM   status_enid_service where $key = 1";
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_info_persona($param){
    $id_usuario =  $param["id_usuario"];    
    $query_get = "SELECT * FROM usuario 
                    WHERE idusuario = '".$id_usuario."' LIMIT 1 ";
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }  
  /***/
  function create_tmp_proyecto_persona($flag , $_num  , $param){

    $query_drop ="DROP TABLE IF exists tmp_proyecto_persona_$_num";
    $result = $this->db->query($query_drop);

    if($flag == 0 ){
      
      $id_usuario =  $param["id_usuario"];            
      $query_create ="CREATE TABLE tmp_proyecto_persona_$_num AS 
                      SELECT
                      p.id_proyecto , 
                      p.proyecto       ,
                      p.descripcion    ,                                                    
                      pp.fecha_registro , 
                      pp.id_proyecto_persona ,                     
                      s.nombre_servicio servicio
                  FROM proyecto p
                  INNER JOIN 
                  proyecto_persona pp 
                  ON p.id_proyecto =  pp.id_proyecto
                  INNER JOIN servicio s
                  ON 
                  p.id_servicio = s.id_servicio
                  WHERE 
                  pp.id_usuario = '".$id_usuario."'"; 
        $this->db->query($query_create);            
    }

  }
  /*Versión
  function qpersona($param){
    
    $_num =  get_random();

    $this->create_tmp_proyecto_persona(0 , $_num  , $param);    
      
      
      $query_get ="SELECT 
                    c.* ,                    
                    z.status estado ,
                    z.monto_a_pagar ,                                     
                    z.id_proyecto_persona_forma_pago,                     
                    z.flag_envio_gratis, 
                    z.costo_envio, 
                    ROUND((z.monto_a_pagar - z.saldo_cubierto ) , 2) monto_por_liquidar,  
                    np.status 
                    estatus_pago_notificago
                  FROM tmp_proyecto_persona_$_num c
                  INNER JOIN 
                    proyecto_persona_forma_pago  z
                  ON 
                    c.id_proyecto_persona =  z.id_proyecto_persona
                    LEFT OUTER JOIN notificacion_pago np 
                    ON z.id_proyecto_persona_forma_pago =  np.num_recibo
                    WHERE 
                    z.monto_a_pagar > z.saldo_cubierto";                 


      $result =  $this->db->query($query_get);      
      $data_complete =   $result->result_array();    
      

    $this->create_tmp_proyecto_persona(1 , $_num  , $param);    
    return $data_complete;  
  }
  */
  /***/
  function q($param){

    /**/    
    $query_get ="SELECT 
                  p.*
                FROM 
                  proyecto p                 
                WHERE           
                  idtipo_negocio =  '".$param["tipo_negocio"]."'
                AND 
                  id_servicio NOT IN(3, 4, 8, 9)
                ORDER BY fecha_registro DESC"; 
    $result =  $this->db->query($query_get);
    return $result->result_array();
    
  }
  /**/
  function get_portafolio($param){

    $query_get ="SELECT 
                  p.* , 
                  t.tipo  FROM proyecto p 
                  INNER JOIN tipo_proyecto t 
                  ON 
                  p.idtipo_proyecto =  t.idtipo_proyecto
                  WHERE status =  '".$param["status"]."'
                ORDER BY fecha_registro DESC"; 
    $result =  $this->db->query($query_get);
    return $result->result_array();  
  }

  /**/
  function inserta_proyecto($param){
  

  
      $proyecto = $param["proyecto"];
      $idtipo_negocio = $param["tipo_negocio"];
      $id_servicio =  $param["id_servicio"];       
      $status =  $param["status"];
      $url = $param["url"];
      $url_img =  $param["url_img"];    
      $idtipo_proyecto =  1;       
      
      
      
      $query_insert = "INSERT INTO proyecto(
                      proyecto ,                        
                      idtipo_proyecto , 
                      url , 
                      url_img , 
                      idtipo_negocio , 
                      id_servicio,
                      status  ) 
                      VALUES( 
                        '". $proyecto ."' ,                                
                        '". $idtipo_proyecto ."' , 
                        '". $url ."' , 
                        '". $url_img ."' ,
                        '". $idtipo_negocio."' ,                        
                        '". $id_servicio."',                        
                        '". $status."'
                      )";

      return $this->db->query($query_insert);
      
  }  
  /*Aquí es en el área de administración*/
  function get_proyectos($param){
    
    $query_get =  "SELECT * FROM proyecto p
                    INNER JOIN 
                      proyecto_persona pp 
                  ON p.id_proyecto =  pp.id_proyecto
                    INNER JOIN
                    persona per 
                  ON  pp.id_persona = per.id_persona";

    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_proyectos_fecha($param){
    
    $query_get = "
                SELECT  
                  
                  p.detalles , 
                  pp.monto_a_pagar,
                  pp.saldo_cubierto,       
                  pp.saldo_cubierto_texto ,
                  pp.id_proyecto_persona_forma_pago
                FROM 
                  proyecto_persona  p                     
                INNER JOIN 
                  proyecto_persona_forma_pago pp 
                ON  
                  p.id_proyecto_persona = pp.id_proyecto_persona
                WHERE 
                  DATE(pp.fecha_registro) =  '".$param["fecha"]."'
                ORDER BY p.fecha_registro DESC";


    $result =  $this->db->query($query_get);
    return $result->result_array();

  }
  /**/
  function update_proyecto($param){

    $proyecto = $param["proyecto"];
    $id_tipo_proyecto =  $param["id_tipo_proyecto"];
    $descripcion =  $param["descripcion"];
    $url =  $param["url"];
    $url_img =  $param["url_img"];
    $id_proyecto =  $param["id_proyecto"];
    $status = $param["status"];
    $tipo_negocio = $param["tipo_negocio"];

    $query_update =  "UPDATE proyecto SET                           
                      proyecto  =  '$proyecto', 
                      descripcion   =  '$descripcion' ,        
                      idtipo_proyecto = '". $id_tipo_proyecto  ."' ,
                      url            =  '".$url."' ,
                      url_img = '".$url_img."'  ,
                      status =  '".$status ."' ,
                      idtipo_negocio = '".$tipo_negocio."'
                      WHERE 
                      id_proyecto =  '".$id_proyecto."' LIMIT 1";
      
    return $this->db->query($query_update);

    
  }


  /**/  
/*Termina modelo */
}


