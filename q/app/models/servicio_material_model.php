<?php defined('BASEPATH') or exit('No direct script access allowed');

class Servicio_material_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'servicio_material';
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert($this->tabla, $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function get($params = [], $params_where = [], $limit = 1, $order = '', $type_order = 'DESC')
    {

        $this->db->limit($limit);
        $this->db->select(implode(",", $params));
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        if ($order != '') {
            $this->db->order_by($order, $type_order);
        }
        return $this->db->get($this->tabla)->result_array();
    }

    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->tabla, $params_where);
    }

    function completo_servicio($id_servicio){

        $query_get = _text_("SELECT m.* FROM servicio_material 
                sm  
                INNER JOIN material m 
                ON sm.id_material =  m.id_material 
                WHERE sm.id_servicio = ", $id_servicio);
        return $this->db->query($query_get)->result_array();

    }

}
