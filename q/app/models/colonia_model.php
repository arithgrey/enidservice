<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Colonia_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->table = 'colonia';
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
		return $this->db->get($this->table)->result_array();
	}

	function q_up($q, $q2, $id_empresa)
	{
		return $this->update([$q => $q2], ["id" => $id_empresa]);
	}

	function q_get($params = [], $id)
	{
		return $this->get($params, ["id" => $id]);
	}

	function insert($params, $return_id = 0)
	{
		$insert = $this->db->insert($this->table, $params);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}
    function update($data = [], $params_where = [], $limit = 1)
    {
        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->table, $data);
    }
    public function delegacion($delegacion)
	{	
		/*Se hizo de esta forma ya que la base de datos está mal CDMX Y ESTADO DE MÉXICO*/
		$query = "SELECT cp,  asentamiento as colonia , estado, municipio, id_codigo_postal
		 FROM codigo_postal WHERE municipio = '".$delegacion."' AND 
		id_estado_republica IN(9, 15) order by asentamiento ASC";

	    return $this->db->query($query)->result_array();

	}
	


}