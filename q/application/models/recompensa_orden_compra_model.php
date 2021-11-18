<?php defined('BASEPATH') or exit('No direct script access allowed');

class Recompensa_orden_compra_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = "recompensa_orden_compra";
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

    function id($id)
    {
       
       $query_get = "SELECT 
       ro.id_recompensa, 
       ro.id_orden_compra, 
       r.descuento  
       FROM recompensa_orden_compra ro 
       INNER JOIN recompensa r 
       ON 
       ro.id_recompensa = r.id_recompensa 
       WHERE ro.id_orden_compra = $id";

       return $this->db->query($query_get)->result_array();


    }    

}
