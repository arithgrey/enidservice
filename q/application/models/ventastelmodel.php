<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class ventastelmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function servicios_disponibles($param){
    
        $query_get ="SELECT nombre_servicio , id_servicio 
                    FROM servicio WHERE status = 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }

    /**/
    function get_porcentajes_ganancias_plan(){
    
        $query_get =   "SELECT  
                            id_servicio,               
                            nombre_servicio ,       
                            descripcion ,              
                            porcentaje_ganancia_venta 
                        FROM  
                        servicio WHERE status = 1";

        $result =  $this->db->query($query_get);
        return $result->result_array();                        
    }
    /**/
    function get_tipo_negocio_q($param){

        $q =  $param["q"];         
        $query_get = "SELECT * FROM tipo_negocio WHERE nombre like '".$q."%'  LIMIT 10";   
        $result =  $this->db->query($query_get);
        return $result->result_array();
        
    }
    /**/
    function get_tipos_negocios($param){

        $q =  $param["q"];         
        $query_get = "SELECT * FROM tipo_negocio WHERE nombre = '".$q."'  LIMIT 1";   
        $result =  $this->db->query($query_get);
        
        $resultados =   $result->result_array();

        if (count($resultados) > 0 ){
            return $resultados;
        }else{
            
            /*Se carga nuevo tipo de negocio*/
            $query_insert = "INSERT INTO tipo_negocio(nombre) VALUES('".$q."')";   
            $result =  $this->db->query($query_insert);
            
            /*Se regresa el tipo de negocio*/
            $query_get = "SELECT * FROM tipo_negocio WHERE nombre = '".$q."'  LIMIT 1";   
            $result =  $this->db->query($query_get);
            
            $resultados =   $result->result_array();            
            return $resultados;
        
        }

    }
    /**/
    function get_pagos_notificados($param){

        $nombre = $param["nombre"];
        $telefono = $param["telefono"];     
        $recibo = $param["recibo"];   
        $estado = $param["estado"];
        
        $sql_extra =" n.status = '".$estado ."'";
        if($estado != 0 ){
            $sql_extra =" n.status != '0' ";
        }

        $query_get =   "SELECT 
                            n.* ,
                            f.forma_pago ,
                            s.nombre_servicio
                        FROM 
                            notificacion_pago n
                        INNER JOIN
                            forma_pago  f 
                        ON
                        n.id_forma_pago =  f.id_forma_pago
                        INNER JOIN 
                            servicio s 
                                ON
                            n.id_servicio =  s.id_servicio
                        WHERE 
                            $sql_extra
                                AND     
                                n.nombre_persona like '%".$nombre."%'
                            AND 
                                n.num_recibo like '%".$recibo."%'";

        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_comparativa_labor_venta($param){

        $query_get = "SELECT
                        SUM(CASE WHEN tipo = 1 then 1 else 0 end  ) prospectos, 
                        SUM(CASE WHEN tipo = 2 then 1 else 0 end  ) clientes,
                        SUM(CASE WHEN tipo = 4 then 1 else 0 end  ) envios_a_validar
                    FROM 
                        persona   p                   
                    WHERE                                                  
                    
                        p.id_usuario = '".$param["id_usuario"]."'
                        AND
                    (    
                        p.fecha_cambio_tipo = DATE(CURRENT_DATE())
                            OR 
                        DATE(p.fecha_registro) = DATE(CURRENT_DATE())
                    )";

        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_labor_venta($param){
        
        $_num = get_random();       
        
        $this->create_tmp_venta_persona_ventas($_num , 0  , $param );

            $query_get =  "SELECT
                                *
                            FROM                                 
                                labor_venta_persona_mensual2_$_num p2                            
                            ORDER BY 
                            p2.fecha_registro DESC";

            $result =  $this->db->query($query_get);                           
            
            $data_complete["resumen"]= $result->result_array();
        $this->create_tmp_venta_persona_ventas($_num , 1  , $param);                    
    
        return $data_complete;
    }    
 
    /**/
    function create_tmp_labor_venta_mensual($_num , $flag  , $param ){
        
        $sql_tiempo =" YEAR(fecha_modificacion) = YEAR(CURRENT_TIMESTAMP) AND MONTH(fecha_modificacion) = MONTH(CURRENT_TIMESTAMP) ";           
        $id_usuario =  $param["id_usuario"];
        $query_drop ="DROP TABLE IF EXISTS labor_venta_mensual_$_num";
        $this->db->query($query_drop);
        /**/
        if ($flag == 0 ){ 

            $query_create ="CREATE TABLE  labor_venta_mensual_$_num AS 
                        SELECT 
                        DATE(fecha_modificacion) fecha_registro ,                        
                        SUM(CASE WHEN tipificacion 
                            IN(2 , 3 , 4)  THEN 1 ELSE 0 END )no_le_interesa, 
                        COUNT(0) llamadas                         

                        FROM base_telefonica
                        WHERE 
                          ".$sql_tiempo."
                        AND 
                        id_usuario =  '".$id_usuario ."'
                        GROUP BY DATE(fecha_modificacion) 
                        ORDER BY fecha_modificacion DESC";

            $this->db->query($query_create);        
        }
    }

    /**/
    function create_tmp_venta_persona_ventas($_num , $flag  , $param ){

         $sql_tiempo =" 
                        (YEAR(fecha_registro) = YEAR(CURRENT_TIMESTAMP) 
                            AND
                            MONTH(fecha_registro) = MONTH(CURRENT_TIMESTAMP) 
                        
                            OR

                            YEAR(fecha_cambio_tipo) = YEAR(CURRENT_TIMESTAMP) 
                                AND
                            MONTH(fecha_cambio_tipo) = MONTH(CURRENT_TIMESTAMP) 
                        )
                        GROUP BY 
                        DATE(fecha_registro)";




        $id_usuario =  $param["id_usuario"];
        $query_drop ="DROP TABLE IF EXISTS labor_venta_persona_mensual2_$_num";
        $this->db->query($query_drop);

        if ($flag == 0 ){            
            $query_create ="CREATE TABLE  labor_venta_persona_mensual2_$_num AS 
                        SELECT 
                            DATE(fecha_registro)fecha_registro  , 
                            SUM(CASE WHEN tipo = 2  THEN 1 ELSE 0 END )clientes ,
                            SUM(CASE WHEN tipo = 1  THEN 1 ELSE 0 END )contactos
                        FROM 
                        persona 
                        WHERE
                            id_usuario =  '".$id_usuario."'
                        AND
                        ".$sql_tiempo;

            $this->db->query($query_create);        
        }
    }
    /**/



}