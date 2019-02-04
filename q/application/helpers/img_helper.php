<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    if (!function_exists('invierte_date_time')) {


        function form_img_usuario($nombre_archivo='perfil_usuario'){
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
                "type"  => "file" ,
                "id"    => "imagen_img",
                "class" => "imagen_img",
                "name"  => "imagen"
                ]);

            $i2 = input_hidden(["name"=>'q', "value" => $nombre_archivo]);
            $i3 = input_hidden(["class" =>  'dinamic_img' , "id"    =>  'dinamic_img' , "name"  =>  'dinamic_img']);

            $g  =   guardar("AGREGAR IMAGEN" . icon("fa fa-check") ,
                [
                    "class" =>  'guardar_img_enid display_none ' ,
                    "id"    =>  'guardar_img'
                ],
                1,
                1
            );

            $p          =   place("place_load_img" ,  ["id"    => "place_load_img"]);
            $cierre     =   form_close();
            $apped      =   [$form ,$i,$i2,$i3,$p,$g ,$cierre];
            $response   =   append_data($apped);
            return $response;

        }

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

            $hidden_1       = input_hidden(["name" => 'q', "value"   => $q , "class"   =>    "q_imagen" ]);
            $hidden_2       = input_hidden(["name" => $q2, "value"   => $q3 , "class"   =>   "q2_imagen" ]);
            $hidden_3       = input_hidden(["class"=>'dinamic_img', "id"=>'dinamic_img' ,"name"=>'dinamic_img']);



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

            $cierre     =   form_close(place("previsualizacion" ,  ["id"    => "previsualizacion"]));
            $apped      =   [$form ,$i,$hidden_1,$hidden_2,$hidden_3,$p,$g,$cierre];
            $response   =   append_data($apped);
            return $response;


        }

    }

