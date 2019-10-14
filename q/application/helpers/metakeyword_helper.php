<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
if (!function_exists('invierte_date_time')) {

    function create_arr_tags($data)
    {
        $tags = [];
        foreach ($data as $row) {

            $metakeyword = $row["metakeyword"];
            if (strlen($metakeyword) > 0) {
                $tags = json_decode($metakeyword, true);
                break;
            }
        }

        return $tags;
    }

    function get_catalogo_metakeyword($catalogo)
    {

        $response[] = d("ÚLTIMAS EMPLEADAS ", "item-content-block");
        foreach ($catalogo as $row) {

            array_push(
                    $response,
                    a_enid(
                            $row,
                            [
                                    'class' => 'white tag_catalogo',
                                    'id' => $row,
                            ]
                    )
            );
        }

        return append($response);

    }

}
