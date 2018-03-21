<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class validacionmodel extends CI_Model{
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function envio_info_inicial_paginas_web($param){


      $dominio_deseado = $param["dominio_deseado"];
      $plantilla_sugerida = $param["plantilla_sugerida"];
      $comentario_previo_a_venta = $param["comentario_previo_a_venta"];
      $id_persona = $param["id_persona"];
            
        $query_update = "UPDATE 
                            persona 
                          SET
                            dominio_deseado = '". $dominio_deseado ."' ,
                            plantilla_sugerida = '". $plantilla_sugerida ."' ,
                            comentario_previo_a_venta ='". $comentario_previo_a_venta ."'
                          WHERE 
                            id_persona = '". $id_persona ."' 
                          LIMIT 1";

        return  $this->db->query($query_update);
    }
    /**/
    function get_servicio_tipo_negocio_por_persona($id_persona){

      $query_get = "SELECT id_servicio FROM persona WHERE  
                    id_persona = '". $id_persona ."' LIMIT 1 ";
      
      $result =  $this->db->query($query_get);
      $data_complete["id_servicio"]=  $result->result_array()[0]["id_servicio"];


      
      $query_get = "SELECT idtipo_negocio FROM tipo_negocio_persona 
                      WHERE  
                      id_persona = '". $id_persona ."' 
                    LIMIT 1 ";
      
      $result =  $this->db->query($query_get);
      $data_complete["idtipo_negocio"]=  $result->result_array()[0]["idtipo_negocio"];

      return $data_complete;

    }
    /**/
    function create_tmp_proyecto($param){

      $dominio_deseado = $param["dominio_deseado"];      
      $id_persona = $param["id_persona"];

      $data_complete =  $this->get_servicio_tipo_negocio_por_persona($id_persona);
      $id_servicio =  $data_complete["id_servicio"]; 
      $idtipo_negocio = $data_complete["idtipo_negocio"];

      $query_insert ="INSERT INTO proyecto(
                              proyecto ,  
                              idtipo_proyecto,  
                              url ,  
                              status ,  
                              idtipo_negocio,  
                              id_servicio
                            )
                      
                      VALUES(
                              '".$dominio_deseado."' , 
                                2,
                              '".$dominio_deseado."' ,                            
                                3,
                              '".$idtipo_negocio."',
                              '".$id_servicio."'
                            )";
      return $this->db->query($query_insert);      
    }
    /**/
    function create_tmp_personas_q($_num , $flag  ,$param){
      /**/
      $query_drop ="DROP TABLE IF EXISTS tmp_personas_$_num";
      $status =  $this->db->query($query_drop);      
      $tipo = $param["tipo"];
      $id_usuario =  $param["id_usuario"];
      
      if ($flag == 0){

            $query_create ="CREATE TABLE tmp_personas_$_num 
                        AS 
                        SELECT        
                          p.fecha_registro ,                
                          p.id_persona ,
                          p.nombre     ,
                          p.a_paterno  ,
                          p.a_materno  ,
                          p.tel        ,                                                  
                          p.tipo  ,
                          p.id_usuario ,                                                     
                          p.fecha_envio_validacion , 
                          s.nombre_servicio                           
                        FROM                          
                          persona p                                                                         
                        INNER JOIN servicio s 
                          ON 
                          p.id_servicio 
                          = 
                          s.id_servicio
                        WHERE                                                
                          p.tipo =  '".$tipo."' 
                          AND 
                          p.id_usuario =  '".$id_usuario."' ";

                          
            $status =  $this->db->query($query_create);
      }
      return $status;
    }
    /**/
    function get_clientesq($param){
        
        $_num =  get_random();        
          $this->create_tmp_personas_q($_num , 0  ,$param);          
            $query_get ="SELECT 
                          p.* ,
                          t.nombre tipo_negocio ,
                          u.nombre nombre_transf ,
                          u.apellido_paterno apaterno_transf,
                          u.apellido_materno  amaterno_transf
                        FROM 
                          tmp_personas_$_num p 
                        INNER JOIN tipo_negocio_persona tp 
                          ON p.id_persona =  tp.id_persona
                        INNER JOIN tipo_negocio t 
                          ON tp.idtipo_negocio =  t.idtipo_negocio                        
                        INNER JOIN usuario  u
                          ON 
                          p.id_usuario =  u.idusuario
                        ORDER BY 
                          fecha_registro 
                        DESC";

            $result =  $this->db->query($query_get);
            $data["info"] = $result->result_array();

          $this->create_tmp_personas_q($_num , 1  ,$param);        
        return $data;
    }
    /**/
    function crea_orden_de_compra($param){
      
      $nombre_proyecto =  $param["descripcion_servicio"];      
      $id_servicio =  $param["plan"];          
      /**/
      $query_insert ="INSERT INTO proyecto(
                                        proyecto, 
                                        idtipo_proyecto ,                                         
                                        status, 
                                        id_servicio 
                                  )VALUES(                    
                                    '".$nombre_proyecto."' ,
                                    1 ,                                     
                                    0 , 
                                    '".$id_servicio ."'
                                )";

      
      $this->db->query($query_insert);
      $id_proyecto =  $this->db->insert_id();
      return  $this->registro_proyecto_persona($id_proyecto , $param);


    }
    /**/
    function get_precio_servicio($param){

        /**/
               $query_get = "SELECT  
                            p.precio , 
                            c.* ,  
                            s.nombre_servicio , 
                            s.descripcion
                            FROM  
                            precio p 
                            INNER JOIN ciclo_facturacion c 
                            ON
                            p.id_ciclo_facturacion =  c.id_ciclo_facturacion
                            INNER JOIN 
                            servicio s 
                            ON 
                            p.id_servicio = s.id_servicio                        
                            WHERE                       
                             p.id_servicio ='".$param["plan"]."'
                            LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }    
    /**/
    function get_fechas_por_ciclo_facturacion($id_ciclo_facturacion , $num_ciclos){

      /*
       1 | Anual          
       2 | Mensual        
       3 | Semanal        
       4 | Quincenal      
        5 | No aplica      
       6 | Anual a 3 meses
       7 | Anual a 4 meses
       8 | Anual a 6 meses

      */  
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
        
        case 3:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , 
                                    INTERVAL  7  DAY) ";  
        
          $nombre_periodo =" Semana contratada "; 


          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;

          break;
        
         case 4:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , 
                                    INTERVAL  15  DAY) ";  
        
          $nombre_periodo =" Quincenas contratadas contratados "; 

          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;

          break;



          case 5:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , INTERVAL  1 YEAR) ";
          $nombre_periodo =" Periodos contratados ";

          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;

          break;




          case 6:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , INTERVAL  ".$num_ciclos." YEAR) ";
          $nombre_periodo =" años contratados ";

          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;
          

          break;



          case 7:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , INTERVAL  ".$num_ciclos." YEAR) ";
          $nombre_periodo =" años contratados ";

          $data_complete["sql_fecha_vencimiento"] =  $sql_fecha_vencimiento;
          $data_complete["nombre_periodo"] =  $nombre_periodo;
          
          break;

          /**/

          case 8:
          
          $sql_fecha_vencimiento =" DATE_ADD(CURRENT_DATE() , INTERVAL  ".$num_ciclos." YEAR) ";
          $nombre_periodo =" años contratados ";

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
    function registro_proyecto_persona($id_proyecto , $param ){
      
      $id_usuario_referencia =    get_info_usuario($param["usuario_referencia"]);      
      $id_persona = $param["id_persona"];
      $info_precio =  $this->get_precio_servicio($param)[0];
      
      $precio  = $info_precio["precio"];            
      $id_ciclo_facturacion =  $info_precio["id_ciclo_facturacion"];
      $nombre_servicio =  $info_precio["nombre_servicio"];
      $ciclo =  $info_precio["ciclo"];
      $num_ciclos =  $param["num_ciclos"];

      $precio = $precio * (int)$num_ciclos;             
      $IVA  =  (int)$precio * .16;
      $total = (int)$precio + (int)$IVA;

      /**/
      $param["total_a_pagar"] =  $total;
      
      $sql_fecha_vencimiento = "";
      $nombre_periodo ="";

      $data_tiempo= 
      $this->get_fechas_por_ciclo_facturacion($id_ciclo_facturacion , $num_ciclos);
      $sql_fecha_vencimiento = $data_tiempo["sql_fecha_vencimiento"];
      $nombre_periodo =$data_tiempo["nombre_periodo"];
      
        
        $param["sql_fecha_vencimiento"] = $sql_fecha_vencimiento; 

        $detalles =  $nombre_servicio.
                     " con ciclo de Facturación " . 
                     $ciclo 
                     ." " 
                     .$nombre_periodo ." " 
                     .$num_ciclos;

        /**/

        /**/

        $query_insert = "INSERT INTO proyecto_persona(
                               id_proyecto           
                              ,id_persona                  
                              ,precio                
                              ,ciclo_facturacion     
                              ,siguiente_vencimiento                 
                              ,detalles              
                              ,IVA                   
                              ,total      
                              ,num_ciclos_contratados
                              ,id_usuario_referencia                                                  
                          )VALUES(
                            
                            '". $id_proyecto ."' ,
                            '". $id_persona ."' ,
                            '". $precio."' ,
                            '". $id_ciclo_facturacion."' , 
                             $sql_fecha_vencimiento ,
                            '". $detalles  ."' ,
                            '". $IVA ."' ,
                            '". $total ."' ,
                            '". $num_ciclos."' ,
                            '".$id_usuario_referencia."'                          
                            )";

      
      
      $this->db->query($query_insert);

      $id_proyecto_persona =  $this->db->insert_id();  
      return $this->registra_forma_pago_proyecto($param, $id_proyecto_persona);
      
      
      
    
  }
  /**/
  function registra_forma_pago_proyecto($param, $id_proyecto_persona){

    $id_forma_pago=  4;
    $saldo_cubierto =  0;
    $saldo_cubierto_texto =  "";
    $RFC =  "";
    $domicilio_fiscal =  "";
    $id_usuario_validacion =  $param["id_usuario"];
    $total =  $param["total_a_pagar"];
    $fecha_vencimiento = $param["sql_fecha_vencimiento"];

    /**/    
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
                              ,status
                              
                          
                          )VALUES(                            
                              '". $id_proyecto_persona ."' ,  
                              '". $id_forma_pago ."' , 
                              '". $saldo_cubierto ."' , 
                              '". $saldo_cubierto_texto ."' ,  
                              '". $RFC ."' ,  
                              '". $domicilio_fiscal ."' , 
                              ". $fecha_vencimiento." , 
                              '". $id_usuario_validacion ."'  , 
                              '".$total."',
                              DATE_ADD(CURRENT_DATE , INTERVAL 3 DAY), 
                              6
                            )";

      
      $this->db->query($query_insert);
      $id_proyecto_persona_forma_pago =  $this->db->insert_id();
      return $id_proyecto_persona_forma_pago;

  }
  /**/

}