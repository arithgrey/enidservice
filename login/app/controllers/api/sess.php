<?php defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '../../librerias/REST_Controller.php';

class Sess extends REST_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(lib_def());
    }

    function start_post()
    {

        $param = $this->post();
        $response = false;

        $es_barer = (prm_def($param,"t") === $this->config->item('barer'));

        $response = [];
        if (fx($param, "email,secret")) {
            $usuario = $this->app->api("usuario/es", $param, "json", "POST");
            $response["usuario"] = $usuario;
            $response["login"] = false;
            if (es_data($usuario)) {

                $usuario = $usuario[0];
                $id_usuario = $usuario["id"];
                $nombre = $usuario["name"];
                $email = $usuario["email"];
                $id_empresa = $usuario["id_empresa"];

                $recien_creado = ($es_barer);
                $session = $this->app->crea_session(
                    $id_usuario,
                    $nombre,
                    $email,
                    $id_empresa,
                    $recien_creado
                );

                $response["session"] = $session;
                
                if ($es_barer) {

                    $this->response($session);
                }

                $response["login"] = (es_data($session)) ? path_enid("login") : false;
            }
        }
        $this->response($response);
    }
}
