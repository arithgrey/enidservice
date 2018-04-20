<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class ventastelmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function marca_alta_usuario($data , $param){
        /**/
        if (count($data["tel"]) > 0 ) {

            $id_base_telefonica =  $data["tel"][0]["id_base_telefonica"];
            $id_usuario =  $param["id_usuario"];

            $query_update ="UPDATE base_telefonica 
                            SET 
                            status = 0 ,
                            id_usuario = '".$id_usuario."'
                            WHERE 
                            id_base_telefonica = '".$id_base_telefonica."' LIMIT 1";

            $this->db->query($query_update);

        }
        
    }


    /**/
    function get_ultimo_prospecto_usuario($param){

        $tipo_negocio  =  $param["tipo_negocio"];
        $id_usuario = $param["id_usuario"];

        $query_get = "SELECT 
                        b.* ,
                        f.nombre nombre_fuente 
                      FROM 
                        base_telefonica b
                      INNER JOIN fuente f 
                        ON b.id_fuente =  f.id_fuente
                      WHERE 
                        b.n_tocado = 0                                              
                        AND 
                        b.status =  0 
                      AND  
                        b.id_usuario = '".$id_usuario ."'
                      AND 
                        b.idtipo_negocio ='".$tipo_negocio."' 
                        LIMIT 1";

        $result =  $this->db->query($query_get);
        return $result->result_array();        

    }
    /**/
    function get_nuevo_prospecto($param){
        $tipo_negocio  =  $param["tipo_negocio"];
        $tipo_negocio  =  $param["tipo_negocio"];

            $query_get = "SELECT 
                        b.* ,
                        f.nombre nombre_fuente ,
                        f.id_fuente
                      FROM 
                      base_telefonica b
                      INNER JOIN fuente f 
                      ON b.id_fuente =  f.id_fuente
                      WHERE 
                        b.n_tocado = 0                      
                      AND 
                        b.status =  1
                      AND 
                        b.idtipo_negocio ='".$tipo_negocio."'                       
                        ORDER BY fecha_registro DESC 
                    LIMIT 1";

        $result =  $this->db->query($query_get);
        return $result->result_array();        
           
    }

    /**/
    function get_prospecto($param){
        

        $tipo_negocio  =  $param["tipo_negocio"];        
        /*Verifica último contacto*/        
        $num_contactos  =  $this->get_ultimo_prospecto_usuario($param);        
        /*Si tiene uno sin tipificar lo regresa*/
        if (count($num_contactos) > 0 ){
            $data["tel"] = $num_contactos;
        }else{
            /*Si no lanza otro*/
            $data["tel"] = $this->get_nuevo_prospecto($param);
        }
        
        /*Marcamos que pertenece a la personas que solicita*/
        $this->marca_alta_usuario($data , $param);    
        
        /**/
        $query_get = "SELECT 
                        * 
                      FROM tipo_negocio 
                      WHERE 
                      idtipo_negocio = '".$tipo_negocio."' LIMIT 1";

        $result =  $this->db->query($query_get);
        $data["tipo_negocio"]=  $result->result_array();        
        
        /**/
        return $data;
    }
    /**/
    function update_prospecto($param){

        $telefono =  $param["telefono"];
        $id_usuario =  $param["id_usuario"];
        $tipificacion =  $param["tipificacion"];

        $query_update ="UPDATE 
                            base_telefonica 
                        SET
                            tipificacion = '".$tipificacion."' ,
                            id_usuario = '".$id_usuario."' ,
                            n_tocado = n_tocado + 1 ,
                            fecha_modificacion =  CURRENT_TIMESTAMP()   
                            WHERE 
                            telefono = '".$telefono."' 
                        LIMIT 1 ";
        
        if($tipificacion ==  2) {
            
            $fecha_agenda =  $param["fecha_agenda"];
            $hora_agenda =  $param["hora_agenda"];
            $comentario =  $param["comentario"];

            $query_update ="UPDATE base_telefonica 
                            SET
                                tipificacion = '".$tipificacion."' ,
                                id_usuario = '".$id_usuario."' ,
                                n_tocado = n_tocado + 1 ,
                                fecha_agenda = '".$fecha_agenda."' ,
                                hora_agenda_text = '".$hora_agenda."' ,
                                comentario = '".$comentario."' ,
                                fecha_modificacion =  CURRENT_TIMESTAMP()   
                            WHERE 
                                telefono = '".$telefono."' LIMIT 1 ";    
        }
        return $this->db->query($query_update);
    }
    /**/
    function get_labor_venta($param){

        /*
        */
        $data["resumen"]= $this->get_labor_venta_mensual($param);
        $data["resumen_periodo"] = $this->get_labor_venta_periodo($param);
        return $data;

    }
    /**/
    function get_labor_venta_mensual($param){

        $_num = get_random();
        $this->create_tmp_labor_venta_mensual($_num , 0,  $param );        

        $sql_tiempo ="YEAR(fecha_registro) = YEAR(CURRENT_TIMESTAMP) 
                      AND
                      MONTH(fecha_registro) = MONTH(CURRENT_TIMESTAMP) 
                      GROUP BY DATE(fecha_registro)";

        $this->create_tmp_venta_persona($_num , 0  , $param , $sql_tiempo );
            
            $query_get =  "SELECT 
                            l.* ,                            
                            p.contactos_efectivos,
                            p.referidos
                            FROM labor_venta_mensual_$_num l
                            LEFT OUTER JOIN labor_venta_persona_mensual_$_num p 
                            ON l.fecha_registro =  p.fecha_registro";
            $result =  $this->db->query($query_get);               
            $data =  $result->result_array();

        $this->create_tmp_labor_venta_mensual($_num , 1, $param );        
        $this->create_tmp_venta_persona($_num , 1  , $param  , $sql_tiempo );
        return $data;

    }
    /**/
    function create_tmp_labor_venta_mensual($_num , $flag  , $param ){
        
        $sql_tiempo ="YEAR(fecha_modificacion) = YEAR(CURRENT_TIMESTAMP) AND MONTH(fecha_modificacion) = MONTH(CURRENT_TIMESTAMP) ";           
        $id_usuario =  $param["id_usuario"];
        $query_drop ="DROP TABLE IF EXISTS labor_venta_mensual_$_num";
        $this->db->query($query_drop);
        /**/
        if ($flag == 0 ){ 

            $query_create ="CREATE TABLE  labor_venta_mensual_$_num AS SELECT 
                        DATE(fecha_modificacion) fecha_registro ,
                        SUM(CASE WHEN tipificacion =  1 THEN 1 ELSE 0 END )  le_interesa ,
                        SUM(CASE WHEN tipificacion =  2 THEN 1 ELSE 0 END )  llamar_despues ,
                        SUM(CASE WHEN tipificacion =  3 THEN 1 ELSE 0 END )  no_le_interesa ,
                        SUM(CASE WHEN tipificacion =  4 THEN 1 ELSE 0 END )  no_volver_a_llamar  ,
                        SUM(CASE WHEN tipificacion =  5 THEN 1 ELSE 0 END )  no_contesta  ,
                        SUM(CASE WHEN tipificacion =  6 THEN 1 ELSE 0 END )  venta ,
                        SUM(CASE WHEN tipificacion =  7 THEN 1 ELSE 0 END )  venta_confirmada 
                        FROM base_telefonica
                        WHERE 
                          ".$sql_tiempo."
                        AND id_usuario =  '".$id_usuario ."'
                        GROUP BY DATE(fecha_modificacion) 
                        ORDER BY fecha_modificacion DESC";

            $this->db->query($query_create);        
        }
    }
    /**/
    function create_tmp_venta_persona($_num , $flag  , $param , $sql_tiempo  ){

        $id_usuario =  $param["id_usuario"];
        $query_drop ="DROP TABLE IF EXISTS labor_venta_persona_mensual_$_num";
        $this->db->query($query_drop);


        if ($flag == 0 ){            
            $query_create ="CREATE TABLE  labor_venta_persona_mensual_$_num AS 
                        SELECT 
                        DATE(fecha_registro)fecha_registro , 
                        count(0)contactos_efectivos ,                         
                        SUM(CASE WHEN referido = 1 THEN 1 ELSE 0 END) referidos 
                        FROM persona WHERE
                        id_usuario =  '".$id_usuario."'
                        AND

                        ".$sql_tiempo;

            $this->db->query($query_create);        
        }



    }
    /**/
    function get_labor_venta_periodo($param){

        $_num =  get_random();
        $this->create_tmp_ventas_periodo($_num , 0  , $param ); 

            $query_get ="SELECT * FROM labor_venta_periodo_$_num";
            $result = $this->db->query($query_get);
            $data =  $result->result_array();
        
        $this->create_tmp_ventas_periodo($_num , 1  , $param );            
        return $data;

    }
    /**/
    function create_tmp_ventas_periodo($_num , $flag , $param){

        $id_usuario =  $param["id_usuario"];
        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];
        $sql_tiempo =  " DATE(fecha_modificacion)  between  '".$fecha_inicio."'  AND   '".$fecha_termino."' ";
        
        $query_drop ="DROP TABLE IF EXISTS labor_venta_periodo_$_num";
        
        $this->db->query($query_drop);

        if ($flag == 0){           

                    $query_get =  "CREATE TABLE labor_venta_periodo_$_num AS 
                        SELECT 
                        HOUR(fecha_modificacion) hora_registro ,
                        SUM(CASE WHEN tipificacion =  1 THEN 1 ELSE 0 END )  le_interesa ,
                        SUM(CASE WHEN tipificacion =  2 THEN 1 ELSE 0 END )  llamar_despues ,
                        SUM(CASE WHEN tipificacion =  3 THEN 1 ELSE 0 END )  no_le_interesa ,
                        SUM(CASE WHEN tipificacion =  4 THEN 1 ELSE 0 END )  no_volver_a_llamar  ,
                        SUM(CASE WHEN tipificacion =  5 THEN 1 ELSE 0 END )  no_contesta  ,
                        SUM(CASE WHEN tipificacion =  6 THEN 1 ELSE 0 END )  venta ,
                        SUM(CASE WHEN tipificacion =  7 THEN 1 ELSE 0 END )  venta_confirmada 
                       FROM base_telefonica
                       WHERE 
                       " .$sql_tiempo ."
                       AND id_usuario =  '".$id_usuario ."'
                       GROUP BY 
                       HOUR(fecha_modificacion)
                       ORDER BY fecha_modificacion DESC";

            $this->db->query($query_get);               
        
        }
        
    }


}