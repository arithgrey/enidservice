<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

   if (!function_exists('get_form_tags')) {
        function get_form_tags()
        {


            $r[] =  form_open("", ["class"=>"form_tags"]);
            $r[] =  div(textarea(["class" => "tags_text", "name"  => "tags_text"]),1);
            $r[] =  place("notificacion_tags");
            $r[] =  guardar("GENERAR TAGS",["class"=>"top_20"]);
            $r[] =  form_close();
            $r[] =  div(place("texto_convertido", ["id"=> "texto_convertido"]), "top_50");

            $resposne = div(div(append_data($r),6,1),"row top_50");
            return $resposne;


        }
    }
}