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
        return $this->get($params, ["id_usuario_deseo_compra" => $id]);
    }

    function total_ip($ip)
    {

        return $this->get(["COUNT(0)num"], ['ip' => $ip, 'status' => 0])[0]["num"];
    }

    function compra($ip)
    {

        $query_get = "SELECT d.*, 
                        d.id_usuario_deseo_compra id,
                        s.* 
                        FROM usuario_deseo_compra d 
                        INNER JOIN servicio s on d.id_servicio =  s.id_servicio 
                        WHERE 
                        d.ip = '" . $ip . "' 
                        AND d.status = 0";
        return $this->db->query($query_get)->result_array();
    }

    function envio_pago($ids)
    {

        $query_update = "UPDATE usuario_deseo_compra SET status = 4 
                        WHERE id_usuario_deseo_compra IN(" . $ids . ") LIMIT 100";
        return $this->db->query($query_update);
    }
    function envio_registro($ids)
    {

        $query_update = "UPDATE usuario_deseo_compra SET status = 3 
                        WHERE id_usuario_deseo_compra IN(" . $ids . ") LIMIT 100";
        return $this->db->query($query_update);
    }

    function por_pago($ids)
    {

        $query_get = "
        SELECT u.*,
                s.* ,
                s.id_usuario id_usuario_venta
                FROM  usuario_deseo_compra u 
                INNER JOIN servicio s
                ON u.id_servicio =  s.id_servicio 
                WHERE  id_usuario_deseo_compra IN(" . $ids . ") ";
        return $this->db->query($query_get)->result_array();

    }
    function baja_recompensa($id, $ip , $id_recompensa)
    {

        $query_update = "UPDATE usuario_deseo_compra SET id_recompensa = 0 
                        WHERE (id_usuario_deseo_compra = $id) 
                        OR (ip = '$ip' && id_recompensa =  $id_recompensa ) LIMIT 100";
        return $this->db->query($query_update);
    }
    
    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->tabla, $params_where);
    }

}