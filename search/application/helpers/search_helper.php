<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {
	function crea_sub_menu_categorias_destacadas($param)
	{

		$z = 0;

        $response =  [];
		foreach ($param as $row) {

			$nombre_clasificacion = $row["nombre_clasificacion"];

			if ($z == 0) {
                $response [] =  "<ul class='clasificaciones_sub_menu_ul'>";
			}
			$href = "?q=&q2=" . $row["primer_nivel"];
            $response [] =   li(anchor_enid($nombre_clasificacion, ["href" => $href, "class" => 'text_categoria_sub_menu']));
			$z++;
			if ($z == 5) {
				$z = 0;
                $response [] =  "</ul>";
			}
		}
		return append_data($response);
	}

	function crea_menu_principal_web($param)
	{


		$z = 0;
		$data_complete = [];

		foreach ($param["clasificaciones"] as $row) {

			$primer_nivel = $row["primer_nivel"];
			$total = $row["total"];
			$nombre_clasificacion = "";
			foreach ($param["nombres_primer_nivel"] as $row2) {

				$id_clasificacion = $row2["id_clasificacion"];
				if ($primer_nivel == $id_clasificacion) {
					$nombre_clasificacion = $row2["nombre_clasificacion"];
					break;
				}


			}
			$data_complete[$z]["primer_nivel"] = $primer_nivel;
			$data_complete[$z]["total"] = $total;
			$data_complete[$z]["nombre_clasificacion"] = $nombre_clasificacion;

			if ($z == 4) {
				break;
			}
			$z++;

		}
		return $data_complete;
	}

	function crea_seccion_de_busqueda_extra($info, $busqueda)
	{

		if (is_array($info)) {

			$seccion = "";
			$flag = 0;

			$lista = [];
			for ($z = 0; $z < count($info); $z++) {
				$data = $info[$z];
				foreach ($data as $row) {

					$id_clasificacion = $row["id_clasificacion"];
					$nombre_clasificacion = $row["nombre_clasificacion"];

					$url = "../search/?q=" . $busqueda . "&q2=" . $id_clasificacion;
					$lista[] =
						anchor_enid($nombre_clasificacion, ["href" => $url, "class" => 'categoria_text black']);

					$flag++;
				}
			}

			$info_seccion["html"] = ul($lista);
			$info_seccion["num_categorias"] = $flag;
			return $info_seccion;

		}

	}


}