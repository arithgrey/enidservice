<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


	if (!function_exists('crea_resumen_servicios_solicitados')) {
		function crea_resumen_servicios_solicitados($data)
		{


			$response = [];
			$ids_servicio = [];
			$complete = [];

			foreach ($data as $row) {

				$id_servicio = $row["id_servicio"];
				if (!in_array($row["id_servicio"], $ids_servicio)) {
					$ids_servicio[] = $row["id_servicio"];
					$response[] = [
						"id_servicio" => $row["id_servicio"],
						"pedidos" => $row["num_ciclos_contratados"]
					];

				} else {

					for ($a = 0; $a < count($response); $a++) {
						if ($response[$a]["id_servicio"] == $id_servicio) {
							$response[$a]["pedidos"] = $response[$a]["pedidos"] + $row["num_ciclos_contratados"];
						}
					}

				}
			}
			return $response;
		}
	}


}