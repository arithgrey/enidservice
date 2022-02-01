<?php defined('BASEPATH') or exit('No direct script access allowed');

class Ubicacion_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'ubicacion';
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

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert($this->tabla, $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id_ubicacion" => $id]);
    }

    function in_recibo($ids)
    {

        $query_get = "SELECT * FROM ubicacion
                      WHERE 
                      id_recibo IN(" . $ids . ") ORDER BY id_ubicacion DESC";

        return $this->db->query($query_get)->result_array();
    }

}
