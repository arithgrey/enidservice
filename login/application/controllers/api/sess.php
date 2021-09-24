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
        $es_ajax = $this->input->is_ajax_request();
        $es_barer = (array_key_exists("t", $param) && $param["t"] == $this->config->item('barer'));
        if ($es_ajax || $es_barer) {
            $response = [];
            if (fx($param, "email,secret")) {
                $usuario = $this->get_es_usuario($param);
                $response["usuario"] = $usuario;
                $response["login"] = false;
                if (es_data($usuario)) {

                    $usuario = $usuario[0];
                    $id_usuario = $usuario["idusuario"];
                    $nombre = $usuario["nombre"];
                    $email = $usuario["email"];
                    $id_empresa = $usuario["idempresa"];

                    $recien_creado = ($es_barer);
                    $session = $this->crea_session($id_usuario, $nombre, $email, $id_empresa, $recien_creado);
                    $response["session"] = $session;
                    $response["session_creada"] = $this->app->get_session();

                    if ($es_barer) {

                        $this->response($session);
                    }

                    $response["login"] = (is_array($session)) ? path_enid("login") : false;
                }
            }
        }
        $this->response($response);

    }


    private function get_es_usuario($q)
    {

        return $this->app->api("usuario/es", $q, "json", "POST");
    }

    private function crea_session($id_usuario, $nombre, $email, $id_empresa, $recien_creado = 0)
    {

        $empresa = $this->get_empresa($id_empresa);
        $perfiles = $this->get_perfil_user($id_usuario);
        $perfildata = $this->get_perfil_data($id_usuario);
        $empresa_permiso = $this->get_empresa_permiso($id_empresa);
        $empresa_recurso = $this->get_empresa_recursos($id_empresa);
        $status_enid = $this->estatus_enid_service();
        $response = 0;

        if (es_data($perfiles)) {

            $navegacion = $this->get_recursos_perfiles($perfiles);
            $usuario[] = ["idusuario" => $id_usuario];
            $path_img_usuario = $this->app->add_imgs_usuario($usuario);

            if (es_data($navegacion)) {

                $response = [
                    "idusuario" => $id_usuario,
                    "nombre" => $nombre,
                    "email" => $email,
                    "perfiles" => $perfiles,
                    "perfildata" => $perfildata,
                    "idempresa" => pr($empresa, "idempresa"),
                    "empresa_permiso" => $empresa_permiso,
                    "empresa_recurso" => $empresa_recurso,
                    "data_navegacion" => $navegacion,
                    "info_empresa" => $empresa,
                    "data_status_enid" => $status_enid,
                    "logged_in" => 1,
                    "recien_creado" => $recien_creado,
                    "path_img_usuario" => pr($path_img_usuario, "url_img_usuario"),
                    "tipo_comisionista" => $this->app->tipo_comisionistas()
                ];

                $this->app->set_userdata($response);
            }

        }
        return $response;
    }

    private function estatus_enid_service($q = [])
    {

        return $this->app->api("status_enid_service/textos/format/json/", $q);
    }

    private function get_empresa($id_empresa)
    {
        $q["id_empresa"] = $id_empresa;
        $api = "empresa/id/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_perfil_user($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "usuario_perfil/usuario/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_perfil_data($id_usuario)
    {

        $q["id_usuario"] = $id_usuario;
        $api = "perfiles/data_usuario/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_empresa_permiso($id_empresa)
    {

        $q["id_empresa"] = $id_empresa;
        $api = "empresa_permiso/empresa/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_empresa_recursos($id_empresa)
    {
        $q["id_empresa"] = $id_empresa;
        $api = "empresa_recurso/recursos/format/json/";
        return $this->app->api($api, $q);
    }

    private function get_recursos_perfiles($q)
    {

        $q["id_perfil"] = $q[0]["idperfil"];
        $api = "recurso/navegacion/format/json/";
        return $this->app->api($api, $q);
    }

    function servicio_POST()
    {

        $param = $this->post();
        $this->app->set_userdata($param);
        $this->response(1);
    }
}