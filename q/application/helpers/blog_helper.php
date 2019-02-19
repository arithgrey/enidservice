<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function create_table_blog($data)
	{

		$l = "";
		$z = 1;

		foreach ($data as $row) {
			$l .= "<tr>";
			$l .= get_td($z);
			$l .= get_td(anchor_enid($row["titulo"]));
			$l .= "</tr>";
			$z++;
		}


	}
}

