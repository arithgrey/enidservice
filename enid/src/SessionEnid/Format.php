<?php

namespace Enid\SessionEnid;

class Format
{

    private $app;
    function __construct($app)
    {
        $this->app = $app;
    }

    function session($email, $secret, $es_recien_creado = 0)
    {

        $param = ["email" => $email, "secret" => $secret];
        $usuario = $this->app->api("usuario/es", $param, "json", "POST");
        $response["usuario"] = $usuario;
        $response["login"] = false;
        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $id_usuario = $usuario["id"];
            $nombre = $usuario["name"];
            $email = $usuario["email"];
            $id_empresa = $usuario["id_empresa"];

            $session = $this->app->crea_session(
                $id_usuario,
                $nombre,
                $email,
                $id_empresa,
                $es_recien_creado
            );

            $response["session"] = $session;

            if ($es_recien_creado) {

                return $session;
            }

            $response["login"] = (es_data($session)) ? path_enid("login") : false;
        }
        return $response;
    }
    function enid_session($picture, $id_usuario, $nombre, $email, $id_empresa)
    {

        $empresa = $this->app->get_empresa($id_empresa);
        $perfiles = $this->app->get_perfil_user($id_usuario);
        $perfildata = $this->app->get_perfil_data($id_usuario);
        $empresa_permiso = $this->app->get_empresa_permiso($id_empresa);
        $empresa_recurso = $this->app->get_empresa_recursos($id_empresa);
        $status_enid = $this->app->estatus_enid_service();
        $response = 0;

        if (es_data($perfiles)) {

            $navegacion = $this->app->get_recursos_perfiles($perfiles);
            $usuario[] = ["id" => $id_usuario];

            if (es_data($navegacion)) {

                $response = [
                    "id_usuario" => $id_usuario,
                    "nombre" => $nombre,
                    "email" => $email,
                    "perfiles" => $perfiles,
                    "perfildata" => $perfildata,
                    "id_empresa" => pr($empresa, "id"),
                    "empresa_permiso" => $empresa_permiso,
                    "empresa_recurso" => $empresa_recurso,
                    "data_navegacion" => $navegacion,
                    "info_empresa" => $empresa,
                    "data_status_enid" => $status_enid,
                    "logged_in" => 1,
                    "recien_creado" => 0,
                    "path_img_usuario" => $picture,
                    "tipo_comisionista" => $this->app->tipo_comisionistas()
                ];

                $this->app->set_userdata($response);
            }
        }
        return $response;
    }

}
