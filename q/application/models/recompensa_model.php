<?php defined('BASEPATH') or exit('No direct script access allowed');

class Recompensa_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = "recompensa";
    }

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->table, $data);
    }

    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert($this->table, $params);
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
        return $this->db->get($this->table)->result_array();
    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_recompensa" => $id]);
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->table, $params_where);
    }

    function visible($id_orden_compra)
    {

        $sql = "SELECT 
                r.id_recompensa, r.descuento, r.id_servicio, r.id_servicio_conjunto, s.precio, sc.precio precio_conjunto FROM recompensa r 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio    
                WHERE r.id_servicio =  $id_orden_compra 
                LIMIT 3";

        return $this->db->query($sql)->result_array();

    }
    function servicio($id_orden_compra)
    {

        $sql = "SELECT 
                r.id_recompensa, r.descuento, r.id_servicio, r.id_servicio_conjunto, s.precio, sc.precio precio_conjunto FROM recompensa r 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio    
                WHERE r.id_servicio =  $id_orden_compra ";

        return $this->db->query($sql)->result_array();

    }
    function id_recompensa($id_recompensa)
    {

        $sql = "SELECT 
                r.id_recompensa, r.descuento, r.id_servicio, r.id_servicio_conjunto, s.precio, sc.precio precio_conjunto FROM recompensa r 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio    
                WHERE r.id_recompensa =  $id_recompensa ";

        return $this->db->query($sql)->result_array();

    }
    function get_in($in)
    {

        $query_get = 'SELECT * FROM recompensa WHERE id_recompensa in (' . $in . ')';
        return $this->db->query($query_get)->result_array();
    }


}
