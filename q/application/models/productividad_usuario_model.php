<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class productividad_usuario_model extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();

    }
    function insert( $params , $return_id=0){        
      $insert   = $this->db->insert($tabla, $params);     
      return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
    private function get( $params=[], $params_where =[] , $limit =1){
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        return $this->db->get($table)->result_array();
    }

    function valoraciones_sin_leer($param){
        $id_usuario =  $param["id_usuario"];
        $query_get ="
            SELECT 
                COUNT(0)num
            FROM 
                servicio s 
            INNER JOIN  
                valoracion v
            ON 
                s.id_servicio =  v.id_servicio
            WHERE 
                s.id_usuario = $id_usuario
            AND
                leido_vendedor =0";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }   


    function get_adeudo_cliente($param){

        $id_usuario =  $param["id_usuario"];        
        $query_get="SELECT 
                    (ppf.monto_a_pagar * ppf.num_ciclos_contratados )+ costo_envio_cliente as  saldo_pendiente,
                    ppf.saldo_cubierto, 
                    ppfd.id_direccion
                    FROM 
                    proyecto_persona_forma_pago 
                    ppf                         
                    LEFT OUTER JOIN 
                    proyecto_persona_forma_pago_direccion  ppfd 
                    ON 
                    ppf.id_proyecto_persona_forma_pago =  ppfd.id_proyecto_persona_forma_pago
                    WHERE 
                    ppf.id_usuario = $id_usuario
                    AND 
                    ppf.monto_a_pagar  > ppf.saldo_cubierto
                    AND se_cancela != 1";


        $result =  $this->db->query($query_get);        
        $data_complete=  $result->result_array();         

        $total_deuda =0; 
        $direciones_pendientes =0;
        foreach ($data_complete as $row){
            
            $saldo_pendiente = $row["saldo_pendiente"];
            $saldo_cubierto = $row["saldo_cubierto"];
            if ($row["id_direccion"] ==  null ){
                $direciones_pendientes ++;
            }
            $deuda =  $saldo_pendiente - $saldo_cubierto; 
            $total_deuda =  $total_deuda + $deuda;
        }
        $data_complete_response["total_deuda"] =  $total_deuda;
        $data_complete_response["sin_direcciones"] =  $direciones_pendientes;
        return $data_complete_response;
    }    
 
     function tareas_enid_service(){
            
       
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
    
    function get_notificaciones_usuario_perfil($param){

        $id_perfil                              =   $this->get_perfil_usuario($param);        
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