<?php defined('BASEPATH') OR exit('No direct script access allowed');

class stock_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'stock';
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

    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->tabla, $data);
    }

    function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_stock" => $id]);
    }

    function q_get($params = [], $id)
    {
        return $this->get($params, ["id" => $id]);
    }

    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete($this->tabla, $params_where);
    }

    function disponibilidad($id_servicio)
    {

        $query_get = "SELECT * FROM stock WHERE  consumo < unidades 
                        AND es_consumo_negativo < 1   
                        AND  id_servicio = $id_servicio  
                        ORDER BY fecha_registro ASC";
        return $this->db->query($query_get)->result_array();

    }


    function consumo($consumo, $id_stock)
    {

        $query = "UPDATE stock SET consumo =  consumo + $consumo WHERE id_stock =  $id_stock LIMIT 1";
        return $this->db->query($query);

    }

    function deuda($id_servicio)
    {

        $query_get = "SELECT * FROM stock 
                    WHERE 
                    id_servicio = $id_servicio 
                    AND es_consumo_negativo > 0 AND unidades < 0
                    ORDER BY fecha_registro ASC";
        return $this->db->query($query_get)->result_array();
    }

    function pago_deuda($id_stock, $unidades, $costo)
    {

        $query = "UPDATE stock SET 
            costo_unidad =  $costo, 
            unidades = unidades + $unidades 
            WHERE id_stock =  $id_stock LIMIT 1";
        return $this->db->query($query);
    }
    function inventario(){

        $query = "SELECT 
                    id_servicio, 
                    id_stock,
                    unidades, 
                    consumo , 
                    (unidades - consumo )unidades_disponibles, 
                    costo_unidad ,
                    fecha_registro                
                    FROM stock 
                    WHERE 
                    unidades > 0 
                    AND es_consumo_negativo < 1 
                    AND (unidades > consumo)
                    ORDER BY id_servicio ASC";

        return $this->db->query($query)->result_array() ;
    }


}