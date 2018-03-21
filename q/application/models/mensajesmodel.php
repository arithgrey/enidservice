<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class mensajesmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /***/
    function info_servicio($param){
        
        $q =  $param["q"];
        $modalidad =  $param["modalidad"];

        $query_get ="SELECT id_servicio , nombre_servicio  FROM servicio 
                     WHERE 
                        flag_servicio = '".$modalidad."' 
                        AND 
                        ( id_servicio ='".$q."'
                            OR 
                            nombre_servicio  like  '%".$q."%'
                        )
                     LIMIT 4";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_mensajes_destacados($param){

        $_num =  get_random();
        $this->create_tmp_mensaje(0 , $_num , $param);
            $this->create_tmp_accesos(0 , $_num , $param);
                $this->create_tmp_conteo_accesos(0 , $_num , $param);


                $query_get ="SELECT 
                                m.id_mensaje         ,
                                m.titular            ,
                                m.enlace             ,
                                m.descripcion,
                                m.red_social         ,
                                m.servicio           ,
                                m.llamada_a_la_accion,
                                m.idtipo_negocio     ,
                                a.num_accesos,
                                u.nombre , 
                                u.email , 
                                u.apellido_paterno , 
                                u.apellido_materno,
                                rs.nombre_red,
                                tn.nombre nombre_tipo_negocio

                                 FROM 
                                tmp_mensajes_$_num m
                            INNER JOIN 
                                tmp_accesos_conteo_$_num a
                            ON 
                            m.id_mensaje =  a.id_mensaje
                            INNER JOIN usuario u 
                                ON 
                                u.idusuario =  m.id_usuario 
                            INNER JOIN red_social rs    
                                ON                          
                                rs.id_red_social =  m.red_social
                                INNER JOIN tipo_negocio tn 
                                ON  
                                m.idtipo_negocio =  tn.idtipo_negocio


                                ORDER BY a.num_accesos DESC ";

                $result =  $this->db->query($query_get);
                $data_complete =  $result->result_array();

                $this->create_tmp_conteo_accesos(1 , $_num , $param);
            $this->create_tmp_accesos(1 , $_num , $param);
        $this->create_tmp_mensaje(1 , $_num , $param);

        return $data_complete;

    }
    function create_tmp_mensaje($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_mensajes_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){

            $query_create ="CREATE TABLE  
                        tmp_mensajes_$_num AS 
                        SELECT * FROM mensaje 
                        WHERE  
                        DATE(fecha_registro) 
                        BETWEEN 
                        DATE_ADD(CURRENT_DATE()  , INTERVAL - 1  WEEK ) 
                        AND 
                        DATE(CURRENT_DATE())";

                        $this->db->query($query_create);
        }   
    }
    function create_tmp_accesos_faq($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_accesos_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){

            $query_create ="CREATE TABLE  
                        tmp_accesos_$_num AS 
                        SELECT 
                        url
                         FROM pagina_web 
                        WHERE                          
                        DATE(fecha_registro) 
                        BETWEEN 
                        DATE_ADD(CURRENT_DATE()  , INTERVAL - 1  WEEK ) 
                        AND 
                        DATE(CURRENT_DATE())";
                        $this->db->query($query_create);

        }
    }
    /**/
    function create_tmp_accesos($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_accesos_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){

            $query_create ="CREATE TABLE  
                        tmp_accesos_$_num AS 
                        SELECT * FROM pagina_web 
                        WHERE                          
                        DATE(fecha_registro) 
                        BETWEEN 
                        DATE_ADD(CURRENT_DATE()  , INTERVAL - 1  WEEK ) 
                        AND 
                        DATE(CURRENT_DATE())                         
                        AND id_mensaje >0";
                        $this->db->query($query_create);

        }
    }
    /**/
    function create_tmp_conteo_accesos($flag , $_num , $param){


        $query_drop = "DROP TABLE IF exists tmp_accesos_conteo_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){

            $query_create ="CREATE TABLE  
                        tmp_accesos_conteo_$_num AS                         
                        SELECT  
                        id_mensaje,  
                        count(0)num_accesos
                        FROM tmp_accesos_$_num 
                        GROUP BY  
                        id_mensaje 
                        ";
                        $this->db->query($query_create);

        }

    }
    function create_tmp_conteo_accesos_faq($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_accesos_conteo_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){

            $query_create ="CREATE TABLE tmp_accesos_conteo_$_num 
                            AS                         
                            SELECT  
                            url,  
                            count(0)num_accesos
                            FROM tmp_accesos_$_num
                            GROUP BY  url";

                        $this->db->query($query_create);

        }

    }
    /**/
    function get_blogs_destacados($param){
        
        $_num =  get_random();        
        $this->create_tmp_faq(0 , $_num , $param);
            $this->create_tmp_accesos_faq(0 , $_num , $param);
                $this->create_tmp_conteo_accesos_faq(0 , $_num , $param);
                                

                    $query_get ="SELECT 
                                    f.*, 
                                    ac.*,
                                    u.nombre , 
                                    u.email , 
                                    u.apellido_paterno , 
                                    u.apellido_materno,
                                    c.nombre_categoria
                                 FROM  
                                    tmp_faq_$_num f
                                 INNER JOIN 
                                    tmp_accesos_conteo_$_num ac
                                 ON 
                                f.url_faq  =  ac.url
                                INNER JOIN usuario u 
                                 ON f.id_usuario = u.idusuario 
                                 INNER JOIN categoria c 
                                 ON c.id_categoria =  f.id_categoria
                                    ORDER BY ac.num_accesos DESC";                    
                    $result=  $this->db->query($query_get);


                    $data_complete =  $result->result_array();


                $this->create_tmp_conteo_accesos_faq(1 , $_num , $param);
            $this->create_tmp_faq(1 , $_num , $param);
        $this->create_tmp_accesos_faq(1 , $_num , $param);
        return $data_complete;
        
        /**/

    }
    /**/
    function create_tmp_faq($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_faq_$_num";
        $this->db->query($query_drop);

        if ($flag ==  0){

            $dominio =  $param["dominio"]; 
            $ulr_actual ="http://enidservice.com/inicio/faq/?faq=";    
            if ($dominio == "http://localhost") {
                $ulr_actual ="http://localhost/inicio/faq/?faq=";        
            }
            

            $query_create ="CREATE TABLE  
                        tmp_faq_$_num AS 
                        SELECT 
                            id_faq , 
                            titulo ,  
                            id_usuario , 
                            id_categoria, 
                            CONCAT('".$ulr_actual."' , id_faq) url_faq
                        FROM faq WHERE
                        DATE(fecha_registro) 
                        BETWEEN 
                        DATE_ADD(CURRENT_DATE()  , INTERVAL - 1  WEEK ) 
                        AND 
                        DATE(CURRENT_DATE())";

                        $this->db->query($query_create);
        }   
    }
    
    /**/
    function get_posts_usuario($param){
        
        $id_usuario = $param["id_usuario"];

        $_num =  get_random();
        $this->create_tmp_mensaje(0 , $_num , $param);
            $this->create_tmp_accesos(0 , $_num , $param);
                $this->create_tmp_conteo_accesos(0 , $_num , $param);


                $query_get ="SELECT 
                                m.id_mensaje         ,
                                m.titular            ,
                                m.enlace             ,
                                m.descripcion,
                                m.red_social         ,
                                m.servicio           ,
                                m.llamada_a_la_accion,
                                m.idtipo_negocio     ,
                                a.num_accesos,
                                u.nombre , 
                                u.email , 
                                u.apellido_paterno , 
                                u.apellido_materno,
                                rs.nombre_red,
                                tn.nombre nombre_tipo_negocio

                                 FROM 
                                tmp_mensajes_$_num m
                            INNER JOIN 
                                tmp_accesos_conteo_$_num a
                            ON 
                            m.id_mensaje =  a.id_mensaje
                            INNER JOIN usuario u 
                                ON 
                                u.idusuario =  m.id_usuario 
                            INNER JOIN red_social rs    
                                ON                          
                            rs.id_red_social =  m.red_social
                            INNER JOIN tipo_negocio tn 
                            ON  
                                m.idtipo_negocio =  tn.idtipo_negocio
                            WHERE 
                                u.idusuario = '".$id_usuario."'
                                ORDER BY a.num_accesos DESC ";

                $result =  $this->db->query($query_get);
                $data_complete =  $result->result_array();

                $this->create_tmp_conteo_accesos(1 , $_num , $param);
            $this->create_tmp_accesos(1 , $_num , $param);
        $this->create_tmp_mensaje(1 , $_num , $param);

        return $data_complete;
    }
    /**/

   
}