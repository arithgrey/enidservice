<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('crea_resumen_servicios_solicitados')) {
        function crea_resumen_servicios_solicitados($data)
        {


            $response = [];
            $ids_servicio = [];

            foreach ($data as $row) {

                $id_servicio = $row["id_servicio"];
                if (!in_array($id_servicio, $ids_servicio)) {
                    $ids_servicio[] = $id_servicio;

                    $response[] =
                        [
                            "id_servicio" => $id_servicio,
                            "pedidos" => $row["num_ciclos_contratados"]
                        ];

                } else {


                    $index = search_bi_array($response, "id_servicio", $id_servicio);
                    $a = 0;
                    if ($index !== false) {

                        $response[$a]["pedidos"] = $response[$index]["pedidos"] + $row["num_ciclos_contratados"];

                        $a++;
                    }

                }
            }
            return $response;
        }
    }


}