<?php defined('BASEPATH') or exit('No direct script access allowed');

class Servicio_relacion_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'servicio_relacion';
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

    function usuario_recibo($id_usuario)
    {

        $query_get = "SELECT * FROM servicio_relacion WHERE id_servicio_dominante IN 
                        (SELECT id_servicio FROM proyecto_persona_forma_pago 
                        WHERE id_usuario = $id_usuario 
                        AND se_cancela < 1 
                        AND cancela_email < 1 
                        AND saldo_cubierto > 0 
                        GROUP BY id_servicio)";

        return $this->db->query($query_get)->result_array();

    }


}
