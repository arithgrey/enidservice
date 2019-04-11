<?php defined('BASEPATH') OR exit('No direct script access allowed');

class actividad_web_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function get($table, $params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
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
		return $this->db->get($table)->result_array();
	}

	function visitas_enid_semana($_num)
	{
		$query_get = "SELECT 
        HOUR(fecha_registro)horario,
        SUM(CASE WHEN tipo IS NOT NULL THEN 1 ELSE 0 END )total_registrado,
        SUM(CASE WHEN tipo = 111 then 1 else 0 end )cotizaciones ,          
        SUM(CASE WHEN tipo = 43 then 1 else 0 end )contacto , 
        SUM(CASE WHEN tipo = 2201 then 1 else 0 end )faq , 
        SUM(CASE WHEN tipo = 9990890 then 1 else 0 end )correos_empresas ,
        SUM(CASE WHEN tipo = 2892 then 1 else 0 end )procesar_compra ,  
        SUM(CASE WHEN tipo = 566 then 1 else 0 end )sobre_enid,
        SUM(CASE WHEN tipo = 22 then 1 else 0 end )afiliados,
        SUM(CASE WHEN tipo = 40 then 1 else 0 end )nosotros,                        
        SUM(CASE WHEN tipo = 3009 then 1 else 0 end )formas_pago
        FROM  tmp_landing_$_num
        GROUP BY 
        HOUR(fecha_registro)
        ORDER BY HOUR(fecha_registro) DESC ";

		return $this->db->query($query_get)->result_array();

	}

	function get_correos_enviados($tabla)
	{

		$query_get = "SELECT SUM(CASE WHEN total  > 0  THEN total ELSE 0 END) correos_enviados FROM $tabla";
		return $this->db->query($query_get)->result_array()[0]["correos_enviados"];
	}

	function get_registros_valoraciones_productos($tabla)
	{
		$query_get = "SELECT COUNT(0)productos_valorados FROM $tabla";
		return $this->db->query($query_get)->result_array();
	}

	function get_registros_valoraciones($fecha, $tabla)
	{
		return $this->get($tabla, ["num_valoraciones", "si_recomendarian", "no_recomendarian"], [], 100);
	}

	function get_num_registros_templal_table_fecha($fecha, $tabla)
	{

		$query_get = "SELECT COUNT(0)num FROM $tabla ";
		$result = $this->db->query($query_get);
		return $result->result_array()[0]["num"];
	}

	function get_registros_venta_fecha($fecha, $tabla)
	{

		$query_get = "SELECT 
                    SUM(total)total
                    ,SUM(compras_efectivas)compras_efectivas
                    ,SUM(solicitudes)solicitudes
                    ,SUM(envios)envios
                    ,SUM(cancelaciones)cancelaciones
                    FROM $tabla ";
		return $this->db->query($query_get)->result_array();

	}

	function get_num_registros_usuario($fecha, $tabla)
	{

		$query_get = "SELECT SUM(total)num FROM $tabla ";
		return $this->db->query($query_get)->result_array()[0]["num"];
	}

	function crea_tb_deseo($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$query_get = "SELECT 
                      COUNT(0)num 
                    FROM 
                      usuario_deseo 
                    WHERE 
                      1=1 
                    AND 
                    " . $where;
		return $query_get;
	}

	/*
	function crea_conversaciones($param)
	{
		$where = $this->get_where_tiempo($param, 1);
		$query_get = "SELECT
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total,
                        SUM(CASE WHEN leido_vendedor =1 THEN 1 ELSE 0 END)leidas_por_vendedor,
                        SUM(CASE WHEN leido_cliente =1 THEN 1 ELSE 0 END)leidas_por_cliente
                      FROM
                      pregunta
                      WHERE
                       1=1
                      AND
                      " . $where . "
                      GROUP BY
                      DATE(fecha_registro)";
		return $query_get;
	}
	*/

	function crea_servicios_creados($param)
	{
		$where = $this->get_where_tiempo($param, 1);
		$query_get = "SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total 
                      FROM 
                      servicio 
                      WHERE
                       1=1 
                      AND 
                      " . $where . "                      
                      GROUP BY 
                      DATE(fecha_registro)";
		return $query_get;

	}

	private function crea_correos_enviados($param)
	{

		$where = $this->get_where_tiempo($param, 3);
		$query_get = "SELECT 
                      DATE(fecha_actualizacion) fecha ,
                      COUNT(0)total 
                      FROM 
                      prospecto
                      WHERE
                       n_tocado > 0
                       AND 
                      " . $where . "                      
                      GROUP BY 
                      DATE(fecha_actualizacion)";
		return $query_get;
	}

	function crea_valoraciones($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$query_create = "SELECT                          
                          COUNT(0)num_valoraciones,
                          SUM(CASE WHEN recomendaria = 1 THEN 1 ELSE 0 END )si_recomendarian,
                          SUM(CASE WHEN recomendaria = 0 THEN 1 ELSE 0 END )no_recomendarian
                        FROM 
                          valoracion
                        WHERE 
                          " . $where;
		return $query_create;
	}

	function crea_valoraciones_distintas($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$query_create = "SELECT                          
                          DISTINCT(id_servicio)servicios_valorados
                        FROM 
                        valoracion
                        WHERE 
                          " . $where;
		return $query_create;
	}

	function crea_tareas_resueltas($param)
	{

		$where = $this->get_where_tiempo($param, 2);
		$query_create = "SELECT                           
                        COUNT(0)num_tareas_resueltas ,                            
                        DATE(fecha_termino)fecha
                        FROM 
                          tarea 
                        WHERE 
                        " . $where . " 
                        GROUP BY 
                        DATE(fecha_termino)";

		return $query_create;
	}

	function crea_registros_usuarios($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$query_get = "SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total 
                      FROM 
                      usuario_perfil 
                      WHERE
                       1=1 
                      AND 
                      " . $where . "
                      AND  
                        idperfil = 20                        
                      GROUP BY 
                      DATE(fecha_registro)";
		return $query_get;
	}

	function crea_actividad_en_contacto($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$query_get = "SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total 
                      FROM 
                      contact
                      WHERE
                       1=1 
                       AND 
                      " . $where . "                      
                      GROUP BY 
                      DATE(fecha_registro)";
		return $query_get;
	}

	function get_fechas_funnel($param)
	{

		$where_fecha = "DATE(fecha_registro )
                         BETWEEN DATE_ADD(CURRENT_DATE() , INTERVAL - 1 WEEK ) 
                         AND  DATE(CURRENT_DATE())";

		if (isset($param["fecha_inicio"])) {

			$fecha_inicio = $param["fecha_inicio"];
			$fecha_termino = $param["fecha_termino"];

			$where_fecha = "DATE(fecha_registro )
                         BETWEEN '" . $fecha_inicio . "' AND '" . $fecha_termino . "' ";
		}
		return $where_fecha;
	}

	function create_tmp_langings($_num, $flag, $param)
	{

		$response = $this->db->query(get_drop("tmp_landing_$_num"));

		if ($flag == 0) {

			$where_fecha = $this->get_fechas_funnel($param);
			$query_create = "CREATE TABLE tmp_landing_$_num 
                          AS
                         SELECT
                           * 
                         FROM pagina_web 
                         WHERE $where_fecha";
			$response = $this->db->query($query_create);
		}
		return $response;

	}

	function crea_actividad_solicitudes($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$where_cancelacion = $this->get_where_tiempo($param, 4);
		$query_get = "SELECT 
                      DATE(fecha_registro) fecha ,
                      COUNT(0)total ,                      
                      SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END)compras_efectivas, 
                      SUM(CASE WHEN status = 6 AND  " . $where . " THEN 1 ELSE 0 END)solicitudes,
                      SUM(CASE WHEN status = 7 THEN 1 ELSE 0 END)envios, 
                      SUM(CASE WHEN status = 10 AND " . $where_cancelacion . " THEN 1 ELSE 0 END)cancelaciones
                      FROM 
                      proyecto_persona_forma_pago 
                      WHERE
                      1=1 
                      AND 
                      " . $where . "
                      OR 
                      " . $where_cancelacion . "
                      GROUP BY 
                      DATE(fecha_registro)";
		return $query_get;
	}

	function get_comparativa_landing_page($param)
	{

		$_num = get_random();
		$this->create_tmp_langings($_num, 0, $param);
		$data_complete["semanal"] = $this->visitas_enid_semana($_num);
		$this->create_tmp_langings($_num, 1, $param);
		return $data_complete;
	}

	private function agrega_data($param, $data_accesos, $_num)
	{

		$data_complete = [];
		if (count($data_accesos) > 0) {

			$tabla_usuarios = "registros_usuarios_$_num";
			$tabla_ventas = "actividad_ventas_$_num";
			$tabla_contacto = "contacto_$_num";
			$tb_tareas = "tareas_resueltas_$_num";
			$tb_valoraciones = "valoraciones_$_num";
			$tb_valoraciones_p = "valoraciones_p_$_num";
			$tb_correos = "correos_$_num";
			$tb_servicios = "servicios_$_num";
			$tb_preguntas = "pregunta_$_num";

			$tb_deseo_usuario = "deseo_$_num";

			$sql_usuarios = $this->crea_registros_usuarios($param);
			$this->crea_tabla_temploral($tabla_usuarios, $sql_usuarios, 0);

			$sql_ventas = $this->crea_actividad_solicitudes($param);
			$this->crea_tabla_temploral($tabla_ventas, $sql_ventas, 0);

			$sql_contacto = $this->crea_actividad_en_contacto($param);
			$this->crea_tabla_temploral($tabla_contacto, $sql_contacto, 0);

			$sql_tareas = $this->crea_tareas_resueltas($param);
			$this->crea_tabla_temploral($tb_tareas, $sql_tareas, 0);

			$sql_valoraciones = $this->crea_valoraciones($param);
			$this->crea_tabla_temploral($tb_valoraciones, $sql_valoraciones, 0);


			$sql_valoraciones_productos =
				$this->crea_valoraciones_distintas($param);

			$this->crea_tabla_temploral(
				$tb_valoraciones_p,
				$sql_valoraciones_productos, 0);


			$sql_correos_enviados = $this->crea_correos_enviados($param);
			$this->crea_tabla_temploral($tb_correos, $sql_correos_enviados, 0);

			$sql_servicios = $this->crea_servicios_creados($param);
			$this->crea_tabla_temploral($tb_servicios, $sql_servicios, 0);


			$sql_deseo = $this->crea_tb_deseo($param);
			$this->crea_tabla_temploral($tb_deseo_usuario, $sql_deseo, 0);

			$a = 0;

			foreach ($data_accesos as $row) {
				$data_complete[$a] = $row;
				$fecha = "";

				$data_complete[$a]["usuarios"]
					= $this->get_num_registros_usuario($fecha, $tabla_usuarios);


				$data_complete[$a]["ventas"]
					=
					$this->get_registros_venta_fecha($fecha, $tabla_ventas);


				$data_complete[$a]["contacto"]
					=
					$this->get_num_registros_templal_table_fecha($fecha, $tabla_contacto);

				$data_complete[$a]["labores_resueltas"]
					=
					$this->get_num_registros_templal_table_fecha($fecha, $tb_tareas);


				$data_complete[$a]["valoraciones"]
					= $this->get_registros_valoraciones($fecha, $tb_valoraciones);

				$data_complete[$a]["valoraciones_productos"]
					= $this->get_registros_valoraciones_productos($tb_valoraciones_p);

				$data_complete[$a]["correos"] = $this->get_correos_enviados($tb_correos);


				$data_complete[$a]["servicios_creados"]
					= $this->get_total_tabla($tb_servicios);



				$data_complete[$a]["lista_deseo"]
					= $this->get_total_lista_deseo($tb_deseo_usuario);


				$a++;
			}

			$this->crea_tabla_temploral($tb_deseo_usuario, $sql_deseo, 1);
			$this->crea_tabla_temploral($tb_servicios, $sql_servicios, 1);
			$this->crea_tabla_temploral($tb_correos, $sql_correos_enviados, 1);
			$this->crea_tabla_temploral($tb_valoraciones_p, $sql_valoraciones_productos, 1);
			$this->crea_tabla_temploral($tb_valoraciones, $sql_valoraciones, 1);
			$this->crea_tabla_temploral($tb_tareas, $sql_tareas, 1);
			$this->crea_tabla_temploral($tabla_contacto, $sql_contacto, 1);
			$this->crea_tabla_temploral($tabla_ventas, $sql_ventas, 1);
			$this->crea_tabla_temploral($tabla_usuarios, $sql_usuarios, 1);

		}
		return $data_complete;
	}

	function crea_tabla_temploral($tabla, $sql, $flag)
	{
		$this->db->query(get_drop($tabla));

		if ($flag == 0) {
			$query_create = "CREATE TABLE $tabla AS " . $sql;
			$this->db->query($query_create);
		}
	}

	/**
	 * @param $param
	 * @param $tipo
	 * @return string
	 */
	function get_where_tiempo($param, $tipo)
	{
		$fecha_inicio = $param["fecha_inicio"];
		$fecha_termino = $param["fecha_termino"];

		switch ($tipo) {
			case 1:

				return " DATE(fecha_registro)
                       BETWEEN 
                       '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
				break;
			case 2:

				return " (fecha_termino)
                       BETWEEN 
                       '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
				break;

			case 3:

				return " (fecha_actualizacion)
                       BETWEEN 
                       '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
				break;

			case 4:

				return " (fecha_cancelacion)
                       BETWEEN 
                       '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ";
				break;

			default:
				return "";
				break;
		}

	}

	function crea_visitas_por_periodo($param)
	{

		$where = $this->get_where_tiempo($param, 1);
		$query_get = "SELECT                   
                    COUNT(0)accesos,                     
                    SUM(CASE WHEN tipo = 2892 THEN 1 ELSE 0 END )accesos_a_intento_compra,
                    SUM(CASE WHEN tipo = 43 THEN 1 ELSE 0 END )accesos_contacto,
                    SUM(CASE WHEN tipo = 48 THEN 1 ELSE 0 END )accesos_area_cliente
                    FROM 
                      pagina_web 
                    WHERE 
                    1=1                     
                    AND 
                    " . $where;
		return $query_get;
	}

	function crea_reporte_enid_service($param)
	{


		$_num = get_random();
		$sql_visitas = $this->crea_visitas_por_periodo($param);
		$this->crea_tabla_temploral("visitas_periodo_$_num", $sql_visitas, 0);
		$query_get = "SELECT * FROM visitas_periodo_$_num";
		$accesos = $this->db->query($query_get)->result_array();
		$data_complete["resumen"] = $this->agrega_data($param, $accesos, $_num);
		$this->crea_tabla_temploral("visitas_periodo_$_num", $sql_visitas, 1);
		return $data_complete;
	}

	private function get_total_tabla($tabla)
	{

		$query_get = "SELECT SUM(total)num FROM $tabla ";
		return $this->db->query($query_get)->result_array()[0]["num"];

	}


	private function get_total_lista_deseo($tb_deseo_usuario)
	{
		$query_get = "SELECT num FROM  $tb_deseo_usuario ";
		return $this->db->query($query_get)->result_array();
	}

}