<?php defined('BASEPATH') OR exit('No direct script access allowed');
  class afiliadosmodel extends CI_Model {
    function __construct(){      
        parent::__construct();        
        $this->load->database();
    }
    /**/
    function create_ventas_por_periodo($param){

        /**/     
        $_num =  get_random();   
        $sql = $this->create_temp_ventas_afiliados(0 , $_num , $param);

            $query_get =  "SELECT 
                                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END )ventas_efectivas,
                                SUM(CASE WHEN status = 6 THEN 1 ELSE 0 END )solicitudes,
                                fecha
                            FROM 
                                tmp_ventas_afiliados_$_num                                
                            GROUP BY 
                            fecha
                            ORDER BY 
                            fecha 
                            ASC";                        
            
            $result =  $this->db->query($query_get);
            $data_complete  =  $result->result_array();

        $this->create_temp_ventas_afiliados(1 , $_num , $param);
        return $data_complete;
        

    }
    /**/
    function create_temp_ventas_afiliados($flag , $_num , $param ){

        /**/
      $query_drop  = "DROP  TABLE IF exists tmp_ventas_afiliados_$_num";
      $this->db->query($query_drop);
      
      if($flag == 0 ){
        
        $fecha_inicio =  $param["fecha_inicio"];
        $fecha_termino =  $param["fecha_termino"];
        $query_get = "CREATE TABLE  tmp_ventas_afiliados_$_num AS 
                        SELECT 
                        DATE(fecha_registro)fecha , 
                        status  
                        FROM 
                        proyecto_persona_forma_pago 
                        WHERE 
                        id_usuario_referencia != 180
                        AND 
                        fecha_registro                         
                        BETWEEN 
                        '".$fecha_inicio."' 
                        AND  
                        '".$fecha_termino."'";
                    $this->db->query($query_get);                
      }
      /**/

    }   
    /**/
    function get_info_usuario($param){
        $id_usuario =  $param["id_usuario"];
        $query_get =  "SELECT 
        nombre ,
        apellido_paterno   ,
        apellido_materno   ,
        email          
        FROM usuario WHERE idusuario=$id_usuario";
        $result =  $this->db->query($query_get);
        return $result->result_array();

    }
    /**/
    function get_usuarios_afiliados($param){

        $query_get =  "SELECT idusuario  id_usuario FROM usuario_perfil WHERE idperfil=19";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }
    function get_usuarios_con_ganancias_comisiones($param){


        $query_get ="SELECT  
                        DISTINCT(id_usuario_referencia)id_usuario
                        FROM proyecto_persona_forma_pago 
                    WHERE 
                        flag_pago_comision=0 
                    GROUP BY id_usuario_referencia";
        $result =  $this->db->query($query_get);
        return $result->result_array();
    }    
    /**/
    function get_ganancias_afiliado($param){

        $id_usuario =  $param["id_usuario"];
        $query_get = "SELECT                              
                        SUM(CASE WHEN  1 > 0 THEN (pp.precio - pp.costo) 
                        ELSE 0 END )ganancias
                        FROM 
                        proyecto_persona_forma_pago   ppfp
                        INNER JOIN
                        proyecto_persona pp 
                        ON  ppfp.id_proyecto_persona =  pp.id_proyecto_persona
                        WHERE  
                        ppfp.id_usuario_referencia = $id_usuario
                        AND 
                        ppfp.flag_pago_comision = 0 
                        AND 
                        ppfp.saldo_cubierto >=  ppfp.monto_a_pagar";

                        $result = $this->db->query($query_get);
                        
                        $arr_ganancias =  $result->result_array();
                        if (count($arr_ganancias) > 0 ) {
                            return $arr_ganancias[0]["ganancias"]; 
                        }else{
                            return 0;
                        }
                        

    }    
    /**/
    function get_metodos_de_pago_registrados($param){
       
       /**/      
       $id_usuario =  $param["id_usuario"];
       $query_get =   "SELECT * FROM  
                        cuenta_pago  c 
						INNER JOIN banco b 
							ON c.id_banco =  b.id_banco
						WHERE c.id_usuario = $id_usuario";
		
		$result =  $this->db->query($query_get);
		return $result->result_array();
       
    }    
    /**/
    function get_bancos(){
    	
    	$query_get = "SELECT * FROM  banco";		
		$result =  $this->db->query($query_get);
		return $result->result_array();
    }
    /**/
    function get_nombre_usuario($param){


    	$id_usuario =  $param["id_usuario"];
    	$query_get = "SELECT 
	    	nombre ,
	    	apellido_paterno ,
	    	apellido_materno
    	FROM  usuario 
    	WHERE idusuario = '".$id_usuario."' LIMIT 1";		

		$result =  $this->db->query($query_get);
		return $result->result_array();
    }
    /**/
    function insert_cuenta_pago($param){


        $id_usuario =  $param["id_usuario"];
        $numero_tarjeta =  $param["numero_tarjeta"];
        $banco = $param["banco"]; 
        $propietario = $param["propietario"]; 
            
        
        $query_get = "SELECT 
                        COUNT(0)num_cuentas_usuario 
                        FROM 
                        cuenta_pago 
                        WHERE id_usuario = '".$id_usuario."'";

        $result =  $this->db->query($query_get);
        $num_cuentas_usuario =  $result->result_array();

        
        if ($num_cuentas_usuario[0]["num_cuentas_usuario"] > 0) {
                
                    $query_update ="UPDATE  cuenta_pago
                        SET                         
                        numero_tarjeta    =  '".$numero_tarjeta."' ,  
                        propietario_tarjeta =  '".$propietario."' ,  
                        id_banco =  '".$banco."'
                        WHERE id_usuario = '".$id_usuario."' ";
        
                    return  $this->db->query($query_update);

        }else{

                $query_insert ="INSERT INTO cuenta_pago(
                        id_usuario ,        
                        numero_tarjeta     ,
                        propietario_tarjeta,
                        id_banco
                        )                        
                        VALUES(
                        '".$id_usuario."' , 
                        '".$numero_tarjeta."' ,  
                        '".$propietario."' ,  
                        '".$banco."')";
        
                return  $this->db->query($query_insert);
        }
        
      
    }
    
}