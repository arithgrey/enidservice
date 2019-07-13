<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('invierte_date_time')) {

   if (!function_exists('get_form_tags')) {
        function form_tags()
        {


            $r[] =  form_open("", ["class"=>"form_tags"]);
            $r[] =  d(textarea(["class" => "tags_text", "name"  => "tags_text"]),1);
            $r[] =  place("notificacion_tags");
            $r[] =  btn("GENERAR TAGS",["class"=>"top_20"]);
            $r[] =  form_close();
            $r[] =  d(place("texto_convertido", ["id"=> "texto_convertido"]), "top_50");
            return  d(d(append($r),6,1),"row top_50");

        }
    }
}