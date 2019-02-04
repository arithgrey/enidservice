<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {


        function form_img($q , $q2 , $q3 )
        {


            $form =  form_open_multipart('' ,

                [
                "accept-charset"    =>  "utf-8" ,
                "method"            =>  "POST" ,
                "id"                =>  "form_img_enid" ,
                "class"             =>  "form_img_enid" ,
                "enctype"           =>  "multipart/form-data"

                ]
            );

            $i =  input([
                "type"      =>  "file" ,
                "id"        =>  "imagen_img" ,
                "class"     =>  "imagen_img" ,
                "name"      =>  "imagen",
                "enctype"   =>  "multipart/form-data",
                "size"      =>  "20"
            ]);

            $hidden_1       = ["name" => 'q', "value"   => $q , "class"   =>    "q_imagen" ];
            $hidden_2       = ["name" => $q2, "value"   => $q3 , "class"   =>   "q2_imagen" ];
            $hidden_3       = ["class"=>'dinamic_img', "id"=>'dinamic_img' ,"name"=>'dinamic_img'];

            $i_hidden       = form_hidden([$hidden_1 , $hidden_2 , $hidden_3]);


            $p  =    place("separate-enid");
            $p .=    place("place_load_img" , ["id"   =>  'place_load_img'] );
            $p .=    place("separate-enid");

            $g  =   guardar("AGREGAR IMAGEN" . icon("fa fa-check") ,
                [
                    "class" =>  'guardar_img_enid ' ,
                    "id"    =>  'guardar_img'
                ],
                1,
                1
            );

            $cierre     = form_close(place("previsualizacion" ,  ["id"    => "previsualizacion"]));
            $response   = append_data($form ,$i,$i_hidden,$p,$g,$cierre);
            return $response;


        }

    }

