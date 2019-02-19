<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

	function get_terminos($conceptos)
	{
		$tb = "";
		foreach ($conceptos as $row) {

			$funcionalidad = $row["funcionalidad"];
			$conceptos = $row["conceptos"];
			//$tb .= get_td($funcionalidad);
			$tb .= "<table style='width:100%;margin-top:30px;' >";

			foreach ($conceptos as $row2) {

				$privacidad = $row2["privacidad"];
				$id_privacidad = $row2["id_privacidad"];
				$id_usuario = $row2["id_usuario"];

				$extra_seleccion = "";
				$termino_asociado = 0;
				if (!is_null($id_usuario)) {
					$extra_seleccion = "checked";
					$termino_asociado = 1;
				}

				$tb .= "<tr>";

				$attr = add_attributes([
					"id" => $id_privacidad,
					"class" => 'concepto_privacidad',
					"termino_asociado" => $termino_asociado,
					"type" => 'checkbox'
				]);
				$tb .= get_td("<input " . $attr . " " . $extra_seleccion . ">");
				$tb .= get_td(strtoupper($privacidad));

				$tb .= "</tr>";

			}
			$tb .= "</table>";
		}

		return $tb;
	}

}

