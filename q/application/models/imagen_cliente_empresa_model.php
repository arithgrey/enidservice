<?php defined('BASEPATH') or exit('No direct script access allowed');

class Imagen_cliente_empresa_model extends CI_Model
{
    private $tabla;
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = "imagen_cliente_empresa";

    }

    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert($this->tabla, $params);
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

    function clientes($id_empresa)
    {
        $query_get =  "SELECT i.nombre_imagen , ice.* FROM  
							imagen_cliente_empresa  ice 
							INNER JOIN imagen i 
							ON  
							ice.id_imagen =  i.idimagen
							WHERE ice.id_empresa =  $id_empresa 
							ORDER BY ice.fecha_registro DESC";

        return  $this->db->query($query_get)->result_array();
    }
}