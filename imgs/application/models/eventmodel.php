<?php defined('BASEPATH') OR exit('No direct script access allowed');
class eventmodel extends CI_Model{
function __construct(){
	parent::__construct();        
    $this->load->database();
}
/**/
function get_imgs_evento($param){
	
	$id_evento =  $param["id_evento"];
	$query_get =  "select  id_imagen from imagen_evento WHERE id_evento =$id_evento LIMIT 1;";    
	$result = $this->db->query($query_get);
	$imagen_evento =  $result->result_array();

	//$data_complete["num_img"]   =  count($imagen_evento);	
	$data_complete["info_img"] = $imagen_evento;
	return $data_complete;	
}
/**/
function get_imgs_evento_galeria($param){
	
	$id_evento =  $param["id_evento"];
	$query_get =  "select  id_imagen from imagen_evento WHERE id_evento =$id_evento LIMIT 5;";    
	$result = $this->db->query($query_get);
	$imagen_evento =  $result->result_array();

	//$data_complete["num_img"]   =  count($imagen_evento);	
	$data_complete["info_img"] = $imagen_evento;
	return $data_complete;	
}


/**/
function verifica_propiedad($id_evento ,  $id_user , $id_empresa ){

	$query_get =  "SELECT count(0) propietario FROM evento WHERE idevento = $id_evento AND idempresa =  $id_empresa LIMIT 1";
	$result =  $this->db->query($query_get);
	return $result->result_array()[0]["propietario"];

}
/**/
function get_reservaciones($param){

	$query_get =  "SELECT * FROM  reservacion WHERE idevento = '".$param["id_evento"]."'  ";
	$result = $this->db->query($query_get);
	return $result->result_array();
}
/**/
function get_asistencia_user($param){


	$query_get =  "SELECT 
	count(0)asistentes 
	FROM  evento_asistente 
	WHERE id_evento='".$param["evento"]."' 
	AND ip= '". $param["ip_user"]."' LIMIT 1";


	$result =  $this->db->query($query_get);
	$num =   $result->result_array()[0]["asistentes"];

	if ($num > 0){

		$query_delete =  "DELETE  FROM  evento_asistente WHERE  id_evento='".$param["evento"]."' 
		AND ip= '". $param["ip_user"]."' LIMIT 1"; 
		$this->db->query($query_delete);

	}else{
		/**/
		$query_insert =  "INSERT IGNORE  INTO asistente(ip) VALUES('". $param["ip_user"]."');"; 
		$this->db->query($query_insert);

		$query_get =  "SELECT  id_asistente FROM  asistente WHERE ip = '". $param["ip_user"]."' LIMIT 1 ";
		$result =  $this->db->query($query_get);
		$id_asistente =  $result->result_array()[0]["id_asistente"];
	
		$query_insert =  "INSERT INTO  
						 evento_asistente(id_evento ,  id_asistente ,  ip ) 
						 VALUES( '". $param["evento"]."'  , '".  $id_asistente  ."'  ,  '". $param["ip_user"]."' )";  
	
		$this->db->query($query_insert);	
	}
	return $num;
	
}
/**/
function get_asistentes($param){
	/**/
	$query_get =  "select count(0)asistentes from evento_asistente where id_evento='".$param["evento"]."' ";
	$result =  $this->db->query($query_get);
	return $result->result_array()[0]["asistentes"];
}
/**/
function get_resum_by_id_event($id_evento){

	$_num =  $this->contruye_tmp_evento_edit($id_evento , 0  ); 	
	$query_get ="
				select 
				ee.* , 
				ea. artistas , 
				ep.evento_punto_venta, 
				es.generos_musicales, 
				eserv.servicios 
				from    
				v_eventos_escena_e_$_num  ee 
				left outer join v_escenarios_artistas_e_$_num ea  on  ee.idevento  =   ea.idevento			
				left outer join v_evento_punto_v_$_num ep on ee.idevento = ep.idevento	
				left outer join  v_evento_sound_$_num es  on ee.idevento = es.idevento 
				left outer join v_event_serv_$_num   eserv  on  ee.idevento = eserv.idevento";
				

	$result = $this->db->query($query_get);
	$data_complete =  $result->result_array();
	$_num =  $this->contruye_tmp_evento_edit($id_evento , 1 , $_num ); 
	return $data_complete; 
}
/**/
function get_img_evento($id_evento){

	$query_get = "select * from imagen_evento where id_evento = $id_evento LIMIT 10";
	$result=  $this->db->query($query_get);
	return $result->result_array();
	/**/
}
/**/
function getTematicaByid($idevento , $idempresa ){
		
	$query_get ="SELECT t.* , et.idevento , et.idtematica as idtem 	
	FROM tematica as t LEFT OUTER JOIN  evento_tematica as et 
	ON t.idtematica = et.idtematica and et.idevento = '".$idevento."' ORDER BY  t.tematica_evento asc";
	$result = $this->db->query($query_get);
	return $result->result_array();
}
/**/
function update_tematicaby_id( $idevento , $idtematica, $idempresa ){
	
	$query_delete ="DELETE FROM evento_tematica WHERE idevento ='".$idevento."' limit 1";
	$resultado_count = $this->db->query($query_delete);
	$dinamic_query ="INSERT INTO evento_tematica VALUES( '".$idevento."' , '".$idtematica."' )";
	$r = $this->db->query($dinamic_query);
	return $r;
}
/*Los ultimos eventos vividos */
function get_last_events_experience($num , $less ){

	$query_get ="SELECT  e.* , count(es.idescenario) as totalescenarios  FROM evento as e
	left outer join escenario as es on e.idevento = es.idevento 
    where e.idevento != '".$less."' and  e.idempresa = (SELECT idempresa FROM evento WHERE idevento = 1 ) 
    group by e.idevento ORDER BY e.fecha_registro DESC LIMIT $num";
	$result = $this->db->query($query_get);
	return $result ->result_array();      
	
}
/*Los últimos eventos registrados de la empresa*/
function get_last_events($id_empresa , $num ){

	/**/
	$_num =  $this->carga_base_img_event(0 , $id_empresa );
	$_num_img  =  $this->carga_img_base_enid( 1 , 0 ); 		

	$query_get ="
	select 
	e.escenarios,
	e.idevento ,
	e.nombre_evento , 
	e.descripcion_evento , 
	e.fecha_inicio, 
	e.fecha_termino, 
	e.descripcion_evento,
	e.eslogan,
	e.edicion, 
	e.tipo, 
	ea.artistas , 
	epv.evento_punto_venta, 
	es.servicios , 
	ra.accesos 
	, i.*    
	from repo_eventos_escenarios_$_num e
	left outer join  repo_escenarios_artistas_$_num ea 
	on e.idevento = ea.idevento 
	left outer join repo_evento_puntos_venta_$_num epv 
	on  e.idevento =  epv.idevento
	left outer join repo_evento_servicios_$_num  es 
	on e.idevento =  es.idevento
	left outer join reporte_evento_accesos_$_num ra 
	on e.idevento =  ra.idevento
	left outer join imagen_evento ie 
	on ie.id_evento =  e.idevento
	left outer join tmp_img_$_num_img  i 
	on ie.id_imagen =  i.idimagen
	group by e.idevento
	ORDER by e.idevento desc
	LIMIT $num ";

	$result = $this->db->query($query_get);
	$data_complete  =   $result ->result_array();      

	$this->carga_base_img_event(1 , $id_empresa , $_num  );
	$this->carga_img_base_enid( 1 , 1 , $_num_img); 

	return $data_complete; 

}
/*check if exist*/
function checkifexist($idevento){
	
	$query_exist ="SELECT count(0)existe FROM evento where  idevento ='". $idevento ."' LIMIT 1 ";
	$result = $this->db->query($query_exist);
	return $result->result_array()[0]["existe"];
}/*Termina la función*/
function getEventbyid($id_evento){	
	$query_get ="SELECT * FROM evento WHERE idevento = '".$id_evento."' limit 1 ";
	$result = $this->db->query($query_get);
	return $result ->result_array();      
}
/**/

/*Actualiza el campo descripcion por uno que ya se encuentra registrado en un contenido*/
function getObjetosPermitidos($id_evento , $id_empresa){

	$query_get = "select  o.* , eo.idempresa , evo.idevento 	
	from objetopermitido as o 
	inner join empresa_objetopermitido as eo 
	on o.idobjetopermitido = eo.idobjetopermitido
	and eo.idempresa=  '". $id_empresa."' 
	left outer join evento_objetopermitido as evo 
	on eo.idobjetopermitido = evo.idobjetopermitido
	and evo.idevento = '".$id_evento."' group by o.nombre";
	$result = $this->db->query($query_get);
	return $result ->result_array();      
	
}
/*Pasados **Pasados **Pasados **Pasados **Pasados **Pasados **Pasados */
function get_time_events_byid($idempresa ){

	$query_get ="SELECT  e.idevento , e.nombre_evento, e.descripcion_evento , e.fecha_inicio , 
	e.fecha_termino ,
	e.url_social, e.url_social_youtube, e.portada , e.status  as estadoevento , e.edicion ,
	count(es.idescenario) as totalescenarios 
	FROM evento as e
	left outer join escenario as es 
	on e.idevento = es.idevento 
	where e.idempresa ='". $idempresa."' 
	group by e.idevento";
	$result = $this->db->query($query_get);
	return $result ->result_array();   
}
/**End Pasados **End Pasados **End Pasados **End Pasados **End Pasados **/
function get_servicios_evento_by_id($id_evento){

	$query_get ="select * from servicio as s, evento_servicio as es
	 where es.idevento = '".$id_evento."' and s.idservicio = es.idservicio";
	$result = $this->db->query($query_get);
	return $result->result_array();
}
/*********************        **************************               *****************/
function delete_byid($id_evento , $id_usuario , $id_empresa ){

	$query_procedure="call delete_evento_all_data('". $id_evento ."'  , '". $id_usuario ."' );";
	return $this->db->query($query_procedure);
}
/**/
function get_list_generos_musicales_byidev($id_evento){

	$query_get ="select g.idgenero_musical, g.nombre  from genero_musical as g 
		inner join evento_genero_musical as egm
		on   g.idgenero_musical = egm.idgenero_musical 
		where egm.idevento = '".$id_evento. "'";

	$result = $this->db->query($query_get);				
	return $result->result_array();
}
/****************** ****************** ****************** ****************** ****************** */
/* get listobjetos permitidos del evento */
function get_obj_permitidos($id_evento){
	$query_get = "SELECT op.idobjetopermitido ,  op.nombre  , op.* FROM  objetopermitido AS op 
	INNER JOIN  evento_objetopermitido eop 
	ON  op.idobjetopermitido = eop.idobjetopermitido 
	WHERE  eop.idevento='". $id_evento."' ORDER BY  nombre";

	$result_obj = $this->db->query($query_get);
	return $result_obj->result_array();
}
/**/
function update_all_in_event_obj_inter($id_evento , $id_empresa ){

	$query_procedure ="call update_all_obj_in_event( $id_evento , $id_empresa );";		
	$result = $this->db->query($query_procedure);			
	return $result->result_array();
}
/**/
function update_status_by_id( $id_evento , $nuevo_status ,  $id_usuario ){
	$query_update =  "UPDATE  evento SET  status = '".$nuevo_status."'  WHERE  idevento = '$id_evento'  "; 	
	return  $this->db->query($query_update);
}
/**/
function get_event_text_by_id( $id_evento , $campo ){
	$query_get = "SELECT $campo FROM evento WHERE idevento = '". $id_evento ."' ";
	$result = $this->db->query($query_get);
	return $result ->result_array();
}
/**/
function update_diferencias_dias($id_evento){	
	/**/
	$query_update =  "SELECT datediff(fecha_registro , fecha_inicio)dif_dias from  evento  WHERE idevento='".$id_evento."'  limit 1";	
	$result =  $this->db->query($query_update);
	$num_dias =  $result->result_array()[0]["dif_dias"];
	//$num_dias =  variant_abs($num_dias);
	/*update*/
	$query_update ="UPDATE evento SET periodo_publicacion = ". $num_dias ."  WHERE idevento='".$id_evento."'  limit 1";	
	$result =   $this->db->query($query_update);
	return $result;
}
/*retorna el escenairo por el id del escenario*/
function get_by_escenario($id_escenario){

	$query_get ="select 
				*  
				from evento e  
				inner join 
				escenario esc on e.idevento = esc.idevento  
				where esc.idescenario = '".$id_escenario."'  ";	
	$result =  	$this->db->query($query_get);
	return $result->result_array();
}
/**/
function get_generos($id_empresa , $id_evento , $genero_filtro){

	$query_get ="select g.* , egm.idevento  , egm.idgenero_musical  idg  from genero_musical g 
	left outer join evento_genero_musical egm 	
	on g.idgenero_musical =  egm.idgenero_musical  and egm.idevento = '".$id_evento."'
	where nombre like '".$genero_filtro."%' LIMIT 5";		

	$result  = $this->db->query($query_get);
	return $result->result_array();

}
/**/
function get_days_to_event($fecha_inicio){

	$query_get = "SELECT DATEDIFF( '". $fecha_inicio."' , CURRENT_DATE() ) AS DateDiff";
	$result = $this->db->query($query_get); 
	return $result->result_array(); 
}
/**/
  function carga_base_img_event( $flag  , $id_empresa , $_num = 0 ){      
    if($_num == 0 ) {
       $_num = mt_rand();       
    }      												  
    $query_temporal_tables =  "call repo_eventos_admin($_num , $flag  , $id_empresa);"; 
	$this->db->query($query_temporal_tables);	
	return $_num;

  }
  /**/
  function create_tmp_img($tipo , $flag  , $_num = 0){

  	$query_drop =  "DROP TABLE if exists tmp_img_$_num"; 
  	$db_response = $this->db->query($query_drop);
  	
  	if ($flag == 0 ){
  			
  		$query_create = "CREATE TABLE tmp_img_$_num AS  
				  		SELECT  idimagen, nombre_imagen,  img  FROM 
					    imagen WHERE  type ='".$tipo."' ";

		$db_response = $this->db->query($query_create);

  	}
  	return $db_response;

  }
  /**/    
  function carga_img_base_enid($tipo , $f  , $_num = 0 ){      
      if($_num == 0 ) {
        $_num = mt_rand();       
      }
      $query_procedure ="CALL create_tmp_img(".$tipo." , $_num  , $f );";
      $this->db->query($query_procedure);
      return $_num;
  }
  /**/
  function get_resumen_artistas($param){
  	$id_evento =  $param["id_evento"];
  	$query_get =  "select * from evento_artista where id_evento = $id_evento limit 5"; 
  	$result = $this->db->query($query_get);
  	return $result->result_array();
  }
  /**/
  function get_resumen_accesos($param){
  	$id_evento =  $param["id_evento"];
  	$query_get = "SELECT *  FROM  acceso WHERE idevento = $id_evento ORDER BY 	inicio_acceso DESC"; 
  	$result =  $this->db->query($query_get);  	
  	return $result->result_array();
  }
  /**/
  function programa_evento($param){
  	$id_evento =  $param["id_evento"];  	
  	$this->update_status_by_id( $id_evento , 4  ,  $param["id_usuario"] );   
  	$query_update =  "UPDATE  evento SET programado = '". $param["fecha_programado"]."' WHERE idevento = '$id_evento' LIMIT 1 "; 
  	$result =  $this->db->query($query_update);
  	return $result;   	
  }
  /**/
  function cancelar($param){

  	$query_update =  "UPDATE evento 
				  	  SET 
				  	  status = '2' ,  
				  	  id_motivo_cancelacion = '".$param["motivo_cancelacion"]."' , 
				  	  nota_cancelacion = '".$param["nota_cancelacion"]."'  , 
				  	  feha_cancelacion = now()
				  	  WHERE 
				  	  idevento = '".$param["id_evento"]."'  " ;  	
				  	$result =  $this->db->query($query_update);
				  	return $result;   	  	
  }
  /**/
  function get_submotivos(){
	$query_get =  "SELECT * FROM motivo_cancelacion";   	
	$result =  $this->db->query($query_get);
	return $result->result_array();
  }
  /**/
function get_generos_evento($param){
	$query_get = "SELECT  eg.* FROM  evento_genero eg WHERE id_evento= '".$param["evento"] ."' ";
	$result = $this->db->query($query_get);
	return $result->result_array();
}
/**/
function contruye_tmp_evento_edit($id_evento , $f , $_num='0' ){
	if($_num == 0 ) {
       $_num = mt_rand();       
	}      												    	
	$query_procedure = "call data_event_public($id_evento , $f , $_num );";	
	$this->db->query($query_procedure);
	return $_num; 
}








/**/
function insert_log($tipo_evento , $descripcion , $id_evento , $id_usuario){

	$navegador = navegador();
	$ip =  ip_user(); 
	$modulo =  1;

	$query_insert = "INSERT INTO log(
						navegador,					
						ip,
						modulo,
						tipo_evento,
						descripcion,
						id_modulo
					)VALUES(						
						'$navegador',					
						'$ip',
						'$modulo',
						'$tipo_evento',
						'$descripcion',
						'$id_evento'
					)"; 
	
