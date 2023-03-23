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
}
