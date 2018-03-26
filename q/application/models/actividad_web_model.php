<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class actividad_web_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function crea_tabla_temploral($tabla , $sql , $flag){

      $query_drop = "DROP TABLE IF exists $tabla";
      $this->db->query($query_drop);   
      
      if($flag ==  0){
            $query_create ="CREATE TABLE $tabla AS ".$sql;
            $this->db->query($query_create);   
      }    
    }
    /**/    
    function get_fechas_funnel_dia($param){

        $where_fecha = "DATE(fecha_registro) =  DATE(CURRENT_DATE())"; 

        if (isset($param["fecha_inicio"])){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];

            $where_fecha = "DATE(fecha_registro )
                         BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."' ";                         
        }                 
        return $where_fecha;
    }
    /**/
    function visitas_enid_semana($_num){


          $query_get = "SELECT 
                        HOUR(fecha_registro)horario,
                        SUM(CASE WHEN tipo IS NOT NULL THEN 1 ELSE 0 END )total_registrado,
                        SUM(CASE WHEN tipo = 111 then 1 else 0 end )cotizaciones ,          
                        SUM(CASE WHEN tipo = 43 then 1 else 0 end )contacto , 
                        SUM(CASE WHEN tipo = 2201 then 1 else 0 end )faq , 
                        SUM(CASE WHEN tipo = 9990890 then 1 else 0 end )correos_empresas ,
                        SUM(CASE WHEN tipo = 2892 then 1 else 0 end )procesar_compra ,  
                        SUM(CASE WHEN tipo = 566 then 1 else 0 end )sobre_enid,
                        SUM(CASE WHEN tipo = 22 then 1 else 0 end )afiliados,
                        SUM(CASE WHEN tipo = 40 then 1 else 0 end )nosotros,                        
                        SUM(CASE WHEN tipo = 3009 then 1 else 0 end )formas_pago
                        FROM  tmp_landing_$_num
                        GROUP BY 
                        HOUR(fecha_registro)
                        ORDER BY HOUR(fecha_registro) DESC ";                       

          $result = $this->db->query($query_get);
          return  $result->result_array();

    }
      
        
    /**/
    function get_comparativa_landing_page($param){

        $_num =  get_random();
        $this->create_tmp_langings($_num ,  0  , $param );

          $data_complete["semanal"] =  $this->visitas_enid_semana($_num);          
          
        $this->create_tmp_langings($_num ,  1 , $param );          
        return $data_complete;      
    }

    /**/
    function create_tmp_langings($_num ,  $flag , $param ){

      $query_drop = "DROP TABLE IF exists tmp_landing_$_num";  
      $db_response = $this->db->query($query_drop);

      if($flag == 0 ){

        $where_fecha =  $this->get_fechas_funnel($param);
        $query_create = "CREATE TABLE tmp_landing_$_num 
                          AS
                         SELECT
                           * 
                         FROM pagina_web 
                         WHERE $where_fecha";  
        $db_response =  $this->db->query($query_create);
      }
      return $db_response;

    }
    /**/
    function get_fechas_funnel($param){

        $where_fecha = "DATE(fecha_registro )
                         BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 WEEK ) 
                         AND  DATE(CURRENT_DATE())"; 

        if (isset($param["fecha_inicio"])){

            $fecha_inicio =  $param["fecha_inicio"];
            $fecha_termino =  $param["fecha_termino"];

            $where_fecha = "DATE(fecha_registro )
                         BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."' ";                         
        }                 
        return $where_fecha;
    }
    /**/
    

    /**/

    function get_actividad_mail_marketing($param){

      $_num =  get_random();
      $this->creta_tmp_mail_marketing($_num ,  0);
      $query_get = "SELECT 
                    COUNT(0)num_enviados , 
                    DATE(fecha_registro) fecha_registro    
                    FROM tmp_mail_marketig_$_num 
                    GROUP BY DATE(fecha_registro)";


      $result = $this->db->query($query_get);
      $data_complete["envios"] = $result->result_array();
      $data_complete["registros"]=  $this->get_num_prospectos($param);


      $this->creta_tmp_mail_marketing($_num ,  1 );          
      return $data_complete;
    }
    /**/
    function creta_tmp_mail_marketing($_num ,  $flag){

      $query_drop = "DROP TABLE IF exists tmp_mail_marketig_$_num";  
      $db_response = $this->db->query($query_drop);

      if($flag == 0 ){

        $query_create ="CREATE TABLE tmp_mail_marketig_$_num
                          AS
                          SELECT fecha_registro FROM email_prospecto 
                          WHERE DATE(fecha_registro )
                          BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 2 WEEK ) 
                          AND  DATE(CURRENT_DATE())";
        $db_response =  $this->db->query($query_create);
      }
      return $db_response;

    }
    /**/
    function get_num_prospectos($param){
      
      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];
      $where_fecha = " WHERE date(fecha_registro) 
                      BETWEEN  '".$fecha_inicio."' AND '".$fecha_termino."'  ";

      $query_get ="SELECT DATE(fecha_registro)fecha_registro, 
                  COUNT(0)registros FROM prospecto
                  $where_fecha GROUP BY DATE(fecha_registro);";
                  
                  $result = $this->db->query($query_get);
                  return $result->result_array();

    }

    /**/
    function create_tmp_visitas($flag , $_num , $param){

      $query_drop =  "drop table if exists visitas_tmp_global_$_num";
      $this->db->query($query_drop);

      $query_drop =  "drop table if exists visitas_tmp_$_num";
      $this->db->query($query_drop);


      if($flag ==  0){   

        $sql_tiempo =  $param["sql_tiempo"];                      
              
        $query_create = "CREATE TABLE visitas_tmp_$_num  AS 
          SELECT 
            DATE(fecha_registro)fecha , 
            COUNT(0)visitas
          FROM 
          pagina_web 
          WHERE
          ".$sql_tiempo
          ." group by date(fecha_registro)";

        $this->db->query($query_create);
        
      }

    }
    /**/
    function get_where_tiempo($param ,  $tipo){

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      switch ($tipo){
        case 1:          
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

        default:
          
          break;
      }
      
    }      
    /**/
    function crea_actividad_en_ventas($param){

        $where =  $this->get_where_tiempo($param , 1);
        $query_get ="SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total ,                      
                      SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END)compras_efectivas, 
                      SUM(CASE WHEN status = 6 THEN 1 ELSE 0 END)solicitudes,
                      SUM(CASE WHEN status = 7 THEN 1 ELSE 0 END)envios, 
                      SUM(CASE WHEN status = 9 THEN 1 ELSE 0 END)cancelaciones

                      FROM 
                      proyecto_persona_forma_pago 
                      WHERE
                       1=1 
                       AND 
                      ".$where."                      
                      GROUP BY 
                      DATE(fecha_registro)";
        return $query_get;
    }
    /**/
    function crea_actividad_en_contacto($param){

        $where =  $this->get_where_tiempo($param , 1);
        $query_get ="SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total 
                      FROM 
                      contact
                      WHERE
                       1=1 
                       AND 
                      ".$where."                      
                      GROUP BY 
                      DATE(fecha_registro)";
        return $query_get;
    }
    /**/
    private function crea_correos_enviados($param){

      $where =  $this->get_where_tiempo($param , 3);
        $query_get ="SELECT 
                      DATE(fecha_actualizacion) fecha ,
                      COUNT(0)total 
                      FROM 
                      prospecto
                      WHERE
                       n_tocado = 1
                       AND 
                      ".$where."                      
                      GROUP BY 
                      DATE(fecha_actualizacion)";
        return $query_get;
    }

    /**/
    function crea_registros_usuarios($param){

        $where =  $this->get_where_tiempo($param , 1);
        $query_get ="SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total 
                      FROM 
                      usuario_perfil 
                      WHERE
                       1=1 
                      AND 
                      ".$where."
                      AND  
                        idperfil = 20                        
                      GROUP BY 
                      DATE(fecha_registro)";
        return $query_get;
    }
    /**/
    function crea_visitas_por_periodo($param){

        $where =  $this->get_where_tiempo($param , 1);
        $query_get ="SELECT                   
                    COUNT(0)accesos,                     
                    SUM(CASE WHEN tipo = 2892 THEN 1 ELSE 0 END )accesos_a_intento_compra,
                    SUM(CASE WHEN tipo = 43 THEN 1 ELSE 0 END )accesos_contacto,
                    SUM(CASE WHEN tipo = 48 THEN 1 ELSE 0 END )accesos_area_cliente
                    FROM 
                      pagina_web 
                    WHERE 
                    1=1                     
                    AND 
                    ".$where;
        return $query_get;
    }
    
    function crea_tareas_resueltas($param){

      $where =  $this->get_where_tiempo($param , 2);
      $query_create = "SELECT                           
                        COUNT(0)num_tareas_resueltas ,                            
                        DATE(fecha_termino)fecha
                        FROM 
                          tarea 
                        WHERE 
                        ".$where." 
                        GROUP BY 
                        DATE(fecha_termino)";

      return $query_create;
    }
    /**/
    function crea_valoraciones($param){
      /**/
      $where =  $this->get_where_tiempo($param , 1);
      $query_create = "SELECT                          
                          COUNT(0)num_valoraciones,
                          SUM(CASE WHEN recomendaria = 1 THEN 1 ELSE 0 END )si_recomendarian,
                          SUM(CASE WHEN recomendaria = 0 THEN 1 ELSE 0 END )no_recomendarian
                        FROM 
                          valoracion
                        WHERE 
                          ".$where;

      return $query_create;
    }
    /**/
    function crea_reporte_enid_service($param){
        
        /**/
        $_num = get_random();     
        $sql_visitas  =  $this->crea_visitas_por_periodo($param);
        $data_complete["sql_visitas"] = $sql_visitas;
        $this->crea_tabla_temploral("visitas_periodo_$_num" , $sql_visitas , 0);

              $query_get = "SELECT * FROM visitas_periodo_$_num";
              $result =  $this->db->query($query_get);
              $accesos =  $result->result_array();
              $data_complete["resumen"] =  $this->agrega_data($param ,  $accesos , $_num);
            
        $this->crea_tabla_temploral("visitas_periodo_$_num" , $sql_visitas , 1);
        return $data_complete;
    }      
    /**/
    private function agrega_data($param , $data_accesos , $_num){
      
      $data_complete = [];
      if(count($data_accesos) > 0){

        $tabla_usuarios =  "registros_usuarios_$_num";
        $tabla_ventas = "actividad_ventas_$_num";
        $tabla_contacto = "contacto_$_num";
        $tb_tareas =  "tareas_resueltas_$_num";
        $tb_valoraciones  = "valoraciones_$_num";
        $tb_correos = "correos_$_num";
        /*usuarios*/


        $sql_usuarios =  $this->crea_registros_usuarios($param);        
          $this->crea_tabla_temploral($tabla_usuarios , $sql_usuarios , 0);
        

          /**/
          $sql_ventas =  $this->crea_actividad_en_ventas($param);
            $this->crea_tabla_temploral($tabla_ventas , $sql_ventas , 0 );
            
            $sql_contacto =  $this->crea_actividad_en_contacto($param);
              $this->crea_tabla_temploral($tabla_contacto , $sql_contacto , 0);

              $sql_tareas = $this->crea_tareas_resueltas($param);
                $this->crea_tabla_temploral($tb_tareas , $sql_tareas , 0);

                /**/
                $sql_valoraciones =  $this->crea_valoraciones($param);
                  $this->crea_tabla_temploral($tb_valoraciones , $sql_valoraciones , 0);
                  /**/

                  
                  $sql_correos_enviados =  $this->crea_correos_enviados($param);
                    $this->crea_tabla_temploral($tb_correos , $sql_correos_enviados , 0);
            

                $a = 0;
                
                foreach($data_accesos as $row){             
                   $data_complete[$a] =  $row;               
                   $fecha = "";
                    /*Agregamos usuarios*/
                   $data_complete[$a]["usuarios"] 
                    = $this->get_num_registros_templal_table_fecha($fecha ,$tabla_usuarios); 

                    /*Agregamos ventas*/
                    $data_complete[$a]["ventas"] 
                    = 
                    $this->get_registros_venta_fecha($fecha ,$tabla_ventas); 

                    /*Agregamos data de contacto*/
                    $data_complete[$a]["contacto"] 
                    = 
                    $this->get_num_registros_templal_table_fecha($fecha ,$tabla_contacto); 

                    $data_complete[$a]["labores_resueltas"] 
                    = 
                    $this->get_num_registros_templal_table_fecha($fecha, $tb_tareas); 


                    $data_complete[$a]["valoraciones"] 
                    = $this->get_registros_valoraciones($fecha, $tb_valoraciones); 

                    /**/
                    $data_complete[$a]["correos"] 
                    = $this->get_correos_enviados($tb_correos); 

                   $a ++;
                }      
                  $this->crea_tabla_temploral($tb_correos , $sql_correos_enviados , 1);
                $this->crea_tabla_temploral($tb_valoraciones , $sql_valoraciones , 1);
              $this->crea_tabla_temploral($tb_tareas , $sql_tareas , 1);
            $this->crea_tabla_temploral($tabla_contacto , $sql_contacto , 1);
          $this->crea_tabla_temploral($tabla_ventas , $sql_ventas , 1);        
      $this->crea_tabla_temploral($tabla_usuarios , $sql_usuarios , 1);
      }      
      return $data_complete;      
    }
    /**/
    function get_registros_valoraciones($fecha , $tabla){
      $query_get = "SELECT 
                    num_valoraciones
                    ,si_recomendarian
                    ,no_recomendarian
                    FROM $tabla";
      $result =  $this->db->query($query_get);      
      return $result->result_array(); 
    }
    /**/
    function get_correos_enviados($tabla){
      $query_get = "SELECT 
                    SUM(total) correos_enviados
                    FROM $tabla";
      $result =  $this->db->query($query_get);      
      return $result->result_array();  
    }
    /**/
    function get_registros_venta_fecha($fecha , $tabla){      
      $query_get = "SELECT 
                    SUM(total)total
                    ,SUM(compras_efectivas)compras_efectivas
                    ,SUM(solicitudes)solicitudes
                    ,SUM(envios)envios
                    ,SUM(cancelaciones)cancelaciones
                    FROM $tabla ";
      $result =  $this->db->query($query_get);      
      return $result->result_array();            
    }
    /**/
    function get_num_registros_templal_table_fecha($fecha , $tabla){      

      /**/
      $query_get = "SELECT COUNT(0)num FROM $tabla ";
      $result =  $this->db->query($query_get);
      return $result->result_array()[0]["num"];      
    }


    /*
    function create_tmp_ventas_efectivas($flag , $_num , $param){

      
      $query_drop =  "drop table if exists tmp_ventas_efectivas_$_num";
      $this->db->query($query_drop);        
      $sql_tiempo =  $param["sql_tiempo"];  
      
      if ($flag == 0 ) {
          
         
        $query_create = "CREATE TABLE tmp_ventas_efectivas_$_num
                        AS
                        SELECT
                          count(0)num_ventas_efectivas, 
                          DATE(fecha_registro) fecha
                           from  proyecto_persona_forma_pago 
                        where 
                          ".$sql_tiempo." 
                          AND  
                          saldo_cubierto > 0 
                          GROUP BY DATE(fecha_registro)";

        $this->db->query($query_create);
      }       
    }
    */
    /**/
    function drop_tables_repo_general(){
      
        /**/        
        $query_drop =  "drop table if exists proyecto_tmp";
        $this->db->query($query_drop);        
        /**/
        
        $query_drop =  "drop table if exists blog_tmp";
        $this->db->query($query_drop);                     


        $query_drop =  "drop table if exists tareas_resueltas";
        $this->db->query($query_drop);                     
    }


}