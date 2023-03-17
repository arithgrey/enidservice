<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("log");
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();

        $this->validate_user_sesssion();
        $data = $this->app->session();
        $data = $this->app->cssJs($data, "login");
        $data["auth_url"] = $this->verifica_google_session($param);
        $data["link_registro_google"] = $this->link_registro_google($param);
        
        $this->app->pagina($data, page_sigin(prm_def($param, "action"), $data,$param), 1);
    }
    private function link_registro_google($param)
    {

        $cliente_registro = new Google_Client();
        $cliente_registro->setClientId($this->config->item('googleClientId'));
        $cliente_registro->setClientSecret($this->config->item('googleClientSecret'));
        $cliente_registro->setRedirectUri($this->config->item('googleRedirectUriRegister'));
        $cliente_registro->addScope("email");
        $cliente_registro->addScope("profile");
        

        $q = prm_def($param, "q");        
        switch ($q) {            
            case 23874:		
                /*Afiliado*/
                $cliente_registro->setState('6');
                break;
                
            case 18369:
                /*Repartidor*/
                $cliente_registro->setState('21');
                break;
        
            default:
                $cliente_registro->setState('20');
            break;
        }
        
        return $cliente_registro->createAuthUrl();
    }
    private function verifica_google_session($param)
    {

        $client = new Google_Client();
        $client->setClientId($this->config->item('googleClientId'));
        $client->setClientSecret($this->config->item('googleClientSecret'));
        $client->setRedirectUri($this->config->item('googleRedirectUri'));
        $client->addScope("email");
        $client->addScope("profile");

        $authUrl = '';

        if (isset($_GET["code"])) {
            $token = $client->fetchAccessTokenWithAuthCode($param['code']);
            $client->setAccessToken($token['access_token']);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email =  $google_account_info->email;
            $picture =  $google_account_info->picture;
            
            $this->google_session($email, $picture);

            
        } else {
            $authUrl =  $client->createAuthUrl();
        }
        return $authUrl;
    }
    private function google_session($email, $picture)
    {

        $response = [];
        $usuario = $this->app->usuario_email($email);
        $response["usuario"] = $usuario;
        $response["login"] = false;
        if (es_data($usuario)) {

            $usuario = $usuario[0];
            $id_usuario = $usuario["id"];
            $nombre = $usuario["name"];
            $email = $usuario["email"];
            $id_empresa = $usuario["id_empresa"];

            $session = $this->enid_session($picture, $id_usuario, $nombre, $email, $id_empresa);
            $response["session"] = $session;
            //$response["session_creada"] = $this->app->get_session();
            redirect(path_enid("url_home"));

        }else{
            redirect(path_enid("login_sin_registro"));
        }
    }
    private function enid_session($picture, $id_usuario, $nombre, $email, $id_empresa)
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


    function validate_user_sesssion()
    {

        if (intval($this->app->is_logged_in()) > 0) {
            redirect(path_enid("url_home"));
        }
    }

    function logout()
    {

        $this->app->out();
    }
}
