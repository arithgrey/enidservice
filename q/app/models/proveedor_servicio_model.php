<?php defined('BASEPATH') or exit('No direct script access allowed');

class Proveedor_servicio_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->table = 'proveedor_servicio';
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

    function q_delete($id)
    {

        $params_where["id"] = $id;
        return $this->delete($params_where);
    }

    private function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->table, $params_where);
    }

    function q($id)
    {

        $query_get = "SELECT 
                      u.id,
                      u.nombre,                   
                      u.apellido_paterno ,                 
                      u.apellido_materno,                                    
                      u.tel_contacto,
                      u.tel_contacto_alterno,
                      ps.*
                      
            FROM proveedor_servicio ps 
                INNER JOIN usuario u ON ps.id_usuario = u.id WHERE id = $id";

        return $this->db->query($query_get)->result_array();

    }
    function set_proveedor($id_usuario,$nombre,$tel)
    {

        $query_update = "UPDATE usuario 
                        SET 
                            nombre = '".$nombre."',
                             tel_contacto = $tel
                        WHERE id = $id_usuario 
                        LIMIT 1";

        return $this->db->query($query_update);

    }



}