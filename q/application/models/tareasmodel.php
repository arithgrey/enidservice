<?php defined('BASEPATH') OR exit('No direct script access allowed');

class tareasmodel extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id_tarea" => $id]);
	}

	function q_up($q, $q2, $id)
	{
		return $this->update([$q => $q2], ["id_tarea" => $id]);
	}

    function q_delete($id)
    {
        return $this->delete(["id_tarea" => $id]);
    }
    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete("tarea", $params_where);
    }
	function update($data = [], $params_where = [], $limit = 1)
	{
		foreach ($params_where as $key => $value) {
			$this->db->where($key, $value);
		}
		$this->db->limit($limit);
		return $this->db->update("tarea", $data);
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert("tarea", $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
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
		return $this->db->get("tarea")->result_array();
	}

	function update_estado_tarea($param)
	{

		$query_update = "UPDATE tarea 
    SET 
    status = '" . $param["nuevo_valor"] . "' ,
    fecha_termino = CURRENT_TIMESTAMP()
    WHERE 
    id_tarea = '" . $param["id_tarea"] . "'
    LIMIT 1";
		return $this->db->query($query_update);
	}

	function get_tareas_ticket_num($param)
	{

		$f = [
			"COUNT(0) tareas",
			"SUM(case when status = 0 then 1 else 0 end )pendientes"
		];
		return $this->get($f, ["id_ticket" => $param["id_ticket"]]);
	}

	function get_tareas_ticket($param)
	{

		$query_get = "SELECT 
                  t.*,
                    u.idusuario  , 
                    u.nombre ,                   
                    u.apellido_paterno,
                    u.apellido_materno ,
                    COUNT(r.id_respuesta) num_comentarios                  
                  FROM 
                    tarea t
                  LEFT OUTER JOIN 
                    usuario u 
                  ON t.usuario_registro = u.idusuario 
                  LEFT OUTER JOIN 
                    respuesta r 
                    ON 
                    t.id_tarea =  r.id_tarea

                  WHERE 
                    t.id_ticket = '" . $param["id_ticket"] . "'
                  GROUP BY t.id_tarea
                  ORDER BY 
                  t.fecha_registro 
                  ASC";

		return $this->db->query($query_get)->result_array();

	}

	function tareas_enid_service()
	{

		$query_get = "SELECT  
                        SUM(CASE 
                        WHEN 
                          tt.id_departamento = 1 
                        THEN 1 ELSE 0 END )num_pendientes_desarrollo,                        
                        SUM(CASE 
                                WHEN 
                                tt.id_departamento = 2 
                                THEN 1 ELSE 0 END )num_pendientes_ventas , 
                        SUM(CASE 
                          WHEN 
                            tt.id_departamento = 4 
                          THEN 1 ELSE 0 END )num_pendientes_direccion                        
                      FROM 
                          tarea t
                      INNER JOIN
                          ticket tt 
                      ON 
                      t.id_ticket = tt.id_ticket    
                      WHERE  
                          t.status = 1                         
                      AND 
                      DATE(t.fecha_termino) =  DATE(CURRENT_TIMESTAMP())";

		return $this->db->query($query_get)->result_array();
	}

}