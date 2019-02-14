<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Solicitud_pago_usuario_model extends CI_Model {
    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    function get( $params=[], $params_where =[] , $limit =1 , $order = '', $type_order='DESC'){

        $params = implode(",", $params);
        $this->db->limit($limit);
        $this->db->select($params);
        foreach ($params_where as $key => $value) {
            $this->db->where($key , $value);
        }
        if($order !=  ''){
            $this->db->order_by($order, $type_order);
        }
        return $this->db->get("solicitud_pago_usuario")->result_array();
    }
    function insert( $params , $return_id=0){
        $insert   = $this->db->insert("solicitud_pago_usuario", $params);
        return ($return_id ==  1) ? $this->db->insert_id() : $insert;
    }
}
