<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_arquetipo_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'tag_arquetipo';
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
        return $this->db->delete($this->tabla, $params_where);
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function q($fecha_inicio, $fecha_termino, $id_tipo_tag_arquetipo)
    {
        $query_get = 'SELECT * FROM tag_arquetipo 
                        WHERE id_tipo_tag_arquetipo = "'.$id_tipo_tag_arquetipo.'" 
                        AND  
                        DATE(fecha_registro ) BETWEEN "'.$fecha_inicio.'" AND "'.$fecha_termino.'"';


        return $this->db->query($query_get)->result_array();
    }

}
