<?php defined('BASEPATH') OR exit('No direct script access allowed');
class valoracion_model extends CI_Model{
  	function __construct(){
      parent::__construct();        
      $this->load->database();      
  	} 
    /**/
    private function get_limit($param){
        /**/
        $page = (isset($param['page'])&& !empty($param['page']))?
        $param['page']:1;
        $per_page = $param["resultados_por_pagina"]; //la cantidad de registros que desea mostrar
        $adjacents  = 4; //brecha entre páginas después de varios adyacentes
        $offset = ($page - 1) * $per_page;    
        return " LIMIT $offset , $per_page ";
    }
    /**/
    function get_desglose_valoraciones_vendedor($param){

      $_num =  get_random();
      $this->create_tmp_servicios_usuario($_num , 1 , $param);
        $limit =  $this->get_limit($param);
        $query_get =  "SELECT v.* FROM  valoracion v 
                            INNER JOIN tmp_servicios_usuario_$_num u 
                            ON v.id_servicio =  u.id_servicio
                            ORDER BY valoracion DESC $limit";   
        $result =  $this->db->query($query_get);
        $data_complete["data"] =  $result->result_array();
        $data_complete["sql"] =  $result->result_array();
      $this->create_tmp_servicios_usuario($_num , 0 , $param);
      return $data_complete;
        
    }
    /**/
    function set_visto_pregunta($param){

      $campo ="leido_cliente";
      if($param["modalidad"] == 1) {
        $campo ="leido_vendedor";  
      }
      /***/
      $id_pregunta =  $param["id_pregunta"];      
      $query_update = "UPDATE 
                        pregunta 
                          SET $campo =  1 
                        WHERE 
                        id_pregunta =  $id_pregunta 
                        LIMIT 1";      
      return $this->db->query($query_update);
    }
    /**/
    function get_respuestas_pregunta($param){

      $id_pregunta =  $param["id_pregunta"];      
      $query_get = "SELECT 
                    r.respuesta     
                    ,r.fecha_registro
                    ,r.id_usuario    
                    ,r. id_pregunta
                    ,u.nombre 
                    ,u.apellido_paterno
                    FROM response r 
                      INNER JOIN  
                      usuario u 
                      ON r.id_usuario = u.idusuario
                    WHERE 
                      r.id_pregunta =  $id_pregunta 
                    ORDER BY 
                    fecha_registro
                    DESC LIMIT 10";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function create_tmp_servicios_venta_usuario($flag , $_num, $param){

      $query_drop = "DROP TABLE IF EXISTS tmp_servicio_usuario_$_num";
        $this->db->query($query_drop);

        if($flag == 0){          
          $id_usuario =  $param["id_usuario"]; 
          $query_create = "CREATE TABLE tmp_servicio_usuario_$_num AS 
                            SELECT id_servicio ,nombre_servicio
                            FROM servicio 
                            WHERE 
                              id_usuario = $id_usuario
                            AND
                              existencia >0
                            AND 
                              status = 1";
          $this->db->query($query_create);
        }
    }
    /**/
    function create_tmp_servicios_venta_usuario_pregunta($flag , $_num, $param){

      $query_drop = "DROP TABLE IF EXISTS tmp_servicio_usuario_pregunta_$_num";
        $this->db->query($query_drop);

        if($flag == 0){          
          $id_usuario =  $param["id_usuario"]; 
          $query_create = "CREATE TABLE tmp_servicio_usuario_pregunta_$_num AS 
                    SELECT 
                    p.* , 
                    ps.id_servicio ,
                    us.nombre_servicio 
                    FROM  
                    pregunta 
                    p 
                    INNER JOIN 
                    pregunta_servicio ps 
                    ON p.id_pregunta =  ps.id_pregunta
                    INNER JOIN 
                    tmp_servicio_usuario_$_num us 
                    ON  
                    ps.id_servicio =  us.id_servicio";
          $this->db->query($query_create);
        }
    }
    /**/
    function get_preguntas_realizadas_a_vendedor($param){
      
      $_num =  get_random();
      $this->create_tmp_servicios_venta_usuario(0 , $_num , $param);      
        /**/
        $this->create_tmp_servicios_venta_usuario_pregunta(0 , $_num, $param);
          $query_get ="SELECT * FROM 
                      tmp_servicio_usuario_pregunta_$_num 
                      ORDER BY 
                      leido_vendedor,
                      fecha_registro  DESC ";
          $result =  $this->db->query($query_get);          
          $data = $result->result_array();
          $data_complete = $this->add_num_respuestas_preguntas($data);

        $this->create_tmp_servicios_venta_usuario_pregunta(1 , $_num, $param);
      $this->create_tmp_servicios_venta_usuario(1 , $_num , $param);
      return  $data_complete;
      
    }
  	/**/
  	function get_preguntas_realizadas($param){
  		  
      $_num =  get_random();
      $this->create_tmp_preguntas_realizadas(0 , $_num , $param);      
        $this->create_tmp_preguntas_servicios(0 , $_num, $param);
          $query_get ="SELECT * FROM  
                        tmp_preguntas_servicios_$_num ORDER BY fecha_registro DESC";
          $result =  $this->db->query($query_get);
          $data = $result->result_array();
          $data_complete = $this->add_num_respuestas_preguntas($data);
        $this->create_tmp_preguntas_servicios(1 , $_num, $param);
      $this->create_tmp_preguntas_realizadas(1 , $_num , $param);
      return $data_complete;
      
  	}
    /**/
    function add_num_respuestas_preguntas($data){

      $data_complete = [];
      $a =0;
      foreach($data as $row){          
        $data_complete[$a] =  $row;
        $data_complete[$a]["respuestas"] = $this->get_num_respuestas_sin_leer($row["id_pregunta"]);
        $a ++;
      }
      return $data_complete;
    }
    /**/
    function get_num_respuestas_sin_leer($id_pregunta){

      $query_get = "SELECT 
                      COUNT(0)respuestas,  
                      SUM(CASE WHEN leido_cliente = 0 THEN 1 ELSE 0 END )sin_leer,
                      SUM(CASE WHEN leido_cliente = 0 THEN 1 ELSE 0 END )sin_leer_vendedor 
                    FROM response 
                    WHERE id_pregunta =  $id_pregunta";
      $result =  $this->db->query($query_get);
      return $result->result_array();
    }
    /**/
    function create_tmp_preguntas_servicios($flag , $_num , $param){

        $query_drop = "DROP TABLE IF EXISTS tmp_preguntas_servicios_$_num";
        $this->db->query($query_drop);

        if($flag == 0){          
          $query_create = "CREATE TABLE tmp_preguntas_servicios_$_num AS 
                    SELECT 
                      p.* , 
                      s.nombre_servicio, 
                      s.id_usuario id_usuario_venta
                    FROM  
                      tmp_preguntas_usuario_$_num  p 
                    INNER JOIN 
                    servicio s 
                      ON p.id_servicio =  s.id_servicio";
          $this->db->query($query_create);
        }     
    }
    /**/
    function create_tmp_preguntas_realizadas($flag , $_num , $param){

        $query_drop = "DROP TABLE IF EXISTS tmp_preguntas_usuario_$_num";
        $this->db->query($query_drop);

        if($flag == 0){
          $id_usuario =  $param["id_usuario"];
          $query_create = "CREATE TABLE tmp_preguntas_usuario_$_num AS 
                  SELECT p.* , ps.id_servicio FROM  
                    pregunta p 
                    INNER JOIN 
                    pregunta_servicio ps 
                    ON p.id_pregunta =  ps.id_pregunta
                    WHERE p.id_usuario = $id_usuario";
          $this->db->query($query_create);
        }     
    }
  	/**/
  	function registrar($param){

  		
  		$titulo = $param["titulo"];
  		$comentario = $param["comentario"];
  		$nombre = $param["nombre"];
  		$email = $param["email"];  	
  		$recomendaria = $param["recomendaria"];
  		$valoracion = $param["calificacion"];
  		$id_servicio =$param["id_servicio"];
  		
  		$query_insert ="INSERT INTO valoracion(
	  		valoracion          
	  		,titulo              
			,comentario          
			,recomendaria		
			,email 
			,nombre 
			,id_servicio
			)VALUES(
				'".$valoracion."',
				'".$titulo."',
				'".$comentario."',
				'".$recomendaria."',
				'".$email."',
				'".$nombre."',
				$id_servicio
			)";

