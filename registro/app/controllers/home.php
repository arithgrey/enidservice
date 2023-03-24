<?php


if (!defined('BASEPATH')) exit('No direct script access allowed');
use Enid\SessionEnid\Format as SessionEnidFormat;
class Home extends CI_Controller
{   
    function __construct()
    {
        parent::__construct();        
        $this->load->library(lib_def());
        $this->session_enid_format = new SessionEnidFormat($this->app);
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
    
        $state = prm_def($param,"state");
        if (strlen(prm_def($param, 'code')) > 3 && $state > 0) {
            
            $token = $client->fetchAccessTokenWithAuthCode($param['code']);

            $client->setAccessToken($token['access_token']);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            $email =  $google_account_info->email;            
            $name =  $google_account_info->name;      
            $picture =  $google_account_info->picture;      
            
            
            if($google_account_info->verifiedEmail){       

                $this->registro_con_google($name, $email,$state); 
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

            $session = $this->session_enid_format->enid_session(
                $picture,$id_usuario, $nombre, $email, $id_empresa);

            $response["session"] = $session;            
            redirect(path_enid("url_home"));
            
        }else{

            redirect(path_enid("login_sin_registro"));
        }

    }
    
    private function registro_con_google($nombre, $email, $state){
        
        return $this->app->api("usuario/vendedor", 
        [
            "email" => $email,
            "nombre" => $nombre,
            "password" => sha1($email),
            "perfil" => $state
        ], 
        "json", "POST");

    }
       
}
