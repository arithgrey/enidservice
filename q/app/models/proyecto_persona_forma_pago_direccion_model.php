<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Proyecto_persona_forma_pago_direccion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function delete_por_id_recibo($id_recibo)
    {
        $query_delete = "DELETE 
                      IGNORE 
                      FROM 
                      proyecto_persona_forma_pago_direccion 
                      WHERE 
                      id = $id_recibo";

        return $this->db->query($query_delete);
    }

    function delete_por_id_recibo_direccion($id_recibo, $id_direccion)
    {
        $query_delete = "DELETE 
                      IGNORE 
                      FROM 
                      proyecto_persona_forma_pago_direccion 
                      WHERE 
                      id_proyecto_persona_forma_pago = $id_recibo
                      AND 
                      id_direccion = $id_direccion";

        return $this->db->query($query_delete);
    }

    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert("proyecto_persona_forma_pago_direccion", $params);

        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id_proyecto_persona_forma_pago" => $id]);
    }

    function get(
            $params = [],
            $params_where = [],
            $limit = 1,
            $order = '',
            $type_order = 'DESC'
    ) {

        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        if ($order != '') {
            $this->db->order_by($order, $type_order);
        }

        return $this->db->get("proyecto_persona_forma_pago_direccion")->result_array();
    }

    function count($id)
    {
        return $this->get(["COUNT(0)total"],
                ["id_proyecto_persona_forma_pago" => $id])[0]["total"];
    }
    function in($ids){

        $query_get = "SELECT * FROM proyecto_persona_forma_pago_direccion 
                      WHERE 
                      id_proyecto_persona_forma_pago  IN(".$ids.")";

        return $this->db->query($query_get)->result_array();
    }


}
