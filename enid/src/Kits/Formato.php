<?php

namespace Enid\Kits;

use Enid\ServicioImagen\Format as FormatImgServicio;

class Formato

{
    private $servicio_imagen;
    function __construct()
    {

        $this->servicio_imagen = new FormatImgServicio();
    }

    function listado($kits_servicios)
    {
        $kits_servicios = $this->servicio_imagen->url_imagen_servicios($kits_servicios);
        $ids_kits = array_unique(array_column($kits_servicios, "id"));
        $response = [];

        foreach ($ids_kits as  $row) {

            $response[] = $this->servicios_en_kit($row, $kits_servicios);
        }
        return d($response, "row");
    }
    function servicios_en_kit($id_kit, $kits_servicios)
    {

        $response = [];

        $nombre = "";
        foreach ($kits_servicios as $row) {

            $id_kit_servicio = $row["id"];

            if ($id_kit === $id_kit_servicio) {

                if (!is_null($row["id_servicio"])) {
                    $response[] = d(img($row["url_img_servicio"]), 'col-xs-2');
                }
                $nombre = $row["nombre"];
            }
        }

        $items = d($response, "row borde_black p-2");
        $nombre = span($nombre, 'strong f12 text-uppercase');
        return flex($nombre, $items, _text_(_between, 'mt-5'), 2, 10);
    }
}
