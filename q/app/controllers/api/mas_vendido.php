<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class mas_vendido extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("mas_vendido_model");
        $this->load->library(lib_def());
    }

    function index_POST()
    {
        $param = $this->post();
        $response = false;

        if (fx($param, "menu,sub_menu,path,titulo,sub_titulo,link_video,id_nicho")) {

            $params = [
                "menu" => $param["menu"],
                "sub_menu" => $param["sub_menu"],
                "path" => $param["path"],
                "titulo" => $param["titulo"],
                "sub_titulo" => $param["sub_titulo"],
                "link_video" => $param["link_video"],
                "id_nicho" => $param["id_nicho"],
            ];


            $response = $this->mas_vendido_model->insert($params, 1);
        }
        $this->response($response);
    }
    function index_PUT()
    {
        $param = $this->put();
        $response = false;

        if (fx($param, "id_mas_vendido,menu,sub_menu,path")) {

            $id = $param["id_mas_vendido"];
            $params = [
                "menu" => $param["menu"],
                "sub_menu" => $param["sub_menu"],
                "path" => $param["path"],
                "titulo" => $param["titulo"],
                "sub_titulo" => $param["sub_titulo"],
                "link_video" => $param["link_video"]
            ];


            $response = $this->mas_vendido_model->update($params,  ["id" => $id]);
        }
        $this->response($response);
    }

    function index_DELETE()
    {
        $param = $this->delete();
        $response = false;

        if (fx($param, "id")) {

            $id = $param["id"];

            $response = $this->mas_vendido_model->delete(["id" => $id]);
        }
        $this->response($response);
    }


    function publicos_GET()
    {
        
        $response = false;
        $param = $this->get();
        if (fx($param, "id_nicho")) {

            $response = $this->mas_vendido_model->get(
                [],
                [
                    "status" => 1,
                    "id_nicho" => $param["id_nicho"]
                ],
                100
            );
        }
        $this->response($response);
    }
    function id_GET()
    {
        $param = $this->get();
        $response = false;


        if (fx($param, "id")) {

            $id = $param["id"];
            $response = $this->response($this->mas_vendido_model->q_get($id));
        }
        $this->response($response);
    }
}
