<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function create_arr_tags($data)
	{
		$tags = [];
		foreach ($data as $row) {

			$metakeyword = $row["metakeyword"];
			if (strlen($metakeyword) > 0) {
				$tags = json_decode($metakeyword, true);
			}
		}
		return $tags;
	}

	function get_catalogo_metakeyword($catalogo)
	{

		$response = [div("ÚLTIMAS EMPLEADAS ", ["class" => "item-content-block"])];
		foreach ($catalogo as $row) {

			array_push($response, anchor_enid($row, ['class' => 'tag_catalogo', 'id' => $row, "style" => "color:white!important;"]));
		}
		return append_data($response);

	}

}