			return  $this->db->query($query_insert);
  	}
  	/**/
  	function get_valoraciones($param){

  		$id_servicio = $param["servicio"];
  		$query_get="SELECT * FROM  valoracion WHERE id_servicio =$id_servicio ORDER BY id_valoracion DESC LIMIT 6";
  		$result =  $this->db->query($query_get);
  		return $result->result_array();

  	}
  	/**/
  	private function create_tmp_servicios_usuario($_num , $flag , $param){

  		$query_drop = "DROP TABLE IF EXISTS tmp_servicios_usuario_$_num";
  		$this->db->query($query_drop);
  		if($flag == 1){
  			$id_usuario =  $param["id_usuario"];
  			$query_create = "CREATE TABLE tmp_servicios_usuario_$_num 
  							AS 
  							SELECT id_usuario , id_servicio   
  							FROM 
  								servicio 
  							WHERE 
  								id_usuario =$id_usuario";	
  			$this->db->query($query_create);
  		}  		
  	}  	
  	/**/
  	function get_valoraciones_usuario($param){
  		$_num =  get_random();
  		$this->create_tmp_servicios_usuario($_num , 1 , $param);
  			$id_usuario =  $param["id_usuario"];
  			$query_get ="SELECT 
						COUNT(0)num_valoraciones,
							AVG(valoracion) promedio ,
							SUM(CASE WHEN recomendaria = 1 
							THEN 1 
							ELSE 0 
							END 
							)personas_recomendarian
						FROM 
							valoracion v 
						INNER JOIN 
							tmp_servicios_usuario_$_num s 
						ON 
							v.id_servicio= s.id_servicio
						WHERE 
							s.id_usuario =  $id_usuario";
			$result =  $this->db->query($query_get);
			$data_complete =  $result->result_array();
  		$this->create_tmp_servicios_usuario($_num , 0 , $param);
  		return $data_complete;
  	}
  	/**/
	function get_valoraciones_articulo($param){        
		$id_servicio=  $param["servicio"];
	    return $this->get_numero_valoraciones_servicio($id_servicio);
	}	
	/**/
	function get_numero_valoraciones_servicio($id_servicio){
		
		$query_get = "SELECT 
						COUNT(0)num_valoraciones,
						AVG(valoracion) promedio ,
						SUM(CASE WHEN recomendaria = 1 THEN 1 ELSE 0 END )personas_recomendarian
					FROM 
						valoracion 
					WHERE 
						id_servicio = $id_servicio";	    
		$result =  $this->db->query($query_get);
		return $result->result_array();
	}
 	/**/
 	function utilidad($param){

 		$id_valoracion =  $param["valoracion"];
 		$campo_a_actualizar = " num_no_util = num_no_util + 1 ";
 		if($param["utilidad"] == 1){
 			$campo_a_actualizar = " num_util = num_util + 1 ";	
 		}
 		$query_update ="UPDATE 
 						valoracion 
 						SET 
 							".$campo_a_actualizar."
 						WHERE 
 						id_valoracion = $id_valoracion LIMIT 1";
 						return $this->db->query($query_update);
 	}
 	/**/
 	function registra_pregunta($param){

 		$pregunta =  $param["pregunta"]; 
 		$id_servicio =  $param["servicio"]; 
 		$id_usuario =  $param["usuario"];

 		$query_insert ="INSERT INTO 
 							pregunta(pregunta , id_usuario) 
	 						VALUES(
	 						'".$pregunta."' , 
	 						'".$id_usuario."'
	 						)";
 			
 		$this->db->query($query_insert);
 		$id_pregunta =  $this->db->insert_id();
 		/**/
 		return $this->agrega_pregunta_servicio($id_pregunta , $id_servicio);
 	}
 	/**/
 	function agrega_pregunta_servicio($id_pregunta , $id_servicio){

 		/**/
 		$query_insert = "INSERT INTO  pregunta_servicio(id_pregunta , id_servicio )
 						 VALUES($id_pregunta  , $id_servicio)";
 		return $this->db->query($query_insert);
 	}
  /**/
  function registra_respuesta($param){

    $id_usuario =  $param["id_usuario"];    
    $id_pregunta =  $param["pregunta"];    
    $respuesta =  $param["respuesta"];

    /**/
    $query_insert = "INSERT INTO response(                      
                        respuesta   ,                        
                        id_pregunta ,
                        id_usuario 

                      )
                      VALUES(
                        '".$respuesta."', 
                          $id_pregunta,
                          $id_usuario
                      )";
    return  $this->db->query($query_insert);    
  }
}


