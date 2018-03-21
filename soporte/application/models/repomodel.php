<?php defined('BASEPATH') OR exit('No direct script access allowed');
class repomodel extends CI_Model {
	function __construct(){
	        parent::__construct();        
	        $this->load->database();
	}	
	/**/
	function reporta_error($param){

      $descripcion = $param["descripcion"];
      $query_insert =  "INSERT INTO 
                        incidencia(descripcion_incidencia , 
                          idtipo_incidencia , 
                          idcalificacion ,  
                          id_user ) 
                        VALUES('".$descripcion ."' , 4 ,  1 , 1)";
      return  $this->db->query($query_insert);                  
    }
	/**/
	function reporte_general_inicio_session($id_empresa){	
		/**/		
		$query_procedure  ="CALL estado_empresa($id_empresa)";	
		$this->db->query($query_procedure);
		/**/
		$query_get ="select  * from tmp_global_".$id_empresa;
		$result = $this->db->query($query_get);
		return $result ->result_array();
	}
	/**/
	function getUsuariosCuenta($idempresa)
	{
		$query_get =" select * from usuario where idempresa = '".$idempresa."' ";
		$result = $this->db->query($query_get);
		return $result ->num_rows();
		
	}
	/**/
	function get_tipos_incidencias($type){

		$query_get = "SELECT  * FROM tipo_incidencia WHERE type = '$type' ";
		$result =  $this->db->query($query_get);
		return $result->result_array();

	}
	/**/
	function get_calificaciones($tipo){

		$query_get =  "SELECT * FROM  calificacion WHERE tipo = '$tipo' "; 
		$result  =  $this->db->query($query_get);
		return $result->result_array();
	}
	/**/
	function insert_incidencia($param){
		/**/		
		$tipo_incidencia =  $param["tipo_incidencia"]; 
		$afectacion =  $param["afectacion"]; 
		$pagina_error =  $param["pagina_error"]; 
		$tipo_template  =  $param["tipo_template"]; 
		$descripcion = $param["descripcion"];
		$id_user  =  $param["id_user"]; 
		$tipo_template =  $param["tipo_template"]; 
		$num_calificacion =  $param["num_calificacion"];

		$query_insert = "INSERT INTO incidencia(
											idtipo_incidencia , 
											pagina_error, 										
											descripcion_incidencia ,  																				
											idcalificacion, 
											id_user, 
											tipo_propuesta,
											num_calificacion
										)
						VALUES(
								$tipo_incidencia , 
								'".$pagina_error ."', 
								'".$descripcion."', 
								$afectacion , 
								$id_user ,
								$tipo_template,
								$num_calificacion

								)"; 
		
