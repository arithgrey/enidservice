<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Costo_operacion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
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
        return $this->db->get("costo_operacion")->result_array();
    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert("costo_operacion", $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }


    function get_recibo($id_recibo)
    {

        $query_get =
            "SELECT c.* , t.tipo  FROM costo_operacion c INNER JOIN tipo_costo t ON t.id_tipo_costo = c.id_tipo_costo 
			WHERE c.id_recibo =  $id_recibo";
        return $this->db->query($query_get)->result_array();
    }

    private function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete("costo_operacion", $params_where);
    }

    function q_delete($id)
    {

        $params_where["id"] = $id;
        return $this->delete($params_where);
    }

    function get_num_type($id_recibo, $id_tipo)
    {
        $query_get = "select count(*)num from costo_operacion where id_recibo = {$id_recibo} and id_tipo_costo = {$id_tipo} ";
        return $this->db->query($query_get)->result_array()[0]["num"];

    }

    function get_qsum($in)
    {

        $query_get = "select  sum(monto)num from costo_operacion where id_recibo in( {$in} )";
        return $this->db->query($query_get)->result_array()[0]["num"];

    }

    function get_recibos_sin_costos($id_usuario)
    {
        $query_get = "SELECT 
                        id_proyecto_persona_forma_pago id_recibo, 
                        saldo_cubierto 
                        FROM 
                        proyecto_persona_forma_pago  p  
                        WHERE
                        id_usuario_venta =  $id_usuario
                        AND 
                        saldo_cubierto >  0 
                        AND 
                        status != 10
                        AND
                        id_proyecto_persona_forma_pago 
                        NOT IN (SELECT id_recibo from costo_operacion)
                        ORDER BY  id_proyecto_persona_forma_pago DESC LIMIT 5 ";

        return $this->db->query($query_get)->result_array();
    }

}
