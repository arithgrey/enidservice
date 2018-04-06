<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class enidmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function telefono_usuario($param){

        $id_usuario=  $param["id_usuario"];
        $telefono =  $param["telefono"];
        $lada =  $param["lada"];
        $query_update ="UPDATE usuario  
                        SET 
                            tel_contacto = '".$telefono."'  ,
                            tel_lada = '".$lada."'

                        WHERE 
                        idusuario = $id_usuario 
                        LIMIT 1";

        return $this->db->query($query_update);

    }
    /**/
    function nombre_usuario($param){
      
        $id_usuario=  $param["id_usuario"];
        $nombre_usuario =  $param["nombre_usuario"];
        $query_update ="UPDATE usuario  
                        SET nombre_usuario = '".$nombre_usuario."' 
                        WHERE 
                        idusuario = $id_usuario
                        LIMIT 1";

        return $this->db->query($query_update);

    }
    /**/
    function registra_lectura_email($param){
        $servicio =  $param["servicio"];
        $query_insert ="INSERT INTO email_leido(servicio) values('".$servicio."')";
        return $this->db->query($query_insert);
    }
    /**/
    function get_registros_disponibles($param){
      
      $limit=  $param["limit"];
      $query_get = "SELECT email FROM prospecto 
                    WHERE 
                    n_tocado < 2
                    ORDER BY fecha_registro DESC                  
                    LIMIT $limit";

      $result = $this->db->query($query_get);
      return $result->result_array();
            
    }
    function get_sql_update($param , $email){

        $query_update = "UPDATE 
                            prospecto 
                        SET 
                            n_tocado = 1  , 
                            fecha_actualizacion =  CURRENT_TIMESTAMP() 
                        WHERE 
                            email = '". trim( strtolower($email)) . "' LIMIT 1";

                     
        return $query_update;                
    }
    /**/
    function actualiza_contactos($param){

        $lista_correos = $param["lista_correos"];                        
        $query_update = "";     
        $flag = 0;                    
        $id_usuario =  $param["id_usuario"];
        for ($i=0; $i < count($lista_correos); $i++){                  

                $email =  trim( strtolower($lista_correos[$i]));  
                $query_update = "UPDATE 
                                    prospecto 
                                SET 
                                    n_tocado = n_tocado +1  , 
                                    id_usuario_ultimo_toque = '".$id_usuario."' , 
                                    fecha_actualizacion =  CURRENT_TIMESTAMP() 
                                WHERE 
                                    email = '".$email. "' LIMIT 1";
                $this->db->query($query_update);
                $flag ++;
                /**/                
        }            
        return "Email registrados como enviados ".$flag;

    }
    /**/
    function actualiza_contacto($param){
        
        $correo =  $param["correo"];
        $query_insert = $this->get_sql_update($param , $correo);
        return $this->db->query($query_insert);    
    }
    /**/
    function registra_prospecto($param){
        
        
        $id_usuario =  $param["id_usuario"];               
        $red_social =  $param["red_social"];
        $estado_republica = $param["estado_republica"];
        $tipo_negocio =  $param["tipo_negocio"];
        $tipo_servicio = $param["tipo_servicio"];
        $id_base_prospecto =  $param["id_base_prospecto"];
        /**/
        $lista_correos=  $param["lista_correos"];  
        $flag = 0;    

        $query_insert = "";
        $num_correos_insert = 0;    

        $v =0; 
        foreach ($lista_correos as $row) {
        
            $correo =  $row;  
                $query_insert = " INSERT IGNORE INTO prospecto(
                                      email ,                           
                                      idtipo_prospecto , 
                                      id_usuario , 
                                      red , 
                                      estado_republica,
                                      tipo_negocio , 
                                      tipo_servicio 

                                   )VALUES(
                                      '".$correo."' ,                                   
                                      '1' , 
                                      '".$id_usuario."' , 
                                      '$red_social' ,
                                      '$estado_republica' , 
                                      '$tipo_negocio',
                                      '$tipo_servicio'
                                   ); ";     

                $result = $db_response =  $this->db->query($query_insert);                                          
                if ($result ==  true ) {
                    $num_correos_insert ++;
                }
                
        }
       
    
        return $num_correos_insert;
    }
    /**/
    function get_num_correos_por_usuario_dia($param){

        $id_usuario = $param["id_usuario"];
        $query_get = "SELECT 
                            COUNT(*)num_envios 
                        FROM 
                            prospecto 
                        WHERE 
                            id_usuario_ultimo_toque='".$id_usuario."' 
                            AND 
                        DATE(fecha_actualizacion)= DATE(CURRENT_DATE())";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_envios"];
    }
    /**/
    function get_registros_email($param){


        /**/

        $id_usuario =  $param["id_usuario"]; 
        $query_get ="SELECT 
                    SUM(CASE WHEN DATE(fecha_registro) = DATE_ADD(CURRENT_DATE() , INTERVAL - 1 DAY ) THEN 1 ELSE 0 END   ) ayer,
                    SUM(CASE WHEN DATE(fecha_registro) = DATE(CURRENT_DATE()) THEN 1 ELSE 0 END   ) hoy
                    FROM prospecto WHERE 
                    id_usuario =  '".$id_usuario."' AND 
                    DATE(fecha_registro) 
                    BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 DAY ) 
                    AND  DATE(CURRENT_DATE())";
        
        $result  =  $this->db->query($query_get);
        return $result->result_array();
        
    }
    /**/
    function get_registros($param){
        $fecha =  $param["fecha"];

        $query_get ="SELECT 
                    email 
                    FROM prospecto WHERE 
                    DATE(fecha_registro) = '".$fecha."'";
        
        $result  =  $this->db->query($query_get);
        return $result->result_array();
           
    }
    /**/
    function get_enviados($param){

        /**/
        $fecha =  $param["fecha"];
        $query_get ="SELECT 
                    email_prospecto email 
                    FROM 
                    email_prospecto
                    WHERE 
                    DATE(fecha_registro) = '".$fecha."'";
        
        $result  =  $this->db->query($query_get);
        return $result->result_array();

    }
}