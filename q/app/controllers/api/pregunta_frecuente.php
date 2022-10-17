<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class pregunta_frecuente extends REST_Controller
{
    private $id_usuario;
    private $id_empresa;

    function __construct()
    {
        parent::__construct();
        $this->load->model("pregunta_frecuente_model");
        $this->load->helper("pregunta_frecuente");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("id_usuario");
        $this->id_empresa = $this->app->get_session("id_empresa");
    }


    function index_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "titulo,respuesta,id_respuesta")) {

            $params = [
                "titulo" => $param["titulo"],
                "respuesta" => trim($param["respuesta"]),
                "id_empresa" => $this->id_empresa
            ];

            if ($param["id_respuesta"] > 0) {


                $response = $this->pregunta_frecuente_model->update($params, ["id" => $param["id_respuesta"]]);

            } else {

                $response = $this->pregunta_frecuente_model->insert($params);
            }


        }
        $this->response($response);

    }

    function index_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id")) {

            $in = ["id" => $param['id']];
            $response = $this->pregunta_frecuente_model->get([], $in, 100);
        }
        $this->response($response);


    }

    function tags_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, "id,tags")) {

            $id = $param['id'];
            $pregunta = $this->pregunta_frecuente_model->q_get(["tags"], $id);
            if (es_data($pregunta)) {

                $array = [];
                $tag = $pregunta[0]["tags"];


                if (strlen($tag) > 0 && !is_null($tag)) {
                    $array = explode(",", $tag);
                }

                $tag_ingreso = $param["tags"];
                if (strlen(trim($tag_ingreso)) > 0) {

                    $array[] = $tag_ingreso;
                }

                $tags = strip_tags(implode(",", $array));
                $response = $this->pregunta_frecuente_model->q_up("tags", $tags, $id);


            }
        }
        $this->response($response);


    }

    function tags_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id,tag")) {

            $id = $param['id'];
            $pregunta = $this->pregunta_frecuente_model->q_get(["tags"], $id);
            if (es_data($pregunta)) {
                $nuevos_tags = [];
                $array = [];
                $tag = $pregunta[0]["tags"];


                if (strlen($tag) > 0 && !is_null($tag)) {
                    $array = explode(",", $tag);
                }

                $tag = $param["tag"];

                foreach ($array as $row) {

                    if ($row !== $tag){
                        $nuevos_tags[] = $row;
                    }
                }


                $tags =  strip_tags(implode(",", $nuevos_tags));
                $response = $this->pregunta_frecuente_model->q_up("tags", $tags, $id);

            }
        }
        $this->response($response);


    }


    function index_DELETE()
    {

        $param = $this->delete();
        $response = false;
        if (fx($param, "id")) {

            $in = ["id" => $param['id']];
            $response = $this->pregunta_frecuente_model->delete($in);
        }
        $this->response($response);


    }

    function q_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "q")) {

            $response = $this->pregunta_frecuente_model->q($param['q']);
            $session = $this->app->session();
            $response = formato_respuestas($response, $session);

        }

        $this->response($response);

    }

}