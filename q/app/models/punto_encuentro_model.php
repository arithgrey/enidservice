<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Punto_encuentro_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
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
		return $this->db->get("punto_encuentro")->result_array();
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id" => $id]);
	}

	function get_tipo($param)
	{

		$id = $param["id"];
		$query_get = "SELECT 
        p.* ,
        p.nombre lugar_entrega ,
        t.tipo ,        
        l.nombre nombre_linea,
        l.color,
        l.tipo tipo_linea,
        l.id id_linea_metro,
        l.numero
        FROM punto_encuentro p  
        INNER JOIN   
        tipo_punto_encuentro t on p.id_tipo_punto_encuentro =  t.id 
        LEFT OUTER JOIN 
        linea_metro l 
        ON 
        l.id = p.id_linea_metro 
        WHERE   
        p.id = '" . $id . "' LIMIT 1";

		return $this->db->query($query_get)->result_array();


	}

    function get_like($id_linea,  $like ){

        $query_get ="SELECT  * FROM  punto_encuentro WHERE id_linea_metro = $id_linea AND nombre like '%{$like}%' ";
        $response =   $this->db->query($query_get)->result_array();

        if ( es_data($response) ){

            $query_get ="SELECT  * FROM  punto_encuentro WHERE  nombre like '%{$like}%' ";
            $response =   $this->db->query($query_get)->result_array();

        }

        return $response;

    }
    function in($ids){

        $query_get = "SELECT * FROM punto_encuentro 
                      WHERE 
                      id  IN(".$ids.")";

        return $this->db->query($query_get)->result_array();
    }

}