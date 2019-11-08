<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {


    if (!function_exists('crea_resumen_servicios_solicitados')) {
        function crea_resumen_servicios_solicitados($data)
        {


            $response = [];
            $ids_servicio = [];

            foreach ($data as $row) {
                $a = 0;
                $id_servicio = $row["id_servicio"];
                $ciclos_contratados = $row["num_ciclos_contratados"];
                if (!in_array($id_servicio, $ids_servicio)) {
                    $ids_servicio[] = $id_servicio;

                    $response[] =
                        [
                            "id_servicio" => $id_servicio,
                            "pedidos" => $ciclos_contratados
                        ];

                } else {


                    $index = search_bi_array($response, "id_servicio", $id_servicio);

                    if ($index !== false) {

                        $response[$a]["pedidos"] =
                            $response[$index]["pedidos"] + $ciclos_contratados;

                        $a++;
                    }

                }
            }
            return $response;
        }
    }


}