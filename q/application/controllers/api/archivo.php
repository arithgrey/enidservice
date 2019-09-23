<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Archivo extends REST_Controller
{
    private $id_usuario;

    function __construct()
    {
        parent::__construct();
        $this->load->model("img_model");
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function extension($str)
    {
        $str = implode("", explode("\\", $str));
        $str = explode(".", $str);
        $str = strtolower(end($str));
        return $str;
    }

    function imgs_POST()
    {

        $config =  [
            'upload_path' => APPPATH . '../../img_tema/productos/',
            'allowed_types' => "*",
            'max_size' => 3500,
            'max_width' => 4024,
            'max_height' => 7680
        ];

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('imagen')) {

            $error['error'] = $this->upload->display_errors();
            $this->response($error);

        } else {

            $nombre_imagen = $this->upload->file_name;
            $upload_data = $this->upload->data();
            $image_width = $upload_data["image_width"];
            $image_height = $upload_data["image_height"];
            $source_image = $this->upload->upload_path . $nombre_imagen;

            $config = [
                'maintain_ratio' => TRUE,
                'width' => (int)porcentaje($image_width, 70, 0, 0),
                'height' => (int)porcentaje($image_height, 70, 0, 0),
                'image_library' => 'gd2',
                'source_image' => $source_image,
            ];


            $this->image_lib->initialize($config);
            $param = $this->post();

            $param += [
                "nombre_archivo" => $nombre_imagen,
                "extension" => $upload_data["file_ext"],
                "imagenBinaria" => $source_image,
            ];

            $response = $this->gestiona_imagenes($param);

            if (!$this->image_lib->resize()) {
                $response["error"] = $this->image_lib->display_errors('', '');
            }

            $this->response($response);
        }
    }

    function gestiona_imagenes($param)
    {

        $param +=  [
            "id_empresa" => $this->app->get_session("idempresa"),
            "id_usuario" => $this->id_usuario,
        ];

        $response = "";
        switch ($param["q"]) {
            case 'faq':

                $response = $this->create_imagen_faq($param);
                break;


            case 'perfil_usuario':

                $response = $this->create_perfil_usuario($param);
                break;

            case 'servicio':
                $response = $this->create_imagen_servicio($param);
                break;


            default:

                break;
        }
        return $response;
    }

    function response_status_img($status)
    {

        return  ($status == 1) ? "Error al cargar la image" : "Imagen guardada .!";

    }

    function notifica_producto_imagen($q)
    {

        return $this->app->api("servicio/status_imagen/format/json/", $q, "json", "PUT");
    }

    function insert_imagen_servicio($q)
    {

        return $this->app->api("imagen_servicio/index", $q, "json", "POST");
    }

    function create_imagen_faq($param)
    {

        $param["id_imagen"] = $this->img_model->insert_img($param, 1);

        if ($param["id_imagen"] > 0) {

            $this->app->api("imagen_faq/index", $param, "json", "POST");
            return $param["id_faq"];
        }
    }

    function create_imagen_usuario($q)
    {

        return $this->app->api("imagen_usuario/index", $q, "json", "POST");
    }

    private function create_perfil_usuario($param)
    {

        $id_imagen = $this->img_model->insert_img($param, 1);
        if ($id_imagen > 0 && $this->id_usuario > 0) {
            $prm["id_imagen"] = $id_imagen;
            $prm["id_usuario"] = $this->id_usuario;
            return $this->create_imagen_usuario($prm);
        }
    }

    private function create_imagen_servicio($param)
    {

        $response = [];
        if ($param["id_usuario"] > 0) {
            $existen = "nombre_archivo,id_usuario,id_empresa,imagenBinaria,extension,servicio";
            if (fx($param, $existen)) {
                $id_imagen = $this->img_model->insert_img($param, 1);
                if ($id_imagen > 0) {

                    $prm = [
                        "id_imagen" => $id_imagen,
                        "id_servicio" => $param["servicio"],
                    ];

                    $response["status_imagen_servicio"] = $this->insert_imagen_servicio($prm);
                    if ($response["status_imagen_servicio"] == true) {


                        $prm["existencia"] = 1;
                        $response["status_notificacion"] = $this->notifica_producto_imagen($prm);

                    }
                    $response["status_notificacion"] = 2;
                }
                return $response;
            }
            $response["params_error"] = 1;
            return $response;
        }
        $response["session_exp"] = 1;
        return $response;
    }

}