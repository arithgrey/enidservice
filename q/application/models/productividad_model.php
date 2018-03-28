<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class productividad_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function create_table_visitas_usuario( $_num , $param , $sql_tiempo){

        $id_usuario =  $param["id_usuario"];
        $query_create = "CREATE TABLE visitas_tmp_global_$_num  
                          AS 
                          SELECT 
                          DATE(fecha_registro)fecha ,           
                          tipo
                        FROM 
                        pagina_web       
                        WHERE
                        id_usuario ='".$id_usuario."'
                        AND ".$sql_tiempo;

        $this->db->query($query_create); 

          $query_create = "CREATE TABLE visitas_tmp_$_num  AS 
            SELECT 
            fecha , 
            count(0) visitas ,          
            sum(CASE WHEN tipo 
            IN(5010, 5011, 5012 , 5013 , 50123)  THEN 1 ELSE 0 END )num_email_leidos                   
          FROM visitas_tmp_global_$_num       
          GROUP BY 
          fecha";
          $this->db->query($query_create); 
        
        $query_drop ="DROP TABLE if exists visitas_tmp_global_$_num";
        $this->db->query($query_drop); 

    }
    /**/
    function get_productividad_social_media($param){

       $_num =  get_random();        
        $this->drop_tables_repo_general($_num);

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      $sql_tiempo =  " date(fecha_registro) 
         between '".$fecha_inicio."' AND  '".$fecha_termino."' ";

      $sql_tiempo2 = "  DATE(fecha_registro) 
                        between '".$fecha_inicio."' AND  '".$fecha_termino."'
                        OR 
                        fecha_cambio_tipo
                        between '".$fecha_inicio."' AND  '".$fecha_termino."' 
                      ";
      $sql_tiempo_actualizacion =  " date(fecha_actualizacion) 
         between '".$fecha_inicio."' AND  '".$fecha_termino."' ";
   

      $sql_tiempo_termino =  " DATE(fecha_termino) BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."'";
         
      $this->create_table_visitas_usuario( $_num , $param , $sql_tiempo);
      $this->create_tables_prospectos_usuario( $_num , $param , $sql_tiempo2);
      $this->create_table_afiliados($_num , $param , $sql_tiempo);
      $this->create_table_prospecto_email($_num , $param , $sql_tiempo);
      $this->create_table_email_enviados_usuario($_num , $param , $sql_tiempo_actualizacion);
      $this->create_table_contact($_num , $param , $sql_tiempo);
      $this->create_table_proyecto($_num , $param , $sql_tiempo);
      $this->create_tables_blog_usuario($_num , $param , $sql_tiempo);
      $this->create_tables_tareas_resueltas($_num , $param , $sql_tiempo_termino);
      /**/


      $query_get =  "select v.* , 
                            em.email_enviados ,                                        
                            r.prospectos_registrados ,
                            c.numero_contactos ,     
                            c.num_contactos_promociones,                                                 
                            po.numero_proyectos , 
                            bl.num_blogs ,
                            pt.prospectos, 
                            pt.clientes,
                            pt.prospectos_sistema ,
                            af.afiliados, 
                            tr.num_tareas_resueltas                                                        
                            from 
                            visitas_tmp_$_num v                                                         
                            left outer join registros_tmp_$_num r on v.fecha =  r.fecha_registro 
                            left outer join registros_email_tmp_$_num em on v.fecha =  em.fecha_actualizacion                            
                            left outer join contactos_tmp_$_num c on v.fecha =  c.fecha_registro
                            
                            left outer join proyecto_tmp_$_num po on v.fecha =  po.fecha_registro 
                            left outer join blog_tmp_$_num bl on v.fecha =  bl.fecha_registro 
                            left outer join  personas_tmp_$_num pt ON pt.fecha =  v.fecha
                            left outer join  afiliados_tmp_$_num af ON af.fecha =  v.fecha
                            left outer join tareas_resueltas_$_num tr ON  v.fecha = tr.fecha_termino
                            ORDER BY v.fecha";

      $result = $this->db->query($query_get);               
      $data_complete =  $result->result_array();

      $this->drop_tables_repo_general($_num);
      return $data_complete;


    }
    function create_tables_tareas_resueltas($_num , $param , $sql_tiempo_termino){

      $query_create = "CREATE TABLE tareas_resueltas_$_num  
                        AS
                        SELECT                           
                          COUNT(0)num_tareas_resueltas ,                            
                          DATE(fecha_termino)fecha_termino
                        FROM 
                          tarea 
                        WHERE 
                          ".$sql_tiempo_termino." 
                        GROUP BY DATE(fecha_termino)";

      $this->db->query($query_create);

    }
    /**/
    function get_contactos_lead($param){

      $fecha = $param["fecha"];  
      $tipo = $param["tipo"];
      $query_get = "SELECT 
                      * 
                    FROM 
                      contact 
                    WHERE 
                    id_tipo_contacto =  '".$tipo."'
                    AND 
                      DATE(fecha_registro) = '".$fecha."'";

      $result =  $this->db->query($query_get);
      return $result->result_array();
      
    }
    /**/
    function get_historia_afiliados($param){

      $fecha = $param["fecha"];  
      $query_get = "SELECT 
                    u.*
                    FROM usuario_perfil up 
                    INNER JOIN 
                    usuario u ON 
                    up.idusuario =  u.idusuario 
                    WHERE 
                    idperfil =  19
                    AND
                    DATE(up.fecha_registro ) =  '".$fecha."'";

      $result =  $this->db->query($query_get);
      return $result->result_array();
      

    }
    /**/
    function get_num_clientes_sistema($param){

      $fecha = $param["fecha"];
      $query_get = "SELECT 
                    *
                    FROM persona 
                    WHERE 
                    registro_web =  1
                    AND 
                    DATE(fecha_registro) = '".$fecha."'";

      $result =  $this->db->query($query_get);
      return $result->result_array();
      
    }
    /**/
    function get_num_clientes($param){

      $fecha = $param["fecha"];
      $tipo =  $param["tipo"];

      $query_get = "SELECT 
                    *
                    FROM persona 
                    WHERE tipo = '".$tipo."'
                    AND 
                    DATE(fecha_registro) = '".$fecha."'";

      $result =  $this->db->query($query_get);
      return $result->result_array();
      
    }
    /**/
    function get_ventas_por_usuario($param){

       /**/         
        $query_get ="SELECT COUNT(0)num_contactos_usuario 
                     FROM 
                     persona 
                     WHERE 
                     id_usuario = '".$param["id_usuario"]."' 
                     AND tipo=2";
        
        $result =  $this->db->query($query_get); 
        return $result->result_array()[0]["num_contactos_usuario"];
    }
    /***/
    function get_comisiones_por_usuario($param){
      return "1"."MXN";
    }
    /***/    
    function get_contactos_por_usuario($param){
        
        /**/         
        $query_get ="SELECT COUNT(0)num_contactos_usuario 
                     FROM 
                     persona 
                     WHERE id_usuario = '".$param["id_usuario"]."' ";
        
        $result =  $this->db->query($query_get); 
        return $result->result_array()[0]["num_contactos_usuario"];
        
    }
    /**/
    function get_accesos_afiliado($param){
        
        /**/
        $query_get ="SELECT COUNT(0)num_accesos_afiliado 
                     FROM 
                     pagina_web 
                     WHERE url = '".$param["url"]."' ";
        
        $result =  $this->db->query($query_get); 
        return $result->result_array()[0]["num_accesos_afiliado"];
        
    }
    /**/
    function get_faqs($param){

       $_num =  get_random();                
          $this->create_tmp_blog_existentes(0 , $_num  , $param);          
            $this->create_tmp_paginas_web( 0, $_num ,  $param);        

            $query_get ="SELECT
                          b.titulo,
                          b.url   ,
                          p.fecha ,         
                          p.num_visitas_web 
                        FROM tmp_blogs_$_num b 
                        LEFT OUTER JOIN 
                        tmp_paginas_$_num p 
                        ON b.url =  p.url
                        ORDER BY fecha";

                $result =  $this->db->query($query_get);              
                $data_complete["info_accesos"] = $result->result_array();  



                $query_get ="SELECT *  FROM tmp_blogs_$_num";  
                $result =  $this->db->query($query_get);              
                $data_complete["blogs"] = $result->result_array();  

                /**/
                
                


              $this->create_tmp_blog_existentes(1 , $_num  , $param );          
            $this->create_tmp_paginas_web( 1, $_num ,  $param);   

        return $data_complete;    
    }
    /**/
    function create_tmp_paginas_web( $flag , $_num, $param){

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      $query_drop ="DROP TABLE IF exists tmp_paginas_$_num";
      $this->db->query($query_drop);

      /**/
      if ($flag ==  0){
              
        $query_create = "CREATE TABLE tmp_paginas_$_num AS                     
                            SELECT 
                            DATE(fecha_registro) fecha,  
                            COUNT(0)num_visitas_web,
                            TRIM(url)url  
                            FROM 
                            pagina_web
                            WHERE 
                            tipo = 2201
                            AND 
                            DATE(fecha_registro) 
                            BETWEEN 
                            '".$fecha_inicio ."'
                              AND 
                            '".$fecha_termino."' 
                            GROUP BY 
                            DATE(fecha_registro) ,
                            TRIM(url)
                            ORDER BY url";

                    $this->db->query($query_create);
        }

    }  
    /**/
    function create_tmp_blog_existentes($flag , $_num , $param ){

      

      $query_drop ="DROP TABLE IF exists tmp_blogs_$_num";
      $this->db->query($query_drop);

      if ($flag ==  0){
          
          $extra ="";
          if (isset($param["id_usuario"]) ) {
            $extra ="WHERE id_usuario = '".$param["id_usuario"]."' ";          
          }        

                  $query_create = "CREATE TABLE tmp_blogs_$_num AS                     
                                    SELECT 
                                      titulo ,
                                      CONCAT('http://enidservice.com/inicio/faq/?faq=' , id_faq)url ,
                                      id_faq 
                                    FROM faq ".$extra;

                    $this->db->query($query_create);
        }

    }
    /**/
    function insert_metas($param){

      $accesos_sw              = $param["accesos_sw"];
      $presentaciones_sw       = $param["presentaciones_sw"];
      $ventas_sw               = $param["ventas_sw"];
      $accesos_tl              = $param["accesos_tl"];
      $presentaciones_tl       = $param["presentaciones_tl"];
      $ventas_tl               = $param["ventas_tl"];
      $accesos_crm             = $param["accesos_crm"];
      $presentaciones_crm      = $param["presentaciones_crm"];
      $ventas_crm              = $param["ventas_crm"];
      $accesos_adwords         = $param["accesos_adwords"];
      $presentaciones_adwords  = $param["presentaciones_adwords"];
      $ventas_adwords         = $param["ventas_adwords"];
      $blogs_creados = $param["blogs"];


      $linkedin  =  $param["linkedin"];
      $facebook  =  $param["facebook"];
      $twitter   =  $param["twitter"];
      
      $instagram   =  $param["instagram"];
      $pinterest   =  $param["pinterest"];



      $query_insert ="INSERT INTO meta(
                      accesos_sw             
                      ,presentaciones_sw      
                      ,ventas_sw              
                      ,accesos_tl             
                      ,presentaciones_tl      
                      ,ventas_tl              
                      ,accesos_crm            
                      ,presentaciones_crm     
                      ,ventas_crm             
                      ,accesos_adwords        
                      ,presentaciones_adwords 
                      ,ventas_adwords        
                      ,blogs_creados
                      ,linkedin
                      ,facebook
                      ,twitter
                      , instagram
                      , pinterest)
                    
                    VALUES( '". $accesos_sw               ."'
                            , '". $presentaciones_sw        ."'
                            , '". $ventas_sw                ."'
                            , '". $accesos_tl               ."'
                            , '". $presentaciones_tl        ."'
                            , '". $ventas_tl                ."'
                            , '". $accesos_crm              ."'
                            , '". $presentaciones_crm       ."'
                            , '". $ventas_crm               ."'
                            , '". $accesos_adwords          ."'
                            , '". $presentaciones_adwords   ."'
                            , '". $ventas_adwords          ."'
                            , '". $blogs_creados  ."' 
                            , '". $linkedin  ."' 
                            , '". $facebook  ."' 
                            , '". $twitter  ."' 
                            , '". $instagram  ."' 
                            , '". $pinterest  ."' 

                            )";
  
                
      return $this->db->query($query_insert); 
    

    }
    /**/
    function get_presentaciones($param){

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];


      $where =  "WHERE  DATE(fecha_registro) 
                  BETWEEN 
                  '".$fecha_inicio."' AND '".$fecha_termino."'
                  GROUP BY 
                  HOUR(fecha_registro) 
                  ORDER BY HOUR(fecha_registro)DESC";
       
      $query_get =  "SELECT 
                    COUNT(0)num_presentaciones , 
                    SUM(CASE WHEN sitio = 0 THEN 1 ELSE 0 END )sitios_1490,
                    SUM(CASE WHEN sitio = 1 THEN 1 ELSE 0 END )sitios_tienda_en_linea,
                    SUM(CASE WHEN sitio = 2 THEN 1 ELSE 0 END )sitios_3490,
                    SUM(CASE WHEN sitio = 3 THEN 1 ELSE 0 END )sitios_4999,
                    SUM(CASE WHEN sitio = 4 THEN 1 ELSE 0 END )tienda_en_linea,
                    HOUR(fecha_registro)hora 
                    FROM 
                    sitio_presentacion " . $where;
     
      $result  =  $this->db->query($query_get);
      return  $result->result_array();

    }

    /**/
    function metas_usuario($param){

      $id_usuario =  $param["id_usuario"];
      $query_get =  "  SELECT 
                          COUNT(0) totales,
                            DATE(fecha_registro) fecha_registro , 
                            SUM(CASE WHEN tipo IN(106,500,501,5010,50100,105)then 1 else 0 end )paginas_web,                         
                            SUM(CASE WHEN tipo IN(107,108,516,517,5011,50111)  then 1 else 0 end )google_adwords,                                                                        
                            SUM(CASE WHEN tipo IN (109,110,510,511,5012,50121)then 1 else 0 end )tienda_en_linea, 
                            SUM(CASE WHEN tipo IN(111,112,514,515,5013,50139) then 1 else 0 end )crm
                          FROM 
                          pagina_web 
                          WHERE 
                          id_usuario =  $id_usuario
                          AND 
                          DATE(fecha_registro)= DATE(CURRENT_DATE)"; 
      $result =  $this->db->query($query_get);

      

      $data["info_metas_cumplidas"]=  $result->result_array();



      $query_get =  "SELECT * FROM meta ORDER BY fecha_registro DESC LIMIT 1";
      $result= $this->db->query($query_get);
      $data["info_metas"] = $result->result_array();

      /**/

      $query_get = "select date(post_date)fecha_registro , 
      count(0)num_blogs from 
      enidserv_wp619.wpu8_posts 
      where date(post_date) = DATE(CURRENT_DATE())       
      AND
      post_type= 'post' ";
      
      $result =  $this->db->query($query_get);      
      $data["info_blogs"] = $result->result_array();
      /**/



      $query_get ="SELECT * FROM tipo_negocio where prospeccion=1";
      $result =  $this->db->query($query_get);
      $data["perfiles_prospectacion"] = $result->result_array();

      return $data;
                        
    }
    /**/
    function relacion_ingresos($param){
      
      $query_get =  "SELECT * FROM meta ORDER BY fecha_registro DESC LIMIT 1";
      $result= $this->db->query($query_get);
      $data["info_metas"] = $result->result_array();

      /**/
      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];


      $query_get =  "SELECT 
      sum(case when sitio in(0,1,2,3) then  1 else 0 end  ) presentacion_sw , 
      sum(case when sitio = 4  then  1 else 0 end  ) presentacion_tl ,
      sum(case when sitio = 5  then  1 else 0 end  ) presentacion_adwords ,
      sum(case when sitio = 6  then  1 else 0 end  ) presentacion_crm 
      FROM  sitio_presentacion
      WHERE
      DATE(fecha_registro) 
      BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."' "; 


      $result= $this->db->query($query_get);
      $data["info_presentaciones"] = $result->result_array();




      /**/
      $query_get = "SELECT 
        sum(case when idtipo_proyecto  = 2 then  1 else 0 end  ) sw_creados , 
        sum(case when idtipo_proyecto  = 3  then  1 else 0 end  ) tl_creados ,
        sum(case when idtipo_proyecto  = 4  then  1 else 0 end  ) adwords_creados ,
        sum(case when idtipo_proyecto  = 5  then  1 else 0 end  ) crm_creados 
      FROM  proyecto 
      WHERE
      DATE(fecha_registro) 
      BETWEEN 
      '".$fecha_inicio."' AND '".$fecha_termino."' "; 

      $result= $this->db->query($query_get);      
      $data["info_proyecto"] = $result->result_array();






      


      $query_get = "select date(post_date)fecha_registro , 
      count(0)num_blogs from 
      enidserv_wp619.wpu8_posts 
      where date(post_date) 
      between '".$fecha_inicio."' AND  '".$fecha_termino."'
      AND  
      post_type= 'post' ";

      $result =  $this->db->query($query_get);      
      $data["info_blogs"] = $result->result_array();

  

      return $data;
                        
    }
    /**/

    function get_productividad_usuarios($param){

      $_num =  get_random();            
      $this->create_tmp_productividad_sociales_usuarios($_num ,  0  , $param );
        $this->create_tmp_productividad_correos_por_usuario($_num ,  0  , $param );
      
        $query_get =  "SELECT t.* ,  c.num_correos_registrados 
                      FROM  tmp_sociales_usuario_$_num t LEFT OUTER JOIN  
        tmp_correos_usuario_$_num c ON t.fecha_registro = c.fecha_registro ORDER BY t.fecha_registro DESC";
        $result =  $this->db->query($query_get);
        $data_complete["data_usuario_sociales"] = $result->result_array();

        $this->create_tmp_productividad_correos_por_usuario($_num ,  1  , $param );
      $this->create_tmp_productividad_sociales_usuarios($_num ,  1  , $param );    
      return $data_complete;

    }
     function drop_tables_repo_general($_num){

        
        $query_drop =  "drop table if exists visitas_tmp_global_$_num";
        $this->db->query($query_drop);  

        $query_drop =  "drop table if exists visitas_tmp_$_num";
        $this->db->query($query_drop);  

        $query_drop =  "drop table if exists personas_tmp_$_num";
        $this->db->query($query_drop);  

        /***/
        $query_drop =  "drop table if exists afiliados_tmp_$_num";
        $this->db->query($query_drop);  
        
        /**/
        $query_drop =  "drop table if exists registros_tmp_$_num";
        $this->db->query($query_drop);  

        $query_drop =  "drop table if exists registros_email_tmp_$_num";
        $this->db->query($query_drop);  

        $query_drop =  "drop table if exists contactos_tmp_$_num";
        $this->db->query($query_drop);      
        
        /**/        
        $query_drop =  "drop table if exists proyecto_tmp_$_num";
        $this->db->query($query_drop);        
        /**/
        
        $query_drop =  "drop table if exists blog_tmp_$_num";
        $this->db->query($query_drop);                     
        /**/

        $query_drop =  "drop table if exists tareas_resueltas_$_num";
        $this->db->query($query_drop);                     

    }

    /**/
    function create_table_visitas( $_num , $param , $sql_tiempo){

        $query_create = "CREATE TABLE visitas_tmp_global_$_num  
                          AS 
                          SELECT 
                          DATE(fecha_registro)fecha ,           
                          tipo
                        FROM pagina_web       
                          WHERE
                          ".$sql_tiempo;

        $this->db->query($query_create); 

          $query_create = "CREATE TABLE visitas_tmp_$_num  AS 
            SELECT 
            fecha , 
            count(0) visitas ,          
            sum(CASE WHEN tipo 
            IN(5010, 5011, 5012 , 5013 , 50123)  THEN 1 ELSE 0 END )num_email_leidos                   
          FROM visitas_tmp_global_$_num       
          GROUP BY 
          fecha";
          $this->db->query($query_create); 
        
        $query_drop ="DROP TABLE if exists visitas_tmp_global_$_num";
        $this->db->query($query_drop); 

    }
    /**/
    function create_tables_prospectos( $_num , $param , $sql_tiempo){

      $query_create = " 
      CREATE TABLE personas_tmp_global_$_num  AS 
        SELECT 
          DATE(fecha_registro)fecha , 
          tipo,
          registro_web
        FROM persona 
        WHERE
        ".$sql_tiempo;
      $this->db->query($query_create);
  

      $query_create = " 
      CREATE TABLE personas_tmp_$_num  AS 
        SELECT 
          fecha , 
          SUM(CASE WHEN tipo =1 THEN 1 ELSE 0 END )prospectos,
          SUM(CASE WHEN tipo =2 THEN 1 ELSE 0 END )clientes,
          SUM(CASE WHEN registro_web = 1 THEN 1 ELSE 0 END )prospectos_sistema
        FROM personas_tmp_global_$_num         
        GROUP BY fecha";
      $this->db->query($query_create);
      
      $query_drop ="DROP TABLE if exists personas_tmp_global_$_num";
      $this->db->query($query_drop); 
    }   
    /**/
    function create_tables_prospectos_usuario( $_num , $param , $sql_tiempo){

      $id_usuario =  $param["id_usuario"];

      $query_create = " 
      CREATE TABLE personas_tmp_global_$_num  AS 
        SELECT 
          DATE(fecha_registro)fecha , 
          tipo,
          registro_web
        FROM persona 
        WHERE
          id_usuario = '".$id_usuario."'
          AND 
        ".$sql_tiempo;
      $this->db->query($query_create);
  

      $query_create = " 
      CREATE TABLE personas_tmp_$_num  AS 
        SELECT 
          fecha , 
          SUM(CASE WHEN tipo =1 THEN 1 ELSE 0 END )prospectos,
          SUM(CASE WHEN tipo =2 THEN 1 ELSE 0 END )clientes,
          SUM(CASE WHEN registro_web = 1 THEN 1 ELSE 0 END )prospectos_sistema
        FROM personas_tmp_global_$_num         
        GROUP BY fecha";
      $this->db->query($query_create);
      
      $query_drop ="DROP TABLE if exists personas_tmp_global_$_num";
      $this->db->query($query_drop); 
    }   
    /**/
    function create_table_afiliados($_num , $param , $sql_tiempo){
       $query_create = " 
        CREATE TABLE afiliados_tmp_$_num  
          AS 
          SELECT 
          DATE(fecha_registro)fecha,
          COUNT(0)afiliados
          FROM usuario_perfil
          WHERE 
          ".$sql_tiempo."
          AND idperfil =  19
          GROUP BY DATE(fecha_registro)";

      $this->db->query($query_create);

    } 
    /**/
    function create_table_prospecto_email($_num , $param , $sql_tiempo){

        $query_create = "CREATE TABLE registros_tmp_global_$_num  AS 
            SELECT 
            DATE(fecha_registro)fecha_registro            
            FROM prospecto
            WHERE ".$sql_tiempo;

        $this->db->query($query_create);      

        $query_create = "CREATE TABLE registros_tmp_$_num  AS 
            SELECT 
            fecha_registro,              
            count(0)prospectos_registrados             
            FROM registros_tmp_global_$_num            
            GROUP BY  fecha_registro";
        $this->db->query($query_create);      



        $query_drop ="DROP TABLE if exists registros_tmp_global_$_num";
        $this->db->query($query_drop); 

    }
    /**/
    function create_table_email_enviados($_num , $param , $sql_tiempo_actualizacion){

          $query_create =  "CREATE TABLE registros_email_tmp_enviados_$_num AS 
            SELECT 
              DATE(fecha_actualizacion)fecha_actualizacion                      
            FROM prospecto  
            WHERE 
            ".$sql_tiempo_actualizacion;

          $this->db->query($query_create);    

           $query_create =  "CREATE TABLE registros_email_tmp_$_num AS 
            SELECT
              fecha_actualizacion,              
              COUNT(0)email_enviados             
            FROM registros_email_tmp_enviados_$_num              
            GROUP BY 
            fecha_actualizacion";

          $this->db->query($query_create);    

        $query_drop ="DROP TABLE if exists registros_email_tmp_enviados_$_num";
        $this->db->query($query_drop); 

    }
    /**/

    function create_table_email_enviados_usuario($_num , $param , $sql_tiempo_actualizacion){

          $id_usuario = $param["id_usuario"];
          $query_create =  "CREATE TABLE registros_email_tmp_enviados_$_num AS 
            SELECT 
              DATE(fecha_actualizacion)fecha_actualizacion                      
            FROM prospecto  
            WHERE 
            id_usuario = '".$id_usuario ."' AND 
            ".$sql_tiempo_actualizacion;

          $this->db->query($query_create);    

           $query_create =  "CREATE TABLE registros_email_tmp_$_num AS 
            SELECT
              fecha_actualizacion,              
              COUNT(0)email_enviados             
            FROM registros_email_tmp_enviados_$_num              
            GROUP BY 
            fecha_actualizacion";

          $this->db->query($query_create);    

        $query_drop ="DROP TABLE if exists registros_email_tmp_enviados_$_num";
        $this->db->query($query_drop); 

    }
    /**/
    function create_table_contact($_num , $param , $sql_tiempo){

      /**/
      $query_create =  "CREATE TABLE contactos_tmp_$_num   AS  
                          SELECT 
                          
                            SUM(CASE WHEN id_tipo_contacto = 2 THEN 1 ELSE 0 END)numero_contactos,
                            SUM(CASE WHEN id_tipo_contacto = 15 THEN 1 ELSE 0 END)num_contactos_promociones,
                          date(fecha_registro)fecha_registro  
                          from contact
                          where ".$sql_tiempo."
                          
                         group by date(fecha_registro)"; 

      $this->db->query($query_create);  
    }
    /**/
    function create_table_proyecto($_num , $param , $sql_tiempo){

       $query_create = "CREATE TABLE proyecto_tmp_global_$_num   
                        AS
                        SELECT
                          DATE(fecha_registro)fecha_registro  
                        FROM proyecto
                        WHERE  ".$sql_tiempo;

      $this->db->query($query_create);

      $query_create = "CREATE TABLE proyecto_tmp_$_num   
                        AS
                        select                           
                        count(0)numero_proyectos ,                            
                        fecha_registro  
                        FROM
                        proyecto_tmp_global_$_num
                        GROUP BY fecha_registro";

      $this->db->query($query_create);
      
      $query_drop ="DROP TABLE if exists proyecto_tmp_global_$_num";
      $this->db->query($query_drop); 

    }
    /**/
    function create_tables_blog($_num , $param , $sql_tiempo){
      
      $query_create = "CREATE TABLE blog_tmp_global_$_num   
                        AS
                        select                                                                             
                        date(fecha_registro)fecha_registro  
                        from faq
                        where  
                        ".$sql_tiempo;

      $this->db->query($query_create);

       $query_create = "CREATE TABLE blog_tmp_$_num   
                        AS
                        select                           
                        count(0)num_blogs ,                            
                        fecha_registro  
                        from blog_tmp_global_$_num                       
                        group by fecha_registro";

      $this->db->query($query_create);

      $query_drop ="DROP TABLE if exists blog_tmp_global_$_num";
      $this->db->query($query_drop); 
    }
    /**/
    function create_tables_blog_usuario($_num , $param , $sql_tiempo){
        
      $id_usuario = $param["id_usuario"];  
      $query_create = "CREATE TABLE blog_tmp_global_$_num   
                        AS
                        select                                                                             
                        date(fecha_registro)fecha_registro  
                        from faq
                        where  
                        id_usuario = '".$id_usuario."'
                        AND 
                        ".$sql_tiempo;

      $this->db->query($query_create);

       $query_create = "CREATE TABLE blog_tmp_$_num   
                        AS
                        select                           
                        count(0)num_blogs ,                            
                        fecha_registro  
                        from blog_tmp_global_$_num                       
                        group by fecha_registro";

      $this->db->query($query_create);

      $query_drop ="DROP TABLE if exists blog_tmp_global_$_num";
      $this->db->query($query_drop); 
    }
    
    /**/
    function get_productividad_usuario($param){

      $_num =  get_random();        
      $this->drop_tables_repo_general($_num);

      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      $sql_tiempo =  " date(fecha_registro) 
         between '".$fecha_inicio."' AND  '".$fecha_termino."' ";

      $sql_tiempo2 = "  DATE(fecha_registro) 
                        between '".$fecha_inicio."' AND  '".$fecha_termino."'
                        OR 
                        fecha_cambio_tipo
                        between '".$fecha_inicio."' AND  '".$fecha_termino."' ";

      $sql_tiempo_actualizacion =  " date(fecha_actualizacion) 
         between '".$fecha_inicio."' AND  '".$fecha_termino."' ";
   

      $this->create_table_visitas( $_num , $param , $sql_tiempo);
      $this->create_tables_prospectos( $_num , $param , $sql_tiempo);
      $this->create_table_afiliados($_num , $param , $sql_tiempo);
      $this->create_table_prospecto_email($_num , $param , $sql_tiempo);
      $this->create_table_email_enviados($_num , $param , $sql_tiempo_actualizacion);
      $this->create_table_contact($_num , $param , $sql_tiempo);
      $this->create_table_proyecto($_num , $param , $sql_tiempo);
      $this->create_tables_blog($_num , $param , $sql_tiempo);

      $query_get =  "select v.* , 
                            em.email_enviados ,                                        
                            r.prospectos_registrados ,
                            c.numero_contactos ,     
                            c.num_contactos_promociones,                                                 
                            po.numero_proyectos , 
                            bl.num_blogs ,
                            pt.prospectos, 
                            pt.clientes,
                            pt.prospectos_sistema ,
                            af.afiliados                                                        
                            from 
                            visitas_tmp_$_num v                                                         
                            left outer join registros_tmp_$_num r on v.fecha =  r.fecha_registro 
                            left outer join registros_email_tmp_$_num em on v.fecha =  em.fecha_actualizacion                            
                            left outer join contactos_tmp_$_num c on v.fecha =  c.fecha_registro
                            
                            left outer join proyecto_tmp_$_num po on v.fecha =  po.fecha_registro 
                            left outer join blog_tmp_$_num bl on v.fecha =  bl.fecha_registro 
                            left outer join  personas_tmp_$_num pt ON pt.fecha =  v.fecha
                            left outer join  afiliados_tmp_$_num af ON af.fecha =  v.fecha
                            ORDER BY v.fecha";

      $result = $this->db->query($query_get);               
      $data_complete =  $result->result_array();

      $this->drop_tables_repo_general($_num);
      return $data_complete;
    
    }
    /**/
    function create_tmp_productividad_correos_usuario($_num , $flag  , $param ){

      $query_drop =  "DROP TABLE IF exists tmp_correos_usuario_$_num";
      $db_response =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];
      if ($flag == 0 ){

        $query_create =  "CREATE TABLE  tmp_correos_usuario_$_num AS 
                          SELECT 
                          SUM(CASE WHEN  DATE(fecha_registro) = DATE(CURRENT_DATE()) - 1  THEN 1 ELSE 0 END  )ayer ,
                          SUM(CASE WHEN  DATE(fecha_registro) = CURRENT_DATE()  THEN 1 ELSE 0 END  )hoy 
                          FROM  prospecto 
                          WHERE 
                          id_usuario =  $id_usuario AND 
                          DATE(fecha_registro) 
                          BETWEEN DATE_ADD( CURRENT_DATE() , INTERVAL - 2 DAY    ) 
                          AND DATE(CURRENT_DATE())
                          ";


        $db_response  =  $this->db->query($query_create);
      }

      return $db_response;

    }
    /**/
    function create_tmp_productividad_sociales($_num , $flag  , $param ){

      $query_drop =  "DROP TABLE IF exists tmp_sociales_usuario_$_num";
      $db_response =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];
      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];
      if ($flag == 0 ){

        $query_create =  "CREATE TABLE  tmp_sociales_usuario_$_num AS 
                           SELECT 
                          COUNT(0) totales,
                          DATE(fecha_registro) fecha_registro , 
                          SUM(CASE WHEN tipo = 105 then 1 else 0 end )pagina_web_fb , 
                          SUM(CASE WHEN tipo = 106 then 1 else 0 end )pagina_web_mercado_libre ,
                          SUM(CASE WHEN tipo = 500 then 1 else 0 end )pagina_web_linkeding ,
                          SUM(CASE WHEN tipo = 501 then 1 else 0 end )pagina_web_twitter,
                          SUM(CASE WHEN tipo = 5010 then 1 else 0 end )pagina_web_email,
                          SUM(CASE WHEN tipo = 50100 then 1 else 0 end )pagina_web_blog,


                          SUM(CASE WHEN tipo = 107 then 1 else 0 end )google_adwords_fb,                              
                          SUM(CASE WHEN tipo = 108 then 1 else 0 end )google_adwords_ml, 
                          SUM(CASE WHEN tipo = 516 then 1 else 0 end )google_adwords_lk,                              
                          SUM(CASE WHEN tipo = 517 then 1 else 0 end )google_adwords_tw,                           
                          SUM(CASE WHEN tipo = 5011 then 1 else 0 end )google_adwords_email, 
                          SUM(CASE WHEN tipo = 50111 then 1 else 0 end )google_adwords_blog, 
                          

                          SUM(CASE WHEN tipo = 109 then 1 else 0 end )tienda_en_linea_fb, 
                          SUM(CASE WHEN tipo = 110 then 1 else 0 end )tienda_en_linea_ml,
                          SUM(CASE WHEN tipo = 510 then 1 else 0 end )tienda_en_linkeding,
                          SUM(CASE WHEN tipo = 511 then 1 else 0 end )tienda_en_twitter,
                          SUM(CASE WHEN tipo = 5012 then 1 else 0 end )tienda_en_email,
                          SUM(CASE WHEN tipo = 50121 then 1 else 0 end )tienda_en_blog,


                          SUM(CASE WHEN tipo = 111 then 1 else 0 end )crm_fb, 
                          SUM(CASE WHEN tipo = 112 then 1 else 0 end )crm_ml,                                               
                          SUM(CASE WHEN tipo = 514 then 1 else 0 end )crm_linkeding, 
                          SUM(CASE WHEN tipo = 515 then 1 else 0 end )crm_twitter, 
                          SUM(CASE WHEN tipo = 5013 then 1 else 0 end )crm_email,
                          SUM(CASE WHEN tipo = 50139 then 1 else 0 end )crm_blog


                          FROM 
                          pagina_web 
                          WHERE 
                          id_usuario =  $id_usuario
                          AND 
                          DATE(fecha_registro) 
                          BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."'
                          
                          GROUP BY DATE(fecha_registro) 
                          ORDER BY fecha_registro DESC";


        $db_response  =  $this->db->query($query_create);
      }

      return $db_response;

    }

    /**/
    function create_tmp_productividad_sociales_usuarios($_num , $flag  , $param ){

      $query_drop =  "DROP TABLE IF exists tmp_sociales_usuario_$_num";
      $db_response =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];
      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      if ($flag == 0 ){

        $query_create =  "CREATE TABLE  tmp_sociales_usuario_$_num AS 
                          SELECT 
                          COUNT(0) totales,
                          DATE(fecha_registro) fecha_registro , 
                          SUM(CASE WHEN tipo = 105 then 1 else 0 end )pagina_web_fb , 
                          SUM(CASE WHEN tipo = 106 then 1 else 0 end )pagina_web_mercado_libre ,
                          SUM(CASE WHEN tipo = 500 then 1 else 0 end )pagina_web_linkeding ,
                          SUM(CASE WHEN tipo = 501 then 1 else 0 end )pagina_web_twitter,
                          SUM(CASE WHEN tipo = 5010 then 1 else 0 end )pagina_web_email,
                          SUM(CASE WHEN tipo = 50100 then 1 else 0 end )pagina_web_blog,


                          SUM(CASE WHEN tipo = 107 then 1 else 0 end )google_adwords_fb,                              
                          SUM(CASE WHEN tipo = 108 then 1 else 0 end )google_adwords_ml, 
                          SUM(CASE WHEN tipo = 516 then 1 else 0 end )google_adwords_lk,                              
                          SUM(CASE WHEN tipo = 517 then 1 else 0 end )google_adwords_tw,                           
                          SUM(CASE WHEN tipo = 5011 then 1 else 0 end )google_adwords_email, 
                          SUM(CASE WHEN tipo = 50111 then 1 else 0 end )google_adwords_blog, 
                          

                          SUM(CASE WHEN tipo = 109 then 1 else 0 end )tienda_en_linea_fb, 
                          SUM(CASE WHEN tipo = 110 then 1 else 0 end )tienda_en_linea_ml,
                          SUM(CASE WHEN tipo = 510 then 1 else 0 end )tienda_en_linkeding,
                          SUM(CASE WHEN tipo = 511 then 1 else 0 end )tienda_en_twitter,
                          SUM(CASE WHEN tipo = 5012 then 1 else 0 end )tienda_en_email,
                          SUM(CASE WHEN tipo = 50121 then 1 else 0 end )tienda_en_blog,


                          SUM(CASE WHEN tipo = 111 then 1 else 0 end )crm_fb, 
                          SUM(CASE WHEN tipo = 112 then 1 else 0 end )crm_ml,                                               
                          SUM(CASE WHEN tipo = 514 then 1 else 0 end )crm_linkeding, 
                          SUM(CASE WHEN tipo = 515 then 1 else 0 end )crm_twitter, 
                          SUM(CASE WHEN tipo = 5013 then 1 else 0 end )crm_email,
                          SUM(CASE WHEN tipo = 50139 then 1 else 0 end )crm_blog


                          FROM 
                          pagina_web 
                          WHERE 
                          id_usuario =  $id_usuario
                          AND 
                          DATE(fecha_registro) 
                          BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."'
                          
                          GROUP BY DATE(fecha_registro) 
                          ORDER BY fecha_registro DESC
                          ";


        $db_response  =  $this->db->query($query_create);
      }

      return $db_response;

    }



    /**/
    function create_tmp_productividad_correos_por_usuario($_num , $flag  , $param ){

      $query_drop =  "DROP TABLE IF exists tmp_correos_usuario_$_num";
      $db_response =  $this->db->query($query_drop);
      $id_usuario =  $param["id_usuario"];
      $fecha_inicio =  $param["fecha_inicio"];
      $fecha_termino =  $param["fecha_termino"];

      if ($flag == 0 ){

          $query_create =  "CREATE TABLE  tmp_correos_usuario_$_num AS 
                            SELECT 
                              count(0)num_correos_registrados,
                              date(fecha_registro) fecha_registro
                            FROM  prospecto 
                            WHERE 
                             id_usuario =  $id_usuario
                            AND 
                            DATE(fecha_registro) 
                            BETWEEN '".$fecha_inicio."' AND '".$fecha_termino."'
                            GROUP BY DATE(fecha_registro)";


          $db_response  =  $this->db->query($query_create);
      }
      return $db_response;

    }

    
   

}