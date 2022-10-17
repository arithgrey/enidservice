<?php defined('BASEPATH') or exit('No direct script access allowed');

class Codigo_postal_model extends CI_Model
{
	private $table; 
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->table = "codigo_postal";
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

	function get_id_codigo_postal_por_patron($param)
	{


		$cp_base = substr($param["cp"], 1, strlen($param["cp"]));
		$query_get = "SELECT id_codigo_postal 
                          FROM 
                            codigo_postal 
                          WHERE 
                            asentamiento         = '" . $param["asentamiento"] . "'
                          AND 
                            municipio            = '" . $param["municipio"] . "' 
                          AND 
                            id_estado_republica  = '" . $param["estado"] . "'
                          AND
                            id_pais          = '" . $param["pais"] . "' 
                          AND 
                          cp like '" . $cp_base . "%' ";


		$cp = $this->db->query($query_get)->result_array();
		if (count($cp) > 0) {
			return $cp[0]["id_codigo_postal"];
		} else {
			$query_get = "SELECT id_codigo_postal 
                      FROM 
                        codigo_postal 
                      WHERE 
                        asentamiento         = '" . $param["asentamiento"] . "'
                      AND 
                        municipio            = '" . $param["municipio"] . "' 
                      AND 
                        id_estado_republica  = '" . $param["estado"] . "'
                      AND
                        id_pais          = '" . $param["pais"] . "' 
                      AND 
                      cp like '" . $param["cp"] . "%' ";

			$cp = $this->db->query($query_get)->result_array();
			if (count($cp) > 0) {
				return $cp[0]["id_codigo_postal"];
			}
		}
		return 0;
	}

	function get_colonia_delegacion($param)
	{

		/*hay que realizar correccion a la base de datos*/
		$cp = $param["cp"];
		$query_get = "SELECT * FROM codigo_postal WHERE cp like '" . $cp . "%' LIMIT 20";
		$cps = $this->db->query($query_get)->result_array();
		if (count($cps) == 0) {
			$cp = substr($cp, 1, strlen($cp));
			$query_get = "SELECT * FROM codigo_postal WHERE cp like '" . $cp . "%' LIMIT 20";
			$cps = $this->db->query($query_get)->result_array();
		}
		return $cps;
	}
	public function get_costo($q)
	{

		$query_get = _text_("SELECT * FROM codigo_postal WHERE cp like " , $q , " LIMIT 20");		
		return $this->db->query($query_get)->result_array();
	}

    private function update($data = [], $params_where = [], $limit = 1)
    {

        foreach ($params_where as $key => $value) {
            $this->db->where($key, $value);
        }
        $this->db->limit($limit);
        return $this->db->update($this->table, $data);
    }
	function q_up($q, $q2, $id)
    {
        return $this->update([$q => $q2], ["id_codigo_postal" => $id]);
    }
	public function set_costo_delegacion($delegacion, $costo)
	{	
		/*Se hizo de esta forma ya que la base de datos está mal*/
		$query = "UPDATE codigo_postal SET costo_entrega = $costo WHERE municipio = '".$delegacion."' ";
	    return $this->db->query($query);

	}

}
