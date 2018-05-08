<?php defined('BASEPATH') OR exit('No direct script access allowed');
class proyectomodel extends CI_Model{
  function __construct(){
      parent::__construct();        
      $this->load->database();
  } 
  /**/
  function get_videos($param){

 
      $query_get =  "SELECT 
                    id_servicio ,
                    nombre_servicio  ,  
                    url_vide_youtube , 
                    url_video_facebook
                    FROM 
                    servicio 
                    WHERE url_vide_youtube
                    IS NOT NULL
                    ORDER BY id_servicio 
                    DESC
                    LIMIT 5 "; 
    
    $result =  $this->db->query($query_get);
    return $result->result_array();

  }
  /**/
  function get_pais($id_pais){

    $query_get = "SELECT  
                  *
                  FROM 
                    countries
                  WHERE 
                    idCountry = $id_pais";

                  $result =  $this->db->query($query_get);
                  return $result->result_array();

  }
  /**/
  function get_estado($param){

    $id_estado =  $param["id_estado"];  
    $query_get = "select * from  estado_republica e  where e.id_estado_republica =".$id_estado;
    
    $result =  $this->db->query($query_get);
    $delegaciones =  $result->result_array();
    return $delegaciones;

  }
  /**/
  function actualiza_direcciones_usuario($id_usuario , $id_direccion ){

    $query_delete =  "DELETE FROM  
                      usuario_direccion                       
                      WHERE 
                      id_usuario = $id_usuario 
                      LIMIT 10";
    $this->db->query($query_delete);    
    /*ahora insertamos nueva*/
    $query_insert = "INSERT INTO usuario_direccion(
                      id_usuario  ,
                      id_direccion)
                      VALUES( $id_usuario ,  $id_direccion)";
    
