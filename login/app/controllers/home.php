<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
use Enid\SessionEnid\Format as SessionEnidFormat;
class Home extends CI_Controller
{   
    private $session_enid_format;
    function __construct()
    {
        parent::__construct();
        $this->load->helper("log");
        $this->load->library(lib_def());
        $this->session_enid_format = new SessionEnidFormat($this->app);
        
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

            $session = $this->session_enid_format->enid_session(
                $picture, $id_usuario, $nombre, $email, $id_empresa);
                
            $response["session"] = $session;            
            redirect(path_enid("url_home"));

        }else{
            redirect(path_enid("login_sin_registro"));
        }
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
