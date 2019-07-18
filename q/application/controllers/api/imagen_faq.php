<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Imagen_faq extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("imagen_faq_model");
        $this->load->library(lib_def());
    }
    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_imagen,id_faq")) {
            $params = [
                "id_imagen" => $param["id_imagen"],
                "id_faq" => $param["id_faq"]
            ];
            $response = $this->imagen_faq_model->insert($params);
        }
        $this->response($response);
    }
    function img_GET()
    {

        $param = $this->get();
        $response = [];
        if (fx($param, "id_faq")) {

            $response   = $this->imagen_faq_model->get_img($param["id_faq"]);

        }
        $this->response($response);
    }



}