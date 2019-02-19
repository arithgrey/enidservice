<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pagina_web_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function accesos_enid_service()
	{

		$query_get = "SELECT
                        COUNT(0)num_accesos 
                    FROM 
                        pagina_web 
                    WHERE  
                    date(fecha_registro) =  date(current_date())";

		return $this->db->query($query_get)->result_array()[0]["num_accesos"];
	}

	function get_num_field($f_inicio, $f_termino, $field)
	{

		$query_get =
			"SELECT  count($field)num , $field FROM pagina_web 
        WHERE DATE(fecha_registro) 
        BETWEEN '" . $f_inicio . "' AND '" . $f_termino . "'
        GROUP BY $field ORDER BY 
        count($field)  DESC";

		return $this->db->query($query_get)->result_array();
	}

	function insert($params, $return_id = 0, $debug = 0, $table = 'pagina_web')
	{
		$insert = $this->db->insert($table, $params, $debug);
		return ($return_id == 1) ? $this->db->insert_id() : $insert;
	}

}