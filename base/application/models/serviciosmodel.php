<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class serviciosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function elimina_color_servicio($param){
        
        $colores =  $this->get_colores_por_servicio($param);

        if (isset($colores[0]["color"])) {
            
            $colores_en_servicio =$colores[0]["color"];
            $color =  $param["color"]; 
            $id_servicio =  $param["servicio"];
            $arreglo_colores = explode(  "," , $colores_en_servicio);             
    
            $nueva_lista ="";
            for($z=0; $z < count($arreglo_colores); $z++){                 
                if($arreglo_colores[$z] != $color){
                    $nueva_lista .= $arreglo_colores[$z].",";        
                }                
            }        
            /**/
            $query_update ="UPDATE servicio SET 
                color =  '".$nueva_lista."' WHERE  id_servicio = $id_servicio LIMIT 1";      
            return $this->db->query($query_update);        
        }else{
            return 1;
        }    
    }
    /***/
    function agrega_color_servicio($param){
        
        $colores =  $this->get_colores_por_servicio($param);
        if (isset($colores[0]["color"])) {
            return $this->agrega_color($param , 1 , $colores[0]["color"] );
        }else{
            return $this->agrega_color($param, 0 , "");
        }
    
    }
    function agrega_color($param , $flag , $color_anterior ){

        $id_servicio =  $param["servicio"];
        $color =  $param["color"]; 
        if ($flag == 0){
            $query_update ="UPDATE servicio SET color =  '".$color."' WHERE 
                     id_servicio = $id_servicio LIMIT 1";    
        }else{


            $info_a=  explode(",", $color_anterior);
            array_push($info_a, $color);
            /**/
            $nuevo=  array_unique($info_a);
            $nueva_lista_colores=  implode(",", $nuevo);            
            $query_update ="UPDATE servicio 
                            SET color =  '".$nueva_lista_colores."'
                            WHERE id_servicio = $id_servicio LIMIT 1";           

        }
        
        return $this->db->query($query_update);        
        
    }
    /**/
    function get_colores_por_servicio($param){

        $id_servicio =  $param["servicio"];
        $query_get ="SELECT color FROM servicio WHERE id_servicio = $id_servicio LIMIT 1";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_nombre_estado_enid_service($param){

        $id_estatus= $param["id_estatus"];
        $query_get = "SELECT nombre 
                        FROM status_enid_service 
                      WHERE id_estatus_enid_service = $id_estatus LIMIT 1";
                      $result =  $this->db->query($query_get);
                      return $result->result_array()[0]["nombre"];
    }
    /**/
    function get_nombre_servicio($param){

        $id_servicio = $param["id_servicio"];
        $query_get = "SELECT nombre_servicio FROM servicio WHERE id_servicio = $id_servicio LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["nombre_servicio"];
    }
    /**/
    function update_categorias_servicio($param){
        
        $primer_nivel= $param["primer_nivel"];
        $segundo_nivel= $param["segundo_nivel"];
        $tercer_nivel= $param["tercer_nivel"];
        $cuarto_nivel= $param["cuarto_nivel"];
        $quinto_nivel= $param["quinto_nivel"];
        $id_servicio = $param["id_servicio"];
        $metakeyword =  $param["metakeyword"];
        /**/        
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

    /**/
    function delete_tag_servicio($param){
        
        $tag =  $param["tag"];
        $id_servicio =  $param["id_servicio"];        
        $palabras_clave=  $this->get_palabras_clave_por_servicio($id_servicio);
        /**/
        $tag_arreglo=  explode(",", $palabras_clave);
        $posicion =    $this->busqueda_meta_key_word($tag_arreglo , $tag);  
        unset($tag_arreglo[$posicion]);

        $metakeyword_usuario =   implode(",", $tag_arreglo);
        
        $query_update = "UPDATE 
        servicio 
        SET 
        metakeyword_usuario= '".$metakeyword_usuario."' 
        WHERE  
        id_servicio = $id_servicio 
        LIMIT 1";
        return $this->db->query($query_update);


    }
    /**/
    function busqueda_meta_key_word($arreglo_tags , $tag){
        
        return  array_search($tag, $arreglo_tags); 

    }
    /**/
    function get_palabras_clave_por_servicio($id_servicio){

        
        $query_get = "SELECT 
                        metakeyword_usuario 
                        FROM 
                        servicio 
                        WHERE id_servicio =$id_servicio 
                        LIMIT 1";

        $result =  $this->db->query($query_get);

        $palabras_clave =  $result->result_array()[0]["metakeyword_usuario"];
        return $palabras_clave;
        
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

    /**/
    function agrega_metakeyword($param){
        
        $metakeyword_usuario = $param["metakeyword_usuario"];    
        $id_servicio = $param["id_servicio"];

        $meta  =  $this->get_palabras_clave_por_servicio($id_servicio);
        $metakeyword_usuario =  $meta .",".$metakeyword_usuario;
        
        $query_update = "UPDATE 
                            servicio 
                        SET 
                        metakeyword_usuario = '".$metakeyword_usuario."'                        
                        WHERE id_servicio ='".$id_servicio."' LIMIT 1";    

        return $this->db->query($query_update);
    }
     function agrega_metakeyword_sistema($param){
        
        $metakeyword = $param["metakeyword"];    
        $id_servicio = $param["id_servicio"];

        $meta  =  $this->get_palabras_clave_por_servicio_sistema($id_servicio);
        $metakeyword =  $meta .",".$metakeyword;
        
        $query_update = "UPDATE 
                            servicio 
                        SET 
                        metakeyword = '".$metakeyword."'                        
                        WHERE id_servicio ='".$id_servicio."' LIMIT 1";    

        return $this->db->query($query_update);
    }
    /**/
    function get_categorias_servicios($param){
        
        $modalidad =  $param["modalidad"];            
        $padre = $param["padre"];
        $extra =  " AND padre =0";
        if ($padre > 0){            
            $extra =  " AND padre = ".$padre;
        }

        $query_get = "SELECT 
            * 
            FROM 
            clasificacion
            WHERE 
            flag_servicio  = '".$modalidad."' ".$extra;    
        $result =  $this->db->query($query_get);
        return $result->result_array();

    }
    /**/
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
    /**/    
    function create_servicio($param){

        $nombre_servicio =  $param["nombre_servicio"];        
        $flag_servicio =  $param["flag_servicio"];
        $primer_nivel  =   $param["primer_nivel"];
        $segundo_nivel =   $param["segundo_nivel"];
        $tercer_nivel  =   $param["tercer_nivel"];
        $cuarto_nivel  =   $param["cuarto_nivel"];
        $quinto_nivel  =   $param["quinto_nivel"];
        $descripcion = "";  
        $metakeyword =  $param["metakeyword"];      
        $id_usuario = $param["id_usuario"];

        $query_insert ="INSERT INTO servicio(
                                            nombre_servicio,                             
                                            flag_servicio , 
                                            primer_nivel, 
                                            segundo_nivel,
                                            tercer_nivel ,
                                            cuarto_nivel ,
                                            quinto_nivel, 
                                            descripcion ,  
                                            metakeyword,
                                            id_usuario 
                                )

                        VALUES(

                            '".$nombre_servicio."' ,                             
                            '".$flag_servicio."', 
                            '".$primer_nivel ."',
                            '".$segundo_nivel."',
                            '".$tercer_nivel ."',
                            '".$cuarto_nivel ."',
                            '".$quinto_nivel ."',                            
                            '".$descripcion."', 
                            '".$metakeyword."',
                            '".$id_usuario."'
                        )";
        
        $this->db->query($query_insert);
        $id_servicio =  $this->db->insert_id();  
        $param["id_servicio"]=  $id_servicio;
        $db_response_precio=  $this->insert_precio($param);
        return $id_servicio;
        
        
    }
    /**/
    function insert_precio($param){
        
        $costo = $param["costo"];
        $precio = $param["precio"];
        $id_servicio = $param["id_servicio"];
        $id_ciclo_facturacion = $param["ciclo_facturacion"];
        $flag_servicio =  $param["flag_servicio"];
       

        $query_insert = "INSERT INTO precio(
                            precio , 
                            costo , 
                            id_servicio , 
                            id_ciclo_facturacion 
                        ) 
                    VALUES(
                        '".$precio."' ,  
                        '".$costo."' ,  
                        '".$id_servicio."' , 
                        '".$id_ciclo_facturacion."' 
                    )";

        return $this->db->query($query_insert);    
        
    }
    /**/
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
    /**/
    function update_q_servicio($param){

        $q =  $param["q"];
        $q2 = $param["q2"];
        $servicio =  $param["servicio"];

        $query_update ="UPDATE 
                            servicio 
                            SET  
                            $q = '".$q2."' 
                        WHERE id_servicio = '".$servicio."' LIMIT 1 ";
            if($q=="nombre_servicio"){

                $param["id_servicio"] = $servicio;
                $param["metakeyword"] =  $q2;    
                $param["id_servicio"] =  $servicio;
                $this->agrega_metakeyword_sistema($param);
            }

        return $this->db->query($query_update);
        
    }
    /**/
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
    /***/
    function create_grupo($param){

        $grupo =  $param["grupo"];
        $query_insert ="INSERT INTO grupo(grupo) VALUES('".$grupo."')";
        $this->db->query($query_insert);
        return $this->db->insert_id();  
    }
    /**/
    function valida_termino_aplicable($id_servicio , $id_caracteristica){


            $query_get =" SELECT COUNT(0)existe 
                FROM servicio_caracteristica 
                WHERE 
                id_caracteristica =  $id_caracteristica AND id_servicio =  $id_servicio";
            
            $result =  $this->db->query($query_get);            
            return $result->result_array()[0]["existe"];

    }
    /**/
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
    /**/
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
    /**/
    function get_grupos($param){
        /**/
        $query_get = "SELECT * FROM grupo";
        $result=  $this->db->query($query_get);        
        return $result->result_array();
    }
    /**/
    function cambia_ciclo_facturacion($param){
        
        $servicio = $param["servicio"];
        $id_ciclo_facturacion =  $param["ciclo_facturacion"];
        
        $query_update ="UPDATE 
                            precio 
                        SET        
                            id_ciclo_facturacion = '".$id_ciclo_facturacion."'
                            WHERE                             
                            id_servicio = '".$servicio."'
                        LIMIT 1";

        return $this->db->query($query_update);        

    }
    /**/
    function get_ciclos_facturacion($param){

        $query_update ="SELECT * FROM 
                            ciclo_facturacion";
        $result= $this->db->query($query_update); 
        return $result->result_array();
    }
    /**/
    function update_precio_servicio($param){

        $servicio = $param["servicio"];
        $costo = $param["costo"];
        $query_update ="UPDATE 
                            precio 
                        SET 
                            costo  = '".$costo."'
                            WHERE 
                            id_servicio = '".$servicio."'
                        LIMIT 1";

        return  $this->db->query($query_update);
        

    }
    /**/
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
    /**/
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
    /**/
    function get_servicios($param){
        
        $query_get = "SELECT * FROM servicio 
                      ORDER BY 
                      status DESC ";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_info_servicio($param){

        $id_servicio = $param["servicio"];
        $query_get = "SELECT 
                        * 
                      FROM 
                        servicio
                      WHERE 
                      id_servicio 
                      = 
                      '".$id_servicio."'                       
                      LIMIT 1 ";
        $result = $this->db->query($query_get);
        return $result->result_array();

    }
    /**/
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
    /**/
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
    /**/
    function create_termino_servicio($param){


        $id_servicio = $param["servicio"];        
        $termino = $param["termino"];                        
        /**/
        $query_insert ="INSERT INTO 
                            caracteristica(caracteristica)
                        VALUES('".$termino."')";
        $result = $this->db->query($query_insert);        
        
        $id_caracteristica=  $this->db->insert_id();  
        $param["caracteristica"] =  $id_caracteristica;
        return $this->asocia_termino_servicio($param);

    }
    /**/    
    function asocia_termino_servicio($param){


        $id_servicio = $param["servicio"];  
        $id_caracteristica =  $param["caracteristica"];
        
        /**/
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
    /**/
    function asocia_servicio_grupo($param){


        $id_servicio = $param["servicio"];  
        $id_grupo =  $param["grupo"];
        
        /**/
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

}