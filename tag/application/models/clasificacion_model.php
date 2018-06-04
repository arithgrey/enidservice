<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class clasificacion_model extends CI_Model {
    public $lista_categorias_nombre=[];
    public $options;
    public $hijo=0;

    function __construct($options=[]){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function get_clasificaciones_por_id_servicio($id_servicio){

        $query_get = "SELECT 
                        id_servicio,
                        primer_nivel,  
                        segundo_nivel, 
                        tercer_nivel,  
                        cuarto_nivel,  
                        quinto_nivel  
                     FROM servicio WHERE id_servicio = $id_servicio LIMIT 1";
        $result = $this->db->query($query_get);
        return $result->result_array();
    }
    function set_option($key , $val ){
    	$this->options[$key] = $val;
    }
    /**/
    function get_option($key){
    	return $this->options[$key];
    }
    /**/
    function get_clasificaciones_primer_nivel($param){

        $query_get = "SELECT 
                        id_clasificacion
                        ,nombre_clasificacion                                                
                      FROM 
                        clasificacion 
                      WHERE 
                      primer_nivel =1";
                      $result =  $this->db->query($query_get);
                      return $result->result_array();
    }

    /**/
    function get_clasificaciones_por_id($param){

    	/**/    	
    	$id_clasificacion =  $param["id_clasificacion"];
    	$clasificacion_padre =  $this->get_clasificacion_por_id($id_clasificacion);
    
    	if (count($clasificacion_padre) > 0){
    		$categorias =  $clasificacion_padre[0];  
    		$this->agrega_categorias($categorias );    			
    		/**/
    		$id_clasificacion =  $categorias["id_clasificacion"];
    		$this->busca_hijos(6 , $clasificacion_padre);	
    	}
   		return $this->get_lista_categorias_nombre();  
    }
 	/**/
 	function busca_hijos($limit, $padre){

 		if (count($padre) > 0) {
 			
 			if ($limit > 0 ){ 		
 				
 				$id_padre = $padre[0]["id_clasificacion"];
 				$nuevo_padre = $this->get_clasificacion_por_padre($id_padre);
 				if (count($nuevo_padre) >0) {
 					$this->agrega_categorias($nuevo_padre[0]);	
 				}
 				
	 			$limit --;
	 			$this->busca_hijos($limit , $nuevo_padre);
 			}	
 		}
 		
 	}
 	/**/
 	function get_clasificacion_por_padre($padre){

 		$query_get = "SELECT 
    					id_clasificacion
						,nombre_clasificacion
						,flag_servicio
						,padre

    				  FROM clasificacion 
    				  WHERE 
    				  padre  = $padre LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
        
 	}
    /**/
    function get_clasificacion_por_id($id_clasificacion){

    	$query_get = "SELECT 
    					*
    				  FROM clasificacion 
    				  WHERE 
    				  id_clasificacion = 
    				  $id_clasificacion 
    				  LIMIT 1";
        $result =  $this->db->query($query_get);
        return $result->result_array();        

    }
   	/**/
    function agrega_categorias($nombre_gategoria){
    	array_push($this->lista_categorias_nombre , $nombre_gategoria);
    }
    /**/
    function get_lista_categorias_nombre(){
    	return $this->lista_categorias_nombre;
    }
    /**/
    function get_clasificaciones_segundo($array_padre){

        /**/
        $nueva_data =[];
        $a =0;
        foreach ($array_padre as $row) {
            
            $nueva_data[$a] = $row;
            $padre =  $row["id_clasificacion"];
            $nueva_data[$a]["hijos"] = $this->get_clasificaciones_por_padre($padre);
            $a ++;
        }
        return $nueva_data;
    }
    /**/
    function get_clasificaciones_por_padre($padre){

        $query_get = "SELECT 
                        id_clasificacion
                        ,nombre_clasificacion                        
                      FROM 
                        clasificacion 
                      WHERE 
                      padre  = $padre";
        $result =  $this->db->query($query_get);
        return $result->result_array();
        
    }
    /**/
    function get_nombre_clasificacion_por_id_clasificacion($param){
        $id_clasificacion =  $param["id_clasificacion"];

        $query_get = "SELECT                         
                        nombre_clasificacion                        
                      FROM 
                        clasificacion 
                      WHERE 
                      id_clasificacion  = $id_clasificacion";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["nombre_clasificacion"];          
    }
    /**/
    function get_clasificaciones_por_id_clasificacion($param){

        $id_clasificacion =  $param["id_clasificacion"];

        $query_get = "SELECT                         
                        id_clasificacion, 
                        nombre_clasificacion                        
                      FROM 
                        clasificacion 
                      WHERE 
                      id_clasificacion  = $id_clasificacion";
        $result =  $this->db->query($query_get);
        return $result->result_array();             
    }
    /**/
    function  get_clasificaciones_destacadas($param){
        
        $query_get ="SELECT primer_nivel, count(0)total
                    FROM servicio 
                    WHERE 
                    status =1 
                    AND existencia >0 
                    GROUP BY 
                    primer_nivel
                    ORDER BY count(0) DESC";
        $result =  $this->db->query($query_get);
        return $result->result_array(); 
    }
    /**/
    function get_clasificaciones_primer_nivel_nombres($param){
        
        $query_get ="SELECT nombre_clasificacion ,id_clasificacion , flag_servicio  FROM clasificacion WHERE primer_nivel=1";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    /**/
    function get_intereses_usuario($param){

        $id_usuario =  $param["id_usuario"];

        $query_get ="
            SELECT 
                c.id_clasificacion,
                c.nombre_clasificacion,
                uc.id_usuario 
            FROM 
                clasificacion c
            LEFT OUTER JOIN 
                usuario_clasificacion uc 
            ON 
                c.id_clasificacion = uc.id_clasificacion
            AND  
                uc.tipo =2
            AND  
                uc.id_usuario =$id_usuario
            WHERE 
                c.primer_nivel =1 
            AND 
                c.flag_servicio =0";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }   
    /**/
    function interes_usuario($param)
    {
        /*Verifica que esté */
        $num = $this->get_interes_usuario($param);        
        $response["tipo"] =0;
        if ($num >0 ) {
            /*Baja*/
            $this->delete_interes_usuario($param);            
        }else{
            /*Alta*/
            $this->insert_interes_usuario($param);
            $response["tipo"] =1;
        }
        return $response;
    }
    /**/
    function get_interes_usuario($param)
    {   
        $id_usuario =  $param["id_usuario"];
        $id_clasificacion =  $param["id_clasificacion"];

         $query_get ="
            SELECT 
                COUNT(0)num
            FROM                 
            usuario_clasificacion  uc             
            WHERE 
                uc.tipo =2
            AND  
                uc.id_usuario =$id_usuario
            AND 
                uc.id_clasificacion = $id_clasificacion
            ";
        $result =  $this->db->query($query_get);
        return $result->result_array()[0]["num"];
    }
    /**/
    private function delete_interes_usuario($param)
    {   
        $id_usuario         =  $param["id_usuario"];
        $id_clasificacion   =  $param["id_clasificacion"];

         $query_delete ="DELETE  FROM                 
            usuario_clasificacion  
            WHERE 
                tipo =2
            AND  
                id_usuario =$id_usuario
            AND 
                id_clasificacion = $id_clasificacion";
        return $this->db->query($query_delete);
        
    }
    /**/
    private function insert_interes_usuario($param)
    {
        $id_usuario         =  $param["id_usuario"];
        $id_clasificacion   =  $param["id_clasificacion"];

        $query_insert =  "INSERT INTO usuario_clasificacion(
                                id_usuario       
                                ,id_clasificacion 
                                ,tipo) 
                            VALUES(
                                '".$id_usuario."' , 
                                '".$id_clasificacion."',
                                2)";                          
                                return $this->db->query($query_insert);
    }


}