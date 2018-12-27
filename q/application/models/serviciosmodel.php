<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class serviciosmodel extends CI_Model {
    public $options;
    public $lista_servicios =[];
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    function insert( $params , $return_id=0 , $debug=0){        
        $insert   = $this->db->insert("servicio", $params , $debug);     
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }        
    function q_up($q , $q2 , $id_servicio){
        return $this->update([$q => $q2 ] , ["id_servicio" => $id_servicio ]);
    }
    function q_get($params=[], $id){
        return $this->get($params, ["id_servicio" => $id ] );
    }  
    function set_gamificacion_deseo($param , $positivo=1 , $valor =1){

        $val  =  ($positivo ==  1) ? "deseado + ".$valor :  "deseado - ".$valor;
        $query_update = "UPDATE servicio SET deseado =  ".$val .  " WHERE id_servicio =" .$param["id_servicio"];
        return $this->db->query($query_update);
    }         
    function get($params=[], $params_where =[] , $limit =1, $order = '', $type_order='DESC'){
        
        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);        
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
          $this->db->order_by($order, $type_order);  
        }
        return $this->db->get("servicio")->result_array();
    }
    /**/
    function update($data =[] , $params_where =[] , $limit =1 ){
    
      foreach ($params_where as $key => $value) {
              $this->db->where($key , $value);
      }
      $this->db->limit($limit);
      return $this->db->update("servicio", $data);    
    }
    private function set_option($key , $value){
        $this->options[$key] =  $value;
    }
    private function get_option($key){
        return $this->options[$key];
    }
    function num_periodo($param){
      
      $_num =  get_random();
      $this->create_tmp_servicio(1 , $_num ,  $param);
        $query_get =    "SELECT
                        DATE(fecha_registro)fecha_registro, 
                        COUNT(0)num 
                        FROM tmp_servicio_$_num
                        GROUP BY DATE(fecha_registro)";        
        $data_complete =  $this->db->query($query_get)->result_array();
      $this->create_tmp_servicio(0 , $_num ,  $param);
      return $data_complete;
    }
    private function create_tmp_servicio($flag , $_num , $param){

        $this->drop_tmp($_num);
        if ($flag ==  1) {            
            $query_create= "CREATE TABLE  tmp_servicio_$_num AS  
                            SELECT 
                              fecha_registro
                            FROM  
                              servicio 
                            WHERE 
                              DATE(fecha_registro) 
                            BETWEEN 
                            '".$param["fecha_inicio"]."' 
                            AND  
                            '".$param["fecha_termino"]."' ";
            $this->db->query($query_create);
        }

      }
      
    private  function drop_tmp($_num){
        $query_drop =  "DROP TABLE IF EXISTS tmp_servicio_$_num";
        $this->db->query($query_drop);
    }
    function get_productos_solicitados($param){
        
        $_num           =  get_random();
        $this->create_tmp_productos_solicitados(0 , $_num,  $param);        
        $query_get      =   "SELECT * FROM tmp_productos_$_num ORDER BY num_keywords DESC";
        $result         =   $this->db->query($query_get);
        $response       =   $result->result_array();
        $this->create_tmp_productos_solicitados(1 , $_num,  $param);
        return $response;
      
    }
    function set_vista($param){

        $id_servicio    =  $param["id_servicio"];
        $query_update   = 
        "UPDATE servicio 
        SET 
        vista               =  vista + 1 ,
        ultima_vista        =  CURRENT_TIMESTAMP()
        WHERE id_servicio   =  $id_servicio LIMIT 1";        
        return $this->db->query($query_update);

    }
    function create_tmp_productos_solicitados($flag , $_num,  $param){

      $this->db->query(get_drop("tmp_productos_$_num"));

      if($flag ==  0){

        $query_get  =  
                    "CREATE TABLE tmp_productos_$_num AS 
                      SELECT 
                        keyword, 
                        COUNT(0)num_keywords 
                      FROM 
                        keyword 
                      WHERE 
                        DATE(fecha_registro) 
                      BETWEEN 
                        '".$param["fecha_inicio"]."'  
                      AND 
                        '".$param["fecha_termino"]."'
                        AND
                        LENGTH(keyword) > 2
                      GROUP BY keyword";

        $this->db->query($query_get);

      }
    } 
    
    function get_producto_alcance($param){

        $query_get ="SELECT id_servicio 
                    FROM  
                    servicio 
                    WHERE 
                    id_usuario = '".$param["id_usuario"]."'
                    AND 
                    vista = '".$param["tipo"]."'
                    AND 
                    status =1 
                    AND
                    existencia>0
                    LIMIT 1";
        return $this->db->query($query_get)->result_array()[0]["id_servicio"];
      
    }
    function get_alcance_productos_usuario($param){
      
        $id_usuario = $param["id_usuario"];

        $params       =[
            "MAX(vista)maximo", 
            "AVG(vista)promedio" , 
            "MIN(vista)minimo" 
        ];

        $params_where =  [
            "id_usuario"    => $id_usuario,
            "status"        => 1, 
            "existencia"    => ">0"
        ];
        return $this->get($params , $params_where);      
    }
    function get_top_semanal_vendedor($param){
        
        $_num =  get_random();
        $this->create_views_productos_usuario(0 , $_num,  $param);          
        $query_get = "SELECT 
                        id_servicio , 
                        COUNT(0)vistas 
                        FROM tmp_views_productos_$_num 
                        GROUP BY id_servicio
                        ORDER BY COUNT(0) 
                        DESC
                        LIMIT 25 ";
                        $result  =  $this->db->query($query_get);
                        $data_complete =  $result->result_array();
        $this->create_views_productos_usuario(1 , $_num,  $param);
        return $data_complete;

    }
    
    private function create_views_productos_usuario($flag , $_num,  $param){
      
      $this->db->query(get_drop(" tmp_views_productos_$_num"));
      if($flag ==  0){

        $id_usuario =  $param["id_usuario"];
        $query_get=  "CREATE TABLE tmp_views_productos_$_num AS 
                      SELECT 
                        id_servicio  
                      FROM 
                        pagina_web
                      WHERE 
                        id_usuario = ".$id_usuario."
                      AND 
                        DATE(fecha_registro )
                      BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 WEEK ) 
                        AND  DATE(CURRENT_DATE())";
                      $this->db->query($query_get);
      }
    }     
    

    function get_tipos_entregas($param){

        $query_get = "SELECT
        id_servicio,   
        nombre_servicio,     
        vista , 
        deseado, 
        valoracion  
        FROM 
        servicio
        WHERE 
        status =  1 
        AND 
        vista > 1 
        AND  
        DATE(ultima_vista) 
        BETWEEN 
        '".$param["fecha_inicio"]."' AND '".$param["fecha_termino"]."' 
        ORDER 
        BY 
        deseado
        DESC
        ";        
        return $this->db->query($query_get)->result_array();


    }
        
    /*
    function agrega_metakeyword_catalogo($param){   

        $metakeyword = 
        $this->verifica_existencia_catalogo_metakeyword_usuario($param);
        
        if (count($metakeyword)> 0) {
            $json_meta  =  $metakeyword[0]["metakeyword"];  
            $arr_meta   =  json_decode($json_meta , true);
            
            $existe =$this->existe_meta($arr_meta, $param["metakeyword_usuario"]);
            if ($existe == 0) {                
                return $this->add_metakeyword($param , $arr_meta);    
            }
        }else{
            return $this->crea_registro_metakeyword($param);
        }
    }  
    */ 
    function set_q_servicio($param){

        $q              =   $param["q"];
        $q2             =   $param["q2"];
        $id_servicio    =   $param["id_servicio"];
        $response       = $this->q_up($q,  $q2  ,  $id_servicio );
        if($q == "nombre_servicio"){
            
            $param["id_servicio"] =     $servicio;
            $param["metakeyword"] =     $q2;    
            $param["id_servicio"] =     $servicio;
            $response             =  $this->agrega_metakeyword_sistema($param);
        }
        return $response;
    }
    function elimina_color_servicio($param){
        
        $colores =  $this->get_colores_por_servicio($param);
        if (isset($colores[0]["color"])) {
            
            $colores_en_servicio =  $colores[0]["color"];
            $color               =  $param["color"]; 
            $id_servicio         =  $param["id_servicio"];
            $arreglo_colores     =  explode(  "," , $colores_en_servicio);             
    
            $nueva_lista ="";
            for($z=0; $z < count($arreglo_colores); $z++){                 
                if($arreglo_colores[$z] != $color){
                    $nueva_lista .= $arreglo_colores[$z].",";        
                }                
            }                    
            return $this->q_up("color" ,$nueva_lista , $id_servicio);
        }else{
            return 1;
        }    
    }
    
    function agrega_color_servicio($param){
        
        $colores =  $this->get_colores_por_servicio($param);
        if (isset($colores[0]["color"])) {
            return $this->agrega_color($param , 1 , $colores[0]["color"] );
        }else{
            return $this->agrega_color($param, 0 , "");
        }    
    }        
    /**/
    function agrega_color($param , $flag , $color_anterior ){

        $color     =  $param["color"];         
        if ($flag != 0){

            $info_a             =  explode(",", $color_anterior);
            array_push($info_a, $color);            
            $nuevo              =  array_unique($info_a);
            $color              =  implode(",", $nuevo);            

        }        
        return $this->q_up("color" , $color , $param["id_servicio"]);
        
    }
    function get_colores_por_servicio($param){        
        return $this->q_get(["color"],  $param["id_servicio"] );
    }
    
    function gamificacion_usuario_servicios($param){
          
        $id             =   $param["id"];
        $valoracion     =   $param["valoracion"];        
        $nueva_valoracion = ($valoracion > 0 ) ? "  valoracion + $valoracion " :  " valoracion - $valoracion ";
        return $this->q_up("valoracion" , $nueva_valoracion , $id);
    }
    function get_num_en_venta_usuario($param){
    
        $query_get = "SELECT 
                        COUNT(0)num_servicios
                      FROM 
                      servicio 
                      WHERE 
                      id_usuario = '".$param["id_usuario"]."'
                      AND 
                        existencia>0
                      AND 
                        status =1
                      AND flag_imagen>0";

        return  $this->db->query($query_get)->result_array()[0]["num_servicios"];
    }
    function busqueda($param){        
        $data_complete["num_servicios"] =  
            $this->get_resultados_posibles($param);                    
            $_num =  get_random();
            $this->create_productos_disponibles(0 , $_num , $param);                
                $data_complete["sql"]       =       $this->get_option("sql");                            
                $data_complete["servicio"]  =       $this->db->get("tmp_producto_$_num")->result_array();
                if($param["agrega_clasificaciones"] ==  1){                        
                    $data_complete["clasificaciones_niveles"] = $this->get_clasificaciones_disponibles($_num);
                }                 
            $this->create_productos_disponibles(1 , $_num , $param);
        return  $data_complete;        
    }
    function get_clasificaciones_disponibles($_num){

        $niveles = ["primer_nivel" , "segundo_nivel" , "tercer_nivel" , "cuarto_nivel" , "quinto_nivel"];
        $data_niveles_clasificaciones = [];
        for ($a=0; $a <count($niveles); $a++){ 
                
            $nivel =  $niveles[$a];    
                    
            $query_get =  "SELECT DISTINCT($nivel)id_clasificacion FROM tmp_producto_$_num";
            $data_niveles_clasificaciones[$nivel] =  $this->db->query($query_get)->result_array();

        }
        return $data_niveles_clasificaciones;
    }    
    
    function get_limit($param){
        
        $page = (isset($param["extra"]['page'])&& !empty($param["extra"]['page']))?
        $param["extra"]['page']:1;
        $per_page = $param["resultados_por_pagina"]; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;
        
        return " LIMIT $offset , $per_page ";
    }
    function agrega_servicios_list($servicio){        
        if (count($servicio)>0){
            array_push($this->lista_servicios, $servicio[0]);    
        }    
    }
    function get_sql_servicio($param , $flag_conteo){
            
            $q          =   $param["q"];
            $limit      =   ($flag_conteo == 0)?$this->get_limit($param):" ";
            $extra_clasificacion = $this->get_extra_clasificacion($param);
            $num_q      =   strlen(trim($q));
            $id_usuario =   $param["id_usuario"];
            $sql_extra  =   "";
            $extra_existencia       = ($id_usuario > 0)?" ":" AND existencia >0 ";
            $sql_considera_imagenes = ($id_usuario > 0)?" ":" AND flag_imagen = 1 ";

            $extra_empresa = ($id_usuario > 0)?" AND id_usuario = " . $id_usuario :"";

            

            $vendedor       =   $param["vendedor"];
            $extra_vendedor =   ( $vendedor > 0)?" AND id_usuario =  '".$vendedor."'" : "";
            $orden          =   $this->get_orden($param);
            
            $sql_match = ($num_q >0 )?
            "   AND MATCH(metakeyword , 
                metakeyword_usuario) 
                AGAINST ('".$q."*' IN BOOLEAN MODE) ":"";

                $sql_extra =" 
                    WHERE 
                    1 = 1 
                    ".$extra_empresa."
                    ".$extra_vendedor."
                    ".$extra_existencia."
                    ".$sql_considera_imagenes."
                    AND 
                    status =1   
                    ".$extra_clasificacion."
                    ".$sql_match."
                    ".$orden."
                    ".$limit;
                
            
            return $sql_extra;
          
    }
    function get_extra_clasificacion($param){

        $id_clasificacion =  $param["id_clasificacion"];  
        $extra = " AND( primer_nivel  =  $id_clasificacion 
                        OR 
                        segundo_nivel  =  $id_clasificacion 
                        OR 
                        tercer_nivel  =  $id_clasificacion 
                        OR                    
                        cuarto_nivel   =  $id_clasificacion 
                        OR                    
                        quinto_nivel   =  $id_clasificacion )";
                        
        $extra = ($id_clasificacion > 0) ? $extra:"";
        return $extra;
    }
    function get_orden($param){

        
        switch ($param["order"]) {
            /*Novedades primero*/
            case 1:
                return " ORDER BY   fecha_registro DESC, deseado DESC ,  vista DESC";
                break;
            
            case 2:
                return " ORDER BY  deseado DESC , vista  DESC";
                break;

            case 3:
                return " ORDER BY valoracion DESC , deseado DESC , vista DESC";
                break;            

            case 4:
                return " ORDER BY vista DESC, deseado DESC , valoracion DESC";
                break;

            case 5:
                return " ORDER BY precio DESC, deseado DESC";
                break;    

            case 6:
                return " ORDER BY precio ASC, deseado DESC";
                break;    
            
            case 7:
                return " ORDER BY nombre_servicio ASC , deseado DESC";
                break;    

            case 8:
                return " ORDER BY nombre_servicio  DESC , deseado ASC";
                break;    
                        
            case 9:
                return 
                " AND flag_servicio = 1 ORDER BY  deseado DESC , vista  DESC , valoracion DESC";
            break;    

            case 10:
                return " AND flag_servicio = 0 ORDER BY  deseado DESC , vista  DESC";
            break; 

            case 11:
                return " ORDER BY  deseado DESC, vista  DESC ";
            break;    

            default:
                
                break;
        }        
    }

    /*
    function get_informacion_basica_servicio_disponible($param){

        $params  =  [   "id_servicio",
                        "nombre_servicio" , 
                        "status" , 
                        "existencia" ,
                        "flag_envio_gratis", 
                        "flag_servicio" , 
                        "flag_nuevo" , 
                        "id_usuario id_usuario_venta" ,
                        "precio" , 
                        "id_ciclo_facturacion"
                    ];

        return  $this->q_get($params, $param["id_servicio"] );
       
    }
    */

    function agrega_elemento_distinto($distinto){
        $nuevo = " AND id_servicio != $distinto";
        $sql = $this->get_option("sql_distintos");
        $nuevo_sql =  $sql . $nuevo;
        $this->set_option("sql_distintos" , $nuevo_sql);
    }
    function get_producto_por_clasificacion($param){

        

        $this->set_option("sql_distintos" , "");      
        $this->agrega_elemento_distinto($param["id_servicio"]);                    
        $n_servicio =  $this->get_producto_clasificacion_nivel(1 , $param["primer_nivel"]);


        if(count($n_servicio) > 0){
            $this->agrega_servicios_list($n_servicio);    
            $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
            

            $n_servicio =  $this->get_producto_clasificacion_nivel(2 , $param["segundo_nivel"]);        
            $this->agrega_servicios_list($n_servicio);            

            
            if (count($n_servicio) > 0) {
                
                $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
                $n_servicio =  
                $this->get_producto_clasificacion_nivel(3 , $param["tercer_nivel"]);
                $this->agrega_servicios_list($n_servicio);
                
                
                if (count($n_servicio) > 0) {                
                    $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
                    $n_servicio =  
                    $this->get_producto_clasificacion_nivel(4 , $param["cuarto_nivel"]);
                    $this->agrega_servicios_list($n_servicio);    

                    
                    if (count($n_servicio) > 0) {                
                        $this->agrega_elemento_distinto($n_servicio[0]["id_servicio"]);            
                        $n_servicio =  
                        $this->get_producto_clasificacion_nivel(5 , $param["quinto_nivel"]);
                        $this->agrega_servicios_list($n_servicio);    
                    }
                }

            }
        }
        

        return $this->get_lista_servicios();
        
    }
    function get_lista_servicios(){
        
        return $this->lista_servicios;
    }
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
                        color,
                        precio,
                        id_ciclo_facturacion
                        FROM 
                        servicio
                        WHERE 
                            1=1
                        $distinto
                            AND 
                        $nivel_text = $id_clasificacion  
                            AND 
                        existencia > 0
                            AND 
                        status = 1
                            AND 
                        flag_imagen = 1
                        LIMIT 1";
                        //debug($query_get);

        return   $this->db->query($query_get)->result_array();

                    
    } 
    /**/
    function periodo($param){

        $query_get =  "SELECT * FROM servicio WHERE DATE(fecha_registro) 
        BETWEEN '".$param["fecha_inicio"]."' AND '".$param["fecha_termino"]."'";        

        return $this->db->query($query_get)->result_array();
    }
    /*
    function es_servicio_usuario($param){
        

    }
    */
    function get_clasificaciones_por_id_servicio($id_servicio){
        
        $params =   [   "id_servicio",
                        "primer_nivel",  
                        "segundo_nivel", 
                        "tercer_nivel",  
                        "cuarto_nivel",  
                        "quinto_nivel" 
                    ];
        return $this->get( $params , ["id_servicio" => $id_servicio]);

    }
    function  get_clasificaciones_destacadas(){
        
        $query_get ="SELECT primer_nivel, count(0)total
                    FROM servicio 
                    WHERE 
                    status =1 
                    AND existencia >0 
                    GROUP BY 
                    primer_nivel
                    ORDER BY count(0) DESC";
        return  $this->db->query($query_get)->result_array();
        
    }
    function get_usuario_por_servicio($param){
      
      /*
      $id_servicio =  $param["id_servicio"];
      $query_get ="SELECT id_usuario FROM servicio WHERE id_servicio = $id_servicio LIMIT 1";
      $result = $this->db->query($query_get);
      return $result->result_array();
      */
      


    }
    function get_resumen($param){

        $id_servicio = $param["id_servicio"];
        $query_get ="SELECT 
                            *
                        FROM  
                            servicio s  
                        INNER JOIN              
                            ciclo_facturacion cf                
                        ON  
                            s.id_ciclo_facturacion = cf.id_ciclo_facturacion
                        WHERE 
                            s.id_servicio ='".$id_servicio."' LIMIT 1";
        return   $this->db->query($query_get)->result_array();
    }
    function busqueda_producto($param){
        
        $data_complete["num_servicios"] = $this->get_resultados_posibles($param);
        $_num =  get_random();
        $this->create_productos_disponibles(0 , $_num , $param);
        $data_complete["sql"]       =   $this->get_option("sql");
        $query_get                  =   "SELECT * FROM tmp_producto_$_num ";
        $result                     =  $this->db->query($query_get);
        $servicios                  =  $result->result_array();
        $data_complete["servicio"]  =  $servicios;
        if($param["agrega_clasificaciones"] ==  1){
            $data_complete["clasificaciones_niveles"] = $this->get_clasificaciones_disponibles($_num);
        }
        $this->create_productos_disponibles(1 , $_num , $param);
        return  $data_complete;
        
    }
    function get_resultados_posibles($param){
        
        $query_where = $this->get_sql_servicio($param , 1);            
        $query_get ="SELECT  
                        COUNT(0)num_servicios 
                    FROM 
                        servicio  ".$query_where;
        return $this->db->query($query_get)->result_array()[0]["num_servicios"];
            
    }
    function create_productos_disponibles($flag , $_num , $param){
        $query_drop = "DROP TABLE IF exists tmp_producto_$_num";
        $this->db->query($query_drop);                
        if($flag == 0){
            $query_where = $this->get_sql_servicio($param , 0);

            $param_extra =  ( $param["agrega_clasificaciones"] ==  1)?
            ",primer_nivel , segundo_nivel , tercer_nivel , cuarto_nivel 
            , quinto_nivel":""; 
              
            
                $query_create ="CREATE TABLE tmp_producto_$_num AS 
                            SELECT  
                                id_servicio ,  
                                nombre_servicio, 
                                flag_servicio, 
                                flag_envio_gratis,
                                metakeyword,                                 
                                color,   
                                precio , 
                                existencia,
                                id_ciclo_facturacion,
                                vista,
                                valoracion,
                                deseado      
                                ".$param_extra."                       
                            FROM 
                            servicio".$query_where;                            
                            $this->set_option("sql" , $query_create );               
            $this->db->query($query_create);    
        }
    }
    
    function agrega_metakeyword_sistema($param){
        
        $metakeyword = $param["metakeyword"];    
        $id_servicio = $param["id_servicio"];
        $meta        =  $this->get_palabras_clave_por_servicio_sistema($id_servicio);
        $metakeyword =  $meta .",".$metakeyword;    
        return $this->q_up("metakeyword",$metakeyword, $id_servicio);
    }
    function get_palabras_clave($id_servicio){

        return $this->q_get(["metakeyword_usuario"], $id_servicio )[0]["metakeyword_usuario"];        
    }
    function get_num_anuncios($param){

        $id_usuario     =  $param["id_usuario"];
        $query_get      ="SELECT COUNT(0)num 
        FROM 
        servicio 
        WHERE 
        id_usuario =$id_usuario 
        AND 
        status = 1
        AND 
        existencia >0
        LIMIT 1";
        return   $this->db->query($query_get)->result_array()[0]["num"];

    }
    function get_num_lectura_valoraciones($param){
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

        return $this->db->query($query_get)->result_array()[0]["num"];

    }   
    function set_preferencia_entrega($tipo , $id_servicio){


        $query_update = "UPDATE servicio SET ".$tipo." = ".$tipo." + 1 WHERE id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }
    
    /*
    
    
    function get_nombre_servicio($param){

        $id_servicio = $param["id_servicio"];
        $query_get = "SELECT nombre_servicio FROM servicio WHERE id_servicio = $id_servicio LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["nombre_servicio"];
    }
    
    function update_categorias_servicio($param){
        
        $primer_nivel= $param["primer_nivel"];
        $segundo_nivel= $param["segundo_nivel"];
        $tercer_nivel= $param["tercer_nivel"];
        $cuarto_nivel= $param["cuarto_nivel"];
        $quinto_nivel= $param["quinto_nivel"];
        $id_servicio = $param["id_servicio"];
        $metakeyword =  $param["metakeyword"];
        
        $query_update ="UPDATE 
                            servicio 
                        SET 
                         primer_nivel    = '".$primer_nivel."',
                         segundo_nivel = '".$segundo_nivel."',   
                         tercer_nivel =  '".$tercer_nivel."' ,  
                         cuarto_nivel = '".$cuarto_nivel."' ,
                         quinto_nivel  = '".$quinto_nivel."',  
                         metakeyword = '".$metakeyword."'
                         WHERE 
                         id_servicio = $id_servicio LIMIT 1";    


        return  $this->db->query($query_update);
        
        

    }

    
    
    
    
     function get_palabras_clave_por_servicio_sistema($id_servicio){

        
        $query_get = "SELECT 
                        metakeyword
                        FROM 
                        servicio 
                        WHERE id_servicio =$id_servicio 
                        LIMIT 1";

        $result =  $this->db->query($query_get);

        $palabras_clave =  $result->result_array()[0]["metakeyword"];
        return $palabras_clave;
        
    }    
    

    
    
    
   
     
    
    function get_clasificacion($param){

        $flag_servicio = $param["flag_servicio"];
        $query_get = "SELECT * FROM clasificacion 
                      WHERE 
                        flag_servicio = '".$flag_servicio."' ";
        $result=  $this->db->query($query_get);
        return $result->result_array();
    }
    function get_url_request($extra){

        $host =  $_SERVER['HTTP_HOST'];
        $url_request =  "http://".$host."/inicio/".$extra; 
        return  $url_request;
    }
    
  
    
    
    function get_precio_servicio($param){
        
        $query_get ="SELECT 
                        precio 
                    FROM precio 
                    WHERE 
                    id_servicio = '".$param["servicio"]."' 
                     LIMIT 1";
        
        $result =  $this->db->query($query_get);
        $precio =  $result->result_array()[0]["precio"];
        $iva = $precio * .16;
        $total =   $precio + $iva;
        $data_complete["precio"] =   $total;



        $query_get ="SELECT 
                        descripcion 
                    FROM 
                        servicio 
                    WHERE 
                    id_servicio = '".$param["servicio"]."' 
                    LIMIT 1";
                
        
        $result =  $this->db->query($query_get);
        $descripcion =  $result->result_array()[0]["descripcion"];
        $data_complete["descripcion"] =   $descripcion;
        return $data_complete;

    }
    
    
    
    function get_servicios_grupo_left_join($param){
        
        $grupo  =  $param["grupo"];    
        $query_get = "SELECT 
                        s.id_servicio, 
                        s.nombre_servicio, 
                        s.descripcion , 
                        gs.id_grupo 
                      FROM servicio s 
                      LEFT OUTER JOIN 
                      grupo_servicio gs 
                      ON 
                      s.id_servicio =  gs.id_servicio
                      AND  
                      gs.id_grupo=  $grupo";
                      
        $result = $this->db->query($query_get);
        return $result->result_array();        
    }
    
    function create_grupo($param){

        $grupo =  $param["grupo"];
        $query_insert ="INSERT INTO grupo(grupo) VALUES('".$grupo."')";
        $this->db->query($query_insert);
        return $this->db->insert_id();  
    }
    
    function valida_termino_aplicable($id_servicio , $id_caracteristica){


            $query_get =" SELECT COUNT(0)existe 
                FROM servicio_caracteristica 
                WHERE 
                id_caracteristica =  $id_caracteristica AND id_servicio =  $id_servicio";
            
            $result =  $this->db->query($query_get);            
            return $result->result_array()[0]["existe"];

    }
    
    function get_caracteristicas_globales_grupo_servicios($param){

            $grupo =  $param["grupo"];  
            $query_get ="SELECT c.* FROM 
                        grupo_servicio gs
                        INNER JOIN 
                        servicio_caracteristica sc 
                        ON 
                        gs.id_servicio =  sc.id_servicio
                        INNER JOIN 
                        caracteristica c
                        ON
                        sc.id_caracteristica =  c.id_caracteristica
                        WHERE 
                        gs.id_grupo = $grupo
                        GROUP BY c.id_caracteristica";

            $result =  $this->db->query($query_get);            
            return $result->result_array();             
    }
    
    function get_servicios_grupo($param){

            $grupo =  $param["grupo"];  
            $query_get ="SELECT * FROM servicio s 
                        INNER JOIN 
                        grupo_servicio gs
                        ON  
                        s.id_servicio = gs.id_servicio
                        INNER JOIN 
                        precio p 
                        ON 
                        p.id_servicio = s.id_servicio
                        INNER JOIN
                        ciclo_facturacion cf 
                        ON 
                        p.id_ciclo_facturacion = cf.id_ciclo_facturacion  
                        WHERE 
                        gs.id_grupo =  $grupo";

            $result =  $this->db->query($query_get);            
            return $result->result_array();
    }
    
    function get_grupos($param){
        
        $query_get = "SELECT * FROM grupo";
        $result=  $this->db->query($query_get);        
        return $result->result_array();
    }
    
    
    
    
    function get_terminos_disponibles_join_servicio($param){

        $id_servicio = $param["servicio"];
          $query_get = "SELECT 
                        c.id_caracteristica,
                        c.caracteristica, 
                        sc.id_servicio                        
                        FROM  caracteristica c
                        LEFT OUTER JOIN 
                        servicio_caracteristica sc 
                        ON 
                        c.id_caracteristica =  sc.id_caracteristica
                        AND 
                        sc.id_servicio = $id_servicio
                        ORDER BY 
                        sc.id_servicio DESC";

        $result = $this->db->query($query_get);
        return $result->result_array();

    }
    
    function get_terminos_disponibles_join_servicio_q($param){

        $id_servicio = $param["servicio"];
        $q = $param["q"];

        $query_get = "SELECT 
                        c.id_caracteristica,
                        c.caracteristica, 
                        sc.id_servicio                        
                        FROM  caracteristica c
                        LEFT OUTER JOIN 
                        servicio_caracteristica sc 
                        ON 
                        c.id_caracteristica =  sc.id_caracteristica
                        AND 
                        sc.id_servicio = $id_servicio
                        AND 
                        c.caracteristica like '%".$q."%'
                        ORDER BY 
                        sc.id_servicio DESC";

        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    
    function get_servicios($param){
        
        $query_get = "SELECT * FROM servicio 
                      ORDER BY 
                      status DESC ";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    
 
    
    function get_terminos_servicio($param){
                

        $id_servicio = $param["servicio"];        
        $query_get ="SELECT c.* FROM 
                        caracteristica c  
                    INNER JOIN  
                        servicio_caracteristica sc ON c.id_caracteristica =  sc.id_caracteristica 
                    WHERE sc.id_servicio = '".$id_servicio."' ";      


        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    
    function get_precios_servicio($param){
        
        $id_servicio = $param["servicio"];        

        $query_get="SELECT 
                        * 
                    FROM 
                        precio p 
                    INNER JOIN  
                        ciclo_facturacion cf                         
                        ON 
                        p.id_ciclo_facturacion =  cf.id_ciclo_facturacion
                        WHERE p.id_servicio = '".$id_servicio."' LIMIT 1";


        $result = $this->db->query($query_get);
        return $result->result_array();                    
    }
    
    function create_termino_servicio($param){


        $id_servicio = $param["servicio"];        
        $termino = $param["termino"];                        
        
        $query_insert ="INSERT INTO 
                            caracteristica(caracteristica)
                        VALUES('".$termino."')";
        $result = $this->db->query($query_insert);        
        
        $id_caracteristica=  $this->db->insert_id();  
        $param["caracteristica"] =  $id_caracteristica;
        return $this->asocia_termino_servicio($param);

    }
    
    function asocia_termino_servicio($param){


        $id_servicio = $param["servicio"];  
        $id_caracteristica =  $param["caracteristica"];
        
        
        $query_get ="SELECT 
                        COUNT(0)num_servicio_caracteristica 
                    FROM  servicio_caracteristica 
                    WHERE 
                    id_servicio     = '".$id_servicio."' 
                    AND 
                    id_caracteristica = '".$id_caracteristica ."'  
                    LIMIT 1";        
        
        $result =  $this->db->query($query_get);

        $num_servicio =  $result->result_array()[0]["num_servicio_caracteristica"];


        if ($num_servicio > 0) {
            

            $query_delete = "DELETE FROM  
                                servicio_caracteristica
                                WHERE 
                                id_servicio     = '".$id_servicio."' 
                                    AND 
                                id_caracteristica = '".$id_caracteristica ."'
                                LIMIT 10 ";

            return $this->db->query($query_delete);                    
        }else{
            $query_insert = "INSERT INTO servicio_caracteristica(
                                    id_servicio      ,
                                    id_caracteristica
                                )                        
                            VALUES(
                                    $id_servicio ,  
                                    $id_caracteristica )";
            
            return $this->db->query($query_insert);
        }


    }
    
    function asocia_servicio_grupo($param){


        $id_servicio = $param["servicio"];  
        $id_grupo =  $param["grupo"];
        
        
        $query_get ="SELECT 
                        COUNT(0)num_q 
                    FROM  
                        grupo_servicio 
                    WHERE 
                        id_servicio     = '".$id_servicio."' 
                    AND 
                        id_grupo = '".$id_grupo ."'  
                    LIMIT 1";        
        
        $result =  $this->db->query($query_get);
        $num_servicio =  $result->result_array()[0]["num_q"];


        if ($num_servicio > 0) {
            

            $query_delete = "DELETE FROM  
                                grupo_servicio
                                WHERE 
                                id_servicio     = '".$id_servicio."' 
                                    AND 
                                id_grupo = '".$id_grupo ."'
                                LIMIT 10";

            return $this->db->query($query_delete);                    
        }else{
            $query_insert = "INSERT INTO grupo_servicio(
                                    id_servicio      ,
                                    id_grupo
                                )                        
                            VALUES(
                                    $id_servicio ,  
                                    $id_grupo )";
            
            return $this->db->query($query_insert);
        }

    }
        
    
    
    */
}