		return $this->db->query($query_insert);	
	}
	/***************************************************** * ***************************************************** */	
	function global_empresa($id_empresa, $param){
		
		$_num =  get_random();
		$data["num_eventos"] = $this->create_tmps(0 ,  $_num ,  $id_empresa );
		
		if ($data["num_eventos"] > 0){
		

							$query_get = "SELECT 
							e.* ,
							a.num_accesos,
							ar.artistas ,
							p.evento_punto_venta, 							
							asis.asistencias, 
							r.reservantes ,
							r.prospectos 

							FROM tmp_evento_e_m_$_num e  
							LEFT OUTER JOIN  tmp_evento_e_m_promo_$_num a 
							ON  e.idevento =  a.idevento
							LEFT OUTER JOIN  tmp_evento_e_artistas_$_num ar
							ON e.idevento =  ar.id_evento
							LEFT OUTER JOIN tmp_evento_e_puntos_venta_$_num p 
							ON e.idevento =  p.idevento
							LEFT OUTER JOIN tmp_evento_asistentes_$_num asis
							ON e.idevento =  asis.idevento
							LEFT OUTER JOIN  tmp_reservaciones_$_num r 
							ON e.idevento  = r.idevento 
							ORDER BY  e.fecha_inicio DESC
							"; 
			$result = $this->db->query($query_get);									
			$data["repo_evento"] = $result->result_array();
			$this->create_tmps( 1 ,  $_num , $id_empresa  );			
			$data["query"] =  $query_get ;
		}


		$this->last_delete($_num , $param);
		return $data;
	}
	/**/
	function last_delete( $_num , $param){

		$query_drop =  "DROP TABLE IF exists tmp_evento_e_m_$_num"; 
		$this->db->query($query_drop);

	}
	/**/
	function create_tmps($flag, $_num ,  $id_empresa){
		
		$num_evento =  $this->create_tmp_evento_mes($flag , $_num  , $id_empresa);
		if ($num_evento > 0 ){

			$this->create_tmps_e($flag ,  $_num ,  $id_empresa ); 						
		}
		return $num_evento;
	}
	/**/
	function create_tmps_e($flag ,  $_num ,  $id_empresa ){

		$this->create_tmo_evento_promociones($flag , $_num);
		$this->create_tmp_artistas($flag , $_num); 
		$this->create_tmp_punto_venta($flag , $_num); 
		$this->create_tmp_asistentes($flag , $_num);
		$this->create_tmp_reservaciones($flag , $_num  , $id_empresa );
		
	}
	/**/
	function create_tmp_reservaciones($flag , $_num , $id_empresa ){

		$query_drop =  "DROP TABLE IF exists  tmp_reservaciones_$_num"; 	
		$this->db->query($query_drop);
		/**/
		if ($flag == 0 ){
			$query_create =  "CREATE TABLE tmp_reservaciones_$_num AS 
							   select 
							   idevento  ,
							   count(0)reservantes ,
							   sum(num_asistentes) prospectos   
							   from 
							   reservacion 
							   where idempresa='".$id_empresa."' 
							   group  by idevento";
			$this->db->query($query_create);
		}
		/**/

	}
	

	/**/
	function create_tmp_evento_mes($flag , $_num  , $id_empresa ){
	
		$query_drop = 'DROP TABLE IF exists tmp_evento_e_m_$_num'; 
		$db_response =    $this->db->query($query_drop);
		if ($flag == 0 ){	

			$query_create =  "CREATE TABLE tmp_evento_e_m_$_num AS 
								SELECT 
								idevento , 
								nombre_evento, 
								fecha_registro, 
								fecha_inicio , 
								fecha_termino ,
								edicion, 
								status , 
								url_social , 
								url_social_youtube, 
								formatted_address
								
								FROM evento 
								WHERE 
								idempresa = '$id_empresa' "; 
			
			$db_response  =  $this->db->query($query_create);

			$query_get =  "SELECT COUNT(0)num_eventos FROM tmp_evento_e_m_$_num"; 
			$result =  $this->db->query($query_get);
			$db_response =  $result->result_array()[0]["num_eventos"];		
		}
		return $db_response;	
	}
	/**/
	function create_tmo_evento_promociones($flag , $_num){

		$query_drop = "DROP TABLE IF exists tmp_evento_e_m_promo_$_num"; 
		$db_response = $this->db->query($query_drop);
		if ($flag ==  0 ){		
			$query_create =  "CREATE TABLE tmp_evento_e_m_promo_$_num  AS  
								SELECT 
								a.idevento ,
								count(0)num_accesos 
								FROM acceso a  INNER JOIN tmp_evento_e_m_$_num  e ON  a.idevento =  e.idevento 
								GROUP BY  a.idevento"; 
			$db_response = $this->db->query($query_create);						
		}
		return $db_response;
	}
	/**/
	function create_tmp_asistentes($flag , $_num){

		$query_drop = "DROP TABLE IF exists tmp_evento_asistentes_$_num"; 
		$db_response = $this->db->query($query_drop);
		if ($flag ==  0 ){		
			$query_create =  "CREATE TABLE tmp_evento_asistentes_$_num  AS  
								SELECT COUNT(0)asistencias , e.idevento 
								FROM 
								evento_asistente  a 
								INNER JOIN tmp_evento_e_m_$_num e 
								ON a.id_evento = e.idevento 
								GROUP BY  e.idevento"; 
			$db_response = $this->db->query($query_create);						
		}
		return $db_response;

	}
	/**/
	function create_tmp_artistas($flag , $_num){
		$query_drop =  "DROP TABLE IF exists tmp_evento_e_artistas_$_num"; 
		$this->db->query($query_drop);
		$db_response = 0; 

		if ($flag ==  0  ){

			$query_create = "
				CREATE TABLE tmp_evento_e_artistas_$_num AS  
				SELECT 
				ea.id_evento  ,  
				count(*)artistas 
				FROM tmp_evento_e_m_$_num  e 
				INNER JOIN evento_artista ea  
				ON  e.idevento =  ea.id_evento GROUP BY id_evento"; 	
			$db_response =  $this->db->query($query_create);		
		}
		return $db_response; 

	}
	/**/
	function create_tmp_punto_venta($flag , $_num){

		$query_drop =  "DROP TABLE IF exists tmp_evento_e_puntos_venta_$_num"; 
		$this->db->query($query_drop);
		$db_response = 0; 
		if ($flag ==  0  ){

			$query_create = "
							CREATE TABLE  tmp_evento_e_puntos_venta_$_num AS  
							SELECT e.idevento  , count(*)evento_punto_venta from tmp_evento_e_m_$_num e 
							INNER JOIN evento_punto_venta p 
							ON e.idevento =  p.idevento ";
			$db_response  =  $this->db->query($query_create);				
		}
		return $db_response; 
	}

	/**/
	function create_tmp_imagen_evento_e($flag , $_num){

		$query_drop ="DROP TABLE IF exists tmp_img_evento_e_$_num";
		$db_response =  $this->db->query($query_drop);

		if ($flag == 0 ){

				$query_create =  "CREATE TABLE  tmp_img_evento_e_$_num 
								AS  
								SELECT 	
								i.id_evento , 
								i.id_imagen  
								FROM  imagen_evento i 
								INNER JOIN tmp_evento_e_m_$_num  e 
								ON  i.id_evento =  e.idevento"; 

				$db_response =  $this->db->query($query_create);					
		}	
		return $db_response;
	}
	/**/
	function create_tmp_img_e($flag ,  $_num , $id_empresa){

		$query_drop ="DROP TABLE IF exists tmp_img_e_$_num";
		$db_response = $this->db->query($query_drop);

		if ($flag == 0){
			$query_create ="CREATE TABLE tmp_img_e_$_num  AS 
								SELECT 
								idimagen , 
								nombre_imagen , 
								img, 
								extension 
								FROM imagen i
								WHERE  
								i.id_empresa = '$id_empresa' 
								AND
								MONTH(fecha_registro) =  MONTH(CURRENT_DATE())
								AND 
								YEAR(fecha_registro) =  YEAR(CURRENT_DATE())"; 
			$db_response =   $this->db->query($query_create);					
						
		}
		return $db_response;


	}
	/**/
}/*Termina la función */