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

    function q_get($id,$params = [])
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
                r.id_recompensa, r.descuento, r.id_servicio, 
                r.id_servicio_conjunto, s.precio, sc.precio precio_conjunto FROM recompensa r 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio    
                WHERE 
                r.id_servicio =  $id_orden_compra 
                AND s.status =  1
                AND r.status =  1
                LIMIT 3";

        return $this->db->query($sql)->result_array();
    }
    function servicio($id_servicio)
    {

        $sql = "SELECT 
                r.id_recompensa, 
                r.descuento, r.id_servicio, r.id_servicio_conjunto, 
                s.precio, sc.precio precio_conjunto ,
                s.status 
                FROM recompensa r 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio    
                WHERE 
                r.id_servicio =  $id_servicio 
                AND s.status = 1 
                AND r.status =  1
                ";

        return $this->db->query($sql)->result_array();
    }
    function disponibles($id_nicho, $limit_paginacion, $populares = 0)
    {

        $extra = ($populares > 0) ?  'ORDER BY r.gamificado DESC' : '';
        $extra_nicho = "AND s.id_nicho =  $id_nicho";

        $sql = _text_("SELECT 
                r.id_recompensa, r.descuento, r.id_servicio, 
                r.id_servicio_conjunto, s.precio, 
                sc.precio precio_conjunto FROM recompensa r                 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio 
                WHERE r.status  > 0 ", $extra_nicho, $extra,  $limit_paginacion);

        return $this->db->query($sql)->result_array();
    }
    function total_disponibles()
    {

        $sql = "SELECT COUNT(0)total FROM recompensa where status > 0";

        return $this->db->query($sql)->result_array();
    }
    function id_recompensa($id_recompensa)
    {

        $sql = "SELECT 
                r.id_recompensa, r.descuento, 
                r.id_servicio, r.id_servicio_conjunto, s.precio, sc.precio precio_conjunto FROM recompensa r 
                INNER JOIN servicio s 
                ON r.id_servicio = s.id_servicio    
                INNER JOIN servicio sc 
                ON r.id_servicio_conjunto = sc.id_servicio    
                WHERE 
                r.id_recompensa =  $id_recompensa                 
                ";

        return $this->db->query($sql)->result_array();
    }
    function get_in($in)
    {

        $query_get = 'SELECT * FROM recompensa WHERE status =  1 AND  id_recompensa in (' . $in . ')';
        return $this->db->query($query_get)->result_array();
    }
    function in($ids)
    {

        $query_get = "SELECT r.*, ro.id_orden_compra, ro.id_recompensa
        FROM recompensa_orden_compra ro 
        INNER JOIN recompensa r ON ro.id_recompensa = r.id_recompensa
        WHERE r.status = 1 AND id_orden_compra IN(" . $ids . ") ORDER BY ro.id_orden_compra";

        return $this->db->query($query_get)->result_array();
    }


    function gamifica_recompensa($id)
    {

        $query_update = "UPDATE recompensa SET gamificado = gamificado + 1 WHERE id_recompensa = $id LIMIT 1";
        return $this->db->query($query_update)->result_array();
    }
    function baja_por_id_servicio($id)
    {

        $query_update = "update recompensa set status = 0 where id_servicio  = $id  or id_servicio_conjunto =  $id";
        return $this->db->query($query_update)->result_array();
    }
}
