<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Enid extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->model("img_model");
        $this->load->library(lib_def());
    }
    function imagen($id_imagen){

        foreach ($this->get_img($id_imagen) as $row ){

            $img_src =  $row["img"];
            if(strlen($img_src) < 200){
                return $this->get_img_contents($row);
            }else{
                return $this->get_img_contents($img_src , 2 );
            }
        }
    }
    function get_img_contents($data , $p = 1 ){

        if($p ==  1){
            $path       = "http://".$_SERVER['HTTP_HOST']."/inicio/img_tema/productos/".$data["nombre_imagen"];
            $im         = imagecreatefromstring(file_get_contents($path) );
            header('Content-Disposition: Attachment;filename=image-1.png');
            header('Content-Type: image/png');
            if ($im !== false) {
                $img =  imagepng($im);
                imagedestroy($im);
                return $img;
            }
        }else{

            $im         = imagecreatefromstring($data );
            header('Content-Disposition: Attachment;filename=image-1.png');
            header('Content-Type: image/png');
            if ($im !== false) {
                $img =  imagepng($im);
                imagedestroy($im);
                return $img;
            }
        }
    }
    function imagen_usuario($id_usuario){
        $img_usuario =  $this->get_img_usuario($id_usuario);
        return  $this->construye_img_format($img_usuario );
    }
    function construye_img_format($response){

        if ( count($response) > 0 ) {
            $id_imagen  =   $response[0]["id_imagen"];
            $data       =   $this->costruye_imagen($id_imagen);
            $img_src    =   $data["img"];
            if(strlen($img_src) < 300){

                return $this->get_img_contents($data , 1);

            }else{
                return $this->get_img_contents($img_src , 2);
            }
        }
    }
    function costruye_imagen($id_imagen){

        foreach ($this->get_img($id_imagen) as $row ){
            return $row;
        }
    }
    function imagen_servicio($id_servicio){
        $imagen         = $this->get_img_servicio($id_servicio);
        if (is_array($imagen) &&  count($imagen) > 0){
            return $this->construye_img_format($imagen);
        }
    }
    function get_img($id_imagen){

        return $this->img_model->get_img($id_imagen);
    }
    function get_img_usuario($id_usuario){

        $q["id_usuario"]   =  $id_usuario;
        $api               =  "imagen_usuario/usuario/format/json/";
        return $this->principal->api( $api , $q);
    }
    function get_img_servicio($id_servicio){

        $q["id_servicio"]   =  $id_servicio;
        $q["limit"]         =  1;
        $api                =  "imagen_servicio/servicio/format/json/";
        return $this->principal->api( $api , $q);
    }
}