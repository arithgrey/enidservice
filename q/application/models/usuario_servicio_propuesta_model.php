<?php defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_servicio_propuesta_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'usuario_servicio_propuesta';
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

    function intentos(){

        $query_get = "SELECT * FROM  
                        usuario_servicio_propuesta 
                        WHERE DATE(fecha_registro ) >  
                        DATE_ADD(CURRENT_DATE() , INTERVAL - 50 DAY )
                        AND es_contactable > 0";
        $result = $this->db->query($query_get);
        return $result->result_array();

    }
}