<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class afiliados_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function create_tmp_accesos_periodo($flag , $_num, $param){

       /**/
      $query_drop ="DROP TABLE IF exists tmp_paginas_web_$_num";
      $this->db->query($query_drop);
      if($flag ==0 ){
            
          $fecha_inicio = $param["fecha_inicio"];
          $fecha_termino = $param["fecha_termino"];

          $query_create ="CREATE TABLE tmp_paginas_web_$_num AS 
                    SELECT 
                    id_usuario ,
                    COUNT(0)num_accesos
                    FROM 
                    pagina_web 
                    WHERE 
                    DATE(fecha_registro) 
                    BETWEEN
                    '".$fecha_inicio."' 
                      AND 
                    '".$fecha_termino."' 
                    GROUP BY id_usuario";
                    $this->db->query($query_create);
                    
      }

    }  
    /**/
    function create_accesos_afiliados( $flag , $_num , $param){

       /**/
      $query_drop ="DROP TABLE IF exists accesos_afiliados_$_num";
      $this->db->query($query_drop);
      if($flag ==0 ){
      
        $query_create = "CREATE TABLE accesos_afiliados_$_num
                          SELECT 
                            ua.*
                          FROM 
                            tmp_paginas_web_$_num  ua 
                          INNER JOIN 
                          tmp_usuario_perfil_$_num a
                          ON 
                          ua.id_usuario =  a.idusuario";
                          $this->db->query($query_create);
      }

    }
    /**/
    

    /**/
    function get_usuarios_productivos($param){
      
      $_num =  get_random();
      $this->create_tmp_afiliados(0 , $_num,  $param);
        /**/
        $this->create_tmp_accesos_periodo(0 , $_num , $param);          
          $this->create_accesos_afiliados( 0 , $_num , $param);
          
          /**/
          $query_get ="SELECT * FROM accesos_afiliados_$_num ORDER BY num_accesos DESC";
          $result =  $this->db->query($query_get);
          $usuarios_accesos= $result->result_array();
          /**/
          $data_complete = $this->get_usuarios_acessos_info($usuarios_accesos);
          $this->create_accesos_afiliados( 1 , $_num , $param);
          /**/
        $this->create_tmp_accesos_periodo(1 , $_num , $param);
      $this->create_tmp_afiliados(1 , $_num,  $param);
      return $data_complete; 
    }
    /**/
    function get_usuarios_acessos_info($data){

      $nueva_data = [];
      $z = 0;
      foreach ($data as $row) {
        
        $id_usuario =  $row["id_usuario"];
        $num_accesos=  $row["num_accesos"];

        $nueva_data[$z] = $this->get_info_usuario($id_usuario , $num_accesos);
        $z ++;
      }
      return $nueva_data;

    }
    /**/
    function get_info_usuario($id_usuario , $num_accesos){

      $query_get = "SELECT 
                    idusuario    
                    ,nombre       
                    ,email        
                    ,apellido_paterno   
                    ,apellido_materno   
                    ,email_alterno 
                    ,tel_contacto
                    ,'".$num_accesos."' num_accesos
                    
                    FROM 
                      usuario 
                    WHERE 
                    idusuario = $id_usuario LIMIT 1";

              $result=  $this->db->query($query_get); 
              $data =  $result->result_array();
              return $this->get_data_usuario($data);
            
    }
    /**/
    function get_data_usuario($data){

      $nueva_data =[];
      foreach ($data as $row){


        
        $nueva_data  = array(
          "id_usuario" => $row["idusuario"], 
          "nombre" =>  $row["nombre"], 
          "email" => $row["email"], 
          "apellido_paterno" =>  $row["apellido_paterno"], 
          "apellido_materno" =>  $row["apellido_materno"],         
          "num_accesos" =>  $row["num_accesos"],
          "tel_contacto" => $row["tel_contacto"]
        );
        

      }
      return $nueva_data;

    }
    /**/
    function get_pendiente_asesoria($param){
        $_num =  get_random();
        $this->create_tmp_afiliados(0 , $_num,  $param);
          $this->create_tmp_usuarios_afiliados(0 , $_num, $param);
          $query_get ="SELECT * FROM tmp_usuarios_afiliados_$_num";
          $result  = $this->db->query($query_get);
          $data =  $result->result_array();
          $this->create_tmp_usuarios_afiliados(1 , $_num, $param);
        $this->create_tmp_afiliados(1 , $_num,  $param);
      return $data;   
    }

    /**/
    function create_tmp_usuarios_afiliados($flag , $_num, $param){

      $query_drop ="DROP TABLE IF exists tmp_usuarios_afiliados_$_num";
      $this->db->query($query_drop);

      if($flag ==0 ){
          
          $query_create ="CREATE TABLE tmp_usuarios_afiliados_$_num AS 
                          SELECT 
                            u.idusuario             ,
                            u.nombre                ,
                            u.email                 ,
                            u.apellido_paterno      ,
                            u.apellido_materno      ,
                            u.tel_contacto                                   
                           FROM 
                            tmp_usuario_perfil_$_num
                              up 
                            INNER JOIN 
                              usuario u 
                            ON 
                              up.idusuario =  u.idusuario
                              WHERE 
                              u.status =1";
                    $this->db->query($query_create);
      }
      
    }
    /**/
    function create_tmp_afiliados($flag , $_num,  $param){

      /**/
      $query_drop ="DROP TABLE IF exists tmp_usuario_perfil_$_num";
      $this->db->query($query_drop);

      if($flag ==0 ){
          
          $query_create ="CREATE TABLE tmp_usuario_perfil_$_num AS 
                    SELECT idusuario FROM usuario_perfil 
                    WHERE idperfil = 19";

                    $this->db->query($query_create);
      }
    }    
    /**/
    /**/
    function get_estatus_enid_service(){

      $query_get = "SELECT * FROM status_enid_service";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function get_resumen_ventas($param){

        $_num =  get_random();
        $this->create_table_proyecto_persona_tmp($_num , 0 , $param);
          $this->create_tmp_persona_compra($_num , 0 , $param);            
          
            $this->create_tmp_pedido($_num , 0 , $param);
            
            
              $query_get ="SELECT 
                            p.*, 
                            ped.*,
                            s.nombre estatus_compra
                           FROM tmp_persona_compra_$_num p
                            INNER JOIN tmp_pedido_$_num ped 
                              ON p.id_proyecto_persona = ped.id_proyecto_persona
                            INNER JOIN
                              status_enid_service s 
                            ON 
                            ped.status_compra = s.id_estatus_enid_service";

              $result = $this->db->query($query_get);          
              $data_complete =  $result->result_array();
            
            $this->create_tmp_pedido($_num , 1 , $param);
          
          
          $this->create_tmp_persona_compra($_num , 1 , $param);
        $this->create_table_proyecto_persona_tmp($_num , 1 , $param);
        return $data_complete;
        

    }
    /**/
    function create_tmp_pedido($_num , $flag , $param){
        
        $query_drop ="DROP TABLE IF exists tmp_pedido_$_num";
        $this->db->query($query_drop);
        $id_usuario =  $param["id_usuario"];

        if ($flag == 0){        

                  $query_create ="CREATE TABLE tmp_pedido_$_num 
                                  AS 
                                  SELECT  
                                    pp.precio , 
                                    pp.costo , 
                                    ppfp.monto_a_pagar , 
                                    ppfp.saldo_cubierto ,  
                                    ppfp.num_email_recordatorio , 
                                    ppfp.status status_compra ,
                                    ppfp.id_proyecto_persona_forma_pago , 
                                    pp.id_proyecto_persona ,
                                    ppfp.fecha_registro fecha_solicitud                                    
                                  FROM  
                                    proyecto_persona_forma_pago ppfp
                                  INNER JOIN
                                    tmp_proyecto_persona_usuario_venta_$_num pp
                                  ON ppfp.id_proyecto_persona = pp.id_proyecto_persona
                                  WHERE 
                                  ppfp.saldo_cubierto <  ppfp.monto_a_pagar";                  
                  $this->db->query($query_create);  

        }

      

    }

    /**/
    function create_tmp_persona_compra($_num , $flag , $param){

        $query_drop ="DROP TABLE IF exists tmp_persona_compra_$_num";
        $this->db->query($query_drop);
        $id_usuario =  $param["id_usuario"];

        $sql_tiempo ="";

        if ($flag ==  0 ){        

                  $query_create ="CREATE TABLE tmp_persona_compra_$_num AS 
                                  SELECT 
                                      u.idusuario id_usuario ,
                                      u.nombre    ,
                                      u.apellido_paterno ,
                                      u.apellido_materno ,
                                      pp.id_proyecto_persona
                                    FROM 
                                      usuario u 
                                    INNER JOIN 
                                      tmp_proyecto_persona_usuario_venta_$_num pp
                                    ON 
                                    u.idusuario = pp.id_usuario_referencia";                  
                  $this->db->query($query_create);  

        }

      
    }
    /**/
    function create_table_proyecto_persona_tmp($_num , $flag , $param){

        $query_drop ="DROP TABLE IF exists tmp_proyecto_persona_usuario_venta_$_num";
        $this->db->query($query_drop);
        $id_usuario =  $param["id_usuario"];
        /**/
        $sql_tiempo = "";
        if ($flag ==  0 ){        

                  $query_create ="CREATE TABLE tmp_proyecto_persona_usuario_venta_$_num AS 
                                  SELECT 
                                    pp.id_proyecto , 
                                    pp.id_usuario , 
                                    pp.id_proyecto_persona ,
                                    pp.id_usuario_referencia, 
                                    pp.precio ,
                                    pp.costo 
                                  FROM 
                                  proyecto_persona pp 
                                  WHERE 
                                    id_usuario_referencia = $id_usuario";                  
                  $this->db->query($query_create);  
        }

    }
    /**/
    function get_reporte_global($param){

      $_num =  get_random();
      
      $this->create_table_accesos_por_afiliado($_num , 0 , $param);                
          /*Creamos tabla de usuarios registrados por referencia */
          $this->create_table_usuarios_referencia($_num , 0 , $param);
            $this->create_table_ordenes_por_afiliado($_num , 0 , $param);
          
            $query_get ="SELECT 
                        a.num_accesos , 
                        ur.num_usuarios_referencia,
                        pp.*
                      FROM tmp_accesos_$_num 
                        a 
                      LEFT OUTER JOIN 
                        tmp_usuarios_referidos_$_num ur
                      ON a.id_usuario = ur.id_usuario_referencia
                      LEFT OUTER JOIN tmp_compras_solicitadas_$_num pp 
                      ON a.id_usuario = pp.id_usuario_referencia";
            $result =  $this->db->query($query_get);


          $data_complete=    $result->result_array();        
          $this->create_table_ordenes_por_afiliado($_num , 1 , $param);
        $this->create_table_usuarios_referencia($_num , 1 , $param);
      $this->create_table_accesos_por_afiliado($_num , 1 , $param);
      return  $data_complete;

    }
    /*select id_usuario_referencia from proyecto_persona;*/
    /**/
    function create_table_ordenes_por_afiliado($_num , $flag , $param){

        /**/
        $query_drop ="DROP TABLE IF exists tmp_proyecto_persona_$_num";
        $this->db->query($query_drop);
        /**/
        $query_drop ="DROP TABLE IF exists tmp_compras_solicitadas_$_num";
        $this->db->query($query_drop);
        

        /**/  
        $id_usuario =  $param["id_usuario"];
        if ($flag ==  0 ) {
          
            $query_get ="CREATE TABLE tmp_proyecto_persona_$_num
                          AS
                          SELECT 
                            fecha_registro ,
                            status ,
                            id_usuario_referencia                             
                          FROM  
                            proyecto_persona_forma_pago 
                          WHERE 
                          id_usuario_referencia = $id_usuario";  
                        $this->db->query($query_get);  


                        $query_get ="CREATE TABLE tmp_compras_solicitadas_$_num
                          AS
                          SELECT                                                         
                            SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END)num_proceso_compra,
                            SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END)venta_efectiva,
                            id_usuario_referencia  
                          FROM  
                            tmp_proyecto_persona_$_num
                          WHERE 
                            fecha_registro
                          BETWEEN 
                            DATE_ADD(CURRENT_DATE()  , INTERVAL - 1 MONTH ) 
                            AND 
                            DATE_ADD(CURRENT_DATE()  , INTERVAL 1 DAY )
                            GROUP BY id_usuario_referencia";  
                        $this->db->query($query_get);  


           }
        
        /**/
    }

    /**/
    function create_table_accesos_por_afiliado($_num , $flag , $param){

        /**/
        $query_drop ="DROP TABLE IF exists tmp_accesos_por_usuario_$_num";
        $this->db->query($query_drop);
        /**/
        $query_drop ="DROP TABLE IF exists tmp_accesos_$_num";
        $this->db->query($query_drop);        
        /**/  
        $id_usuario =  $param["id_usuario"];
        if ($flag ==  0 ) {
          
            $query_get ="CREATE TABLE tmp_accesos_por_usuario_$_num
                          AS
                          SELECT 
                            fecha_registro ,
                            id_usuario  
                          FROM  
                            pagina_web 
                          WHERE 
                            id_usuario = $id_usuario";  
                        $this->db->query($query_get);  


                        $query_get ="CREATE TABLE tmp_accesos_$_num
                          AS
                          SELECT 
                          COUNT(0)num_accesos,
                          id_usuario
                          FROM  
                          tmp_accesos_por_usuario_$_num
                          WHERE 
                          fecha_registro
                          BETWEEN 
                            DATE_ADD(CURRENT_DATE()  , INTERVAL - 1 MONTH ) 
                            AND 
                            DATE_ADD(CURRENT_DATE()  , INTERVAL 1 DAY )
                          GROUP BY id_usuario";  
                        $this->db->query($query_get);  


           }
        
        /**/
    }
    /**/


     function create_table_usuarios_referencia($_num , $flag , $param){

        /**/
        $query_drop ="DROP TABLE IF exists tmp_usuarios_referencia_$_num";
        $this->db->query($query_drop);
        /**/
        $query_drop ="DROP TABLE IF exists tmp_usuarios_referidos_$_num";
        $this->db->query($query_drop);
        

        
        $id_usuario =  $param["id_usuario"];
        if ($flag ==  0 ) {
          
            $query_get ="CREATE TABLE tmp_usuarios_referencia_$_num
                          AS
                          SELECT 
                            fecha_registro,
                            id_usuario_referencia
                          FROM 
                          usuario 
                          WHERE 
                          id_usuario_referencia = $id_usuario";  
                        $this->db->query($query_get);  





              $query_get ="CREATE TABLE tmp_usuarios_referidos_$_num
                          AS
                          SELECT 
                            COUNT(0)num_usuarios_referencia ,
                            id_usuario_referencia                       
                          FROM  
                            tmp_usuarios_referencia_$_num
                          WHERE 
                          fecha_registro
                          BETWEEN 
                            DATE_ADD(CURRENT_DATE()  , INTERVAL - 1 MONTH ) 
                            AND 
                            DATE_ADD(CURRENT_DATE()  , INTERVAL 1 DAY )
                            GROUP BY id_usuario_referencia";  
                        $this->db->query($query_get);  


           }
        
        /**/
    }





    
}