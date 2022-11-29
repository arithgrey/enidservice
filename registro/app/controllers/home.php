<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());
    }

    function index()
    {

        $param = $this->input->get();
        $client = new Google_Client();
        $client->setClientId($this->config->item('googleClientId'));
        $client->setClientSecret($this->config->item('googleClientSecret'));
        $client->setRedirectUri($this->config->item('googleRedirectUriRegister'));
        $client->addScope("email");
        $client->addScope("profile");
    
        
        if (strlen(prm_def($param, 'code')) > 3 ) {
            
            $token = $client->fetchAccessTokenWithAuthCode($param['code']);

            $client->setAccessToken($token['access_token']);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email =  $google_account_info->email;            
            $name =  $google_account_info->name;      
            $picture =  $google_account_info->picture;      
            
            if($google_account_info->verifiedEmail){       

                $this->registro_cliente_google($name, $email); 
                $this->google_session($email, $picture);                               
            }
                  
        } 
        
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

            $session = $this->enid_session($picture,$id_usuario, $nombre, $email, $id_empresa);
            $response["session"] = $session;
            $response["session_creada"] = $this->app->get_session();        
            redirect(path_enid("url_home"));
            
        }else{

            redirect(path_enid("login_sin_registro"));
        }

    }
    private function enid_session($picture ,$id_usuario, $nombre, $email, $id_empresa)
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
    private function registro_cliente_google($nombre, $email){
        
        return $this->app->api("usuario/vendedor", 
        [
            "email" => $email,
            "nombre" => $nombre,
            "password" => sha1($email),
            "perfil" => 20
        ], 
        "json", "POST");

    }
       
}
