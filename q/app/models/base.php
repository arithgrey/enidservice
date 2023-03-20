<?php defined('BASEPATH') OR exit('No direct script access allowed');

class base_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'base';
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
        return $this->db->get($this->tabla)->result_array();
    }

    function insert($params, $return_id = 0)
    {

        $insert = $this->db->insert($this->tabla, $params);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->tabla, $data);
    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id" => $id]);
    }

    function q_get($id, $params = [])
    {
        return $this->get($params, ["id" => $id]);
    }

    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->tabla, $params_where);
    }    

}