<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Imagen_faq_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function insert($params, $return_id = 0)
    {
        $insert = $this->db->insert("imagen_faq", $params);
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
        return $this->db->get("imagen_faq")->result_array();
    }
    function delete($params_where = [], $limit = 1)
    {
        $this->db->limit($limit);
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        return $this->db->delete("imagen_faq", $params_where);
    }
    function  get_img($id_faq){

        $query_get  = "SELECT  
                            ifq.*, i.nombre_imagen  
                            FROM  
                            imagen_faq ifq 
                            INNER JOIN 
                            imagen  i  
                            ON 
                            ifq.id_imagen = i.idimagen   
                            WHERE  
                            id_faq = ".$id_faq." LIMIT 1";
        return $this->db->query($query_get)->result_array();

    }
}