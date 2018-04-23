<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class qmodel extends CI_Model {
    public $options;
    public $lista_servicios =[];
    function __construct($options=[]){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function carga_productos_en_venta_usuario($param){

        $id_usuario =  $param["id_usuario"];
        
        $query_get = "SELECT 
                        COUNT(0)num_servicios
                      FROM 
                      servicio 
                      WHERE 
                      id_usuario = $id_usuario 
                      AND 
                        existencia>0
                      AND 
                        status =1
                      AND flag_imagen>0";

        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num_servicios"];

    }
    
    /*Regresa información basica del servicio, en caso de estar disponible*/
    function get_informacion_basica_servicio_disponible($param){

        $id_servicio =  $param["id_servicio"];
        $articulos_solicitados =  $param["articulos_solicitados"];

        $query_get ="SELECT 
                        id_servicio,
                        nombre_servicio , 
                        status , 
                        existencia ,
                        flag_envio_gratis, 
                        flag_servicio , 
                        flag_nuevo , 
                        id_usuario id_usuario_venta,
                        precio , 
                        id_ciclo_facturacion
                    FROM 
                        servicio 
                    WHERE 
                        id_servicio = $id_servicio                     
                    LIMIT 1";
            
            $result =  $this->db->query($query_get);
            $servicio =   $result->result_array();

            $num_servicios =  count($servicio); 
            $data_complete["en_existencia"] =0;
            $data_complete["info_servicio"] =  $servicio;
            if($num_servicios > 0){
                /**/
                $data_complete["en_existencia"] =1;                
            }else{
                /*Consultamos el número de artículos disponibles*/
                $data_complete["numero_servicios_disponinble_para_compra"] =  
                $this->consulta_numero_articulos_disponibles_por_id_servicio($id_servicio);
            }  
            return $data_complete;      
    }    
    /*Consulamos el número de articulos disponibles actualmente*/
    function consulta_numero_articulos_disponibles_por_id_servicio($id_servicio){

        $query_get ="SELECT                         
                        existencia 
                    FROM 
                        servicio 
                    WHERE 
                        id_servicio = $id_servicio 
                    LIMIT 1";
            
            $result =  $this->db->query($query_get);
            return $result->result_array()[0]["existencia"];
    }
    /**/
    function get_producto_por_clasificacion($param){

        $servicio =  $param[0];             
        $this->set_option("sql_distintos" , "");      
        $this->agrega_elemento_distinto($servicio["id_servicio"]);                    
        $n_servicio =  $this->get_producto_clasificacion_nivel(1 , $servicio["primer_nivel"]);    
        /**2*/
        if(count($n_servicio) > 0){

            $this->agrega_servicios_list($n_servicio);    
            $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
            $n_servicio =  $this->get_producto_clasificacion_nivel(2 , $servicio["segundo_nivel"]);
            $this->agrega_servicios_list($n_servicio);

            /**3*/
            if (count($n_servicio) > 0) {
                
                $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
                $n_servicio =  
                $this->get_producto_clasificacion_nivel(3 , $servicio["tercer_nivel"]);
                $this->agrega_servicios_list($n_servicio);
                
                /*4*/
                if (count($n_servicio) > 0) {                
                    $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
                    $n_servicio =  
                    $this->get_producto_clasificacion_nivel(4 , $servicio["cuarto_nivel"]);
                    $this->agrega_servicios_list($n_servicio);    

                    /*5*/
                    if (count($n_servicio) > 0) {                
                        $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
                        $n_servicio =  
                        $this->get_producto_clasificacion_nivel(5 , $servicio["quinto_nivel"]);
                        $this->agrega_servicios_list($n_servicio);    
                    }
                }

            }
        }
        
        
        return $this->get_lista_servicios();
        
    }
    /**/
    function get_lista_servicios(){
        return $this->lista_servicios;
    }
    /**/
    function agrega_servicios_list($servicio){        
        array_push($this->lista_servicios, $servicio[0]);
    }
    /**/
    function agrega_elemento_distinto($distinto){        
        $nuevo = " AND id_servicio != $distinto";
        $sql = $this->get_option("sql_distintos");
        $nuevo_sql =  $sql . $nuevo;
        $this->set_option("sql_distintos" , $nuevo_sql);
    }
    /**/
    function get_producto_clasificacion_nivel($nivel , $id_clasificacion){

        $lista_niveles = ["" , 
        "primer_nivel" , 
        "segundo_nivel" ,
        "tercer_nivel" , 
        "cuarto_nivel",
        "quinto_nivel"];

        $nivel_text =  $lista_niveles[$nivel];
        $distinto =  $this->get_option("sql_distintos");
        $query_get = "SELECT 
                                id_servicio ,  
                                nombre_servicio, 
                                flag_servicio, 
                                flag_envio_gratis,
                                metakeyword, 
                                primer_nivel , 
                                segundo_nivel ,
                                tercer_nivel ,
                                cuarto_nivel , 
                                quinto_nivel, 
                                color
                        FROM 
                        servicio
                        WHERE 
                            1=1
                            $distinto
                            AND 
                            $nivel_text = $id_clasificacion  
                            AND 
                            existencia > 0
                        LIMIT 1";
                    $result =  $this->db->query($query_get);
                    return $result->result_array();
    }  
    /**/
    function get_option($key){
        return $this->options[$key];
    }
    /**/
    function set_option($key , $value){
        $this->options[$key] =  $value;
    }
    /**/
    function busqueda_producto($param){
        
        $data_complete["num_servicios"] =  
            $this->get_resultados_posibles($param);                    
            $_num =  get_random();
            $this->create_productos_disponibles(0 , $_num , $param);                

                    $data_complete["sql"] =  $this->get_option("sql");
                    $query_get ="SELECT * FROM tmp_producto_$_num ORDER BY 
                    valoracion,vista DESC";
                    $result =  $this->db->query($query_get);
                    $servicios =  $result->result_array();
                
                    $data_complete["servicio"] =  $servicios;
                    
                    if($param["agrega_clasificaciones"] ==  1){                        
                        $data_complete["clasificaciones_niveles"] =  
                        $this->get_clasificaciones_disponibles($_num);                      
                    }
                    
            $this->create_productos_disponibles(1 , $_num , $param);
        return  $data_complete;
        
    }
    /**/
    /**/
    function get_clasificaciones_disponibles($_num){

        $niveles = ["primer_nivel" , "segundo_nivel" , "tercer_nivel" , "cuarto_nivel" , "quinto_nivel"];
        $data_niveles_clasificaciones = [];
        for ($a=0; $a <count($niveles); $a++){ 
                
            $nivel =  $niveles[$a];    
            $query_get = "select distinct($nivel)id_clasificacion from tmp_producto_$_num";
            $result=  $this->db->query($query_get);
            $data_niveles_clasificaciones[$nivel] = $result->result_array();    
        }

        return $data_niveles_clasificaciones;

    }    
    /**/
    function get_resultados_posibles($param){
        
        $query_where = $this->get_sql_producto($param , 1);            
        $query_get ="SELECT  
                        COUNT(0)num_servicios 
                    FROM 
                        servicio  ".$query_where;
        $result = $this->db->query($query_get);
        return $result->result_array()[0]["num_servicios"];
            
    }
    /**/
    function get_extra_clasificacion($id_clasificacion , $param){

            $extra_clasificacion ="";

            if ($param["agrega_clasificaciones"] ==  1) {
                
                if($id_clasificacion > 0){                
                    $extra_clasificacion = "AND(
                                                primer_nivel  =  $id_clasificacion 
                                                OR 
                                                segundo_nivel  =  $id_clasificacion 
                                                OR 
                                                tercer_nivel  =  $id_clasificacion 
                                                OR                    
                                                cuarto_nivel   =  $id_clasificacion 
                                                OR                    
                                                quinto_nivel   =  $id_clasificacion 
                                            )";
                }       
            }
            
            return $extra_clasificacion;

    }
    /**/
    
    /**/
    function get_precio_servicio($id_servicio){
        
        $query_get = "SELECT 
                        precio ,                                                 
                        id_ciclo_facturacion 
                        FROM precio WHERE id_servicio = $id_servicio LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_limit($param){
        /**/
        $page = (isset($param["extra"]['page'])&& !empty($param["extra"]['page']))?
        $param["extra"]['page']:1;
        $per_page = $param["resultados_por_pagina"]; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
        
        return " LIMIT $offset , $per_page ";
    }
    /**/
    function get_sql_producto($param , $flag_conteo){
            
            $limit = " ";    
            if ($flag_conteo ==  0){
                $limit =  $this->get_limit($param);    
            }
            /**/
            $id_clasificacion =  $param["id_clasificacion"];
            $extra_clasificacion =  
            $this->get_extra_clasificacion($id_clasificacion , $param);            
            $num_q = strlen(trim($param["q"])); 
            $q=  $param["q"]; 
            $sql_extra  ="";
            $extra_empresa = "";   
                          
            /**/
            $extra_existencia =" AND existencia > 0  ";
            $sql_considera_imagenes = " AND flag_imagen =1 ";
            
            /**/
            if($param["id_usuario"] > 0){
                    $extra_existencia = " ";
                    $sql_considera_imagenes = " ";
                    $extra_empresa = " AND id_usuario = " . $param["id_usuario"];      
            }
           
            /**/
            if($num_q >0 ){
                
                $sql_match =" AND MATCH(metakeyword , metakeyword_usuario) 
                            AGAINST ('".$q."*' IN BOOLEAN MODE) ";
                $sql_extra =" WHERE 1 = 1 
                    ".$extra_existencia."
                    ".$sql_considera_imagenes."
                    AND 
                    status =1   
                    ".$extra_clasificacion." 
                    ".$extra_empresa."
                    
                    ".$sql_match."
                    ORDER BY 
                    vista 
                    DESC ".$limit;
                
            }if($num_q ==  0){
        
                $sql_extra =" WHERE 
                        1 = 1               
                        ".$extra_existencia."
                        ".$sql_considera_imagenes."                       
                    AND 
                        status = 1                     
                        ".$extra_clasificacion." 
                        ".$extra_empresa."
                    ORDER BY 
                    vista DESC ".$limit;

            }
            if($param["vendedor"] > 0){            
                $sql_extra =" WHERE 
                        1 = 1               
                            ".$extra_existencia."
                            ".$sql_considera_imagenes."                        
                        AND 
                            id_usuario =  '".$param["vendedor"]."'
                        AND 
                        ".$extra_empresa."
                        status = 1                                             
                    ORDER BY 
                    vista DESC ".$limit;
            }
            

            return $sql_extra;
          
    }
    /**/
    function create_productos_disponibles($flag , $_num , $param){

        $query_drop = "DROP TABLE IF exists tmp_producto_$_num";
        $this->db->query($query_drop);        
        /**/
        if($flag == 0){

            $query_where = $this->get_sql_producto($param , 0);

             $query_create ="CREATE TABLE tmp_producto_$_num AS 
                            SELECT  
                                id_servicio ,  
                                nombre_servicio, 
                                flag_servicio, 
                                flag_envio_gratis,
                                metakeyword,                                 
                                color,
                                existencia,
                                precio , 
                                id_ciclo_facturacion, 
                                vista,
                                valoracion  

                            FROM 
                            servicio".$query_where; 

                        $this->set_option("sql" , $query_create);       

            if( $param["agrega_clasificaciones"] ==  1){            
                $query_create ="CREATE TABLE tmp_producto_$_num AS 
                            SELECT  
                                id_servicio ,  
                                nombre_servicio, 
                                flag_servicio, 
                                flag_envio_gratis,
                                metakeyword, 
                                primer_nivel , 
                                segundo_nivel ,
                                tercer_nivel ,
                                cuarto_nivel , 
                                quinto_nivel,
                                color,   
                                precio , 
                                id_ciclo_facturacion,
                                vista,
                                valoracion                             
                            FROM 
                            servicio".$query_where;   
                            
                            $this->set_option("sql" , $query_create );       
            }
            $this->db->query($query_create);
            


        }
    }
    /**/
    function registra_keyword($param){
        $q =  $param["q"];
        if (strlen(trim($q)) > 2){        
            $query_insert ="INSERT INTO keyword(keyword) VALUES('".$param["q"]."')";
            return $this->db->query($query_insert);    
        }
    }
    /*carga conceptos básicos por servicio por id_servicio*/
    function get_basic_servicio($param){
        $id_servicio =  $param["id_servicio"];
        $query_get ="SELECT 
                    nombre_servicio , 
                    telefono_visible ,
                    id_usuario 
                    FROM servicio 
                    WHERE id_servicio = $id_servicio LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_servicios_periodo_simple($param){
        
        $query_get ="SELECT * FROM servicio 
                    WHERE   
                    
                    DATE(fecha_registro) 
        BETWEEN '".$param["fecha_inicio"]."' AND '".$param["fecha_termino"]."' ";

        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
}