<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class enidmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function update_inicidencia($param){

      $id_incidencia = $param["id_incidencia"];
      $status = $param["status_incidencia"];
      $query_update =  "UPDATE incidencia SET status = '".$status."' WHERE id_incidencia = '".$id_incidencia."' LIMIT 1 "; 
      return  $this->db->query($query_update);

    }

    /**/
    function get_perfiles_disponibles($id_perfil){
        
        $where =""; 
        switch ($id_perfil){
          /*Usuario general */          
          case 4:
            $where =" WHERE usuario_prueba =  1"; 
            break;
          
          default:
                      
            break;
        }
        $query_get ="SELECT * FROM perfil " .$where .  " ORDER BY nombreperfil ASC";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function getperfildata($id_usuario){
        $query_get ="SELECT 
                    p.idperfil , 
                    p.nombreperfil , 
                    p.descripcion 
                    FROM perfil AS p , 
                    usuario_perfil AS up 
                    WHERE  
                    up.idperfil = p.idperfil 
                    AND up.idusuario = $id_usuario  
                    AND  up.status =  1 LIMIT 1";
                    
        $result_user = $this->db->query($query_get);       
        return $result_user ->result_array();      
    }
    /**/
    function getperfiluser($id_usuario ){
        $query_get ="SELECT idperfil FROM usuario_perfil  
                    WHERE 
                    idusuario='".$id_usuario."' AND status =  1 ";
        $result_user = $this->db->query($query_get);       
        return $result_user ->result_array();      
    }
    /**/
    function getidempresabyidusuario($id_user){
      $query_get   ="SELECT idempresa FROM usuario WHERE idusuario = $id_user limit 1"; 
      $result = $this->db->query($query_get); 
      $id_empresa = 0;
      foreach ($result ->result_array() as $row) {   
         $id_empresa =  $row["idempresa"];
      }
      return $id_empresa;
    }
    /**/
    function validauserrecord($mail , $secret){
        $query_select ="SELECT * FROM usuario WHERE email='".$mail."' AND password ='".$secret."' limit 1";
        $result_user = $this->db->query($query_select);       
        return $result_user ->result_array();      
    }
    /**/
    function get_empresa_permiso($id_empresa){
      $query_get =  "SELECT idpermiso FROM empresa_permiso WHERE  idempresa =  '".$id_empresa."' LIMIT 15 ";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    function get_empresa_recurso($id_empresa){
      $query_get =  "SELECT idrecurso FROM empresa_recurso WHERE  idempresa =  '".$id_empresa."' LIMIT 15 ";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_reporte_general_mail_marketing($param){

        $query_get = "select 
                  u.nombre nombre_user ,
                  u.email ,  
                  p.fecha_registro , 
                  pu.nombre publicidad , 
                  pu.descripcion , 
                  pu.nombre  tipo_publicidad  
                  from  usuario_mensaje_publicidad p 
                  inner join usuario u on u.idusuario =  p.idusuario 
                  inner join publicidad pu on p.id_publicidad =  pu.id_publicidad 
                  inner join  tipo_publicidad t  on  pu.id_tipo_publicidad=  t.id_tipo_publicidad 
                  WHERE pu.id_tipo_publicidad = '".$param["tipo"]."' ORDER BY  p.fecha_registro desc ";

        $result =  $this->db->query($query_get);            
        return   $result->result_array();            
                  
    }
    /**/
    function get_bugs($param){

      $status =  $param["estado_incidencia"];
      $query_get =  "
      SELECT   
      i.id_incidencia ,            
      i.fecha_registro, 
      i.descripcion_incidencia  ,    
      count(0) incidencias,       
      ti.tipo_incidencia  ,
      c.nombre        ,
      i.pagina_error  ,      
      i.tipo_propuesta        
      FROM incidencia i 
      INNER JOIN tipo_incidencia  ti 
      ON i.idtipo_incidencia = ti.idtipo_incidencia
      INNER JOIN  calificacion c 
      ON  i.idcalificacion =  c.idcalificacion
      WHERE i.status = '".$status."'       
      GROUP BY i.descripcion_incidencia
      ORDER BY i.fecha_registro DESC ";

      $result = $this->db->query($query_get);
      return $result->result_array();


    }
    /**/
    function get_nuevos_miembros(){

      $_num =  get_random();
      $this->create_table_tmp_miembros($_num , 0 );

      $this->create_table_tmp_miembros_complate($_num , 0);

          $query_get = "SELECT * FROM tmp_table_miembros_$_num";        
          $result = $this->db->query($query_get);
          $data_complete["resumen"] =  $result->result_array();

          /**/


          $query_get = "SELECT  
                        u.idusuario           , 
                    u.nombre              , 
                    u.email                     , 
                    u.fecha_registro                  , 
                    u.puesto              , 
                    u.status              , 
                    u.apellido_paterno    , 
                    u.apellido_materno    , 
                    u.email_alterno       , 
                    u.tel_contacto        , 
                    u.tel_contacto_alterno, 
                    u.edad                      , 
                    u.cargo               , 
                    u.url_fb              , 
                    u.url_tw              , 
                    u.url_www             , 
                    u.sexo                   
                        FROM  tmp_table_miembros_c_$_num e 
          INNER JOIN usuario u ON  e.idempresa =  u.idusuario";
          $result = $this->db->query($query_get); 
          $data_complete["completa"] =  $result->result_array();




          /**/
      $this->create_table_tmp_miembros_complate($_num , 1);
      $this->create_table_tmp_miembros($_num , 1 );
      return $data_complete;
    }
    /***/
    function create_table_tmp_miembros($_num , $flag){

      $query_drop = "DROP TABLE IF exists tmp_table_miembros_$_num";
      $db_response = $this->db->query($query_drop);
      
      if($flag == 0 ) {
        
        $query_create = "CREATE TABLE tmp_table_miembros_$_num 
        AS 
        SELECT DATE(fecha_registro) fecha_registro  , count(0)registrados  FROM empresa WHERE  status =  5 AND DATE(fecha_registro) 
        BETWEEN DATE_ADD(CURRENT_DATE()  , INTERVAL - 1 MONTH ) AND DATE(CURRENT_DATE()) GROUP BY DATE(fecha_registro) ";

        $this->db->query($query_create);
      }
      return $db_response;

    }
    function create_table_tmp_miembros_complate($_num , $flag){

      $query_drop = "DROP TABLE IF exists tmp_table_miembros_c_$_num";
      $db_response = $this->db->query($query_drop);
      
      if($flag == 0 ) {
        
        $query_create = "CREATE TABLE tmp_table_miembros_c_$_num 
        AS 
        SELECT idempresa   FROM empresa WHERE  status =  5 AND DATE(fecha_registro) 
        BETWEEN DATE_ADD(CURRENT_DATE()  , INTERVAL - 1 MONTH ) AND DATE(CURRENT_DATE()) GROUP BY idempresa ";

        $this->db->query($query_create);
      }
      return $db_response;

    }

    /**/
    function get_numusuarios_enid(){
      /**/
      $query_get =  "SELECT  COUNT(0)organizaciones FROM usuario";
      $result =  $this->db->query($query_get);
      return $result->result_array();
      
    }
    /**/
    /**/
    function visitas_enid_semana($_num){
      $query_get  = " SELECT 
                          f_registro , 
                          count(0) total_registrado , 
                          SUM(CASE WHEN tipo = 1 then 1 else 0 end )home  ,
                          SUM(CASE WHEN tipo = 2 then 1 else 0 end )prospectos ,   
                          SUM(CASE WHEN tipo = 3 then 1 else 0 end )usuario_miembro , 
                          SUM(CASE WHEN tipo = 4 then 1 else 0 end )inicio_session , 
                          SUM(CASE WHEN tipo = 5 then 1 else 0 end )busqueda  ,                          
                          SUM(CASE WHEN tipo = 6 then 1 else 0 end )pagina_empresa, 
                          SUM(CASE WHEN tipo = 7 then 1 else 0 end )eventos ,          
                          SUM(CASE WHEN tipo = 8 then 1 else 0 end )dia_evento , 
                          SUM(CASE WHEN tipo = 9 then 1 else 0 end )accesos , 
                          SUM(CASE WHEN tipo = 10 then 1 else 0 end )escenarios , 
                          SUM(CASE WHEN tipo = 11 then 1 else 0 end )cuenta_historia , 
                          SUM(CASE WHEN tipo = 12 then 1 else 0 end )solicita_artista , 
                          SUM(CASE WHEN tipo = 13 then 1 else 0 end )tendencias_empresa , 
                          SUM(CASE WHEN tipo = 14 then 1 else 0 end )informacion_usuario , 
                          SUM(CASE WHEN tipo = 15 then 1 else 0 end )errores_sistema , 
                          SUM(CASE WHEN tipo = 16 then 1 else 0 end )conf_escenario  , 
                          SUM(CASE WHEN tipo = 17 then 1 else 0 end )accesos_sistema  , 
                          SUM(CASE WHEN tipo = 18 then 1 else 0 end )conf_evento  , 
                          SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_acceso , 
                          SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_punto_eventa                           
                          FROM  tmp_landing_$_num  GROUP  BY f_registro                         
                          UNION  

                          SELECT 
                          '' totales , 
                          count(0) total_registrado , 
                          SUM(CASE WHEN tipo = 1 then 1 else 0 end )home  ,
                          SUM(CASE WHEN tipo = 2 then 1 else 0 end )prospectos ,   
                          SUM(CASE WHEN tipo = 3 then 1 else 0 end )usuario_miembro , 
                          SUM(CASE WHEN tipo = 4 then 1 else 0 end )inicio_session , 
                          SUM(CASE WHEN tipo = 5 then 1 else 0 end )busqueda  ,                          
                          SUM(CASE WHEN tipo = 6 then 1 else 0 end )pagina_empresa, 
                          SUM(CASE WHEN tipo = 7 then 1 else 0 end )eventos ,          
                          SUM(CASE WHEN tipo = 8 then 1 else 0 end )dia_evento , 
                          SUM(CASE WHEN tipo = 9 then 1 else 0 end )accesos , 
                          SUM(CASE WHEN tipo = 10 then 1 else 0 end )escenarios , 
                          SUM(CASE WHEN tipo = 11 then 1 else 0 end )cuenta_historia , 
                          SUM(CASE WHEN tipo = 12 then 1 else 0 end )solicita_artista , 
                          SUM(CASE WHEN tipo = 13 then 1 else 0 end )tendencias_empresa , 
                          SUM(CASE WHEN tipo = 14 then 1 else 0 end )informacion_usuario , 
                          SUM(CASE WHEN tipo = 15 then 1 else 0 end )errores_sistema , 
                          SUM(CASE WHEN tipo = 16 then 1 else 0 end )conf_escenario  , 
                          SUM(CASE WHEN tipo = 17 then 1 else 0 end )accesos_sistema  , 
                          SUM(CASE WHEN tipo = 18 then 1 else 0 end )conf_evento  , 
                          SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_acceso , 
                          SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_punto_eventa                           
                          FROM  tmp_landing_$_num group  by totales";
          $result = $this->db->query($query_get);
          return  $result->result_array();
    }
    /**/
    function visitas_enid_dia($_num){

                        $query_get =  "SELECT 
                                      hour(fecha_registro) horario, 
                                      count(0) total_registrado , 
                                      SUM(CASE WHEN tipo = 1 then 1 else 0 end )home  ,
                                      SUM(CASE WHEN tipo = 2 then 1 else 0 end )prospectos ,   
                                      SUM(CASE WHEN tipo = 3 then 1 else 0 end )usuario_miembro , 
                                      SUM(CASE WHEN tipo = 4 then 1 else 0 end )inicio_session , 
                                      SUM(CASE WHEN tipo = 5 then 1 else 0 end )busqueda  ,                          
                                      SUM(CASE WHEN tipo = 6 then 1 else 0 end )pagina_empresa, 
                                      SUM(CASE WHEN tipo = 7 then 1 else 0 end )eventos ,          
                                      SUM(CASE WHEN tipo = 8 then 1 else 0 end )dia_evento , 
                                      SUM(CASE WHEN tipo = 9 then 1 else 0 end )accesos , 
                                      SUM(CASE WHEN tipo = 10 then 1 else 0 end )escenarios , 
                                      SUM(CASE WHEN tipo = 11 then 1 else 0 end )cuenta_historia , 
                                      SUM(CASE WHEN tipo = 12 then 1 else 0 end )solicita_artista , 
                                      SUM(CASE WHEN tipo = 13 then 1 else 0 end )tendencias_empresa , 
                                      SUM(CASE WHEN tipo = 14 then 1 else 0 end )informacion_usuario , 
                                      SUM(CASE WHEN tipo = 15 then 1 else 0 end )errores_sistema , 
                                      SUM(CASE WHEN tipo = 16 then 1 else 0 end )conf_escenario  , 
                                      SUM(CASE WHEN tipo = 17 then 1 else 0 end )accesos_sistema  , 
                                      SUM(CASE WHEN tipo = 18 then 1 else 0 end )conf_evento  , 
                                      SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_acceso , 
                                      SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_punto_eventa                           
                                      FROM  tmp_landing_$_num 
                                      WHERE f_registro =  DATE(CURRENT_DATE() )  
                                      GROUP BY HOUR(fecha_registro)
                                        
                                        UNION 

                                      SELECT 
                                      hour(fecha_registro) horario, 
                                      count(0) total_registrado , 
                                      SUM(CASE WHEN tipo = 1 then 1 else 0 end )home  ,
                                      SUM(CASE WHEN tipo = 2 then 1 else 0 end )prospectos ,   
                                      SUM(CASE WHEN tipo = 3 then 1 else 0 end )usuario_miembro , 
                                      SUM(CASE WHEN tipo = 4 then 1 else 0 end )inicio_session , 
                                      SUM(CASE WHEN tipo = 5 then 1 else 0 end )busqueda  ,                          
                                      SUM(CASE WHEN tipo = 6 then 1 else 0 end )pagina_empresa, 
                                      SUM(CASE WHEN tipo = 7 then 1 else 0 end )eventos ,          
                                      SUM(CASE WHEN tipo = 8 then 1 else 0 end )dia_evento , 
                                      SUM(CASE WHEN tipo = 9 then 1 else 0 end )accesos , 
                                      SUM(CASE WHEN tipo = 10 then 1 else 0 end )escenarios , 
                                      SUM(CASE WHEN tipo = 11 then 1 else 0 end )cuenta_historia , 
                                      SUM(CASE WHEN tipo = 12 then 1 else 0 end )solicita_artista , 
                                      SUM(CASE WHEN tipo = 13 then 1 else 0 end )tendencias_empresa , 
                                      SUM(CASE WHEN tipo = 14 then 1 else 0 end )informacion_usuario , 
                                      SUM(CASE WHEN tipo = 15 then 1 else 0 end )errores_sistema , 
                                      SUM(CASE WHEN tipo = 16 then 1 else 0 end )conf_escenario  , 
                                      SUM(CASE WHEN tipo = 17 then 1 else 0 end )accesos_sistema  , 
                                      SUM(CASE WHEN tipo = 18 then 1 else 0 end )conf_evento  , 
                                      SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_acceso , 
                                      SUM(CASE WHEN tipo = 19 then 1 else 0 end )conf_punto_eventa                           
                                      FROM  tmp_landing_$_num 
                                      WHERE f_registro =  DATE(CURRENT_DATE() )  
                                      
                                      "; 


                                      $result = $this->db->query($query_get);
                                      return  $result->result_array();


    }
    /**/
    function get_dispositivos_dia(){

       $query_get = "SELECT 
                  dispositivo , COUNT(0)accesos    
                  FROM pagina_web 
                  WHERE DATE(fecha_registro) =  DATE(CURRENT_DATE() ) 
                  GROUP  BY dispositivo ORDER BY accesos DESC";


      $result =  $this->db->query($query_get);            
      return $result->result_array();
    }
    /**/
    function get_sitios_dia(){

      $query_get = "SELECT 
                  url , COUNT(0)accesos    
                  FROM pagina_web 
                  WHERE DATE(fecha_registro) =  DATE(CURRENT_DATE() ) 
                  GROUP  BY url ORDER BY accesos DESC";


      $result =  $this->db->query($query_get);            
      return $result->result_array();
    }    
    /**/
    function get_visitas_unicas_dia_enid($_num){

      $query_get ="
      select 
      count(*)accesos , 
      count(distinct(ip))ip ,
      count(distinct(url))sitios   ,
      count(distinct(dispositivo))dispositivos   
      from tmp_landing_$_num WHERE f_registro =  DATE(CURRENT_DATE() )";

      $result = $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_comparativa_landing_page(){

      $_num =  get_random();
      $this->create_tmp_langings($_num ,  0 );


                
          $data_complete["semanal"] =  $this->visitas_enid_semana($_num);
          $data_complete["dia"] = $this->visitas_enid_dia($_num);
          $data_complete["visitas_dispositivos"] = $this->get_visitas_unicas_dia_enid($_num);

        $this->create_tmp_langings($_num ,  1 );          
        return $data_complete;      
    }
    /**/
    function create_tmp_langings($_num ,  $flag ){

      $query_drop = "DROP TABLE IF exists tmp_landing_$_num";  
      $db_response = $this->db->query($query_drop);

      if ($flag == 0 ){
        $query_create = "CREATE TABLE tmp_landing_$_num AS
                         SELECT * , date(fecha_registro) f_registro FROM pagina_web 
                         WHERE DATE(fecha_registro )
                         BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 WEEK ) 
                         AND  DATE(CURRENT_DATE())";  
        $db_response =  $this->db->query($query_create);
      }
      return $db_response;

    }
    /**/
    function registra_acceso_pagina_web($url , $ip , $dispositivo ,  $tipo  ){

      $query_insert =  "INSERT INTO pagina_web(
                        url,             
                        ip ,              
                        dispositivo , 
                        tipo )
                        VALUES( '".$url."'  , '".$ip."'  , '".$dispositivo."'  , '". $tipo ."' )"; 
      $this->db->query($query_insert);
    }


    /**/
    function get_organizaciones_con_eventos_prospecto($param){

      $_num =  get_random();      
      $this->create_organizaciones_prospecto($_num , 0 );
      $this->create_empresa_eventos($_num , 0 );  

        $query_get =  "SELECT 
                      SUM(CASE WHEN eventos >  0  then 1 else  0 end ) organizaciones
                      FROM tmp_empresa_eventos_$_num;";
        
        $result =  $this->db->query($query_get);
        
        $data_complete =  $result->result_array();
      
      $this->create_organizaciones_prospecto($_num , 1, $param);
      $this->create_empresa_eventos($_num , 1 , $param);  

      return  $data_complete;
    }
    


    /**/
    function get_organizaciones_sin_eventos_prospecto($param){

      $_num =  get_random();      
      $this->create_organizaciones_prospecto($_num , 0 );
      $this->create_empresa_eventos($_num , 0 );  

        $query_get =  "SELECT 
                      SUM(CASE WHEN eventos = 0  then 1 else  0 end ) organizaciones
                      FROM tmp_empresa_eventos_$_num;";
        
        $result =  $this->db->query($query_get);
        
        $data_complete =  $result->result_array();
      
      $this->create_organizaciones_prospecto($_num , 1, $param);
      $this->create_empresa_eventos($_num , 1 , $param);  

      return  $data_complete;
    }
    /**/
    function create_empresa_eventos($_num , $flag ){        

      $query_drop =  "DROP TABLE IF exists tmp_empresa_eventos_$_num";
      $db_response =  $this->db->query($query_drop);

      if ($flag == 0 ){

            $query_get ="CREATE TABLE tmp_empresa_eventos_$_num   AS SELECT emp.idempresa , 
                  SUM(CASE WHEN  e.idempresa > 0 then 1 else 0  end)eventos  
                  FROM tmp_emp_prospecto_$_num emp 
                  LEFT OUTER JOIN  
                  evento e 
                  ON emp.idempresa =  e.idempresa GROUP BY  
                  emp.idempresa";
            
            $db_response =  $this->db->query($query_get);


      }

      return $db_response;

    } 

    /**/
    function create_organizaciones_prospecto($_num , $flag){

        $query_drop =  "DROP TABLE IF exists tmp_emp_prospecto_$_num";
        $db_response = $this->db->query($query_drop);

        if ($flag == 0 ){
          
          $query_create =  "CREATE TABLE tmp_emp_prospecto_$_num AS  
                            SELECT 
                            idempresa  ,     
                            nombreempresa ,   
                            idCountry      , 
                            fecha_registro 
                            FROM empresa WHERE status =  1"; 
          $db_response =  $this->db->query($query_create);

        }
        return $db_response;
    }
    /**/
    function get_imagen($id_imagen ){

        $query_get =  "SELECT * FROM imagen WHERE idimagen = $id_imagen LIMIT 1"; 
        $result  =  $this->db->query($query_get);
        return $result->result_array();


    }
    /**/
    function get_tipo_publicidad(){

        $query_get =  "SELECT * FROM tipo_publicidad WHERE status = 1";
        $result  = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function reporta_error($param){

      $descripcion = $param["descripcion"];
      $query_insert =  "INSERT INTO 
                        incidencia(descripcion_incidencia , 
                          idtipo_incidencia , 
                          idcalificacion ,  
                          id_user ) 
                        VALUES('".$descripcion ."' , 4 ,  1 , 1)";
      return  $this->db->query($query_insert);                  
    }
    /**/

    /**/
    function get_info_prospectos_e($param){

      $_num =  get_random();
        $this->create_tmp_semana_p($_num , 0, $param);
        $this->create_tmp_event_p($_num , 0, $param);
        $query_get =  "";
          switch ($param["periodo"]) {
            case 'semana':        

                $query_get =  "SELECT e.*  FROM tmp_1week_prospectos_$_num em
                INNER JOIN tmp_1week_prospectos_e$_num e 
                 ON  em.idempresa =  e.idempresa 
                WHERE date(em.fecha_registro) = DATE(CURRENT_DATE() -7)";
              break;
            case 'ayer':
                    $query_get =  "SELECT e.*  FROM tmp_1week_prospectos_$_num em
                INNER JOIN tmp_1week_prospectos_e$_num e 
                 ON  em.idempresa =  e.idempresa 
                WHERE date(em.fecha_registro) = DATE(CURRENT_DATE() -1)";
              break;
            case 'hoy':
                    $query_get =  "SELECT e.*  FROM tmp_1week_prospectos_$_num em
                INNER JOIN tmp_1week_prospectos_e$_num e 
                 ON  em.idempresa =  e.idempresa 
                WHERE date(em.fecha_registro) = DATE(CURRENT_DATE())";
              break;
            default:            
              break;
          }

        $result =  $this->db->query($query_get);
        $data_complete =  $result->result_array();
        $this->create_tmp_event_p($_num , 1, $param);
        $this->create_tmp_semana_p($_num , 1, $param);

        return $data_complete;
        

    } 
    /**/
    function create_tmp_event_p($_num , $flag , $param){
        $query_drop =  "DROP TABLE IF exists tmp_1week_prospectos_e$_num";  
        $db_response =  $this->db->query($query_drop);

        if ($flag == 0){            
            $query_create =  "CREATE TABLE tmp_1week_prospectos_e$_num AS 
                                SELECT 
                                idevento,
                                fecha_inicio,
                                fecha_termino,
                                idempresa,
                                nombre_evento,
                                fecha_registro,
                                reservacion_tel,
                                reservacion_mail  
                                FROM  evento                                
                                WHERE DATE(fecha_registro) 
                                BETWEEN DATE_ADD(CURRENT_DATE() ,  INTERVAL -1 WEEK )
                                AND DATE(CURRENT_DATE())"; 
            $db_response  =  $this->db->query($query_create);
        }
        return $db_response;

            

    } 
            

    /**/
    function get_info_prospectos($param){
        
        $_num =  get_random();
        $this->create_tmp_semana_p($_num , 0, $param);
        $query_get =  "";
          switch ($param["periodo"]) {
            case 'semana':        
                $query_get =  "SELECT * FROM tmp_1week_prospectos_$_num WHERE date(fecha_registro) = DATE(CURRENT_DATE() -7) ";
              break;
            case 'ayer':
                $query_get =  "SELECT * FROM tmp_1week_prospectos_$_num WHERE date(fecha_registro) = DATE(CURRENT_DATE() -1) ";
              break;
            case 'hoy':
                $query_get =  "SELECT * FROM tmp_1week_prospectos_$_num WHERE date(fecha_registro) = DATE(CURRENT_DATE())";
              break;
            default:            
              break;
          }

        $result =  $this->db->query($query_get);
        $data_complete =  $result->result_array();
        $this->create_tmp_semana_p($_num , 1, $param);
        return $data_complete;
        


    }    
    /**/
    function create_tmp_semana_p($_num , $flag , $param){

        $query_drop =  "DROP TABLE IF exists tmp_1week_prospectos_$_num";  
        $db_response =  $this->db->query($query_drop);

        if ($flag == 0){            
            $query_create =  "CREATE TABLE tmp_1week_prospectos_$_num AS 
                                SELECT 
                                idempresa          ,   
                                nombreempresa      ,   
                                fecha_registro     ,   
                                status             ,   
                                idplan             ,   
                                facebook           ,   
                                tweeter            ,   
                                gp                 ,   
                                www                ,   
                                reservacion_tel    ,   
                                reservacion_mail   
                                FROM  empresa                                
                                WHERE DATE(fecha_registro) 
                                BETWEEN DATE_ADD(CURRENT_DATE() ,  INTERVAL -1 WEEK )
                                AND DATE(CURRENT_DATE())
                                AND status =  1
                               "; 
            $db_response  =  $this->db->query($query_create);
        }
        return $db_response;

    }
    /**/
    function reservacion_evento($param){

        $nombre =  $param["a_nombre"];
        $mail =  $param["a_mail"];
        $telefono =  $param["a_telefono"];
        $reservados =  $param["a_reservados"];
        $id_evento = $param["id_evento"];
        $id_empresa =  $param["id_empresa"];
        $ip = $param["ip"];

        $query_insert =  "SELECT 
                          COUNT(0)registros  
                          FROM reservacion 
                          WHERE 
                          idevento = '".$id_evento."' 
                          AND  (mail = '".$mail ."' OR ip = '". $ip ."' )
                          LIMIT 1 "; 

        $result  = $this->db->query($query_insert);
        $num_reservacion  =  $result->result_array()[0]["registros"];
        $f =1;
        if ($num_reservacion  == 0 ){
          /**/  
          $query_insert =  "INSERT INTO reservacion(
                                    nombre , 
                                    mail , 
                                    telefono , 
                                    num_asistentes ,  
                                    idevento, 
                                    idempresa , 
                                    ip 
                                    ) 
                                  VALUES(
                                         '".$nombre."'  ,
                                         '".$mail."' ,
                                         '".$telefono ."' ,
                                         '".$reservados."',
                                         '".$id_evento ."' ,
                                         '".$id_empresa ."',
                                         '".$ip."'
                                        )"; 

          $f =  $this->db->query($query_insert);      
  
        }
        return $f;
        
        
    }
    /**/
    function miemtros_cuenta($param){

      $query_get =  "
                    SELECT 
                      idusuario           , 
                      nombre              , 
                      email                     , 
                      fecha_registro                  , 
                      puesto              , 
                      status              , 
                      apellido_paterno    , 
                      apellido_materno    , 
                      email_alterno       , 
                      tel_contacto        , 
                      tel_contacto_alterno, 
                      edad                      , 
                      cargo               , 
                      url_fb              , 
                      url_tw              , 
                      url_www             , 
                      sexo                     
                    FROM usuario WHERE idempresa =  '".$param["id_empresa"]."'  LIMIT  5";  
                  $result =   $this->db->query($query_get);
                  return $result->result_array();
    }

    /**/
    function repo_prospectos_comparativa(){      
      /**/          
      $_num =  get_random();
      $this->create_tmp_2week($_num ,  0 );
        $r =  $this->create_tmp_block($_num ,  0 );        

        $query_get = "select  
                      sum(case when prospectos_semana  = 1 then 1 else 0 end )prospectos_semana ,  
                      sum(case when  prospectos_ayer =  1 then 1 else 0  end )prospectos_ayer , 
                      sum(case when  prospectos_dia =  1 then 1 else 0 end ) prospectos_dia 
                      from tmp_2week_info2_$_num"; 
                      $result = $this->db->query($query_get);
                      $data["info_prospectos"] =  $result->result_array();


                 $query_get2 ="     
                      select 
                      sum(case when eventos_dia =  1 then 1 else 0 end )eventos_dia ,
                      sum(case when eventos_ayer =  1 then 1 else 0 end )eventos_ayer ,
                      sum(case when eventos_semana =  1 then 1 else 0 end )eventos_semana 
                      from evento e 
                      inner join tmp_2week_info2_$_num b on e.idempresa =  b.idempresa";
                      $result2 = $this->db->query($query_get2);
                      $data["info_eventos"] =  $result2->result_array();

                      $this->create_tmp_2week($_num ,  1 );
         $this->create_tmp_block($_num ,  1);   
      return $data;

    }
    /**/
    function create_tmp_block($_num ,  $flag ){

        $query_drop =  "DROP TABLE IF exists tmp_2week_info2_$_num";
        $db_response =  $this->db->query($query_drop);

        if ($flag == 0){

            $query_create =  "CREATE TABLE tmp_2week_info2_$_num AS 
                              select 
                                idempresa , 
                                sum(case when  date(fecha_registro) =  current_date()-7 then 1 else 0 end )prospectos_semana ,           
                                sum(case when  date(fecha_registro) =  current_date()-1 then 1 else 0 end )prospectos_ayer ,           
                                sum(case when  date(fecha_registro) =  current_date() then 1 else 0 end )prospectos_dia ,              
                                sum(case when empresa_dia = 1   then 1 else 0 end )eventos_dia, 
                                sum(case when empresa_ayer = 2   then 1 else 0 end )eventos_ayer ,
                                sum(case when empresa_week =   3  then 1 else 0 end )eventos_semana             
                              from tmp_2week_$_num group BY idempresa";  
            $db_response = $this->db->query($query_create);
        }
        return $db_response;

    }
    /**/
    function create_tmp_2week($_num ,  $flag ){
       
      $query_drop =  "DROP TABLE IF exists tmp_2week_$_num";
      $db_response =  $this->db->query($query_drop);

        if ($flag == 0){
            $query_create =  "CREATE TABLE tmp_2week_$_num AS 
                              SELECT 
                              idempresa  ,  
                              fecha_registro , 
                              sum(case when  date(fecha_registro) = CURRENT_DATE() THEN 1 ELSE 0 END   )empresa_dia,
                              sum(case when  date(fecha_registro) = CURRENT_DATE() -1 THEN 2 ELSE 0 END   )empresa_ayer,
                              sum(case when  date(fecha_registro) = DATE(CURRENT_DATE() -7) THEN 3 ELSE 0 END   )empresa_week
                              FROM  empresa 
                              WHERE 
                              status = 1 AND 
                              date(fecha_registro) 
                              BETWEEN DATE_ADD(CURRENT_DATE() ,  INTERVAL -1 WEEK )
                              AND CURRENT_DATE() GROUP BY idempresa";  
            $db_response = $this->db->query($query_create);                  
        }
        return $db_response;
    }
    /**/
    function set_pass($param){

        $mail =  trim($param["mail"]); 
        $new_pass =  RandomString(); 
        $query_update =  "UPDATE usuario SET password = '".sha1($new_pass)."' WHERE email = '".$mail."' LIMIT 1 ";
        
        $status_send= $this->db->query($query_update); 
        $data["new_pass"]= $new_pass;
        $data["status_send"] = $status_send; 
        $data["mail"] =  $param["mail"];
        return $data;
    }

    /**/
    function verifica_estatus_prospecto($param){

      $query_get =  "SELECT password_prospecto 
                            FROM usuario 
                            WHERE email =  '".$param["mail_user"]."' LIMIT 1";
      $result =  $this->db->query($query_get);
      $num_mail =  $result->result_array()[0]["password_prospecto"];
      $data["mail_prospecto"] =1; 
      if ($num_mail == 0 ){
          $data["mail_prospecto"] =0;
          $new_pass =  RandomString();
          $data["new_pass"] =  $new_pass;

          $query_update =  "UPDATE usuario SET password_prospecto = 1 ,  password = '".sha1($new_pass)."'  WHERE email =  '".$param["mail_user"]."' LIMIT 1   ";
          $data["estatus_pass"]=  $this->db->query($query_update);

      }
      return $data;
    }
    /**/
    function repo_prospectos($param){

      $_num =  get_random();
      $flag_evento = $this->create_tmps($_num , 0 , $param);            
      $query_get =  "SELECT * FROM  
                    tmp_prospectos_$_num  p 
                    LEFT OUTER JOIN 
                    tmp_prospectos_eventos_$_num e  ON p.idempresa  =  e.id_empresa_eventos
                    LEFT OUTER  JOIN  
                    tmp_prospectos_miembro_$_num  m 
                    ON  p.idempresa =  m.idempresa
                    ORDER BY p.fecha_registro DESC

                    ";  

      $result =  $this->db->query($query_get);
      $data_complete =  $result->result_array();
      $flag_evento = $this->create_tmps($_num , 1 , $param);            
      return $data_complete;
    }
    /**/
    function create_tmps($_num , $flag , $param){

        $this->create_tmps_info_empresa($_num , $flag , $param);
        $flag_evento =  $this->create_tmps_eventos($_num , $flag , $param);
        $flag_miembros  =  $this->create_tmps_miembros($_num , $flag );
        return  $flag_evento;     
    }
    /**/
    function create_tmps_miembros($_num , $flag ){

        $query_drop =  "DROP TABLE IF exists tmp_prospectos_miembro_$_num"; 
        $db_response=  $this->db->query($query_drop);
        /**/
        
        if ($flag == 0 ){
            $query_create =  "CREATE TABLE tmp_prospectos_miembro_$_num AS 
                              SELECT  e.idempresa, COUNT(0)miembros FROM usuario u  
                              INNER JOIN tmp_prospectos_$_num e ON u.idempresa =  e.idempresa group by e.idempresa;";  
                              $db_response = $this->db->query($query_create );                              
        }
        return $db_response;
        
    }
    
    /**/
    function create_tmps_eventos($_num , $flag , $param){

      $flag_action = "";  
      $query_drop =  "DROP TABLE IF exists tmp_prospectos_eventos_$_num";
      $flag_action =   $this->db->query($query_drop); 

      if ($flag == 0 ){
      
        $query_procedure =  "CREATE TABLE tmp_prospectos_eventos_$_num AS 
                            SELECT  e.idempresa id_empresa_eventos ,  COUNT(*)num_eventos 
                            FROM  evento e  
                            INNER JOIN  tmp_prospectos_$_num  p  
                            ON  e.idempresa =  p.idempresa 
                            group by  e.idempresa";

         $flag_action  =  $this->db->query($query_procedure);
 
      }
      return $flag_action;

    }
    /**/
    function create_tmps_info_empresa($_num , $flag , $param){
      $flag_action = "";  
      $query_drop =  "DROP TABLE IF exists tmp_prospectos_$_num";
      $flag_action =   $this->db->query($query_drop); 


      if ($flag == 0 ){

          $query_procedure ="CREATE TABLE   tmp_prospectos_$_num AS SELECT 
                  idempresa,  
                  nombreempresa , 
                  fecha_registro ,  
                  facebook , 
                  tweeter , 
                  gp , 
                  www ,  
                  datediff( CURRENT_DATE() , fecha_registro) dias_dif
                  FROM empresa 
                  WHERE  
                  status = 1 ORDER BY fecha_registro DESC"; 
          
          $flag_action =  $this->db->query($query_procedure);

      }

      return $flag_action;

    }
    /**/
    function display_recursos_by_perfiles($perfiles){

        $b = 0;
        $data_info = array();
        $datacompleto = array();
        

        $idperfil = $perfiles[0]["idperfil"];
                        $query_get ="SELECT
                                        r.nombre , 
                                        r.urlpaginaweb , 
                                        r.iconorecurso, 
                                        r.descripcionrecurso , 
                                        pr.idrecurso 
                                        FROM recurso  r INNER JOIN 
                                        perfil_recurso  pr
                                        ON  r.idrecurso  =  pr.idrecurso 
                                        WHERE 
                                        r.idrecurso = pr.idrecurso AND 
                                        pr.idperfil = $idperfil  
                                        ORDER BY order_negocio ASC"; 

            $result = $this->db->query($query_get);  
            $data  = $result ->result_array();
            
            for ($i=0; $i <  count($data); $i++) {                             
                if (!in_array( $data[$i], $data_info)){
                    $data_info[$b] = $data[$i];
                    $b++;                    
                }
            }
            
            /*Terminamos de de recorrer perfiles*/           
            /*Sub páginas*/
            $datacompleto = $data_info;
            foreach ($perfiles as $row){

                $id_perfil_actual = $row["idperfil"];
                
                        /******  ******/
                        for ($a=0; $a < count($datacompleto); $a++) { 
                            
                            $idrecursoactual= $datacompleto[$a]["idrecurso"];   
                            
                            /*Validamos que no este sin elementos el arreglo*/                        
                            if ($idrecursoactual != "") {
                                    

                                $sub_paginas_query = "SELECT  
                                                    p.nombrepermiso , 
                                                    p.urlpaginaweb ,
                                                    p.iconpermiso, 
                                                    p.descripcionpermiso 
                                                    FROM permiso AS p , perfil_permiso AS pp  
                                                    WHERE  pp.idpermiso = p.idpermiso AND 
                                                    pp.idperfil = $id_perfil_actual AND 
                                                    p.idrecurso = $idrecursoactual LIMIT 5";

                                $resultsubpaginas  = $this->db->query($sub_paginas_query);  
                                $datasubpaginas   = $resultsubpaginas ->result_array();
                                $datacompleto[$a]["subpaginas"] = $datasubpaginas; 

                            }/*Terminamos de validar que no este sin id el arreglo */
        
                        }                    
            }
            return $datacompleto;

        }
    

}