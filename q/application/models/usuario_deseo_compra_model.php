<?php defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_deseo_compra_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'usuario_deseo_compra';
    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_usuario_deseo_compra" => $id]);
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert($this->tabla, $params, $debug);
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

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function total_ip($ip)
    {

        return $this->get(["COUNT(0)num"], ['ip' => $ip,'status' => 0])[0]["num"];
    }

    function compra($ip)
    {

        $query_get = "SELECT d.*, 
                        s.descripcion, 
                        s.precio, s.flag_envio_gratis, s.nombre_servicio, s.deseado, s.valoracion 
                        FROM usuario_deseo_compra d 
                        INNER JOIN servicio s on d.id_servicio =  s.id_servicio 
                        WHERE 
                        d.ip = '".$ip."' 
                        AND d.status = 0";
        return $this->db->query($query_get)->result_array();
    }


}