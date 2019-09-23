<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

    function create_table_blog($data)
    {

        $r = [];
        $z = 1;

        foreach ($data as $row) {
            $r[] = "<tr>";
            $r[] = td($z);
            $r[] = td(a_enid($row["titulo"]));
            $r[] = "</tr>";
            $z++;
        }

        return append($r);
    }
}

