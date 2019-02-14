<?php defined('BASEPATH') OR exit('No direct script access allowed');

    class Usuario_punto_encuentro_model extends CI_Model
    {
        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        function insert($params, $return_id = 0)
        {
            $insert = $this->db->insert("usuario_punto_encuentro", $params);
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
            return $this->db->get("usuario_punto_encuentro")->result_array();
        }

        function get_num($id_usuario, $id_punto_encuentro)
        {

            $query_get =
                "SELECT COUNT(0)num FROM usuario_punto_encuentro 
      WHERE  
      id_usuario =  $id_usuario 
      AND 
      id_punto_encuentro =  $id_punto_encuentro";


            return $this->db->query($query_get)->result_array()[0]["num"];
        }

        function get_usuario($id_usuario, $limit = 10)
        {

            $query_get = "SELECT p.* FROM punto_encuentro p  
                INNER JOIN usuario_punto_encuentro up 
                ON p.id =  up.id_punto_encuentro 
                WHERE up.id_usuario =  $id_usuario LIMIT $limit";

            return $this->db->query($query_get)->result_array();
        }

    }