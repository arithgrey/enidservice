<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Enid extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("img_model");

    }

    function imagen($id_imagen)
    {

        $img = $this->get_img($id_imagen);
        if (count($img) > 0) {
            $this->get_img_contents($img[0]);
        }
    }

    function get_img_contents($data)
    {

        $path = "http://" . $_SERVER['HTTP_HOST'] . "/inicio/img_tema/productos/" . $data["nombre_imagen"];
        return $this->output->set_content_type('png')->set_output(file_get_contents($path));

    }

    function imagen_usuario($id_usuario)
    {

        return $this->construye_img_format($this->get_img_usuario($id_usuario));
    }

    function construye_img_format($response)
    {

        if (es_data($response)) {

            return $this->get_img_contents($this->costruye_imagen($response[0]["id_imagen"]));
        }
    }

    function costruye_imagen($id_imagen)
    {

        if ($id_imagen > 0) {

            foreach ($this->get_img($id_imagen) as $row) {
                return $row;
            }
        }

    }

    function imagen_servicio($id_servicio = 0)
    {
        if ($id_servicio > 0) {
            $imagen = $this->img_servicio($id_servicio);
            if (is_array($imagen) && count($imagen) > 0) {
                return $this->construye_img_format($imagen);
            }
        }
    }

    function get_img($id_imagen)
    {

        if ($id_imagen > 0) {

            return $this->img_model->q_get(["nombre_imagen"], $id_imagen);
        }
    }

    function get_img_usuario($id_usuario)
    {

        $this->load->library(lib_def());
        $q["id_usuario"] = $id_usuario;
        return $this->principal->api("imagen_usuario/usuario/format/json/", $q);
    }

    function img_servicio($id_servicio)
    {

        $this->load->library(lib_def());

        $q = [
            "id_servicio" => $id_servicio,
            "limit" => 1
        ];

        return $this->principal->api("imagen_servicio/servicio/format/json/", $q);
    }
}