<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class usuario_perfil extends REST_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("usuario_perfil_model");
        $this->load->library(lib_def());
    }

    function usuario_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {

            $params = [
                "idusuario" => $param["id_usuario"],
                "status" => 1
            ];
            $response = $this->usuario_perfil_model->get(["idperfil"], $params);
        }
        $this->response($response);
    }

    function permisos_usuario_POST()
    {

        $param = $this->post();
        $response = false;
        if (fx($param, "id_usuario,puesto")) {

            $id_usuario = $param["id_usuario"];
            $id_perfil = $param["puesto"];
            $status = $this->usuario_perfil_model->delete(["idusuario" => $id_usuario], 15);
            $response = [];
            if ($status == true) {

                $params = [
                    "idusuario" => $id_usuario,
                    "idperfil" => $id_perfil
                ];
                $response = $this->usuario_perfil_model->insert($params);
            }
        }
        $this->response($response);
    }

    function es_cliente_GET()
    {

        $param = $this->get();
        $response = false;
        if (fx($param, "id_usuario")) {
            $response = $this->usuario_perfil_model->get_es_cliente($param["id_usuario"]);
        }
        $this->response($response);
    }

    function comisionistas_GET()
    {

        $response = $this->usuario_perfil_model->comisionistas();
        $this->response($this->concatena_nombres($response));
    }

    function repartidores_GET()
    {
        $param = $this->get();
        $params =
            [
                "idperfil" => 21,
                "status" => 1
            ];
        $response = $this->usuario_perfil_model->get([], $params, 100);

        if (fx($param, "requiere_auto,moto,bicicleta,pie")) {
            $response = $this->usuarios_entregas($response, $param);
        }

        $this->response($response);
    }

    private function usuarios_entregas($usuarios, $filtros)
    {

        $ids = [];
        foreach ($usuarios as $row) {

            $ids[] = $row['idusuario'];
        }

        $q = [
            'ids' => get_keys($ids),
            'requiere_auto' => $filtros['requiere_auto'],
            'moto' => $filtros['moto'],
            'bicicleta' => $filtros['bicicleta'],
            'pie' => $filtros['pie']
        ];

        $response = $this->app->api("usuario/entrega/format/json/", $q);

        $repartidores =  [];
        foreach ($usuarios as $row){

            $idusuario =  $row['idusuario'];
            foreach ($response as $usr){

                $id_usuario_filtro = (!es_data($usr['idusuario'])) ? $usr['idusuario'] : $usr['idusuario']['id_usuario'];
                if($idusuario == $id_usuario_filtro){
                    $repartidores[] = $row;
                }
            }
        }
        return $repartidores;

    }

    private function concatena_nombres($data)
    {

        $response = [];
        foreach ($data as $row) {

            $nombre = $row['nombre'];
            $apellido_paterno = $row['apellido_paterno'];
            $apellido_materno = $row['apellido_materno'];
            $row['nombre_usuario'] =
                _text_($nombre, $apellido_paterno, $apellido_materno);
            $response[] = $row;

        }
        return $response;

    }

}