    return $this->db->query($query_insert);

  }
  /**/
  function elimina_direccion_previa_envio($param){
    
    $id_recibo =  $param["id_recibo"];  
    $query_delete = "DELETE 
                      IGNORE 
                      FROM proyecto_persona_forma_pago_direccion 
                      WHERE 
                      id_proyecto_persona_forma_pago = $id_recibo";
    $this->db->query($query_delete);

  }
  /**/
  function crea_direccion($param){

    $calle = $param["calle"];
    $referencia = $param["referencia"];
    $numero_exterior = $param["numero_exterior"];
    $numero_interior = $param["numero_interior"];
    $id_codigo_postal =  $param["id_codigo_postal"];

    $receptor=
      (array_key_exists("nombre_receptor", $param))?$param["nombre_receptor"]:"";
    $tel_receptor=
      (array_key_exists("telefono_receptor", $param))?$param["telefono_receptor"]:0;


    $query_insert = "INSERT INTO direccion(                        
                          calle      ,     
                          entre_calles,    
                          numero_exterior ,
                          numero_interior ,                           
                          id_codigo_postal,
                          nombre_receptor, 
                          telefono_receptor )
                        VALUES(
                          '".$calle."',
                          '".$referencia."', 
                          '".$numero_exterior."', 
                          '".$numero_interior."',
                          '".$id_codigo_postal."',
                          '".$receptor."',
                          '".$tel_receptor."'
                          )";
            
      $this->db->query($query_insert);      
      return $this->db->insert_id();
  }
  /**/
  function get_id_codigo_postal_por_patron($param){
    
    $cp =  $param["cp"];
    $asentamiento =  $param["asentamiento"];
    $municipio = $param["municipio"];
    $estado =  $param["estado"];
    $pais = $param["pais"];


    $query_get ="SELECT id_codigo_postal 
                FROM codigo_postal
                WHERE 
                cp = $cp
                AND 
                  asentamiento = '".$asentamiento."' 
                AND 
                  municipio = '".$municipio."'
                AND 
                  id_estado_republica = '".$estado."'
                AND 
                  id_pais = '".$pais."' LIMIT 1";

    $result =  $this->db->query($query_get);
    return $result->result_array()[0]["id_codigo_postal"];

  }
  /**/
  function agrega_direccion_a_compra($param){
            
      $id_recibo =  $param["id_recibo"];
      $id_direccion =  $param["id_direccion"];

      $query_insert ="INSERT INTO 
                        proyecto_persona_forma_pago_direccion( 
                        id_proyecto_persona_forma_pago,
                        id_direccion
                      )
                      VALUES(
                        $id_recibo  , 
                        $id_direccion) ";
    $this->db->query($query_insert);
  }
  /**/
  function registra_direccion_envio($param){

    $this->elimina_direccion_previa_envio($param);
    $id_codigo_postal =  $this->get_id_codigo_postal_por_patron($param);
    $param["id_codigo_postal"] =  $id_codigo_postal;
    $id_direccion =  $this->crea_direccion($param);
    $param["id_direccion"] =  $id_direccion;      
    $this->agrega_direccion_a_compra($param);
    return $id_direccion;   

  }
  /**/
  function registra_direccion_usuario($param){
    
    $id_codigo_postal =  $this->get_id_codigo_postal_por_patron($param);
    $param["id_codigo_postal"] =  $id_codigo_postal;  
    return  $this->crea_direccion($param);
  }
  /**/
  function get_delegaciones($param){

    $id_codigo_postal =  $param["id_codigo_postal"];  
    $query_get = "SELECT 
                  m.* 
                  FROM  
                  codigo_postal c  INNER JOIN municipio m ON c.id_municipio =  m.id_municipio 
                  WHERE c.id_codigo_postal =  $id_codigo_postal";

    $result =  $this->db->query($query_get);
    $delegaciones =  $result->result_array();
    return $delegaciones;
  }
  /**/
  function get_colonia_delegacion($param){

    $cp =  $param["cp"];
    $query_get = "SELECT * FROM codigo_postal where cp=$cp";    
    $result =  $this->db->query($query_get);
    $colonia =  $result->result_array();
    
    return $colonia;

  }  
  /**/
  function verifica_direccion_envio_proyecto_persona_forma_pago($param){
      
      $id_recibo = $param["id_recibo"];
      $query_get = "SELECT 
                    * 
                    FROM 
                    proyecto_persona_forma_pago_direccion 
                    WHERE id_proyecto_persona_forma_pago =".$id_recibo;      

      $result = $this->db->query($query_get);
      $info =  $result->result_array();    
      if(count($info) > 0){        
        $param["id_direccion"] =  $info[0]["id_direccion"];
        return $this->get_data_direccion($param);
      }else{
        return $info;
      }       
  }
  /**/
  function get_data_direccion($param){
      
      $id_direccion =  $param["id_direccion"];

      $query_get ="SELECT * FROM direccion d INNER JOIN 
                  codigo_postal cp ON d.id_codigo_postal =  cp.id_codigo_postal  
                  WHERE d.id_direccion =".$id_direccion;
      $result =  $this->db->query($query_get);
      return $result->result_array();
  }
  /**/
  function get_domicilio_cliente($id_usuario){



      $param["id_usuario"]= $id_usuario;
      $query_get = "SELECT * FROM usuario_direccion 
                    WHERE 
                    id_usuario =".$id_usuario." AND status =1 LIMIT 1";      

      $result = $this->db->query($query_get);
      $info =  $result->result_array();    

      if(count($info) > 0){
        
        $param["id_direccion"] =  $info[0]["id_direccion"];

        return $this->get_data_direccion($param);

      }else{
                
        return $info;
      } 

      
  }
  /**/
  function get_ultimo_pago_servicio($param){
    
      $id_proyecto_persona =  $param["id_proyecto_persona"];
      $query_get ="select  
                      * 
                   from 
                   proyecto_persona_forma_pago 
                   where 
                   id_proyecto_persona = '".$id_proyecto_persona."'
                    order by 
                   fecha_registro 
                   desc limit 1";

      $result = $this->db->query($query_get);
      return $result->result_array();    
  }
  /**/
  function get_proyecto_persona_info_renovacion($param){

    $id_proyecto_persona =  $param["id_proyecto_persona"];
    $query_get ="SELECT * FROM 
                    proyecto_persona 
                 WHERE 
                  id_proyecto_persona = $id_proyecto_persona
                 LIMIT 1 ";

    $result = $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_proyecto_by_id($id_proyecto){

    $query_get =  "SELECT * FROM proyecto WHERE id_proyecto = '".$id_proyecto."' LIMIT 1 ";
    $result = $this->db->query($query_get);
    return $result->result_array(); 
    
  }
  /**/
  function update_info_proyecto($param){

    
    $proyecto      =  $param["proyecto"];
    $id_servicio      =  $param["id_servicio"];
    $status      =  $param["status"];
    $url      =  $param["url"];
    $id_proyecto      =  $param["id_proyecto"];
    $url_img      =      $param["url_img"];
    

    $query_update ="UPDATE proyecto 
                      SET 
                        proyecto = '".$proyecto ."' ,                                               
                        url = '".$url ."'            ,                                    
                        url_img = '".$url_img ."'     ,  
                        status = '". $status ."' , 
                        id_servicio  = '".$id_servicio."'  
                      WHERE id_proyecto = '".$id_proyecto ."'  
                      LIMIT 1 ";
    
    return $this->db->query($query_update);
  }
  /**/
  function get_servicios(){

    $query_get = "SELECT * FROM servicio";
    $result = $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_info_proyecto($param){

    $query_get ="SELECT 
                  p.* , 
                  s.nombre_servicio
                FROM proyecto p                   
                  INNER JOIN 
                  servicio s
                  ON p.id_servicio =  s.id_servicio
                WHERE 
                id_proyecto = '".$param["id_proyecto"]."' 
                LIMIT 1";
    $result =  $this->db->query($query_get);
    return $result->result_array();
  }
  /**/
  function get_proyectos_pendientes_publicar($param){

      $query_get = "SELECT 
                    p.* ,
                    s.nombre_servicio
                    FROM 
                      proyecto p                 
                    INNER JOIN
                      servicio s 
                      ON 
                      p.id_servicio = s.id_servicio  
                    WHERE           
                      p.id_servicio NOT IN(3, 4, 8, 9)
                    AND 
                      p.status =  0";

      $result =  $this->db->query($query_get);
      $response  =  $result->result_array();
      return $response;
  }
  /**/
  function get_num_proyectos_pendientes($param){

    $query_get = "SELECT 
                    sum(case when p.status  = 1 then 1 else 0 end )publicos,
                    sum(case when p.status  = 0 then 1 else 0 end )privados , 
                    sum(case when p.status  = 2 then 1 else 0 end )muestras  
                    
                  FROM 
                  proyecto p
                  INNER JOIN
                  servicio s 
                  ON 
                  p.id_servicio = s.id_servicio                  
                  WHERE           
                  p.id_servicio NOT IN(3, 4, 8, 9)";


      $result =  $this->db->query($query_get);
      $db_response  =  $result->result_array();
      $data["publicos"] =  $db_response[0]["publicos"];
      $data["privados"] =  $db_response[0]["privados"];
      $data["muestras"] =  $db_response[0]["muestras"];
      return $data;

  }
  /**/
  function registrar_abono_pago_vencido($param){
    
    $id_proyecto_persona_forma_pago =  $param["id_proyecto_persona_forma_pago"];
    $saldo_cubierto =  $param["saldo_cubierto"];
    $monto_liquidado =   $param["monto_liquidado"];
    $nuevo_saldo_abonado =  $saldo_cubierto +  $monto_liquidado;    
    $id_usuario =  $param["id_usuario"];


    $query_insert ="UPDATE proyecto_persona_forma_pago 
                    SET 
                      saldo_cubierto =  $nuevo_saldo_abonado
                    WHERE 
                      id_proyecto_persona_forma_pago = '$id_proyecto_persona_forma_pago' 
                    LIMIT 1 ";

    $this->db->query($query_insert);
    

    /**/
    $query_insert ="INSERT INTO 
                    anticipo(
                        anticipo                          
                        ,id_proyecto_persona_forma_pago
                        ,id_usuario 
                      )
                    VALUES(
                      '".$monto_liquidado."'
                      ,'".$id_proyecto_persona_forma_pago."'
                      ,'".$id_usuario."'
                    );";
                        
    $this->db->query($query_insert);    
    return $this->modifica_estatus_venta($param);

    
    
  }  
  /**/
  function modifica_estatus_venta($param){

    $id_proyecto_persona_forma_pago =  $param["id_proyecto_persona_forma_pago"];    
    $query_insert ="SELECT  
                      saldo_cubierto , monto_a_pagar
                    FROM 
                      proyecto_persona_forma_pago 
                    WHERE 
                      id_proyecto_persona_forma_pago = '$id_proyecto_persona_forma_pago' 
                    LIMIT 1 ";

    $result =  $this->db->query($query_insert);
    $data_saldos = $result->result_array()[0];
  
    $saldo_cubierto = $data_saldos["saldo_cubierto"];
    $monto_a_pagar =  $data_saldos["monto_a_pagar"];    
    if(floatval($saldo_cubierto) >= floatval($monto_a_pagar)) {
      $query_update ="UPDATE proyecto_persona_forma_pago 
                    SET 
                      status =  1
                    WHERE id_proyecto_persona_forma_pago = '$id_proyecto_persona_forma_pago' 
                    LIMIT 1 ";
                    $result =  $this->db->query($query_update);

    }
    return 1;

    
  }  
  /**/
  function get_proyecto_persona_forma_pago($param){

    $id_proyecto_persona_forma_pago = $param["id_proyecto_persona_forma_pago"];    

    $query_get =  "SELECT * 
                    FROM 
                      proyecto_persona_forma_pago 
                    WHERE 
                      id_proyecto_persona_forma_pago = '$id_proyecto_persona_forma_pago' 
                    LIMIT 1 ";

    $result =  $this->db->query($query_get);
    return $result->result_array();


  }
  /**/
  function get_historia_anticipos($param){

    /**/
    $id_proyecto_persona_forma_pago = $param["id_proyecto_persona_forma_pago"];    
    $query_get ="select 
                    a.* ,
                  concat(u.nombre  , ' ' , u.apellido_paterno)usuario_validacion,
                    u.email
                  from 
                    anticipo a
                  left outer join
                    usuario u 
                  on 
                    a.id_usuario =  u.idusuario
                  where 
                    a.id_proyecto_persona_forma_pago  = '".$id_proyecto_persona_forma_pago."' 
                  order by 
                  a.fecha_registro desc";
    
    $result =  $this->db->query($query_get);
    return $result->result_array();

  }
  /*
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
  */
  /**/

  /**/
  /*
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
  */
  /**/
}


