<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class enidmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    
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


          $query_get = "SELECT 
                          f_registro , 
                          count(0) total_registrado , 
                          SUM(CASE WHEN tipo = 40 then 1 else 0 end )home  ,
                          SUM(CASE WHEN tipo = 29 then 1 else 0 end )repo_enid ,   
                          SUM(CASE WHEN tipo = 41 then 1 else 0 end )bi , 
                          SUM(CASE WHEN tipo = 42 then 1 else 0 end )blog , 
                          SUM(CASE WHEN tipo = 111 then 1 else 0 end )coincidir  ,                          
                          SUM(CASE WHEN tipo = 43 then 1 else 0 end )contacto , 
                          SUM(CASE WHEN tipo = 112 then 1 else 0 end )cotizaciones ,          
                          SUM(CASE WHEN tipo = 44 then 1 else 0 end )desarrollo_web , 
                          SUM(CASE WHEN tipo = 45 then 1 else 0 end )pagina_web , 
                          SUM(CASE WHEN tipo = 46 then 1 else 0 end )ultimos_proyectos                           
                      FROM tmp_landing_$_num GROUP  BY f_registro                         
                        UNION  
                      SELECT 
                      '' totales , 
                      count(0) total_registrado , 
                      SUM(CASE WHEN tipo = 40 then 1 else 0 end )home  ,
                      SUM(CASE WHEN tipo = 29 then 1 else 0 end )repo_enid ,   
                      SUM(CASE WHEN tipo = 41 then 1 else 0 end )bi , 
                      SUM(CASE WHEN tipo = 42 then 1 else 0 end )blog , 
                      SUM(CASE WHEN tipo = 111 then 1 else 0 end )coincidir  ,                          
                      SUM(CASE WHEN tipo = 43 then 1 else 0 end )contacto, 
                      SUM(CASE WHEN tipo = 112 then 1 else 0 end )cotizaciones ,          
                      SUM(CASE WHEN tipo = 44 then 1 else 0 end )desarrollo_web , 
                      SUM(CASE WHEN tipo = 45 then 1 else 0 end )pagina_web , 
                      SUM(CASE WHEN tipo = 46 then 1 else 0 end )ultimos_proyectos                          
                      FROM tmp_landing_$_num group  by totales";                       

          $result = $this->db->query($query_get);
          return  $result->result_array();
    }
    /**/
    function visitas_enid_dia($_num){
      
        $query_get = "SELECT 
          hour(fecha_registro) horario , 
          count(0) total_registrado , 
          SUM(CASE WHEN tipo = 40 then 1 else 0 end )home  ,
          SUM(CASE WHEN tipo = 29 then 1 else 0 end )repo_enid ,   
          SUM(CASE WHEN tipo = 41 then 1 else 0 end )bi , 
          SUM(CASE WHEN tipo = 42 then 1 else 0 end )blog , 
          SUM(CASE WHEN tipo = 111 then 1 else 0 end )coincidir  ,                          
          SUM(CASE WHEN tipo = 43 then 1 else 0 end )contacto, 
          SUM(CASE WHEN tipo = 112 then 1 else 0 end )cotizaciones ,          
          SUM(CASE WHEN tipo = 44 then 1 else 0 end )desarrollo_web , 
          SUM(CASE WHEN tipo = 45 then 1 else 0 end )pagina_web , 
          SUM(CASE WHEN tipo = 46 then 1 else 0 end )ultimos_proyectos                           
          FROM  tmp_landing_$_num 
            WHERE f_registro =  DATE(CURRENT_DATE() )  
          GROUP BY HOUR(fecha_registro)
            
            ";                       


          $result = $this->db->query($query_get);
          return $result->result_array();


    }
    /**/
    function get_dispositivos_dia(){

       $query_get = "SELECT 
                    dispositivo , 
                    COUNT(0)accesos    
                    FROM pagina_web 
                    WHERE 
                    DATE(fecha_registro) =  DATE(CURRENT_DATE() ) 
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
 
 
}