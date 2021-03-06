<?php defined('BASEPATH') or exit('No direct script access allowed');

class Material_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'material';

    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
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
}