	$result =  $this->db->query($query_insert);
	$id_log   = $this->db->insert_id(); 


	$query_insert =  "INSERT INTO usuario_log(id_usuario , id_log) VALUES('$id_usuario' , '$id_log'  )";
	$this->db->query($query_insert);
	return $result;

}

/**/
function update_eslogan($id_evento , $eslogan , $id_usuario , $id_empresa , $param){
	/*UPDATE*/
	$query_update ="UPDATE evento SET eslogan= '$eslogan' WHERE idevento = '". $id_evento ."' limit 1";	
	$result =   $this->db->query($query_update);

	if ($result == true){		
		$log_evento =  "Actualizó el slogan del evento ". $param["enid_evento"]." a- " . $eslogan;		
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );		
	}
	return $result;  
}
/**/
function update_ubicacion($nueva_ubicacion , $id_evento , $id_usuario , $id_empresa , $param   ) {	

	$query_update = "UPDATE evento SET ubicacion='". $nueva_ubicacion ."' WHERE idevento ='".$id_evento."' limit 1";		
	$result =   $this->db->query($query_update);	
	if ($result == 1){		
		$log_evento =  "Indicó que la dirección del evento ". $param["enid_evento"]."   será en- " . $nueva_ubicacion;		
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );		
	}
	return $result; 
}
/**/
function update_descripcion_by_content($id_contenido , $id_evento  ,  $id_usuario ,  $id_empresa , $param ){

	$query_update ="UPDATE evento SET descripcion_evento = (SELECT descripcion_contenido FROM contenido WHERE  idcontenido='". $id_contenido ."' ) WHERE idevento='".$id_evento."' limit 1";
	$result =  $this->db->query($query_update);	
	
	if ($result  ==  1 ){			
		$log_evento =  "Actualizó la descripción de evento ". $param["enid_evento"];		
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );				
	} 
	
	return $result;
}
/**/
function updateDescripcion($nueva_descripcion , $id_evento  , $id_usuario , $id_empresa , $param ) {
	
	$query_update = "UPDATE evento SET descripcion_evento='". $nueva_descripcion."' WHERE idevento ='".$id_evento."'  limit 1";				
	$result =  $this->db->query($query_update); 	
	if ( $result == 1 ){		
		$log_evento =  "Indicó que la experiencia en el evento ". $param["enid_evento"]."   será-  " . $nueva_descripcion;		
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );					
	}
	return $result; 	
}
/***/
function updateEdicion( $nuevo_edicion , $id_evento  , $id_usuario  ,  $id_empresa , $param ){

	$query_update = "UPDATE evento SET edicion = '". $nuevo_edicion."' WHERE idevento ='".$id_evento."' limit 1";		
	$result =  $this->db->query($query_update);		
	if ($result ==  1 ){
		$log_evento =  "Indicó que la edición del evento ". $param["enid_evento"]."  será- " . $nuevo_edicion;
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );						
	}
	return $result;
	/**/	
}
/**/
function updateNombre($nuevo_nombre , $id_evento , $id_usuario , $id_empresa ,  $param ){	

	$query_update = "UPDATE evento SET nombre_evento = '". $nuevo_nombre."' WHERE idevento ='".$id_evento."' ";	
	$result = $this->db->query($query_update);
	/**/	
	if ($result == 1){
	
		$log_evento =  "Actualizó el nombre del evento ". $param["enid_evento"]."  a- " . $nuevo_nombre;
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );							
	}
	/**/
	return $result; 	
}
/**/
function create( $nombre , $edicion , $inicio , $termino , $id_usuario , $idempresa){


	$query_insert ="INSERT INTO evento(
		nombre_evento , 
		edicion , 
		idempresa , 
		idusuario , 
		fecha_inicio , 
		fecha_termino )
	 	VALUES( 	 	
	 	'$nombre' , 
	 	'$edicion' , 
	 	'$idempresa' ,   
	 	'$id_usuario' , 
	 	'$inicio' , 
	 	'$termino' 
	 	)";
		$dbresponse =  $this->db->query($query_insert);
		$msj_response =  "Problemas al registrar reportar al administrador";
		/*Registramos log evento */
		if ($dbresponse) {		
			/*Registramos log */
			$id_evento  = $this->db->insert_id(); 
			$log_descripcion =  "Registró el evento ".$nombre; 							
			$db_response =  $this->insert_log(1 , $log_descripcion , $id_evento ,  $id_usuario );
			$msj_response =  $id_evento;
		}
		return $msj_response;
}
/**/
function updatePoliticas($nueva_politica , $id_evento , $id_usuario,  $param ){
	
	$query_update = "UPDATE evento SET  politicas='". $nueva_politica ."' WHERE idevento ='".$id_evento."' limit 1";		
	$result=   $this->db->query($query_update);
	
	if ($result == 1){	
		$log_evento =  "Especificó que la politica del evento ". $param["enid_evento"]." es- " . $nueva_politica;
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );							
	}
	return $result;

}
/*Actualiza los objetos permitidos dentro del evento*/
function update_obj_permitido($id_evento, $id_objeto , $id_usuario , $param ){

	$query_exist ="SELECT 
					COUNT(0)e 
					FROM 
					evento_objetopermitido 
					WHERE  idevento ='".$id_evento."' AND  
					idobjetopermitido='". $id_objeto ."' ";


	$result = $this->db->query($query_exist);
	$exist = $result->result_array()[0]["e"];
	$tipo_evento = 0;
	$log_evento =  "";
	$dinamic_query = "";
	if ($exist > 0){
		/*Delete */
		$dinamic_query ="DELETE FROM evento_objetopermitido WHERE idevento = '".$id_evento."' 
		AND  idobjetopermitido = '". $id_objeto ."' LIMIT 1";
		/*
		$log_evento =  "Quitó un articulo permitido del evento con id- ".$id_objeto;
		$tipo_evento = 3;
		*/

	}else{
		/*insert*/
		$dinamic_query ="INSERT INTO evento_objetopermitido (idevento , idobjetopermitido ) 
		VALUES('".$id_evento."' , '". $id_objeto ."' )";		
		/*
		$log_evento =  "Cargo un nuevo articulo permitido en el evento ". $param["enid_evento"]." ";
		$tipo_evento = 1;
		*/

	}
	$result =  $this->db->query($dinamic_query);
	
	/*if ($result ==  1){
		
		$this->insert_log($tipo_evento , $log_evento , $id_evento ,  $id_usuario );							
	}
	*/
	return $result;

}
/**/
function update_permitido($nuevo_permitido , $id_evento , $id_usuario ,  $param ){
	$query_update = "UPDATE evento SET  permitido='". $nuevo_permitido ."' WHERE idevento ='".$id_evento."'  limit 1";		
	$result =    $this->db->query($query_update);

	if ($result ==  1 ){
		$log_evento =  "Cargo una nueva nota de aquello que está permitido en el evento ". $param["enid_evento"]." - ".$nuevo_permitido;
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );								
	}
	return $result; 
}
/**/
function update_restricciones($nuevo_restriccion , $id_evento , $id_usuario , $param ){

	$query_update = "UPDATE evento SET  restricciones ='". $nuevo_restriccion ."' WHERE idevento ='".$id_evento."'  limit 1";		
	$result = $this->db->query($query_update);
	if ($result ==  1 ) {
	
		$log_evento =  "Actualizó la descripcion de la restricción de evento ". $param["enid_evento"]." a- ".$nuevo_restriccion;
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );										
	}
	return $result; 
}
/**/
function update_tipo_evento($id_evento , $tipo_evento , $id_usuario , $param ){

	$query_update ="UPDATE evento SET tipo= '$tipo_evento' WHERE idevento = '".$id_evento."' limit 1";
	$result=  $this->db->query($query_update);
	
	if ($result == 1) {
		$log_evento =  "Indicó que el tipo de evento ". $param["enid_evento"]." será- ". $tipo_evento;
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );											
	}
	return $result;
}
/**/
function update_url($nueva_url , $url_social_evento_youtube , $id_evento , $id_usuario , $param   ) {	
	$query_update = "UPDATE evento SET url_social='". $nueva_url ."' , url_social_youtube='". $url_social_evento_youtube ."'   WHERE idevento ='".$id_evento."'  limit 1";		
	$result =   $this->db->query($query_update);

	if ($result ==  1 ) {
		$log_evento =  "Actualizó las redes sociales del evento ". $param["enid_evento"]." ";
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );											
	}
	return $result;
}
/**/
function update_date($id_evento , $nuevo_inicio , $nuevo_termino , $id_usuario , $param  ){
	/**/
	$query_update ="UPDATE evento SET fecha_inicio = '". $nuevo_inicio."' , fecha_termino ='".$nuevo_termino."' WHERE idevento='".$id_evento."'  limit 1";	
	$r =   $this->db->query($query_update);
	$result =  $this->update_diferencias_dias($id_evento); 

	
	if ($result ==  1 ) {
		
		$log_evento =  "Actualizó la fecha del evento ". $param["enid_evento"]."  a- ".fechas_enid_format($nuevo_inicio ,  $nuevo_termino );
		$this->insert_log(2 , $log_evento , $id_evento ,  $id_usuario );												
	}
	return $result;
}
/**/
/*POSIBLE DEPURACIÓN * POSIBLE DEPURACIÓN POSIBLE DEPURACIÓN POSIBLE DEPURACIÓN POSIBLE DEPURACIÓN POSIBLE DEPURACIÓN /
/*puede que ésta función ya no se emplee ******** **puede que ésta función ya no se emplee ******** *puede que ésta función ya no se emplee ******** */
function update_generos($nuevos_generos , $idevento , $param  ){

	$query_update = "UPDATE evento SET genero_tupla='". $nuevos_generos ."' WHERE idevento ='".$idevento."'  limit 1";		
	$result=    $this->db->query($query_update);

	return $result; 
}
/**/
function update_url_yout($nueva_url , $idevento ){
	$query_update = "UPDATE evento SET url_social_youtube='". $nueva_url ."'  WHERE idevento ='".$idevento."' limit 1";		
	return  $this->db->query($query_update);
}
/**/
function delete_genero($param){  	
  	$query_delete =  "DELETE FROM  evento_genero  WHERE  id_genero = '".$param["genero"] ."'  and  id_evento = '". $param["evento"]."' LIMIT 1"; 
	$r1 =  $this->db->query($query_delete);	
  	$query_delete =  "DELETE FROM  evento_genero_musical WHERE  idgenero_musical = '".$param["genero"] ."' and  idevento = '". $param["evento"]."' LIMIT 1"; 
	$r2 = $this->db->query($query_delete);  		
	
	if ($r == 1){
		$log_evento =  "Quitó un genero musical del evento ". $param["enid_evento"]." ";
		$this->insert_log(3, $log_evento ,  $param["evento"] ,  $param["id_usuario"] );												
	}
	return $r1;   		
}
/**/
function update_locacion_maps($param){

	$place_id =  $param["place_id"];
	$formatted_address =  $param["formatted_address"];
	$id_evento =  $param["identificador"];
	$lat = $param["lat"]; 
	$lng = $param["lng"]; 
	
	$query_update = "UPDATE evento 
					SET  					
					place_id = '".$place_id ."'  ,  
					formatted_address = '". $formatted_address  ."', 					
					lat =  '".$lat."' , 
					lng = '".$lng."' 
					WHERE idevento = '".$id_evento."' limit 1"; 
	return  $this->db->query( $query_update);	
	
}
/*Termina modelo */
}