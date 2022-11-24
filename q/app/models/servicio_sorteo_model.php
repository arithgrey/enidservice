<?php defined('BASEPATH') or exit('No direct script access allowed');

class Servicio_sorteo_model extends CI_Model
{
    private $tabla;

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->tabla = 'servicio_sorteo';
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
    function fecha($fecha_inicio, $fecha_termino)
    {

        
        $query_get = _text_("SELECT * FROM 
        servicio_meta WHERE DATE( fecha_registro ) 
        BETWEEN '" . $fecha_inicio . "' AND  '" . $fecha_termino . "' ");

        return $this->db->query($query_get)->result_array();
    }
    
    function pagado_entregado($id_servicio,$fecha_registro, $fecha_promesa)
    {

        $query_get = _text_("SELECT COUNT(0)total, date(fecha_entrega) fecha_entrega 
        FROM proyecto_persona_forma_pagos WHERE 
        id_servicio = $id_servicio 
        AND 
        saldo_cubierto >  0         
        AND se_cancela < 1  
        AND DATE( fecha_entrega )  BETWEEN '" . $fecha_registro . "' AND  '" . $fecha_promesa . "'  
        GROUP BY DATE(fecha_entrega) ORDER BY fecha_entrega ASC
        ");

        return $this->db->query($query_get)->result_array();
        

    }
    function leads($id_servicio,$fecha_registro, $fecha_promesa)
    {

        $query_get = _text_("SELECT COUNT(0)total, date(fecha_entrega) fecha_entrega 
        FROM proyecto_persona_forma_pagos WHERE 
        id_servicio = $id_servicio         
        AND DATE( fecha_entrega )  BETWEEN '" . $fecha_registro . "' AND  '" . $fecha_promesa . "'  
        GROUP BY DATE(fecha_entrega) ORDER BY fecha_entrega ASC
        ");

        return $this->db->query($query_get)->result_array();        

    }
    function usuario_boleto($id_servicio, $boleto)
    {

        $query_get = "SELECT * FROM proyecto_persona_forma_pagos 
        WHERE 
        id_servicio = $id_servicio
        AND  
        numero_boleto =  $boleto";
        
        return $this->db->query($query_get)->result_array();        

    }
    function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->tabla, $data);
        
    }

}