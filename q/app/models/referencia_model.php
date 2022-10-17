<?php defined('BASEPATH') or exit('No direct script access allowed');

class Referencia_model extends CI_Model
{
    private $table;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = "referencia";
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


    function get_imagen_servicio_referencia($id_servicio)
    {

        $query_get ="SELECT im.* FROM referencia r 
                    INNER JOIN imagen im
                    ON r.id_imagen = im.idimagen   
                    where r.id_servicio = $id_servicio LIMIT 6";

        return $this->db->query($query_get)->result_array();


    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_servicio" => $id]);
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

}
