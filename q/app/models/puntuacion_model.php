<?php defined('BASEPATH') or exit('No direct script access allowed');

class Puntuacion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'puntuacion';
    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id" => $id]);
    }

    function update($data = [], $params_where = [], $limit = 1)
    {
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->table, $data);
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
        return $this->db->get($this->table)->result_array();
    }

    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert($this->table, $params);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function avg($id_usuario)
    {

        $query = "SELECT AVG(cantidad)promedio FROM puntuacion WHERE id_usuario = $id_usuario";
        return $this->db->query($query)->result_array();
    }

    function promedio_recibos($fecha_inicio, $fecha_termino)
    {

        $query_get = "SELECT 
                        AVG(p.cantidad)promedio , 
                        p.id_usuario , 
                        u.name, 
                        u.apellido_paterno , 
                        u.apellido_materno ,  
                        u.puntuacion   
                        FROM 
                        puntuacion p 
                        INNER JOIN  
                        users u ON p.id_usuario = u.id 
                        WHERE 
                            id_servicio > 0 
                        AND  
                            DATE(p.fecha_registro) 
                        BETWEEN 
                          '" . $fecha_inicio . "' 
                        AND  
                          '" . $fecha_termino . "' 
                          GROUP BY id_usuario ";

        return $this->db->query($query_get)->result_array();

    }


}