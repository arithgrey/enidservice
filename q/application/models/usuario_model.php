<?php defined('BASEPATH') OR exit('No direct script access allowed');

class usuario_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function set_ultima_publicacion($param)
	{

		$id_usuario = $param["id_usuario"];
		$query_update = "UPDATE usuario SET ultima_publicacion = CURRENT_TIMESTAMP() WHERE idusuario =  $id_usuario";
		return $this->db->query($query_update);
	}

	function calificacion_cancelacion_compra($param)
	{
		$id = $param["id"];
		return $this->update(["num_cancelaciones" => "num_cancelaciones + 1"], ["idusuario" => $id]);
	}

	function evalua_usuario_existente($param)
	{
		return $this->get(["COUNT(0)num"], ["email" => $param["email"]])[0]["num"];
	}

	function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
	{

		$params = implode(",", $params);
		$this->db->limit($limit);
		$this->db->select($params);
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		if ($order != '') {
			$this->db->order_by($order, $type_order);
		}
		return $this->db->get("usuario")->result_array();
	}

	function update($data = [], $params_where = [], $limit = 1)
	{
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->limit($limit);
		return $this->db->update("usuario", $data);
	}

	function q_up($q, $q2, $id_usuario)
	{
		return $this->update([$q => $q2], ["idusuario" => $id_usuario]);
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["idusuario" => $id]);
	}

	function get_usuario_ventas()
	{
		return $this->get(["idusuario"], ["email" => 'ventas@enidservices.com']);
	}

	function get_miembro($param)
	{

		$query_get = "SELECT 
                      u.idusuario,
                      u.nombre,                   
                      u.apellido_paterno ,                 
                      u.apellido_materno,                                    
                      u.email,
                      u.fecha_registro,                  
                      u.status,                                
                      u.email_alterno,
                      u.tel_contacto,
                      u.tel_contacto_alterno,
                      u.inicio_labor,
                      u.fin_labor,
                      u.grupo,
                      u.cargo,
                      u.turno,
                      u.sexo, 
                      u.id_departamento,
                      up.idperfil
                      FROM usuario u
                      INNER JOIN usuario_perfil up 
                        ON up.idusuario =  u.idusuario
                      WHERE 
                      u.idusuario = '" . $param["id_usuario"] . "' 
                      LIMIT 1";

		$result = $this->db->query($query_get);
		return $result->result_array();
	}

	function registros($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];
		$query_get =
			"SELECT 
                            COUNT(0)num ,
                            SUM(CASE WHEN tel_contacto 
                            IS NOT NULL THEN 1 ELSE 0 END )
                            registros_numeros_telefonicos
                        FROM 
                            usuario
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "'";

		$result = $this->db->query($query_get);
		$total = $result->result_array();

		$response["num"] = $total[0]["num"];
		$response["registros_numeros_telefonicos"] =
			$total[0]["registros_numeros_telefonicos"];
		return $response;


	}

	function insert($params, $return_id = 0)
	{

		$insert = $this->db->insert("usuario", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

	function has_phone($param)
	{

		$id_usuario = $param["id_usuario"];
		$query_get = "SELECT 
                        COUNT(0)num 
                    FROM usuario 
                    WHERE 
                        idusuario =$id_usuario
                    AND 
                        tel_contacto 
                    IS NOT NULl LIMIT 1";

		$result = $this->db->query($query_get);
		return $result->result_array()[0]["num"];
	}

	function publican_periodo($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];
		$query_get = "SELECT COUNT(0)num FROM usuario
                        WHERE 
                            DATE(ultima_publicacion) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "'
                        ";
		$result = $this->db->query($query_get);
		return $result->result_array()[0]["num"];
	}

	function num_registros_periodo($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];
		$query_get =
			"SELECT 
                            COUNT(0)num ,
                            DATE(fecha_registro) fecha
                        FROM 
                            usuario
                        WHERE 
                            DATE(fecha_registro) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "'
                        GROUP BY DATE(fecha_registro)";
		return $this->db->query($query_get)->result_array();
	}

	function get_usuarios_perfil($param)
	{

		$id_perfil = $param["id_perfil"];
		$_num = mt_rand();
		$this->create_tmp_usuarios_perfil(0, $_num, $id_perfil);
		$query_get =
			"SELECT
                    nombre
                    ,email 
                    ,apellido_paterno 
                    ,apellido_materno 
                    FROM  usuario u
                    INNER JOIN 
                    tmp_clienes_$_num up 
                    ON 
                    u.idusuario = up.idusuario";

		$result = $this->db->query($query_get);
		$data_complete = $result->result_array();
		$this->create_tmp_usuarios_perfil(1, $_num, $id_perfil);
		return $data_complete;

	}

	function create_tmp_usuarios_perfil($flag, $_num, $perfil)
	{

		$query_drop = "DROP TABLE IF exists tmp_clienes_$_num";
		$this->db->query($query_drop);
		if ($flag == 0) {

			$query_create = "CREATE TABLE tmp_clienes_$_num AS 
                          SELECT 
                            idusuario 
                          FROM 
                            usuario_perfil 
                          WHERE 
                          idperfil=" . $perfil;
			$this->db->query($query_create);
		}
	}

	function valida_pass($antes, $id_usuario)
	{
		$q = [
			"idusuario" => $id_usuario,
			"password" => $antes
		];
		return $this->get(["COUNT(0)num"], $q)[0]["num"];
	}

	function num_registros_preriodo($param)
	{

		$q =
			["DATE(fecha_registro)" => "BETWEEN '" . $param["fecha_inicio"] . "' AND  '" . $param["fecha_termino"] . "'"];
		return $this->get(["COUNT(0)num"], $q)[0]["num"];

	}

	function get_usuarios_periodo($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];
		$limit = $this->get_limit_usuarios($param);
		$query_get = "SELECT 
                    idusuario id_usuario
                    ,nombre
                    ,email
                    ,apellido_paterno
                    ,apellido_materno
                    , fecha_registro 
                    FROM usuario 
                    WHERE DATE(fecha_registro) 
                    BETWEEN 
                    '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' " . $limit;
		$result = $this->db->query($query_get);
		return $result->result_array();
	}

	function get_limit_usuarios($param)
	{

		$page = (isset($param['page']) && !empty($param['page'])) ? $param['page'] : 1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		return " LIMIT $offset , $per_page ";
	}

	function registros_preriodo($param)
	{

		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];
		$limit = $this->get_limit_usuarios($param);
		$query_get =
			"SELECT 
                    idusuario id_usuario
                    ,nombre
                    ,email
                    ,apellido_paterno
                    ,apellido_materno
                    , fecha_registro 
                    FROM usuario 
                    WHERE DATE(fecha_registro) 
                    BETWEEN 
                    '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' " . $limit;
		$result = $this->db->query($query_get);
		return $result->result_array();
	}

	function num_total($param)
	{
		$where = $this->get_where_usuarios_total($param);
		$query_get = "SELECT COUNT(0)num FROM usuario" . $where;
		$result = $this->db->query($query_get);
		return $result->result_array()[0]["num"];
	}

	function get_where_usuarios_total($param)
	{

		$id_departamento = $param["id_departamento"];
		$status = $param["status"];

		switch (intval($param["id_departamento"])) {
			case 0:
				return " WHERE id_departamento != 8 AND id_departamento != 9 AND status = $status ";
				break;

			case 8:

				return " WHERE id_departamento = 8 ";
				break;
			default:
				break;
		}
	}

	function get_productos_deseados_sugerencias($param)
	{

		$id_usuario = $param["id_usuario"];
		$limit = $param["limit"];
		$query_get = "SELECT                         
                        s.id_servicio ,  
                        s.nombre_servicio,                         
                        s.metakeyword, 
                        s.primer_nivel , 
                        s.segundo_nivel ,
                        s.tercer_nivel ,
                        s.cuarto_nivel , 
                        s.quinto_nivel             
                    FROM usuario_deseo us
                    INNER JOIN servicio s  
                    ON us.id_servicio =  s.id_servicio
                    WHERE 
                       us.id_usuario = '" . $id_usuario . "' 
                       AND  
                       s.status = 1 
                    ORDER BY 
                    us.num_deseo DESC LIMIT $limit ";


		return $this->db->query($query_get)->result_array();

	}

	function num_q($param)
	{
		return $this->get([" COUNT(0)num "], [$param["key"] => $param["value"]], 1000)[0]["num"];
	}

	function get_usuarios_sin_publicar_articulos($param)
	{
		$query_get = "SELECT
                    nombre , 
                    email 
                    FROM usuario 
                    WHERE status = 1 
                    AND 
                    ultima_publicacion 
                    < DATE_ADD(CURRENT_DATE() , INTERVAL - 30 DAY )
                    AND id_departamento =9 ";
		return $this->db->query($query_get)->result_array();

	}

	function verifica_registro_telefono($param)
	{

		$query_get = "SELECT COUNT(0)num FROM 
                    usuario WHERE 
                    idusuario ='" . $param["id_usuario"] . "' 
                    and tel_contacto is null";
		$result = $this->db->query($query_get);
		return $result->result_array()[0]["num"];
	}

	function get_equipo_enid_service($param)
	{
		$_num = mt_rand();
		$this->create_usuarios_enid_service(0, $_num, $param);
		$query_get = "SELECT 
                    u.* , 
                    d.nombre nombre_departamento                        
                   FROM 
                    tmp_usuarios_enid_service_$_num u
                   INNER JOIN 
                    departamento d 
                    ON 
                    u.id_departamento =  d.id_departamento";


		$data_complete = $this->db->query($query_get)->result_array();
		$this->create_usuarios_enid_service(1, $_num, $param);
		return $data_complete;
	}

	function create_usuarios_enid_service($flag, $_num, $param)
	{

		$this->db->query(get_drop("tmp_usuarios_enid_service_$_num"));
		if ($flag == 0) {
			$where = $this->get_where_usuarios($param);
			$query_create = "CREATE TABLE tmp_usuarios_enid_service_$_num AS 
                            SELECT      
                              u.idusuario id_usuario,
                              u.nombre,                   
                              u.apellido_paterno ,                 
                              u.apellido_materno,                                    
                              u.email,                              
                              u.id_departamento ,
                              u.fecha_registro
                            FROM 
                              usuario u
                            " . $where;
			$this->db->query($query_create);
		}
	}

	function get_where_usuarios($param)
	{

		$id_departamento = $param["id_departamento"];
		$status = $param["status"];

		switch (intval($param["id_departamento"])) {
			case 0:
				$limit = $this->get_limit_usuarios($param);
				return
					" WHERE id_departamento != 8 AND id_departamento != 9 AND status = $status " . $limit;
				break;

			case 8:
				$limit = $this->get_limit_usuarios($param);
				return
					" WHERE id_departamento = 8 " . $limit;
				break;
			default:
				break;
		}
	}

	function set_miembro($param)
	{

		$id_usuario = $param["id_usuario"];
		$params = [
			"nombre" => $param["nombre"],
			"email" => $param["email"],
			"apellido_paterno" => $param["apellido_paterno"],
			"apellido_materno" => $param["apellido_materno"],
			"inicio_labor" => $param["inicio_labor"],
			"fin_labor" => $param["fin_labor"],
			"turno" => $param["turno"],
			"sexo" => $param["sexo"],
			"id_departamento" => $param["departamento"],
			"status" => $param["status"]
		];

		$tel_contacto = $param["tel_contacto"];

		if (strlen($tel_contacto) > 3) {
			$params["tel_contacto"] = $tel_contacto;
		}

		$this->update($params, ["idusuario" => $id_usuario]);

		$query_update = "UPDATE usuario SET ultima_modificacion = CURRENT_TIMESTAMP() WHERE idusuario = $id_usuario LIMIT 1 ";
		return $this->db->query($query_update);

	}

	function crea_usuario_enid_service($param)
	{


		$params = [
			"nombre" => $param["nombre"],
			"email" => $param["email"],
			"idempresa" => '1',
			"apellido_paterno" => $param["apellido_paterno"],
			"apellido_materno" => $param["apellido_materno"],
			"tel_contacto" => $param["tel_contacto"],
			"inicio_labor" => $param["inicio_labor"],
			"fin_labor" => $param["fin_labor"],
			"turno" => $param["turno"],
			"sexo" => $param["sexo"],
			"id_departamento" => $param["departamento"],
			"password" => sha1("qwerty123.1")
		];
		$id_usuario = $this->insert($params, 1);
		$param["id_usuario"] = $id_usuario;
		return $param;

	}

	function registrar_afiliado($param)
	{

		$data_complete["usuario_existe"] = $this->evalua_usuario_existente($param);
		$data_complete["usuario_registrado"] = 0;

		if ($data_complete["usuario_existe"] == 0) {

			$params = [
				"email" => $param["email"],
				"idempresa" => '1',
				"id_departamento" => 8,
				"password" => $param["password"],
				"nombre" => $param["nombre"],
				"tel_contacto" => $param["telefono"]
			];

			$id_usuario = $this->insert($params, 1);
			$param["id_usuario"] = $id_usuario;
			$param["puesto"] = 19;
			$data_complete["usuario_permisos"] = $this->agrega_permisos_usuario($param);
			$data_complete["id_usuario"] = $id_usuario;
			$data_complete["email"] = $param["email"];
			$data_complete["usuario_registrado"] = 1;
		}
		return $data_complete;
	}
	/*





  function nombre_usuario($param){

	  $id_usuario =  $param["id_usuario"];
	  $query_get ="SELECT nombre FROM usuario WHERE idusuario =$id_usuario LIMIT 1";
	  $result =  $this->db->query($query_get);
	  return $result->result_array();
  }





  function get_tipo_entregas($param){

	  $id_usuario =  $param["id_usuario"];
	  $query_get = "SELECT
					  entregas_en_casa
					  tipo_entregas
					  FROM usuario
					  WHERE
					  idusuario =  $id_usuario LIMIT 1";
	  $result =  $this->db->query($query_get);
	  return $result->result_array()[0]["tipo_entregas"];
  }

  function get_informes_por_telefono($param){

	  $id_usuario =  $param["id_usuario"];
	  $query_get = "SELECT
					  informes_telefono
					  FROM usuario
					  WHERE
					  idusuario =  $id_usuario LIMIT 1";
	  $result =  $this->db->query($query_get);
	  return $result->result_array()[0]["informes_telefono"];

  }

  function get_terminos_privacidad($param){

	  $id_usuario =  $param["id_usuario"];
	  $query_get = "SELECT
					  *
					  FROM privacidad_usuario
					  WHERE
					  id_usuario =  $id_usuario";
	  $result =  $this->db->query($query_get);
	  return $result->result_array();
  }
  */

	/*
  function set_cancelacion_compra($id){
	  return $this->q_up("num_cancelaciones" , "num_cancelaciones + 1 " , $id);
  }
	*/
	/*
	function actualizarPassword($antes, $nuevo, $id_usuario){

		$existe = count($this->validarPassword($antes, $id_usuario));
		if($existe != 1){

			return "La contraseña ingresada no corresponde a su contraseña actual";
		}else{
			$query_update = "UPDATE usuario SET password = '".$nuevo."' WHERE idusuario = '".$id_usuario."' limit 1";
			$dbresponse = $this->db->query( $query_update );
			return $dbresponse;
		}
	}
	*/
	/*
function set_telefono_negocio($param){

	$params         =
	[
		"tel_contacto_alterno"  =>  $param["telefono_negocio"] ,
		"lada_negocio"          =>  $param["lada_negocio"]
	];
	$params_where   = ["idusuario" => $param["id_usuario"]];
	return $this->update( $params , $params_where );
}
*/
	/*
	function set_telefono($param){


	}
	*/
	/*
	function set_pass($param){


		$new_pass                   =   randomString();
		$params                     =   ["password" => sha1($new_pass)];
		$params_where               =   ["email"   => trim($param["mail"]) ];
		$resopnse["new_pass"]       =   $new_pass;
		$resopnse["status_send"]    =   $this->update($params, $params_where );
		$resopnse["mail"] =  $param["mail"];
		return $resopnse;
	}
	*/
	/*
	  function get_usuario_cobranza($param){

		$id_usuario =  $param["id_usuario"];
		$query_get =    "SELECT
							idusuario id_usuario,
							nombre,
							apellido_paterno,
							apellido_materno ,
							email
						FROM usuario
						WHERE
						idusuario = $id_usuario LIMIT 1";
		$result =  $this->db->query($query_get);
		return $result->result_array();
	}
	*/

}