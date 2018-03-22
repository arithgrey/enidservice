<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class productividad_usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
    /**/
    function get_notificaciones_usuario_perfil($param){

        /**/    
        $id_perfil =   $this->get_perfil_usuario($param);        
        $data_complete["perfil"] = $id_perfil;
        $param["id_perfil"] = $id_perfil;
        /**/
        $data_complete["objetivos_perfil"] =  $this->get_objetivos_perfil($param);

        switch ($id_perfil){
            case 3:            
                /**/                                  
                $data_complete["ventas_enid_service"]= $this->ventas_enid_service();                
                $data_complete["envios_a_validar_enid_service"] = 
                $this->envios_a_validar_enid_service();                
                $data_complete["email_enviados_enid_service"] = $this->email_enviados_enid_service();                
                $data_complete["accesos_enid_service"] = $this->accesos_enid_service();                
                $data_complete["tareas_enid_service"] = 
                $this->tareas_enid_service()[0]["num_pendientes_desarrollo"];    
                /**/                    
                
                $data_complete["num_pendientes_direccion"] = 
                $this->tareas_enid_service()[0]["num_pendientes_direccion"];        
                                
            break;
            
         case 4:            
                
                $data_complete["ventas_enid_service"]= $this->ventas_enid_service();                
                $data_complete["envios_a_validar_enid_service"] = $this->envios_a_validar_enid_service();
                $data_complete["email_enviados_enid_service"] = $this->email_enviados_enid_service();
                $data_complete["accesos_enid_service"] = $this->accesos_enid_service();                
                $data_complete["tareas_enid_service"] = 
                $this->tareas_enid_service()[0]["num_pendientes_desarrollo"];                
                

            break;


            case 5:            
                /**/    
                $data_complete["correos_registrados_enid_service"] = 
                $this->correos_electronicos();  
            break;


            case 6:            
                /**/
                
                $data_complete["ventas_usuario"] = $this->ventas_enid_service_vendedor($param);  
                $data_complete["contactos_promociones_enid_service"] = 
                $this->contactos_enid_promociones($param);

                $data_complete["email_enviados_enid_service"] =  $this->email_enviados_usuario_enid_service($param);
                

            break;

            case 20:                                                
                $data_complete["adeudos_cliente"] = $this->get_adeudo_cliente($param);

            break;

            default:
                
                break;
        }
        return $data_complete;
    }
    /**/
    /**/
    function get_objetivos_perfil($param){
        
        $query_get ="SELECT * FROM  objetivo WHERE id_perfil = '".$param["id_perfil"]."' ";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_perfil_usuario($param){
            
        $id_usuario = $param["id_usuario"];    
        
        $query_get = "SELECT idperfil from usuario_perfil 
                      WHERE 
                      idusuario = '".$id_usuario."'
                      LIMIT 1";    

        $result = $this->db->query($query_get);
        return $result->result_array()[0]["idperfil"];
    }
    /**/
    function ventas_enid_service(){   
        
        $query_get ="SELECT
                        count(0)num_ventas 
                    FROM persona 
                    WHERE
                    tipo =2 
                        AND 
                    fecha_cambio_tipo =  current_date()";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_ventas"];
 
    }
    /**/
    function ventas_enid_service_vendedor($param){   
        

        /**/
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
    

    /**/
    function envios_a_validar_enid_service(){   
        
        $query_get ="SELECT
                        count(0)num_ventas 
                    FROM persona 
                    WHERE
                    tipo = 4 
                        AND 
                    fecha_cambio_tipo =  current_date()";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_ventas"];
 
    }   
    /**/    
    function email_enviados_enid_service(){
        
        $query_get = "SELECT 
                        count(0)num_envios 
                      FROM  
                        prospecto
                    WHERE                      
                    date(fecha_actualizacion) = date(current_date())";
        
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_envios"];
 
    }
    /**/
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
    /**/
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
    /**/
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
    /**/
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
    /**/
    function contactos_enid_usuario($param){
        
        /**/
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
    /**/
    function contactos_enid_promociones($param){
        
        /**/
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
    /**/
    function accesos_enid_service(){   
        
        $query_get ="SELECT
                        COUNT(0)num_accesos 
                    FROM 
                        pagina_web 
                    WHERE  
                    date(fecha_registro) =  date(current_date())";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_accesos"];
 
    }  
    /**/
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

    /**/
    function tareas_enid_service(){
            
        /*
        $query_get ="SELECT  
                        SUM(CASE 
                        WHEN 
                        tt.id_departamento = 1 
                        THEN 1 ELSE 0 END )num_pendientes_desarrollo,                        


                        SUM(CASE 
                                WHEN 
                                tt.id_departamento = 2 
                                THEN 1 ELSE 0 END )num_pendientes_ventas ,                       

                        SUM(CASE 
                        WHEN 
                        tt.id_departamento = 3 
                        THEN 1 ELSE 0 END )num_pendientes_marketing  ,

                        SUM(CASE 
                        WHEN 
                        tt.id_departamento = 4 
                        THEN 1 ELSE 0 END )num_pendientes_direccion                        

                    FROM 
                        tarea t
                    INNER JOIN
                        ticket tt 
                    ON 
                    t.id_ticket = tt.id_ticket    
                    WHERE  
                        t.status = 1                         
                    AND 
                    date(t.fecha_termino) =  date(current_timestamp())";
    
        */
                $query_get ="SELECT  
                        SUM(CASE 
                        WHEN 
                        tt.id_departamento = 1 
                        THEN 1 ELSE 0 END )num_pendientes_desarrollo,                        

                        SUM(CASE 
                                WHEN 
                                tt.id_departamento = 2 
                                THEN 1 ELSE 0 END )num_pendientes_ventas ,                       
                        
                        SUM(CASE 
                        WHEN 
                        tt.id_departamento = 4 
                        THEN 1 ELSE 0 END )num_pendientes_direccion                        

                    FROM 
                        tarea t
                    INNER JOIN
                        ticket tt 
                    ON 
                    t.id_ticket = tt.id_ticket    
                    WHERE  
                        t.status = 1                         
                    AND 
                    date(t.fecha_termino) =  date(current_timestamp())";
        $result =  $this->db->query($query_get);
        return $result->result_array();

           

    }
    /**/
    function correos_electronicos(){
        
        $query_get ="SELECT 
                    count(0)num_correos_pendientes 
                    FROM   
                    prospecto WHERE 
                    date(fecha_registro) =  date(current_date())";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_correos_pendientes"];
    }
    /**/
    function get_adeudo_cliente($param){

        $id_usuario =  $param["id_usuario"];        
        $saldo_pendiente =  $this->get_saldo_pendiente_por_persona($id_usuario);    
        return $saldo_pendiente;
        
    }    
    /**/
    function get_saldo_pendiente_por_persona($id_usuario){

            $query_get="SELECT                         
                            ppf.monto_a_pagar,
                            ppf.saldo_cubierto, 
                            ppf.flag_envio_gratis 
                                    
                        FROM  
                            proyecto_persona_forma_pago ppf 
                        INNER JOIN 
                            proyecto_persona pp 
                        ON 
                            ppf.id_proyecto_persona =  pp.id_proyecto_persona   
                        WHERE 
                        pp.id_usuario = $id_usuario";

        $result =  $this->db->query($query_get);        
        $saldo_pendiente =  $result->result_array();        
        return $this->crea_saldo_pendiente($saldo_pendiente);
    }   
    /**/
    function crea_saldo_pendiente($saldo_pendiente){
        
        $total =  0;
        /**/
        foreach($saldo_pendiente as $row){
                
                $monto_a_pagar =  $row["monto_a_pagar"];
                $saldo_cubierto =  $row["saldo_cubierto"];
                $flag_envio_gratis =  $row["flag_envio_gratis"];


                if ($flag_envio_gratis ==  1) {
                    $nuevo_saldo = $monto_a_pagar - $saldo_cubierto;    
                    $total =  $total + $nuevo_saldo;
                }else{
                    $nuevo_saldo = $monto_a_pagar - $saldo_cubierto;    
                    $total =  $total + $nuevo_saldo + 100;
                }
                
                
        }
        return $total;
    }

    /**/
}