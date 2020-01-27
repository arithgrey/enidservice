<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario_tipo_negocio_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'usuario_tipo_negocio';
    }

    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert($this->table, $params);

        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function get(
        $params = [],
        $params_where = [],
        $limit = 1,
        $order = '',
        $type_order = 'DESC'
    )
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

    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->table, $params_where);
    }

    function get_num($id_usuario, $id_tipo_negocio)
    {

        $query_get =
            "SELECT COUNT(0)num FROM usuario_tipo_negocio 
      WHERE  
      id_usuario =  $id_usuario 
      AND 
      id_tipo_negocio =  $id_tipo_negocio";


        return $this->db->query($query_get)->result_array()[0]["num"];
    }

    function get_usuario($id_usuario, $limit = 10)
    {

        $query_get = "SELECT p.* FROM tipo_negocio p  
                INNER JOIN usuario_tipo_negocio up 
                ON p.idtipo_negocio =  up.id_tipo_negocio 
                WHERE up.status = 1 AND up.id_usuario =  $id_usuario LIMIT $limit";

        return $this->db->query($query_get)->result_array();
    }

    function update($data = [], $params_where = [], $limit = 1)
    {
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);

        return $this->db->update($this->table, $data);
    }
}