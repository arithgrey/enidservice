<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Usuario_conexion extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_conexion_model");
        $this->load->helper("busqueda");
        $this->load->library(lib_def());
        $this->id_usuario = $this->app->get_session("idusuario");
    }

    function index_POST()
    {

        $param = $this->post();
        $response = false;

        $id_seguidor = $this->id_usuario;
        if (fx($param, 'id_usuario,status') && $id_seguidor > 0) {

            $params = [
                "id_seguidor" => $id_seguidor,
                "id_usuario" => $param["id_usuario"],
                "status" => $param["status"],
            ];
            $response = $this->usuario_conexion_model->insert($params, 1);
        }

        $this->response($response);
    }

    function quitar_seguimiento_PUT()
    {

        $param = $this->put();
        $response = false;
        if (fx($param, 'id')) {

            $id = $param['id'];
            $response = $this->usuario_conexion_model->q_up("status", 0, $id);
        }

        $this->response($response);
    }

    function sugerencias_GET()
    {

        $response = false;
        $param = $this->get();
        if (fx($param, 'id_usuario')) {

            $id_seguidor = $param["id_usuario"];
            $response = $this->usuario_conexion_model->sugerencias($id_seguidor);
            $response = $this->app->add_imgs_usuario($response);
            $response = conexiones($response, $id_seguidor);
        }

        $this->response($response);
    }

    function totales_seguidores_GET()
    {

        $response = false;
        $param = $this->get();
        $id_seguidor = $this->id_usuario;
        if (fx($param, 'id_usuario')) {

            $id_usuario = $param["id_usuario"];
            $total = $this->usuario_conexion_model->total_seguidores($id_usuario);
            $total_seguidores = es_data($total) ? pr($total, "total") : 0;

            $total = $this->usuario_conexion_model->total_siguiendo($id_usuario);
            $total_siguiendo = es_data($total) ? pr($total, "total") : 0;

            $response = [
                "total_seguidores" => $total_seguidores,
                "total_siguiendo" => $total_siguiendo,
                "id_usuario" => $id_usuario,
                "id_seguidor" => $id_seguidor
            ];
            $response = seccion_totales_seguimiento($response);
        }

        $this->response($response);
    }

    function total_seguidores_GET()
    {

        $response = false;
        $param = $this->get();
        if (fx($param, 'id_usuario')) {

            $id_usuario = $param["id_usuario"];
            $total = $this->usuario_conexion_model->total_seguidores($id_usuario);
            $response = es_data($total) ? pr($total, "total") : 0;
        }

        $this->response($response);
    }

    function total_siguiendo_GET()
    {

        $response = false;
        $param = $this->get();
        if (fx($param, 'id_usuario')) {

            $id_usuario = $param["id_usuario"];
            $total = $this->usuario_conexion_model->total_siguiendo($id_usuario);
            $response = es_data($total) ? pr($total, "total") : 0;
        }

        $this->response($response);
    }


    function seguidores_GET()
    {

        $response = false;
        $param = $this->get();
        if (fx($param, 'id_usuario')) {

            $id_usuario = $param["id_usuario"];
            $response = $this->usuario_conexion_model->seguidores($id_usuario);
            $response = $this->imagenes_sugerencias($response, "id_seguidor");
        }

        $this->response($response);
    }

    function seguimiento_GET()
    {

        $response = false;
        $param = $this->get();
        if (fx($param, 'id_usuario')) {

            $id_usuario = $param["id_usuario"];
            $response = $this->usuario_conexion_model->seguimiento($id_usuario);
            $response = $this->imagenes_sugerencias($response, "id_usuario");

        }

        $this->response($response);
    }

    function noticias_seguimiento_GET()
    {

        $response = false;
        $id_seguidor = $this->id_usuario;
        if ($id_seguidor > 0) {

            $response = $this->usuario_conexion_model->noticias_seguimiento($id_seguidor);
            $ventas_like = $this->ids_ventas_like($response);
            $response = $this->app->add_imgs_usuario($response, "id_usuario_referencia");
            $response = $this->app->add_imgs_servicio($response);
            $obj_session = $this->app->get_session();
            $response = render_actividad($response, $ventas_like, $id_seguidor, $obj_session);
        }

        $this->response($response);
    }

    private function ids_ventas_like($recibos)
    {

        $ids = array_column($recibos, "id_proyecto_persona_forma_pago");
        return $this->usuario_conexion_model->conteo_recibo(get_keys($ids));


    }


    function ranking_GET()
    {

        $response = false;
        $param = $this->get();
        if (fx($param, 'id_seguidor,nombre')) {

            $id_seguidor = $param["id_seguidor"];
            $response = $this->usuario_conexion_model->ranking($id_seguidor);
            $ventas_usuario = $this->usuario_conexion_model->total_seguidor($id_seguidor);

            if (es_data($ventas_usuario) && pr($ventas_usuario, "ventas") > 0) {

                $data_usuario = [
                    "ventas" => pr($ventas_usuario, "ventas"),
                    "id_seguidor" => $id_seguidor,
                    "id_usuario" => $id_seguidor,
                    "es_seguidor" => 1,
                    "nombre" => pr($ventas_usuario, "nombre"),
                    "apellido_paterno" => pr($ventas_usuario, "apellido_paterno"),
                    "apellido_materno" => pr($ventas_usuario, "apellido_materno"),
                ];
                array_push($response, $data_usuario);
            } else {

                $data_usuario = [
                    "ventas" => 0,
                    "id_seguidor" => $id_seguidor,
                    "id_usuario" => $id_seguidor,
                    "es_seguidor" => 1,
                    "nombre" => $param["nombre"],
                    "apellido_paterno" => "",
                    "apellido_materno" => "",

                ];
                array_push($response, $data_usuario);
            }


            $response = $this->imagenes_sugerencias($response, "id_usuario");

        }

        $this->response($response);
    }

    private function imagenes_sugerencias($usuarios, $tipo_usuario, $key = 'path_imagen')
    {

        $response = [];
        $a = 0;
        foreach ($usuarios as $row) {

            $id = $row[$tipo_usuario];
            $response[$a] = $row;
            $response[$a][$key] = path_enid("imagen_usuario", $id);
            $a++;
        }

        return $response;

    }


}