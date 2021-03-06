<?php defined('BASEPATH') or exit('No direct script access allowed');

class Direccion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_data_direccion($id_direccion)
    {


        $query_get = "SELECT 
                    d.*,
                    cp.* 
                    FROM 
                    direccion 
                    d 
                    INNER JOIN 
                    codigo_postal 
                    cp 
                    ON d.id_codigo_postal =  cp.id_codigo_postal  
                    WHERE d.id_direccion =" . $id_direccion;

        return $this->db->query($query_get)->result_array();

    }

    function insert($params, $return_id = 0, $debug = 0)
    {
        $insert = $this->db->insert("direccion", $params, $debug);
        return ($return_id == 1) ? $this->db->insert_id() : $insert;
    }

    function in($ids)
    {

        $query_get = "SELECT 
                        d.*,
                        cp.*
                        FROM direccion                      
                      d 
                    INNER JOIN 
                    codigo_postal 
                    cp 
                    ON d.id_codigo_postal =  cp.id_codigo_postal  
                    WHERE 
                      d.id_direccion  IN(" . $ids . ")";

        return $this->db->query($query_get)->result_array();
    }

}