<?php defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_deseo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id" => $id]);
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert('usuario_deseo', $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update("usuario_deseo", $data);
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
        return $this->db->get('usuario_deseo')->result_array();
    }

    function agregan_lista_deseos_periodo($param)
    {

        $query_get = "SELECT 
                        id_usuario 
                    FROM 
                        usuario_deseo 
                    WHERE
                        DATE(fecha_registro) 
                    BETWEEN 
                        '" . $param["fecha_inicio"] . "' 
                    AND  
                        '" . $param["fecha_termino"] . "'                    
                    GROUP 
                    BY 
                    id_usuario";

        $result = $this->db->query($query_get);
        return $result->result_array();

    }

    function get_productos_deseados_periodo($param)
    {

        $query_get = "SELECT 
                        id_servicio ,
                        num_deseo
                     FROM 
                        usuario_deseo 
                     WHERE 
                        DATE(fecha_registro) 
                    BETWEEN 
                        '" . $param["fecha_inicio"] . "'
                        AND 
                        '" . $param["fecha_termino"] . "'
                    ORDER BY num_deseo DESC";

        return $this->db->query($query_get)->result_array();
    }

    function aumenta_deseo($param)
    {

        $id_usuario = $param["id_usuario"];
        $id_servicio = $param["id_servicio"];
        $query_update =
            "UPDATE usuario_deseo SET num_deseo = num_deseo + 1 WHERE id_usuario = $id_usuario AND  id_servicio = $id_servicio LIMIT 1";
        return $this->db->query($query_update);
    }

    function get_usuario_deseo($id_usuario)
    {

        $query_get = "SELECT 
				u.id, 
				u.num_deseo,
				u.articulos,
				s.*  
				FROM  usuario_deseo u 
				INNER JOIN servicio s  
				ON u.id_servicio =  s.id_servicio 
				WHERE  u.id_usuario =  $id_usuario
				AND 
				u.status =  0
				ORDER BY u.fecha_registro desc   
				LIMIT 50";
        return $this->db->query($query_get)->result_array();
    }

    function envio_pago($ids)
    {

        $query_update = "UPDATE usuario_deseo SET status = 3 WHERE id IN(" . $ids . ") LIMIT 100";
        return $this->db->query($query_update);
    }

    function por_pago($ids, $envia_cliente = 0)
    {

        $extra = ($envia_cliente < 1) ? "AND u.status = 3" : "";
        $query_get = "SELECT 
				u.id, 
				u.num_deseo,
				u.articulos,
				s.* ,
                s.id_usuario id_usuario_venta
				FROM  usuario_deseo u 
				INNER JOIN servicio s
                ON u.id_servicio =  s.id_servicio 
				WHERE  id IN(" . $ids . ")";

        $query_get = _text_($query_get, $extra);
        return $this->db->query($query_get)->result_array();

    }


}