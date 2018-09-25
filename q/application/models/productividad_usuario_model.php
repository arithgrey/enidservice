<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class productividad_usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    
    function get_notificaciones_usuario_perfil($param){

        $id_perfil                              =   $param["id_perfil"];
        $data_complete["perfil"]                =   $id_perfil;
        $param["id_perfil"]                     =   $id_perfil;
        
        $data_complete["id_usuario"]            =  $param["id_usuario"]; 
        $data_complete["adeudos_cliente"]       = $this->get_adeudo_cliente($param);
        $data_complete["valoraciones_sin_leer"] = $this->valoraciones_sin_leer($param);    
        $data_complete["id_perfil"]             = $id_perfil;
        switch ($id_perfil){
            case 3:            
                                
                
                
                
                $data_complete["email_enviados_enid_service"] = 
                $this->email_enviados_enid_service();                

                $data_complete["accesos_enid_service"] = 
                $this->accesos_enid_service();                

                $data_complete["tareas_enid_service"] = 
                $this->tareas_enid_service()[0]["num_pendientes_desarrollo"];

                $data_complete["num_pendientes_direccion"] = 
                $this->tareas_enid_service()[0]["num_pendientes_direccion"];        
                                
            break;
            
         case 4:            
                
                

                $data_complete["email_enviados_enid_service"] = 
                $this->email_enviados_enid_service();

                $data_complete["accesos_enid_service"] = 
                $this->accesos_enid_service();                
                $data_complete["tareas_enid_service"] = 
                $this->tareas_enid_service()[0]["num_pendientes_desarrollo"];                
                

            break;

            default:
                
                break;
        }
        return $data_complete;
    }
    
    /*
    
    
    
    
    
    function ventas_enid_service_vendedor($param){   
        

        
        $id_usuario=  $param["id_usuario"];
        $query_get ="SELECT
                        count(0)num_ventas 
                    FROM 
                        persona 
                    WHERE
                        tipo =2 
                    AND 
                        fecha_cambio_tipo =  current_date()

                    AND id_usuario = $id_usuario";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_ventas"];
 
    }
    

    
    
    
    function email_enviados_usuario_enid_service($param){
        
        $query_get = "SELECT 
                            count(0)num_envios 
                        FROM  
                        prospecto
                        WHERE  
                            date(fecha_actualizacion) = date(current_date())
                        AND 
                        id_usuario = '".$param["id_usuario"]."' ";
        
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_envios"];
 
    }
    
    function llamadas_enid_service(){
      
        $query_get = "SELECT 
                    count(0)num_llamadas 
                    FROM
                    base_telefonica 
                    WHERE 
                    date(fecha_modificacion) =  date(current_date())";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_llamadas"];
             
    }
    
    function llamadas_enid_service_usuario($param){
        
        $id_usuario =  $param["id_usuario"];
        
        $query_get = "SELECT 
                    count(0)num_llamadas 
                    FROM
                        base_telefonica 
                    WHERE 
                        date(fecha_modificacion) =  date(current_date())
                    AND 
                        id_usuario = '".$id_usuario."' ";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_llamadas"];
             
    }
    
    function contactos_enid_service(){   
        
        $query_get ="SELECT
                        count(0)num_ventas 
                    FROM persona 
                    WHERE
                    tipo = 1 
                        AND 
                    date(fecha_registro) =  current_date()";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_ventas"];
 
    }  
    
    function contactos_enid_usuario($param){
        
        
        $id_usuario = $param["id_usuario"];

        $query_get ="SELECT
                        count(0)num 
                    FROM 
                        persona 
                    WHERE
                        tipo = 1 
                        AND 
                    date(fecha_registro) =  current_date()
                    AND id_usuario ='". $id_usuario."' ";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }
    
    function contactos_enid_promociones($param){
        
        
        $id_usuario = $param["id_usuario"];

        $query_get ="SELECT
                        count(0)num 
                    FROM 
                        persona 
                    WHERE
                        tipo = 12 
                        AND 
                    date(fecha_registro) =  current_date()
                    AND id_usuario ='". $id_usuario."' ";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num"];

    }
    
      
    
    function blogs_enid_service(){
        
        $query_get ="SELECT
                        COUNT(0)num_blogs
                    FROM 
                        faq
                    WHERE  
                    date(fecha_registro) 
                    =  
                    date(current_date())";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_blogs"]; 
    }

    
   
    function correos_electronicos(){
        
        $query_get ="SELECT 
                    count(0)num_correos_pendientes 
                    FROM   
                    prospecto WHERE 
                    date(fecha_registro) =  date(current_date())";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_correos_pendientes"];
    }
    
    
    
    
    */

}